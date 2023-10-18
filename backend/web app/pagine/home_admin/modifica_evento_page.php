<!DOCTYPE html>
<html lang = ita>
<head>
    <title>Modifica Evento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href = "../../style/style.css">
    <script src = "../../js/script.js"></script>
</head>
<body>
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
                        <a class="nav-link" href="insert_comico.php">Comici</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="insert_musicista.php">Musicisti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cambio_pw.php">Cambia password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../script/logout.php">Loguot</a>
                    </li>
                </ul>
                <div class="row justify-content-center align-items-center" id = "div_search">
                    <input id = "input_ricerca" class="form-control mr-sm-2" type="search" placeholder="Cerca" aria-label="Search">
                    <button onclick = "ricerca()" id = "input_bottone" class="btn btn-outline-success my-2 my-sm-0">Cerca</button>
                </div>
            </div>
        </nav>

        <br>
        <h3>Evento da modificare:</h3>
        <br>
        
        <?php
            if (isset($_POST['codice'])) {
                $codice = $_POST['codice'];

                include_once('../../script/connection.php');

                $query = "SELECT * FROM eventi.eventi AS e WHERE e.codice = $1";
                $res = pg_prepare($connection, "", $query);
                $res = pg_execute($connection, "", array($codice));

                if (!$res) {
                    echo "<h4>Errore nella visualizzazione dell'evento da modificare.</h4>";
                } else {
                    $row = pg_fetch_assoc($res);

                    echo "<ul class = 'list-group'>";

                    foreach ($row as $key => $value) {
                        if (str_contains($key, '_')) {
                            $campi_chiave = explode('_', $key);

                            switch ($key) {
                                case 'nome_evento':
                                    echo "<li class='"."list-group-item"."'>";
                                    echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                                    echo "<br><br><button onclick='mostra_mod(\"nome_evento\", \"".$codice."\")' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                    echo "<form class = 'form-group' method = 'POST' id = 'myForm_nome_evento_".$codice."' name = 'myForm_nome_evento_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>"; 
                                    echo "<input type = 'text' class = 'form-control' id = 'nome_evento' name = 'nome_evento' placeholder = 'Reinserisci il nome' required />";
                                    echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                                    echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma' />";
                                    echo "</form>";
                                    echo "</li>";
                                    break;
                                case 'data_evento':
                                    echo "<li class='"."list-group-item"."'>";
                                    echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                                    echo "<br><br><button onclick='mostra_mod(\"data_evento\", \"".$codice."\")' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                    echo "<form class = 'form-group' method = 'POST' id = 'myForm_data_evento_".$codice."' name = 'myForm_data_evento' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>";
                                    echo "<input type = 'date' class = 'form-control' id = 'data_evento' name = 'data_evento' placeholder = 'Reinserisci la data' required />";
                                    echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                                    echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                    echo "</form>";
                                    echo "</li>";
                                    break;
                            }
                        } else {
                            switch ($key) {
                                case 'luogo':
                                    echo "<li class='"."list-group-item"."'>";
                                        echo strtoupper($key).": ".$value;

                                        echo "<br><br><button onclick='mostra_mod(\"luogo\", \"".$codice."\")' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_luogo_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>";
                                        echo "<input type = 'text' class = 'form-control' id = 'luogo' name = 'luogo' placeholder = 'Reinserisci il luogo' required/>";
                                        echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                                        echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                        echo "</form>";

                                        echo "</li>";
                                        break;
                                case 'descrizione':
                                    echo "<li class='"."list-group-item"."'>";
                                    echo strtoupper($key).": ".$value;

                                    echo "<br><br><button onclick='"."mostra_mod(\"descrizione\", \"".$codice."\")"."' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                    echo "<form class = 'form-group' method = 'POST' id = 'myForm_descrizione_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>";
                                    echo "<textarea class = 'form-control' id = 'descrizione' name = 'descrizione' placeholder = 'Reinserisci la descrizione' required></textarea>";
                                    echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                                    echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                    echo "</form>";

                                    echo "</li>";
                                    break;
                                case 'immagine':
                                    $sql = "SELECT encode(immagine, 'base64') AS img FROM eventi.eventi AS e WHERE e.codice = $1";
                                    $res2 = pg_prepare($connection, "", $sql);
                                    $res2 = pg_execute($connection, "", array($codice));
                                    $row2 = pg_fetch_assoc($res2);

                                    echo "<li class='"."list-group-item"."'>";

                                    echo '<br><img src="data:image/jpg;base64,'.$row2["img"].'">';

                                    echo "<br><br><button onclick='"."mostra_mod(\"immagine\", \"".$codice."\")"."' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                    echo "<form class = 'form-group' method = 'POST' id = 'myForm_immagine_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' enctype = 'multipart/form-data' style = 'display: none;'>";
                                    echo "<input type = 'file' class = 'form-control' id = 'immagine' name = 'immagine' placeholder = 'Reinserisci immagine' required/>";
                                    echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                                    echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                    echo "</form>";

                                    echo "</li>";
                                    break;
                            }
                        }
                    }

                    echo "</ul>";
                }
            } else {
                echo "<h3>Errore nella ricerca dell'evento da rimuovere</h3><br>";
            }
        ?>

            <br><br><br>

            <a href = "home_admin.php">
                <button class = "btn btn-primary">HomePage</button>
            </a>

            <br><br>

        </div>
    </div>
</body>
</html>