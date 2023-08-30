<!DOCTYPE html>
<html lang = ita>
<html>
<head>
    <title>Home Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href = "../../style/style.css">
</head>
<body>

    <?php
        include_once('../../script/check_login.php');
    ?>

    <div class = "container d-flex align-items-center centrato">
        <div class = "text-center">
            <h1>BENVENUTO!</h1>

            <br>
            <br>

            <h3>Inserisci un nuovo evento:</h3>
            <form class = "form-group" method = "POST" action = "../../script/gestione_eventi/insert_evento.php" enctype = "multipart/form-data">
                <input type = "text" class = "form-control" id = "nome_evento" name = "nome_evento" placeholder = "Inserisci il nome dell'evento" required>
                <input type = "date" class = "form-control" id = "data" name = "data" placeholder = "Inserisci la data" required>
                <input type = "luogo" class = "form-control" id = "luogo" name = "luogo" placeholder = "Inserisci il luogo" required>
                <input type = "file" class = "form-control" id = "img" name = "img" required>
                <textarea class = "form-control" id = "descrizione" name = "descrizione" placeholder = "Inserisci la descrizione" required></textarea>
                <br>
                <input type = "submit" class="btn btn-primary" value = "INSERISCI">
            </form>

            <br>
            <br>
            <hr>

            <h3>Tutti gli eventi creati:</h3>
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
    
                                        echo '<img src="data:image/jpg;base64,'.$row2["img"].'">';

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

                    echo "<br><hr><br>";
                }  
            }

            pg_close($connection);
            ?>

            <br>
            <br>

            <div id = "div_bottoni">

                <form action = "cambio_pw.php" method = "POST">
                    <button type = "submit" class="btn btn-primary" >CAMBIA PASSWORD</button>
                </form>

                <form action = "../../script/logout.php" method = "GET">
                    <button type = "submit" class="btn btn-primary" >LOGOUT</button>
                </form>

            </div>

            <br>

        </div>
    </div>

    <script>
        function mostra_mod(contenuto, codice) {
            var form_completo = "myForm_" + contenuto + "_" + codice;
            // console.log(form_completo);
            var form = document.getElementById(form_completo);
            
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>

</body>
</html>