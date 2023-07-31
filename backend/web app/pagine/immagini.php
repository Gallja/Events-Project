<!DOCTYPE html>
<html>
<head>
    <title>Home Admin</title>
</head>
<body>
    <?php

    include_once('../script/connection.php');

    // convert image byte array to base64 directly from postgres
    $sql = "SELECT encode(immagine, 'base64') as img FROM eventi.eventi";
    $res = pg_prepare($connection, "get_evento", $sql);
    $res = pg_execute($connection, "get_evento", array());

    // render image (as a base64 converted byte array) 
    while($row = pg_fetch_assoc($res)) {
      echo '<img src="data:image/jpg;base64,'.$row["img"].'">';
    }

    ?>
</body>
</html>
