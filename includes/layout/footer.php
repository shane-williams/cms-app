  	
	<footer>
		<p>Copyright <?php echo date("Y") ?></p>
	</footer>
  
  </body>
</html>

<?php
	// CLOSE DATABASE CONNECTION:
	
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>
<?php ob_end_flush() ?>