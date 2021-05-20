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
  <script src="https://kit.fontawesome.com/fa878af576.js" crossorigin="anonymous"></script>

  <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&display=swap" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla&family=Raleway:wght@400;500&display=swap" rel="stylesheet"> 
</head>

<body>
  <?php

  $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
  $idEvento =  $_GET['id'];

  $q = "SELECT categoria,citta,ora,username,partecipanti,nome,data,filep,email,telefono,descrizione FROM events,users WHERE users.id = events.utente AND events.id=$1";
  $res = pg_query_params($dbconn, $q, array($idEvento));
  $line = pg_fetch_array($res, null, PGSQL_ASSOC);
  if ($line['categoria'] == "1") $categoria = "Musica";
  else if ($line['categoria'] == "2") $categoria = "Sport";
  else if ($line['categoria'] == "3") $categoria = "Escursionismo";
  else $categoria = "Varie";


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
    <a class="navbar-brand main-title" href="javascript:history.go(-1)">
      <img id="logo" src="../images/Ptogether.png" width="85px" height="85px"  alt="Ptogether">
      <span class="ml-3"><?php echo "$line[nome]"; ?></span>
    </a>
    <div class="mr-3 nav-item btn-group">
      <a href="javascript:history.go(-1)"><button class="btn-lg btn-warning mr-1"><i class="fas fa-reply"></i> Torna alla Ricerca</button></a>
      <form method="POST" action="../ricercaevento/ricerca.php" id="fakeForm" style="display:none">
        <input type="text" name="id" value='<?php echo "$idEvento"?>'>
        <input type="text" name="cercaCategoria" value='<?php echo "$_GET[categoria]";?>'>
        <input type="text" name="cercaLuogo" value='<?php echo "$_GET[luogo]";?>'>
        <input type="text" name="cercaDal" value='<?php echo "$_GET[dataDal]";?>'>
        <input type="text" name="cercaAl" value='<?php echo "$_GET[dataAl]";?>'>
        <input type="text" name="partecipanti" value='<?php echo "$line[partecipanti]";?>'>
      </form>
      <button name="fakeButton" type="submit" form="fakeForm" class="btn-lg btn-success" id="partecipa"><i class="fas fa-user-plus"></i> Partecipa</button>
    </div>
  </nav>



  <div class="container mt-5" id="divEvento">
    <div class="media">
      <div class="media-body mr-3">
        <table class="table" id="infoTable">
          <tbody>
            <tr class="infoRow">
              <th>Categoria</th>
              <td> <?php echo "$categoria"; ?></td>
            </tr>
            <tr class="infoRow">
              <th>Luogo</th>
              <td><?php echo "$line[citta]"; ?></td>
            </tr>
            <tr class="infoRow">
              <th>Data</th>
              <td><?php echo "$line[data]"; ?></td>
            </tr>
            <tr class="infoRow">
              <th>Orario</th>
              <td><?php echo "$line[ora]"; ?></td>
            </tr>
            <tr class="infoRow">
              <th>Organizzatore</th>
              <td><?php echo "$line[username]"; ?></td>
            </tr>
            <tr class="infoRow">
              <th>Partecipanti</th>
              <td><?php echo "~$line[partecipanti]"; ?></td>
            </tr>
            <tr class="infoRow">
              <th>Email</th>
              <td><?php echo "$line[email]"; ?></td>
            </tr>
            <tr class="infoRow">
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