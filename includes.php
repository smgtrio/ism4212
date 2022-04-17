<?php
###### session start must be the very first thing ######
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// phpinfo(); #### PHP Info page

##### Show Error Message #####
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
##### end of show error message #####

// ##### this is the DB connection page
include_once("connect.php"); ### DB connection

// ##### headers has all html/CSS/JavaScript stuff
include_once("headers.php");

if (isset($_SESSION['email'])) {
    $email = $_SESSION['username'];
    echo "<span class='username_display'> Hi, $username </span>";
// echo "Hi, $username";
}
elseif (isset($username)) {
    echo "<span style='display: inline; float:right; color:red'> Hi, $username </span>";
}
else {
    echo "What now?";
}

?>