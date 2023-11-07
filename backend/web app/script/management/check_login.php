<?php
    session_start();

    if (!isset($_SESSION['isLogin'])) {
        header('Location: ../../home.php');
        exit();
    }
?>
