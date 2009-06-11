=== Hackadelic Sliding Notes ===
Contributors: Hackadelic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=1805414
Tags: shortcode, AJAX, post, page, content, slide
Requires at least: 2.6
Tested up to: 2.8
Stable tag: 1.5.0

Ajax sliders for content fragments. Fancy replacement for foot- and other notes.

== Description ==

Check out the [plug-in homepage](http://hackadelic.com/solutions/wordpress/sliding-notes "Sliding Notes") for in-depth information about the plug-in.

The release announcements (see the links below) provide in-depth information about the particular releases.

### Change Log

#### [1.5.0 - "Accordion Virtuoso"](http://hackadelic.com/sliding-notes-1-5-0-released)

* Cool new **grouping** feature: When a note is opened, all other notes in the same group are closed. Very handy for emulating an accordion-style effect, like [this one over here](http://hackadelic.com/services#things-i-do).
* New shortcode argument *hint* to specify the text to display when hovering over the slider button.
* Changed CSS that tended to conflict with some other plugins.
* Verified WordPress 2.8 compatibility.

#### [1.4.1](http://hackadelic.com/sliding-notes-1-4-1-released)

Added workaround for themes that have shown a weird cross-browser issue in conjunction with Sliding Notes, such as [reported by Magnus](http://hackadelic.com/solutions/wordpress/sliding-notes#comment-390).

#### [1.4.0 - 'Shadowchaser' Release](http://hackadelic.com/sliding-notes-1-4-shadowchaser-release "Sliding Notes 1.4 - Shadowchaser Release")

Resolves a CSS conflict with the 'Shadowbox JS' plug-in, while at the same time relieving the user from housekeeping the CSS parts that are vital to Sliding Notes function, not their visual appearance.

>**Attention upgraders to version 1.4**:
With Sliding Notes versions prior to 1.4 you had to manually add .hidden and .block CSS clauses to your stylesheet. Please remove them again. As of Sliding Notes 1.4, these clauses are automatically added where needed.

>**Attention Shadowbox JS users**:
If you have applied the [conflict workaround](http://hackadelic.com/solutions/wordpress/sliding-notes#comment-156), and commented out the '.hidden' clause in your 'extras.css' file, you need to **uncomment it again**. (Look for it in your 'wp-content/plugins/shadowbox-js/css/' folder.)

#### [1.3.1 'Presidential Bugfix' Release](http://hackadelic.com/sliding-notes-131-bugfix-release "Sliding Notes 1.3.1 - Presidential Bugfix Release")

A small glitch had slipped into the prior release that caused sliding notes to be "dead" (not expandable) on the front page. This version fixes it.

#### [1.3.0 - 'Presidential Oath' Release](http://hackadelic.com/sliding-notes-1-3-hot-new-presidential-oath-release "Sliding Notes 1.3.1 - Presidential Oath Release")

This release is packed with features that greatly ease the integration into existing website styles and concepts, as well as the combination of different usage patterns on the same site.

* Many new shortcode arguments for easy integration into different website/usage concepts:
  * inline CSS styles
  * custom note types
  * auto-expanded notes
  * embedding shortcodes inside sliding notes
* Improved interoperability with other JavaScript/AJAX libraries
* Various cleanups and fixes

For details, see [the release announcement](http://hackadelic.com/sliding-notes-1-3-hot-new-presidential-oath-release "Announcing Sliding Notes 1.3").

#### 1.2.1

* *Widget-ready* (for usage within text widgets in the sidebar)

#### 1.2.0

* Fixed cross-browser issue!
* Fixed IE issue with missing space between slider button and surrounding text

#### 1.1.1 (internal release only)

* Compatibility fixes with older PHP versions

#### 1.1.0
ATTENTION: I had to rollback to 1.0rc5 due to cross-browser problems with the 1.1 series.

A total rewrite:

* Switch from a buggy Shortcode API to "good old" Filter API. (See [this post on that](http://hackadelic.com/shortcode-shortcomings).)
* Improved handling of multi-paragraph notes, enabling the following features:
 * Note paragraphs can be individually styled.
 * Note paragraph styles can differ from surrounding paragraph style.

Note: The styling is done the usual way in the visual editor. There's no extra UI for writing sliding notes (yet). There is an example in [the 1.1 release announcement](http://hackadelic.com/sliding-notes-major-upgrade).

#### 1.0rc5

Fixes an issue with the print preview. (Notes were not initially collapsed in print preview. Reported by Mark Adams).

#### 1.0rc4, 1.0rc3

Slight changes in the readme file only.

#### 1.0rc2

Initial public release

== Installation ==

1. Upload the whole plugin folder to your /wp-content/plugins/ folder.
1. Go to the Plugins page and activate the plugin.
1. Go to *Settings->Hackadelic Sliding Notes* and follow the instructions there.

== Screenshots ==

Screenshots? Who needs screenshots, when you can see it in live action at the [plug-in homepage](http://hackadelic.com/solutions/wordpress/sliding-notes "Sliding Notes")?

== License ==

This file is part of the *Hackadelic Sliders* WordPress plugin.

*Hackadelic Sliders* is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

*Hackadelic Sliders* is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with *Hackadelic Sliders*. If not, see <http://www.gnu.org/licenses/>.

== Frequently Asked Questions ==

= How do I use the plug-in? =

Easy: Add the shortcode [slider title="slider button title"]slider note content[/slider] to your post or page (or in text widgets, if you enabled processing shortcodes there).

= Why are there no options? =

This was a deliberate decision, with the following reasoning:

* For a typical blog site, the CSS definitions are unlikely to change, or change frequently, so it is basically a one-time effort for the administrator.
* On the other hand, having extra options is an run-time overhead that occurrs on every page load, so it's an "every-time" penalty for each and every of your visitors.
* Any customization I can think of right now is related to CSS styling. There already exists [a plug-in that allows for extra CSS styling from within the WordPress' admin interface - MyCSS](http://wordpress.org/extend/plugins/mycss/), so why re-invent the wheel, and add another stylesheet file to load on page displays?

= I love your work, are you available for hire? =

Yes I am. [Contact me](http://hackadelic.com/contact) to "talk turkey" :) 