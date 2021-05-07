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
  <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pangolin&display=swap" rel="stylesheet">
</head>

<body>
  <?php

  $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
  $idEvento =  $_GET['id'];

  $q = "SELECT events.id,categoria,citta,ora,username,partecipanti,nome,data,filep,email,telefono,descrizione FROM events,users WHERE users.id = events.utente AND events.id=$1";
  $res = pg_query_params($dbconn, $q, array($idEvento));
  $line = pg_fetch_array($res, null, PGSQL_ASSOC);
  if ($line['categoria'] == "1") $categoria = "Musica";
  else if ($line['categoria'] == "2") $categoria = "Sport";
  else if ($line['categoria'] == "3") $categoria = "Escursionismo";
  else $categoria = "Varie";

  if (isset($_GET['partecipa'])) {
    $q1 = "UPDATE public.events SET partecipanti=$1 WHERE id=$2";
    $res = pg_query_params($dbconn, $q1, array($line['partecipanti'] + 1, $idEvento));
    echo '<div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Partecipazione accettata!</strong> Hai deciso di partecipare!
            </div>';
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

  <div class="container-fluid mr-5 my-5">
    <div class="media">
      <div class="media-body mr-3" style="font-size:120%">
        <table class="table table-hover">
          <tbody>
            <tr>
              <th>Nome Evento</th>
              <td> <?php echo "$line[nome]"; ?></td>
            </tr>
            <tr>
              <th>Categoria</th>
              <td> <?php echo "$categoria"; ?></td>
            </tr>
            <tr>
              <th>Luogo</th>
              <td><?php echo "$line[citta]"; ?></td>
            </tr>
            <tr>
              <th>Data</th>
              <td><?php echo "$line[data]"; ?></td>
            </tr>
            <tr>
              <th>Orario</th>
              <td><?php echo "$line[ora]"; ?></td>
            </tr>
            <tr>
              <th>Organizzatore</th>
              <td><?php echo "$line[username]"; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?php echo "$line[email]"; ?></td>
            </tr>
            <tr>
              <th>Contatto telefonico</th>
              <td><?php echo "$line[telefono]"; ?></td>
            </tr>

          </tbody>
        </table>
      </div>
      <?php echo "<img src=../uploads/" . $line["filep"] . " alt='imgEvento' class='img-thumbnail' width='40%' height='40%' >"; ?>
    </div>
    <div class="media-footer">
      <h5><strong>Dettagli evento:</strong></h5>
      <h6><?php echo "$line[descrizione]"; ?></h6>
    </div>
  </div>
</body>
</html>