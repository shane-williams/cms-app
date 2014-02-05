<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php
	
	$current_subject = find_subject_by_id($_GET["subject"], false);
	if (!($current_subject)) {
		redirect_to("manage_content.php");
	}
	
	// Only allows a subject to be deleted if it has no pages.
	$pages_set = find_pages_for_subject($current_subject["id"]);
	if (mysqli_num_rows($pages_set) > 0) {
		$_SESSION["message"] = "Can't delete a subject with pages, delete pages first.";			
		redirect_to("manage_content.php?subject={$current_subject["id"]}");	
	}
	
	// Query
	$id = $current_subject["id"];
	$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	// Query Results
	if ($result && mysqli_affected_rows($connection) == 1) {
		//SUCCESS
		$_SESSION["message"] = "Subject deleted";					
		redirect_to("manage_content.php");	
	} else {
		// FAILURE
		$_SESSION["message"] = "Subject deletion failed";			
		redirect_to("manage_content.php?subject={$id}");	
	}

?>
<?php ob_end_flush() ?>
