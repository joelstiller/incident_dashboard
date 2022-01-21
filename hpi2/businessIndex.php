<?php
// Initialize the session
if(!isset($_SESSION))
    {
        session_start();
    }

#Including database config.
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
// P# MTTR
$mttrScale = array(
    'P1' => '7200',
    'P2' => '14400',
    'P3' => '21600',
    'P4' => '86400'
);
// Importing Style sheet and jquery.
echo '<meta http-equiv="refresh" content="180">';
echo '<div class="container col-12 pt-2">';
$current_hpi = indexPopulate();
echo '<h2 class="display-5 text-center  text-white bg-primary col-12 py-2">Business Dashboard</h2>';
echo '<table id="hpitable" class="table table-secondary table-hover">';
echo '<thead>';
echo '<tr class="table-primary">';
echo '<th scope="col">Incident</th>';
echo '<th scope="col">Priority</th>';
echo '<th scope="col">Summary</th>';
echo '<th scope="col">Status</th>';
echo '<th scope="col">Impact</th>';
echo '<th scope="col" class="text-nowrap">MTTR Start Time</th>';
echo '<th scope="col" class="text-nowrap">MTTR End Time</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ( $current_hpi as $hpi ) {
  if ( $hpi['impact'] != "Proactive" ) {
    if ( ( $hpi['callStatus'] == 'Open') && ( $hpi['priority'] == 'P1') ) {
        $starttime = strtotime($hpi['startTime']);
        if ($hpi['endTime']) {
            $endtime = strtotime($hpi['endTime']);
            $time =  $endtime - $starttime;
        }else{
            $time =  time() - $starttime;
        }
	if ( $time > 7200 ) {
            echo '<tr scope="row" class="bg-danger" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
	}elseif ($time > 3600) {
            echo '<tr scope="row" class="bg-warning" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
	}else{
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
	}
        echo "<td>" . $hpi['snowTicket'] . "</td>";
        echo "<td>" . $hpi['priority'] . "</td>";
        echo "<td>" . $hpi['descrip'] . "</td>";
        echo "<td>" . $hpi['callStatus'] . "</td>";
        echo "<td>" . $hpi['impact'] . "</td>";
        echo "<td>" . $hpi['startTime'] . "</td>";
        echo "<td>" . $hpi['endTime'] . "</td>";
        echo '</tr>';
    }
  }
}

foreach ( $current_hpi as $hpi ) {
  if ( $hpi['impact'] != "Proactive" ) {
    if ( ( $hpi['callStatus'] == 'Open') && ( $hpi['priority'] == 'P2') ) {
        $starttime = strtotime($hpi['startTime']);
        if ($hpi['endTime']) {
            $endtime = strtotime($hpi['endTime']);
            $time =  $endtime - $starttime;
        }else{
            $time =  time() - $starttime;
        }
        if ( $time > 14400 ) {
            echo '<tr scope="row" class="bg-danger" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }elseif ($time > 7200) {
            echo '<tr scope="row" class="bg-warning" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }else{
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }
        echo "<td>" . $hpi['snowTicket'] . "</td>";
        echo "<td>" . $hpi['priority'] . "</td>";
        echo "<td>" . $hpi['descrip'] . "</td>";
        echo "<td>" . $hpi['callStatus'] . "</td>";
        echo "<td>" . $hpi['impact'] . "</td>";
        echo "<td>" . $hpi['startTime'] . "</td>";
        echo "<td>" . $hpi['endTime'] . "</td>";
        echo '</tr>';
    }
  }
}

