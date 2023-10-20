<?php
    session_start();

    if (isset($_POST['nome_evento']) && isset($_POST['data']) && isset($_POST['luogo']) && isset($_FILES['img']) && isset($_POST['descrizione']) && isset($_POST['artisti'])) {
        $nome_evento = $_POST['nome_evento'];
        $data = $_POST['data'];
        $luogo = $_POST['luogo'];
        $descrizione = $_POST['descrizione'];

        include_once('../management/connection.php');

        // validate image:
        $img_path = $_FILES['img']['tmp_name'];
        $img = file_get_contents($img_path);
        $img_escape = pg_escape_bytea($img);

        $query = "CALL eventi.insert_evento($1, $2, $3, $4, $5)";
        $res = pg_prepare($connection, "", $query);
        $res = pg_execute($connection, "", array($nome_evento, $data, $luogo, $img_escape, $descrizione));

        $flag = true;
        $conta_sel = count($_POST['artisti']);
        for ($i = 0; $i < $conta_sel; $i++) {
            $artista = $_POST['artisti'][$i];

            if ($artista == "empty") {
                break;
            } else {
                // select codice 'evento'
                $query2 = "SELECT e.codice FROM evento AS e WHERE e.nome_evento = $1";
                $res2 = pg_prepare($connection, "", $query2);
                $res2 = pg_execute($connection, "", array($nome_evento));
                $row2 = pg_fetch_assoc($res2);
                $cod_new_ev = $row2['codice'];
                
                // check 'comico' or 'musicista'
                if ($artista.contains('comico')) {

                    // select 'comico' id
                    $campo = explode($artista, '-');
                    $id_comico = $campo[1];

                    // call insert procedure
                    $query3 = "CALL eventi.ins_eventi_comici($1, $2)";
                    $res3 = pg_prepare($connection, "", $query3);
                    $res3 = pg_execute($connection, "", array($cod_new_ev, $id_comico));

                    if (!$res3) {
                        $flag = false;
                    }
                } else {
                    // select 'musicista' id
                    $campo = explode($artista, '-');
                    $id_musicista = $campo[1];

                    // call insert
                    $query4 = "CALL eventi.ins_eventi_musicisti($1, $2)";
                    $res4 = pg_prepare($connection, "", $query4);
                    $res4 = pg_execute($connection, "", array($cod_new_ev, $id_musicista));

                    if (!$res4) {
                        $flag = false;
                    }
                }
            }
        }

        pg_close($connection);

        if (!$res) {
            if ($flag) {
                $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento. ";
                header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
                exit();
            } else {
                $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento e nell'affiliazione degli artisti. ";
                header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
                exit();
            }
        } else {
            if ($flag) {
                $_SESSION['inserimento'] = "Inserimento dell'evento avvenuto con successo!";
                header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
                exit();
            } else {
                $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento e nell'affiliazione degli artisti. ";
                header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
                exit();
            }
        }
    } else {
        $_SESSION['inserimento'] = "Errore nell'inserimento dell'evento, devi compilare tutti i campi.";
        header('Location: ../../pagine/home_admin/eventi/conf_inserimento.php');
        exit();
    }
?>