<?php
    session_start();

    if (isset($_POST['codice'])) {
        include_once('../connection.php');
        $codice = $_POST['codice'];

        $sql = "DELETE FROM eventi.eventi AS e WHERE e.codice = $1";
        $res = pg_prepare($connection, "", $sql);
        $res = pg_execute($connection, "", array($codice));

        if (!$res) {
            $_SESSION['eliminazione'] = "Errore nell'eliminazione dell'evento.";
            header('Location: ../../pagine/home_admin/eventi/conf_eliminazione.php');
            exit();
        } else {
            $_SESSION['eliminazione'] = "Eliminazione dell'evento avvenuta con successo!";
            header('Location: ../../pagine/home_admin/eventi/conf_eliminazione.php');
            exit();
        }
    } else {
        $_SESSION['eliminazione'] = "Errore nell'eliminazione dell'evento: codice non trovato.";
        header('Location: ../../pagine/home_admin/eventi/conf_eliminazione.php');
        exit();
    }
?>