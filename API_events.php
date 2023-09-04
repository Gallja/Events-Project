<?php
header('Content-Type: application/json');

// open connection to the DB
include_once('backend\web app\script\connection.php');

// API request - only read events
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // endpoint
    $result = pg_query($connection, "SELECT * FROM eventi.eventi");
    $eventi = pg_fetch_all($result);
    echo json_encode($eventi);
} 

// close connection to the DB
pg_close($connection);
?>