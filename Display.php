<?php
    require_once "VerifyLogin.php";

    require_once "sql.php";
    //the following lines should connect to the database and run the query
    
    $res = mysqli_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
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