<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');

if(!isset($_SESSION))
    {
        session_start();
    }

$domain = $_SERVER['HTTP_HOST'];

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: http://" . $domain .  "/hpi2/businessIndex.php");
    require_once('inc/userbar.php');
}else{
    if ( $_SESSION["memberOf"] == "Major Incident Management" ) {
        require_once('inc/navbar.php');
    }elseif ( $_SESSION["memberOf"] == "IT Business Communication" ) {
        require_once('inc/bisbar.php');
    }
}

$id  = $_GET['ID'];
$inc = $_GET['INC'];

// Processing form data when form is submitted
// Prepare an insert statement
$sql = "DELETE FROM impactedApps WHERE id = ?";

if($stmt = mysqli_prepare($link, $sql)){
// Setting parameters
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $id);
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
    // Redirect to login page
        header("location: http://" . $domain .  "/hpi2/businessIndex.php?INC=$inc");
    }else{
        echo "Something went wrong. Please try again later.";
    }
}
// Close statement
mysqli_stmt_close($stmt);
// Close connection
mysqli_close($link);
?>
