<?php

/**
 * class used in the normal page
 *
 * @package Flexible Map Options
 * @since 1.0.0
 */
class FlxMapOptions_Map {

	private $pluginOptions;

	public function __construct($options) {
		$this->pluginOptions = $options;
		
		add_filter('flexmap_shortcode_attrs', array($this, 'setDefaults'));
	}
	
	/**
	 * sets  the default values for the unset fields
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function setDefaults($attrs) {
		$defaults = $this->pluginOptions->getValues();
		$attrsInclDefaults = wp_parse_args($attrs, $defaults);
		
		return $attrsInclDefaults;
	}

}

?>