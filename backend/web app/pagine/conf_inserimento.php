<!DOCTYPE html>
<html lang = "it">
    <head>
        <title>Inserimento evento</title>

    </head>
    <body>
        <?php
            include_once('../script/check_login.php');

            echo "<h2>".$_SESSION['inserimento']."<h2>";

            unset($_SESSION['inserimento']);
        ?>

        <h4>Torna alla pagina precedente:</h4>
        <form action = "home_admin.php">
            <input type = "submit" value = "Torna alla Home" />
        </form>
    </body>
</html>