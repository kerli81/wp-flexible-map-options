<?php
/*
Plugin Name: Flexible Map Options
Description: Provides an option page for the plugin WP Flexible Map to define the default values globally.
Version: 1.0.0
Author: Kerli
Domain Path: /languages
Text Domain: flxmapoptions
*/

/*
copyright (c) 2011-2013 WebAware Pty Ltd (email : rmckay@webaware.com.au)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('FLXMAPOPTIONS_PLUGIN_NAME')) {
	define('FLXMAPOPTIONS_PLUGIN_NAME', plugin_basename(__FILE__)); // flexible-map-options/flexible-map-options.php
	define('FLXMAPOPTIONS_PLUGIN_FQ_NAME', plugin_dir_path(__FILE__).basename(__FILE__)); // /path/to/your/pluginfolder/flexible-map-options/flexible-map-options.php
	define('FLXMAPOPTIONS_PLUGIN_SLUG', 'flexible-map-options');
	define('FLXMAPOPTIONS_TEXT_DOMAIN', 'flxmapoptions');
	
	define('FLXMAPOPTIONS_FLXMAP_NAME', 'wp-flexible-map/flexible-map.php');
}

if (!class_exists('FlxMapOptions_Options')) {
	include_once( dirname(__FILE__) . '/class.FlxMapOptions_SingleOption.php');
	include_once( dirname(__FILE__) . '/class.FlxMapOptions_Options.php');
	include_once( dirname(__FILE__) . '/class.FlxMapOptions_Map.php');
	include_once( dirname(__FILE__) . '/class.FlxMapOptions_Admin.php');

	$options = new FlxMapOptions_Options();
	$map = new FlxMapOptions_Map($options);
	$admin = new FlxMapOptions_Admin($options);
	
	// do some action in the activation/deactivation
	register_activation_hook( __FILE__, array($admin, 'activatePlugin'));
	register_deactivation_hook( __FILE__, array($admin, 'deactivatePlugin'));
}

?>