<?php
// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verify user login
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

// Connect to the database
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

// Function to delete an existing file
function deleteExistingFile($filepath) {
    if (file_exists($filepath)) {
        unlink($filepath);
        return true;
    }
    return false;
}

$userid = $_SESSION["UserId"];
$message = ""; // Initialize message variable
$target_dir = "uploads/";
$target_file = dirname(dirname(__FILE__)) . '/' . $target_dir . basename($_FILES["imageUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$errorMessage = "";
$successMessage = "";

// Check if a new message is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['InputType'] == 'Image' && $_FILES['imageUpload']['name']) {    //check if the input was an image
        mysqli_query($conn, "UPDATE userinfo SET ImageView = 1 WHERE UserId = '$userid';");

        // Ensure directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Ensure directory is writable
        if (!is_writable($target_dir)) {
            $errorMessage = "Directory is not writable.";
            $uploadOk = 0;
        }

        // Check if file is an image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
            if ($check === false) {
                $errorMessage = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $errorMessage = "Sorry, file already exists. Please rename your file.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["imageUpload"]["size"] > 500000) {
            $errorMessage = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If an error occurred, show an alert and stop execution
        if ($uploadOk === 0) {
            echo "<script>alert('$errorMessage'); window.history.back();</script>";
            exit(); // Prevent further execution
        }

        // Proceed with file upload only if no errors
        try {
            $stmt = mysqli_prepare($conn, "SELECT ImageLocation FROM currentdisplays WHERE UserId = ?");
            mysqli_stmt_bind_param($stmt, "i", $userid);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_bind_result($stmt, $delete_dir);

                if (mysqli_stmt_fetch($stmt) && deleteExistingFile($delete_dir)) {
                    // Previous file deleted successfully
                }
            }
        } catch (Exception $e) {
            error_log("Error deleting old file: " . $e->getMessage());
        }

        // Move new file
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
            // Update database
            try {
                mysqli_query($conn, "UPDATE CurrentDisplays SET ImageLocation = '$target_file' WHERE UserId = $userid;");
            } catch (Exception $e) {
                error_log("Error updating database with file location: " . $e->getMessage());
            }

            $successMessage = "Image uploaded successfully. Redirecting...";
            echo "<script>
                setTimeout(() => { window.location.href = '/../FullAccessPages/currentdisplay.php'; }, 6000);
            </script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
            exit();
        }


    } else { //if the input was text and not and image do the following
        mysqli_query($conn, "UPDATE userinfo SET ImageView = 0 WHERE UserId = '$userid';");
        if ($_POST['InputType'] == 'CustomText') {
            $selectedInput = substr(htmlspecialchars($_POST['textInput']), 0, 250);
        }
        if ($_POST['InputType'] == 'PresetText') {
            if($_POST['presets'] == "") {
                $selectedInput = substr(htmlspecialchars($_POST['custompresets']), 0, 250);
            } else if($_POST['custompresets'] == "") {
                $selectedInput = substr(htmlspecialchars($_POST['presets']), 0, 250);
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
    //set expiration date
    if($_POST['Expiration'] == 'Yes') {
        $DateTime = $_POST['expiration-time'];
    } else {
        $DateTime = null;
    }
    $ExpirationQuery = $conn->prepare("UPDATE CurrentDisplays SET Expiration = ? WHERE Userid = ?");
        $ExpirationQuery->bind_param("si", $DateTime, $userid);
        try {
            $ExpirationQuery->execute();
        } catch(Exception $e) {
            error_log("Error updating message: " . e->getMessage());
            $message = "<div class='alert alert-danger'>Error updating Expiration Date. Try again.</div>";
        }
        $ExpirationQuery->close();
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
