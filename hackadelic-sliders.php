<?php 
//---------------------------------------------------------------------------------------------
/*
Plugin Name: Hackadelic Sliding Notes
Version: 1.2.0
Plugin URI: http://hackadelic.com/solutions/wordpress/sliding-notes
Description: Ajax sliders for content fragments
Author: Hackadelic
Author URI: http://hackadelic.com
*/
//---------------------------------------------------------------------------------------------

add_shortcode('slider_usage', 'hackadelic_shortcode_slider_usage');
add_action('wp_footer', 'hackadelic_sliders_print_js');

//---------------------------------------------------------------------------------------------

function hackadelic_shortcode_slider_usage($atts, $content=null) {
	return '<code>'
		.'[slider title=&quot;<em>slider button title</em>&quot;]'
		.'<em>sliding note content</em>[/slider]</code>'
		;
}

function hackadelic_sliders_print_js() {
?>
<script type="text/javascript">
//-- "Hackadelic Sliding Notes", http://hackadelic.com --

function toggleSlider(target, source) {
	t = jQuery(target);
	if ( !t.data('hackadelized') ) {
		s = jQuery(source);
		t.html( s.html() ).data('hackadelized', true);
		s.replaceWith('');
	}
	t.slideToggle('fast');

	//t = jQuery(target);
	//if ( ! t.text() ) {
	//	s = jQuery(source);
	//	t.html( s.html() );
	//	s.replaceWith('');
	//}
	//t.slideToggle('fast');

	//t = jQuery(target);
	//if (t.css('display') == 'none') {
	//	s = jQuery(source).html();
	//	t.html(s).slideDown('fast');
	//}
	//else
	//	t.slideUp('fast').html('');
}

jQuery(document).ready(function() {
	jQuery('.hidden').show().hide();
});
</script>
<?php
}


//---------------------------------------------------------------------------------------------

class HackadelicSliders
{
	var $sliderID = 0;
	var $notes = '';

	//-------------------------------------------------------------------------------------

	function initialize() {
		add_action('wp_print_scripts', array(&$this, 'enqueueScripts'));
		add_filter('the_content', array(&$this, 'preProcessContent'), 10);
		add_shortcode('slider', array(&$this, 'doShortcode'));
		add_filter('the_content', array(&$this, 'postProcessContent'), 12);
	}

	//-------------------------------------------------------------------------------------

	function enqueueScripts() {
		wp_enqueue_script('jquery');
	}

	//-------------------------------------------------------------------------------------

	function preProcessContent($content) {
		$this->sliderID = 0;
		$this->notes = '';
		return $content;
	}

	//-------------------------------------------------------------------------------------

	function doShortcode($atts, $content=null) {
		extract(shortcode_atts(array(
			'title' => '+/-',
			), $atts ));
		return $this->processSlider($title, $content);
	}

	//-------------------------------------------------------------------------------------

	function processSlider($title, $content) {
		global $id; // the post ID is globally set by WordPress

		$sliderID = ++$this->sliderID;
		$noteID = "hackadelic-sliderNote-$id-$sliderID";
		$sliderID = "hackadelic-sliderPanel-$id-$sliderID";
		$clickCode = "toggleSlider('#$sliderID', '#$noteID')";

		if (preg_match('@</?p.*?>@si', $content)) {
			$content = "<p>${content}</p>";
			$content = preg_replace(
				array('@^<p.*?></p>@i', '@<p.*?></p>$@i'),
				'',
				$content );
		}

		$note = '<DIV id="'.$noteID.'" class="hidden hackadelic-sliderPanel">'.$content.'</DIV>';
		$this->notes .= $note;

		$substitute = ''
			//.'<span class="hackadelic-slider>'
			.'<a href="javascript:;" class="hackadelic-sliderButton" onclick="'.$clickCode.'"'
			.' title="expand/collapse slider: '.$title.'">'.$title.'</a> '
			.'<span class="hidden hackadelic-sliderPanel" id="'.$sliderID.'">'
			.'</span>'
			//.'</span>'
			;
		return $substitute;
	}

	//-------------------------------------------------------------------------------------

	function postProcessContent($content) {
		return $content . $this->notes;
	}
}

//---------------------------------------------------------------------------------------------

if (!is_admin()) {
	$hackadelicSliders = new HackadelicSliders();
	$hackadelicSliders->initialize();
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