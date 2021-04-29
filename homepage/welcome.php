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
    <link rel="stylesheet" href="./style.css">
    <script lang="javascript" src="script.js"></script>
</head>

<body>
    <?php
    if (!(isset($_POST['loginButton']))) header("Location: ../index.php");
    else {
        session_start();
        $utente = $_SESSION['username'];
        $idUtente = $_SESSION['id'];
    }
    ?>
    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand" href="./../index.html">
            <img src="../images/Ptogether.png" width="100" height="100" alt="Ptogether">
        </a>
        <span id="homeTitle">
            <?php echo "Bentornato, $utente"; ?>
        </span>
        </div>
        <div class="btn-group">
            <a href="../creaevento/creaevento.php"><button class="btn-lg btn-success">Crea Evento</button></a>
            <button type="button" class="btn-lg btn-outline-success" data-toggle="modal" data-target="#myModal">Cerca il tuo evento</button>
            <a href="../index.php"><button class="btn-lg btn-warning">Logout</button></a>
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
                    <form action="" method="POST" class="myForm" id="ricercaEvento" onsubmit="return controllaSearch()">
                        <div class="form-group">
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
                            <label for="cercaAl">A</label>
                            <input type="date" class="form-control" id="cercaAl" required>
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
                $query = "SELECT * FROM public.events WHERE utente='$idUtente'";
                $result = pg_query($query) or die('Query failed: ' . pg_last_error());
                while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                ?>
                    <tr>
                        <td>
                            <div class="media border p-3">
                                <?php echo "<img src=../uploads/" . $line["filep"] . " alt='imgEvento' class='mr-3 mt-3 rounded-circle' width='170px' height='150px'>"; ?>
                                <div class="media-body">
                                    <h5><?php echo "$line[nome]"; ?> <small><i><?php echo "$line[data]"; ?></i></small></h5>
                                    <p>Luogo: <?php echo "$line[citta]"; ?></p>
                                    <p>Orario: <?php echo "$line[ora]"; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group myButton">
                                <button type="button" class="btn btn-info">Info</button>
                                <button type="button" class="btn btn-secondary">Modifica</button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</html>