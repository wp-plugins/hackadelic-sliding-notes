<?php
if ( !defined('ABSPATH') )
	exit("Sorry, you are not allowed to access this page directly.");
if ( !isset($this) || !is_a($this, HackadelicSliders) )
	exit("Invalid operation context.");
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php echo $plugin->title ?></h2>
<?php
	$slugHome = $slugWP = $plugin->slug;
	include dirname(__FILE__) . '/common/xadm.php'
?>
	<div style="margin-right:180px">

		<div id="important-notice" style="border: 1px solid #ccc; background-color: navajowhite; padding: 5px">
			<span style="float:right"><a href="#" title="close" style="text-decoration:none" onclick="jQuery('#important-notice').fadeOut('slow'); return false;">x</a></span>
			<h3>IMPORTANTE NOTICE</h3>
			  <p>Version 1.6.5 is presumably <strong>the very last release in the 1st generation of Sliding Notes</strong>. Development of the <strong>next generation</strong> is taking over on a <a href="http://slidingnotes.hackadelic.com/" title="Sliding Note's Development Website">brand new shiny website</a>.</p>
			  <p>The next generation of Sliding Notes is being rewritten from scratch, based on an entirely new concept that will enable cool features like linkability, skinnability, and more.</p>
			  <p>Naturally, it will be inevitable that some of the things will work differently than before, so users may have to adapt this or that (most probably CSS code).</p>
			  <p>You should connect with development for early access to information
			  about upcoming changes and compatibility workarounds that may arise from them.</p>
			  <p><a target="_blank" href="http://slidingnotes.hackadelic.com/" title="Sliding Note's Development Website">Click here to connect and apply for early access</a>.</p>
		</div>

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
<?php /** / ?>
		<div style="border: 1px solid #ccc; background-color: navajowhite; padding: 5px">
			<h3>ATTENTION upgraders to version 1.4</h3>
			<p>
			With Sliding Notes versions prior to 1.4 you had to manually add
			<em>.hidden</em> and <em>.block</em> CSS clauses to your stylesheet.
			<strong>Please remove them again.</strong>
			As of Sliding Notes 1.4, these clauses are <em>automatically added</em> where needed.
			</p>
			<h3>ATTENTION Shadowbox JS users</h3>
			<p>
			If you have applied the
			<a href="http://hackadelic.com/solutions/wordpress/sliding-notes#comment-152">conflict</a>
			<a href="http://hackadelic.com/solutions/wordpress/sliding-notes#comment-156">workaround</a>,
			and commented out the <em>.hidden</em> clause in your <em>extras.css</em> file,
			you need to <strong>uncomment it again</strong>!
			(Look for it in the <em>wp-content/plugins/shadowbox-js/css/</em> folder.)
			</p>
		</div>
<?php /**/ ?>
</div>
