=== Hackadelic Sliding Notes ===
Contributors: Hackadelic
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=1805414
Tags: shortcode, AJAX, post, page, content, slide
Requires at least: 2.6
Tested up to: 2.7
Stable tag: 1.0rc5

Ajax sliders for content fragments. Fancy replacement for foot- and other notes.

== Description ==

Check out the [plug-in homepage](http://hackadelic.com/solutions/wordpress/sliding-notes "Sliding Notes") for in-depth information about the plug-in.

== Installation ==

1. Upload the whole plugin folder to your /wp-content/plugins/ folder.
1. Go to the Plugins page and activate the plugin.
1. Go to *Settings->Hackadelic Sliding Notes* and follow the instructions there.

== Screenshots ==

Screenshots? Who needs screenshots, when you can see it in live action at the [plug-in homepage](http://hackadelic.com/solutions/wordpress/sliding-notes "Sliding Notes")?

== Change Log ==

ATTENTION: I had to rollback to 1.0rc5 due to cross-browser problems with the 1.1 series.

#### 1.2.0

* Fixed cross-browser issue!
* Fixed IE issue with missing space between slider button and surrounding text
* *Widget-ready* (for usage within text widgets in the sidebar)

#### 1.1.1 (internal release only)

* Compatibility fixes with older PHP versions

#### 1.1.0

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