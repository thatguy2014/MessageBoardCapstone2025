<?php

    // starts displaying errors when things go wrong
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();            //this is a test
    require_once "/home/site/wwwroot/ScriptFiles/sql.php";
    //the following lines should connect to the database and run the query
    $userid = $_SESSION["UserId"];
    $stmt = mysqli_prepare($conn, "SELECT ImageView FROM userinfo WHERE UserId = '?'");
    $res = mysqli_query($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = '" . $userid . "'");
    
    mysqli_stmt_bind_param($stmt, "i", $userid);

    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($ImageView);
        mysqli_stmt_bind_result($ImageView, $resultbool);
        mysqli_stmt_fetch($stmt);
    }

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
    <h2 id="currentdisplay" style="background:white">
        <?php   
            if($resultbool) {
                echo "<p>Image goes here, this is just filler for now.</p>";
            }else {
                while ($row = mysqli_fetch_assoc($res)) {
                    printf ("%s \n", $row["CurrentDisplay"]);
                } 
            }
        ?>
    </h2>
        </html>
