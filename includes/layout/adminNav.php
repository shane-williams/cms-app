<nav>
	<a href="edit_index.php">Edit the Home page</a>
	<br />
	<div class="menu">
		<h2>Site Menu</h2>			
		<a href="manage_content.php">Home</a>
		<?php /* Navigation */ echo navigation($current_subject, $current_page, false); ?> 
	</div>
	<a href="new_subject.php">+ Add a subject</a>
	<br />
	<a href="admin.php">&laquo; Back to the Admin Section</a>
	<br />
	<a href="index.php">&raquo; Go To Site</a>
</nav>
