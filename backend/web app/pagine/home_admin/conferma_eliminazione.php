<!DOCTYPE html>
<html lang = ita>
<html>
<head>
    <title>Home Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href = "../../style/style3.css">
</head>
<body>
    <?php
        include_once('../../script/check_login.php');
    ?>

    <div class = "container d-flex centrato">
        <div class = "text-center" id = "div_c">

            <h1>Conferma eliminazione</h1>
            <hr>

            <?php
                if (isset($_POST['codice'])) {
                    $codice = $_POST['codice'];

                    echo "<h3>Clicca su 'Conferma cancellazione' per confermare l'eliminazione dell'evento (TUTTI i dati e le modifiche andranno persi). Se vuoi tornare alla pagina precedente clicca su 'Indietro'</h3>";
                    echo "<form class = 'form-group' action = '../../script/gestione_eventi/elimina_evento.php' method = 'POST'>";
                    echo "<input type = 'hidden' id = 'codice' name = 'codice' value = '".$codice."' />";
                    echo "<input type = 'submit' class = 'btn btn-danger's value = 'Conferma cancellazione' />";
                    echo "</form>";
                    echo "<button type = 'submit' class = 'btn btn-success'>";
                    echo "Indietro";
                    echo "</button>";
                } else {
                    echo "<h3>Errore nella ricerca dell'evento da eliminare</h3>";
                    echo "<button type = 'submit' class = 'btn btn-success'>";
                    echo "Indietro";
                    echo "</button>";
                }
            ?>

        </div>
    </div>

</body>
</html>