<?php
    session_start();

    if (isset($_POST['nome_comico']) && isset($_POST['cognome_comico']) && isset($_FILES['profilo']) && isset($_POST['bio'])) {
        $nome_comico = $_POST['nome_comico'];
        $cognome_comico = $_POST['cognome_comico'];
        $bio = $_POST['bio'];

        include_once('../connection.php');

        // validate image:
        $img_path = $_FILES['profilo']['tmp_name'];
        $img = file_get_contents($img_path);
        $img_escape = pg_escape_bytea($img);

        $query = "CALL eventi.insert_comico($1, $2, $3, $4)";
        $res = pg_prepare($connection, "", $query);
        $res = pg_execute($connection, "", array($nome_comico, $cognome_comico, $img_escape, $bio));

        // echo "<p>".pg_last_error($connection)."</p>";

        pg_close($connection);

        if (!$res) {
            $_SESSION['inserimento_comico'] = "Errore nell'inserimento del comico.";
            header('Location: ../../pagine/home_admin/comici/conf_ins_comico.php');
            exit();
        } else {
            $_SESSION['inserimento_comico'] = "Inserimento del comico avvenuto con successo!";
            header('Location: ../../pagine/home_admin/comici/conf_ins_comico.php');
            exit();
        }
    } else {
        $_SESSION['inserimento_comico'] = "Errore nell'inserimento del comico, compilare tutti i campi.";
        header('Location: ../../pagine/home_admin/comici/conf_ins_comico.php');
        exit();
    }
?>