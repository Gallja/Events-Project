<!DOCTYPE html>
<html>
<head>
    <title>Home Admin</title>
    <link rel = "stylesheet" href = "../../style/style.css">
</head>
<body>
    <?php
        include_once('../../script/check_login.php');
    ?>
    <h1>BENVENUTO!</h1>

    <br>
    <br>

    <h3>Inserisci un nuovo evento:</h3>
    <form method = "POST" action = "../../script/gestione_eventi/insert_evento.php" enctype = "multipart/form-data">
        <input type = "text" id = "nome_evento" name = "nome_evento" placeholder = "Inserisci il nome dell'evento" required>
        <input type = "date" id = "data" name = "data" placeholder = "Inserisci la data" required>
        <input type = "luogo" id = "luogo" name = "luogo" placeholder = "Inserisci il luogo" required>
        <input type = "file" id = "img" name = "img" required>
        <input type = "text" id = "descrizione" name = "descrizione" placeholder = "Inserisci la descrizione" required>
        <input type = "submit" value = "INSERISCI">
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
            echo "<ul>";
            while ($row = pg_fetch_assoc($res)) {
                $codice = $row['codice'];

                $img_bytea = $row['immagine'];
                $img_b64 = base64_encode($img_bytea);
                foreach ($row as $key => $value) {
                    if (str_contains($key, '_')) {
                        $campi_chiave = explode('_', $key);
                        echo "<li>";
                        echo strtoupper($campi_chiave[0])." ".strtoupper($campi_chiave[1]).": ".$value;
                        echo "</li>";
                    } else {
                        if ($key != "immagine") {
                            echo "<li>";
                            echo strtoupper($key).": ".$value;
                            echo "</li>";
                        } else {
                            $sql = "SELECT encode(immagine, 'base64') AS img FROM eventi.eventi AS e WHERE e.codice = $1";
                            $res2 = pg_prepare($connection, "", $sql);
                            $res2 = pg_execute($connection, "", array($codice));
                            $row2 = pg_fetch_assoc($res2);

                            echo "<li>";

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

    <form action = "../script/logout.php" method = "GET">
        <button type = "submit">LOGOUT</button>
    </form>
</body>
</html>