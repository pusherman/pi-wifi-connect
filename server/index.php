<?php
  exec("ip route get 8.8.8.8 | grep -Po 'dev \K\w+' | grep -qFf - /proc/net/wireless && echo wireless || echo wired", $connectionType);

  $connection['type'] = $connectionType[0];
  $connection['ip'] = $_SERVER['SERVER_ADDR'];

  if ($_GET['output']) {
    header('Content-Type: application/json');

    echo json_encode($connection);
    die();
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
  <title>Speakerlight - Status</title>
  <link href="css/style.css" rel="stylesheet">
  <style>
    .subtle {color: #666;}
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Aura Status</h1>
        <table class="table">
          <tr>
            <td><h3 class="subtle">IP Address:</h3></td>
            <td><h3><?php echo $connection['ip'] ?></h3></td>
          </tr>
          <tr>
            <td><h3 class="subtle">Connection Status:</h3></td>
            <td><h3>Connected (<?php echo $connection['type'] ?>)</h3></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</body>
</html>

