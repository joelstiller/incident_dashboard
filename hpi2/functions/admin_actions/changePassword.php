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
    require_once('inc/userbar.php');
}else{
    if ( $_SESSION["memberOf"] == "Major Incident Management" ) {
        require_once('inc/navbar.php');
    }elseif ( $_SESSION["memberOf"] == "IT Business Communication" ) {
        require_once('inc/bisbar.php');
    }
}

$username = $_SESSION["username"];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Prepare an insert statement
    $sql = "UPDATE users SET password = ?, salt = ?  WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Setting parameters
	$password    = $_POST['password'];
        // Lets add some salt.
        $random_chars = "";
        $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i < 22; $i++) {
            $random_chars .= $salt_chars[array_rand($salt_chars)];
        }
        $salt = "$2a$10$" . "$random_chars";
        $salted_password = crypt($password, $salt);

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $salted_password, $salt, $username);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            $domain = $_SERVER['HTTP_HOST'];
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


echo '<div class="my-lg-5 col-lg-3">';
echo '<form class="form-horizontal" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
echo '<div class="form-group">';
echo '<label>New Password</label>';
echo '<input type="password" name="password" class="form-control">';
echo '</div>';
echo '<button type="submit" class="btn btn-primary mr-2" value="Submit">Submit</button>';
echo '<button type="button" class="btn btn-primary" onclick="window.location=\'/hpi2/index.php\';">Cancel</button>';
echo '</form>';
echo '</div>';
echo '</html>';

?>
