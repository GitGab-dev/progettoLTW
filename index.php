<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning Together</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./style.css">
    <script src="https://kit.fontawesome.com/fa878af576.js" crossorigin="anonymous"></script>
    <script lang="javascript" src="script.js"></script>
    <!--FONT USATO-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Girassol&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>

    <?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
    $password = $username = "";
    session_start();
    if (isset($_SESSION['id']) && $_SESSION['id']) session_unset();
    session_commit();

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


    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>




    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand main-title" href="#">
            <img id="logo" src="./images/Ptogether.png" width="85px" height="85px" alt="Ptogether">
            <span class="ml-3">Planning Together</span>
        </a>


        <div class="mr-3 nav-item btn-group">
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModalLogin" onclick="return ricorda()">Login</button>
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModalSignin">Registrati</button>
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModalSearch"><i class="fa fa-search"></i> Cerca il tuo evento</button>
        </div>

        <script>
            $("#logo").mouseover(function() {
                $(this).animate({
                    height: "11%",
                    width: "11%"
                }, "fast");
            });
            $("#logo").mouseleave(function() {
                $(this).animate({
                    height: "10%",
                    width: "10%"
                }, "fast");
            });
        </script>

    </nav>

    <div id="mainPart">
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
        <footer class="text-center text-white">
            <div class="text-center text-dark p-3" style="background-color: rgba(255, 255, 255, 0.8);">
                © 2021 Copyright by Filippo & Gabriele: Progetti LTW 2020/2021
            </div>
        </footer>
    </div>




    <div class="modal fade" id="myModalLogin" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="myForm" id="logForm" onsubmit="return controllaLogin()">
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
                                <input type="password" class="form-control" id="passSignin" name="passSignin" placeholder="Scegli una password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="passSigninBis">Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control" id="passSigninBis" name="passSigninBis" placeholder="Ripeti la password" required>
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
    </script>

    <script>
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


    <datalist id="provincia" name="provincia">
        <option value="Agrigento">Agrigento</option>
        <option value="Alessandria">Alessandria</option>
        <option value="Ancona">Ancona</option>
        <option value="Aosta">Aosta</option>
        <option value="Arezzo">Arezzo</option>
        <option value="Ascoli Piceno">Ascoli Piceno</option>
        <option value="Asti">Asti</option>
        <option value="Avellino">Avellino</option>
        <option value="Bari">Bari</option>
        <option value="Barletta-Andria-Trani">Barletta-Andria-Trani</option>
        <option value="Belluno">Belluno</option>
        <option value="Benevento">Benevento</option>
        <option value="Bergamo">Bergamo</option>
        <option value="Biella">Biella</option>
        <option value="Bologna">Bologna</option>
        <option value="Bolzano">Bolzano</option>
        <option value="Brescia">Brescia</option>
        <option value="Brindisi">Brindisi</option>
        <option value="Cagliari">Cagliari</option>
        <option value="Caltanissetta">Caltanissetta</option>
        <option value="Campobasso">Campobasso</option>
        <option value="Carbonia-iglesias">Carbonia-iglesias</option>
        <option value="Caserta">Caserta</option>
        <option value="Catania">Catania</option>
        <option value="Catanzaro">Catanzaro</option>
        <option value="Chieti">Chieti</option>
        <option value="Como">Como</option>
        <option value="Cosenza">Cosenza</option>
        <option value="Cremona">Cremona</option>
        <option value="Crotone">Crotone</option>
        <option value="Cuneo">Cuneo</option>
        <option value="Enna">Enna</option>
        <option value="Fermo">Fermo</option>
        <option value="Ferrara">Ferrara</option>
        <option value="Firenza">Firenze</option>
        <option value="Foggia">Foggia</option>
        <option value="Forlì">Forl&igrave;-Cesena</option>
        <option value="Frosinone">Frosinone</option>
        <option value="Genova">Genova</option>
        <option value="Gorizia">Gorizia</option>
        <option value="Grosseto">Grosseto</option>
        <option value="Imperia">Imperia</option>
        <option value="Isernia">Isernia</option>
        <option value="La spezia">La spezia</option>
        <option value="L'Aquila">L'aquila</option>
        <option value="Latina">Latina</option>
        <option value="Lecce">Lecce</option>
        <option value="Lecco">Lecco</option>
        <option value="Livorno">Livorno</option>
        <option value="Lodi">Lodi</option>
        <option value="Lucca">Lucca</option>
        <option value="Macerata">Macerata</option>
        <option value="Mantova">Mantova</option>
        <option value="Massa-Carrara">Massa-Carrara</option>
        <option value="Matera">Matera</option>
        <option value="Medio Campidano">Medio Campidano</option>
        <option value="Messina">Messina</option>
        <option value="Milano">Milano</option>
        <option value="Modena">Modena</option>
        <option value="Monza e della Brianza">Monza e della Brianza</option>
        <option value="Napoli">Napoli</option>
        <option value="Novara">Novara</option>
        <option value="Nuoro">Nuoro</option>
        <option value="Ogliastra">Ogliastra</option>
        <option value="Olbia-Tempio">Olbia-Tempio</option>
        <option value="Oristano">Oristano</option>
        <option value="Padova">Padova</option>
        <option value="Palermo">Palermo</option>
        <option value="Parma">Parma</option>
        <option value="Pavia">Pavia</option>
        <option value="Perugia">Perugia</option>
        <option value="Pesaro e Urbino">Pesaro e Urbino</option>
        <option value="Pescara">Pescara</option>
        <option value="Piacenza">Piacenza</option>
        <option value="Pisa">Pisa</option>
        <option value="Pistoia">Pistoia</option>
        <option value="Pordenone">Pordenone</option>
        <option value="Potenza">Potenza</option>
        <option value="Prato">Prato</option>
        <option value="Ragusa">Ragusa</option>
        <option value="Ravenna">Ravenna</option>
        <option value="Reggio di Calabria">Reggio di Calabria</option>
        <option value="Reggio nell'Emilia">Reggio nell'Emilia</option>
        <option value="Rieti">Rieti</option>
        <option value="Rimini">Rimini</option>
        <option value="Roma">Roma</option>
        <option value="Rovigo">Rovigo</option>
        <option value="Salerno">Salerno</option>
        <option value="Sassari">Sassari</option>
        <option value="Savona">Savona</option>
        <option value="Siena">Siena</option>
        <option value="Siracusa">Siracusa</option>
        <option value="Sondrio">Sondrio</option>
        <option value="Taranto">Taranto</option>
        <option value="Teramo">Teramo</option>
        <option value="Terni">Terni</option>
        <option value="Torino">Torino</option>
        <option value="Trapani">Trapani</option>
        <option value="Trento">Trento</option>
        <option value="Treviso">Treviso</option>
        <option value="Trieste">Trieste</option>
        <option value="Udine">Udine</option>
        <option value="Varese">Varese</option>
        <option value="Venezia">Venezia</option>
        <option value="Verbano-Cusio-Ossola">Verbano-Cusio-Ossola</option>
        <option value="Vercelli">Vercelli</option>
        <option value="Verona">Verona</option>
        <option value="Vibo valentia">Vibo valentia</option>
        <option value="Vicenza">Vicenza</option>
        <option value="Viterbo">Viterbo</option>
    </datalist>
</body>

</html>