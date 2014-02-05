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
		
		// Validations
		$required_fields = array("menu_name", "position", "visible");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if(!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("new_subject.php");
		}
		
		// Query.
		$query = "INSERT INTO subjects (";
		$query .= " menu_name, position, visible, content";
		$query .= ") VALUES (";
		$query .= "'{$menu_name}', {$position}, {$visible}, '{$content}'";
		$query .= ")";
		
		$result = mysqli_query($connection, $query);
		
		// Redirecting based on result.		
		if ($result) {
			//SUCCESS
			$_SESSION["message"] = "Subject created";					
			redirect_to("manage_content.php");
		} else {
			// FAILURE
			$_SESSION["message"] = "Subject creation failed";			
			redirect_to("new_subject.php");
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

