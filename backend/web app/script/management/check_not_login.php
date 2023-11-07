<?php
    session_start();

    if (isset($_SESSION['isLogin'])) {
        header('Location: ../pagine/home_admin/eventi/home_admin.php');
        exit();
    }
?>