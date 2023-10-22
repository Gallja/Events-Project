<?php
    session_start();

    if (isset($_POST['artisti']) && isset($_SESSION['nome_evento'])) {
        include_once('../management/connection.php');
        
        $nome_evento = $_SESSION['nome_evento'];

        $sql = "SELECT e.codice FROM eventi.eventi AS e WHERE e.nome_evento = $1";
        $res = pg_prepare($connection, "", $sql);
        $res = pg_execute($connection, "", array($nome_evento));
        $row = pg_fetch_assoc($res);
        $codice_evento = $row['codice'];

        unset($_SESSION['nome_evento']);
        
        $arr_backup = array_unique($_POST['artisti']);

        $arr_comici = array();
        $arr_musicisti = array();
        
        for ($i = 0; $i < count($arr_backup); $i++) {
            $campi = $arr_backup[$i].split('-'); // $campi[0] --> tipo artista ; $campi[1] --> codice artista ;
            
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

        $query = "SELECT * FROM eventi.inserisci_comici_musicisti($1, $2, $3)";
        $ris = pg_prepare($connection, "", $query);
        $ris = pg_execute($connection, "", array($codice_evento, $arr_comici, $arr_musicisti));

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