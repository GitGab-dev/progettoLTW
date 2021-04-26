<html>

<head></head>

<body>
    <?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=progetto user=postgres password=biar") or die('Could not connect' . pg_last_error());
    

    
    $email = $_POST['emailLogin'];
    $q1 = "select * from users where email = $1";
    $res = pg_query_params($dbconn,$q1, array($email));
    if(!($line=pg_fetch_array($res, null, PGSQL_ASSOC))) {
        echo "<h1> Non sei registrato </h1>";
        
    }
    else{
        $password = md5($_POST['passLogin']);
        $q2 = "select * from users where email = $1 and password = $2";
        $res = pg_query_params($dbconn,$q2, array($email,$password));
        if (!($line=pg_fetch_array($res, null, PGSQL_ASSOC))) {
            echo "<h1> Password sbagliata </h1>"; 
            echo "<a href=index.html> Clicca qui per il login</a>";
        }
        else {
            $nome = $line['username'];
            echo "<h1> Benvenuto $nome </h1>";
        }

    }
    

    pg_free_result($res); //libera la memoria
    pg_close($dbconn); //disconnette

            

    ?>
</body>

</html>