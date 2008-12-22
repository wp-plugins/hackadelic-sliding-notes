<?php 
//---------------------------------------------------------------------------------------------
/*
Plugin Name: Hackadelic Sliding Notes
Version: 1.1.1
Plugin URI: http://hackadelic.com/solutions/wordpress/sliding-notes
Description: Ajax sliders for content fragments
Author: Hackadelic
Author URI: http://hackadelic.com
*/
//---------------------------------------------------------------------------------------------

add_shortcode('slider_usage', 'hackadelic_shortcode_slider_usage');

//---------------------------------------------------------------------------------------------

function hackadelic_shortcode_slider_usage($atts, $content=null) {
	return '<code>'
		.'[slider title=&quot;<em>slider button title</em>&quot;]'
		.'<em>sliding note content</em>[/slider]</code>'
		;
}

//---------------------------------------------------------------------------------------------

class HackadelicSliders
{
	var $sliderID = 0;

	function initialize() {
		add_action('wp_print_scripts', array(&$this, 'enqueueScripts'));
		add_filter('the_content', array(&$this, 'processContent'), 12);
	}

	function enqueueScripts() {
		wp_enqueue_script('jquery');
	}

	function processContent($content) {
		$this->sliderID = 0;
		$this->notes = array();
		$regex1 = hackadelic_slider_regex('"');
		$regex2 = hackadelic_slider_regex("'");
		$content = preg_replace_callback(
			array($regex1, $regex2),
			array(&$this, 'subst'),
			$content );
		return $content;
	}

	function subst($matches) {
		global $id; // the post ID is globally set by WordPress
		$title = $matches[1]; $content = $matches[2];

		$sliderID = ++$this->sliderID;
		$sliderID = "hackadelic-sliderPanel-$id-$sliderID";
		$clickCode = "jQuery('#$sliderID').slideToggle('fast')";
		if (preg_match('@</?p.*?>@i', $content)) {
			$content = "<p>${content}</p>";
			$content = preg_replace(
				array('@^<p.*?></p>@i', '@<p.*?></p>$@i'),
				'',
				$content );
		}

		$substitute = ''
			.'<a href="javascript:;" class="hackadelic-sliderButton" onclick="'.$clickCode.'"'
			.' title="expand/collapse slider: '.$title.'">'.$title.'</a>'
			.'<span class="hackadelic-sliderPanel" style="display:none" id="'.$sliderID.'">'
			.$content
			.'</span>'
			;
		return $substitute;
	}
}

//---------------------------------------------------------------------------------------------

if (!is_admin()) {
	$hackadelicSliders = new HackadelicSliders();
	$hackadelicSliders->initialize();
}

//---------------------------------------------------------------------------------------------

function hackadelic_slider_regex($q) {
	return '@\[slider\s*title\s*=\s*'.$q.'(?P<title>.*?)'.$q.'\s*](?P<content>.*?)\[/slider]@s';
}

// ===========================================================================
// Admin Pages
// ===========================================================================

add_action('admin_menu', 'hackadelic_sliders_addAdminMenu');

//---------------------------------------------------------------------------------------------

$hackadelic_sliders_pluginTitle = 'Hackadelic Sliding Notes';

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_addAdminMenu() {
  global $hackadelic_sliders_pluginTitle;
  add_options_page(
    $hackadelic_sliders_pluginTitle, $hackadelic_sliders_pluginTitle, 10, 
    __FILE__, 'hackadelic_sliders_displayAdminPage');
}

//---------------------------------------------------------------------------------------------

function hackadelic_sliders_displayAdminPage() {
global $hackadelic_sliders_pluginTitle;
?>
<div class="wrap">
<h2><?php echo $hackadelic_sliders_pluginTitle ?></h2>
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