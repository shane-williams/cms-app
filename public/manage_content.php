<?php ob_start() ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Validations */ require_once("../includes/validation_functions.php"); ?>
<?php  confirm_logged_in(); ?>
<?php $layout_context = "admin" ?>
<?php /* HEADER */  include("../includes/layout/header.php"); ?>

<?php find_selected_page(false); ?>

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
		
		<div id="subject">
			<div class="tableInformation">
				<?php
					// SUBJECT SELECTED
					if ($current_subject) {
						echo "<h2>Manage Subject</h2>";
						echo "<p>Menu Name: ";
						echo htmlentities($current_subject["menu_name"]) . "</p>";
						echo "<p>Menu Position: " . $current_subject["position"] . "</p>";
						echo "<p> Visibility: "; 
						if ($current_subject["visible"] == 1) { echo "Yes</p>"; } else { echo "No</p>"; };
				?>
				<div class="pageContent">
					<h3>Content:</h3>
					<?php echo "<p>" . htmlentities($current_subject["content"]) . "</p>"; ?>
				</div>
				
				<div class="pagesOnSubject">
					<!-- Linking the related pages on the subject. -->
					<h3>Pages on Subject:</h3>
					<?php echo pages_in_subject($_GET["subject"], false) ?>
				</div>
			</div>
			
			<div class="editLinks"
				<!-- Linking to Edit, Delete and Create New Page -->
				<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit this Subject</a>
				<br />
				<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]) ?>" onclick="return confirm('Are you sure')">Delete this Subject</a>
				<br />
				<a href="new_page.php?subject_id=<?php echo urldecode($current_subject["id"]); ?>">Create New Page for this Subject</a>
			</div>
			
		</div>
		
		<div id="page">
		
			<div class="tableInformation">
				<?php	
					// PAGE SELECTED
					} elseif ($current_page) {
							echo "<h2>Manage Page</h2>";
						echo "<p>Menu Name: ";										
						echo htmlentities($current_page["menu_name"]) . "</p>";
						echo "<p>Menu Position: " . $current_page["position"] . "</p>";
						echo "<p> Visibility: "; 
						if ($current_page["visible"] == 1) { echo "Yes</p>"; } else { echo "No</p>"; };						
				?>
			
			<div class="pageContent">
				<h3>Content:</h3>
				<?php echo "<p>" . htmlentities($current_page["content"]) . "</p>"; ?>
			</div>
							
			<div class="editLinks">
				<!-- Linking to Edit, Delete and Create New Page -->
				<a href="edit_page.php?page=<?php echo urldecode($current_page["id"]); ?>">Edit this Page</a>
				<br />
				<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]) ?>" onclick="return confirm('Are you sure')">Delete this Page</a>
				<br />
				<a href="new_page.php?subject_id=<?php echo urldecode($current_page["subject_id"]); ?>">Create New Page for this Subject</a>
			</div>	
				
		</div>
				
		<div class="tableInformation">			
			<?php
				// Displaying information if neither is selected (index)
				} else {
					echo "<p>Select a subject or page to edit it.<br />Below is the home page:</p>";
					$index = show_index();
					echo "<h2>" . htmlentities($index["heading"]) . "</h2>";
					echo "<p>" . htmlentities($index["content"]) . "</p>";
					echo "<a href=\"edit_index.php\">Edit the Home page</a>";
			}	
			?>
		</div>
		
		</div>
		
	</div>
</main>

<?php /* FOOTER */ include("../includes/layout/footer.php"); ?>