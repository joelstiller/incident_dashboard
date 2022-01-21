<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

$domain = $_SERVER['HTTP_HOST'];

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: http://" . $domain .  "/hpi2/index.php");
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">High Priority Incident Dashboard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/hpi2/index.php">IT Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/hpi2/businessIndex.php">Business Dashboard</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Incident Actions</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/hpi2/functions/hpi_actions/openHpi.php">Open New HPI</a>
          <a class="dropdown-item" href="/hpi2/functions/hpi_actions/editHpi.php">Edit HPI</a>
          <a class="dropdown-item" href="/hpi2/functions/hpi_actions/resolveHpi.php">Resolve HPI</a>
          <a class="dropdown-item" href="/hpi2/functions/hpi_actions/closeHpi.php">Close HPI</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/hpi2/functions/hpi_actions/addNote.php">Add Note</a>
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/hpi2/functions/admin_actions/addUser.php">Add User</a>
          <a class="dropdown-item" href="/hpi2/functions/admin_actions/deleteUser.php">Delete User</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/hpi2/functions/admin_actions/changePassword.php">Change Password</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
        <div class="dropdown-menu" style="width: 200px;height: 100px;" aria-labelledby="navbarDropdown">
            <form class="form" role="form" action="/hpi2/inc/post_cssmode.php" method="POST">
            <div class="theme-switch-wrapper">
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" name="cssmode" value="Dark" />
                    <div class="slider round"></div>
                </label>
                <em>Enable Dark Mode!</em>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
            </form>
         </div>
      </li>
    </ul>
    <form class="form-inline ml-auto" action="/hpi2/logout.php" method="POST">
        <button class="btn btn-outline-danger ml-auto" type="submit">Logout</button>
    </form>
  </div>
</nav>
