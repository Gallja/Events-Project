<!DOCTYPE html>
<html lang = ita>
<head>
    <title>Home Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href = "../../../style/style.css">
    <script src = "../../../js/script.js"></script>
</head>
<body>

    <?php
        include_once('../../../script/check_login.php');
    ?>

    <div class = "container d-flex align-items-center centrato">
        <div class = "text-center">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand">Benvenuto nella tua area riservata!</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="home_admin.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../comici/insert_comico.php">Comici</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../musicisti/insert_musicista.php">Musicisti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pw/cambio_pw.php">Cambia password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../../script/logout.php">Loguot</a>
                        </li>
                    </ul>
                    <div class="row justify-content-center align-items-center" id = "div_search">
                        <input id = "input_ricerca" class="form-control mr-sm-2" type="search" placeholder="Cerca" aria-label="Search">
                        <button onclick = "ricerca()" id = "input_bottone" class="btn btn-outline-success my-2 my-sm-0">Cerca</button>
                    </div>
                </div>
            </nav>

            <br>
            <br>

            <h3>Inserisci un nuovo evento:</h3>
            <form class = "form-group" method = "POST" action = "../../../script/gestione_eventi/insert_evento.php" enctype = "multipart/form-data">
                <input type = "text" class = "form-control" id = "nome_evento1" name = "nome_evento" placeholder = "Inserisci il nome dell'evento" required>
                <input type = "date" class = "form-control" id = "data" name = "data" placeholder = "Inserisci la data" required>
                <input type = "luogo" class = "form-control" id = "luogo1" name = "luogo" placeholder = "Inserisci il luogo" required>
                <input type = "file" class = "form-control" id = "img" name = "img" required>
                <textarea class = "form-control" id = "descrizione" name = "descrizione" placeholder = "Inserisci la descrizione" required></textarea>
                <br />
                <div id = "artisti-container">
                    <label for = "artista">Seleziona un artista per questo evento:</label>
                    <select class = "form-control" id = "artisti" name = "artisti[]" required>
                        <?php
                            include_once('../../../script/connection.php');

                            $sql = "SELECT * FROM eventi.comici";
                            $ris = pg_prepare($connection, "", $sql);
                            $ris = pg_execute($connection, "", array());

                            if (!$ris) {
                                echo "<option>Errore nella visualizzazione dei comici</option>";
                            } else {
                                while ($row = pg_fetch_assoc($ris)) {
                                    echo "<option>";
                                    foreach ($row as $key => $value) {
                                        switch ($key) {
                                            case "nome_comico":
                                                echo $value." ";
                                                break;
                                            case "cognome_comico":
                                                echo $value;
                                        }
                                    }
                                    echo "</option>";
                                }
                            }

                            $sql2 = "SELECT * FROM eventi.musicisti";
                            $ris2 = pg_prepare($connection, "", $sql);
                            $ris2 = pg_execute($connection, "", array());

                            if (!$ris2) {
                                echo "<option>Errore nella visualizzazione dei musicisti</option>";
                            } else {
                                while ($row2 = pg_fetch_assoc($ris2)) {
                                    echo "<option>";
                                    foreach ($row as $key => $value) {
                                        switch ($key) {
                                            case "nome_musicista":
                                                echo $value;
                                                break;
                                        }
                                    }
                                    echo "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <input type = "button" class = "btn btn-secondary btn-sm" id = "aggiungi-artista" onclick = "clonaArtista('artisti-container')" value = "Aggiungi Artista" />
                <br />
                <br />
                <input type = "submit" class="btn btn-primary" value = "INSERISCI">
            </form>

            <br>
            <br>
            <hr>

            <h3>Tutti gli eventi creati:</h3>
            
            <?php
                include_once('../../../script/connection.php');

                $query = "SELECT * FROM eventi.eventi AS e ORDER BY e.data_evento";
                $res = pg_prepare($connection, "ris", $query);
                $res = pg_execute($connection, "ris", array());

                $tipo = ['danger', 'warning', 'secondary', 'primary', 'success', 'light', 'info'];
                $conta = 0;
                $conta2 = 1;

                if (!$res) {
                    echo "<h4>Errore nella visualizzazione degli eventi.</h4>";
                } else {
                    echo "<table class='table'>";

                    echo "<th>";
                    echo "<td class='int'>Nome Evento</td>";
                    echo "<td class='int'>Data Evento</td>";
                    echo "<td class='int'>Luogo</td>";
                    echo "<td class='int'>Locandina</td>";
                    echo "<td class='int'>Descrizione</td>";
                    echo "<td class='int'>Modifica Evento</td>";
                    echo "<td class='int'>Elimina Evento</td>";
                    echo "</th>";
                    
                    while ($row = pg_fetch_assoc($res)) {
                        $codice = $row['codice'];
                        echo "<tr>";

                        foreach($row as $key => $value) {
                            if (str_contains($key, '_')) {
                                $campi_chiave = explode('_', $key);

                                switch ($key) {
                                    case 'nome_evento':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo $value;
                                        echo "</td>";
                                        break;
                                    case 'data_evento':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        $newData = date('d-m-Y', strtotime($value));
                                        echo $newData;
                                        echo "</td>";
                                        break;
                                }
                            } else {
                                switch ($key) {
                                    case 'codice':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo $conta2;
                                        echo "</td>";
                                        break;
                                    case 'luogo':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo $value;
                                        echo "</td>";
                                        break;
                                    case 'immagine':
                                        $sql = "SELECT encode(immagine, 'base64') AS img FROM eventi.eventi AS e WHERE e.codice = $1";
                                        $res2 = pg_prepare($connection, "", $sql);
                                        $res2 = pg_execute($connection, "", array($codice));
                                        $row2 = pg_fetch_assoc($res2);

                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo "<button type='button' class = 'btn btn-info' onclick='mostraFoto(".$codice.")'>";
                                        echo "Mostra";
                                        echo "</button>";
                                        echo "</td>";

                                        echo "<div id = 'pannelloFoto".$codice."' class = 'pannelloFoto' data-pannello='false'>";
                                        echo '<img src="data:image/jpg;base64,'.$row2["img"].'"><br><br>';
                                        echo "<button type = 'button' class = 'btn btn-info' onclick='chiudiFoto(".$codice.")'>";
                                        echo "Chiudi";
                                        echo "</button>";
                                        echo "</div>";

                                        break;
                                    case 'descrizione':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo "<button type='button' class = 'btn btn-primary' onclick = 'mostraDesc(".$codice.")'>";
                                        echo "Mostra";
                                        echo "</button>";
                                        echo "</td>";

                                        echo "<div id = 'pannelloDesc".$codice."' class = 'pannelloDesc' data-pannello='false'>";
                                        echo $value;
                                        echo "<br><br>";
                                        echo "<button type = 'button' class = 'btn btn-primary' onclick='chiudiDesc(".$codice.")'>";
                                        echo "Chiudi";
                                        echo "</button>";
                                        echo "</div>";

                                        break;
                                }
                            }
                        }

                        echo "<td class = 'table-".$tipo[$conta]."'>";
                        echo "<form action = 'modifica_evento_page.php' method = 'POST'>";
                        echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                        echo "<input type = 'submit' class = 'btn btn-warning' value = 'Modifica' />";
                        echo "</form>";
                        echo "</td>";

                        echo "<td class = 'table-".$tipo[$conta]."'>";
                        echo "<form action = 'conferma_eliminazione.php' method = 'POST'>";
                        echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                        echo "<input type = 'submit' class = 'btn btn-danger' value = 'Elimina' />";
                        echo "</form>";
                        echo "</td>";

                        $conta++;

                        if ($conta > 6) {
                            $conta = 0;
                        }
                        
                        echo "</tr>";
                        $conta2++;
                    }
                    echo "</table>";
                }
            ?>
            
            <br>
            <br>

        </div>
    </div>

</body>
</html>