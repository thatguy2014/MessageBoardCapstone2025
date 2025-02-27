<?php
// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verify user login
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

// Connect to the database
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $_POST['addPresetinput'];
    echo "<br>";
    echo $_POST['deletePresetInput'];
    if($_POST['addPresetinput'] !== '') {
        //then add the selected preset
        $NewPreset = $_POST['addPresetinput'];
        $addPresetQuery = mysqli_prepare($conn, "INSERT INTO presets(PresetString,UserId) VALUES (?,?)");
        mysqli_stmt_bind_param($addPresetQuery, "si", $NewPreset, $userid);
        if(mysqli_stmt_execute($addPresetQuery)) {
            //it worked!
        } else {
            //it didn't work :(
        }
    }
    if($_POST['deletePresetInput'] !== '') {
        //then delete the selected preset
        $deletePreset = $_POST['deletePresetInput'];
        $deletePresetQuery = mysqli_prepare($conn, "DELETE FROM presets WHERE PresetString = ?");
        mysqli_stmt_bind_param($deletePresetQuery, "s", $deletePreset);
        if (mysqli_stmt_execute($deletePresetQuery)) {
            //it worked!
        } else {
            //it didn't work :(
        }
    }
}




?>