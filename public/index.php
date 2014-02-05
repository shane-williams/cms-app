<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Validations */ require_once("../includes/validation_functions.php"); ?>
<?php  logged_in(); ?>
<?php $layout_context = "public" ?>
<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<?php /* Checking what page we're on*/ find_selected_page(); ?>

<main>
	
	<?php /* NAVIGATION */  include("../includes/layout/publicNav.php"); ?>
			
	<div id="content">
		<?php /* Echoing anything that's come via $_SESSION */ echo message(); ?>

		<div class="tableInformation">
			<?php
				// Displaying the information from the subjects.
				if ($current_subject) {
					echo "<h2>" . htmlentities($current_subject["menu_name"]) . "</h2>";
					echo "<p>" . htmlentities($current_subject["content"]) . "</p><br />";
					if (find_pages_for_subject($_GET["subject"]) == 1) {
						echo pages_in_subject($_GET["subject"], true);
					}						
			?>
		</div>
	
		<div class="tableInformation">
			<?php
				// Displaying the information from the pages.					
				} elseif ($current_page) {
					echo "<h2>" . htmlentities($current_page["menu_name"]) . "</h2>"; 					
					echo "<p>" . htmlentities($current_page["content"]) . "</p>"; 
			?>
		</div>
		
		<div id="home_page">			
			<?php
				// Displaying when nothing is selected (index page)	 
				} else {
					$index = show_index();
					echo "<h2>" . htmlentities($index["heading"]) . "</h2>";
					echo "<p>" . htmlentities($index["content"]) . "</p>";
				}
			?>
			
		</div>
		
	</div>
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>
