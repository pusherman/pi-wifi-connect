#!/usr/bin/env ruby

require 'socket'
require 'timeout'

# Get our current private IP
def my_private_ip
  Socket.ip_address_list.detect{|intf| intf.ipv4_private?}.inspect_sockaddr
end

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
    return host if is_open?(host, "28409")

    print "."
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
puts "Looks like you are connect to the network '#{current_ssid}'.  Great!"
print "Enter the password you used to connect: "
STDOUT.flush
password = gets.chomp

puts "Setting up client to use the network '#{current_ssid}' with the password '#{password}'."
puts ""

# Scan their local network to find the speaker light host
subnet_to_scan = my_private_ip.rpartition(".")[0]
puts "Scanning for client on #{subnet_to_scan}.0"
host = find_host subnet_to_scan, 1

puts "Unable to find client :(" if host.nil?

puts "Found it on #{host}"

# @todo send SSID/PASS to nginx
