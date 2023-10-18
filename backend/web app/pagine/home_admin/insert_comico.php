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
            <br><br>
        </div>
    </div>
    
</body>
</html>