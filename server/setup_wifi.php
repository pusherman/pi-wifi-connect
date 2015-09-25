<?php

$ssid = trim($_GET['ssid']);
$psk = trim($_GET['psk']);

if (!$ssid || !$psk) {
  return;
}

$config = 'wpa.conf';

if (file_exists($config)) {
  unlink($config);
}

$settings = 'network={
  ssid="' . $_GET['ssid'] . '"
  proto=RSN
  key_mgmt=WPA-PSK
  pairwise=CCMP TKIP
  group=CCMP TKIP
  psk="' . $_GET['psk'] . '"
}';

file_put_contents($config, $settings);

print 'super!';
