<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php $index = show_index(); ?>


<?php

	if (isset($_POST["submit"])) { // bracket ends 47.
		
		// Validations
		$required_fields = array("content");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("heading" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if (empty($errors)) { // bracket ends line 46
				
			// Form data.
			$id = $index["id"];
			$heading = mysql_prep($_POST["heading"]); //string is escaped.
			$content = mysql_prep($_POST["content"]); //string is escaped.
			
			// Here's the query.
			$query = "UPDATE home SET ";
			$query .= "heading = '{$heading}', ";
			$query .= "content = '{$content}' ";			
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection, $query);
			
			// Redirecting based on query results. 
			if ($result && mysqli_affected_rows($connection) >= 0) {
				//SUCCESS
				$_SESSION["message"] = "Index edited";					
				redirect_to("manage_content.php");
			} else {
				// FAILURE
				$message = "Subject creation failed";			
			}
		} 
	} else {
		// Form data not submitted.
	}	

?>
<?php $layout_context = "admin" ?>
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
			 <h2>Edit Home Page</h2>
			<form action="edit_index.php" method="post">
				<p>Heading:
					<input type="text" name="heading" value="<?php echo htmlentities($index["heading"]); ?>" />
				</p>
				<br />
				<textarea name="content" value="" rows="20" cols="80"><?php echo htmlentities($index["content"]); ?></textarea>
				<br />
				<input type="submit" name="submit" value="Edit Index" />
			</form>
		</div>
		
		<div class="editLinks">
			<br />
			<a href="manage_content.php">Cancel</a>
		</div>
		
	</div>
	
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>