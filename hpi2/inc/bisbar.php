<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: /hpi2/index.php");
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
          <a class="dropdown-item" href="/hpi2/functions/bis_actions/addApp.php">Add Impacted Application</a>
          <a class="dropdown-item" href="/hpi2/functions/bis_actions/addNote.php">Add Note</a>
        </div>
      </li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/hpi2/functions/admin_actions/changePassword.php">Change Password</a>
        </div>
      </li>
    </ul>
      <form class="form-inline ml-auto" action="/hpi2/logout.php" method="POST">
          <button class="btn btn-outline-danger ml-auto" type="submit">Logout</button>
      </form>
  </div>
</nav>
