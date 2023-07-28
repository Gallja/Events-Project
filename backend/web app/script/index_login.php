<?php
    session_start();
    
    if (isset($_POST["email"]) && isset($_POST["pw"])) {
        include_once('../script/connection.php'); 
        $sql = "SELECT * FROM eventi.autenticazione($1, $2)";
        $res = pg_prepare($connection, "get_all_esito_attesa_acc", $sql);

        $res = pg_execute($connection, "get_all_esito_attesa_acc", array($_POST["email"], $_POST["pw"]));

        $row = pg_fetch_assoc($res);
        pg_close($connection);
        
        if ($row["email"] === null) {
            $_SESSION['autenticazione_fallita'] = "Credenziali non corrette, riprova";
            header('Location: ../pagine/home.php');
        } else {
            $_SESSION['isLogin'] = true;

            header('Location: ../pagine/home_admin.php');
        }
}
?>