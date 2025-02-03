<?php
// starts displaying errors when things go wrong
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//connection data
require_once "/../ScriptFiles/sql.php";
//start a session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["Displayloggedin"]) && $_SESSION["DisplayLoggedin"] === true){
    header("location: ViewDisplayOnly.php");
    exit;
}

// Include config file
require_once "/../ScriptFiles/sql.php";



// Define variables and initialize with empty values
$username = "";
$username_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //print("debug: login pressed \n");
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Validate credentials
    if(empty($username_err)){

        //Prepare a login statement
        $sql = "Select UserId FROM userinfo where Username = ?";

        //prepare the statement
        if($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            //print("debug: statement prepared \n");
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //set parameter
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                //print("debug: statement executed \n");
                // Get the result
                mysqli_stmt_store_result($stmt);

                // Bind the result to get the boolean result
                mysqli_stmt_bind_result($stmt,$result_userid);

                //Fetch the result
                if(mysqli_stmt_fetch($stmt)) {
                    if($result_userid > 0) {
                        //logged in, start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["Displayloggedin"] = true;
                        $_SESSION["UserId"] = $result_userid;                            
                        
                        // Redirect user to welcome page
                        header("location: ViewDisplayOnly.php");
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
<!--external style sheet is required -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/../css/Login.css">
</head>
<body>
    <div class="wrapper">
        <h2>Ohio Northern University Office Message Boards (Display Only)</h2>
        <p>Please enter the username of the account you'd like to view.</p>

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
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Is this not a display only device? <a href="/../LoginPages/Login.php">Login Here</a>.</p>
        </form>
    </div>
</body>
</html>