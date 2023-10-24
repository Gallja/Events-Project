<!DOCTYPE html>
<html lang = ita>
<head>
    <title>Modifica Artisti Affiliati</title>
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
                        <a class="nav-link" href="home_admin.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="artistiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Artisti</a>
                        <div class="dropdown-menu" aria-labelledby="artistiDropdown">
                            <a class="dropdown-item" href="../comici/insert_comico.php">Comici</a>
                            <a class="dropdown-item" href="../musicisti/insert_musicista.php">Musicisti</a>
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
                    <input id = "input_ricerca" class="form-control mr-sm-2" type="search" placeholder="Cerca" aria-label="Search">
                    <button onclick = "ricerca()" id = "input_bottone" class="btn btn-outline-success my-2 my-sm-0">Cerca</button>
                </div>
            </div>
        </nav>

        <br>
        <h3>Artisti affiliati all'evento selezionato:</h3>
        <br>
        
        <?php
            if (isset($_POST['codice'])) {
                $codice = $_POST['codice'];
                $_SESSION['codice_evento'] = $codice;

                include_once('../../../script/management/connection.php');

                $query = "SELECT ec.comico AS id_comico, c.nome_comico, c.cognome_comico
                          FROM eventi.comici AS c
                          INNER JOIN eventi.eventi_comici AS ec
                          ON c.id = ec.comico
                          WHERE ec.evento = $1";
                $res = pg_prepare($connection, "", $query);
                $res = pg_execute($connection, "", array($codice));

                $query2 = "SELECT em.musicista AS id_musicista, m.nome_musicista
                           FROM eventi.musicisti AS m
                           INNER JOIN eventi.eventi_musicisti AS em
                           ON m.id_musicista = em.musicista
                           WHERE em.evento = $1";
                $res2 = pg_prepare($connection, "", $query2);
                $res2 = pg_execute($connection, "", array($codice));

                if (!$res || !$res2) {
                    echo "<h4>Errore nella visualizzazione dei comici o dei musicisti dell'evento.</h4>";
                } else {
                    echo "<ul class = 'list-group'>";
                    while ($row = pg_fetch_assoc($res)) {
                        echo "<li class = 'list-group-item'>";
                        echo "<div id = 'divArtisti'>";
                        foreach ($row as $key => $value) {
                            switch ($key) {
                                case 'nome_comico':
                                    echo $value." ";
                                    break;
                                case 'cognome_comico':
                                    echo $value;
                                    break;
                                case 'id_comico':
                                    $codice_comico = $value;
                                    break;
                            }
                        }
                        echo "<form action = '../../../script/gestione_eventi/elimina_artista.php' method = 'POST'>";

                        echo "<input type = 'hidden' name = 'codice_evento' value = '".$codice."' />";
                        echo "<input type = 'hidden' name = 'codice_comico' value = '".$codice_comico."' />";
                        echo "<input type = 'submit' class = 'btn btn-danger' id = 'eliminaArt' value = 'Elimina dall evento' />";

                        echo "</form>";

                        echo "</div>";
                        echo "</li>"; 
                    }                   
                    echo "</ul>";

                    echo "<ul class = 'list-group'>";
                    while ($row2 = pg_fetch_assoc($res2)) {
                        echo "<li class = 'list-group-item'>";
                        echo "<div id = 'divArtisti'>";
                        foreach ($row2 as $key => $value) {
                            switch ($key) {
                                case 'nome_musicista':
                                    echo $value;
                                    break;
                                case 'id_musicista':
                                    $codice_mus = $value;
                                    break;
                            }
                        }
                        echo "<form action = '../../../script/gestione_eventi/elimina_artista.php' method = 'POST'>";

                        echo "<input type = 'hidden' name = 'codice_evento' value = '".$codice."' />";
                        echo "<input type = 'hidden' name = 'codice_mus' value = '".$codice_mus."' />";
                        echo "<input type = 'submit' class = 'btn btn-danger' id = 'eliminaArt' value = 'Elimina dall evento' />";

                        echo "</form>";

                        echo "</div>";

                        echo "</li>";
                    }
                    echo "</ul>"; 
                }
            } else {
                echo "<h3>Errore nella ricerca dell'evento da rimuovere</h3><br>";
            }
        ?>

            <br><br><br>

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

            <hr>

            <a href = "home_admin.php">
                <button class = "btn btn-primary">Homepage</button>
            </a>

            <br><br>

        </div>
    </div>
</body>
</html>