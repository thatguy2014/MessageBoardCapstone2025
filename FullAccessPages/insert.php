<?php
// Enable error reporting for debugging (comment out in production)
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Verify user login
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

// Connect to the database
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

$userid = $_SESSION["UserId"];
$message = ""; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_input'])) {
    $selectedInput = htmlspecialchars($_POST['selected_input']);

    // Insert a new row if it doesn't already exist
    try {
        mysqli_query($conn, "INSERT INTO CurrentDisplays (UserId, CurrentDisplay) VALUES ('$userid', '')");
    } catch (Exception $e) {
        error_log("Error adding new row: " . $e->getMessage());
    }

    // Update the database with the selected input
    $updateQuery = "UPDATE CurrentDisplays SET CurrentDisplay = '$selectedInput' WHERE UserId = '$userid'";
    if (mysqli_query($conn, $updateQuery)) {
        $message = "<div class='alert alert-success text-center p-3 mt-3'>
                        ✅ Message updated successfully. Redirecting...
                    </div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'currentdisplay.php';
                }, 6000);
              </script>";
    } else {
        $message = "<div class='alert alert-danger text-center p-3 mt-3'>
                        ❌ Error updating message. Try again.
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Display</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Updating Your Display Message...</h3>
            </div>
            <div class="card-body text-center">
                <?= $message; ?>
                <p>Click <a href="currentdisplay.php" class="fw-bold">here</a> if not redirected.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
