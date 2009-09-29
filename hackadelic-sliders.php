<?php 
//---------------------------------------------------------------------------------------------
/*
Plugin Name: Hackadelic Sliding Notes
Version: 1.6.2.1
Plugin URI: http://hackadelic.com/solutions/wordpress/sliding-notes
Description: Ajax sliders for content fragments
Author: Hackadelic
Author URI: http://hackadelic.com
*/
//---------------------------------------------------------------------------------------------
add_action('plugins_loaded', array('HackadelicSliders', 'start'));

class HackadelicSliders
{
	var $info = array( // Make sure this is equal to the information in the plug-in header!
		'title' => 'Hackadelic Sliding Notes',
		'version' => '1.6.2.1',
		'slug' => 'sliding-notes');

	//-------------------------------------------------------------------------------------

	var $DEFAULT_TITLE = '+/-'; // Slider button title
	var $TITLE_PREFX = 'expand/collapse slider: ';
	var $BUTTON_PREFIX = ''; // Slider button prefix
	var $BUTTON_SUFFIX = '&raquo;'; // Slider button suffix

	var $sliderID = 0; // unique per each page view, not globally unique
	var $entryID = 0; // ID of the entry currently processed, or 0 (ex. when in widebar widgets)
	var $notes = '';
	var $initjs = '';

	//-------------------------------------------------------------------------------------

	function start() {
		new HackadelicSliders();
	}

	//-------------------------------------------------------------------------------------

	function HackadelicSliders() {
		if (is_admin())
			$this->initAdmin();
		else
			$this->initPublic();
	}

	//-------------------------------------------------------------------------------------

	function initPublic() {
	
		add_action('wp_print_scripts', array(&$this, 'enqueueScripts'));
		add_action('wp_head', array(&$this, 'embedPrologue'), 99);
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
		global $id;
		$this->entryID = $id;
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
			'group' => '',
			'hint' => '',
			'shortcodes' => null,
			), $atts ));

		if ($shortcodes == 'on')
			$content = do_shortcode($content); // do this early, so sliderID is consistent

		$sliderID = ++$this->sliderID;
		$noteID = "hackadelic-sliderNote-$sliderID";
		$sliderID = "hackadelic-sliderPanel-$sliderID";

		if (preg_match('@</?p.*?>@si', $content)) {
			$content = "<p>${content}</p>";
			$content = preg_replace(
				'@<p[^>]*?></p>$@i',
				'',
				$content );
		}

		//$note = '<div id="'.$noteID.'" class="concealed hackadelic-sliderPanel">'.$content.'</div>';
		$note = '<div id="'.$noteID.'" class="concealed">'.$content.'</div>';
		$this->notes .= $note;
		$this->initjs .= "\n	initSlider('#$sliderID', '#$noteID');";

		$this->_xclass($type);
		$bclass = $nclass = $type;
		$this->_xstyle($bstyle);
		$this->_xstyle($nstyle);
		if (!$hint) $hint = $this->TITLE_PREFX . $title;

		if ($group) {
			$gid = $this->entryID;
			$group = sanitize_title($group);
			$group = "$group-$gid";
			$nclass .= " $group";
			//$clickCode = "jQuery('.$group').slideUp('fast'); $clickCode";
			$clickCode = "toggleSliderOfGroup('.$group', '#$sliderID')";
		}
		else
			$clickCode = "toggleSlider('#$sliderID')";

		$substitute = ''
			//.'<span class="hackadelic-slider>'
			.'<a href="javascript:;" class="hackadelic-sliderButton'.$bclass.'"'.$bstyle
			.'onclick="'.$clickCode.'"'
			.' title="' . $hint .'">'
			.$this->BUTTON_PREFIX . $title . $this->BUTTON_SUFFIX . '</a> '
			.'<span class="hackadelic-sliderPanel concealed'.$nclass.'"'.$nstyle.' id="'.$sliderID.'">'
			.'</span>'
			//.'</span>'
			;
		return $substitute;
	}

	//-------------------------------------------------------------------------------------

	function postProcessContent($content) {
		$this->entryID = 0;
		$notes = $this->notes;
		$this->notes = '';
		return $content . $notes;
	}

	//-------------------------------------------------------------------------------------

	function _xclass(&$class) { if ($class) $class = ' '.$class; }
	function _xstyle(&$style) { if ($style) $style = ' style="'.$style.'"'; }

	//-------------------------------------------------------------------------------------
	function embedPrologue() {
		$plugin = (object) $this->info;
?>
<!-- BEGIN <?php echo "$plugin->title $plugin->version" ?> -->
<style type="text/css">
.concealed { display: none }
.block { display: block }
</style>
<!-- END <?php echo "$plugin->title $plugin->version" ?> -->
<?php
	}

	//-------------------------------------------------------------------------------------
	// NOTE: Sliders need to be inited right away, 
	// so other js libs can do their magic on the *target*, not the source element.

	function embedEpliogue() {
		$plugin = (object) $this->info;
?>
<?php if ($this->initjs) : ?>
<!-- BEGIN <?php echo "$plugin->title $plugin->version" ?> -->
<script type="text/javascript">//<![CDATA[
function toggleSlider(target) {
	jQuery(target).slideToggle('fast');
}
function toggleSliderOfGroup(group, target) {
	var t = jQuery(target);
	if (t.css('display') == 'none') {
		var g = jQuery(group);
		g.slideUp('fast');
	}
	t.slideToggle('fast');
}
function initSlider(target, source) {
	var t = jQuery(target);
<?php
	// t.length condition is a workaround for 
	// weird behaviour @ http://rennert.at/faq/unterricht et.al.
?>
	if ( t.length && !t.data('hackadelized') ) {
		var s = jQuery(source);
		t.html( s.html() ); t.data('hackadelized', true);
		s.replaceWith('');
	}
	return t;
}

(function(){<?php echo $this->initjs ?>

	jQuery('.hackadelic-sliderPanel:not(.auto-expand)').addClass('block').hide().removeClass('concealed');
	jQuery('.hackadelic-sliderPanel.auto-expand').addClass('block').removeClass('concealed');
})();

//]]></script>
<!-- END <?php echo "$plugin->title $plugin->version" ?> -->
<?php endif ?>
<?php include 'common/xsig.php';
	}

	//=====================================================================================
	// ADMIN
	//=====================================================================================

	function initAdmin() {
		add_action('admin_menu', array(&$this, 'addAdminMenu'));
	}

	//-------------------------------------------------------------------------------------

	function addAdminMenu() {
		//$title = 'Hackadelic Sliding Notes';
		$title = 'Sliding Notes';
		add_options_page($title, $title, 10, __FILE__, array(&$this, 'handleOptions'));
	}

	//-------------------------------------------------------------------------------------

	function handleOptions() {
		$plugin = (object) $this->info;
		include 'template.settings.php';
	}
}

?>