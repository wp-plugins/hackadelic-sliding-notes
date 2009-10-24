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
	include 'common/xadm.php'
?>
	<div style="margin-right:180px">
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
</div>
