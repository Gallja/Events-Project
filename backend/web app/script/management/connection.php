<?php
    error_reporting(0);

    $connection = pg_connect("host=postgres.favo02.dev port=5432 dbname=eventi user=server password=3*2da@ELNj@DFP");

    if ($connection == false) {
        echo "<h1>Errore nella connessione al database...</h1>";
    }
?>