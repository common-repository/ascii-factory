=== Plugin Name ===
Contributors: ascii-factory
Donate link: http://rocketshape.com/
Tags: ascii, image, imagemagick
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Ascii Factory converts an image into ascii characters.

== Description ==

The ASCII-Image_Factory converts images into ascii characters. The Plugin is integrated into the TinyMCE Editor and writes a shortcode to your article, where the image should be displayed. The images are analyzed on the server, where the pixels are clustered and displayed as ascii characters on the client. The user is able to display the original and the ascii image together or to show just the ascii-image. Furthermore the user can convert the image into gray shades. 

== Installation ==

1. Install ImageMagick ('apt-get install php5-imagick' on linux distributions)
2 If your not able to install ImageMagick ask your server administrator to install it
3. Upload the `ascii-factory` folder to the `/wp-content/plugins/` directory
4. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Is it possible to write the information directly into the text, instead of using the button? =

Of course you can write the shortcode by hand.
Following structure is required: [ascii file="yourURL" showOriginal="true/false" colorized="true/false"]

== Changelog ==

version 0.0.1

== Upgrade Notice ==

none

== Screenshots ==

1. colorized
2. gray shades
3. input field