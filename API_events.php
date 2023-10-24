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

        $result4 = pg_query($connection, "SELECT * FROM eventi.eventi_comici");
        $eventi_comici = pg_fetch_all($result4);

        $result5 = pg_query($connection, "SELECT * FROM eventi.eventi_musicisti");
        $eventi_musicisti = pg_fetch_all($result5);

        $response['eventi'] = $eventi;
        $response['comici'] = $comici;
        $response['musicisti'] = $musicisti;
        $response['eventi_comici'] = $eventi_comici;
        $response['eventi_musicisti'] = $eventi_musicisti;

        // JSON encoding
        echo json_encode($response);
    } 

    // close connection to the DB
    pg_close($connection);
?>