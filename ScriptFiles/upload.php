<?php
// Enable error reporting for debugging (comment out in production)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

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
$target_dir = "uploads/";
$target_file = dirname(dirname(__FILE__)) . '/' . $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$message = "";

// Ensure directory exists
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Ensure directory is writable
if (!is_writable($target_dir)) {
    die("Directory is not writable");
}

// Check if file is an image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $message = "<div class='alert alert-danger'>File is not an image.</div>";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $message = "<div class='alert alert-warning'>Sorry, file already exists.</div>";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $message = "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
    $uploadOk = 0;
}

// Allow certain file formats
if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
    $message = "<div class='alert alert-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
    $uploadOk = 0;
}

// If all checks pass, proceed with the upload
if ($uploadOk === 1) {
    // Delete existing file
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
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Update database
        try {
            mysqli_query($conn, "UPDATE CurrentDisplays SET ImageLocation = '$target_file' WHERE UserId = $userid;");
        } catch (Exception $e) {
            error_log("Error updating database with file location: " . $e->getMessage());
        }

        $message = "<div class='alert alert-success'>Image uploaded successfully. Redirecting...</div>";
        header("refresh:6; url=/../FullAccessPages/currentdisplay.php");
    } else {
        $message = "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
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
        <h2>Image Upload</h2>
        <?= $message; ?>
        <p>You will be redirected in 6 seconds...</p>
        <div class="loader"></div>
        <a href="/../FullAccessPages/currentdisplay.php" class="btn btn-dark mt-3">Go Now</a>
    </div>
</body>
</html>
