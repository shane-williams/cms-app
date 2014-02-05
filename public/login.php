<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  logged_in(); ?>
<?php /* Checking what page we're on*/ find_selected_page(); ?>
<?php
$user = ""; // Setting so it does not return an error.

	if (isset($_POST["submit"])) { // bracket ends 50.
		
		// Validations
		$required_fields = array("user", "pass");
		validate_presences($required_fields);
		
		if (empty($errors)) { // bracket ends line 49
		
			// Form data
			$user = $_POST["user"];
			$pass = $_POST["pass"];
			
			$found_admin = attempt_login($user, $pass);
		
			// Redirecting based on query results. 
			if ($found_admin) {
				//SUCCESS: User marked as logged in.
				$_SESSION["admin_id"] = $found_admin["id"];
				$_SESSION["username"] = $found_admin["user"];			
				redirect_to("admin.php");
			} else {
				// FAILURE
				$message = "Username // Password not found";			
			}
		} 
	} else {
		// Form not submitted.
	}	

?>


<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<main>
	
	<?php /* NAVIGATION */  include("../includes/layout/publicNav.php"); ?>
	
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
			 <p>Login</p>
			<form action="login.php" method="post">
			
				<input type="text" name="user" value="<?php echo htmlentities($user); ?>" />
				<br />
				<input type="password" name="pass" value="" />
				<br />
				<input type="submit" name="submit" value="Log In" />
			</form>
		</div>
		
	</div>
	
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>