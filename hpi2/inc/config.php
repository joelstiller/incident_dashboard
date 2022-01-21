<?php
/* Database credentials. Assuming you are running MySQL server */
/* You must define these values for yourself */
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'incident_db');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// Below here are a bunch of functions that are used to perform various database actions.

// getHPIS function gets all rows from incidents table.
function getHPIS() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $result = $link->prepare("SELECT * FROM incidents");
    $result->execute();
    $result = $result->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// indexPopulate is used to populate the index page with the last 24 hours of incidents, it will include longer open items if they are in the open or resolved status. Closed incidents
// will still exist in the database, but will not be shown.
function indexPopulate() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $result = $link->prepare("SELECT * FROM incidents WHERE created_at >= DATE_SUB( NOW(), INTERVAL 24 HOUR ) OR callStatus = 'Open' OR callStatus = 'Resolved'");
    $result->execute();
    $result = $result->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getOpenTickets as it's named, this gets all incidents with a status of "Open"
function getOpenTickets() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $result = $link->prepare("SELECT * FROM incidents WHERE callStatus = 'Open'");
    $result->execute();
    $result = $result->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getResolvedTickets gets all tickets with a status of "Resolved"
function getResolvedTickets() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $result = $link->prepare("SELECT * FROM incidents WHERE callStatus = 'Resolved'");
    $result->execute();
    $result = $result->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getOneInc this function gets a single incident
// Expected input (ticket number)
function getOneInc($inc) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT * FROM incidents WHERE snowTicket = ?");
    $stmt->bind_param("s", $inc);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getNotes this function gets all notes associated with an incident for the major incident page.
// Expected input (ticket number)
function getNotes($inc) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT * FROM updates WHERE parentIncident = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $inc);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getBisNotes this function gets all notes associated with issues on the business page.
// Expected input (ticket number)
function getBisNotes($inc) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT * FROM businessUpdates WHERE parentIncident = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $inc);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);

}

// getImpact this function gets a specific issue for the buisness page. Why? Because the customer wanted it this way.
// Expected input (ticket number)
function getImpact($inc) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT * FROM impactedApps WHERE parentIncident = ?");
    $stmt->bind_param("s", $inc);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);

}

// getOneNote this function gets a single mim note.
// Expected input (note id)
function getOneNote($id) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT * FROM updates WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getOneBisNote this function gets a single buisness note
// Expected input (buisness note id)
function getOneBisNote($id) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT * FROM businessUpdates WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getUsers this funciton gets all users
function getUsers() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT username FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// getLastNoteFromInc this funciton gets the latest note for an incident
// Expected intput (incident number)
function getLastNoteFromInc($inc) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT MAX(created_at) as outdate FROM updates WHERE parentIncident = ?");
    $stmt->bind_param("s", $inc);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}

// Get light or dark mode info.

function getCssMode($username) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("SELECT cssmode FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    return($res);
}
// Update mode
function putCssMode($username, $cssmode) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $stmt = $link->prepare("UPDATE users SET cssMode = ? WHERE username = ?");
    $stmt->bind_param("ss", $cssmode, $username);
    $stmt->execute();
    return($stmt);
}

// This function is used to dump STDIN output to a file. Useful for troubleshooting bugs.
function Dump2File($dumpy) {
    ob_start();
    var_dump($dumpy);
    $output = ob_get_clean();
    // Edit this path to put the file where you'd like to put it.
    $outputFile = 'output.txt';
    $filehandle = fopen($outputFile, 'a') or die('File creation error.');
    fwrite($filehandle, $output);
    fclose($filehandle);
}

?>

