<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/fa878af576.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script lang="javascript" src="script.js"></script>
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
    $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
    if (isset($_GET['delete'])) {
        $q = "DELETE FROM public.events WHERE id=$1";
        $res = pg_query_params($dbconn, $q, array($_GET['id']));
    }
    ?>
    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand main-title" href="#">
            <img id="logo" src="../images/Ptogether.png" width="85px" height="85px" alt="Ptogether">
            <span class="ml-3" id="bentornato"><?php echo "Bentornato, $utente"; ?></span>
        </a>


        <div class="mr-3 nav-item btn-group">
            <a href="../creaevento/creaevento.php"><button class="btn-lg btn-success mr-1"><i class="far fa-calendar-plus"></i> Crea Evento</button></a>
            <button type="button" class="btn-lg btn-blue mr-1" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"></i> Cerca il tuo evento</button>
            <a href="../index.php"><button class="btn-lg btn-warning"><i class="fas fa-door-open"></i> Logout</button></a>
        </div>
    </nav>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ricerca Evento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="divErroreSearch"></div>
                    <form action="../ricercaevento/ricerca.php" method="POST" class="myForm" id="ricercaEvento" onsubmit="return controllaSearch()">
                        <div class="form-group">
                            <label for="cercaCategoria">Categoria</label>
                            <select id="cercaCategoria" name="cercaCategoria" class="form-control">
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





    <div class="row container-fluid mt-2 ">
        <div class="table-wrapper-scroll-y my-custom-scrollbar col-5 myFull ">
            <table class="table table-striped cell">
                <thead></thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM public.events WHERE utente='$idUtente' order by id desc";
                    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
                    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    ?>
                        <tr>
                            <td>
                                <div class="media border p-3">
                                    <?php echo "<img src=../uploads/" . $line["filep"] . " alt='imgEvento' class='mr-3 mt-3 rounded-circle' width='170px' height='150px'>"; ?>
                                    <div class="media-body">
                                        <h5><?php echo "<strong>$line[nome]</strong>"; ?> <small><i><?php echo "$line[data]"; ?></i></small></h5>
                                        <br>
                                        <p><strong>Luogo</strong>: <?php echo "$line[citta]"; ?></p>
                                        <p><strong>Orario</strong>: <?php echo "$line[ora]"; ?></p>
                                        <p><strong>Partecipanti</strong>: ~<?php echo " $line[partecipanti]"; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="media border p-3">
                                    <div class="mr-3 p-3 pl-5 btn-group myButton">

                                        <?php echo "<button type='button' class='btn btn-blue infoButton' id='$line[id]'><i class='fas fa-clipboard-list'></i> Info</button>"; ?>
                                        <?php echo "<a href='../modificaevento/modificaevento.php?id=$line[id]'><button type='button' class='btn btn-secondary'><i class='fas fa-pencil-alt'></i> Modifica</button></a>"; ?>

                                    </div>
                                </div>
                            </td>

                        </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-7" id="divEvento">
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $(".infoButton").click(function(e) {
                if(e.target.id!="") $("#divEvento").load("../evento/eventomin.php?id=" + e.target.id);
            })
        })
    </script>

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