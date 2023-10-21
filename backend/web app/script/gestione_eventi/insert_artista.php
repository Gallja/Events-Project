<?php
    session_start();

    if (isset($_POST['artisti']) && isset($_SESSION['nome_evento'])) {
        include_once('../management/connection.php');
        
        $nome_evento = $_SESSION['nome_evento'];

        $sql = "SELECT e.codice FROM eventi.eventi AS e WHERE e.nome_evento = $1"
        $res = pg_prepare($connection, "", $sql);
        $res = pg_execute($connection, "", array($nome_evento));
        $row = pg_fetch_assoc($res);
        $codice_evento = $row['codice'];

        unset($_SESSION['nome_evento']);

        $flag = true;
        $arr_backup = array_unique($_POST['artisti']);

        for ($i = 0; $i < $arr_backup.sizeof(); $i++) {
            $campi = $arr_backup[i].split('-'); // $campi[0] --> tipo artista ; $campi[1] --> codice artista ;
            
            switch ($campi[0]) {
                case 'comico':
                    // insert comico in eventi_comici

                    break;
                case 'musicista':
                    // insert musicista in eventi_musicisti

                    break;
                case 'empty':
                    break;
            }
        }

        pg_close($connection);
        /**
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
        } */
    } else {
        $_SESSION['ins_artista'] = "Errore di sistema. L'aggiunta dell'evento deve essere andata a buon fine prima di poter aggiungere ad esso degli artisti.";
        header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
        exit();
    }
?>