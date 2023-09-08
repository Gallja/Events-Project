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
        </div>
    </div>
    
</body>
</html>