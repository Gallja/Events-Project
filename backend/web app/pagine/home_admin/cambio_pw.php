<!DOCTYPE html>
<html>
    <head>
        <title>Cambio Password</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel = "stylesheet" href = "../../style/style_conf.css">
    </head>
    <body>
        <?php
            include_once('../../script/check_login.php');
        ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand"">Benvenuto nella tua area riservata!</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="home_admin.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cambio_pw.php">Cambia password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../script/logout.php">Loguot</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <br>
            <br>

            <div id = "centro">

                <h4>Compila il seguente modulo per cambiare la password:</h4>

                <form class = "form-group" method = "POST" action = "../../script/check_change_pw.php" id = "form-change">
                    <input type = "password" id = "old_pw" name = "old_pw" placeholder = "Password attuale" required />
                    <br>
                    <br>
                    <input type = "password" id = "new_pw" name = "new_pw" placeholder = "Nuova password" required />
                    <br>
                    <br>
                    <input type = "password" id = "conf_new_pw" name = "conf_new_pw" placeholder = "Conferma password" required />
                    <br>
                    <br>
                    <input type = "submit" class = "btn btn-primary" value = "CAMBIA" />
                </form>
                
                <hr>
                <br>

                <form action = "home_admin.php" method = "GET">
                    <button type = "submit" class = "btn btn-primary">TORNA ALLA HOME</button>
                </form>
            </div>


    </body>
</html>