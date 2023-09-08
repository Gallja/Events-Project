<?php
    session_start();

    if (isset($_POST['nome_evento']) && isset($_POST['data']) && isset($_POST['luogo']) && isset($_FILES['img']) && isset($_POST['descrizione'])) {
        $nome_evento = $_POST['nome_evento'];
        $data = $_POST['data'];
        $luogo = $_POST['luogo'];
        $descrizione = $_POST['descrizione'];

        include_once('../connection.php');

        // validate image:
        $img_path = $_FILES['img']['tmp_name'];
        $img = file_get_contents($img_path);
        $img_escape = pg_escape_bytea($img);

        $query = "CALL eventi.insert_evento($1, $2, $3, $4, $5)";
        $res = pg_prepare($connection, "", $query);
        $res = pg_execute($connection, "", array($nome_evento, $data, $luogo, $img_escape, $descrizione));

        pg_close($connection);

        if (!$res) {
            $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento. ";
            header('Location: ../../pagine/home_admin/conf_inserimento.php');
            exit();
        } else {
            $_SESSION['inserimento'] = "Inserimento dell'evento avvenuto con successo!";
            header('Location: ../../pagine/home_admin/conf_inserimento.php');
            exit();
        }
    } else {
        $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento, devi compilare tutti i campi.";
        header('Location: ../../pagine/home_admin/conf_inserimento.php');
        exit();
    }
?>