<?php ob_start() ?>
<?php /* Databbase connection */  require_once("../includes/db_connect.php"); ?>
<?php /* Sessions */ require_once("../includes/session.php"); ?>
<?php /* Functions */ require_once("../includes/functions.php"); ?>

<?php		
		// SUBJECT TABLE CREATION
		$query = "CREATE TABLE subjects (";
		$query .= "id INT(11) NOT NULL AUTO_INCREMENT, ";
		$query .= "menu_name VARCHAR(30) NOT NULL, ";
		$query .= "position INT(3) NOT NULL, ";
		$query .= "visible TINYINT(1) NOT NULL, ";
		$query .= "content VARCHAR(200) NOT NULL, ";
		$query .= "PRIMARY KEY (id)";		
		$query .= ")";
		
		$result1 = mysqli_query($connection, $query);
		if ($result1) {
			
			// PAGES TABLE CREATION
			$query = "CREATE TABLE pages (";
			$query .= "id INT(11) NOT NULL AUTO_INCREMENT, ";
			$query .= "subject_id INT(11) NOT NULL, ";			
			$query .= "menu_name VARCHAR(30) NOT NULL, ";
			$query .= "position INT(3) NOT NULL, ";
			$query .= "visible TINYINT(1) NOT NULL, ";
			$query .= "content VARCHAR(200) NOT NULL, ";
			$query .= "PRIMARY KEY (id), ";
			$query .= "INDEX (subject_id)";							
			$query .= ")";
			
			$result2 = mysqli_query($connection, $query);
			if ($result2) {
				
				// INDEX TABLE CREATION
				$query = "CREATE TABLE home (";
				$query .= "id INT(11) NOT NULL AUTO_INCREMENT, ";
				$query .= "heading VARCHAR(50) NOT NULL, ";
				$query .= "content VARCHAR(200) NOT NULL, ";
				$query .= "PRIMARY KEY (id)";
				$query .= ")";			
		
					$result3 = mysqli_query($connection, $query);
					if ($result3) {
						
						// ADMIN TABLE CREATION
						$query = "CREATE TABLE admin (";
						$query .= "id INT(11) NOT NULL AUTO_INCREMENT, ";
						$query .= "user VARCHAR(50) NOT NULL, ";
						$query .= "pass VARCHAR(200) NOT NULL, ";				
						$query .= "PRIMARY KEY (id)";		
						$query .= ")";
						
						$result4 = mysqli_query($connection, $query);
						if ($result4) {
							
							// 1ST SUBJECT CREATION
							$query = "INSERT INTO subjects (";
							$query .= " menu_name, position, visible, content";
							$query .= ") VALUES (";
							$query .= "'First Subject', 1, 1, 'Hi! This is a subject, log in using your username to edit it!'";
							$query .= ")";
							
							$result5 = mysqli_query($connection, $query);
							if ($result5) {
								
								// 1ST PAGE CREATION
								$query = "INSERT INTO pages (";
								$query .= "subject_id, menu_name, position, visible, content";
								$query .= ") VALUES (";
								$query .= "1, 'First Page', 1, 1, 'Hi again, this is a page, log in using your username to edit it.'";
								$query .= ")";
									
								$result6 = mysqli_query($connection, $query);
								if ($result6) {
										
										// 1ST INDEX CREATION
										$query = "INSERT INTO home (";
										$query .= "heading, content";
										$query .= ") VALUES (";
										$query .= "'Welcome', 'This is the index page log in using your username to edit it.'";
										$query .= ")";
										
								
											$result7 = mysqli_query($connection, $query);
											if ($result7) {
																								
												$username = "root";
												$password = "root"; 
												
												$user = mysql_prep($username); //string is escaped.
												$pass = password_encrypt($password); //$pass is encrypted.
												
												$query = "INSERT INTO admin (";
												$query .= " user, pass";
												$query .= ") VALUES (";
												$query .= "'{$user}', '{$pass}'";
												$query .= ")";
												
													$result8 = mysqli_query($connection, $query);
													if ($result8) {
															echo "Install successful<br />";
															echo "Username is: {$username}<br />";
															echo "Password is: {$password} <br />";
															echo "Don't forget to delete this file and change your password!<br />";
															echo "<a href=\"index.php\">Go to site</a>";
														}
											}
								}
							}
						}
					}
			}
		}
?>
<?php
	// CLOSE DATABASE CONNECTION:
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>
<?php ob_end_flush() ?>
			
