<?php
    session_start();

    if (isset($_POST['email']) && isset($_POST['pw'])) {

        $email = $_POST['email'];

        // validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['registrazione_fallita'] = 'Email inserita non valida, inseriscila nuovamente';
            header('Location: ../pagine/registrazione.php');
        }

        $pw = $_POST['pw'];

        // validate password (7+ characters, one letter, one number, one special char)
        if (!preg_match("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{7,}$", $pw)) {
            $_SESSION['registrazione_fallita'] = 'La password inserita deve contenere almeno 7 caratteri, una lettera, un numero ed un carattere speciale';
            header('Location: ../pagine/registrazione.php');
        }

        // password and mail well-formed
        
        include_once('../script/connection.php');

        $pw_enc = password_hash($pw, PASSWORD_DEFAULT);

        $query = "CALL eventi.insert_utente($1, $2)";
        $res = pg_prepare($connection, "esito", $query);
        $res = pg_execute($connection, "esito", array($email, $pw_enc));

        pg_close($connection);
                
        if (!$res) {
            $_SESSION['registrazione_fallita'] = 'Email già registrata nel sistema.';
            header('Location: ../pagine/registrazione.php');
        } else {
            $_SESSION['registrato'] = 'Registrazione avvenuta con successo!';
            header('Location: ../pagine/home.php');   
        }
    }
?>
