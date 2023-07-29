<?php
    session_start();
    
    if (isset($_POST["email"]) && isset($_POST["pw"])) {
        include_once('../script/connection.php'); 

        $sql = "SELECT * FROM eventi.autenticazione($1)";
        $res = pg_prepare($connection, "get_all_esito_attesa_acc", $sql);

        $res = pg_execute($connection, "get_all_esito_attesa_acc", array($_POST["email"]));

        $row = pg_fetch_assoc($res);
        
        if ($row["email"] === null) {
            $_SESSION['autenticazione_fallita'] = "Credenziali non corrette, riprova ".$pw_enc;
            header('Location: ../pagine/home.php');
        } else {
            $query = "SELECT pw FROM eventi.utenti WHERE email = $1";
            $res2 = pg_prepare($connection, "", $query);
            $res2 = pg_execute($connection, "", array($_POST['email']));

            $row2 = pg_fetch_assoc($res2);
            $pw_enc = $row2['pw'];

            $pw_bool = password_verify($_POST['pw'], $pw_enc);

            pg_close($connection);

            if ($pw_bool) {
                $_SESSION['isLogin'] = true;

                header('Location: ../pagine/home_admin.php');
            } else {
                $_SESSION['autenticazione_fallita'] = "Password inserita non corretta, riprova";
                header('Location: ../pagine/home.php');
            }
        }
    } else {
        $_SESSION['autenticazione_fallita'] = "Login errato, devi compilare tutti i campi";
        header('Location: ../pagine/home.php');
    }
?>