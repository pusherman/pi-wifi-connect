<?php
print_r($_POST);

if ($_POST) {
  $ssid = trim($_POST['ssid']);
  $psk = trim($_POST['psk']);

  if (!$ssid || !$psk) {
die('lasdfasdf');
    return;
  }

  $config = 'wpa.conf';

  if (file_exists($config)) {
    die('lol');
    unlink($config);
  } else {
    die('wtf');
  }

  $settings = 'network={
    ssid="' . $_POST['ssid'] . '"
    proto=RSN
    key_mgmt=WPA-PSK
    pairwise=CCMP TKIP
    group=CCMP TKIP
    psk="' . $_POST['psk'] . '"
  }';

  file_put_contents($config, $settings);

  $saved = true;
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Speaker Light Status">
  <meta name="author" content="Corey Wilson">
  <title>Aura - Update</title>
  <link href="css/style.css" rel="stylesheet">
  <style>
    .subtle {color: #666;}
  </style>
</head>
<body>
  <div class="container">
    <?php if ($saved === true) { ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-success"
             role="alert">
          Network info updated, please reboot your Aura and disconnect the network cable if attached.
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-xs-6">
        <h1>Speakerlight Setup</h1>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="ssid">
              Wifi Network Name
            </label>
            <input type="text"
                   class="form-control"
                   id="ssid"
                   name="ssid"
                   placeholder="My Network SSID">
          </div>

          <div class="form-group">
            <label for="psk">
              Wifi Password
            </label>
            <input type="text"
                   class="form-control"
                   id="psk"
                   name="psk"
                   placeholder="My Wifi Password">
          </div>
          <button type="submit"
                  class="btn btn-primary">
            Save
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

