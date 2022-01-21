<?php

// Initialize the session
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

//Including database config.
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
// Content refresh every 3 minutes.
echo '<meta http-equiv="refresh" content="180">';
echo '<div class="container col-12 pt-2">';

// Getting list of incidents.
$current_hpi = indexPopulate();

// Primary table formatting code.
echo '<h2 class="display-5 text-center  text-white bg-primary col-12 py-2">MIM IT Dashboard</h2>';
echo '<table id="hpitable" class="col-12 table table-secondary table-hover w-100">';
echo '<thead>';
echo '<tr class="table-primary">';
echo '<th scope="col">Incident</th>';
echo '<th scope="col">Priority</th>';
echo '<th scope="col">Summary</th>';
echo '<th scope="col">Status</th>';
echo '<th scope="col">Impact</th>';
echo '<th scope="col">Bridge Link</th>';
echo '<th scope="col" class="text-nowrap">MTTR Start Time</th>';
echo '<th scope="col" class="text-nowrap">MTTR End Time</th>';
echo '<th scope="col">Incident Owner</th>';
echo '<th scope="col">Last Updated</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Running population functions!

//Open Incidents.
tablePop($current_hpi, 'Open', 'P1', '7200', '3600', 'Major Incident Management');
tablePop($current_hpi, 'Open', 'P2', '14400', '7200', 'Major Incident Management');
tablePop($current_hpi, 'Open', 'P3', '21600', '10800', 'Major Incident Management');
tablePop($current_hpi, 'Open', 'P4', '86400', '43200', 'Major Incident Management');

// Resolved Incidents.
tablePop($current_hpi, 'Resolved', 'P1', '7200', '3600', 'Major Incident Management');
tablePop($current_hpi, 'Resolved', 'P2', '14400', '7200', 'Major Incident Management');
tablePop($current_hpi, 'Resolved', 'P3', '21600', '10800', 'Major Incident Management');
tablePop($current_hpi, 'Resolved', 'P4', '86400', '43200', 'Major Incident Management');

// Closed Events
tablePop($current_hpi, 'Closed', 'P1', '7200', '3600', 'Major Incident Management');
tablePop($current_hpi, 'Closed', 'P2', '14400', '7200', 'Major Incident Management');
tablePop($current_hpi, 'Closed', 'P3', '21600', '10800', 'Major Incident Management');
tablePop($current_hpi, 'Closed', 'P4', '86400', '43200', 'Major Incident Management');

echo '</tbody>';
echo '</table>';

// Writing Command Center Table.
echo '<h2 class="display-5 text-center  text-white bg-primary col-12 py-2">CC IT Dashboard</h2>';
echo '<table id="hpitable" class="col-12 table table-secondary table-hover w-100">';
echo '<thead>';
echo '<tr class="table-primary">';
echo '<th scope="col">Incident</th>';
echo '<th scope="col">Priority</th>';
echo '<th scope="col">Summary</th>';
echo '<th scope="col">Status</th>';
echo '<th scope="col">Impact</th>';
echo '<th scope="col">Bridge Link</th>';
echo '<th scope="col" class="text-nowrap">MTTR Start Time</th>';
echo '<th scope="col" class="text-nowrap">MTTR End Time</th>';
echo '<th scope="col">Incident Owner</th>';
echo '<th scope="col">Last Updated</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Running population functions!

//Open Incidents.
tablePop($current_hpi, 'Open', 'P1', '7200', '3600', 'Command Center');
tablePop($current_hpi, 'Open', 'P2', '14400', '7200', 'Command Center');
tablePop($current_hpi, 'Open', 'P3', '21600', '10800', 'Command Center');
tablePop($current_hpi, 'Open', 'P4', '86400', '43200', 'Command Center');

// Resolved Incidents.
tablePop($current_hpi, 'Resolved', 'P1', '7200', '3600', 'Command Center');
tablePop($current_hpi, 'Resolved', 'P2', '14400', '7200', 'Command Center');
tablePop($current_hpi, 'Resolved', 'P3', '21600', '10800', 'Command Center');
tablePop($current_hpi, 'Resolved', 'P4', '86400', '43200', 'Command Center');

// Closed Events
tablePop($current_hpi, 'Closed', 'P1', '7200', '3600', 'Command Center');
tablePop($current_hpi, 'Closed', 'P2', '14400', '7200', 'Command Center');
tablePop($current_hpi, 'Closed', 'P3', '21600', '10800', 'Command Center');
tablePop($current_hpi, 'Closed', 'P4', '86400', '43200', 'Command Center');

echo '</tbody>';
echo '</table>';


echo '</div>'; 
echo '</html>';


// Function to populate tables.
function tablePop($hpis, $status, $prio, $mttr_red, $mttr_yel, $owner) {
    foreach ( $hpis as $hpi ) {
        if ( ( $hpi['callStatus'] == "$status") && ( $hpi['priority'] == "$prio") && ( $hpi['incidentOwner'] == "$owner")) {
            $starttime = strtotime($hpi['startTime']);
            if ($hpi['endTime']) {
                $endtime = strtotime($hpi['endTime']);
                $time =  $endtime - $starttime;
            }else{
                $time =  time() - $starttime;
            }
            echo '<tr scope="row" class="table-secondary" onclick="window.location.assign(\'/hpi2/details.php?INC=' . $hpi['snowTicket'] . '\');">';
            echo "<td>" . $hpi['snowTicket'] . "</td>";
            echo "<td>" . $hpi['priority'] . "</td>";
            echo "<td>" . $hpi['descrip'] . "</td>";
            echo "<td>" . $hpi['callStatus'] . "</td>";
            echo "<td>" . $hpi['impact'] . "</td>";
            echo "<td><a class=\"text-info\" href=\"" . $hpi['bridgeURL'] . "\">Join Here!</a></td>";
	    if ( ($time > $mttr_red) && ($hpi['impact'] != "Proactive") ) {
                echo "<td class=\"bg-danger text-white text-nowrap\">" . $hpi['startTime'] . "</td>";
	    }elseif ( ($time > $mttr_yel) && ($hpi['impact'] != "Proactive") ) {
                echo "<td class=\"bg-warning text-nowrap\">" . $hpi['startTime'] . "</td>";
	    }else{
                echo "<td class=\"text-nowrap\">" . $hpi['startTime'] . "</td>";
	    }
            echo "<td class=\"text-nowrap\">" . $hpi['endTime'] . "</td>";
            echo "<td>" . $hpi['incidentOwner'] . "</td>";
	    $tick = $hpi['snowTicket'];
	    $last_up = getLastNoteFromInc($tick);
            $dt = $last_up[0]['outdate'];
            $date = date_create($dt);
            $janky = date_format($date, 'm/d/y h:i A');
            echo "<td class=\"text-nowrap\">" . $janky . "</td>";
            echo '</tr>';
        }
    }
};

?>
