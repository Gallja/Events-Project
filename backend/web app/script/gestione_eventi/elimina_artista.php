<?php
    session_start();

    if (isset($_POST['codice_evento']) && isset($_POST['codice_comico']) || isset($_POST['codice_mus'])) {
        include_once('../management/connection.php');

        $codice_evento = $_POST['codice_evento'];

        if (isset($_POST['codice_comico'])) {
            $codice_comico = $_POST['codice_comico'];

            $query = "DELETE FROM eventi.eventi_comici AS ec WHERE ec.evento = $1 AND ec.comico = $2";
            $res = pg_prepare($connection, "", $query);
            $res = pg_execute($connection, "", array($codice_evento, $codice_comico));

            pg_close($connection);

            if (!$res) {
                $_SESSION['el_artista'] = "Errore nell'eliminazione del comico dall'evento.";
                header('Location: ../../pagine/home_admin/eventi/conf_el_art.php');
                exit();
            } else {
                $_SESSION['el_artista'] = "Eliminazione del comico dall'evento completata.";
                header('Location: ../../pagine/home_admin/eventi/conf_el_art.php');
                exit();
            }
        } else {
            $codice_musicista = $_POST['codice_mus'];

            $query = "DELETE FROM eventi.eventi_musicisti AS em WHERE em.evento = $1 AND em.musicista = $2";
            $res = pg_prepare($connection, "", $query);
            $res = pg_execute($connection, "", array($codice_evento, $codice_musicista));

            if (!$res) {
                $_SESSION['el_artista'] = "Errore nell'eliminazione del musicista dall'evento.";
                header('Location: ../../pagine/home_admin/eventi/conf_el_art.php');
                exit();
            } else {
                $_SESSION['el_artista'] = "Eliminazione del musicista dall'evento completata.";
                header('Location: ../../pagine/home_admin/eventi/conf_el_art.php');
                exit();
            }
        }

        pg_close($connection);

        if (!$ris) {
            $_SESSION['ins_artista'] = "Errore nell'inserimento degli artisti nell'evento.";
            header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
            exit();
        } else {
            if ($flag && count($arr_comici) == 0 && count($arr_musicisti) == 0) {
                $_SESSION['ins_artista'] = "Non hai associato nessun artista all'evento.";
                header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
                exit();
            } else {
                $_SESSION['ins_artista'] = "Artisti associati correttamente all'evento.";
                header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
                exit();
            }
        } 
    } else {
        $_SESSION['ins_artista'] = "Errore di sistema. L'aggiunta dell'evento deve essere andata a buon fine prima di poter aggiungere ad esso degli artisti.";
        header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
        exit();
    }
?>