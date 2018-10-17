<?php
class cls_validator{
	
	//remueve los espacios de todas las posiones del arreglo
	public function validateForm($fields){
		foreach($fields as $index => $value){
			$value = trim($value);
			$fields[$index] = $value;
		}
		return $fields;
	}

	//DE ESTA MANERA SE VALIDA EL XSS, ya que le aplicamos a todas las posiciones del arreglo enviado el metodo dicho
	//'strip_tags' quita todas las etiquetas html y php de un string, las remueve directamente
	//'htmlspecialchars' reemplaza los caracteres html y php con codigos especiales, se mostraran pero no se ejecutaran
	//'htmlentities' realiza lo mismo que la anterior, pero solo se utiliza cuando se usa una codificacion diferente a UTF-8 o  ISO-8859-1 
	//las validaciones no deberian dejar pasar ningun caracter de ese tipo, pero por cualquier cosa, tambien existe este metodo
	public function validateXSS($fields){
		$fields = array_map("htmlspecialchars", $fields);
		return $fields;
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateId($value){
		return filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 1));
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);		
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateAlphabetic($value, $minimum, $maximum){
		return preg_match("/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{".$minimum.",".$maximum."}$/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateAlphanumeric($value, $minimum, $maximum){
		return preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{".$minimum.",".$maximum."}$/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateMoney($value){
		return preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validatePassword($value){
		return strlen($value) >= 8 && preg_match("/^(?=.*[A-Z])/", $value) && preg_match("/^(?=.*[a-z])/", $value) && preg_match("/^(?=.*\d)(?=.*[\W_])/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateTelephone($value){
		return preg_match("/^\d{4}-\d{4}$/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateDUI($value){
		return preg_match("/^\d{8}-\d{1}$/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateNIT($value){
		return preg_match("/^\d{4}-\d{6}-\d{3}-\d{1}$/", $value);
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateDate($value){
		return true && strlen($value) > 0;
	}

	//verifica el valor utilizando una expresion regular que debe concordar con el valor enviado
	public function validateStr($value){
		return strlen($value) > 0;
	}
}
?>