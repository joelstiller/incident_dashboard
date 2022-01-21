<?php
// Initialize the session
 
if(!isset($_SESSION))
    {
        session_start();
    }

$domain = $_SERVER['HTTP_HOST'];

// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: http://" . $domain .  "/hpi2/index.php");
exit();
?>
