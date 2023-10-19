<?php
    session_start();

    if (isset($_POST['nome_mus']) && isset($_FILES['profilo']) && isset($_POST['bio'])) {
        $nome_mus = $_POST['nome_mus'];
        $bio = $_POST['bio'];

        include_once('../management/connection.php');

        // validate image:
        $img_path = $_FILES['profilo']['tmp_name'];
        $img = file_get_contents($img_path);
        $img_escape = pg_escape_bytea($img);

        $query = "CALL eventi.insert_musicista($1, $2, $3)";
        $res = pg_prepare($connection, "", $query);
        $res = pg_execute($connection, "", array($nome_mus, $img_escape, $bio));

        // pg_close($connection);

        if (!$res) {
            $_SESSION['inserimento_musicista'] = "Errore nell'inserimento del musicista.";

            // $err = pg_last_error($connection);
            // echo $err;
            
            header('Location: ../../pagine/home_admin/musicisti/conf_ins_mus.php');
            exit();
        } else {
            $_SESSION['inserimento_musicista'] = "Inserimento del musicista avvenuto con successo!";
            header('Location: ../../pagine/home_admin/musicisti/conf_ins_mus.php');
            exit();
        }
    } else {
        $_SESSION['inserimento_musicista'] = "Errore nell'inserimento del musicista, compilare tutti i campi.";
        header('Location: ../../pagine/home_admin/musicisti/conf_ins_mus.php');
        exit();
    }
?>