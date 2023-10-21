<?php
    session_start();

    if (isset($_POST['artisti'])) {
        include_once('../management/connection.php');
        
        $flag = true;
        $arr_backup = array_unique($_POST['artisti']);
        $conta_sel = $arr_backup;

        for ($i = 0; $i < $conta_sel; $i++) {
            $artista = $_POST['artisti'][$i];
            // echo "<p>".$artista."</p>";

            
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
        $_SESSION['ins_artista'] = "Errore di sistema.";
        header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
        exit();
    }
?>