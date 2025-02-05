<?php

    // starts displaying errors when things go wrong
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);
    //start a session
    session_start();           
    
    //verify user is logged in
    require_once "home/site/wwwroot/ScriptFiles/VerifyViewOnlyLogin.php";
    
    //verify we are connected to the db
    require_once "/home/site/wwwroot/ScriptFiles/sql.php";
    
    //the following lines should connect to the database and run the query
    $userid = $_SESSION["UserId"];
    $stmt = mysqli_prepare($conn, "SELECT ImageView FROM userinfo WHERE UserId = ?");
    $res = mysqli_query($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = '" . $userid . "'");
    
    mysqli_stmt_bind_param($stmt, "i", $userid);

    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $resultbool);
        mysqli_stmt_fetch($stmt);
    }

    $ImageStmt = mysqli_prepare($conn, "SELECT ImageLocation FROM currentdisplays where UserId = ?");
    mysqli_stmt_bind_param($ImageStmt, "i", $userid);
    if (mysqli_stmt_execute($ImageStmt)) {
        mysqli_stmt_store_result($ImageStmt);
        mysqli_stmt_bind_result($ImageStmt, $ImageDir);
        mysqli_stmt_fetch($ImageStmt);
    }

    $ImageDir = substr($ImageDir, 18);
    $ImageDir = "/.." . $ImageDir;
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
                echo "<img src=" . $ImageDir . ">";
            }else {
                while ($row = mysqli_fetch_assoc($res)) {
                    printf ("%s \n", $row["CurrentDisplay"]);
                } 
            }
        ?>
    </h2>
        </html>
