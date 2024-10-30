=== Instant-Quote.co Asset Datasheet===
Contributors: instant-quote.co
Tags: instant-quote, IQ, Datasheet, Asset Datasheet, instant quote
Requires at least: 3.5
Tested up to: 4.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==

Instant-quote.co is a Software as a service solution for small businesses. The system allows consumers to get a quote for a service at any time of the day and displays real time availability of the supplier's resources along with a comprehensive business administration suite.

This plugin for WordPress enables you to embed an Asset datasheet on your WordPress page and is configurable as to the parts of the datasheet that are displayed.

= Features =
Settings include:

1. Display or hide the asset title.
2. Display or hide the main asset image.
3. Display or hide review boilerplate text.
4. Display or hide video links.
5. Display or hide prices.
6. Limit the number of thumbnail images displayed.

== Installation ==

1. Log in to your WordPress site as an administrator
2. Use the built-in Plugins tools to install from the repository or unzip and Upload the plugin directory to /wp-content/plugins/ 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. The settings for the plugin can be edited by going to by going to Settings > instant-quote.co asset datasheet.

== Screenshots ==

None

== External resources ==

The plugin uses the generic instant-quote.co stylesheet (css)
This can be overridden using the Plugin's IQuser.css file.

== Frequently Asked Questions ==

= Is this plugin template supported? =
Support is by your normal Instant-quote.co support arrangements  

= How do I find my Asset id and Host id? =
You can find these settings in the instant-quote.co administration page.
Under configuration > Assets, the asset id is listed at the top of the table.
Under configuration > Host Settings, the Host id is listed at the top of the table.

Alternatively go to Agency > Asset Search.
On each data card the Asset id and Host id is identified.
In this case the host id is the Directory host setting for the Asset.

= How do I use the shortcode? =
When you have looked up your Asset id and Host id, go to the WordPress page editor and enter the ShortCode into the page where you want the Datasheet to appear.

The ShortCode is:

[iq_datasheet assetid="?" hostid="?"]

Where ? is replaced with the numbers you have looked up.

Note: There should be no spaces inside the quotes.


== Changelog ==

= 1.0.0 =
* First public release

== Upgrade Notice ==

