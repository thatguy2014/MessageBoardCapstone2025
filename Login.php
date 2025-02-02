<?php

// starts displaying errors when things go wrong
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//connection data
require_once "sql.php";
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
                mysqli_stmt_bind_result($stmt, $result_boolean,$result_userid);

                //Fetch the result
                if(mysqli_stmt_fetch($stmt)) {
                    if($result_boolean) {
                        //logged in, start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["UserId"] = $result_userid;                            
                        
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
        
        html {
            font-size: 16px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;  /* 16px by default */
            line-height: 1.5; /* Ensures better readability */
            color: #333; /* Dark text for contrast */
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }

        .wrapper {
            width: 100%;
            max-width: 360px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 10px; /* Adds space at the top */
        }

        h2 {
            color: #e63946; 
            font-size: 1.5rem;
            text-align: center;
        }

        
        input, button {
            font-size: 1rem; 
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input:focus, button:focus {
            outline: 3px solid #4D90FE; 
        }

        
        .invalid-feedback {
            color: #e63946; 
        }

        
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:focus, a:hover {
            text-decoration: underline;
        }
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
        </form>
    </div>
</body>
</html>