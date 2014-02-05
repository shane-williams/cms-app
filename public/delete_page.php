<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php
	$current_page = find_page_by_id($_GET["page"], false);
	if (!($current_page)) {
		redirect_to("manage_content.php");
	}
	
	// Query
	$id = $current_page["id"];
	$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	// Query Results
	if ($result && mysqli_affected_rows($connection) == 1) {
		//SUCCESS
		$_SESSION["message"] = "Page Deleted";					
		redirect_to("manage_content.php");	
	} else {
		// FAILURE
		$_SESSION["message"] = "Page deletion failed";			
		redirect_to("manage_content.php?page={$id}");	
	}
?>
<?php ob_end_flush() ?>
