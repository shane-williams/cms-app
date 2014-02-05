<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php find_selected_page(false); ?>

<?php
	$current_admin = find_admin_by_id($_GET["admin"]);
?>

<?php

	if (isset($_POST["submit"])) { // bracket ends 50.
		
		// Validations
		$required_fields = array("user", "pass");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("user" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if (empty($errors)) { // bracket ends line 51
				
			// Form data.
			$id = $current_admin["id"];
			$user = mysql_prep($_POST["user"]); //string is escaped.
			$pass = password_encrypt($_POST["pass"]); //$pass in encrypted.
			
			
			// Query.
			$query = "UPDATE admin SET ";
			$query .= "user = '{$user}', ";
			$query .= "pass = '{$pass}' ";
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection, $query);
			
			// Redirecting based on query results. 
			if ($result && mysqli_affected_rows($connection) >= 0) {
				//SUCCESS
				$_SESSION["message"] = "Admin edited";					
				redirect_to("manage_admins.php");
			} else {
				// FAILURE
				$message = "Admin editing failed";			
			}
		} 
	} else {
		// Form not submitted
	}	

?>


<?php $layout_context = "admin"; ?>
<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<main>
	
	<?php /* NAVIGATION */  include("../includes/layout/adminNav.php"); ?>
	
	<div id="content">
		<div class="errors">
			<?php
			if (!empty($message)) {
				echo "<div class=\"message\">" . htmlentities($message) . "</div>";
			}
			?>		
			<?php 
				// Checking for errors and displaying them.
				echo form_errors($errors); 			 
			 ?>
		</div>
		
		<div class="form">
			 <h2>Edit Admin</h2>
			<form action="edit_admin.php?admin=<?php echo urlencode($current_admin["id"]); ?>" method="post">
			
				<input type="text" name="user" value="<?php echo htmlentities($current_admin["user"]); ?>" />
				<br />
				<input type="password" name="pass" value="" />
				<br />
				<input type="submit" name="submit" value="Edit Admin" />
			</form>
		</div>
		
		<div class="editLinks">
			<br />
			<a href="manage_admins.php">Cancel</a>
			&nbsp;
			&nbsp;
			<a href="delete_admin.php?admin=<?php echo urlencode($current_admin["id"]) ?>" onclick="return confirm('Are you sure')">Delete Admin</a>
		</div>
		
	</div>
	
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>