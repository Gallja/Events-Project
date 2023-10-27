<!DOCTYPE html>
<html lang = ita>
<head>
    <title>Inserisci Musicista</title>
    <link rel="icon" type="image/png" href="../../../img/icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href = "../../../style/style.css">
    <script src = "../../../js/script.js"></script>
</head>
<body>

    <?php
        include_once('../../../script/management/check_login.php');
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
                                <a class="nav-link" href="../eventi/home_admin.php">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="artistiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Artisti</a>
                            <div class="dropdown-menu" aria-labelledby="artistiDropdown">
                                <a class="dropdown-item" href="../comici/insert_comico.php">Comici</a>
                                <a class="dropdown-item" href="insert_musicista.php">Musicisti</a>
                            </div>
                            </li>    
                            <li class="nav-item">
                                    <a class="nav-link" href="../archivio_eventi/eventi_passati.php">Archivio eventi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../pw/cambio_pw.php">Cambia password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../../script/logout.php">Loguot</a>
                            </li>
                        </ul>
                        <div class="row justify-content-center align-items-center" id = "div_search">
                            <input id = "input_ricerca" class="form-control mr-sm-2" type="search" placeholder="Cerca musicista" aria-label="Search">
                            <button onclick = "ricerca()" id = "input_bottone" class="btn btn-outline-success my-2 my-sm-0">Cerca</button>
                        </div>
                    </div>
            </nav>
            
            <br>

            <h3>Inserisci un nuovo musicista nel sistema:</h3>
            <form class = "form-group" method = "POST" action = "../../../script/gestione_musicisti/script_insert_musicista.php" enctype = "multipart/form-data">
                <input type = "text" class = "form-control" id = "nome_mus1" name = "nome_mus" placeholder = "Inserisci il nome del musicista" required>
                <input type = "file" class = "form-control" id = "profilo" name = "profilo" required>
                <textarea class = "form-control" id = "bio" name = "bio" placeholder = "Inserisci la bio del comico" required></textarea>
                <br>
                <input type = "submit" class="btn btn-primary" value = "INSERISCI">
            </form>

            <br>
            <br>
            <hr>

            <h3>Tutti i musicisti affiliati:</h3>

            <?php
                include_once('../../../script/management/connection.php');

                $query = "SELECT * FROM eventi.musicisti";
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
                    echo "<td class='int'>Nome d'arte</td>";
                    echo "<td class='int'>Foto Profilo</td>";
                    echo "<td class='int'>Descrizione</td>";
                    echo "<td class='int'>Modifica Musicista</td>";
                    echo "<td class='int'>Elimina Musicista</td>";
                    echo "</th>";
                    
                    while ($row = pg_fetch_assoc($res)) {
                        $id = $row['id_musicista'];
                        echo "<tr>";

                        foreach($row as $key => $value) {
                            switch ($key) {
                                case 'nome_musicista':
                                    echo "<td class = 'table-".$tipo[$conta]."'>";
                                    echo $value;
                                    echo "</td>";
                                    break;
                            
                                case 'id_musicista':
                                    echo "<td class = 'table-".$tipo[$conta]."'>";
                                    echo $conta2;
                                    echo "</td>";
                                    break;
                                case 'profilo_musicista':
                                    $sql = "SELECT encode(profilo_musicista, 'base64') AS img FROM eventi.musicisti AS m WHERE m.id_musicista = $1";
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
                                case 'bio_musicista':
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

                        echo "<td class = 'table-".$tipo[$conta]."'>";
                        echo "<form action = 'modifica_musicista.php' method = 'POST'>";
                        echo "<input type = 'hidden' id = 'id' name = 'id' value = '".$id."' />";
                        echo "<input type = 'submit' class = 'btn btn-warning' value = 'Modifica' />";
                        echo "</form>";
                        echo "</td>";

                        echo "<td class = 'table-".$tipo[$conta]."'>";
                        echo "<form action = 'conf_elim_mus.php' method = 'POST'>";
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