<?php

/**
 * class for one single option property
 *
 * @package Flexible Map Options
 * @since 1.0.0
 */
class FlxMapOptions_SingleOption {
	private $name;
	private $defaultValue;
	private $value;
	private $type;
	private $possibleValues;
	
	public function __construct($name, $defaultValue, $type, $possibleValues) {
		$this->name = $name;
		$this->defaultValue = $defaultValue;
		$this->value = $defaultValue;
		$this->type = $type;
		$this->possibleValues = $possibleValues;
	}
	
	function getName() {
		return $this->name;
	}
	
	function getDefault() {
		return $this->defaultValue;
	}
	
	function getType() {
		return $this->type;
	}
	
	function getValue() {
		return $this->value;
	}
	
	function setValue($value) {
		$this->value = $value;
	}
	
	function getPossibleValues() {
		return $this->possibleValues;
	}
}
?>