<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evento</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./style.css">
  <script lang="javascript" src="script.js"></script>

</head>

<body>
  <?php
 
  $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
  $idEvento =  $_GET['id'];

  $q = "SELECT * FROM public.events WHERE id=$1";
  $res = pg_query_params($dbconn, $q, array($idEvento));
  $line = pg_fetch_array($res, null, PGSQL_ASSOC);
  if ($line['categoria'] == "1") $categoria = "Musica";
  else if ($line['categoria'] == "2") $categoria = "Sport";
  else if ($line['categoria'] == "3") $categoria = "Escursionismo";
  else $categoria = "Varie";

  if (isset($_GET['partecipa'])) {
    $q1 = "UPDATE public.events SET partecipanti=$1 WHERE id=$2";
    $res = pg_query_params($dbconn, $q1, array($line['partecipanti'] + 1, $idEvento));
  }

  pg_free_result($res); //libera la memoria
  pg_close($dbconn); //disconnette


  function console_log($data)
  {
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
  }
  ?>
  <nav class="navbar navbar-light navbar-bg">
    <a class="navbar-brand" href="./../index.php">
      <img src="../images/Ptogether.png" width="100" height="100" alt="Ptogether">
    </a>
    <span id="homeTitle"><?php echo "$line[nome]"; ?></span>
    <div class="btn-group">
      <a href=""><button class="btn-lg btn-warning">Torna alla Ricerca</button></a>
      <a <?php echo "href='evento.php?partecipa=true&id=$idEvento'"; ?>><button class="btn-lg btn-danger" id="elimina">Partecipa</button></a>
    </div>
  </nav>

  <div class="container mt-3">
    <div class="media">
      <div class="media-body">
        <h3>Categoria: <?php echo "$categoria"; ?></h3>
        <h3>Luogo: <?php echo "$line[citta]"; ?></h3>
        <h3>Data: <?php echo "$line[data]"; ?></h3>
        <h3>Orario: <?php echo "$line[ora]"; ?></h3>
        <h3>Email di riferimento: <?php echo "$line[email]"; ?></h3>
        <h3>Contatto telefonico: <?php echo "$line[telefono]"; ?></h3>
      </div>
      <?php echo "<img src=../uploads/" . $line["filep"] . " alt='imgEvento' class='img-thumbnail' width='60%' height='60%' >"; ?>
    </div>
    <div class="media-footer">
        <h3>Dettagli evento:</h3>
        <p><?php echo "$line[descrizione]"; ?></p>
    </div>
  </div>
</body>

</html>