<?php
    session_start();

    if (isset($_POST['old_pw']) && isset($_POST['new_pw']) && isset($_POST['conf_new_pw'])) {
        include_once('connection.php');

        $old_pw = $_POST['old_pw'];
        $new_pw = $_POST['new_pw'];
        $conf_new_pw = $_POST['conf_new_pw'];

        if (strcmp($new_pw, $conf_new_pw)) {
            $_SESSION['cambio_pw'] = "La nuova password e la conferma non coincidono, riprova...";
            header('Location: ../pagine/home_admin/cambio_pw.php');
            exit();
        }

        // Controllo e modifica della password vecchia
    } else {
        $_SESSION['cambio_pw'] = "Errore nel cambio della password.";
        header('Location: ../pagine/home_admin/cambio_pw.php');
        exit();
    }
?>