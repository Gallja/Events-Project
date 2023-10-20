<?php
    session_start();

    if (isset($_POST['artisti'])) {
        include_once('../management/connection.php');
        
        $flag = true;
        $arr_backup = array_unique($_POST['artisti']);
        $conta_sel = $arr_backup;

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
                if ($artista.str_contains('comico')) {

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

        if (!$flag) {
            $_SESSION['ins_artista'] = "Errore nell'inserimento dell'artista nell'evento.";
            header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
            exit();
        } else {
            if ($conta_sel > 1) {
                $_SESSION['ins_artista'] = "Artisti associati correttamente all'evento.";
                header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
                exit();
            } else {
                $_SESSION['ins_artista'] = "Artista associato correttamente all'evento.";
                header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
                exit();
            }
        }
    } else {
        $_SESSION['ins_artista'] = "Errore di sistema.";
        header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
        exit();
    }
?>