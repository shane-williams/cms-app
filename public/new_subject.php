<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Functions */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>
<?php $layout_context = "admin" ?>
<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<?php find_selected_page(false); ?>

<main>

	<?php /* HEADER */  include("../includes/layout/adminNav.php"); ?>
	
	<div id="content">
		<div class="errors">
			<?php /* Echoing the success or failure message */ echo message(); ?>
			
			<?php 
				// Checking for errors and displaying them.
				$errors = errors();
				echo form_errors($errors); 			 
			 ?>
		</div>
		
		<div class="form">
			 <h2>Create Subject</h2>		 
			<form action="create_subject.php" method="post">
				<p>Menu Name:
					<input type="text" name="menu_name" value="" />
				</p>
				<p>Position:
					<select name="position">
						<?php
						$subject_set = find_all_subjects(false);
						$subject_count = mysqli_num_rows($subject_set);
						for ($count=1; $count<=($subject_count + 1); $count++) {
							echo "<option value=\"{$count}\">{$count}</option>";
						}
						?>
					</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" /> No
					&nbsp;
					<input  type="radio" name="visible" value="1" /> Yes
				</p>
				<textarea name="content" value="" rows="20" cols="80" placeholder="Content"></textarea>	
				<br />			
				<input type="submit" name="submit" value="Create Subject" />
			</form>
		</div>
		
		<div class="editLinks">
			<br />
			<a href="manage_content.php">Cancel</a>
		</div>
	</div>
	
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>