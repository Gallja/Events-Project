<?php
    session_start();
    session_unset();
    header('Location: ../pagine/home.php');
    exit();
?>
