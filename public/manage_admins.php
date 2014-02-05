<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Validations */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>
<?php $layout_context = "admin" ?>
<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<?php  find_selected_page(false); ?>

<main>
	<?php /* HEADER */  include("../includes/layout/adminNav.php"); ?>
	
	<div id="content">
		<div class="errors">
			<?php 
				// Checking if errors have come in via $_SESSION
				$errors = errors();
				echo form_errors($errors); 			 
			 ?>
			<?php /* Echoing any success or failure messages via $_SESSION */ echo message(); ?>
		</div>
		
		<div id="admins">
			<h2>Admin Users:</h2>
			<ul>
				<?php
					$admin_set = find_all_admin();
						
						while ($admin = mysqli_fetch_assoc($admin_set)) {
							echo admins_as_list($admin);
						}
				?>
			</ul>
			<br />
			<a href="new_admin.php">Create a new Admin User</a>
		</div>
		
	</div>
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>