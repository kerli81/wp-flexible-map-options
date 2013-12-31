<?php

/**
 * adds a new row for a property to the page
 *
 * @package Flexible Map Options
 * @since 1.0.0
 */
function optionRow($option, $description) {
	$row = "";
	$row .= "<tr valign=\"top\">\n";
	
	$row .= "\t<th scope=\"row\"><label for=\"" . $option->getName() . "\">" . $option->getName()  . "</label></th>\n";
	
	$row .= "\t<td>";
	switch ($option->getType()) {
	case 'boolean':
		// to set 'unselected' values
		$row .= "<input type=\"hidden\" id=\"h_" . $option->getName() . "\" name=\"" . $option->getName() . "\" value=\"false\"/>";
		$row .= "<input type=\"checkbox\" id=\"" . $option->getName() . "\" name=\"" . $option->getName() . "\" value=\"true\" " . checked($option->getValue(), "true", false) . "/>";
		break;
	
	case 'list':
		$values = explode(",", $option->getPossibleValues());
		$row .= "<select id=\"" . $option->getName() . "\" name=\"" . $option->getName() . "\" size=\"1\">";
		foreach ($values as $value) {
			$value = trim($value);
			$row .= "<option " . selected($option->getValue(), $value, false) . ">" . $value . "</option>";
		}
		$row .= "</select>";
		break;
		
	case 'text':
		$row .= "<input type=\"text\" id=\"" . $option->getName() . "\" name=\"" . $option->getName() . "\" value=\"" . $option->getValue() . "\" />";
		break;
	}
	$row .= "<p class=\"description\">" . $description . " (". __("Default", FLXMAPOPTIONS_TEXT_DOMAIN) . ": '" . $option->getDefault() . "')</p></td>\n";
	
	$row .= "</tr>\n";
	echo $row;
}

$options = $optionInstance->getAllFields();

if ( isset($_POST['submitted']) ) {
	foreach ($_POST as $key => $value) {
		$optionInstance->updateValue($key, $value);
	}
	
	$optionInstance->saveAll();
	
	add_settings_error('flxmapoptions_message', esc_attr('settings_updated'), __('Successfully updated', FLXMAPOPTIONS_TEXT_DOMAIN), 'updated');
	settings_errors('flxmapoptions_message');
}
?>

<div class="wrap">
	<?php screen_icon(); ?>
	
	<h2><?php echo __('Options Page for ', FLXMAPOPTIONS_TEXT_DOMAIN) . get_plugin_data(FLXMAPOPTIONS_PLUGIN_FQ_NAME)['Name']; ?></h2>
	
	<?php _e('You will find more information about the fields on the instruction page of the WP Flexible Map plugin', FLXMAPOPTIONS_TEXT_DOMAIN); ?>
	
	<form method="post" action="<?php $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="submitted" value="1" /> 
		<h3><?php _e('Parameters for all maps', FLXMAPOPTIONS_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<?php
				optionRow($options["width"], __('Width in Pixel/Percent', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["height"], __('Height in Pixel/Percent', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["maptype"], __('Type of map to show', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["hidemaptype"], __('Hide the map type controls', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["hidepanning"], __('Hide the panning controls', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["hidezooming"], __('Hide the zoom controls', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["hidestreetview"], __('Hide the street view control', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["zoomstyle"], __('Which zoom control style', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["hidescale"], __('Hide the map scale', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["scrollwheel"], __('Enable zoom with mouse scroll wheel', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["draggable"], __('Enable dragging to pan', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["dblclickzoom"], __('Enable double-clicking to zoom', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["directions"], __('show directions link in text bubble', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["dirdraggable"], __('allow directions to be draggable', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["dirnomarkers"], __('suppress start and end markers when showing directions', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["dirshowsteps"], __('show or suppress directions steps when showing directions', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["dirshowssearch"], __('show or suppress directions search form when showing directions', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["region"], __('specify region to help localise address searches for street address map and directions', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["locale"], __('use a specific locale (language) for messages like the text of the Directions link', FLXMAPOPTIONS_TEXT_DOMAIN));
				?>
			</table>
		<?php submit_button(); ?>
		
		<h3><?php _e('Additional parameters for centre coordinates map', FLXMAPOPTIONS_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<?php
				optionRow($options["icon"], __('URL to icon for the marker', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["showdirections"], __('show directions when the map loads', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["directionsfrom"], __('initial from: location for directions', FLXMAPOPTIONS_TEXT_DOMAIN));
				optionRow($options["showinfo"], __('show the marker\'s info window when the map loads', FLXMAPOPTIONS_TEXT_DOMAIN));
				?>
			</table>
		<?php submit_button(); ?>
		
		<h3><?php _e('Additional parameters for KML map', FLXMAPOPTIONS_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<?php
				optionRow($options["targetfix"], __('Prevent links from opening in new window', FLXMAPOPTIONS_TEXT_DOMAIN));
				?>
			</table>
		<?php submit_button(); ?>
	</form>
</div>