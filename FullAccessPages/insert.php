<?php
// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verify user login
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

// Connect to the database
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

$userid = $_SESSION["UserId"];
$message = ""; // Initialize message variable

// Check if a new message is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['InputType'] == 'Image' && $_FILES['fileToUpload']['name']) {    //check if the input was an image
        
    } else { //if the input was text and not and image do the following
        if ($_POST['InputType'] == 'CustomText') {
            $selectedInput = substr(htmlspecialchars($_POST['textInput']), 0, 250);
        }
        if ($_POST['InputType'] == 'PresetText') {
            if($_POST['setPresets'] == "") {
                $selectedInput = substr(htmlspecialchars($_POST['customPresets']), 0, 250);
                var_dump($_POST);
            } else if($_POST['customPresets'] == "") {
                $selectedInput = substr(htmlspecialchars($_POST['setPresets']), 0, 250);
            }
        }
        

        // Insert a new row if it doesn't already exist
        try {
            mysqli_query($conn, "INSERT INTO CurrentDisplays (UserId, CurrentDisplay) VALUES ('$userid', '')");
        } catch (Exception $e) {
            error_log("Error adding new row: " . $e->getMessage());
        }
        
        $updateQuery = $conn->prepare("UPDATE CurrentDisplays SET CurrentDisplay = ? WHERE UserId = ?");
        $updateQuery->bind_param("si", $selectedInput, $userid);

        try {
            $updateQuery->execute();
        } catch (Exception $e) {
            error_log("Error updating message: " . $e->getMessage());
            $message = "<div class='alert alert-danger'>Error updating message. Try again.</div>";
        }
        if ($updateQuery->affected_rows > 0) {
            $message = "<div class='alert alert-success'>Message updated successfully. Redirecting...</div>";
        }
        $updateQuery->close();
    }
}

// Delay redirect for 6 seconds
header("refresh:6; url=currentdisplay.php");
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
        <h2>Success!</h2>
        <?= $message; ?>
        <p>You will be redirected in 6 seconds...</p>
        <div class="loader"></div>
        <a href="currentdisplay.php" class="btn btn-dark mt-3">Go Now</a>
    </div>
</body>
</html>
