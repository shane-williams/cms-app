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
			 <h2>Create Admin</h2>		 
			<form action="create_admin.php" method="post">
			
				<input type="text" name="user" value="" placeholder="Username" />
				<br />
				<input type="password" name="pass" value="" placeholder="Password" />
				<br />
				<input type="submit" name="submit" value="Submit" />
			</form>
		</div>
		
		<div class="editLinks">
			<br />
			<a href="manage_admins.php">Cancel</a>
		</div>
	</div>
	
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>