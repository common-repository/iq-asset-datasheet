<?php
/*
	Plugin Name: IQ Asset datasheet
	Plugin URI: https://www.instant-quote.co/WordPress.aspx
	Description: Loads the datasheet for an instant-quote.co asset to your WordPress page. Configure under the Settings menu.
	Text Domain: IQdatasheet
	Author: Instant-Quote.co
	Version: 1.0.0
	Author URI: https://www.instant-quote.co
	License: GPLv2 or later
*/

/*
	Copyright 2017 Instant-Quote.co (email : neil@instant-quote.co)
	
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly!
}

//require_once(plugin_dir_path(__FILE__).'ns-sidebar/ns-sidebar.php');

// TODO: rename this class
class IQ_plugin {
	
	var $path; 				// path to plugin dir
	var $wp_plugin_page; 	// url to plugin page on wp.org
	var $IQ_plugin_page; 	// url to pro plugin page on ns.it
	var $IQ_plugin_name; 	// friendly name of this plugin for re-use throughout
	var $IQ_plugin_slug; 	// slug name of this plugin for re-use throughout
	var $IQ_plugin_ref; 	// reference name of the plugin for re-use throughout
	
	function __construct(){		
		$this->path = plugin_dir_path( __FILE__ );
		// TODO: update to actual
		//$this->wp_plugin_page = "http://wordpress.org/plugins/IQdatasheet";
		// TODO: update to link builder generated URL or other public page or redirect
		$this->IQ_plugin_page = "https://www.instant-quote.co/wordpress.aspx/";
		// TODO: update this - used throughout plugin code and only have to update here
		$this->IQ_plugin_name = "Instant-Quote.co Asset Datasheet";
		// TODO: update this - used throughout plugin code and only have to update here
		$this->IQ_plugin_slug = "Instant-Quote.co-Asset-Datasheet";
		// TODO: update this - used throughout plugin code and only have to update here
		$this->IQ_plugin_ref = "IQdatasheet_template";
		
		add_action( 'plugins_loaded', array($this, 'setup_plugin') );
		add_action( 'admin_notices', array($this,'admin_notices'), 11 );
		add_action( 'network_admin_notices', array($this, 'admin_notices'), 11 );		
		add_action( 'admin_init', array($this,'register_settings_fields') );		
		add_action( 'admin_menu', array($this,'register_settings_page'), 20 );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_assets') );
		
		// TODO: uncomment this if you want to add custom JS 
		// add_action( 'admin_print_footer_scripts', array($this, 'add_javascript'), 100 );
		
		// TODO: uncomment this if you want to add custom actions to run on deactivation
		//register_deactivation_hook( __FILE__, array($this, 'deactivate_plugin_actions') );
	}

	function deactivate_plugin_actions(){
		// TODO: add any deactivation actions here
	}
	
	/*********************************
	 * NOTICES & LOCALIZATION
	 */
	 
	 function setup_plugin(){
	 	load_plugin_textdomain( $this->IQ_plugin_slug, false, $this->path."lang/" ); 
	 }
	
	function admin_notices(){
		$message = 'IQdatasheet updated';	
		if ( $message != '' ) {
			echo "<div class='updated'><p>$message</p></div>";
		}
	}

	function admin_assets($page){
	 	wp_register_style( $this->IQ_plugin_slug, plugins_url("css/IQ-adminpage.css",__FILE__), false, '1.0.0' );
		if( strpos($page, $this->IQ_plugin_ref) !== false  ){
			wp_enqueue_style( $this->IQ_plugin_slug );
		}		
	}
	
	/**********************************
	 * SETTINGS PAGE
	 */
	
	function register_settings_fields() {
		// TODO: might want to update / add additional sections and their names, if so update 'default' in add_settings_field too
		add_settings_section( 
			$this->IQ_plugin_ref.'_set_section', 	// ID used to identify this section and with which to register options
			$this->IQ_plugin_name, 					// Title to be displayed on the administration page
			false, 									// Callback used to render the description of the section
			$this->IQ_plugin_ref 					// Page on which to add this section of options
		);
		// TODO: update labels etc.
		// TODO: for each field or field set repeat this
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowassetname', 	// ID used to identify the field
			'Display the name of the asset.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowassetname'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowimages', 	// ID used to identify the field
			'Whether to show any images.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowimages'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowthmbnails', 	// ID used to identify the field
			'Display thumbnail images.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowthmbnails'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQmaximages', 	// ID used to identify the field
			'The maximum number of thumbnail images to display', 					// The label to the left of the option interface element
			array($this,'show_settings_numbers_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQmaximages'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowvideo', 	// ID used to identify the field
			'Show video links.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowvideo'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowaboutreviews', 	// ID used to identify the field
			'Display general information about reviews.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowaboutreviews'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowprices', 	// ID used to identify the field
			'Display current prices for the asset.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowprices'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowdescription', 	// ID used to identify the field
			'Display the asset description.', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowdescription'
			)
		);
		add_settings_field( 
			$this->IQ_plugin_ref.'_IQshowassetmetadata', 	// ID used to identify the field
			'Display general information about an asset (i.e. Colour).', 					// The label to the left of the option interface element
			array($this,'show_settings_field'), // The name of the function responsible for rendering the option interface
			$this->IQ_plugin_ref, 				// The page on which this option will be displayed
			$this->IQ_plugin_ref.'_set_section',// The name of the section to which this field belongs
			array( 								// args to pass to the callback function rendering the option interface
				'field_name' => $this->IQ_plugin_ref.'_IQshowassetmetadata'
			)
		);
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQmaximages');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowthmbnails');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowaboutreviews');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowassetname');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowprices');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowdescription');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowimages');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowvideo');
		register_setting( $this->IQ_plugin_ref, $this->IQ_plugin_ref.'_IQshowassetmetadata');
	}	

	function show_settings_field($args){
		$saved_value = get_option($args['field_name']);
		$name = $args['field_name'];
		// initialize in case there are no existing options
		if ( empty($saved_value) ) {
			echo "<input type='checkbox' name='" .$name. "' /><br/>";
		} else {			
			if($saved_value) { $checked = ' checked="checked" '; }
			echo "<input " .$checked. " type='checkbox'  name='" .$name. "' /><br/>";
		}
	}

	function show_settings_numbers_field($args){
		$saved_value = get_option( $args['field_name'] );
		$name = $args['field_name'];
		$items = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10");
		// initialize in case there are no existing options
		echo "<select name='" .$name. "'>";
		foreach($items as $item) {
			$selected = ($saved_value == $item) ? 'selected="selected"' : '';
			echo "<option value='$item' $selected>$item</option>";
		}
		echo "</select>";
	}

	function register_settings_page(){
		add_submenu_page(
			'options-general.php',								// Parent menu item slug	
			__($this->IQ_plugin_name, $this->IQ_plugin_name),	// Page Title
			__($this->IQ_plugin_name, $this->IQ_plugin_name),	// Menu Title
			'manage_options',									// Capability
			$this->IQ_plugin_ref,								// Menu Slug
			array( $this, 'show_settings_page' )				// Callback function
		);
	}
	

	function show_settings_page(){
		?>
		<div class="wrap">
			
			<h2><?php $this->plugin_image( 'IQ_logo.png', __('ALT') ); ?></h2>
			
			<!-- BEGIN Left Column -->
			<div class="ns-col-left">
				<form method="POST" action="options.php" style="width: 100%;">
					<!-- <div><h1>Instant-quote.co datasheet plugin</h1></div> -->
					<?php settings_fields($this->IQ_plugin_ref); ?>					
					<?php do_settings_sections($this->IQ_plugin_ref); ?>
					<?php submit_button(); ?>
				</form>
			</div>
			<!-- END Left Column -->
						
			<!-- BEGIN Right Column -->			
			<div class="ns-col-right">				
				<h2>Implementation</h2>
				<p>The datasheet for an asset can be displayed on a page by using this plugin.</p>
				<p><b>Note: </b> only one datasheet can appear on a page.</p>
				<p>The plugin is implemented by adding a shortcode to your WordPress web page.</p>
				<p>The shortcode takes two parameters: assetid and hostid.</p>
				<p>These are numbers only and can be found as follows:</p>
				<ol>
					<li>Login to the instant-quote.co administration site.</li>
					<li>In the left panel select Configuration.</li>
					<li>Within the Configuration section select Host Configuration.</li>
					<li>Within the Host Configuration section select the host (web site) whose settings you want to use.</li>
					<li>Make a note of the Host id value at the top of the table. That is the value for hostid</li>
					<li>Within the Configuration section select Assets.</li>
					<li>Within the Assets section select the Asset whose settings you want to use.</li>
					<li>Make a note of the  Asset id value at the top of the table. That is the value for assetid </li>
				</ol>
				<p>The plugin is called using the shortcode:</p>
				<h4>[iq_datasheet assetid=&quot;?&quot; hostid=&quot;?&quot;]</h4>
				<p>Where the ? are replaced with the values you have just looked up.</p>

				<h2>Configuration</h2>	
				<p>Use the controls to the left of the page to define which fields are displayed.</p>
				<p>You can change the order of the items displayed by carefully editing the file &quot;IQdatasheet/IQdatasheet.txt&quot; moving the divs up or down in the file but maintaining the structure.</p>


			</div>
			<!-- END Right Column -->
				
		</div>
		<?php
	}
	
	
	/*************************************
	 * FUNCTIONALITY
	 */
	
	// TODO: add additional necessary functions here

	
	/*************************************
	 * UITILITY
	 */
	 
	 function plugin_image( $filename, $alt='', $class='' ){
	 	echo "<img src='".plugins_url("/images/$filename",__FILE__)."' alt='$alt' class='$class' />";
	 }
	
}

