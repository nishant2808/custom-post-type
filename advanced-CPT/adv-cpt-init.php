<?php
/*
*
*	***** ADVANCED CUSTOM POST TYPE *****
*
*	This files initializes admin and frontend components
*	
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Define Our Admin Constants

define('CPT_CORE_ADMIN_INC',dirname( __FILE__ ).'/admin/inc/');
define('CPT_CORE_ADMIN_IMG',plugins_url( '/admin/img/', __FILE__ ));
define('CPT_CORE_ADMIN_CSS',plugins_url( '/admin/css/', __FILE__ ));
define('CPT_CORE_ADMIN_JS',plugins_url( '/admin/js/', __FILE__ ));
/*
*
*  Register admin CSS
*
*/
function cpt_register_core_admin_css(){
wp_enqueue_style('cpt-core-admin', CPT_CORE_ADMIN_CSS . 'cpt-core-admin.css',null,time(),'all');
};
add_action( 'admin_enqueue_scripts', 'cpt_register_core_admin_css' );   
/**
*
*  Register admin JS/Jquery Ready
*
*/
function cpt_register_core_admin_js(){
// Register Core Admin Plugin JS	
	wp_enqueue_script('cpt-core-admin', CPT_CORE_ADMIN_JS . 'cpt-core-admin.js','jquery',time(),true);
};
add_action( 'admin_enqueue_scripts', 'cpt_register_core_admin_js' ); 
/*
*
*   Register extra links
*
*
*/
function cpt_register_extra_admin_links(){

		wp_enqueue_script('sweetalert','https://cdn.jsdelivr.net/npm/sweetalert2@11');

} 
add_action('admin_enqueue_scripts','cpt_register_extra_admin_links');   
/*
*
* admin Includes
*
*/ 
// Load the Functions
if ( file_exists( CPT_CORE_ADMIN_INC . 'cpt-core-admin-functions.php' ) ) {
	require_once CPT_CORE_ADMIN_INC . 'cpt-core-admin-functions.php';
} 



// Define Our Fronted Constants

define('CPT_CORE_FRONTEND_INC',dirname( __FILE__ ).'/frontend/inc/');
define('CPT_CORE_FRONTEND_IMG',plugins_url( '/frontend/img/', __FILE__ ));
define('CPT_CORE_FRONTEND_CSS',plugins_url( '/frontend/css/', __FILE__ ));
define('CPT_CORE_FRONTEND_JS',plugins_url( '/frontend/js/', __FILE__ ));
/*
*
*  Register Frontend CSS
*
*/
function cpt_register_core_css(){
wp_enqueue_style('cpt-core', CPT_CORE_FRONTEND_CSS . 'cpt-core.css',null,time(),'all');
};
add_action( 'wp_enqueue_scripts', 'cpt_register_core_css' );   
/**
*
*  Register Frontend JS/Jquery Ready
*
*/
function cpt_register_core_js(){
// Register Core Plugin JS	
	wp_enqueue_script('cpt-core', CPT_CORE_FRONTEND_JS . 'cpt-core.js','jquery',time(),true);
};
add_action( 'wp_enqueue_scripts', 'cpt_register_core_js' );  
/*
*
* Fronted Includes
*
*/ 
// Load the Functions
if ( file_exists( CPT_CORE_FRONTEND_INC . 'cpt-core-functions.php' ) ) {
	require_once CPT_CORE_FRONTEND_INC . 'cpt-core-functions.php';
} 

?>