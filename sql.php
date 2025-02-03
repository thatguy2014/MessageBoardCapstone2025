<?php

define('DB_SERVER', getenv("CUSTOMCONNSTR_DB_Server"));
define('DB_USERNAME', getenv("CUSTOMCONNSTR_DB_Username"));
define('DB_PASSWORD', getenv("CUSTOMCONNSTR_DB_Password"));
define('DB_NAME', getenv("CUSTOMCONNSTR_DB_Name"));


$conn = mysqli_init();
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);

// Connect to MySQL
$link = mysqli_real_connect($conn, DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, 3306, MYSQLI_CLIENT_SSL);

if (!$link) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Now $conn contains the MySQLi object
?>
