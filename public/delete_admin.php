<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php
	
	$current_admin = find_admin_by_id($_GET["admin"]);
	if (!($current_admin)) {
		redirect_to("manage_admins.php");
	}
	
	// Query
	$id = $current_admin["id"];
	$query = "DELETE FROM admin WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	// Query Results
	if ($result && mysqli_affected_rows($connection) == 1) {
		//SUCCESS
		$_SESSION["message"] = "Admin deleted";					
		redirect_to("manage_admins.php");	
	} else {
		// FAILURE
		$_SESSION["message"] = "Admin deletion failed";			
		redirect_to("manage_admins.php?subject={$id}");	
	}

?>
<?php ob_end_flush() ?>