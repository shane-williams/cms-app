<?php
	$errors = array();
	
	function fieldname_as_text($fieldname) {
		$fieldname = str_replace("_", " ", $fieldname);
		$fieldname = ucfirst($fieldname);
		return $fieldname;
	}

	//Presence
	function has_presence($value) {
		return isset($value) && $value !== "";
	}
	
	function validate_presences($required_fields) {
		global $errors;
		foreach ($required_fields as $field) {
			$value = trim($_POST[$field]);
			if (!has_presence($value)) {
				$errors[$field] = fieldname_as_text($field) . " can't be blank";
			}
		}
	}
	
	//String length MAX
	function has_max_length($value, $max) {
		return strlen($value) <= $max;
	}
	
	function validate_max_lengths($fields_with_max_lengths) {
		global $errors;
		// Expects an a.array
		foreach($fields_with_max_lengths as $field => $max) {
			$value = trim($_POST[$field]);
			if (!has_max_length($value, $max)) {
				$errors[$field] = fieldname_as_text($field) . " is to long";
			}
		}
	}
	
	//String length MIN
	
	function has_min_length($value, $min) {
		settype($value, "int");
		return $value >= $min;
	}
	
	// In set
	function has_inclusion_in($value, $set) {
		return in_array($value, $set);
	}
	
?>
