<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>
<?php
	if (isset($_POST["submit"])) {
		$user = mysql_prep($_POST["user"]); //string is escaped.
		$pass = password_encrypt($_POST["pass"]); //$pass is encrypted.
		
		// Validations
		$required_fields = array("user", "pass");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("user" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if(!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("new_admin.php");
		}
		
		// Puery.
		$query = "INSERT INTO admin (";
		$query .= " user, pass";
		$query .= ") VALUES (";
		$query .= "'{$user}', '{$pass}'";
		$query .= ")";
		
		$result = mysqli_query($connection, $query);
		
		// Redirecting based on result.		
		if ($result) {
			//SUCCESS
			$_SESSION["message"] = "Admin Created";					
			redirect_to("manage_admins.php");
		} else {
			// FAILURE
			$_SESSION["message"] = "Admin creation failed";			
			redirect_to("new_admin.php");
		}

	} else {
		redirect_to("new_admin.php");
	}	
?>

<?php
	// CLOSE DATABASE CONNECTION:
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>
<?php ob_end_flush() ?>
