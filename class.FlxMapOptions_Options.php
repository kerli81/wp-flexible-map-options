<?php
/**
 * provides an abstraction layer for the options
 *
 * @package Flexible Map Options
 * @since 1.0.0
 */
class FlxMapOptions_Options {
	const OPTION_NAME = 'flexible-map-options';
	const OPTION_NAME_STATUS = 'flexible-map-options-status';
	
	private $pluginOptionName;
	private $options = array();

	public function __construct() {
		add_option(self::OPTION_NAME_STATUS, "inactive");
		
		$this->initFields();
		$this->updateOptionsFromDB();
	}
	
	/**
	 * sets the plugin status
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function setPluginStatus($status) {
		update_option(self::OPTION_NAME_STATUS, $status);
	}
	
	/**
	 * called while activating the plugin
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function init() {
		add_option(self::OPTION_NAME, $this->getValues());
		register_setting('flxmapoptions-group', self::OPTION_NAME);
		$this->updateOptionsFromDB();
		$this->saveAll();
	}
	
	/**
	 * saves the in-memory data to the database
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function saveAll() {
		update_option(self::OPTION_NAME, $this->getValues());
	}
	
	/**
	 * return a key/value list of all options
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function getValues() {
		$values = array();
		
		$keys = array_keys($this->options);
		foreach ($keys as $key) {
			$obj = $this->options[$key];
			$values[$obj->getName()] = $obj->getValue();
		}
		
		return $values;
	}
	
	/**
	 * returns the structure of all options
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function getAllFields() {
		return $this->options;
	}
	
	/**
	 * updates the vallues of an option
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function updateValue($name, $value) {
		if (!empty($this->options[$name])) {
			$this->options[$name]->setValue($value);
		}
	}
	
	/**
	 * init of all known options
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	private function initFields() {
		$this->addSingleOption('width', '400', 'text');
		$this->addSingleOption('height', '400', 'text');
		$this->addSingleOption('maptype', 'roadmap', 'list', 'roadmap,satellite');
		$this->addSingleOption('hidemaptype', 'false');
		$this->addSingleOption('hidepanning', 'true');
		$this->addSingleOption('hidezooming', 'false');
		$this->addSingleOption('hidestreetview', 'true');
		$this->addSingleOption('zoomstyle', 'small', 'list', 'small,large,default');
		$this->addSingleOption('hidescale', 'true');
		$this->addSingleOption('scrollwheel', 'false');
		$this->addSingleOption('draggable', 'true');
		$this->addSingleOption('dblclickzoom', 'true');
		$this->addSingleOption('targetfix', 'true');
	}
	
	/**
	 * add single option
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	private function addSingleOption($name, $defaultValue, $type = 'boolean', $possibleValues = '') {
		$this->options[$name] = new FlxMapOptions_SingleOption($name, $defaultValue, $type, $possibleValues);
	}
	
	/**
	 * reads the value from the database and upddates the in-memory values
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function updateOptionsFromDB() {
		if (get_option(self::OPTION_NAME_STATUS) == "active") {
			$dbOptions = get_option(self::OPTION_NAME);

			foreach ($dbOptions as $key => $value) {
				if (!empty($this->options[$key])) {
					$this->options[$key]->setValue($value);
				}
			}
		}
	}
}
?>