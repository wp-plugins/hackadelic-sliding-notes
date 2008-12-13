<?php 
/*
Plugin Name: Hackadelic Sliding Notes
Version: 1.0rc2
Plugin URI: http://hackadelic.com/solutions/wordpress/sliding-notes
Description: Ajax sliders for content fragments
Author: Zoran Isailovski alias Hackadelic
Author URI: http://hackadelic.com
*/

add_action('wp_print_scripts', 'hackadelic_sliders_scripts');
add_filter('the_content', 'hackadelic_sliders_prefilter', 5);
add_filter('the_content', 'hackadelic_sliders_postfilter', 55);
add_shortcode('slider', 'hackadelic_shortcode_slider');
add_shortcode('slider_usage', 'hackadelic_shortcode_slider_usage');
//add_shortcode('sliderButton', 'hackadelic_shortcode_sliderButton');

//---------------------------------------------------------------------------------------------

$sliderID = 0;
$priorID = 0;

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_scripts() {
	wp_enqueue_script('jquery');
}

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_prefilter($content) {
	global $sliderID, $priorID;
	$priorID = $sliderID;
	return $content;
}

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_postfilter($content) {
	global $sliderID, $priorID;
	if ($sliderID == $priorID) return $content;
	return preg_replace('@<p>(.*?)</p>@s', '\1<p></p>', $content);
}

//---------------------------------------------------------------------------------------------

function hackadelic_shortcode_slider_usage($atts, $content=null) {
	return '<code>'
		.'[slider title=&quot;<em>slider button title</em>&quot;]'
		.'<em>sliding note content</em>[/slider]</code>'
		;
}

//---------------------------------------------------------------------------------------------

function hackadelic_shortcode_slider($atts, $content=null) {
	extract(shortcode_atts(array(
		'title' => '+/-',
		), $atts ));

	global $sliderID;
	++$sliderID;

	$clickCode = "jQuery('#hackadelic-sliderPanel-$sliderID').slideToggle('fast')";

	$panelTag = 'div'; //preg_match('/\<\/?(p)>/i', $content) ? 'div' : 'span';

	if ($notestyle) $notestyle = ' style="'.$notestyle.'"';

	$content = ''
		.'<a href="javascript:;" class="hackadelic-sliderButton" '
		."title=\"expand/collapse slider: $title\""
		."onclick=\"$clickCode\" title=\"expand/collapse slider: $title.\">$title&raquo;</a>"
		."<$panelTag class=\"hackadelic-sliderPanel $noteclass\" id=\"hackadelic-sliderPanel-$sliderID\"$notestyle>$content"
		."</$panelTag>"
		;
	return $content;
}

// ===========================================================================
// Admin Pages
// ===========================================================================

add_action('admin_menu', 'hackadelic_sliders_addAdminMenu');

//---------------------------------------------------------------------------------------------

$pluginTitle = 'Hackadelic Sliding Notes';

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_addAdminMenu() {
  global $pluginTitle;
  add_options_page(
    $pluginTitle, $pluginTitle, 10, 
    __FILE__, 'hackadelic_sliders_displayAdminPage');
}

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_displayAdminPage() {
global $pluginTitle;
?>
<div class="wrap">
<h2><?php echo $pluginTitle ?></h2>
<p>
To customize the look of your sliding notes,
integrate the
<a href="http://hackadelic.com/solutions/wordpress/sliding-notes#sample-css">sample CSS code</a>
from the
<a href="http://hackadelic.com/solutions/wordpress/sliding-notes">plugin homepage</a>
into your stylesheet(s), and adjust it as you see fit.
</p>
<p>
If you don't want to mess around with your theme's <code>style.css</code> file,
consider using the <a href="http://wordpress.org/extend/plugins/mycss/">MyCSS plugin</a>,
which will enable you to add/edit extra CSS definitions
from within the WordPress admin interface.
</p>
<p>
Done that? Well then, that's it! 
<a href="http://hackadelic.com/solutions/wordpress/sliding-notes#configuration">Nothing more to configure</a>.
</p>
<p>Cheers and happy sliding!</p>
</div>
<?php
} //-- end function hackadelic_sliders_displayAdminPage

?>