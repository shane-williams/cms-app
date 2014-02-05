<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php find_selected_page(false); ?>

<?php
if (!$current_subject) {
	redirect_to("manage_content.php");
}
?>

<?php

	if (isset($_POST["submit"])) { // bracket ends 57.
		
		// Validations
		$required_fields = array("menu_name", "position", "visible");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if (empty($errors)) { // bracket ends line 56
		
		
			// Form data.
			$id = $current_subject["id"];
			$menu_name = mysql_prep($_POST["menu_name"]); //string is escaped.
			$position = (int) $_POST["position"];
			$visible = (int) $_POST["visible"];
			$content = mysql_prep($_POST["content"]); //string is escaped.
			
			// Query.
			$query = "UPDATE subjects SET ";
			$query .= "menu_name = '{$menu_name}', ";
			$query .= "position = {$position}, ";
			$query .= "visible = {$visible}, ";
			$query .= "content = '{$content}' ";			
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection, $query);
			
			// Redirecting based on query results. 
			if ($result && mysqli_affected_rows($connection) >= 0) {
				//SUCCESS
				$_SESSION["message"] = "Subject edited";					
				redirect_to("manage_content.php");
			} else {
				// FAILURE
				$message = "Subject creation failed";			
			}
		} 
	} else {
		// Form Not Submitted
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
			 <h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
			<form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
				<p>Menu Name:
					<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>" />
				</p>
				<p>Position:
					<select name="position">
						<?php
						$subject_set = find_all_subjects(false);
						$subject_count = mysqli_num_rows($subject_set);
						for ($count=1; $count<= $subject_count; $count++) {
							echo "<option value=\"{$count}\"";
							if ($current_subject["position"] == $count) {
							echo " selected";
							}
							echo ">{$count}</option>";
						}
						?>
					</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) {echo "checked";} ?>/> No
					&nbsp;
					<input  type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) {echo "checked";} ?>/> Yes
				</p>
				<textarea name="content" value="" rows="20" cols="80"><?php echo htmlentities($current_subject["content"]); ?></textarea>
				<br />
				<input type="submit" name="submit" value="Edit Subject" />
			</form>
		</div>
		
		<div class="editLinks">
			<br />
			<a href="manage_content.php">Cancel</a>
			&nbsp;
			&nbsp;
			<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]) ?>" onclick="return confirm('Are you sure')">Delete Subject</a>
		</div>
		
	</div>
	
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>