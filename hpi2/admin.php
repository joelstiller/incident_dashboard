<?php

// Initialize the session
if(!isset($_SESSION))
    {
        session_start();
    }

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');
require_once('inc/navbar.php');

?>
</body>
</html>
