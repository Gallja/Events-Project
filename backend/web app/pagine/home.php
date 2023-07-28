<!DOCTYPE html>
<html lang = ita>
    <head>
        <title>Eventi Login</title>
        
    </head>
    <body>
        <?php
            include_once("../script/check_not_login.php");

            if (isset($_SESSION['autenticazione_fallita'])) {
                echo "<p>".$_SESSION['autenticazione_fallita']."</p>";
                unset($_SESSION['autenticazione_fallita']);
            }
        ?>
        <form method = "POST" action = "../script/index_login.php">
            <input type = "text" id = "email" name = "email" placeholder = "Inserisci la mail" required>
            <input type = "password" id = "pw" name = "pw" placeholder = "Inserisci la password" required>
            <br>
            <input type = "submit" placeholder = "Log In">
        </form> 
    </body>
</html>