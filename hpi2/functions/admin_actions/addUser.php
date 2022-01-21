<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');
require_once('inc/navbar.php');

if(!isset($_SESSION))
    {
        session_start();
    }

$domain = $_SERVER['HTTP_HOST'];
// Check if the user is logged in, if not then redirect him to login page

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: http://" . $domain .  "/hpi2/index.php");
}
if ( $_SESSION["memberOf"] != "Major Incident Management" && $_SESSION['username'] != 'admin' ) {
    header("location: http://" . $domain .  "/hpi2/index.php");
}

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $post_un = trim($_POST["username"]); 
    $post_pass = trim($_POST["password"]);
    $displayname = trim($_POST["displayname"]);
    $member = $_POST['member'];
    // Validate username
    if(empty($post_un)){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Validate password
    if(empty($post_pass)){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, displayname, salt, memberOf, cssMode) VALUES (?, ?, ?, ?, ?, ?)";
        $css_mod = 'Light'; 
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $displayname, $salt, $member, $css_mod);
            
            // Set parameters
            $param_username = $username;
	    // Lets add some salt.
            $random_chars = "";
            $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
            for($i=0; $i < 22; $i++) {
                $random_chars .= $salt_chars[array_rand($salt_chars)];
            }
	    $salt = "$2a$10$" . "$random_chars";
	    $salted_password = crypt($password, $salt);
            $param_password = $salted_password; // Creates a password hash
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: http://" . $domain .  "/hpi2/index.php");
            } else{
		printf("Error: %s.\n", mysqli_stmt_error($stmt));
                echo "Testing --- Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

?>

<div class="my-lg-5 col-lg-3">
  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <legend>Add User</legend>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="displayname" class="form-control">
            </div>    
            <div class="form-group">
                <label>Group</label>
                <select class="form-control" id="member" name="member">
		    <option>Major Incident Management</option>
		    <option>IT Business Communications</option>
		</select>
            </div>    
      <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
</form>
</html>

