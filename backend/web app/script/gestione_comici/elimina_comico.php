<?php
    session_start();

    if (isset($_POST['id'])) {
        include_once('../connection.php');
        $id = $_POST['id'];

        $sql = "DELETE FROM eventi.comici AS c WHERE c.id = $1";
        $res = pg_prepare($connection, "", $sql);
        $res = pg_execute($connection, "", array($id));

        if (!$res) {
            $_SESSION['eliminazione_comico'] = "Errore nell'eliminazione dell'evento.";
            header('Location: ../../pagine/home_admin/conf_elim_comico2.php');
            exit();
        } else {
            $_SESSION['eliminazione_comico'] = "Eliminazione dell'evento avvenuta con successo!";
            header('Location: ../../pagine/home_admin/conf_elim_comico2.php');
            exit();
        }
    } else {
        $_SESSION['eliminazione_comico'] = "Errore nell'eliminazione dell'evento: codice non trovato.";
        header('Location: ../../pagine/home_admin/conf_elim_comico2.php');
        exit();
    }
?>