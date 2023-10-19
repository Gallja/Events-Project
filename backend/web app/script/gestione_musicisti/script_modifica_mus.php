<?php
    session_start();

    if (isset($_POST['id'])) {
        include_once('../management/connection.php');
        $id = $_POST['id'];
        if (isset($_POST['nome'])) {
            $nome = $_POST['nome'];
            $query1 = "CALL eventi.aggiorna_musicista_nome($1, $2)";
            $res1 = pg_prepare($connection, "", $query1);
            $res1 = pg_execute($connection, "", array($id, $nome));

            if (!$res1) {
                $_SESSION['modifica_nome_mus'] = "Errore nella modifica del nome del musicista";
                header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                exit();
            } else {
                $_SESSION['modifica_nome_mus'] = "Modifica del nome del musicista avvenuta con successo!";
                header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                exit();
            }
        } else {
            if (isset($_FILES['profilo'])) {
                // validate image:
                $img_path = $_FILES['profilo']['tmp_name'];
                $img = file_get_contents($img_path);
                $immagine = pg_escape_bytea($img);

                $profilo = $_POST['profilo'];
                $query3 = "CALL eventi.aggiorna_musicista_foto($1, $2)";
                $res3 = pg_prepare($connection, "", $query3);
                $res3 = pg_execute($connection, "", array($id, $immagine));

                if (!$res3) {
                    $_SESSION['modifica_foto_mus'] = "Errore nella modifica della foto profilo del musicista";
                    header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                    exit();
                } else {
                    $_SESSION['modifica_foto_mus'] = "Modifica della foto profilo del musicista avvenuta con successo!";
                    header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                    exit();
                }
            } else {
                if (isset($_POST['bio'])) {
                    $bio = $_POST['bio'];
                    $query4 = "CALL eventi.aggiorna_musicista_desc($1, $2)";
                    $res4 = pg_prepare($connection, "", $query4);
                    $res4 = pg_execute($connection, "", array($id, $bio));

                    if (!$res4) {
                        $_SESSION['modifica_bio_mus'] = "Errore nella modifica della descrizione del musicista";
                        header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                        exit();
                    } else {
                        $_SESSION['modifica_bio_mus'] = "Modifica della descrizione del musicista avvenuta con successo!";
                        header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                        exit();
                    }
                } else {
                    $_SESSION['errore_mod_mus'] = "Errore del sistema";
                    header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
                    exit();
                }
            }
        }
    } else {
        $_SESSION['errore_mod_mus'] = "Errore del sistema. Musicista non trovato.";
        header('Location: ../../pagine/home_admin/musicisti/conf_modifica_mus.php');
        exit();
    }
?>