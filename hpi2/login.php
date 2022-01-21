<?php
// Initialize the session
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}
 
// Include config file
require_once "inc/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Fixing nonsense.
    $passed_username = trim($_POST["username"]);
    $passed_password = trim($_POST["password"]); 
    // Check if username is empty
    if(empty($passed_username)){
        $username_err = "Please enter username.";
    }else{
        $username = $passed_username;
    }
    
    // Check if password is empty
    if(empty($passed_password)){
        $password_err = "Please enter your password.";
    } else{
        $password = $passed_password;
    }
    
    // =======> READ THIS!!!! ATTENTION!!!!!!!!!!!!!!! <=============
    // From this point to the comment //END ADMIN LOGIN is used for a fresh install. Once you've logged in as this account,
    // you should create a new administrative user, and comment/delete this code from your instance. Leaving this code in will be a security
    // risk for your application.  
    if ($username == 'admin' && $password == 'admin') {
        // Password is correct, so start a new session
        session_start();

        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username;
        $_SESSION["displayname"] = 'Admin';
        // Redirect user to welcome page
        header("location: index.php");
        exit();
    }
    //END ADMIN LOGIN
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, displayname, salt, memberOf, cssMode FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $displayname, $salt, $memberOf, $cssMode);
                    if(mysqli_stmt_fetch($stmt)){
		                $entered_password = crypt($password, $salt);
                        if($entered_password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
			                $_SESSION["displayname"] =  $displayname;
                            $_SESSION["memberOf"] = $memberOf; 
			                $_SESSION["cssMode"] = $cssMode;
                            // Redirect user to welcome page
                            if ( $memberOf == "Major Incident Management" ) {
                                            header("location: index.php");
                            }else{
			                    header("location: businessIndex.php");
			                }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }else{
                        // Display an error message if username doesn't exist
                        $username_err = "No account found with that username.";
		            }
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/hpi2/css/bootstrap.min.css">
    <script type="text/javascript" src="/hpi2/js/jquery-3.1.1.min.js"></script>
</head>
<body>
<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6- col-md-6 col-lg-4 col-xl-3">
        <h2>HPI Admin Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info btn-lg btn-block" value="Login">
            </div>
        </form>
</body>
</html>


