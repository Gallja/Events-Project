<?php
    session_start();

    if (isset($_POST['mail']) && isset($_POST['old_pw']) && isset($_POST['new_pw']) && isset($_POST['conf_new_pw'])) {
        include_once('../management/connection.php');

        $email = $_POST['mail'];
        $old_pw = $_POST['old_pw'];
        $new_pw = $_POST['new_pw'];
        $conf_new_pw = $_POST['conf_new_pw'];

        if (strcmp($new_pw, $conf_new_pw)) {
            $_SESSION['cambiamento_fallito'] = "La nuova password e la sua conferma non coincidono, riprova...";
            header('Location: ../../pagine/home_admin/pw/cambio_pw.php');
            exit();
        }

        // check old password & update

        $test = "SELECT * FROM eventi.autenticazione($1)";
        $res1 = pg_prepare($connection, "get_all", $test);
        $res1 = pg_execute($connection, "get_all", array($email));
        $row = pg_fetch_assoc($res1);

        // user email not found
        if ($row['email'] === null) {
            $_SESSION['cambiamento_fallito'] = "Hai inserito un indirizzo email non valido, riprova...";
            header('Location: ../../pagine/home_admin/pw/cambio_pw.php');
            exit();
        }

        $query = "SELECT pw FROM eventi.utenti WHERE email = $1";
        $res2 = pg_prepare($connection, "get", $query);
        $res2 = pg_execute($connection, "get", array($email));

        $row2 = pg_fetch_assoc($res2);
        $pw_enc1 = $row2['pw'];

        $pw_bool = password_verify($old_pw, $pw_enc1);

        // wrong password
        if (!$pw_bool) {
            $_SESSION['cambiamento_fallito'] = "La password attuale che hai inserito non è corretta, riprova...";
            header('Location: ../../pagine/home_admin/pw/cambio_pw.php');
            exit();
        }

        // valid password
        $new_pw_cript = password_hash($new_pw, PASSWORD_DEFAULT);

        $query_change = "CALL eventi.aggiorna_pw($1, $2)";
        $res3 = pg_prepare($connection, "update_pw", $query_change);
        $res3 = pg_execute($connection, "update_pw", array($email, $new_pw_cript));

        $row3 = pg_fetch_assoc($res3);

        pg_close($connection);
        
        $_SESSION['cambiamento_avvenuto'] = "Cambiamento della password avvenuto con successo!";
        header('Location: ../../pagine/home_admin/pw/cambio_pw.php');
        exit();

    } else {
        $_SESSION['cambiamento_fallito'] = "Errore nel cambiamento della password.";
        header('Location: ../../pagine/home_admin/pw/cambio_pw.php');
        exit();
    }
?>