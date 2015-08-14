Raspberry Pi Wifi Connect
=========================

Creating scripts to enable wifi on a raspberry pi without having to SSH

Setting up the Pi
------------------

    apt-get update
    apt-get install libapache2-mod-php5 php5 apache2

    vi /etc/apache2/ports.conf (change ports to 28409)

    mv setup_wifi.php /var/www/
    mv interfaces /etc/network/
    cp wpa.conf /etc/wpa.conf

    ln -s /etc/wpa.conf /var/www/wpa.conf

    chown www-data:www-data /etc/wpa.conf 
