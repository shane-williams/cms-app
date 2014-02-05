<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php
	if (isset($_POST["submit"])) {
		$menu_name = mysql_prep($_POST["menu_name"]); //string is escaped.
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
		$content = mysql_prep($_POST["content"]); //string is escaped.
		$subject_id = $_GET["subject_id"]; 
		
		// Validations
		$required_fields = array("menu_name", "position", "visible", "content");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if(!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("new_page.php?subject_id={$subject_id}"); 
		}
		
		// Query.
		$query = "INSERT INTO pages (";
		$query .= "subject_id, menu_name, position, visible, content";
		$query .= ") VALUES (";
		$query .= "{$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
		$result = mysqli_query($connection, $query);		
		
		// Redirecting based on result.
		if ($result) {
			//SUCCESS
			$_SESSION["message"] = "Page created";					
			redirect_to("manage_content.php?subject={$subject_id}");
		} else {
			// FAILURE
			$_SESSION["message"] = "Page creation failed";			
			redirect_to("new_page.php?subject_id={$subject_id}");
		}

	} else {
		redirect_to("new_subject.php");
	}	
?>

<?php
	// CLOSE DATABASE CONNECTION:
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>
<?php ob_end_flush() ?>