function iqdatasheet_shortcode_func($atts) {
 	$a = shortcode_atts( array(
        'assetid' => '0',
        'hostid' => '0'
    ), $atts );

	//	Enqueue the javascript for the plugin
	//	wp_deregister_script( "Instant-Quote.co-Asset-Datasheet");
		wp_register_script( "Instant-Quote.co-Asset-Datasheet", plugins_url("js/IQwp_datasheet.js",__FILE__), array('jquery'), null, true );
		wp_enqueue_script( "Instant-Quote.co-Asset-Datasheet", array('jquery'), null, true );
		wp_register_style( "Instant-Quote.co-Asset-Datasheet", plugins_url("css/IQuser.css",__FILE__),false,null);
		wp_enqueue_style(( "Instant-Quote.co-Asset-Datasheet"),false,null);

  	//include the html file
	if (file_exists(plugin_dir_path( __FILE__ ) . 'IQdatasheet.txt')){
		ob_start();	
  		include( plugin_dir_path( __FILE__ ) . 'IQdatasheet.txt' );
  		//assign the file output to $content variable and clean buffer
  		$content = ob_get_clean();
		$content = $content . "<input id='IQassetid' type='hidden' value='{$a['assetid']}' />";
		$content = $content . "<input id='IQhost' type='hidden' value='{$a['hostid']}' />";
		$content = $content . "<input id='IQmaximages' type='hidden' value='".get_option('IQdatasheet_template_IQmaximages')."' />";
		$content = $content . "<input id='IQshowthmbnails' type='hidden' value='".get_option('IQdatasheet_template_IQshowthmbnails')."' />";
		$content = $content . "<input id='IQshowaboutreviews' type='hidden' value='".get_option('IQdatasheet_template_IQshowaboutreviews')."' />";
		$content = $content . "<input id='IQshowassetname'' type='hidden' value='".get_option('IQdatasheet_template_IQshowassetname')."' />";
		$content = $content . "<input id='IQshowprices' type='hidden' value='".get_option('IQdatasheet_template_IQshowprices')."' />";
		$content = $content . "<input id='IQshowdescription' type='hidden' value='".get_option('IQdatasheet_template_IQshowdescription')."' />";
		$content = $content . "<input id='IQshowimages' type='hidden' value='".get_option('IQdatasheet_template_IQshowimages')."' />";
		$content = $content . "<input id='IQshowvideo' type='hidden' value='".get_option('IQdatasheet_template_IQshowvideo')."' />";
		$content = $content . "<input id='IQshowassetmetadata' type='hidden' value='".get_option('IQdatasheet_template_IQshowassetmetadata')."' />";

    	return $content ;

		}
		else {
		return "<input id='IQhost' type='hidden' value='{$a['hostid']}' />"; 
		}
	}


add_shortcode('iq_datasheet','iqdatasheet_shortcode_func'); 

new IQ_Plugin();
