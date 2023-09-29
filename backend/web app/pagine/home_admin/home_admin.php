<!DOCTYPE html>
<html lang = ita>
<head>
    <title>Home Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href = "../../style/style.css">
    <script src = "../../js/script.js"></script>
</head>
<body>

    <?php
        include_once('../../script/check_login.php');
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
                            <a class="nav-link" href="insert_comico.php">Inserisci nuovo comico</a>
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
            <br>

            <h3>Inserisci un nuovo evento:</h3>
            <form class = "form-group" method = "POST" action = "../../script/gestione_eventi/insert_evento.php" enctype = "multipart/form-data">
                <input type = "text" class = "form-control" id = "nome_evento1" name = "nome_evento" placeholder = "Inserisci il nome dell'evento" required>
                <input type = "date" class = "form-control" id = "data" name = "data" placeholder = "Inserisci la data" required>
                <input type = "luogo" class = "form-control" id = "luogo1" name = "luogo" placeholder = "Inserisci il luogo" required>
                <input type = "file" class = "form-control" id = "img" name = "img" required>
                <textarea class = "form-control" id = "descrizione" name = "descrizione" placeholder = "Inserisci la descrizione" required></textarea>
                <br>
                <input type = "submit" class="btn btn-primary" value = "INSERISCI">
            </form>

            <br>
            <br>
            <hr>

            <h3>Tutti gli eventi creati:</h3>
            <!---
            <?php
                include_once('../../script/connection.php');

                $query = "SELECT * FROM eventi.eventi AS e ORDER BY e.data_evento";
                $res = pg_prepare($connection, "ris", $query);
                $res = pg_execute($connection, "ris", array());

                $tipo = ['danger', 'warning', 'secondary', 'primary', 'success', 'light', 'info'];
                $conta = 0;
                $conta2 = 1;

                if (!$res) {
                    echo "<h4>Errore nella visualizzazione dei comici del sistema.</h4>";
                } else {
                    echo "<table class='table'>";

                    echo "<th>";
                    echo "<td class='int'>Nome</td>";
                    echo "<td class='int'>Cognome</td>";
                    echo "<td class='int'>Foto Profilo</td>";
                    echo "<td class='int'>Descrizione</td>";
                    echo "<td class='int'>Modifica Comico</td>";
                    echo "<td class='int'>Elimina Comico</td>";
                    echo "</th>";
                    
                    while ($row = pg_fetch_assoc($res)) {
                        $id = $row['id'];
                        echo "<tr>";

                        foreach($row as $key => $value) {
                            // echo $row[$key];
                            // echo "<br>";
                            if (str_contains($key, '_')) {
                                $campi_chiave = explode('_', $key);

                                switch ($key) {
                                    case 'nome_comico':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo $value;
                                        echo "</td>";
                                        break;
                                    case 'cognome_comico':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo $value;
                                        echo "</td>";
                                        break;
                                        break;
                                    
                                }
                            } else {
                                switch ($key) {
                                    case 'id':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo $conta2;
                                        echo "</td>";
                                        break;
                                    case 'profilo':
                                        $sql = "SELECT encode(profilo, 'base64') AS img FROM eventi.comici AS c WHERE c.id = $1";
                                        $res2 = pg_prepare($connection, "", $sql);
                                        $res2 = pg_execute($connection, "", array($id));
                                        $row2 = pg_fetch_assoc($res2);

                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo "<button type='button' class = 'btn btn-info' onclick='mostraFoto(".$id.")'>";
                                        echo "Mostra";
                                        echo "</button>";
                                        echo "</td>";

                                        echo "<div id = 'pannelloFoto".$id."' class = 'pannelloFoto' data-pannello='false'>";
                                        echo '<img src="data:image/jpg;base64,'.$row2["img"].'"><br><br>';
                                        echo "<button type = 'button' class = 'btn btn-info' onclick='chiudiFoto(".$id.")'>";
                                        echo "Chiudi";
                                        echo "</button>";
                                        echo "</div>";

                                        break;
                                    case 'bio':
                                        echo "<td class = 'table-".$tipo[$conta]."'>";
                                        echo "<button type='button' class = 'btn btn-primary' onclick = 'mostraDesc(".$id.")'>";
                                        echo "Mostra";
                                        echo "</button>";
                                        echo "</td>";

                                        echo "<div id = 'pannelloDesc".$id."' class = 'pannelloDesc' data-pannello='false'>";
                                        echo $value;
                                        echo "<br><br>";
                                        echo "<button type = 'button' class = 'btn btn-primary' onclick='chiudiDesc(".$id.")'>";
                                        echo "Chiudi";
                                        echo "</button>";
                                        echo "</div>";

                                        break;
                                }
                            }
                        }

                        echo "<td class = 'table-".$tipo[$conta]."'>";
                        echo "<form action = 'modifica_comico.php' method = 'POST'>";
                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
                        echo "<input type = 'submit' class = 'btn btn-warning' value = 'Modifica' />";
                        echo "</form>";
                        echo "</td>";

                        echo "<td class = 'table-".$tipo[$conta]."'>";
                        echo "<form action = 'conf_elim_comico.php' method = 'POST'>";
                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
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
            -->

            <!--
            <?php
                include_once('../../script/connection.php');

                $query = "SELECT * FROM eventi.eventi AS e ORDER BY e.data_evento";
                $res = pg_prepare($connection, "", $query);
                $res = pg_execute($connection, "", array());

                if (!$res) {
                    echo "<h4>Errore nella visualizzazione degli eventi creati.</h4>";
                } else {
                    echo "<ul class='"."list-group"."'>";
                    while ($row = pg_fetch_assoc($res)) {
                        $codice = $row['codice'];

                        foreach ($row as $key => $value) {
                            if (str_contains($key, '_')) {
                                $campi_chiave = explode('_', $key);

                                switch ($key) {
                                    case 'nome_evento':
                                        echo "<li class='"."list-group-item"."'>";
                                        echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                                        echo "<br><br><button onclick='mostra_mod(\"nome_evento\", \"".$codice."\")' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_nome_evento_".$codice."' name = 'myForm_nome_evento_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
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
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_data_evento_".$codice."' name = 'myForm_data_evento' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
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
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_luogo_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
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
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_descrizione_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
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
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_immagine_".$codice."' action = '../../script/gestione_eventi/modifica_evento.php' enctype = 'multipart/form-data' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
                                        echo "<input type = 'file' class = 'form-control' id = 'immagine' name = 'immagine' placeholder = 'Reinserisci immagine' required/>";
                                        echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                                        echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                        echo "</form>";
    
                                        echo "</li>";
                                        break;
                            }
                        }
                    }
                    echo "</ul><br>";

                    echo "<form action = 'conferma_eliminazione.php' method = 'POST'>";
                    echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                    echo "<input type = 'submit' class = 'btn btn-danger' value = 'Elimina evento' />";
                    echo "</form>";

                    echo "<br><hr><br><br>";
                }  
            }

            pg_close($connection);
            ?>
            -->
            <br>
            <br>

        </div>
    </div>

</body>
</html>