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
  
  $q = "SELECT * FROM public.events WHERE id=$1";
  $res = pg_query_params($dbconn, $q, array($_GET['id']));
  $line = pg_fetch_array($res, null, PGSQL_ASSOC);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    console_log($_POST);
    $nome = test_input($_POST["creaNomeEvento"]);
    $categoria = (int)($_POST["creaCategoria"]);
    $luogo = test_input($_POST["creaLuogo"]);
    $data = test_input($_POST["creaData"]);
    $ora = test_input($_POST["creaOra"]);
    //TO_DO: idEvento per nome immagine e immagine di default
    $immagine = test_input($idUtente . "-" . str_replace(" ", "", $nome) . "." . strtolower(pathinfo($_FILES["creaImmagine"]["name"], PATHINFO_EXTENSION)));
    $email = test_input($_POST["creaEmail"]);
    $telefono = test_input($_POST["creaTel"]);
    $descrizione = test_input($_POST["creaDesc"]);

    console_log($nome);
    console_log($idUtente);
    console_log((int)$_GET['id']);
    $q = "SELECT * FROM public.events WHERE nome=$1 AND utente=$2 AND id!=$3";
    $res = pg_query_params($dbconn, $q, array($nome, $idUtente,(int)$_GET['id']));
    if ($line = pg_fetch_array($res, null, PGSQL_ASSOC)) {
      echo "Esiste già un evento creato da te con questo nome";
    } else {
      $q1 = "UPDATE public.events
                SET nome=$1, categoria=$2, citta=$3, data=$4, ora=$5, email=$6, telefono=$7, descrizione=$8
                WHERE id=$9";

      $res = pg_query_params($dbconn, $q1, array($nome, $categoria, $luogo, $data, $ora, $email, $telefono, $descrizione,(int)$_GET['id']));
      console_log($q1);
      /*
      $target_dir = "../uploads/";
      $target_file = $target_dir . $immagine;

      if (move_uploaded_file($_FILES["creaImmagine"]["tmp_name"], $target_file)) {
        //console_log("File uploadato con successo!");
      } else {
        console_log("C'è stato un errore con l'upload");
      }*/
      header("Location: ../homepage/welcome.php");
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
  ?>
  <nav class="navbar navbar-light navbar-bg">
    <a class="navbar-brand" href="./../index.html">
      <img src="../images/Ptogether.png" width="100" height="100" alt="Ptogether">
    </a>
    <span id="homeTitle">Modifica Evento</span>
    <div class="btn-group">
      <button type="submit" form="form1" class="btn-lg btn-success">Salva</button>
      <a href=""><button class="btn-lg btn-warning">Annulla</button></a>
      <button class="btn-lg btn-danger" onclick="return eliminaEvento()">Elimina</button>
    </div>
  </nav>

  <div class="container myFormDiv">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET['id']; ?>" method="POST" class="myForm" id="form1" enctype="multipart/form-data" onsubmit="return validaCreazione()">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="creaNomeEvento">Nome Evento</label>
          <input type="text" class="form-control" id="creaNomeEvento" name="creaNomeEvento" placeholder="Nome Evento" required>
        </div>
        <div class="form-group col-md-6">
          <label for="creaCategoria">Categoria</label>
          <select id="creaCategoria" name="creaCategoria" class="form-control">
            <option value="default">Scegli...</option>
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
          <input type="text" class="form-control" id="creaLuogo" name="creaLuogo" required>
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

      <div class="form-group">
        <label for="creaImmagine">Immagine</label>

        <div class="custom-file">

          <input type="file" class="custom-file-input" id="creaImmagine" name="creaImmagine" accept="image/*">
          <label class="custom-file-label" for="creaImmagine">Scegli immagine...</label>
          <div class="invalid-feedback">File non valido</div>
        </div>

        <script>
          $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
          });
        </script>

      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="creaEmail">Email</label>
          <input type="email" class="form-control" id="creaEmail" name="creaEmail" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
          <label for="creaTel">Recapito telefonico</label>
          <input type="tel" class="form-control" id="creaTel" name="creaTel" placeholder="Telefono">
        </div>
      </div>

      <div class="form-group">
        <label for="creaDesc">Descrizione:</label><br>
        <textarea class="form-control" id="creaDesc" name="creaDesc" rows="4" cols="50"></textarea>
      </div>
    </form>
    
    <script>
      var data = <?php echo json_encode($line); ?>; // Don't forget the extra semicolon!
      //console.log(data);
      riempiForm(data);
    </script>

  </div>
</body>

</html>