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
    header("Location: /hpi2/index.php");
    require_once('inc/userbar.php');
}else{
    if ( $_SESSION["memberOf"] == "Major Incident Management" ) {
        require_once('inc/navbar.php');
    }elseif ( $_SESSION["memberOf"] == "IT Business Communication" ) {
        require_once('inc/bisbar.php');
    }
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an insert statement
    $sql = "UPDATE incidents SET priority = ?, incidentOwner = ?, startTime = ?, endTime = ?, callStatus = ?, bridgeURL = ?, descrip = ?, impact = ? WHERE snowTicket = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Setting parameters
        $snowticket  = $_POST['snowTicket'];
        $priority    = $_POST['priority'];
        $owner       = $_POST['incidentOwner'];
        $starttime   = $_POST['startTime'];
	    $endtime     = $_POST['endTime'];
        $callstatus  = $_POST['callStatus'];
        $bridgeURL   = $_POST['bridgeURL'];
        $description = $_POST['descrip'];
        $impact      = $_POST['impact'];
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssssss", $priority, $owner, $starttime, $endtime, $callstatus, $bridgeURL, $description, $impact, $snowticket);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: /hpi2/index.php");
        }else{
            echo "Something went wrong. Please try again later.";
        }
     }
    // Close statement
    mysqli_stmt_close($stmt);
    // Close connection
    mysqli_close($link);
}

?>

<div class="container h-100 my-lg-5 col-6">
    <form id="nosubmit" class="form-style-8">
    <label for="keyField">Entry to Edit:</label>
        <select class="form-group custom-select" name="keyField" id="keyField">
            <option disabled selected> -- Select Incident -- </option>
        <?php
        $current_hpi = getHPIS();
        foreach ( $current_hpi as $hpi ) {
            if ( $hpi['callStatus'] != 'Closed' ) {
            echo '<option>' . $hpi['snowTicket'] . '</option>';
            };
        }
        ?>
        </select>
    </form>
<form id="editHPI" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
</form>

<script type="text/javascript">
// Get host details on selection.
$('#keyField').on('change', function(){
    var snowTicket = $('#keyField option:selected' ).text(); // or $(this).val()
    $.ajax({
        url: "/hpi2/functions/getEditForm.php",
        method: "POST",
        dataType:'html',
        timeout: 5000,
        data: {"snowTicket": snowTicket},
        success: function(html) {
            $('#editHPI').empty();
            $("#editHPI").append(html);
        }
    });
});
</script>
</html>
