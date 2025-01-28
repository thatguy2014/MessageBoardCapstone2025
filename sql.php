<?php

        define('DB_SERVER', 'mbcwebbapp-server.mysql.database.azure.com');
        define('DB_USERNAME', 'qzmbodniyz');
        define('DB_PASSWORD', "YgM0Smd\$bLYYepT1");
        define('DB_NAME', 'mbcwebbapp-database');

        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
/*
        //Run the Select query
    printf("Reading data from table: \n");
    $res = mysqli_real_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
    $res = mysqli_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
    while ($row = mysqli_fetch_assoc($res)) {
        printf ("%s \n", $row["CurrentDisplay"]);
    }*/
?>
