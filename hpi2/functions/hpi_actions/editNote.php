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
    header("location: http://" . $domain .  "/hpi2/index.php");
    require_once('inc/userbar.php');
}else{
    if ( $_SESSION["memberOf"] == "Major Incident Management" ) {
        require_once('inc/navbar.php');
    }elseif ( $_SESSION["memberOf"] == "IT Business Communication" ) {
        require_once('inc/bisbar.php');
    }
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an insert statement
    $sql = "UPDATE updates SET note = ? WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Setting parameters
	$id = $_POST['noteid'];
	$note = $_POST['note'];
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $note, $id);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: http://" . $domain .  "/hpi2/index.php");
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
<form id="editNote" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Edit Incident Note</h2>
      <div class="form-group">
        <label for="priority">Incident Number:</label>
<?php 
    $id = $_GET['id'];
    $note = getOneNote($id);
    $ticket = $note[0]['parentIncident'];
    $noteid = $note[0]['id'];
    $noteinfo = $note[0]['note'];
    echo '<input type="text" readonly class="form-control-plaintext" name="snowTicket" value="' . $ticket . '">';
    echo '</div>'; 
    echo '<input type="hidden" name="noteid" value="' . $noteid . '">'; 
    echo '<div class="form-group">';
    echo '<label for="note">Note (1500 Character Limit)</label>';
    echo '<textarea class="form-control" id="note" name="note">' . $noteinfo .'</textarea>';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary">Submit</button>';
    echo '<button type="button" class="btn btn-primary" onclick="window.location=\'/hpi2/details.php?INC=' . $ticket . '\';">Cancel</button>';
?>
  </form>
</div>
</html>
