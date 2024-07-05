<?php
/*
Plugin Name: Advanced Custom Post Type 
Plugin URI: http://localhost/brand/
Description: Custom Post Type easy-to-use interface for registering and managing custom post types and taxonomies for your website.
Version: 1.5.0
Author: Nishant Thakur
Author URI: http://localhost/brand/
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Activation Hook
register_activation_hook(__FILE__, 'my_cpt_plugin_create_table');
function my_cpt_plugin_create_table() 
{
    global $wpdb;   
    $table_name = $wpdb->prefix . 'custom_post_type';
    
    // SQL query to create custom post type tabe

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        post_name VARCHAR(255) NOT NULL,
        slug VARCHAR(255)NOT NULL,
        supports VARCHAR(255)NOT NULL,
        shortcode VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

    )";

    $table = $wpdb->prefix . 'custom_taxonomy';

    // SQL query to create custom taxonomy
    $sql_query = "CREATE TABLE IF NOT EXISTS  $table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        singular_name VARCHAR(255) NOT NULL,
        slug VARCHAR(255)NOT NULL,
        post_type VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

    )";

    // Execute the query
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql_query);
}
// Deactivation Hook
register_deactivation_hook(__FILE__, 'my_cpt_plugin_drop_table');

function my_cpt_plugin_drop_table() {
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_post_type';
    $table = $wpdb->prefix . 'custom_taxonomy';

    // SQL query to drop both table
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $sql_query = "DROP TABLE IF EXISTS $table;";

    // Execute the query
    $wpdb->query($sql);
    $wpdb->query($sql_query);

   
}

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'adv-cpt-init.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'adv-cpt-init.php' );
}

?>