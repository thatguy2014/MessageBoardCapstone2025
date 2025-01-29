<?php

// starts displaying errors when things go wrong
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//connection data
$conn = mysqli_init();
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd\$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

//start a session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: currentdisplay.php");
    exit;
}

// Include config file
require_once "sql.php";



// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //print("debug: login pressed \n");
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){

        //Prepare a login statement
        $sql = "call Login(?,?,?);";

        //prepare the statement
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            //print("debug: statement prepared \n");
            mysqli_stmt_bind_param($stmt, "ssb", $param_username, $param_password, $boolean_value);

            //set parameters
            $param_username = $username;
            $param_password = $password;
            $boolean_value = false;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                //print("debug: statement executed \n");
                // Get the result
                mysqli_stmt_store_result($stmt);

                // Bind the result to get the boolean result
                mysqli_stmt_bind_result($stmt, $result_boolean);

                //Fetch the result
                if(mysqli_stmt_fetch($stmt)) {
                    if($result_boolean) {
                        //logged in, start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $param_username;                            
                        
                        // Redirect user to welcome page
                        header("location: CurrentDisplay.php");
                    } else {
                        //not logged in
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    // no result found
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Ohio Northern University Office Message Boards</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            <p>Forgot your password? <a href="">Reset your password</a>.</p>
        </form>
    </div>
</body>
</html>