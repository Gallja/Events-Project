<!DOCTYPE html>
<html lang = ita>
    <head>
        <title>Eventi Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src = "../js/script.js"></script>
        <link rel = "stylesheet" href = "../style/style2.css">
    </head>
    <body>
        <div class = "container">
            <div class = "row">
                <div class = "col-md-6 mx-auto">
                    <div class = "text-center">

                        <h1>Login</h1>
                        <br>

                        <?php
                            include_once("../script/check_not_login.php");

                            if (isset($_SESSION['autenticazione_fallita'])) {
                                echo "<p>".$_SESSION['autenticazione_fallita']."</p>";
                                unset($_SESSION['autenticazione_fallita']);
                            }

                            if (isset($_SESSION['registrato'])) {
                                echo "<p>".$_SESSION['registrato']." Ora puoi effettuare il login:</p>";
                                unset($_SESSION['registrato']);
                            }
                        ?>

                        <form class="form-group" method="POST" action="../script/index_login.php">
                            <div class="form-centrato">
                                <div class = "input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-user fa-lg"></i>
                                    </span>
                                    <input type="text" class="form-control col-md-9" id="email" name="email" placeholder="Inserisci la mail" required>
                                </div>
                                
                                <div class="input-group" id="sPw">
                                    <span class="input-group-text" onclick = "mostraP()">
                                        <i class="fa fa-eye" id="showP"></i>
                                    </span>
                                    <input type="password" class="form-control col-md-9" id="pw" name="pw" placeholder="Inserisci la password" required>
                                </div>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary" value="Log In">
                        </form>
                        

                        <br>

                        <a href = "registrazione.php">Registrati se non hai un account</a>
                    
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
