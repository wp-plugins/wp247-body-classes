
Contributors: wescleveland
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RM26LBV2K6NAU
Tags: mobile, post type, body, class, custom CSS, CSS, custom Body Classes, wp_is_mobile, is_home, is_front_page, is_blog, is_admin, is_admin_bar_showing, is_404, is_super_admin, is_user_logged_in, is_search, is_archive, is_author, is_category, is_tag, is_tax, is_date, is_year, is_month, is_day, is_time, is_single, is_sticky
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add unique classes to the body tag for easy styling based on post attributes (post type, slug, and ID) and various WordPress "is" functions. You can also create your own custom Body Classes.

== Description ==

Add unique classes to the body tag for easy styling based on post attributes (post type, slug, and ID) and various WordPress "is" functions:

 - wp_is_mobile()
 - is_home()
 - is_front_page()
 - is_blog()
 - is_admin()
 - is_admin_bar_showing()
 - is_404()
 - is_super_admin()
 - is_user_logged_in()
 - is_search()
 - is_archive()
 - is_author()
 - is_category()
 - is_tag()
 - is_tax()
 - is_date()
 - is_year()
 - is_month()
 - is_day()
 - is_time()
 - is_single()
 - is_sticky()
 - $post->post_type
 - $post->name
 - $post->ID
 - $user->nicename
 - $user->id
 - $archive->slug (e.g. Category slug, Tag slug, etc.)
 - $archive->id   (e.g. Category id, Tag id, etc.)

This plugin adds classes to the html body tag indicating:

 - whether or not the requesting device is a mobile device (.is-mobile or .is-not-mobile)

 - the type of post being viewed (.is-? where ? is the post type (page, post, whetever special post types are defined) ).
     E.g. .is-page or .is-post

 - the slug of the post being viewed (.is-?-! where ? is the post type and ! is the post slug).
     E.g. a post with slug "hello-world' would have class .is-post-hello-world

 - the ID of the post being viewed (.is-?-# where ? is the post type and # is the post ID).
     E.g. a post with ID "1" would have class .is-page-1

 - whether or not the requested page shows archived results (.is-archive or .is-not-archive)

   If the page being displayed is an archive

    - the type of archive being viewed (.is-? where ? represents the type of archive (author, category, date, tag) )
	    E.g. .is-author

    - the slug of the archive being viewed (.is-?-! where ? is the archive type and ! is the archive slug)
	    E.g. a category with slug "uncategorized' would have class .is-category-uncategorized

    - the ID of the archive being viewed (.is-?-# where ? is the archive type and # is the archive ID)
        E.g. a category with ID "1" would have class .is-category-1

Use these classes in your styling to provide a better browsing experience for your viewers.

= Custom Body Classes =

Create your own Custom Body Classes by adding your PHP code in the "Custom Body Classes" section.

Here's an example. Not sure why we would want to do it, but suppose we want to do some custom styling when the page is being displayed to someone that can manage WordPress options. We might enter something like:

`if (current_user_can('manage_options')) $classes[] = 'user-can-manage-options';`

Then we can use the **body.user-can-manage-options** qualifier in our CSS styling.

= Example =

Suppose you have a large h1 top margin that you want to eliminate on mobile devices to avoid a lot of white space. After activating the wp247-body-classes plugin and indicating that the .is-mobile class is desired, all you need to do is add this line to your css:

body.is-mobile h1 {
	margin-top: 0;
}

== Installation ==

In the WordPress backend, search for the plugin 'wp247 body classes'. Click the "Install" button and then click on "Activate". That's it. You're now ready to customize your viewer's browsing experience.

== Screenshots ==

1. Environment Classes setting selection
2. User Classes setting selection
3. Archive Classes setting selection
4. Post Classes setting selection
5. Custom Classes setting
6. Custom CSS setting

== Changelog ==

= 1.0.1 =
Fix PHP Error in wp247-settings-api

= 1.0 =
First release on 2015-March-1