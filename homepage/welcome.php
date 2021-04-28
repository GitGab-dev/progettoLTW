<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <script lang="javascript" src="script.js"></script>
</head>

<body>
    <nav class="navbar navbar-light navbar-bg">
        <a class="navbar-brand" href="./../index.html">
            <img src="../images/Ptogether.png" width="100" height="100" alt="Ptogether">
        </a>
        <span id="homeTitle">
            <?php
            session_start();
            $username = $_SESSION['username'];
            echo "Bentornato, $username";
            ?></span>
        </div>
        <div class="btn-group">
            <a href="../creaevento/index.html"><button class="btn-lg btn-success">Crea Evento</button></a>
            <button class="btn-lg btn-outline-success" onclick="return apriSearch()">Ricerca Evento</button>
        </div>
    </nav>

    <div class="container">
        <table class="table table-striped">
            <thead></thead>
            <tbody>
                <tr>
                    <td>
                        <div class="media border p-3">
                            <img src="img_avatar3.png" alt="John Doe" class="mr-3 mt-3 rounded-circle" style="width:60px;">
                            <div class="media-body">
                                <h4>John Doe <small><i>Posted on February 19, 2016</i></small></h4>
                                <p>Lorem ipsum...</p>
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
                <tr>
                    <td>Mary</td>
                    <td>Moe</td>
                    <td>mary@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>