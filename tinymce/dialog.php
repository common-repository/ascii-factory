<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly. ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php _e( 'Add Ascii', 'asciigs' ); ?></title>
<script src="<?php echo includes_url( 'js/jquery/jquery.js' ); ?>" type="text/javascript"></script>
<script src="<?php echo includes_url( 'js/tinymce/tiny_mce_popup.js' ); ?>" type="text/javascript"></script>
<script>
jQuery(document).ready(function($) {

	var Ascii = {
		e: '',
		init: function(e) {
			Ascii.e = e;
			tinyMCEPopup.resizeToInnerSize();
		},
		/*checks input parameters and writes shortcode*/
		insert: function createGalleryShortcode(e) {

			var AsciiFile = $('#ascii-file').val();
			var showOriginal = $('#ascii-show-original').is(':checked');
			var Colorized = $('#ascii-colorized').is(':checked');

			var output = '[ascii';

			if (AsciiFile) {
				output += ' file="' + AsciiFile + '"';
			}

			if (!showOriginal) {
				output += ' showOriginal="false"';
			}

			if (!Colorized) {
				output += ' colorized="false"';
			}

			output += ']';

			tinyMCEPopup.execCommand('mceReplaceContent', false, output);

			tinyMCEPopup.close();
		}
	}
	tinyMCEPopup.onInit.add(Ascii.init, Ascii);
	/*form submit listener, checks required fields*/
	$('#ascii-form').on('submit', function(e) {
		var required_file = $('#ascii-file');
		required_file.removeClass('invalid');
		$('label.invalid').remove();

		if (required_file.val() == '') {
			e.preventDefault();
			required_file.addClass('invalid');
			required_file.after('<label class="invalid" style="display: block;"><?php _e( "Required Field!", "asciigs" ); ?></label>');
		} else {
			Ascii.insert(Ascii.e);
		}
	});

});
</script>
</head>
<body>
	<form id="ascii-form" action="#">
		<p>
			<label for="ascii-file">File:</label><br/>
			<input id="ascii-file" type="text" value="" />
		</p>
		<table>
			<tr>
				<td><label for="ascii-show-original">Show Original:</label></td>
				<td><input id="ascii-show-original" type="checkbox" checked /></td>
			</tr>
			<tr>
				<td><label for="ascii-colorized">Colorized:</label></td>
				<td><input id="ascii-colorized" type="checkbox" checked /></td>
			</tr>
		</table>
		<p>
			<input type="submit" id="insert" value="Insert" />
		</p>
	</form>
</body>
</html>
