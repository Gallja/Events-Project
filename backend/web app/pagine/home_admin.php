<!DOCTYPE html>
<html>
<head>
    <title>Home Admin</title>
</head>
<body>
    <?php
        include_once('../script/check_login.php');
    ?>
    <h1>BENVENUTO!</h1>

    <br>
    <br>

    <h3>Inserisci un nuovo evento:</h3>
    <form method = "POST" action = "../script/gestione_eventi/insert_evento.php" enctype = "multipart/form-data">
        <input type = "text" id = "nome_evento" name = "nome_evento" placeholder = "Inserisci il nome dell'evento" required>
        <input type = "date" id = "data" name = "data" placeholder = "Inserisci la data" required>
        <input type = "luogo" id = "luogo" name = "luogo" placeholder = "Inserisci il luogo" required>
        <input type = "file" id = "img" name = "img" placeholder = "Inserisci l'immagine" required>
        <input type = "text" id = "descrizione" name = "descrizione" placeholder = "Inserisci la descrizione" required>
        <input type = "submit" value = "INSERISCI">
    </form>

    <br>
    <br>

    <form action = "../script/logout.php" method = "GET">
        <button type = "submit">LOGOUT</button>
    </form>
</body>
</html>