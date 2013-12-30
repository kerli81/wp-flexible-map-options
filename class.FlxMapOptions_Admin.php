<?php

/**
 * class for all the admin stuff
 *
 * @package Flexible Map Options
 * @since 1.0.0
 */
class FlxMapOptions_Admin {

	private $flxMapStatus = "";
	private $pluginOptions;

	public function __construct($options) {
		$this->pluginOptions = $options;
		
		// load translations
		add_action('init', array($this, 'load_textdomain'));
		
		// add action hook for adding plugin meta links
		add_filter('plugin_row_meta', array($this, 'addPluginDetailsLinks'), 10, 2);
		
		// admin menu
		add_action('admin_menu', array($this, 'registerMenuEntry'));
	}
	
	/**
	 * load text domain
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function load_textdomain() {
		load_plugin_textdomain(FLXMAPOPTIONS_TEXT_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}

	/**
	 * called while activating the plugin
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function activatePlugin() {
		$this->pluginOptions->setPluginStatus('active');
		$this->pluginOptions->init();
	}
	
	/**
	 * called while deactivating the plugin
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function deactivatePlugin() {
		$this->pluginOptions->setPluginStatus('inactive');
	}
	
	/**
	 * adds some links to the plugin meta area
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function addPluginDetailsLinks($links, $file) {
		if ($file == FLXMAPOPTIONS_PLUGIN_NAME) {
			if (!$this->isFlxMapActive()) {
				$links[] = '<font color="red">' . __('Plugin "Flexible Map" is NOT active!', FLXMAPOPTIONS_TEXT_DOMAIN) . '</font>';
			}
			else {
				$links[] = '<a href="options-general.php?page='.FLXMAPOPTIONS_PLUGIN_SLUG.'">' . __('Settings', FLXMAPOPTIONS_TEXT_DOMAIN) . '</a>';
			}
		}
		return $links;
	}
	
	/**
	 * registers the menu entry
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function registerMenuEntry() {
		if ($this->isFlxMapActive()) {
			$data = get_plugin_data(FLXMAPOPTIONS_PLUGIN_FQ_NAME);
			add_options_page($data['Name'], $data['Name'], 'manage_options', FLXMAPOPTIONS_PLUGIN_SLUG , array($this, 'optionPage'));
		}
	}
	
	/**
	 * loads the option page
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	function optionPage() {
		$optionInstance = $this->pluginOptions;
		include( dirname(__FILE__) . '/page.optionpage.php');
	}
	
	/**
	 * helper function to check of the depended plugin is active
	 *
	 * @package Flexible Map Options
	 * @since 1.0.0
	 */
	private function isFlxMapActive() {
		if ($this->flxMapStatus == "") {
			if (is_plugin_active(FLXMAPOPTIONS_FLXMAP_NAME)) {
				$this->flxMapStatus = "active";
			}
			else {
				$this->flxMapStatus = "inactive";
			}
		}

		return $this->flxMapStatus == "active";
	}
	
}

?>