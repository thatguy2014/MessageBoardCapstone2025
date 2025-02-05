<?php
    //start error reporting for testing
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //verify user is logged in
    require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

    //access sql server
    require_once "/home/site/wwwroot/ScriptFiles/sql.php";

    $target_dir = "uploads/";
    $target_file = dirname(dirname(__FILE__)) . '/' . $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    //ensure directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    //ensure directory is writable
    if (!is_writable($target_dir)) {
        die("Directory is not writable");
    }

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

        // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            //need to store the file location
            $userid = $_SESSION["UserId"];
            try{
                mysqli_query($conn, "UPDATE CurrentDisplays SET ImageLocation = $target_file WHERE UserId = $userid;");
            } catch(Exception $e) {
                error_log("Error occured while updating database with file location " . $e->getMessage());
            }
            echo "<p>Message updated successfully please click here <a href=/../FullAccessPages/currentdisplay.php>Go Back</a>.</p>";
            header("location: /../FullAccessPages/currentdisplay.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>