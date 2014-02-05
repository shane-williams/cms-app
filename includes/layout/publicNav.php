<nav>
	<div class="menu">
		<a href="index.php">Home</a>
		<?php /* Navigation */ echo navigation($current_subject, $current_page); ?>
	</div>
	<?php
	if (logged_in()) {
		echo "<a href=\"admin.php\">&laquo; Back to the Admin Section</a>";
	}
	?>
</nav>
