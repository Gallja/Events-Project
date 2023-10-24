<!DOCTYPE html>
<html lang = ita>
    <head>
        <title>Conferma Inserimento Evento</title>
        <link rel="icon" type="image/png" href="../../../img/icon.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src = "../../../js/script.js"></script>
        <link rel = "stylesheet" href = "../../../style/style_conf.css">
    </head>
    <body>
        <div id = "centro">

            <?php
                include_once('../../../script/management/check_login.php');

                if (isset($_SESSION['inserimento'])) {
                    echo "<h2>".$_SESSION['inserimento']."<h2>";

                    unset($_SESSION['inserimento']);

                    include_once('../../../script/management/connection.php');
        
                    $nome_evento = $_SESSION['nome_evento'];

                    $sql = "SELECT e.codice FROM eventi.eventi AS e WHERE e.nome_evento = $1";
                    $res = pg_prepare($connection, "", $sql);
                    $res = pg_execute($connection, "", array($nome_evento));
                    $row = pg_fetch_assoc($res);
                    $_SESSION['codice_evento'] = $row['codice'];

                    unset($_SESSION['nome_evento']);
                }
            ?>

            <br>

            <h3>Desideri aggiungere qualche artista per l'evento appena inserito?</h3>
            <br />

                <form class = "form-group" method = "POST" action = "../../../script/gestione_eventi/insert_artista.php">
                    <div id = "artisti-container">
                        <select class = "form-control" id = "artisti" name = "artisti[]" required>
                            <?php
                                include_once('../../../script/management/connection.php');

                                $sql = "SELECT * FROM eventi.comici";
                                $ris = pg_prepare($connection, "", $sql);
                                $ris = pg_execute($connection, "", array());

                                if (!$ris) {
                                    echo "<option>Errore nella visualizzazione dei comici</option>";
                                } else {
                                    echo "<option value = 'empty'>Scegli un artista</option>";
                                    while ($row = pg_fetch_assoc($ris)) {
                                        echo "<option value = 'comico-";
                                        foreach ($row as $key => $value) {
                                            switch ($key) {
                                                case 'id':
                                                    echo $value."' >";
                                                    break;
                                                case "nome_comico":
                                                    echo $value." ";
                                                    break;
                                                case "cognome_comico":
                                                    echo $value;
                                                    break;
                                            }
                                        }
                                        echo "</option>";
                                    }
                                }

                                $sql2 = "SELECT * FROM eventi.musicisti";
                                $ris2 = pg_prepare($connection, "", $sql2);
                                $ris2 = pg_execute($connection, "", array());

                                if (!$ris2) {
                                    echo "<option>Errore nella visualizzazione dei musicisti</option>";
                                } else {
                                    while ($row2 = pg_fetch_assoc($ris2)) {
                                        echo "<option value = 'musicista-";
                                        foreach ($row2 as $key => $value) {
                                            switch ($key) {
                                                case 'id_musicista':
                                                    echo $value."' >";
                                                    break;
                                                case 'nome_musicista':
                                                    echo $row2['nome_musicista'];
                                                    break;
                                            }
                                        }
                                        echo "</option>";
                                    }
                                }
                            ?>
                        </select>
                        <input type = "button" class = "btn btn-secondary btn-sm" id = "aggiungi-artista" onclick = "clonaArtista('artisti-container')" value = "Aggiungi Artista" />
                        </div>
                    <br />
                    <br />
                    <input type = "submit" class = "btn btn-primary" value = "AGGIUNGI">
                </form>
            
            <br />

            <h4>Torna alla pagina precedente:</h4>
            <br>
            <form action = "home_admin.php">
                <input type = "submit" class = "btn btn-primary" value = "Torna alla Home" />
            </form>

        </div>
    </body>
</html>