<?php
class validator {
	
	private $errors;
	public $messages;
	private $val;
	public $placeholder;
	
	function __construct() {
		$this->messages['notEmpty'] = " should not be empty.";
		$this->messages['int'] = " is not a valid integer.";
	}
	
	function notEmpty() {
		if($this->checkNull($this->val)) {
			if(is_array($this->val) || is_object($this->val)) {
				if(empty($this->val))
					$this->assignError();
			} else {
				if(empty(trim($this->val)))
					$this->assignError();
			}
		} else {
			$this->assignError();
		}
	}
	
	function checkNull() {
		if(is_null($this->val)) {
		 return false;
		}
		return true;
	}
	
	function int(){
		if(is_null($this->val)) {
		 	$this->assignError();
		} else {
			if(!preg_match("/^[\d]+$/",$this->val))
			 	$this->assignError();
		}
	}
	
	function assignError(){
		$method = debug_backtrace()[0]['function'];
		$this->errors[$this->placeholder][] = $this->messages[$method];
	}
	
	function validate($validation_rules, $inputs){ 
		foreach($validation_rules as $placeholder=>$rules)
		{
			$this->placeholder = $placeholder;
			$this->val = $inputs[$this->placeholder];
			foreach($rules as $method)
			{
				$this->{$method}();
			}
		}
		return $this->errors;
	}
	
}
