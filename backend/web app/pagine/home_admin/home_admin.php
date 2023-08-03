<!DOCTYPE html>
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
                <input type = "text" class = "form-control" id = "descrizione" name = "descrizione" placeholder = "Inserisci la descrizione" required>
                <br>
                <input type = "submit" class="btn btn-primary" value = "INSERISCI">
            </form>

            <br>
            <br>
            <hr>

            <h3>Tutti gli eventi creati:</h3>
            <?php
                include_once('../../script/connection.php');

                $query = "SELECT * FROM eventi.eventi";
                $res = pg_prepare($connection, "", $query);
                $res = pg_execute($connection, "", array());

                if (!$res) {
                    echo "<h4>Errore nella visualizzazione degli eventi creati.</h4>";
                } else {
                    echo "<ul class='"."list-group"."'>";
                    while ($row = pg_fetch_assoc($res)) {
                        $codice = $row['codice'];

                        $img_bytea = $row['immagine'];
                        $img_b64 = base64_encode($img_bytea);
                        foreach ($row as $key => $value) {
                            if (str_contains($key, '_')) {
                                $campi_chiave = explode('_', $key);
                                echo "<li class='"."list-group-item"."'>";
                                echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                                echo "</li>";
                            } else {
                                if ($key != "immagine") {
                                    echo "<li class='"."list-group-item"."'>";
                                    echo strtoupper($key).": ".$value;
                                    echo "</li>";
                                } else {
                                    $sql = "SELECT encode(immagine, 'base64') AS img FROM eventi.eventi AS e WHERE e.codice = $1";
                                    $res2 = pg_prepare($connection, "", $sql);
                                    $res2 = pg_execute($connection, "", array($codice));
                                    $row2 = pg_fetch_assoc($res2);

                                    echo "<li class='"."list-group-item"."'>";

                                    echo '<img src="data:image/jpg;base64,'.$row2["img"].'">';

                                    echo "</li>";
                                }
                            }
                        }
                        echo "<br><br>";
                    }
                    echo "</ul>";
                }

                pg_close($connection);
            ?>

            <br>
            <br>

            <form action = "../../script/logout.php" method = "GET">
                <button type = "submit" class="btn btn-primary" >LOGOUT</button>
            </form>

        </div>
    </div>
</body>
</html>