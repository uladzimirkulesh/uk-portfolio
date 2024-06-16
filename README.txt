=== UK Portfolio ===
Contributors: uladzimirkulesh
Tags: portfolio, post type
Requires at least: 6.2
Tested up to: 6.5
Stable tag: 1.1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds "Project" Post Type to your site.

== Description ==

UK Portfolio is a WordPress plugin that adds a custom post type "Project". By having custom post types in a separate plugin, your content remains intact across different themes. It also registers separate project taxonomies for tags and categories.

This plugin doesn’t change how projects are displayed in your theme. You will need to add the some templates if you want to customize the display of projects.

== Installation ==

1. In your admin panel, go to Plugins and click the "Add New" button.
2. Click "Upload Plugin" and "Choose File", then select the plugin's .zip file. Click "Install Now".
3. Click "Activate" to use plugin right away.

== Frequently Asked Questions ==

= How can I display projects differently than regular posts? =

You will need to create some templates: archive-uk-project.html, taxonomy-uk-project_category.html and taxonomy-uk-project_category.html for displaying multiple projects and a single-uk-project.html for displaying the single project.

= Why did you make this? =

To allow users have a portfolio functionality in my themes. And hopefully to save time for other people trying to build a portfolio.

== Changelog ==

= 1.1.5 - June 16, 2024 =
* CHECKED: Compatibility with WordPress 6.5.
* ADDED: Clearing permalink cache.

= 1.1.4 - Mart 31, 2024 =
* FIXED: readme.txt.

= 1.1.3 - Mart 10, 2024 =
* DELETED: Not permitted files (.DS_Store).
* FIXED: Variables escapes.

= 1.1.2 - February 4, 2024 =
* FIXED: Variables escapes and plugin prefixes.

= 1.1.1 - January 28, 2024 =
* FIXED: add_taxonomy_filters function.

= 1.1.0 - November 12, 2023 =
* DELETED: Metaboxes.

= 1.0.0 - October 21, 2023 =
* Initial release.
