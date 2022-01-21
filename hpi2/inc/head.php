<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HPI Dashboard</title>
<?php
if(!isset($_SESSION)){ 
    session_start();
}
if (ISSET($_SESSION['cssMode']) ) {
    if ($_SESSION['cssMode'] == "Light") {
        echo '<link id="lightcss" rel="stylesheet" href="/hpi2/css/bootstrap.min.css">';
    }elseif ( $_SESSION['cssMode'] == "Dark" ) {
        echo '<link id="darkcss"  rel="stylesheet" href="/hpi2/css/bootstrap.min.darkly.css">';
    }else{
        echo '<link id="lightcss" rel="stylesheet" href="/hpi2/css/bootstrap.min.css">';
    }
}else{
    echo '<link id="lightcss" rel="stylesheet" href="/hpi2/css/bootstrap.min.css">';
}
?>
    <link rel="stylesheet" href="/hpi2/css/toggleswitch.css">
    <script type="text/javascript" src="/hpi2/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/hpi2/js/bootstrap.bundle.min.js"></script>
</head>
