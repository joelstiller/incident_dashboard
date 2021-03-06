<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');
require_once('inc/bisbar.php');

if(!isset($_SESSION))
    {
        session_start();
    }
$domain = $_SERVER['HTTP_HOST'];

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: http://" . $domain .  "/hpi2/businessIndex.php");
}
if ( $_SESSION["memberOf"] != "IT Business Communication" ) {
    header("location: http://" . $domain .  "/hpi2/businessIndex.php");
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an insert statement
    $sql = "INSERT INTO impactedApps (parentIncident, appName , details) VALUES (?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // Setting parameters
	$parentincident = $_POST['incident'];
	$appname        = $_POST['app'];
	$note           = $_POST['note'];
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $parentincident, $appname, $note);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: http://" . $domain .  "/hpi2/businessIndex.php");
        }else{
            echo "Something went wrong. Please try again later.";
        }
     }
    // Close statement
    mysqli_stmt_close($stmt);
    // Close connection
    mysqli_close($link);
}

?>

<div class="container h-100 my-lg-5 col-6">
  <form id="addNote" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Add Impacted Application</h2>
      <div class="form-group">
        <label for="priority">Incident Number:</label>
        <select class="form-control" id="incident" name="incident">
        <?php 
	$current_hpi = getHPIS();
	foreach ( $current_hpi as $hpi ) {
            if ( $hpi['callStatus'] != 'Closed' ) {
	    echo '<option>' . $hpi['snowTicket'] . '</option>';
	    };
	}
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="app">App Name</label>
	<input class="form-control" id="app" name="app">
      </div>
      <div class="form-group">
        <label for="note">Note (2000 Character Limit)</label>
	<textarea class="form-control col-md-12" rows="20" id="note" name="note"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="button" class="btn btn-primary" onclick="window.location='/hpi2/businessIndex.php';">Cancel</button>
  </form>
</div>
</html>
