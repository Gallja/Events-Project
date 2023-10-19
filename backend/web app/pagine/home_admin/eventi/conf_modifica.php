<!DOCTYPE html>
<html lang = ita>
    <head>
        <title>Conferma Modifica</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel = "stylesheet" href = "../../../style/style_conf.css">
    </head>
    <body>
        <div id = "centro">
            <?php
                include_once('../../../script/check_login.php');

                if (isset($_SESSION['modifica_nome'])) {
                    echo "<h2>".$_SESSION['modifica_nome']."</h2><br>";
                    unset($_SESSION['modifica_nome']);
                }

                if (isset($_SESSION['modifica_data'])) {
                    echo "<h2>".$_SESSION['modifica_data']."</h2><br>";
                    unset($_SESSION['modifica_data']);
                }

                if (isset($_SESSION['modifica_luogo'])) {
                    echo "<h2>".$_SESSION['modifica_luogo']."</h2><br>";
                    unset($_SESSION['modifica_luogo']);
                }

                if (isset($_SESSION['modifica_immagine'])) {
                    echo "<h2>".$_SESSION['modifica_immagine']."</h2><br>";
                    unset($_SESSION['modifica_immagine']);
                }

                if (isset($_SESSION['modifica_desc'])) {
                    echo "<h2>".$_SESSION['modifica_desc']."</h2><br>";
                    unset($_SESSION['modifica_desc']);
                }

                if (isset($_SESSION['errore_mod'])) {
                    echo "<h2>".$_SESSION['errore_mod']."</h2><br>";
                    unset($_SESSION['errore_mod']);
                }
            ?>

            <h4>Torna alla pagina precedente:</h4>

            <br>
            <br>

            <form action = "home_admin.php">
                <input type = "submit" class = "btn btn-primary" value = "Torna alla Home" />
            </form>
        </div>
    </body>
</html>