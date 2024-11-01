<?php

/*
Plugin Name: Wavewatch Surf Widget
Plugin URI: http://www.shaneandpeter.com/wordpress
Description: Wave, tide, weather & surf conditions and forecast for 60+ regions
Author: Shane Pearlman
Version: 1.0
Author URI: http://www.shaneandpeter.com/
*/

class wavewatch_forecast_widget {

	var $id = "wavewatch-forecast";
	var $name = "Wavewatch";
	var $classname = "wavewatch_forecast_widget";
	var $optionsname = "wavewatch_forecast_widget_option";
	var $description = "Wavewatch regional surf forecast";

	// Display the widget
	function widget($args) {
		extract($args);
		$options = get_option($this->optionsname);
		echo $before_widget;
		echo $before_title . '' . $after_title;
		$region = explode("|",$options[$this->id]['region']);
		
		if ($options[$this->id]['widgettype'] == 'conditions'){
		?><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $options[$this->id]['width']?>" height="<?php echo $options[$this->id]['height']?>"><param name="movie" value="http://www.wavewatch.com/flash_tools/current_magnet.swf?theLocation=<?php echo $region[2];?>&city=<?php echo $region[0];?>" /><param name="quality" value="high" /><embed src="http://www.wavewatch.com/flash_tools/current_magnet.swf?theLocation=<?php echo $region[2];?>&city=<?php echo $region[0];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $options[$this->id]['width']?>" height="<?php echo $options[$this->id]['height']?>"></embed></object>
		<?php
		}
		if ($options[$this->id]['widgettype'] == 'map'){?>
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $options[$this->id]['width']?>" height="<?php echo $options[$this->id]['height']?>"><param name="movie" value="http://www.wavewatch.com/flash_tools/map_magnet.swf?location=<?php echo $region[1];?>&city=<?php echo $region[0];?>&theLocation=<?php echo $region[2];?>" /><param name="quality" value="high" /><embed src="http://www.wavewatch.com/flash_tools/map_magnet.swf?location=<?php echo $region[1];?>&city=<?php echo $region[0];?>&theLocation=<?php echo $region[2];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $options[$this->id]['width']?>" height="<?php echo $options[$this->id]['height']?>"></embed></object>
		<?php
		}
		echo $after_widget;
	}
	
