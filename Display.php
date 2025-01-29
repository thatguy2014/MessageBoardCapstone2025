<?php

    // starts displaying errors when things go wrong
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();            //this is a test
    require_once "sql.php";
    //the following lines should connect to the database and run the query
    $userid = $_SESSION["UserId"];
    $res = mysqli_query($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = '" . $userid . "'");
?>
<!--the style is so the fullscreen view looks right-->
<style>
html {                  
    background:white;
}
h2 {
  font-size: 10em;
}

    </style>
<html>
    <h2 id="currentdisplay" style="background:white">Current Display is -> 
        <?php   
            while ($row = mysqli_fetch_assoc($res)) {
                printf ("%s \n", $row["CurrentDisplay"]);
            } 
        ?>
    </h2>
        </html>
