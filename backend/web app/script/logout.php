<?php
    session_start();
    session_destroy();
    header('Location: ../pagine/home.php');
    exit();
?>
