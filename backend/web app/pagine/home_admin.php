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

    <form action = "../script/logout.php" method = "GET">
        <button type = "submit">LOGOUT</button>
    </form>
</body>
</html>