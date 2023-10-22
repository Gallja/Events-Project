<?php
    session_start();

    if (isset($_POST['artisti']) && isset($_SESSION['codice_evento'])) {
        include_once('../management/connection.php');

        $codice_evento = $_SESSION['codice_evento'];

        unset($_SESSION['codice_evento']);

        $arr_comici = array();
        $arr_musicisti = array();
        
        $len = count($_POST['artisti']);

        foreach ($_POST['artisti'] as $key => $value) {
            $campi = explode('-', $value); // $campi[0] --> tipo artista ; $campi[1] --> codice artista ;
            switch ($campi[0]) {
                case 'comico':
                    // increase comici list
                    array_push($arr_comici, (int)$campi[1]);
                    break;
                case 'musicista':
                    // increase musicisti list
                    array_push($arr_musicisti, (int)$campi[1]);
                    break;
                case 'empty':
                    break;
            }
        }
        
        $arr_comici_str = '{' . implode(',', $arr_comici) . '}';
        $arr_musicisti_str = '{' . implode(',', $arr_musicisti) . '}';

        $query = "SELECT * FROM eventi.inserisci_comici_musicisti($1, $2, $3)";
        $ris = pg_prepare($connection, "", $query);
        $ris = pg_execute($connection, "", array($codice_evento, $arr_comici_str, $arr_musicisti_str));

        $err = pg_last_error($connection);

        pg_close($connection);
        if (!$ris) {
            $_SESSION['ins_artista'] = "Errore nell'inserimento degli artisti nell'evento.";
            header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
            exit();
        } else {
            $_SESSION['ins_artista'] = "Artisti associati correttamente all'evento.";
            header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
            exit();
        } 
    } else {
        $_SESSION['ins_artista'] = "Errore di sistema. L'aggiunta dell'evento deve essere andata a buon fine prima di poter aggiungere ad esso degli artisti.";
        header('Location: ../../pagine/home_admin/eventi/conf_ins_art.php');
        exit();
    }
?>