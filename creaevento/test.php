<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Evento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <script lang="javascript" src="script.js"></script>
</head>

<body>

    <?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
    $password = $email = "";

    ?>

    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand" href="./../index.html">
            <img src="../images/Ptogether.png" width="100" height="100" alt="Ptogether">
        </a>
        <span id="homeTitle">Crea Evento</span>
        <button type="submit" form="form1" class="btn-lg btn-primary">Crea</button>
    </nav>

    <div class="myFormDiv">
        <form class="myForm" id="form1" onsubmit="return validaCreazione()">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="creaNomeEvento">Nome Evento</label>
                    <input type="text" class="form-control" id="creaNomeEvento" placeholder="Nome Evento" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="creaCategoria">Categoria</label>
                    <select id="creaCategoria" class="form-control">
                        <option selected value="default">Scegli...</option>
                        <option value="1">Musica</option>
                        <option value="2">Sport</option>
                        <option value="3">Escursionismo</option>
                        <option value="4">Varie</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="creaLuogo">Luogo</label>
                    <input type="text" class="form-control" id="creaLuogo" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="creaData">Data</label>
                    <input type="date" class="form-control" id="creaData" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="creaOra">Ora</label>
                    <input type="time" class="form-control" id="creaOra" required>
                </div>
            </div>

            <div class="form-group">
                <label for="creaImmagine">Immagine</label>
                <div class="custom-file">

                    <input type="file" class="custom-file-input" id="creaImmagine" accept="image/*">
                    <label class="custom-file-label" for="creaImmagine">Scegli immagine...</label>
                    <div class="invalid-feedback">File non valido</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="creaEmail">Email</label>
                    <input type="email" class="form-control" id="creaEmail" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="creaTel">Recapito telefonico</label>
                    <input type="tel" class="form-control" id="creaTel" placeholder="Telefono">
                </div>
            </div>

            <div class="form-group">
                <label for="creaDesc">Descrizione:</label><br>
                <textarea class="form-control" id="creaDesc" rows="4" cols="50"></textarea>
            </div>
        </form>
    </div>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["emailLogin"])) {
            echo "Errore";
        } else {
            $email = test_input($_POST["emailLogin"]);
            $q1 = "select * from users where email = $1";
            $res = pg_query_params($dbconn, $q1, array($email));

            if (!($line = pg_fetch_array($res, null, PGSQL_ASSOC))) {
                echo "<script>erroreLogin()</script>";
                echo "A";
            } else {
                $password = md5($_POST['passLogin']);
                $q2 = "select * from users where email = $1 and password = $2";
                $res = pg_query_params($dbconn, $q2, array($email, $password));
                if (!($line = pg_fetch_array($res, null, PGSQL_ASSOC))) {
                    echo "<script>erroreLogin()</script>";
                    echo "B";
                } else {
                    session_start();
                    $_SESSION['id'] = $line['id'];
                    $_SESSION['username'] = $line['username'];
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
</body>

</html>