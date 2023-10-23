<?php
    header('Content-Type: application/json');

    // open connection to DB
    include_once('backend\web app\script\management\connection.php');

    // API request - only read events
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // endpoint
        $result = pg_query($connection, "SELECT * FROM eventi.eventi");
        $eventi = pg_fetch_all($result);

        $result2 = pg_query($connection, "SELECT * FROM eventi.comici");
        $comici = pg_fetch_all($result2);

        $result3 = pg_query($connection, "SELECT * FROM eventi.musicisti");
        $musicisti = pg_fetch_all($result3);

        $response['eventi'] = $eventi;
        $response['comici'] = $comici;
        $rensonse['musicisti'] = $musicisti;

        // JSON encoding
        echo json_encode($response);
    } 

    // close connection to the DB
    pg_close($connection);
?>