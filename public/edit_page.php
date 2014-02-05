<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>

<?php find_selected_page(false); ?>

<?php
if (!$current_page) {
	redirect_to("manage_content.php");
}
?>

<?php

	if (isset($_POST["submit"])) { // bracket ends 57.
		
		// Validations
		$required_fields = array("menu_name", "position", "visible", "content");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lengths);
		
		if (empty($errors)) { // bracket ends line 56
				
			// Form data.
			$id = $_GET["page"];
			$menu_name = mysql_prep($_POST["menu_name"]); //string is escaped.
			$position = (int) $_POST["position"];
			$visible = (int) $_POST["visible"];
			$content = mysql_prep($_POST["content"]); //string is escaped.
			
			
			// Here's the query.
			$query = "UPDATE pages SET ";
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
				$_SESSION["message"] = "Page Edited";					
				redirect_to("manage_content.php?page={$id}");
			} else {
				// FAILURE
				$message = "Page editing failed";			
			}
		} 
	} else {
		// Form not submitted
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
				echo form_errors($errors); 			 
			 ?>
		</div>
		
		<div class="form">
			 <h2>Edit page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
			<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
				<p>Menu Name:
					<input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
				</p>
				<p>Position:
					<select name="position">
						<?php
						$page_set = find_pages_for_subject($current_page["subject_id"]);
						$page_count = mysqli_num_rows($page_set);
						for ($count=1; $count<= $page_count; $count++) {
							echo "<option value=\"{$count}\"";
							if ($current_page["position"] == $count) {
							echo " selected";
							}
							echo ">{$count}</option>";
						}
						?>
					</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) {echo "checked";} ?>/> No
					&nbsp;
					<input  type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) {echo "checked";} ?>/> Yes
				</p>
				<textarea name="content" value="" rows="20" cols="80"><?php echo htmlentities($current_page["content"]); ?></textarea>
			<br />
				<input type="submit" name="submit" value="Edit page" />
			</form>
		</div>
		
		<div class="editLinks">
			<br />
			<a href="manage_content.php">Cancel</a>
			&nbsp;
			&nbsp;
			<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]) ?>" onclick="return confirm('Are you sure')">Delete page</a>
		</div>
		
	</div>
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>