<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["Displayloggedin"]) || $_SESSION["Displayloggedin"] !== true){
    header("location: /home/site/wwwroot/DisplayOnlyPages/DisplayOnlyLogin.php");
    exit;
}
?>