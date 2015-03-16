<?php
/*
	Plugin Name: WP247 Body Classes
	Version: 1.0
	Description: Add unique classes to the body tag for easy styling based on post attributes (post type, slug, and ID) and various wordpress "is" functions:
					wp_is_mobile()
					is_home()
					is_front_page()
					is_blog()
					is_admin()
					is_admin_bar_showing()
					is_404()
					is_super_admin()
					is_user_logged_in()
					is_search()
					is_archive()
					is_author()
					is_category()
					is_tag()
					is_tax()
					is_date()
					is_year()
					is_month()
					is_day()
					is_time()
					is_single()
					is_sticky()
					$post->post_type
					$post->name
					$post->ID
	Tags: mobile, post type, body, class, custom CSS, CSS, custom Body Classes, wp_is_mobile, is_home, is_front_page, is_blog, is_admin, is_admin_bar_showing, is_404, is_super_admin, is_user_logged_in, is_search, is_archive, is_author, is_category, is_tag, is_tax, is_date, is_year, is_month, is_day, is_time, is_single, is_sticky
	Author: wp247
	Author URI: http://wp247.net/
	Uses: weDevs Settings API wrapper class from http://tareq.weDevs.com Tareq's Planet
*/

if ( !function_exists( 'wp247_body_classes_do_action_wp_loaded' ) )
{
	add_action( 'wp_loaded','wp247_body_classes_do_action_wp_loaded');
	add_action( 'wp_head', 'wp247_body_classes_do_action_wp_head', 99999 );
	add_filter( 'body_class', 'wp247_body_classes_do_action_body_class' );

	/*
	 * Only load Admin Settings if this user can manage options
	 */
	function wp247_body_classes_do_action_wp_loaded()
	{
		if ( current_user_can( 'manage_options' ) )
			require_once dirname( __FILE__ ) . '/wp247-body-classes-admin.php';
	}

	function wp247_body_classes_do_action_wp_head()
	{
		$css = get_option( 'wp247_body_classes_css', '' );
		if ( isset( $css[ 'custom-css' ] ) and !empty( $css[ 'custom-css' ] ) ) echo "<style type=\"text/css\">/* wp247-body-classes Custom CSS */\n".$css[ 'custom-css' ]."\n</style>\n";
	}

	function wp247_body_classes_do_action_body_class( $classes )
	{
		global $post;

		$option_names = array(
			'wp247_body_classes_environment',
			'wp247_body_classes_user',
			'wp247_body_classes_archive',
			'wp247_body_classes_post',
			);
		$options = array();
		foreach( $option_names as $opt )
		{
			$option = get_option( $opt );
			if ( is_array( $option ) ) $options = array_merge( $options, $option );
		}

		$query = get_queried_object();

		$author_extra	= array( 'slug' => $query->user_nicename, 'id' => $query->ID );
		$category_extra	= array( 'slug' => $query->slug, 'id' => $query->cat_ID );
		$tag_extra		= array( 'slug' => $query->slug, 'id' => $query->term_taxonomy_id );
		$tax_extra		= array( 'slug' => $query->slug, 'id' => $query->term_taxonomy_id );
		if ( have_posts() )
		{
			$date_extra		= array( 'year-month-day' => get_the_date( 'Y-m-d' ), 'year-month' => get_the_date( 'Y-m' ), 'year' => 'is-year-' . get_the_date( 'Y' ), 'month' => 'is-month-' . get_the_date( 'm' ), 'day' => 'is-day-' . get_the_date( 'd' ) );
			$year_extra		= array( 'year' => get_the_date( 'Y' ) );
			$month_extra	= array( 'month' => get_the_date( 'm' ) );
			$day_extra		= array( 'day' => get_the_date( 'd' ) );
			$time_extra		= array( 'year-month-day-time' => get_the_time( 'Y-m-d-G-i-s' ), 'year-month-day' => 'is-date-' . get_the_time( 'Y-m-d' ), 'year-month' => 'is-date-' . get_the_time( 'Y-m' ), 'year' => 'is-year-' . get_the_date( 'Y' ), 'month' => 'is-month-' . get_the_date( 'm' ), 'day' => 'is-day-' . get_the_date( 'd' ) );
		}
		else $date_extra = $month_extra = $day_extra = $time_extra = NULL;

		$user = wp_get_current_user();
		$user_extra   = array( 'slug' => $user->user_nicename, 'id' => $user->ID );

		$class_driver = array(
					  array( 'mobile', wp_is_mobile() )
					, array( 'home', is_home() )
					, array( 'front-page', is_front_page() )
					, array( 'blog', ( is_front_page() and is_home() ) )
					, array( 'admin', ( is_admin() or is_super_admin() ) )
					, array( 'super-admin', is_super_admin() )
					, array( 'admin-bar-showing', is_admin_bar_showing() )
					, array( 'user-logged-in', is_user_logged_in(), $user_extra, 'user' )
					, array( '404', is_404() )
					, array( 'archive', is_archive() )
					, array( 'search', is_search() )
					, array( 'single', is_single() )
					, array( 'sticky', is_sticky() )
					, array( 'author', is_author(), $author_extra )
					, array( 'category', is_category(), $category_extra )
					, array( 'tag', is_tag(), $tag_extra )
					, array( 'tax', is_tax(), $tax_extra )
					, array( 'date', is_date(), $date_extra )
					, array( 'year', is_year(), $year_extra )
					, array( 'month', is_month(), $month_extra )
					, array( 'day', is_day(), $day_extra )
					, array( 'time', is_time(), $time_extra )
					);

		if ( is_singular() and isset( $post ) )
		{
			$post_type = $post->post_type;
			$post_name = $post->post_name;
			$post_id   = $post->ID;
		}
		else $post_type = $post_name = $post_id = '';
		
		$post_types = get_post_types();
		foreach ( $post_types as $pt )
		{
			$class_driver[] = array( str_replace( '_', '-', $pt ), $pt == $post_type, array( 'slug' => $post_name, 'id' => $post_id ) );
		}

		foreach ( $class_driver as $cd )
		{
			$option = $cd[ 0 ];
			$is_value = $cd[ 1 ];
			$is_extras = ( isset( $cd[ 2 ] ) ? $cd[ 2 ] : array() );
			$is_extra_base = ( isset( $cd[ 3 ] ) ? $cd[ 3 ] : $option );
			
			if ( !is_array( $is_extras ) ) $is_extras = array( $is_extras );

			if ( $is_value )
			{
				if ( isset( $options[ $option ][ 'is-' . $option ] ) ) $classes[] = 'is-' . $option;
				foreach( $is_extras as $key => $value )
				{
					if ( !is_null( $value ) and isset( $options[ $option ][ $is_extra_base.'-'.$key ] ) )
					{
						if ( 'is-' == substr( $value, 0, 3 ) ) $classes[] = $value;
						else $classes[] = 'is-' . $is_extra_base . '-' . $value;
					}
				}
			}
			elseif ( isset( $options[ $option ][ 'is-not-' . $option ] ) ) $classes[] = 'is-not-' . $option;
		}

		$custom = get_option( 'wp247_body_classes_custom' );
		if ( isset( $custom[ 'custom-classes' ] ) and !empty( $custom[ 'custom-classes' ] ) ) @eval( $custom[ 'custom-classes' ] );

		return $classes;
	}

}
