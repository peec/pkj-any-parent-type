=== Plugin Name ===
Contributors: peec
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W8HDRTUEGNAFG
Tags: cms,custom,plugin,rewrite,parent,cpt
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 0.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin let's you define what parent post types that are allowed for each custom post type. Configurable in admin.

== Description ==

The PKJ Any Parent Type plugin lets you customize what parent post types that are allowed for each custom post type.
This makes it possible to have one-to-many relationship between custom post types and not just itself.

Lets say you have two custom post-types:

- Person
- Activiy

The *Person* CPT contains, well, a person. Each person can have many *Activity*. This is not possible using vanilla wordpress without many hacks, this plugins helps  you do this easily! Just configure it in the plugins options page that "The Activity type can have Parent as Person", and the "Person can have parent as "Page".

Now we create a post of type *Page* named "Persons".

We create a post type of "Person" titled "Peter" and set the parent page to "Persons".

We create a post type of "Activity" named "Ran two miles" and set the parent person to "Peter".

Now you have great urls:

- http://youtsite.com/persons <- Page
- http://youtsite.com/persons/peter <- Person
- http://youtsite.com/persons/peter/ran-two-miles <- Activity



Features:

- Easy to install, just add the plugin and go into the settings page for the plugin!
- Customizable settings in admin for each custom post type, select what types you can put as parent for each CPT.
- This plugins sorts all rewrites of URLs for you, so it actually works like expected.



== Installation ==


1. Install Pkj Any Parent Type either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Go into the plugins settings via the "Settings" tab, its named "Any Parent Type".


== Frequently Asked Questions ==

= I get 404 =

- If you previosly allowed forexample "Pages" to be parent of "Services" and removed "Pages" in settings, the parent_id
is still stored, add it again, remove the Parent and save the "Services" post.

- Go to permalinks and regenerate them

= How do i implement my custom post types? =

Refer to the documentation: [https://github.com/peec/pkj-any-parent-post-type/blob/master/README.md](https://github.com/peec/pkj-any-parent-post-type/blob/master/README.md)


== Screenshots ==

1. The settings lets you define what parents that are allowed for each CPT.
2. On the "Services" pages you now have access to set the parent of "Page". Here we allowed only "Page".
3. On the "References" pages you now have access to set the parent of "Page" and "Reference". Note only one parent is
allowed.
4. How it might look in a footer (widget).

== Changelog ==

= 0.0.1 =

First stable release.

== Upgrade Notice ==

To upgrade simply download the latest release.
