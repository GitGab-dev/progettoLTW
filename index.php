<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning Together</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <script src="script.js"></script>
</head>

<body>

    <?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
    $password = $email = "";
    session_start();
    if ($_SESSION['id']) session_unset();
    session_commit();
    ?>

    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand" href="#">
            <img src="./images/Ptogether.png" width="100" height="100" alt="Ptogether">
            <span id="homeTitle">Planning Together</span>
            <span style=color:#86afb9>copyright by Gabriele & Filippo</span>
        </a>
        <div>
            <button class="btn-lg btn-primary" onclick="return apriLogin()">Login</button>
            <button class="btn-lg btn-outline-success" onclick="return apriSearch()">Ricerca Evento</button>
        </div>

    </nav>

    <!--CONTAINER IMG E TESTI-->

    <div id="mainPart">

        <p class="myCell" id="altoSin">Vuoi organizzare e pubblicizzare un evento? Iscriviti al nostro sito!</p>


        <div class="myFormDiv" id="loginFormDiv">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="myForm" onsubmit="return controllaLogin()">
                <div class="form-group">
                    <h4>Login</h4>
                    <label for="emailLogin">Indirizzo email</label>
                    <input type="email" class="form-control" id="emailLogin" name="emailLogin" value="<?php echo $email; ?>" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="passLogin">Password</label>
                    <input type="password" class="form-control" id="passLogin" name="passLogin" value="<?php echo $password; ?>" placeholder="Password" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberBox">
                    <label class="form-check-label" for="rememberBox">Ricordami</label>
                </div>
                <br>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-primary" name="loginButton">Login</button><br>
                </div>
                <label for="signUp">Non sei iscritto?</label>
                <a href="" id="signUp">Crea un account</a>
            </form>
        </div>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["emailLogin"])) {
                echo "Errore";
            } else {
                $email = test_input($_POST["emailLogin"]);
                $q1 = "select * from users where email = $1";
                $res = pg_query_params($dbconn,$q1, array($email));

                if(!($line=pg_fetch_array($res, null, PGSQL_ASSOC))) {
                    echo "<script>erroreLogin()</script>";
                    echo "A";
                }
                else{
                    $password = md5($_POST['passLogin']);
                    $q2 = "select * from users where email = $1 and password = $2";
                    $res = pg_query_params($dbconn,$q2, array($email,$password));
                    if (!($line=pg_fetch_array($res, null, PGSQL_ASSOC))) {
                        echo "<script>erroreLogin()</script>";
                        echo "B";
                    }
                    else {
                        session_start();
                        $_SESSION['id'] = $line['id'];
                        $_SESSION['username'] = $line['username'];
                        session_commit();
                        header("Location: ../homepage/welcome.php");
                    }
                }
            }
            
        
            pg_free_result($res); //libera la memoria
            pg_close($dbconn); //disconnette

        }

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>


        <div class="myFormDiv" id="searchFormDiv">
            <form action="" method="POST" class="myForm" onsubmit="return controllaSearch()">
                <div class="form-group">
                    <h4>Ricerca Evento</h4>
                    <label for="cercaCategoria">Categoria</label>
                    <select id="cercaCategoria" class="form-control">
                        <option selected value="default">Scegli...</option>
                        <option value="cat1">Musica</option>
                        <option value="cat2">Sport</option>
                        <option value="cat3">Escursionismo</option>
                        <option value="cat4">Varie</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cercaLuogo">Luogo</label>
                    <input type="text" class="form-control" id="cercaLuogo" required>
                </div>
                <div class="form-group">
                    <label for="cercaDal">Dal</label>
                    <input type="date" class="form-control" id="cercaDal" required>
                    <br>
                    <label for="cercaAl">Al</label>
                    <input type="date" class="form-control" id="cercaAl" required>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-primary" id="cercaSubmit">Cerca</button><br>
                </div>
            </form>
        </div>


        <p class="myCell" id="bassoDx">Vuoi partecipare ad iniziative ed eventi? Dai uno sguardo alla sezione Search!</p>



    </div>

</body>

</html>