<?php
    session_start();

    if (isset($_POST['nome_evento']) && isset($_POST['data']) && isset($_POST['ora']) && isset($_POST['luogo']) && isset($_FILES['img']) && isset($_POST['descrizione'])) {
        $nome_evento = $_POST['nome_evento'];
        $data = $_POST['data'];
        $ora = $_POST['ora'];
        $luogo = $_POST['luogo'];
        $descrizione = $_POST['descrizione'];

        include_once('../management/connection.php');

        // validate image:
        $img_path = $_FILES['img']['tmp_name'];
        $img = file_get_contents($img_path);
        $img_escape = pg_escape_bytea($img);

        if (strlen($_POST['link']) > 0) {
            $link = $_POST['link'];

            $query = "CALL eventi.insert_evento($1, $2, $3, $4, $5, $6, $7)";
            $res = pg_prepare($connection, "", $query);
            $res = pg_execute($connection, "", array($nome_evento, $data, $ora, $luogo, $img_escape, $descrizione, $link));

            pg_close($connection);

            if (!$res) {
                $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento. ";
                header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
                exit();
            } else {
                $_SESSION['inserimento'] = "Inserimento dell'evento avvenuto con successo!";
                $_SESSION['nome_evento'] = $nome_evento;
                header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
                exit();
            }
        }

        $query = "CALL eventi.insert_evento_nolink($1, $2, $3, $4, $5, $6)";
        $res = pg_prepare($connection, "", $query);
        $res = pg_execute($connection, "", array($nome_evento, $data, $ora, $luogo, $img_escape, $descrizione));

        pg_close($connection);

        if (!$res) {
            $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento. ";
            header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
            exit();
        } else {
            $_SESSION['inserimento'] = "Inserimento dell'evento avvenuto con successo!";
            $_SESSION['nome_evento'] = $nome_evento;
            header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
            exit();
        }
    } else {
        $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento, devi compilare tutti i campi.";
        header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
        exit();
    }
?>