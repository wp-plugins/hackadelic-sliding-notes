<?php 
//---------------------------------------------------------------------------------------------
/*
Plugin Name: Hackadelic Sliding Notes
Version: 1.4.0
Plugin URI: http://hackadelic.com/solutions/wordpress/sliding-notes
Description: Ajax sliders for content fragments
Author: Hackadelic
Author URI: http://hackadelic.com
*/
//---------------------------------------------------------------------------------------------

add_shortcode('slider_usage', 'hackadelic_shortcode_slider_usage');

//---------------------------------------------------------------------------------------------

function hackadelic_shortcode_slider_usage($atts, $content=null) {
	return '<pre>'
		.'[slider title=&quot;<em>slider button title</em>&quot;]<em>sliding note content</em>[/slider]'
		.'</pre>'
		;
}

//---------------------------------------------------------------------------------------------

class HackadelicSliders
{
	var $VERSION = '1.4.0'; // Make sure this is equal to the one in the plug-in header!

	var $DEFAULT_TITLE = '+/-'; // Slider button title
	var $TITLE_PREFX = 'expand/collapse slider: ';
	var $BUTTON_PREFIX = ''; // Slider button prefix
	var $BUTTON_SUFFIX = '&raquo;'; // Slider button suffix

	var $sliderID = 0; // unique per each page view, not globally unique
	var $notes = '';
	var $initjs = '';

	//-------------------------------------------------------------------------------------

	function initialize() {
		add_action('wp_print_scripts', array(&$this, 'enqueueScripts'));
		add_action('wp_footer', array(&$this, 'embedEpliogue'));
		add_filter('the_content', array(&$this, 'preProcessContent'), 10);
		add_shortcode('slider', array(&$this, 'doShortcode'));
		add_filter('the_content', array(&$this, 'postProcessContent'), 12);
		// DO NOT preProcessContent with widget_text !
		add_filter('widget_text', array(&$this, 'postProcessContent'), 12);
	}

	//-------------------------------------------------------------------------------------

	function enqueueScripts() {
		wp_enqueue_script('jquery');
	}

	//-------------------------------------------------------------------------------------

	function preProcessContent($content) {
		$this->notes = ''; // reset notes for this unit
		return $content;
	}

	//-------------------------------------------------------------------------------------

	function doShortcode($atts, $content=null) {
		extract(shortcode_atts(array(
			'title' => $this->DEFAULT_TITLE,
			'type' => '',
			'bstyle' => '',
			'nstyle' => '',
			'shortcodes' => null,
			), $atts ));

		if ($shortcodes == 'on')
			$content = do_shortcode($content); // do this early, so sliderID is consistent

		$sliderID = ++$this->sliderID;
		$noteID = "hackadelic-sliderNote-$sliderID";
		$sliderID = "hackadelic-sliderPanel-$sliderID";
		$clickCode = "toggleSlider('#$sliderID', '#$noteID')";

		if (preg_match('@</?p.*?>@si', $content)) {
			$content = "<p>${content}</p>";
			$content = preg_replace(
				'@<p.*?></p>$@i',
				'',
				$content );
		}

		//$note = '<DIV id="'.$noteID.'" class="hidden hackadelic-sliderPanel">'.$content.'</DIV>';
		$note = '<DIV id="'.$noteID.'" class="hidden">'.$content.'</DIV>';
		$this->notes .= $note;
		$this->initjs .= "\n	initSlider('#$sliderID', '#$noteID');";

		$this->_xclass($type);
		$bclass = $nclass = $type;
		$this->_xstyle($bstyle);
		$this->_xstyle($nstyle);

		$substitute = ''
			//.'<span class="hackadelic-slider>'
			.'<a href="javascript:;" class="hackadelic-sliderButton'.$bclass.'"'.$bstyle
			.'onclick="'.$clickCode.'"'
			.' title="' . $this->TITLE_PREFX . $title.'">'
			.$this->BUTTON_PREFIX . $title . $this->BUTTON_SUFFIX . '</a> '
			.'<span class="hackadelic-sliderPanel hidden'.$nclass.'"'.$nstyle.' id="'.$sliderID.'">'
			.'</span>'
			//.'</span>'
			;
		return $substitute;
	}

	//-------------------------------------------------------------------------------------

	function postProcessContent($content) {
		return $content . $this->notes;
	}

	//-------------------------------------------------------------------------------------

	function _xclass(&$class) { if ($class) $class = ' '.$class; }
	function _xstyle(&$style) { if ($style) $style = ' style="'.$style.'"'; }

	//-------------------------------------------------------------------------------------
	// NOTE: Sliders need to be inited right away, 
	// so other js libs can do their magic on the *target*, not the source element.

	function embedEpliogue() {
?>
<?php if ($this->initjs) : ?>
<!-- BEGIN Hackadelic Sliding Notes <?php echo $this->VERSION ?>, by http://hackadelic.com -->
<style type="text/css">
.hidden { display: none }
.block { display: block }
</style>
<script type="text/javascript">
function toggleSlider(target, source) {
<?php /*
	var t = initSlider(target, source)
	t.slideToggle('fast');
*/?>
	jQuery(target).slideToggle('fast');
}

function initSlider(target, source) {
	var t = jQuery(target);
<?php
	// t.length condition is a workaround for 
	// weird behaviour @ http://rennert.at/faq/unterricht et.al.
?>
	if ( t.length && !t.data('hackadelized') ) {
		var s = jQuery(source);
		t.html( s.html() ).data('hackadelized', true);
		s.replaceWith('');
	}
	return t;
}

(function(){<?php echo $this->initjs ?>

	jQuery('.hackadelic-sliderPanel:not(.auto-expand)').addClass('block').hide().removeClass('hidden');
	jQuery('.hackadelic-sliderPanel.auto-expand').addClass('block').removeClass('hidden');
})();

</script>
<!-- END Hackadelic Sliding Notes -->
<?php endif ?>
<?php
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
<p><em><strong>Important note:</strong>
Plug-in updates may require changes in the CSS, so please align your CSS with the <a href="http://hackadelic.com/solutions/wordpress/sliding-notes#sample-css">sample CSS code</a> whenever you upgrade.
</em>
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