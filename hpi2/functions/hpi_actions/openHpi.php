<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');

//Starting Session

if(!isset($_SESSION))
    {
        session_start();
    }

// Verifying logged in
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
    if ( preg_match($dateRegex, $_POST['startTime']) ) {
        $sql = "INSERT INTO incidents (snowTicket, priority, incidentOwner, startTime, bridgeName, bridgeURL, descrip, callStatus, impact ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      if($stmt = mysqli_prepare($link, $sql)){
      // Setting parameters
      $snowticket  = $_POST['snowTicket'];
      $snowticket = trim($snowticket);
    	$priority    = $_POST['priority'];
	    $owner       = $_POST['incidentOwner'];
	    $starttime   = $_POST['startTime'];
      $bridgename  = "Join Now";
	    $bridgeURL   = $_POST['bridgeURL'];
	    $description = $_POST['descrip'];
	    $callstatus  = 'Open';
	    $impact      = $_POST['impact'];
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "sssssssss", $snowticket, $priority, $owner, $starttime, $bridgename, $bridgeURL, $description, $callstatus, $impact);
      // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
        // Redirect to login page
            header("location: /hpi2/index.php");
        }else{
            printf("Error: %s.\n", mysqli_stmt_error($stmt));
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
  <form id="addHPIform" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Open High Priority Incident</h2>
      <div class="form-group">
        <label for="snowTicket">SNOW Ticket ID:*</label>
        <input type="text" class="form-control" name="snowTicket" placeholder="INC1234567" required>
      </div>
      <div class="form-group">
        <label for="priority">Incident Priority:</label>
        <select class="form-control" id="priority" name="priority">
          <option>P1</option>
          <option>P2</option>
          <option>P3</option>
          <option>P4</option>
        </select>
      </div>
      <div class="form-group">
        <label for="priority">Impact Level:</label>
        <select class="form-control" id="impact" name="impact">
          <option>Proactive</option>
          <option>Partial Outage</option>
          <option>Full Outage</option>
        </select>
      </div>
      <div class="form-group">
        <label for="incidentOwner">Incident Owner:</label>
 	<select class="form-control" id="incidentOwner" name="incidentOwner">
	  <option>Command Center</option>
	  <option>Major Incident Management</option>
        </select>
      </div>
      <div class="form-group">
        <label for="startTime">Start Date and Time</label>
	<input type="text" class="form-control" name="startTime" placeholder="01/01/00 12:12 PM">
	<?php
	if ( $dateError ) {
    	    echo '<div class="alert alert-dismissible alert-danger">';
  	    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	    echo '<span class="error">' . $dateError . '</span>';
            echo '</div>';
        }
        ?>
      </div>
      <div class="form-group">
	<label for="bridgeURL">Bridge URL</label>
        <input type="text" class="form-control" name="bridgeURL">
      </div>
      <div class="form-group">
        <label for="descrip">Incident Description:</label>
        <input id="descrip" type="text" class="form-control" name="descrip" />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="button" class="btn btn-primary" onclick="window.location='/hpi2/index.php';">Cancel</button>
  </form>
</div>
</html>

