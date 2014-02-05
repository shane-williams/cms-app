<?php
	
	// Checks if an SQL query failed.
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed");			
		}
	}
	
	// Performs a query that finds all results from the 'subjects' table
	function find_all_subjects($public=true) {
		global $connection;
				
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		
		return $subject_set;

	}
	
	// Finds all the admins // doesn't place in assoc.
	function find_all_admin() {
		global $connection;
				
		$query = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "ORDER BY user ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		
		return $admin_set;

	}
	
	// Finds from home table, does place in assoc.
	function show_index() {
		global $connection;
				
		$query = "SELECT * ";
		$query .= "FROM home;";
		$index_set = mysqli_query($connection, $query);
		confirm_query($index_set);
		
		$index = mysqli_fetch_assoc($index_set);
		
		return $index;

	}	
		
	// Performs a query that finds all results from the 'pages' table and orders them with relation to the subjects table.
	function find_pages_for_subject($subject_id, $public=true) { 
		global $connection;
		
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}		
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		
		return $page_set;

		}
	
	// Creating the navigation HTML.
	function navigation($subject_array, $page_array, $public=true) {
		
			$output = "<ul class=\"subjects\">";
			
			if ($public) { // ENDS LINE 129
					$subject_set = find_all_subjects();
					
				while($subject = mysqli_fetch_assoc($subject_set)) { //Bracket ends at line 100.
					$output .= "<li";
					if ($subject_array && $subject["id"] == $subject_array["id"]) {
						$output .= " class=\"subjectSelected\"";
					}
					$output .= ">"; 
					$output .= "<a href=\"index.php?subject=";
					$output .= urlencode($subject["id"]);
					$output .= "\">";									
					$output .= htmlentities($subject["menu_name"]); 
					$output .= "</a>";
					$output .= "</li>";
					
					
							if ($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"]) {
							$page_set = find_pages_for_subject($subject["id"]);						
								  			
							$output .= "<ul class=\"pages\">";
							
							while ($page = mysqli_fetch_assoc($page_set)) { 
								
								$output .= "<li";
								if ($page_array && $page["id"] == $page_array["id"]) {
									$output .= " class=\"pageSelected\"";
								}
								$output .= ">"; 
								$output .= "<a href=\"index.php?page="; 
								$output .= urlencode($page["id"]);
								$output .= "\">"; 
								$output .= htmlentities($page["menu_name"]);
								$output .= "</a></li>";
							}		
							$output .=	"</ul>";						
							mysqli_free_result($page_set);
							
						}
				}
	
			} else { // ENDS LINE 172
				
				$subject_set = find_all_subjects(false);
				
				while($subject = mysqli_fetch_assoc($subject_set)) { //Bracket ends at line 100.
					$output .= "<li";
					if ($subject_array && $subject["id"] == $subject_array["id"]) {
						$output .= " class=\"subjectSelected\"";
					}
					$output .= ">"; 
					$output .= "<a href=\"manage_content.php?subject=";
					$output .= urlencode($subject["id"]);
					$output .= "\">";									
					$output .= htmlentities($subject["menu_name"]); 
					$output .= "</a>";
					$output .= "</li>";
					
					if ($public) {
						$page_set = find_pages_for_subject($subject["id"]);
						
					} else {
					$page_set = find_pages_for_subject($subject["id"], false);						
					}
						  			
					$output .= "<ul class=\"pages\">";
					
					while ($page = mysqli_fetch_assoc($page_set)) { 
						
						$output .= "<li";
						if ($page_array && $page["id"] == $page_array["id"]) {
							$output .= " class=\"pageSelected\"";
						}
						$output .= ">"; 
						$output .= "<a href=\"manage_content.php?page="; 
						$output .= urlencode($page["id"]);
						$output .= "\">"; 
						$output .= htmlentities($page["menu_name"]);
						$output .= "</a></li>";
					}
					mysqli_free_result($page_set);
					$output .=	"</ul>";							
				}
			}
		
		mysqli_free_result($subject_set);
		
		$output .= "</ul>";
		
		return $output;

		}
		
	// Performs a query that returns a single row from 'subjects' depeneding on the 'id'
	function find_subject_by_id($subject_id, $public=true) {
		global $connection;
		
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
				
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($public) {
		$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		
		if ($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

	// Performs a query that returns a single row from 'pages' depeneding on the 'id'
	function find_page_by_id($page_id, $public=true) {
		global $connection;
		
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		
		
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} ";
		if ($public) {
		$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		
		if ($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}
	
	// Performs a query that returns a single row from 'admin' depeneding on the 'id'
	function find_admin_by_id($admin_id) {
		global $connection;
		
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		
		
		$query = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		
		if ($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
		
	}
	
	// Performs a read on any admins with the matching username.
	function find_admin_by_username($username) {
		global $connection;
		
		$safe_admin_username = mysqli_real_escape_string($connection, $username);
		
		$query = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "WHERE user = '{$safe_admin_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		
		if ($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
		
	}
	
	
	// Displays the pages if there is no content given in the subject
	function find_default_page_for_subject($subject_id) {
	
			$page_set = find_pages_for_subject($subject_id);
			
			if ($first_page = mysqli_fetch_assoc($page_set)) {
				return $first_page;
			} else {
				return null;
			}		
	}
	
	// Checks the value that has come through via $_GET thus the current subject or page is given.
	function find_selected_page($public=true) {
		global $current_subject;
		global $current_page;
		
		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"], $public);
			$current_page = find_default_page_for_subject($current_subject["id"]);
		} elseif (isset($_GET["page"])) {
			$current_page = find_page_by_id($_GET["page"], $public);
			$current_subject = null;
		} else {
			$current_page = null;		
			$current_subject = null;
		}
				
	}
	
	// Redirect function to take the awkward syntax out of editing headers
	function redirect_to($new_location) {
		header("Location: " . $new_location);
		exit;
	}
	
	// Escapes a string so SQL sensitive characters are allowed. STOPS SQL INJECTION
	function mysql_prep($string) {
		global $connection;
	
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	// Placing any errors into an array and into a <div class="errors"> and then looping through each error and displaying it as a <li>.
	function form_errors($errors = array()) {
	$output = "";  			
		if (!empty($errors)) {
			$output .= "<div class=\"error\">";
			$output .= "Please fix the following errors:";
			$output .= "<ul>";
			foreach ($errors as $key => $error) {
  			$output .= "<li>";
  			$output .= htmlentities($error);
  			$output .= "</li>";
			} 
		$output .= "</ul>";
		$output .= "</div>";
		}
	return $output;
	}
	
	// Allowing the pages to display as links with context for manage_content section or index.
	function pages_in_subject($subject_id, $public=true) {
		if ($public) {
			$page_set = find_pages_for_subject($subject_id, $public);						
			 	$output = "<ul>";				
			while ($page = mysqli_fetch_assoc($page_set)) { 
				$output .= "<li>";
				// This is where the $_GET value is created.										
				$output .= "<a href=\"index.php?page="; 
				$output .= urlencode($page["id"]);
				$output .= "\">"; 
				$output .= htmlentities($page["menu_name"]);
				$output .= "</a></li>";
			}
			$output .= "</ul>";
			return $output;
		} else {
			$page_set = find_pages_for_subject($subject_id, false);						
			 	$output = "<ul>";				
			while ($page = mysqli_fetch_assoc($page_set)) { 
				$output .= "<li>";
				// This is where the $_GET value is created.										
				$output .= "<a href=\"manage_content.php?page="; 
				$output .= urlencode($page["id"]);
				$output .= "\">"; 
				$output .= htmlentities($page["menu_name"]);
				$output .= "</a></li>";
			}
			$output .= "</ul>";
			return $output;
		}
	}
	
	// Puts the returned admins into a list to I can repring them onto the <content> div.
	function admins_as_list($admin_assoc) {
	
			$output = "<li>";
			$output .= htmlentities($admin_assoc["user"]);
			$output .= "&nbsp;";
			$output .= "<a href=\"edit_admin.php?admin=";
			$output .= urlencode($admin_assoc["id"]);
			$output .= "\">";
			$output .= "Edit Admin";
			$output .= "</a>";
			$output .= "&nbsp;";
			$output .= "<a href=\"delete_admin.php?admin=";
			$output .= urlencode($admin_assoc["id"]);
			$output .= "\"onclick=\"return confirm('Are you sure')\">";
			$output .= "Delete Admin";
			$output .= "</a>";
			
			$output .= "</li>";
			
			return $output;
			
	}
	
	// Creates the encryption on the password
	function password_encrypt($password) {
		$hash_format = "$2y$10$"; 
		
		$salt_length = 22;
		$salt = generate_salt($salt_length);
		
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		
		return $hash;
	}
	
	// Creates a heavily encrypted random salt for the password_encrypt
	function generate_salt($length) {
	
		$unique_random_string = md5(uniqid(mt_rand(), true));
		
		$base64_string = base64_encode($unique_random_string);		
		$modified_base64_string = str_replace('+', '.', $base64_string); 		
		$salt = substr($modified_base64_string, 0, $length);
		
		return $salt;
	}
	
	// Performs the inverse of the password_encrypt() function. Takes the $hash and compares it to the $_POST password.
	function password_check($password, $existing_hash) {
		$hash = crypt($password, $existing_hash);
		if ($hash === $existing_hash) {
			return true;
		} else {
			return false;
		}
	}
	
	// Takes the $_POST user and finds all results for it (if there are none returns false) and then checks the hashed password (from the db) against the $_POST password, if true returns the entire admin value, if they don't match returns false.
	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		
		if ($admin) {
			// found the admin, now check password.
			if (password_check($password, $admin["pass"])) {
				// login successful (function returns true or false)
				return $admin;
			} else {
				// Password does not match.
				return false;
			}
		} else {
			// Username and password are not found.
			return false;
		}
		
	}
	
	// This is just checking if the user is logged in.
	function logged_in() {
		return isset($_SESSION["admin_id"]);		
	}
	
	// This is enforcing the log in.
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
?>