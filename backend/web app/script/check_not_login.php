<?php
    session_start();

    if (isset($_SESSION['isLogin'])) {
        header('Location: ../pagine/home_admin/home_admin.php');
        exit();
    }
?>
