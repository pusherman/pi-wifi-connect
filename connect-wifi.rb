#!/usr/bin/env ruby

require 'socket'
require 'timeout'

# Check to see if a specific port is open
def is_open?(host, port, timeout = 0.5)
  begin
     Timeout.timeout(timeout) do
        begin
          s = TCPSocket.new(host, port)
          s.close
          return true

        rescue Errno::ENETUNREACH
          rescue Errno::ECONNREFUSED
          rescue Errno::EHOSTDOWN
          rescue Errno::EHOSTUNREACH
          return false
        end
     end
  rescue Timeout::Error
     return false
  end
end

# Search each host on a given subnet
# for something listening on 28409
def find_host(subnet, start_host)
  until start_host === 255 do
    host = "#{subnet}.#{start_host}"
    if is_open?(host, "28409")
      return host
    else
      print "."
    end
    start_host += 1
  end

  return nil
end

# Get the users current SSID
current_ssid = `/System/Library/PrivateFrameworks/Apple80211.framework/Versions/Current/Resources/airport -I | awk '/ SSID/ {print substr($0, index($0, $2))}'`.chomp

# If they aren't on a network give up
if current_ssid.nil?
  puts "So sorry but it does not look like you are currently connected to wifi :(";
  puts "Please get a connection and try again."
  exit
end

# So far so good, get the password they want to use
puts "Looks like you are connect to the network #{current_ssid}.  Great!"
print "Enter the password you used to connect: "
STDOUT.flush
password = gets.chomp

puts "Setting up client to use the network '#{current_ssid}' with the password '#{password}'."
puts ""

# Scan their local network to find the speaker light host
puts "Scanning for client."
host = find_host "192.168.1", 1


if host.nil?
  puts "Unable to find client :("
  exit
end

puts "Found it on #{host}"

# @todo send SSID/PASS to nginx
