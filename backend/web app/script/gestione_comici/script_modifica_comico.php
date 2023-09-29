<?php
    session_start();

    if (isset($_POST['id'])) {
        include_once('../connection.php');
        $id = $_POST['id'];
        if (isset($_POST['nome_comico'])) {
            $nome = $_POST['nome_comico'];
            $query1 = "CALL eventi.aggiorna_comico_nome($1, $2)";
            $res1 = pg_prepare($connection, "", $query1);
            $res1 = pg_execute($connection, "", array($id, $nome));

            if (!$res1) {
                $_SESSION['modifica_nome_com'] = "Errore nella modifica del nome del comico";
                header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                exit();
            } else {
                $_SESSION['modifica_nome_com'] = "Modifica del nome del comico avvenuta con successo!";
                header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                exit();
            }
        } else {
            if (isset($_POST['cognome_comico'])) {
                $cognome = $_POST['cognome_comico'];
                $query2 = "CALL eventi.aggiorna_comico_cognome($1, $2)";
                $res2 = pg_prepare($connection, "", $query2);
                $res2 = pg_execute($connection, "", array($id, $cognome));

                if (!$res2) {
                    $_SESSION['modifica_cognome_com'] = "Errore nella modifica del cognome del comico";
                    header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                    exit();
                } else {
                    $_SESSION['modifica_cognome_com'] = "Modifica del cognome del comico avvenuta con successo!";
                    header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                    exit();
                }
            } else {
                if (isset($_POST['profilo'])) {
                    $profilo = $_POST['profilo'];
                    $query3 = "CALL eventi.aggiorna_comico_foto($1, $2)";
                    $res3 = pg_prepare($connection, "", $query3);
                    $res3 = pg_execute($connection, "", array($id, $profilo));

                    if (!$res3) {
                        $_SESSION['modifica_foto_com'] = "Errore nella modifica della foto profilo del comico";
                        header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                        exit();
                    } else {
                        $_SESSION['modifica_foto_com'] = "Modifica della foto profilo del comico avvenuta con successo!";
                        header('Location: ../../pagine/home_admin/conf_modifica.php');
                        exit();
                    }
                } else {
                    if (isset($_POST['bio'])) {
                        $bio = $_POST['bio'];
                        $query4 = "CALL eventi.aggiorna_comico_bio($1, $2)";
                        $res4 = pg_prepare($connection, "", $query4);
                        $res4 = pg_execute($connection, "", array($id, $bio));

                        if (!$res4) {
                            $_SESSION['modifica_bio_com'] = "Errore nella modifica della descrizione del comico";
                            header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                            exit();
                        } else {
                            $_SESSION['modifica_bio_com'] = "Modifica della descrizione del comico avvenuta con successo!";
                            header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                            exit();
                        }
                    } else {
                        $_SESSION['errore_mod_com'] = "Errore del sistema";
                        header('Location: ../../pagine/home_admin/conf_modifica_com.php');
                        exit();
                    }
                }
            }
        }
    } else {
        $_SESSION['errore_mod_com'] = "Errore del sistema";
        header('Location: ../../pagine/home_admin/conf_modifica_com.php');
        exit();
    }
?>