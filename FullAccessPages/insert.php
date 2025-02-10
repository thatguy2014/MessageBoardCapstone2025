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
        $message = "<div class='alert alert-success'>Message updated successfully. Redirecting...</div>";
        header("refresh:2; url=currentdisplay.php"); // Auto redirect after 2 seconds
    } else {
        $message = "<div class='alert alert-danger'>Error updating message. Try again.</div>";
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
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Update Your Display Message</h3>
            </div>
            <div class="card-body">
                <?= $message; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="selected_input" class="form-label">Enter Your Message:</label>
                        <input type="text" class="form-control" name="selected_input" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update Message</button>
                </form>
                <a href="currentdisplay.php" class="btn btn-secondary mt-3">View Current Display</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
