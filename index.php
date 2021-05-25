<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning Together</title>
    <link rel="icon" href="images/Ptogether.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./style.css">
    <script src="https://kit.fontawesome.com/fa878af576.js" crossorigin="anonymous"></script>
    <script lang="javascript" src="script.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Girassol&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>

    <?php
    // connessione al DB
    $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
    $password = $username = "";
    session_start();
    if (isset($_SESSION['id']) && $_SESSION['id']) session_unset();
    session_commit();

    // gestione LOGIN
    if (isset($_POST["loginButton"])) {
        $username = $_POST["usernameLogin"];
        $q1 = "SELECT * FROM users WHERE username = $1";
        $res = pg_query_params($dbconn, $q1, array($username));

        if (!($line = pg_fetch_array($res, null, PGSQL_ASSOC))) {
            echo "<script>erroreLogin()</script>";
            echo '<div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Errore!</strong> Nome utente o password errati!
            </div>';
        } else {
            $password = md5($_POST['passLogin']);
            $q2 = "SELECT * FROM users WHERE username = $1 and password = $2";
            $res = pg_query_params($dbconn, $q2, array($username, $password));
            if (!($line = pg_fetch_array($res, null, PGSQL_ASSOC))) {
                echo "<script>erroreLogin()</script>";
                echo '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Errore!</strong> Nome utente o password errati!
                </div>';
            } else {
                session_start();
                $_SESSION['id'] = $line['id'];
                $_SESSION['username'] = $line['username'];
                session_commit();
                header("Location: homepage/welcome.php");
            }
        }
        pg_free_result($res); //libera la memoria

    // gestione SIGNIN
    } else if (isset($_POST["signinButton"])) {
        $username = $_POST["userSignin"];
        $q1 = "SELECT * FROM users WHERE username = $1";
        $res = pg_query_params($dbconn, $q1, array($username));

        if (($line = pg_fetch_array($res, null, PGSQL_ASSOC))) {
            echo "<script>erroreRegistrazione()</script>";
            echo '<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Errore!</strong> Username già usato!
          </div>';
        } else {
            $password = md5($_POST['passSignin']);
            $q2 = "INSERT INTO users (id, username, password) VALUES (DEFAULT, $1, $2)";
            if ($res = pg_query_params($dbconn, $q2, array($username, $password))) {
                echo '<div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Complimenti!</strong> La registrazione è andata a buon fine!
              </div>';
            } else {
                echo "Si è verificato un errore";
            }
        }
        pg_free_result($res); //libera la memoria
    }


    pg_close($dbconn); //disconnette


    //correzione degli input
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>



    <!--NAVBAR-->
    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand main-title" href="#">
            <img id="logo" src="./images/Ptogether.png" width="85px" height="85px" alt="Ptogether">
            <span class="ml-3" id="titolo">Planning Together</span>
        </a>


        <div class="mr-3 nav-item btn-group">
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModalLogin" onclick="return compila()">Login</button>
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModalSignin">Registrati</button>
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModalSearch"><i class="fa fa-search"></i> Cerca il tuo evento</button>
        </div>

        <script>
            $("#logo").mouseover(function() {
                $(this).animate({
                    height: "95px",
                    width: "95px"
                }, "fast");
            });
            $("#logo").mouseleave(function() {
                $(this).animate({
                    height: "85px",
                    width: "85px"
                }, "fast");
            });
            $(document).ready(function() {
                $("#titolo").hide().fadeIn(2000).animate({
                    "font-size": "110%"
                });
                $("#titolo").animate({
                    "font-size": "100%"
                });
            });
        </script>

    </nav>


    <div id="mainPart">
        <!--CAROUSEL-->
        <div id="demo" class="carousel slide" data-ride="carousel">

            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/evento2.jpg" class="img-fluid img-thumbnail" alt="evento" width="100%" height="100%">
                    <span class="myCell shadow-lg p-4 mb-4" id="eventoText">Vuoi partecipare ad iniziative ed eventi?<br> Dai uno sguardo alla sezione Ricerca Eventi</span>
                </div>
                <div class="carousel-item">
                    <img src="images/planning2.jpg" class="img-fluid img-thumbnail" alt="planning" width="100%" height="100%">
                    <span class="myCell shadow-lg p-4 mb-4" id="planningText">Vuoi organizzare e pubblicizzare un evento?<br> Iscriviti al nostro sito!</span>
                </div>
                <div class="carousel-item">
                    <img src="images/personefelici.jpeg" class="img-fluid img-thumbnail" alt="persone felici" width="100%" height="100%">
                    <span class="myCell shadow-lg p-4 mb-4" id="personefeliciText">Divertirsi non è mai stato così semplice</span>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $(".myCell").hide();
                });

                $(".carousel-item").mouseenter(function() {
                    $(this).children("span").fadeIn("slow");
                });

                $(".carousel-item").mouseleave(function() {
                    $(this).children("span").fadeOut("slow");
                });
            </script>

            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>

        <!--FOOTER-->
        <footer class="text-center text-white">

            <div class="text-center text-dark p-3" style="background-color: rgba(255, 255, 255, 0.8);">
                <ul class="list-unstyled list-inline text-center">
                    <li class="list-inline-item">
                        <a class="btn-floating btn-fb mx-1" href="https://github.com/ZoSo9999" role="button">
                            <i class="fab fa-github"> </i> Filippo
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn-floating btn-tw mx-1" href="https://github.com/GitGab-dev" role="button">
                            <i class="fab fa-github"> </i> Gabriele
                        </a>
                    </li>
                </ul>
                <a href="http://www.diag.uniroma1.it/rosati/ltw/"> © Progetti LTW 2020/2021</a>
            </div>
        </footer>
    </div>



    <!--LOGIN MODAL-->
    <div class="modal fade" id="myModalLogin" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="myForm" id="logForm" onsubmit="return ricordami()">
                        <div class="form-group">
                            <label for="usernameLogin">Nome Utente</label>
                            <input type="text" class="form-control user" id="usernameLogin" name="usernameLogin" value="<?php echo $username; ?>" placeholder="Nome Utente" required>
                        </div>
                        <div class="form-group">
                            <label for="passLogin">Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control" id="passLogin" name="passLogin" placeholder="Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberBox">
                            <label class="form-check-label" for="rememberBox">Ricordami</label>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-blue" name="loginButton" data-toggle="modal" data-target="#myModalLogin">Login</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--SIGNIN MODAL-->
    <div class="modal fade" id="myModalSignin" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrazione</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="divErroreSignin"></div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="myForm" id="signForm" onsubmit="return controllaSignin()">
                        <div class="form-group">
                            <label for="userSignin">Nome Utente</label>
                            <input type="text" class="form-control user" id="userSignin" name="userSignin" placeholder="Digita un nome utente" maxlength="20" required>
                        </div>
                        <div class="form-group">
                            <label for="passSignin">Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control passSignin" id="passSignin" name="passSignin" placeholder="Scegli una password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control passSignin" id="passSigninBis" name="passSigninBis" placeholder="Ripeti la password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-blue" name="signinButton">Registrati</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--SEARCH MODAL-->
    <div class="modal fade" id="myModalSearch" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ricerca Evento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="divErroreSearch"></div>
                    <form action="ricercaevento/ricerca.php" method="POST" class="myForm" id="ricercaEvento" onsubmit="return controllaSearch()">
                        <div class="form-group">
                            <label for="cercaCategoria">Categoria</label>
                            <select id="cercaCategoria" name="cercaCategoria" class="form-control" autofocus>
                                <option selected value="default">Scegli...</option>
                                <option value="1">Musica</option>
                                <option value="2">Sport</option>
                                <option value="3">Escursionismo</option>
                                <option value="4">Varie</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cercaLuogo">Luogo</label>
                            <input list="provincia" class="form-control" id="cercaLuogo" name="cercaLuogo" required autocomplete="on">
                        </div>
                        <div class="form-group">
                            <label for="cercaDal">Dal</label>
                            <input type="date" class="form-control" id="cercaDal" name="cercaDal" required>
                            <br>
                            <label for="cercaAl">A</label>
                            <input type="date" class="form-control" id="cercaAl" name="cercaAl" required>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-blue" id="cercaSubmit">Cerca</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".modal").on("shown.bs.modal", function() {
            $(".user").trigger("focus");
        })
    
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>


    <!--LISTA DEI COMUNI-->
    <?php

    $filename = "./resources/comuniRidotto.csv";
    $classArray = array();

    if (($handle = fopen($filename, "r")) !== FALSE) {

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            foreach ($data as $v) {
                array_push($classArray, $v);
            }
        }
    }
    ?>

    <datalist id="provincia" name="provincia">
        <?php

        for ($i = 0; $i < count($classArray); $i++) {
            echo "<option value='$classArray[$i]'>$classArray[$i]</option>";
        }

        ?>
    </datalist>
</body>

</html>