// Resolved Events
foreach ( $current_hpi as $hpi ) {
  if ( $hpi['impact'] != "Proactive" ) {
    if ( ( $hpi['callStatus'] == 'Resolved') && ( $hpi['priority'] == 'P1') ) {
        $starttime = strtotime($hpi['startTime']);
        if ($hpi['endTime']) {
            $endtime = strtotime($hpi['endTime']);
            $time =  $endtime - $starttime;
        }else{
            $time =  time() - $starttime;
        }
        if ( $time > 7200 ) {
            echo '<tr scope="row" class="bg-danger" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }elseif ($time > 3600) {
            echo '<tr scope="row" class="bg-warning" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }else{
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }
        echo "<td>" . $hpi['snowTicket'] . "</td>";
        echo "<td>" . $hpi['priority'] . "</td>";
        echo "<td>" . $hpi['descrip'] . "</td>";
        echo "<td>" . $hpi['callStatus'] . "</td>";
        echo "<td>" . $hpi['impact'] . "</td>";
        echo "<td>" . $hpi['startTime'] . "</td>";
        echo "<td>" . $hpi['endTime'] . "</td>";
        echo '</tr>';
    }
  }
}
foreach ( $current_hpi as $hpi ) {
  if ( $hpi['impact'] != "Proactive" ) {
    if ( ( $hpi['callStatus'] == 'Resolved') && ( $hpi['priority'] == 'P2') ) {
        $starttime = strtotime($hpi['startTime']);
        if ($hpi['endTime']) {
            $endtime = strtotime($hpi['endTime']);
            $time =  $endtime - $starttime;
        }else{
            $time =  time() - $starttime;
        }
        if ( $time > 14400 ) {
            echo '<tr scope="row" class="bg-danger" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }elseif ($time > 7200) {
            echo '<tr scope="row" class="bg-warning" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }else{
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }
        echo "<td>" . $hpi['snowTicket'] . "</td>";
        echo "<td>" . $hpi['priority'] . "</td>";
        echo "<td>" . $hpi['descrip'] . "</td>";
        echo "<td>" . $hpi['callStatus'] . "</td>";
        echo "<td>" . $hpi['impact'] . "</td>";
        echo "<td>" . $hpi['startTime'] . "</td>";
        echo "<td>" . $hpi['endTime'] . "</td>";
        echo '</tr>';
    }
  }
}

// Closed events
foreach ( $current_hpi as $hpi ) {
  if ( $hpi['impact'] != "Proactive" ) {
    if ( ( $hpi['callStatus'] == 'Closed') && ( $hpi['priority'] == 'P1') ) {
        $starttime = strtotime($hpi['startTime']);
        if ($hpi['endTime']) {
            $endtime = strtotime($hpi['endTime']);
            $time =  $endtime - $starttime;
        }else{
            $time =  time() - $starttime;
        }
        if ( $time > 7200 ) {
            echo '<tr scope="row" class="bg-danger" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }elseif ($time > 3600) {
            echo '<tr scope="row" class="bg-warning" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }else{
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }
        echo "<td>" . $hpi['snowTicket'] . "</td>";
        echo "<td>" . $hpi['priority'] . "</td>";
        echo "<td>" . $hpi['descrip'] . "</td>";
        echo "<td>" . $hpi['callStatus'] . "</td>";
        echo "<td>" . $hpi['impact'] . "</td>";
        echo "<td>" . $hpi['startTime'] . "</td>";
        echo "<td>" . $hpi['endTime'] . "</td>";
        echo '</tr>';
    }
  }
}
foreach ( $current_hpi as $hpi ) {
  if ( $hpi['impact'] != "Proactive" ) {
    if ( ( $hpi['callStatus'] == 'Closed') && ( $hpi['priority'] == 'P2') ) {
        $starttime = strtotime($hpi['startTime']);
        if ($hpi['endTime']) {
            $endtime = strtotime($hpi['endTime']);
            $time =  $endtime - $starttime;
        }else{
            $time =  time() - $starttime;
        }
        if ( $time > 14400 ) {
            echo '<tr scope="row" class="bg-danger" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }elseif ($time > 7200) {
            echo '<tr scope="row" class="bg-warning" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }else{
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/bisdetails.php?INC=' . $hpi['snowTicket'] . '\');">';
        }
        echo "<td>" . $hpi['snowTicket'] . "</td>";
        echo "<td>" . $hpi['priority'] . "</td>";
        echo "<td>" . $hpi['descrip'] . "</td>";
        echo "<td>" . $hpi['callStatus'] . "</td>";
        echo "<td>" . $hpi['impact'] . "</td>";
        echo "<td>" . $hpi['startTime'] . "</td>";
        echo "<td>" . $hpi['endTime'] . "</td>";
        echo '</tr>';
    }
  }
}

echo '</tbody>';
echo '</table>';
echo '</div>'; 
echo '</html>';
?>

