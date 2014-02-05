<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Validations */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>
<?php $layout_context = "admin" ?>
<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<?php /* Checking what page we're on*/ find_selected_page(); ?>

<main>

	<?php /* HEADER */  include("../includes/layout/adminNav.php"); ?>
	
	<div id="content">
		<div class="adminMenu">
			<h2>Admin Menu</h2>
			<p>Welcome to the admin area<?php echo ", " . htmlentities($_SESSION["username"]); ?></p>
			<ul>
				<li><a href="manage_content.php">Manage Website Content</a></li>
				<li><a href="manage_admins.php">Manage Admin Users</a></li>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</div>
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>