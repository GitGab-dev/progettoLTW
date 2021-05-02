<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./style.css">
    <script lang="javascript" src="script.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand" href="./../index.html">
            <img src="../images/Ptogether.png" width="100" height="100" alt="Ptogether">
        </a>
        <span id="homeTitle">
            Risultati Ricerca
        </span>
        </div>
        <div class="btn-group">
            <button type="button" class="btn-lg btn-outline-success" data-toggle="modal" data-target="#myModal">Cerca il tuo evento</button>
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
                    <form action="ricerca.php" method="POST" class="myForm" id="ricercaEvento" onsubmit="return controllaSearch()">
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
                            <input type="text" class="form-control" id="cercaLuogo" name="cercaLuogo" required>
                        </div>
                        <div class="form-group">
                            <label for="cercaDal">Dal</label>
                            <input type="date" class="form-control" id="cercaDal" name="cercaDal" required>
                            <br>
                            <label for="cercaAl">A</label>
                            <input type="date" class="form-control" id="cercaAl" name="cercaAl" required>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary" id="cercaSubmit">Cerca</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead></thead>
            <tbody>
                <?php
                $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());

                $categoria = (int)($_POST["cercaCategoria"]);
                $luogo = test_input($_POST["cercaLuogo"]);
                $dataDal = test_input($_POST["cercaDal"]);
                $dataAl = test_input($_POST["cercaAl"]);

                $query = "SELECT * FROM events WHERE categoria=$1 AND citta=$2 AND data >= $3 AND data <= $4";
                console_log([$categoria,$luogo,$dataDal,$dataAl]);
                
                $result = pg_query_params($dbconn,$query,array($categoria,$luogo,$dataDal,$dataAl)) or die('Query failed: ' . pg_last_error());
                while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
                ?>
                    <tr>
                        <td>
                            <div class="media border p-3">
                                <?php echo "<img src=../uploads/" . $line["filep"] . " alt='imgEvento' class='mr-3 mt-3 rounded-circle' width='170px' height='150px'>"; ?>
                                <div class="media-body">
                                    <h5><?php echo "$line[nome]"; ?> <small><i><?php echo "$line[data]"; ?></i></small></h5>
                                    <br>
                                    <p>Luogo: <?php echo "$line[citta]"; ?></p>
                                    <p>Orario: <?php echo "$line[ora]"; ?></p>
                                    <p>Partecipanti: ~<?php echo " $line[partecipanti]"; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="media border p-3">
                                <?php echo "<a href='../evento/evento.php?id=$line[id]'><button type='button' class='btn btn-secondary'>Info</button></a>";?>
                            </div>
                        </td>
                        
                    </tr>
                <?php
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
                ?>
            </tbody>
        </table>
    </div>

</html>