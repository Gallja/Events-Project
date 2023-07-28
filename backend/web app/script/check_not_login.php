<?php
    session_start();

    if (isset($_SESSION['isLogin'])) {
        header('Location: home_admin.php');
    }
?>