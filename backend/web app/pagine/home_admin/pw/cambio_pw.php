<!DOCTYPE html>
<html lang = ita>
    <head>
        <title>Cambio Password</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src = "../../../js/script.js"></script>
        <link rel = "stylesheet" href = "../../../style/style_conf.css">
    </head>
    <body>
        <?php
            include_once('../../../script/management/check_login.php');
        ?>
        <div class = "container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand"">Benvenuto nella tua area riservata!</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="../eventi/home_admin.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="artistiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Artisti</a>
                            <div class="dropdown-menu" aria-labelledby="artistiDropdown">
                                <a class="dropdown-item" href="../comici/insert_comico.php">Comici</a>
                                <a class="dropdown-item" href="insert_musicista.php">Musicisti</a>
                            </div>
                        </li>    
                        <li class="nav-item">
                                <a class="nav-link" href="../archivio_eventi/eventi_passati.php">Archivio eventi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cambio_pw.php">Cambia password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../../script/logout.php">Loguot</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <br>
            <br>

            <div id = "centro">

                <?php
                    if (isset($_SESSION['cambiamento_fallito'])) {
                        echo "<p>".$_SESSION['cambiamento_fallito']."</p>";
                        unset($_SESSION['cambiamento_fallito']);
                    } else {
                        if (isset($_SESSION['cambiamento_avvenuto'])) {
                            echo "<p>".$_SESSION['cambiamento_avvenuto']."</p>";
                            unset($_SESSION['cambiamento_avvenuto']);
                        }
                    }
                ?>

                <h4>Compila il seguente modulo per cambiare la password:</h4><br>

                <form class = "form-group" method = "POST" action = "../../../script/change_pw/check_change_pw.php" id = "form-change">
                    <div class = "input-group">
                        <span class = "input-group-text">
                            <i class = "fa fa-user fa-lg"></i>
                        </span>
                        <input type = "text" id = "mail" name = "mail" placeholder = "Indirizzo email" required />
                    </div>
                    <br>
                    <br>
                    <div class = "input-group" id = "isPw">
                        <span class = "input-group-text" onclick = "mostraPassChange('old_pw')">
                            <i class = "fa fa-eye"></i>
                        </span>
                        <input type = "password" id = "old_pw" name = "old_pw" placeholder = "Password attuale" required />
                    </div>
                    <br>
                    <br>
                    <div class = "input-group" id = "isPw">
                        <span class = "input-group-text" onclick = "mostraPassChange('new_pw')">
                            <i class = "fa fa-eye"></i>
                        </span>
                        <input type = "password" id = "new_pw" name = "new_pw" placeholder = "Nuova password" required />
                    </div>
                    <br>
                    <br>
                    <div class = "input-group" id = "isPw">
                        <span class = "input-group-text" onclick = "mostraPassChange('conf_new_pw')">
                            <i class = "fa fa-eye"></i>
                        </span>
                        <input type = "password" id = "conf_new_pw" name = "conf_new_pw" placeholder = "Conferma password" required />
                    </div>
                    <br>
                    <br>
                    <input type = "submit" class = "btn btn-primary" value = "CAMBIA" />
                </form>
                
                <hr>
                <br>
            </div>

        </div>
    </body>
</html>