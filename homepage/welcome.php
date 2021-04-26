html>

<head></head>

<body>
    <?php
    session_start();
    $username = $_SESSION['username'];
    echo "Benvenuto $username" ;

    ?>
</body>

</html>