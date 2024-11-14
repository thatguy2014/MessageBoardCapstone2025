<?php
    /*$url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");*/         //this should autorefresh
   
    include('sql.php'); 
    $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";
    $getResults = sqlsrv_query($conn, $tsql);
    //mysqli_close($con);
    //print("$getResults \n");
    echo file_get_contents("CurrentDisplay.html");
?>


