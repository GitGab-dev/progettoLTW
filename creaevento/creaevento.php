<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Evento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script lang="javascript" src="script.js"></script>
    <script src="https://kit.fontawesome.com/fa878af576.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Raleway:wght@400;500&display=swap" rel="stylesheet">

</head>

<body>
    <?php
    session_start();
    if (!$_SESSION['id']) {
        session_commit();
        header("Location: ../index.php");
    } else {
        $utente = $_SESSION['username'];
        $idUtente = $_SESSION['id'];
        session_commit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());

        $nome = test_input($_POST["creaNomeEvento"]);
        $categoria = (int)($_POST["creaCategoria"]);
        $luogo = test_input($_POST["creaLuogo"]);
        $data = test_input($_POST["creaData"]);
        $ora = test_input($_POST["creaOra"]);

        //TO_DO: idEvento per nome immagine e immagine di default
        //$immagine = test_input($idUtente . "-" . str_replace(" ","",$nome) . "." . strtolower(pathinfo($_FILES["creaImmagine"]["name"], PATHINFO_EXTENSION)));
        $idEvento = getNextId($dbconn);

        $check = $_FILES["creaImmagine"]["tmp_name"];
        if ($check === "") $immagine = "default.png";
        else $immagine = test_input($idEvento . "." . strtolower(pathinfo($_FILES["creaImmagine"]["name"], PATHINFO_EXTENSION)));

        $email = test_input($_POST["creaEmail"]);
        $telefono = test_input($_POST["creaTel"]);
        $descrizione = test_input($_POST["creaDesc"]);

        $q = "SELECT * FROM public.events WHERE nome=$1 AND utente=$2 AND data=$3";
        $res = pg_query_params($dbconn, $q, array($nome, $idUtente, $data));
        if ($line = pg_fetch_array($res, null, PGSQL_ASSOC)) {
            echo '<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Errore!</strong> Esiste già un evento creato da te con stesso nome e stessa data!
          </div>';
        } else {

            echo "che succede?";
            $q1 = "INSERT INTO public.events(
                id, nome, categoria, citta, data, ora, filep, email, telefono, descrizione, partecipanti, utente)
                VALUES (DEFAULT,$1, $2, $3, $4, $5, $6, $7, $8, $9, 0, $10);";
            $res = pg_query_params($dbconn, $q1, array($nome, $categoria, $luogo, $data, $ora, $immagine, $email, $telefono, $descrizione, $idUtente));



            if ($check === "") header("Location: ../homepage/welcome.php");

            //Uplaod immagine
            $target_dir = "../uploads/";
            $target_file = $target_dir . $immagine;
            if (move_uploaded_file($_FILES["creaImmagine"]["tmp_name"], $target_file)) {
                //console_log("File uploadato con successo!");
                header("Location: ../homepage/welcome.php");
            } else {
                console_log("C'è stato un errore con l'upload");
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

    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    function getNextId($db)
    {
        $q = 'SELECT id FROM events ORDER BY id DESC LIMIT 1';
        $result = pg_query($db, $q) or die('Query failed: ' . pg_last_error());
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
        if (!$line) return 0;
        return (int)$line['id'] + 1;
    }
    ?>

    <div id="divErroreCrea"></div>

    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand main-title" href="./../homepage/welcome.php">
            <img id="logo" src="../images/Ptogether.png" width="85px" height="85px" alt="Ptogether">
            <span class="ml-3">Crea Evento</span>
        </a>


        <div class="mr-3 nav-item btn-group">
            <button type="submit" form="form1" class="btn-lg btn-success"><i class="fas fa-calendar-plus"></i> Crea</button>
        </div>
    </nav>


    <div class="container myFormDiv mt-5">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="myForm" id="form1" enctype="multipart/form-data" onsubmit="return validaCreazione()">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="creaNomeEvento">Nome Evento</label>
                    <input type="text" class="form-control" id="creaNomeEvento" name="creaNomeEvento" placeholder="Nome Evento" maxlength="25" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="creaCategoria">Categoria</label>
                    <select id="creaCategoria" name="creaCategoria" class="form-control">
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
                    <input list="provincia" class="form-control" id="creaLuogo" name="creaLuogo" placeholder="Luogo dell'evento" required autocomplete="on">
                </div>
                <div class="form-group col-md-4">
                    <label for="creaData">Data</label>
                    <input type="date" class="form-control" id="creaData" name="creaData" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="creaOra">Ora</label>
                    <input type="time" class="form-control" id="creaOra" name="creaOra" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-8">
                    <label for="creaImmagine">Immagine</label>

                    <div class="custom-file">

                        <input type="file" class="custom-file-input" id="creaImmagine" name="creaImmagine" accept="image/*">
                        <label class="custom-file-label" for="creaImmagine">Scegli immagine...</label>
                        <div class="invalid-feedback">File non valido</div>

                    </div>
                </div>
                <div class="form-group col-4">
                    <img id="myImage" src="../uploads/default.png" width="100%" height="100%" alt="">
                </div>
                <script>
                    $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                    $("#creaImmagine").change(function() {
                        readURL(this);
                    });
                </script>



            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="creaEmail">Email<span class="red-text"> *</span></label>
                    <input type="email" class="form-control" id="creaEmail" name="creaEmail" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="creaTel">Recapito telefonico<span class="red-text"> *</span></label>
                    <input type="tel" class="form-control" id="creaTel" name="creaTel" placeholder="Telefono">
                </div>
            </div>

            <div class="form-group">
                <label for="creaDesc">Descrizione:</label><br>
                <textarea class="form-control" id="creaDesc" name="creaDesc" rows="4" cols="50"></textarea>
            </div>

            <p class="red-text">* è sufficiente riempire uno tra i campi Email e Recapito telefonico</p>
        </form>
    </div>

    <?php

    $filename = "../resources/comuniRidotto.csv"; //example name for your CSV file with classes - this file would exist in the same directory as this PHP file
    $classArray = array(); //declare an array to store your classes

    if (($handle = fopen($filename, "r")) !== FALSE) {

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            foreach ($data as $v) { //loop through the CSV data and add to your array
                array_push($classArray, $v);
            }
        }
    }
    ?>

    <datalist id="provincia" name="provincia">
        <?php

        for ($i = 0; $i < count($classArray); $i++) { // this is embedded PHP that allows you to loop through your array and echo the values of the PHP array within an HTML option tag
            echo "<option value='$classArray[$i]'>$classArray[$i]</option>";
        }

        ?>
    </datalist>
</body>

</html>