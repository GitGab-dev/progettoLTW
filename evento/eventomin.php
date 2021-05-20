<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evento</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="../main.css">
  <link rel="stylesheet" href="./style.css">
  <script lang="javascript" src="script.js"></script>
</head>

<body>
  <?php
  //connessione al DB
  $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
  $idEvento =  $_GET['id'];
  console_log($idEvento);

  $q = "SELECT events.id,categoria,citta,ora,username,partecipanti,nome,data,filep,email,telefono,descrizione FROM events,users WHERE users.id = events.utente AND events.id=$1";

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

  <!--SCHEDA EVENTO-->
  <div class="container-fluid mr-5 my-5">
    <div class="media">
      <div class="media-body mr-3" style="font-size:120%">
        <table class="table" id="infoTable">
          <tbody>
            <tr class="infoRow">
              <th>Nome Evento</th>
              <td> <?php echo "$line[nome]"; ?></td>
            </tr>
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
      <h5><strong>Dettagli evento:</strong></h5>
      <h6><?php echo "$line[descrizione]"; ?></h6>
    </div>
  </div>
</body>

</html>