	// Widget Panel
	function control() 
	{
		$widgettype = $this->id.'-widgettype';
		$region = $this->id.'-region';
		$width = $this->id.'-width';
		$height = $this->id.'-height';
		$submit = $this->id.'-submit';
		
	    // Update DB if new data
		if ( $_POST[$submit] ) {
			$options[$this->id]['widgettype'] = htmlentities(stripslashes($_POST[$widgettype]));
			$options[$this->id]['region'] = htmlentities(stripslashes($_POST[$region]));
			$options[$this->id]['width'] = htmlentities(stripslashes($_POST[$width]));
			$options[$this->id]['height'] = htmlentities(stripslashes($_POST[$height]));
			update_option($this->optionsname, $options);
		}
	
	    // Get Data from Options
	  	$options = get_option($this->optionsname);		
		if ( !is_array($options) ) {
			$options = array();
			$options[$this->id] = array(
				'widgettype' => "conditions",
				'region' => "csc|4",
				'width' => 305,
				'height' => 260
			);
		}     
		
		// Prepopulate Flash widget Types
		
		$widgetlist = array("conditions","map");
		
		// Prepopulate Available Regions
		$regionlist = array("Washington"=>"Washington|was|1", "Oregon"=>"Oregon|ore|2", "Central California"=>"Central Cal|nca|3", "Norcal"=>"Northern California|csc|4", "Santa Barbara/Ventura"=>"Santa Barbara / Ventura|csb|5","Los Angeles"=>"Los Angeles|cla|6","Orange County"=>"Orange County|coc|7","S. CA (San Diego)"=>"San Diego|csd|8","NE (Cape to Maine)"=>"|Cape to Main|ncc|9","NE (LI to NJ)"=>"Li tp New Jersey|nli|10","C.East (MD to VA)"=>"Maryland to Verginia|cvb|11","Central East (OBX)"=>"Central East|cch|12","Southeast"=>"South East|seg|13","Florida East Coast"=>"Florida East Coast|fcc|14","Florida Gulf"=>"Florida Gulf|gue|15","Texas"=>"Texas|guw|16","Hawaii (North Shore)"=>"Hawaii North Shore|hin|17","Hawaii (South Shore)"=>"Hawaii South Shore|his|18","British Columbia"=>"British Columbia|bcc|19","Nova Scotia"=>"Nova Scotia|nsc|20","Baja"=>"Baja,baj|21","Mainland Mexico"=>"Mainland Mexico|mew|22","Costa Rica"=>"Costa Rica|cri|23","Panama"=>"Panama|pan|24","Ecuador"=>"Ecuador|ecu|25","Peru"=>"Peru|per|26","Peru South/Chile North"=>"Sothern Peru / Nothern Chile|chn|27","Chile Central"=>"Central Chile|chc|28","Chile South"=>"Chile South|chs|29","Brazil North"=>"Northern Brazil|bno|30","Brazil Northeast"=>"NorthEast Brazil|bne|31","Brazil Bahia"=>"Brazil Bahia|bba|32","Brazil Southeast"=>"SouthEast Brazil|bse|33","Brazil South"=>"Southern Brazil|bso|34","Argentina"=>"Argentina|amo|35","Fiji"=>"Fiji|fij|36","Tonga"=>"Tonga|ton|37","Tahiti"=>"Tahiti|tah|38","Gold Coast"=>"Gold Coast|agc|39","S. East (Sydney)"=>"Sydney|ase|40","West (Geraldton)"=>"Geraldton|awe|41","S. West (Margaret River)"=>"Margaret River|asw|42","Victoria/Tasmania"=>"Victoria/Tasmania|aso|43","New Zealand North"=>"Northern New Zealand|nzn|44","New Zealand South"=>"Southern New Zealand|nzs|45","Bali"=>"Bali|bal|46","Java"=>"Java|jav|47","Sumatra"=>"Sumatra|sum|48","Morocco"=>"Morocco|mor|49","West Africa"=>"West Africa|afw|50","Madagascar"=>"Madagascar|afe|51","South Africa"=>"South Africa|act|52","Cape Verde"=>"Cape Verde|acv|53","Puerto Rico"=>"Puerto Rico|pur|54","E. Caribbean"=>"E. Caribbean|eca|55","Japan South"=>"Southern Japan|jas|56","Japan East"=>"Eastern Japan|jae|57","Philippines North"=>"Northern Philippines|phn|58","Philippines South"=>"Sothern Philippines|phs|59","Maldives"=>"Maldives|mal|60","Netherlands"=>"Netherlands|hol|61","Ireland/United Kingdom"=>"Ireland/United Kingdom|eng|62","France / Spain"=>"France / Spain|fra|63","Portugal"=>"Portugal|por|64");
	    
		// Display the Panel
		
		echo '<p><label for="'.$widgettype.'">Show: </label>';
		
		foreach ($widgetlist as $value)
		{
		  if ($value == $options[$this->id]['widgettype']){$checked = ' checked ';} else {$checked = '';}
		  echo '<input type="radio" name="'.$widgettype.'" value="'.$value.'"'. $checked . '> '.$value.' ';
		}
		
		echo '<p><label for="'.$region.'">Region: </label><select id="'.$region.'" name="'.$region.'" onchange="changeMagnet();">';
	
		foreach ($regionlist as $label=>$value)
		{
		  if ($value == $options[$this->id]['region']){$selected = ' selected ';} else {$selected = '';}
		  echo '<option name="' . $label . '" value="' . $value . '"'. $selected . '>' . $label . '</option>';
		}
		echo '</select></p><p><label for="'.$width.'">Width: </label><input type="text" name="'.$width.'" size=5 value="'.$options[$this->id]['width'].'"> (px or % or blank)</p><p><label for="'.$height.'">Height: </label><input type="text" name="'.$height.'" size=5  value="'.$options[$this->id]['height'].'"> (px or % or blank)</p><p><em>both width and height cannot be blank</em></p><input type="hidden" id="'.$submit.'" name="'.$submit.'" value="1" /></p>';
	}
	
// Initialize the widget
	function init() {
		wp_register_sidebar_widget(
			$this->id, 
			$this->name, 
			array(&$this, 'widget'), 
			array('classname' => $this->classname, 'description' => $this->description), 
			array( 'number' => -1 )
		);
		wp_register_widget_control(
			$this->id, 
			$this->name, 
			array(&$this, 'control')
		);		
	}

}

$o = new wavewatch_forecast_widget();
add_action("plugins_loaded", array($o,"init"));

?>
