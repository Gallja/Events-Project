<!DOCTYPE html>
<html lang = ita>
    <head>
        <title>Eventi Registrazione</title>
        
    </head>
    <body>
        <?php
            session_start();
            if (isset($_SESSION['registrazione_fallita'])) {
                echo "<p>".$_SESSION['registrazione_fallita']."</p>";
                unset($_SESSION['registrazione_fallita']);
            }
        ?>
        <form method = "POST" action = "../script/index_registrazione.php">
            <input type = "text" id = "email" name = "email" placeholder = "Inserisci la mail" required>
            <input type = "password" id = "pw" name = "pw" placeholder = "Inserisci la password" required>
            <br>
            <input type = "submit" placeholder = "Registrati">
        </form> 

        <br>

        <a href = "home.php">Effettua il login</a>
    </body>
</html>