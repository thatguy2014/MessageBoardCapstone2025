<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["Displayloggedin"]) || $_SESSION["Displayloggedin"] !== true){
    $_SESSION["loggedin"] = false;
    header("location: /../DisplayOnlyPages/DisplayOnlyLogin.php");
    exit;
}
?>