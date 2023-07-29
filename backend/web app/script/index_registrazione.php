<?php
    session_start();

    if (isset($_POST['email']) && isset($_POST['pw'])) {
        if (str_contains($_POST['email'], "@")) {
            if (str_contains($_POST['email'], ".com") || str_contains($_POST['email'], ".it")) {
                    if (strlen($_POST['pw']) < 7) {
                        $_SESSION['registrazione_fallita'] = 'La password inserita deve contenere almeno 7 caratteri';
                        header('Location: ../pagine/registrazione.php');
                    } else {
                        $pw_enc = password_hash($_POST['pw'], PASSWORD_DEFAULT);
                        include_once('../script/connection.php');
                        $query = "CALL eventi.insert_utente($1, $2)";
                        $res = pg_prepare($connection, "esito", $query);
                        $res = pg_execute($connection, "esito", array($_POST['email'], $pw_enc));

                        pg_close($connection);
                        
                        if (!$res) {
                            $_SESSION['registrazione_fallita'] = 'Email già registrata nel sistema.';
                            header('Location: ../pagine/registrazione.php');
                        } else {
                            $_SESSION['registrato'] = 'Registrazione avvenuta con successo!';
                            header('Location: ../pagine/home.php');   
                        }
                    }
            } else {
                $_SESSION['registrazione_fallita'] = 'Email inserita non valida, inseriscila nuovamente';
                header('Location: ../pagine/registrazione.php');
            }
        } else {
            $_SESSION['registrazione_fallita'] = 'Email inserita non valida, inseriscila nuovamente';
            header('Location: ../pagine/registrazione.php');
        }
    }
?>