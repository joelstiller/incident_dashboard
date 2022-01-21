<?php
session_start();
require_once('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Setting parameters
    $username = $_SESSION['username'];
    $cssmode = 'Light';
    if (isset($_POST['cssmode']) && $_POST['cssmode'] == 'Dark') {
        $cssmode = 'Dark';
	$_SESSION['cssMode'] = 'Dark';
    }else{
	$_SESSION['cssMode'] = 'Light';
    }
    $out = putCssMode($username, $cssmode);
    header("location: index.php");
}

?>
