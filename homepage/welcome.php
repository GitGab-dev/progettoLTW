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
        <a class="navbar-brand" href="#">
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
                            <button type="submit" class="btn btn-primary" id="cercaSubmit">Cerca</button><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <div class="row container-fluid">
        <div class="table-wrapper-scroll-y my-custom-scrollbar col-5 myFull">
            <table class="table table-bordered table-striped">
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
                                    <div class="btn-group myButton">
                                        <!--<button type="button" class="btn btn-info">Info</button>-->
                                        <?php echo "<button type='button' class='btn btn-secondary infoButton' id='$line[id]'>Info</button>"; ?>
                                        <?php echo "<a href='../modificaevento/modificaevento.php?id=$line[id]'><button type='button' class='btn btn-secondary'>Modifica</button></a>"; ?>

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
            Evento selezionato
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $(".infoButton").click(function(e) {
                $("#divEvento").load("../evento/eventomin.php?id=" + e.target.id);
            })
        })
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