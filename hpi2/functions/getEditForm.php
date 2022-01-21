<?php
#Including database config.
require_once('inc/config.php');
require_once('inc/head.php');
//require_once('inc/navbar.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $snowticket = $_POST['snowTicket'];
    $dbrow = getOneInc($snowticket);
    // Spitting out a new form.
    echo '<h2>Edit Incident</h2>';
    // Snowticket Div
    echo '<div class="form-group">';
    echo '<label for="snowTicket">SNOW Ticket ID:*</label>';
    echo '<input type="text" readonly class="form-control-plaintext custom-select" name="snowTicket" value="' . $dbrow[0]['snowTicket'] . '">';
    echo '</div>';
    // Incident Priority
    echo '<div class="form-group">';
    echo '<label for="priority" >Incident Priority:</label>';
    echo '<select class="form-control" id="priority" name="priority">';
    $pri = $dbrow[0]['priority'];
    if ( $pri == 'P1' ) {
        echo '<option selected>P1</option>';
    }else{
        echo '<option>P1</option>';
    }
    if ( $pri == 'P2' ) {
        echo '<option selected>P2</option>';
    }else{
        echo '<option>P2</option>';
    }
    if ( $pri == 'P3' ) {
        echo '<option selected>P3</option>';
    }else{
        echo '<option>P3</option>';
    }
    if ( $pri == 'P4' ) {
        echo '<option selected>P4</option>';
    }else{
        echo '<option>P4</option>';
    }
    echo '</select>';
    echo '</div>';
    // Impact
    echo '<div class="form-group">';
    echo '<label for="priority">Impact Level:</label>';
    echo '<select class="form-control" id="impact" name="impact">';
    $imp = $dbrow[0]['impact'];
    if ( $imp == 'Proactive' ) {
        echo '<option selected>Proactive</option>';
    }else{
        echo '<option>Proactive</option>';
    }
    if ( $imp == 'Partial Outage' ) {
        echo '<option selected>Partial Outage</option>';
    }else{
        echo '<option>Partial Outage</option>';
    }
    if ( $imp == 'Full Outage' ) {
        echo '<option selected>Full Outage</option>';
    }else{
        echo '<option>Full Outage</option>';
    }
    echo '</select>';
    echo '</div>';
    // Call Status
    echo '<div class="form-group">';
    $status = $dbrow[0]['callStatus'];
    echo '<label for="callStatus" >Call Status:</label>';
    echo '<select class="form-control" id="callStatus" name="callStatus">';
    echo '<option selected>Open</option>';
    echo '</select>';
    echo '</div>';
    // Incident Owner
    echo '<div class="form-group">';
    echo '<label for="incidentOnwer" >Incident Owner:</label>';
    echo '<select class="form-control" id="incidentOwner" name="incidentOwner">';
    $w_group = $dbrow[0]['incidentOwner'];
    if ( $w_group == 'Command Center' ) {
	echo '<option selected>Command Center</option>';
	echo '<option>Major Incident Management</option>';
    }elseif ( $w_group == 'Major Incident Management' ) {
	echo '<option>Command Center</option>';
	echo '<option selected>Major Incident Management</option>';
    }
    echo '</select>';
    echo '</div>';
    // Bridge Start Time
    echo '<div class="form-group">';
    echo '<label for="startTime">Start Date and Time</label>';
    echo '<input type="text" class="form-control" name="startTime" value="' . $dbrow[0]['startTime'] . '">';
    echo '</div>';
    // Bridge End Time
    echo '<div class="form-group">';
    echo '<label for="endTime">End Date and Time</label>';
    echo '<input type="text" class="form-control" name="endTime" value="' . $dbrow[0]['endTime'] . '">';
    echo '</div>';
    $bname = $dbrow[0]['bridgeName'];
    $url   = $dbrow[0]['bridgeURL'];
    // Bridge URL
    echo '<div class="form-group">';
    echo '<label for="bridgeURL">WebEX URL</label>';
    echo '<input type="text" class="form-control" name="bridgeURL" required="" value="' . $url . '">';
    echo '</div>';
    // Description 
    echo '<div class="form-group">';
    echo '<label for="descrip">Incident Description</label>';
    echo '<input id="descrip" type="text" class="form-control" name="descrip" value="' .  $dbrow[0]['descrip'] . '">';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary mr-2">Submit</button>';
    echo '<button type="button" class="btn btn-primary" onclick="window.location=\'/hpi2/index.php\';">Cancel</button>';
}
?>
