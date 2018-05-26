<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Clean up wordpress <head>
 * ---------------------------------------------------------------------------------------------------------------------
 */
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Theme Scripts & Styles
 * ---------------------------------------------------------------------------------------------------------------------
 */
function alekeis_scripts() {
    $manifest = json_decode(file_get_contents('dist/assets.json', true));
    $main = $manifest->main;
    wp_enqueue_style('alekeis-css', get_template_directory_uri() . '/dist/' . $main->css, false, null);
    wp_enqueue_script('alekeis-script', get_template_directory_uri() . '/dist/' . $main->js, null, true);
}
add_action( 'wp_enqueue_scripts', 'alekeis_scripts' );

// theme setup
function alekeis_theme_setup() {
    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');
    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'mini')
    ]);
    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');
    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    // add_theme_support('customize-selective-refresh-widgets');
}
add_action( 'after_setup_theme', 'alekeis_theme_setup' );

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * configure site-origin
 * ---------------------------------------------------------------------------------------------------------------------
 */
function alekeis_widgets_collection($folders){
    $folders[] = get_template_directory() . '/widgets/';
    return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'alekeis_widgets_collection');

function siteorigin_panels_remove_inline_css(){
  remove_action( 'wp_head', 'siteorigin_panels_print_inline_css', 12 );
  remove_action( 'wp_footer', 'siteorigin_panels_print_inline_css' );
}
add_action( 'init', 'siteorigin_panels_remove_inline_css' );
     
// Add Class prefix for a custom widget field for siteorigin Plug-In
function custom_widget_field_class_prefixes( $class_prefixes ) {
  $class_prefixes[] = 'Initiative_Widget';
  return $class_prefixes;
}
add_filter( 'siteorigin_widgets_field_class_prefixes', 'custom_widget_field_class_prefixes' );

// Add custom field path
function custom_widget_field_class_paths( $class_paths ) {
  $class_paths[] = get_template_directory() . '/custom-widget-fields/';
  return $class_paths;
}
add_filter('siteorigin_widgets_field_class_paths', 'custom_widget_field_class_paths' );

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Disable the emoji's
 * ---------------------------------------------------------------------------------------------------------------------
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
   }
   add_action( 'init', 'disable_emojis' );
   
   /**
    * Filter function used to remove the tinymce emoji plugin.
    * 
    * @param array $plugins 
    * @return array Difference betwen the two arrays
    */
   function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
    return array();
    }
   }
   
   /**
    * Remove emoji CDN hostname from DNS prefetching hints.
    *
    * @param array $urls URLs to print for resource hints.
    * @param string $relation_type The relation type the URLs are printed for.
    * @return array Difference betwen the two arrays.
    */
   function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
   
   $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
   
   return $urls;
   }

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Add custom post types
 * ---------------------------------------------------------------------------------------------------------------------
 */
// add_action('init', 'register_post_types');
// function register_post_types() {
// 	$labels = array(
// 		'name' => '',
// 		'singular_name' => '',
// 		'add_new' => '',
// 		'add_new_item' => '',
// 		'edit_item' => '',
// 		'view_item' => '',
// 		'search_item' => '',
// 		'not_found' => '',
// 		'not_found_in_trash' => '',
// 		'parent_item_colon' => '' );
// 	$args = array (
// 		'labels' => $labels,
// 		'public' => true,
// 		'public_queryable' => true,
// 		'show_ui' => true,
// 		'query_var' => true,
// 		'menu_icon' => '',
// 		'rewrite' => true,
// 		'capability_type' => 'post',
// 		'hierarchical' => 'false',
// 		'menu_position' => null,
// 		'supports' => array('title', 'thumbnail', 'page-attributes'),
// 		'exclude_from_search' => true
// 	);
// 	register_post_type('', $args);
// }
