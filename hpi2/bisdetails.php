<?php
// Initialize the session
if(!isset($_SESSION))
    {
        session_start();
    }

// Including database config.
require_once('inc/config.php');
require_once('inc/head.php');
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

$incident = $_GET['INC'];
$incInfo = getOneInc($incident);

// Importing Style sheet and jquery.
echo '<meta http-equiv="refresh" content="180">';
echo '<div class="container col-12">';
echo '<table id="hpitable" class="table table-hover">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Incident</th>';
echo '<th scope="col">Priority</th>';
echo '<th scope="col">Summary</th>';
echo '<th scope="col">Status</th>';
echo '<th scope="col">Impact</th>';
echo '<th scope="col" class="text-nowrap">MTTR Start Time</th>';
echo '<th scope="col" class="text-nowrap">MTTR End Time</th>';
echo '</tr>';
foreach ( $incInfo as $hpi ) {
    echo '<tr scope="row" class="table-active">';
    echo "<td>" . $hpi['snowTicket'] . "</td>";
    echo "<td>" . $hpi['priority'] . "</td>";
    echo "<td class=\"tdleft\">" . $hpi['descrip'] . "</td>";
    echo "<td>" . $hpi['callStatus'] . "</td>";
    echo "<td>" . $hpi['impact'] . "</td>";
    echo "<td>" . $hpi['startTime'] . "</td>";
    echo "<td>" . $hpi['endTime'] . "</td>";
    echo '</tr>';
}
echo '</table>';
echo '</div>'; 
// Comment Section
$notes = getBisNotes($incident);
$impact = getImpact($incident);
echo '<div class="container col-11 py-2">';
echo '<div class="row">';
echo '<div class="comments col-md-12" id="comments">';
$starttime = strtotime($hpi['startTime']);
if ($hpi['endTime']) {
   $endtime = strtotime($hpi['endTime']);
   $time =  $endtime - $starttime;
}else{
   $time =  time() - $starttime;
}
$mttr = 'Elapsed MTTR: '.secondsToTime($time);
echo '<h3 class="mb-4 font-weight-light">' . $mttr . '</h3>';
echo '<h3 class="my-4 font-weight-light">Impacted Applications</h3>';
echo '<div class="row col-12 py-2" id="impactwrap">';
foreach ( $impact as $imp ) {
    echo '<div class="card border-secondary m-1" style="max-width: 20rem;">';
    echo '<div class="card-header">' . $imp['appName'] . '</div>';
    echo '<div class="card-body">';
    echo '<p class="card-text">' . $imp['details'] . '</p>';
    echo '</div>';
    if (isset($_SESSION["memberOf"]) ) {
        if($_SESSION["memberOf"] == "IT Business Communication"){
            echo '<button type="button" class="btn btn-primary btn-sm" onclick="redirect(\'/hpi2/functions/bis_actions/deleteApp.php?ID=' . $imp['id'] . '&INC=' . $imp['parentIncident'] . '\')">Delete</button>';
        }
    }
    echo '</div>';
}
echo '</div>'; 
echo '<h3 class="my-4 font-weight-light">Updates - </h3>';
foreach ( $notes as $note ) {
    echo '<div class="comment mb-2 row border-bottom border-primary">';
    echo '<div class="comment-content col-md-11 col-sm-10">';
    echo '<h6 class="small comment-meta"><span class="text-danger pr-2">' . $note['created_by'] . '</span>    ' . $note['created_at'] . '</h6>';
    echo '<div class="comment-body">';
    echo '<p>' . $note['note'] . '</p>';
    echo '</div>';
    // Check if the user is allowed to modify things
    if (isset($_SESSION["memberOf"]) ) {
        if($_SESSION["memberOf"] == "IT Business Communication"){
            echo '<button type="button" class="btn btn-primary mr-2 btn-sm mb-2" onclick="window.location=\'/hpi2/functions/bis_actions/editNote.php?id=' . $note['id'] . '\';">Edit</button>';
            echo '<button type="button" class="btn btn-primary btn-sm mb-2" onclick="redirect(\'/hpi2/functions/bis_actions/deleteNote.php?ID=' . $note['id'] . '&INC=' . $note['parentIncident'] . '\')">Delete</button>';
        }
    }
    echo '</div>';
    echo '</div>';
}
echo '</div>';
echo '</div>'; 
echo '</div>'; 
echo '</html>';

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a Days, %h Hours and %i Minutes');
}

?>
<script>
function redirect(url){
  if (confirm('Are you sure you want to delete this note?')) {
    window.location.href=url;
  }
  return false;
}
</script>
