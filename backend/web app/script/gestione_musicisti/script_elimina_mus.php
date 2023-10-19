<?php
    session_start();

    if (isset($_POST['id'])) {
        include_once('../management/connection.php');
        $id = $_POST['id'];

        $sql = "DELETE FROM eventi.musicisti AS m WHERE m.id_musicista = $1";
        $res = pg_prepare($connection, "ris", $sql);
        $res = pg_execute($connection, "ris", array($id));

        if (!$res) {
            $_SESSION['eliminazione_musicista'] = "Errore nell'eliminazione del musicista.";
            echo pg_last_error($connection)."\n";
            header('Location: ../../pagine/home_admin/musicisti/conf_elim_mus2.php');
            exit();
            
        } else {
            $_SESSION['eliminazione_musicista'] = "Eliminazione del musicista avvenuta con successo!";
            header('Location: ../../pagine/home_admin/musicisti/conf_elim_mus2.php');
            exit();
        }
    } else {
        $_SESSION['eliminazione_musicista'] = "Errore nell'eliminazione del musicista: codice non trovato.";
        header('Location: ../../pagine/home_admin/musicisti/conf_elim_mus2.php');
        exit();
    }
?>