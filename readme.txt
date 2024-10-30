=== BP XML Sitemap Generator for Buddypress by SHIFT1 ===
Contributors: dconsorte
Donate link: https://www.shift1.com/plugins/
Tags: buddypress,xml,sitemap,site map,bp,group,member,user
Requires at least: 4.6
Tested up to: 5.1
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Generate a BuddyPress XML sitemap to submit your BP group and member pages to Google, Bing and other search engines.

== Description ==

This plugin will automatically generate XML site maps for your BuddyPress groups and users. It will schedule new sitemaps to be generated once daily, and includes a link to manually regenerate them if you need to. Two separate sitemaps will be generated: one for your groups, and one for your members. Sitemaps are split into separate files based on the first letter or number in the name of each group and username. The plugin is set to default to 1,000 links per sitemap file, but you can increase or decrease that number. Keep in mind, if it is too high, your sitemap files will be very large and difficult to load. Regardless of how many sitemap files you have, you will only need to submit two links to Google.

== Installation ==

Installing this plugin is extremely simple.

1. Upload the plugin files to the '/wp-content/plugins/' directory, or install the plugin through the WordPress plugins screen directly.
2. Go to the 'Plugins' screen in WordPress and scroll down to 'BP XML Sitemap Generator for BuddyPress by SHIFT1' to activate the plugin
3. Click the 'Settings' link, or go to SHIFT1 > XML Sitemap for BuddyPress on the left nav in admin to get links to the sitemaps that you'll need to submit to Google, and for any configuration options

== Frequently Asked Questions ==

= Do I need to do anything after I install the plugin? =

The sitemaps will be generated automatically. However, you will need to submit them to Google and other search engines. Instructions are on the Settings screen.

= Is the sitemap customizable? =

You can customize how many links appear in each of the sitemap files. It will generate separate files for groups and users, categorized alphabetically and is defaulted to groups of 1000 or fewer. If you have more than 1000 groups that start with the letter 'a' then it'll make separate files for each chunk of 1000. You can change this number as you see fit, but keep in mind that if it is too large, your files will be hard to load. Regardless, you'll only need to submit two URLs to Google, shown on the Settings page for this plugin. The plugin does the rest. If we receive some donations and positive feedback, then we may consider expanding the plugin further, or possibly offering a paid upgrade for greater functionality.

= Where are the sitemaps located? =

You can find links to the sitemaps on the Settings screen. Generally, a new directory will be created at /sitemap/ where all of the files are located.

== Screenshots ==

1. Menu location of settings page
2. Settings page example
3. Group sitemap index example 
4. Member sitemap index example 
5. Member page sitemap example 
6. File deletion functionality on settings page

== Changelog ==

= 1.0.0 =
* Buddypress XML sitemap released

== Upgrade Notice ==

= 1.0 =
We will consider expanding this plugin depending on the level of response.

== Developer ==

We're primarily a digital marketing company, but [SHIFT1] (https://www.shift1.com "SHIFT1") is our brand for Wordpress and other plugins.