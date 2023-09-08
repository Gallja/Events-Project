<!DOCTYPE html>
<html lang = ita>
<head>
    <title>Inserisci comico</title>
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

            <h3>Inserisci un nuovo comico nel sistema:</h3>
            <form class = "form-group" method = "POST" action = "../../script/gestione_comici/script_insert_comico.php" enctype = "multipart/form-data">
                <input type = "text" class = "form-control" id = "nome_comico1" name = "nome_comico" placeholder = "Inserisci il nome del comico" required>
                <input type = "text" class = "form-control" id = "cognome_comico1" name = "cognome_comico" placeholder = "Inserisci il cognome del comico" required>
                <input type = "file" class = "form-control" id = "profilo" name = "profilo" required>
                <textarea class = "form-control" id = "bio" name = "bio" placeholder = "Inserisci la bio del comico" required></textarea>
                <br>
                <input type = "submit" class="btn btn-primary" value = "INSERISCI">
            </form>

            <br>
            <br>
            <hr>

            <h3>Tutti i comici affiliati:</h3>

            <?php
                include_once('../../script/connection.php');

                $query = "SELECT * FROM eventi.comici AS c ORDER BY c.cognome_comico";
                $res = pg_prepare($connection, "ris", $query);
                $res = pg_execute($connection, "ris", array());

                if (!$res) {
                    echo "<h4>Errore nella visualizzazione dei comici nel sistema.</h4>";
                } else {
                    echo "<ul class='"."list-group"."'>";
                    while ($row = pg_fetch_assoc($res)) {
                        $id = $row['id'];

                        foreach ($row as $key => $value) {
                            if (str_contains($key, '_')) {
                                $campi_chiave = explode('_', $key);

                                switch ($key) {
                                    case 'nome_comico':
                                        echo "<li class='"."list-group-item"."'>";
                                        echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                                        echo "<br><br><button onclick='mostra_mod(\"nome_comico\", \"".$id."\")' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_nome_comico_".$id."' name = 'myForm_nome_comico_".$id."' action = '../../script/gestione_comici/modifica_comico.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
                                        echo "<input type = 'text' class = 'form-control' id = 'nome_comico' name = 'nome_comico' placeholder = 'Reinserisci il nome' required />";
                                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
                                        echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma' />";
                                        echo "</form>";
                                        echo "</li>";
                                        break;
                                    case 'cognome_comico':
                                        echo "<li class='"."list-group-item"."'>";
                                        echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                                        echo "<br><br><button onclick='mostra_mod(\"cognome_comico\", \"".$id."\")' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_cognome_comico_".$id."' name = 'myForm_cognome_comico_".$id."' action = '../../script/gestione_comici/modifica_comico.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
                                        echo "<input type = 'text' class = 'form-control' id = 'cognome_comico' name = 'cognome_comico' placeholder = 'Reinserisci il cognome' required />";
                                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
                                        echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma' />";
                                        echo "</form>";
                                        echo "</li>";
                                        break;
                                }
                            } else {
                                switch ($key) {
                                    case 'profilo':
                                        $sql = "SELECT encode(profilo, 'base64') AS img FROM eventi.comici AS c WHERE c.id = $1";
                                        $res2 = pg_prepare($connection, "", $sql);
                                        $res2 = pg_execute($connection, "", array($id));
                                        $row2 = pg_fetch_assoc($res2);
    
                                        echo "<li class='"."list-group-item"."'>";
    
                                        echo '<br><img src="data:image/jpg;base64,'.$row2["img"].'">';

                                        echo "<br><br><button onclick='"."mostra_mod(\"profilo\", \"".$id."\")"."' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_profilo_".$id."' action = '../../script/gestione_comici/modifica_comico.php' enctype = 'multipart/form-data' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
                                        echo "<input type = 'file' class = 'form-control' id = 'profilo' name = 'profilo' placeholder = 'Reinserisci immagine profilo' required/>";
                                        echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$id."' />";
                                        echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                        echo "</form>";
    
                                        echo "</li>";
                                        break;
                                    case 'bio':
                                        echo "<li class='"."list-group-item"."'>";
                                        echo strtoupper($key).": ".$value;

                                        echo "<br><br><button onclick='"."mostra_mod(\"bio\", \"".$id."\")"."' class = 'btn btn-secondary'>Modifica</button><br><br>";
                                        echo "<form class = 'form-group' method = 'POST' id = 'myForm_bio".$id."' action = '../../script/gestione_comici/modifica_comico.php' style = 'display: none;'>"; // Form da far comparire dopo aver premuto il bottone
                                        echo "<textarea class = 'form-control' id = 'bio' name = 'bio' placeholder = 'Reinserisci la bio' required></textarea>";
                                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
                                        echo "<br><input type = 'submit' class = 'btn btn-success' value = 'Conferma'/>";
                                        echo "</form>";

                                        echo "</li>";
                                        break;
                                        break;
                                }
                            }
                        }
                        echo "</ul><br>";

                        echo "<form action = 'conferma_eliminazione_comico.php' method = 'POST'>";
                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
                        echo "<input type = 'submit' class = 'btn btn-danger' value = 'Elimina comico' />";
                        echo "</form>";

                        echo "<br><hr><br><br>";
                    }
                }

                pg_close($connection);
            ?>
        </div>
    </div>
    
</body>
</html>