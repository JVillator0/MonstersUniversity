<?php
class cls_validator{
	
	public function validateForm($fields){
		foreach($fields as $index => $value){
			$value = trim($value);
			$fields[$index] = $value;
		}
		return $fields;
	}

	public function validateId($value){
		return filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 1));
	}

	public function validateEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);		
	}

	public function validateAlphabetic($value, $minimum, $maximum){
		return preg_match("/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{".$minimum.",".$maximum."}$/", $value);
	}

	public function validateAlphanumeric($value, $minimum, $maximum){
		return preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{".$minimum.",".$maximum."}$/", $value);
	}

	public function validateMoney($value){
		return preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $value);
	}

	public function validatePassword($value){
		return strlen($value) >= 8 && preg_match("/^(?=.*[A-Z])/", $value) && preg_match("/^(?=.*[a-z])/", $value) && preg_match("/^(?=.*\d)(?=.*[\W_])/", $value);
	}

	public function validateTelephone($value){
		return true && strlen($value) > 0;
	}

	public function validateDUI($value){
		return true && strlen($value) > 0;
	}

	public function validateNIT($value){
		return true && strlen($value) > 0;
	}

	public function validateDate($value){
		return true && strlen($value) > 0;
	}

	public function validateStr($value){
		return strlen($value) > 0;
	}
}
?>