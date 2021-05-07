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

  if (isset($_POST['fakeButton'])) {
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

  <nav class="navbar navbar-light navbar-bg">
    <a class="navbar-brand main-title" href="#">
      <img id="logo" src="../images/Ptogether.png" width="14.7%" height="14.7%" alt="Ptogether">
      <span class="ml-3"><?php echo "$line[nome]"; ?></span>
    </a>
    <div class="mr-3 nav-item btn-group">
      <a href="javascript:history.go(-1)"><button class="btn-lg btn-warning mr-1">Torna alla Ricerca</button></a>
      <form method="POST" action="evento.php" id="fakeForm" style="display:none">
        <input type="text" value='<?php echo "$line[id]";?>'>
      </form>
      <button name="fakeButton" type="submit" form="fakeForm" class="btn-lg btn-danger" id="partecipa">Partecipa</button>
    </div>
  </nav>



  <div class="container-fluid mr-3 my-3">
    <div class="media">
      <div class="media-body mr-3">
        <table class="table table-hover">
          <tbody>
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
      <h3><strong>Dettagli evento:</strong></h3>
      <h5><?php echo "$line[descrizione]"; ?></h5>
    </div>
  </div>
</body>

</html>