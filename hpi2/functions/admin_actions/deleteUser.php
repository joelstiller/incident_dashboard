<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');
require_once('inc/navbar.php');


if(!isset($_SESSION))
    {
        session_start();
    }

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: index.php");
}
if ( $_SESSION["memberOf"] != "Major Incident Management" ) {
    header("Location: index.php");
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an insert statement
    $sql = "DELETE FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Setting parameters
	$username = $_POST['users'];
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: index.php");
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
  <form id="deleteUser" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Delete User</h2>
      <div class="form-group">
        <label for="priority">User to Delete:</label>
        <select class="form-control" id="users" name="users">
        <?php
        $users = getUsers();
        foreach ( $users as $user ) {
            echo '<option>' . $user['username'] . '</option>';
        }
        ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Delete User</button>
      <button type="button" class="btn btn-primary" onclick="window.location='/hpi2/index.php';">Cancel</button>
  </form>
</div>
</html>
