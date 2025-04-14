<?php
// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verify user login
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

// Connect to the database
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

$userid = $_SESSION["UserId"];
$error = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['addPresetinput'] !== '') {
        //then add the selected preset
        $NewPreset = $_POST['addPresetinput'];
        $addPresetQuery = mysqli_prepare($conn, "INSERT INTO presets(PresetString,UserId) VALUES (?,?)");
        mysqli_stmt_bind_param($addPresetQuery, "si", $NewPreset, $userid);
        if(mysqli_stmt_execute($addPresetQuery)) {
            //it worked!
            $message = "<div class='alert alert-success'>Database updated successfully. Redirecting...</div>";
            $error = false;
        } else {
            //it didn't work :(
            $message = "<div class='alert alert-danger'>Error updating Database. Try again.</div>";
        }
    }
    if($_POST['deletePresetInput'] !== '') {
        //then delete the selected preset
        $deletePreset = $_POST['deletePresetInput'];
        $deletePresetQuery = mysqli_prepare($conn, "DELETE FROM presets WHERE PresetString = ?");
        mysqli_stmt_bind_param($deletePresetQuery, "s", $deletePreset);
        if (mysqli_stmt_execute($deletePresetQuery)) {
            //it worked!
            $message = "<div class='alert alert-success'>Database updated successfully. Redirecting...</div>";
            $error = true;
        } else {
            //it didn't work :(
            $message = "<div class='alert alert-danger'>Error updating Database. Try again.</div>";
        }
    }
    if($_POST['deletePresetInput'] == '' && $_POST['addPresetinput'] == '') {
        $message = "<div class='alert alert-danger'>Error updating Database, no input found. Try again.</div>";
    }
}

header("refresh:6; url=/../FullAccessPages/currentdisplay.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Updated</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .card {
            background-color: #E87722;
            color: #000000;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.2);
        }
        .loader {
            border: 4px solid #ffffff;
            border-top: 4px solid #E87722;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>
            <?
                if($error) {
                    print("Error!");
                } else {
                    print("Success!");
                }
            ?>
        </h2>
        <?= $message; ?>
        <p>You will be redirected in 6 seconds...</p>
        <div class="loader"></div>
        <a href="/../FullAccessPages/currentdisplay.php" class="btn btn-dark mt-3">Go Now</a>
    </div>
</body>
</html>