<?php
/*
 * Plugin Name: Ascii Factory
 * Description: Awesome Ascii Factory
 * Version: 0.0.1
 * Author: David Neubuaer & Joscha Probst
 * Author URI: http://rocketshape.com
 * License: MIT license
 */

class Ascii_Factory_Shortcode {

	/**
	 * Class construct.
	 */
	public function __construct() {
		// Register the shortcode.
		add_shortcode( 'ascii', array( $this, 'shortcode' ) );

		// Init the buttons.
		add_action( 'init', array( $this, 'buttonsInit' ) );

		// Register the modal dialog ajax request.
		add_action( 'wp_ajax_ascii_shortcode', array( $this, 'dialog' ) );
	}

	/**
	 * Ascii Factory shortcode.
	 *
	 * Usage:
	 * [ascii file="File" showOriginal="true (optinal)" colorized="true (optional)"]
	 *
	 * @param  array  $atts Shortcodes attributes (file).
	 *
	 * @return string       Ascii code.
	 */
	function shortcode( $atts ) {
		extract( shortcode_atts( array(
			'file' => '',
			'showoriginal' => 'true',
			'colorized' => 'true'
		), $atts ) );

		if(extension_loaded('imagick')) {
    		$img = new Imagick(esc_attr($file));

			if($colorized == 'false' || $colorized == '0'){
				/* leave hue at 100%, drop saturation by 100%, leave brightness at 100% */
    			$img->modulateImage(100, 0, 100);
    		} 

    		/* Makke a clone of the image, not a reference */
		    $unscaledImg = clone $img;

    		/* Get the Image Properties */
		    $imageprops = $img->getImageGeometry();
		   	$imgWidth = $imageprops['width'];
		    $imgHeight = $imageprops['height'];

		    /* Defines the Resolution of the ASCII-Image */
		    $scaleFactor = 8;

		    /* Calulate the new scaled size */
		    $imgWidthScaled = floor($imgWidth / $scaleFactor);
		    $imgHeightScaled = floor($imgHeight / $scaleFactor);

		    /* Scale the original image to cluster the Pixels */
		    $img->resizeImage($imgWidthScaled, $imgHeightScaled, imagick::FILTER_LANCZOS, 1);

		    /* Imagemagick PixelIterator */
		    $it = $img->getPixelIterator();
		    $pixelColors = [];
          	/* Loop trough pixel rows */
			foreach( $it as $row => $pixels ){
			  $rowColors = [];
			  /* Loop trough the pixels in the row (columns) */
		      foreach ( $pixels as $column => $pixel ){
		      	/* getColor returns an rgba-Array */
		      	$color = $pixel->getColor();
		        array_push($rowColors, $color);		        
		      }
		      array_push($pixelColors, $rowColors);
			  /* Sync the iterator, this is important to do on each iteration */
			  $it->syncIterator();
			}

			/* Values for the CSS Style */
			$rowHeight = $imgHeight / $imgHeightScaled;
			$fontSize = ($imgWidth / $imgWidthScaled) * 2;
			$columnWidth = $imgWidth / $imgWidthScaled;

			/* return variable */
			$ascii = '';

			/* Loop trough PixelColors and print each Pixel */
			$ascii .= '<div class="ascii-image" style="width:'.$imgWidth.'px;height:'.$imgHeight.'px; overflow: hidden; margin: auto;">';		
			foreach($pixelColors as $row){
				$ascii .= '<div style="height:'.$rowHeight.'px; font-size: '.$fontSize.'px;">';
				/* Loop through each Column */
				foreach($row as $column => $value){
					$rgb = 'rgb('.$value['r'].','.$value['g'].','.$value['b'].')';
					$ascii .= '<span style="color: '.$rgb.'; width:'.$columnWidth.'px; " >#</span>';
				}
				$ascii .= '</div>';
			}
			$ascii .= "</div>";

			if($showoriginal == 'true' || $showoriginal == '1'){
				$ascii .= sprintf( '<img src="data:image/jpg;base64,'.base64_encode($unscaledImg->getImageBlob()).'" alt="" />' );
			}

			return $ascii;
		} else {
			echo 'imagemagick missing.';
		}
	}

	/**
	 * Add custom buttons in TinyMCE.
	 */
	function registerButtons( $buttons ) {
		array_push( $buttons, '|', 'ascii' );
		return $buttons;
	}

	/**
	 * Register button scripts.
	 */
	function addButtons( $plugin_array ) {
		$plugin_array['ascii'] = plugins_url( 'tinymce/ascii.js' , __FILE__ );
		return $plugin_array;
	}

	/**
	 * Register buttons in init.
	 */
	function buttonsInit() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( true == get_user_option( 'rich_editing') ) {
			add_filter( 'mce_external_plugins', array( $this, 'addButtons' ) );
			add_filter( 'mce_buttons', array( $this, 'registerButtons' ) );
		}
	}

	/**
	 * Displays the shortcode modal dialog.
	 *
	 * @return string  Modal Dialog HTML.
	 */
	function dialog() {
		@ob_clean();

		include plugin_dir_path( __FILE__ ) . 'tinymce/dialog.php';

		die();
	}

} // close class.

new Ascii_Factory_Shortcode;
