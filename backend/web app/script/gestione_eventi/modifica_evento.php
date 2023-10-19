<?php
    session_start();

    if (isset($_POST['codice'])) {
        include_once("../connection.php");
        $codice = $_POST['codice'];
        if (isset($_POST['nome_evento'])) {
            $nome = $_POST['nome_evento'];
            $query1 = "CALL eventi.aggiorna_evento_nome($1, $2)";
            $res1 = pg_prepare($connection, "", $query1);
            $res1 = pg_execute($connection, "", array($codice, $nome));

            if (!$res1) {
                $_SESSION['modifica_nome'] = "Errore nella modifica del nome dell'evento";
                header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                exit();
            } else {
                $_SESSION['modifica_nome'] = "Modifica del nome dell'evento avvenuta con successo!";
                header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                exit();
            }
        } else {
            if (isset ($_POST['data_evento'])) {
                $data = $_POST['data_evento'];
                $query2 = "CALL eventi.aggiorna_evento_data($1, $2)";
                $res2 = pg_prepare($connection, "", $query2);
                $res2 = pg_execute($connection, "", array($codice, $data));

                if (!$res2) {
                    $_SESSION['modifica_data'] = "Errore nella modifica della data dell'evento";
                    header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                    exit();
                } else {
                    $_SESSION['modifica_data'] = "Modifica della data dell'evento avvenuta con successo!";
                    header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                    exit();
                }
            } else {
                if (isset($_POST['luogo'])) {
                    $luogo = $_POST['luogo'];
                    $query3 = "CALL eventi.aggiorna_evento_luogo($1, $2)";
                    $res3 = pg_prepare($connection, "", $query3);
                    $res3 = pg_execute($connection, "", array($codice, $luogo));

                    if (!$res3) {
                        $_SESSION['modifica_luogo'] = "Errore nella modifica del luogo dell'evento";
                        header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                        exit();
                    } else {
                        $_SESSION['modifica_luogo'] = "Modifica del luogo dell'evento avvenuta con successo!";
                        header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                        exit();
                    }
                } else {
                    if (isset($_FILES['immagine'])) {
                        // validate image:
                        $img_path = $_FILES['immagine']['tmp_name'];
                        $img = file_get_contents($img_path);
                        $immagine = pg_escape_bytea($img);

                        $query4 = "CALL eventi.aggiorna_evento_imm($1, $2)";
                        $res4 = pg_prepare($connection, "", $query4);
                        $res4 = pg_execute($connection, "", array($codice, $immagine));

                        if (!$res4) {
                            $_SESSION['modifica_immagine'] = "Errore nella modifica della copertina dell'evento";
                            header('Location: ../../pagine/eventi/eventi/conf_modifica.php');
                            exit();
                        } else {
                            $_SESSION['modifica_immagine'] = "Modifica della copertina dell'evento avvenuta con successo!";
                            header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                            exit();
                        }
                    } else {
                        if (isset($_POST['descrizione'])) {
                            $desc = $_POST['descrizione'];
                            $query5 = "CALL eventi.aggiorna_evento_desc($1, $2)";
                            $res5 = pg_prepare($connection, "", $query5);
                            $res5 = pg_execute($connection, "", array($codice, $desc));

                            if (!$res5) {
                                $_SESSION['modifica_desc'] = "Errore nella modifica della descrizione dell'evento";
                                header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                                exit();
                            } else {
                                $_SESSION['modifica_desc'] = "Modifica della descrizione dell'evento avvenuta con successo!";
                                header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                                exit();
                            }
                        } else {
                            $_SESSION['errore_mod'] = "Errore del sistema";
                            header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
                            exit();
                        }
                    }
                }
            }
        }
    } else {
        $_SESSION['errore_mod'] = "Errore del sistema";
        header('Location: ../../pagine/home_admin/eventi/conf_modifica.php');
        exit();
    }
?>