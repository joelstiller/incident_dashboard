<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');

if(!isset($_SESSION))
    {
        session_start();
    }

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: /hpi2/index.php");
    require_once('inc/userbar.php');
}else{
    if ( $_SESSION["memberOf"] == "Major Incident Management" ) {
        require_once('inc/navbar.php');
    }elseif ( $_SESSION["memberOf"] == "IT Business Communication" ) {
        require_once('inc/bisbar.php');
    }
}

$dateRegex = '/\d{2}\/\d{2}\/\d{2,4}\s\d{2}:\d{2}\s(PM|AM)$/';
$dateError = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an insert statement
    $sql = "UPDATE incidents SET callStatus = ?, endTime = ? WHERE snowTicket = ?";
    if ( preg_match($dateRegex, $_POST['endTime']) ) {
        if($stmt = mysqli_prepare($link, $sql)){
            // Setting parameters
            $snowticket  = $_POST['snowTicket'];
	    $callstatus  = 'Resolved';
            $endtime   = $_POST['endTime'];
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $callstatus, $endtime, $snowticket);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
                header("location: /hpi2/index.php");
            }else{
                echo "Something went wrong. Please try again later.";
            }
         }
         // Close statement
         mysqli_stmt_close($stmt);
         // Close connection
         mysqli_close($link);
    }else{
        $dateError = "You did not use the correct date format. Ex. 01/01/20 01:00 PM";
    }
}

?>

<div class="container h-100 my-lg-5 col-6">
    <form id="closeHPIform" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Resolve High Priority Incident</h2>
	<div class="form-group">
            <label for="snowTicket">SNOW Ticket ID:*</label>
            <select class="form-group custom-select" name="snowTicket" id="snowTicket" required>
                <?php $tickets = getOpenTickets(); foreach ( $tickets as $tick ) { echo "<option value=\"$tick[snowTicket]\">$tick[snowTicket]</option>"; } ?>
            </select>
	</div>
	<div class="form-group">
            <label for="endTime">End Time</label>
            <input type="text" class="form-control" name="endTime" placeholder="01/01/00 12:12">
            <?php
            if ( $dateError ) {
                echo '<div class="alert alert-dismissible alert-danger">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<span class="error">' . $dateError . '</span>';
                echo '</div>';
            }
            ?>
	</div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-primary" onclick="window.location='/hpi2/index.php';">Cancel</button>

    </form>
</div>
</html>
