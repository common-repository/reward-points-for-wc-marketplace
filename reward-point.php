<?php 
/*
	Plugin Name: Reward Points for wc-marketplace
	Plugin URI: https://wordpress.org/plugins/reward-points-wc-marketplace/
	Description: Reward point by vendor for your store with offers and redeem features.
	Author: Excellentwebworld
	Version: 1.0
	Author URI: http://www.excellentwebworld.com
	*/
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

/**
*  Activation Class  - WordPress plugin depency check. Check if another plugin is installed before allowing yours to be installed
**/
register_activation_hook( __FILE__, array('WC_CPInstallCheck', 'install') );
if ( ! class_exists( 'WC_CPInstallCheck' ) ) {
  class WC_CPInstallCheck {
	static function install() {
	  /**
	  * Check if WooCommerce & Cubepoints are active
	  **/
	  if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ||
		  !in_array( 'dc-woocommerce-multi-vendor/dc_product_vendor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
		// Deactivate the plugin
		deactivate_plugins(__FILE__);
		
		// Throw an error in the wordpress admin console
		$error_message = __('This plugin requires <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> &amp; <a href="https://wordpress.org/plugins/dc-woocommerce-multi-vendor/">WC Marketplace</a> plugins to be active!', 'woocommerce');
		wp_die($error_message);
		
	  }		
	}
  }
}



define('EWW_REWARD_POINTPLUGPATH',plugin_dir_path(__FILE__));
/**rewrite rules is to do it on activation of your plugin.**/
define( 'EWW_REWARD_POINT_REWRITE_FLUSH', __FILE__ );
register_activation_hook( EWW_REWARD_POINT_REWRITE_FLUSH, 'eww_rewrite_flush');
function eww_rewrite_flush() {
	  flush_rewrite_rules();
}
/** Create a tables when install a plugin **/
function eww_installer(){
	include('eww_installer.php');
}
register_activation_hook( __file__, 'eww_installer' );

 
add_action( 'admin_menu', 'eww_reward_point_system' );
function eww_reward_point_system()
{
  $path =  plugin_dir_url( __FILE__ );
  $page_title = 'Reward Points';
  $menu_title = 'Reward Points';
  $capability = 'manage_options';
  $menu_slug  = 'reward-points';
  $function   = 'eww_reward_point_page';
  $icon_url   = '';
  $position   = 10;
  add_menu_page( $page_title,$menu_title,$capability,$menu_slug,$function,$icon_url,$position );
  //add_submenu_page( 'Settings','Settings',$capability,$menu_slug,$function,$icon_url,$position );
  add_submenu_page( 'reward-points', 'Customer Rewards', 'Customer Rewards',
	'manage_options', 'customer-points', 'eww_customer_reward_points');
  add_submenu_page( 'reward-points', 'Vendor Offers', 'Vendor Offers',
	'manage_options', 'vendor-offers', 'eww_vendor_all_offers');
}


function eww_reward_point_page() {
	//register our settings
	//register_setting('reward_point_setting', 'reward_percentage');
	include_once(EWW_REWARD_POINTPLUGPATH.'includes/functions/reward-point-option.php');
}

function eww_customer_reward_points(){
	include_once(EWW_REWARD_POINTPLUGPATH.'includes/functions/customer-reward-points.php');
}

function eww_vendor_all_offers(){
	include_once(EWW_REWARD_POINTPLUGPATH.'includes/functions/vendor-offers.php');
}

add_action('wp_head','eww_reward_point_frontend_style');
function eww_reward_point_frontend_style(){
	include_once(EWW_REWARD_POINTPLUGPATH.'templates/reward-point-front-styling.php');
}

/** create a page when install plugin **/
// setup a function to check if these pages exist
function eww_the_slug_exists($post_name) {
	global $wpdb;
	if($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
		return true;
	} else {
		return false;
	}
}
define( 'EWW_REWARD_POINT_PLUGIN_FILE', __FILE__ );
register_activation_hook( EWW_REWARD_POINT_PLUGIN_FILE, 'eww_reward_point_plugin_activation' );
function eww_reward_point_plugin_activation() {

	// create the Vendor Add Offer Product page

    $vendor_add_offer_title = 'Vendor Add Offer Product';
    $vendor_add_offer_page_check = get_page_by_title($vendor_add_offer_title);
    $vendor_add_offer_page = array(
	    'post_type' => 'page',
	    'post_title' => $vendor_add_offer_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'vendor-add-offer'
    );
    if(!isset($vendor_add_offer_page_check->ID) && !eww_the_slug_exists('vendor-add-offer')){
        $vendor_add_offer_page_id = wp_insert_post($vendor_add_offer_page);
    }
    // create the Vendor All Offer Product

    $vendor_all_offer_title = 'Vendor All Offer Product';
    $vendor_all_offer_page_check = get_page_by_title($vendor_all_offer_title);
    $vendor_all_offer_page = array(
	    'post_type' => 'page',
	    'post_title' => $vendor_all_offer_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'vendor-all-offer'
    );
    if(!isset($vendor_all_offer_page_check->ID) && !eww_the_slug_exists('vendor-all-offer')){
        $vendor_all_offer_page_id = wp_insert_post($vendor_all_offer_page);
    }
    // create the Vendor Reward Points

    $vendor_all_reward_title = 'Vendor Reward Points';
    $vendor_all_reward_page_check = get_page_by_title($vendor_all_reward_title);
    $vendor_all_reward_page = array(
	    'post_type' => 'page',
	    'post_title' => $vendor_all_reward_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'vendor-all-reward-point'
    );
    if(!isset($vendor_all_reward_page_check->ID) && !eww_the_slug_exists('vendor-all-reward-point')){
        $vendor_all_reward_page_id = wp_insert_post($vendor_all_reward_page);
    }
    // create the Vendor All Offer Product

    $vendor_edit_offer_title = 'Vendor Edit Offer Product';
    $vendor_edit_offer_page_check = get_page_by_title($vendor_edit_offer_title);
    $vendor_edit_offer_page = array(
	    'post_type' => 'page',
	    'post_title' => $vendor_edit_offer_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'vendor-edit-offer'
    );
    if(!isset($vendor_edit_offer_page_check->ID) && !eww_the_slug_exists('vendor-edit-offer')){
        $vendor_edit_offer_page_id = wp_insert_post($vendor_edit_offer_page);
    }
    // create the Vendor All Offer Product

    $customer_redeem_points_title = 'Customer Reedem Point';
    $customer_redeem_points_page_check = get_page_by_title($customer_redeem_points_title);
    $customer_redeem_points_page = array(
	    'post_type' => 'page',
	    'post_title' => $customer_redeem_points_title,
	    'post_status' => 'publish',
	    'post_author' => 1,
	    'post_slug' => 'customer-redeem-points'
    );
    if(!isset($customer_redeem_points_page_check->ID) && !eww_the_slug_exists('customer-redeem-points')){
        $customer_redeem_points_page_id = wp_insert_post($customer_redeem_points_page);
    }
}


/** localize admin ajax **/
function eww_enqueue_scripts_styles_init() {
   
  
  wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ). 'js/custom.js', array('jquery'), 1.0 ); // jQuery will be included automatically
  wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  wp_localize_script( 'ajax-script', 'cart_ajax', array( 'ajaxurl' =>   admin_url( 'admin-ajax.php' ) ) );
  wp_enqueue_script( 'modrize-script', plugin_dir_url( __FILE__ ). 'js/modernizr.min.js', array('jquery'), 1.0 );
  wp_enqueue_script( 'datatable-jquery-script', plugin_dir_url( __FILE__ ). 'lib/jquery.dataTables.min.js', array('jquery'), 1.0 ); // jquery datatable js
  //wp_enqueue_script( 'datepicker', plugin_dir_url( __FILE__ ). '../wp-includes/js/jquery/ui/datepicker.min.js?ver=1.11.4', array('jquery'), 1.0 );
  
}

add_action('wp_enqueue_scripts', 'eww_enqueue_scripts_styles_init');

function eww_add_my_stylesheet() 
{
    //wp_enqueue_style( 'myCSS', plugins_url( '/lib/css/jquery.dataTables.css', __FILE__ ) );
    wp_enqueue_style( 'myCSS1', plugins_url( '/lib/dataTables.bootstrap.min.css', __FILE__ ) );
    wp_enqueue_style( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css?ver=4.8.3', array('jquery'), 1.0 );
}
add_action('wp_print_styles', 'eww_add_my_stylesheet');

function eww_wpdocs_selectively_enqueue_admin_script() {
  
   wp_enqueue_script( 'datatable-jquery-script', plugin_dir_url( __FILE__ ). 'lib/jquery.dataTables.min.js', array('jquery'), 1.0 ); // jquery datatable js 
   wp_enqueue_style('datatable-css', plugin_dir_url( __FILE__ ). 'lib/datatables.min.css', 1.0);
   wp_enqueue_style('backend-css', plugin_dir_url( __FILE__ ). 'includes/css/backend-css.css', 1.0);
   wp_enqueue_script( 'backend-js', plugin_dir_url( __FILE__ ). 'includes/js/backend.js', array('jquery'), 1.0 );
   wp_enqueue_style( 'wp-color-picker' );
   wp_enqueue_script( 'wp-color-picker');
   
}
add_action( 'admin_enqueue_scripts', 'eww_wpdocs_selectively_enqueue_admin_script' );


function eww_reward_point_styles() {
  echo "<link rel='stylesheet' id='reward-css' href='" . plugin_dir_url( __FILE__ ) . "css/eww_reward_point_style.css' type='text/css' />" . "\n";
  //echo "<link rel='stylesheet' id='datatable-jquery-css' href='" . plugin_dir_url( __FILE__ ) . "lib/css/datatables.min.css' type='text/css' />" . "\n";

}
add_action('wp_print_styles', 'eww_reward_point_styles');
/** localize admin ajax (END)**/
	
/*** add a dashboard menu and endpoints **/
add_action('wcmp_init', 'eww_after_wcmp_init');
function eww_after_wcmp_init() {
  // add a setting field to wcmp endpoint settings page
  add_action('settings_vendor_general_tab_options', 'eww_add_vendor_reward_point_endpoint_option');
  add_action('settings_vendor_general_tab_options', 'eww_add_vendor_offer_endpoint_option');
  add_action('settings_vendor_general_tab_options', 'eww_all_vendor_offer_endpoint_option');
  add_action('settings_vendor_general_tab_options', 'eww_edit_vendor_offer_endpoint_option');
  add_action('settings_vendor_general_tab_options', 'eww_customer_reedem_points_endpoint_option');
  // save setting option for custom endpoint
  add_filter('settings_vendor_general_tab_new_input', 'eww_save_custom_endpoint_option', 10, 2);
  // add custom endpoint
  add_filter('wcmp_endpoints_query_vars', 'eww_add_wcmp_endpoints_query_vars');
  // add custom menu to vendor dashboard
  add_filter('wcmp_vendor_dashboard_nav', 'eww_add_tab_to_vendor_dashboard');
  // display content of custom endpoint
  add_action('wcmp_vendor_dashboard_vendor-all-reward-point_endpoint', 'eww_custom_menu_endpoint_content');
  add_action('wcmp_vendor_dashboard_vendor-add-offer_endpoint', 'eww_vendor_add_offer_endpoint_content');
  add_action('wcmp_vendor_dashboard_vendor-all-offer_endpoint', 'eww_vendor_all_offer_endpoint_content');
  add_action('wcmp_vendor_dashboard_vendor-edit-offer_endpoint', 'eww_vendor_edit_offer_endpoint_content');
  add_action('wcmp_vendor_dashboard_customer-redeem-points_endpoint', 'eww_customer_reedem_points_endpoint_content');
}

function eww_add_vendor_reward_point_endpoint_option($settings_tab_options) {
  $settings_tab_options['sections']['wcmp_vendor_general_settings_endpoint_ssection']['fields']['wcmp_reward_point_vendor_endpoint'] = array(
	'title' => __('Vendor Reward Points', 'dc-woocommerce-multi-vendor'), 
	'type' => 'text', 'id' => 'wcmp_reward_point_vendor_endpoint', 
	'label_for' => 'wcmp_reward_point_vendor_endpoint', 
	'name' => 'wcmp_reward_point_vendor_endpoint', 
	'hints' => __('Set endpoint for reward point page', 'dc-woocommerce-multi-vendor'), 
	'placeholder' => 'vendor-all-reward-point');
  return $settings_tab_options;
}

function eww_add_vendor_offer_endpoint_option($settings_tab_options) {
  $settings_tab_options['sections']['wcmp_vendor_general_settings_endpoint_ssection']['fields']['wcmp_add_vendor_offer_endpoint'] = array(
	'title' => __('Vendor Add Offer Product', 'dc-woocommerce-multi-vendor'), 
	'type' => 'text', 'id' => 'wcmp_add_vendor_offer_endpoint', 
	'label_for' => 'wcmp_add_vendor_offer_endpoint', 
	'name' => 'wcmp_add_vendor_offer_endpoint', 
	'hints' => __('Set endpoint for vendor add offer for product', 'dc-woocommerce-multi-vendor'), 
	'placeholder' => 'vendor-add-offer');
  return $settings_tab_options;
}
function eww_all_vendor_offer_endpoint_option($settings_tab_options) {
  $settings_tab_options['sections']['wcmp_vendor_general_settings_endpoint_ssection']['fields']['wcmp_all_vendor_offer_endpoint'] = array(
	'title' => __('Vendor All Offer Product', 'dc-woocommerce-multi-vendor'), 
	'type' => 'text', 'id' => 'wcmp_all_vendor_offer_endpoint', 
	'label_for' => 'wcmp_all_vendor_offer_endpoint', 
	'name' => 'wcmp_all_vendor_offer_endpoint', 
	'hints' => __('Set endpoint for vendor all offer', 'dc-woocommerce-multi-vendor'), 
	'placeholder' => 'vendor-all-offer');
  return $settings_tab_options;
}
function eww_edit_vendor_offer_endpoint_option($settings_tab_options) {
  $settings_tab_options['sections']['wcmp_vendor_general_settings_endpoint_ssection']['fields']['wcmp_edit_vendor_offer_endpoint'] = array(
	'title' => __('Vendor Edit Offer Product', 'dc-woocommerce-multi-vendor'), 
	'type' => 'text', 'id' => 'wcmp_edit_vendor_offer_endpoint', 
	'label_for' => 'wcmp_edit_vendor_offer_endpoint', 
	'name' => 'wcmp_edit_vendor_offer_endpoint', 
	'hints' => __('Set endpoint for vendor edit offer', 'dc-woocommerce-multi-vendor'), 
	'placeholder' => 'vendor-edit-offer');
  return $settings_tab_options;
}
function eww_customer_reedem_points_endpoint_option($settings_tab_options) {
  $settings_tab_options['sections']['wcmp_vendor_general_settings_endpoint_ssection']['fields']['wcmp_customer_redeem_points_endpoint'] = array(
	'title' => __('Customer Reedem Point', 'dc-woocommerce-multi-vendor'), 
	'type' => 'text', 'id' => 'wcmp_customer_redeem_points_endpoint', 
	'label_for' => 'wcmp_customer_redeem_points_endpoint', 
	'name' => 'wcmp_customer_redeem_points_endpoint', 
	'hints' => __('Set endpoint for ustomer reedem point', 'dc-woocommerce-multi-vendor'), 
	'placeholder' => 'customer-redeem-points');
  return $settings_tab_options;
}


function eww_save_custom_endpoint_option($new_input, $input) {
  if (isset($input['wcmp_reward_point_vendor_endpoint']) && !empty($input['wcmp_reward_point_vendor_endpoint'])) {
	$new_input['wcmp_reward_point_vendor_endpoint'] = sanitize_text_field($input['wcmp_reward_point_vendor_endpoint']);
  }
  if (isset($input['wcmp_add_vendor_offer_endpoint']) && !empty($input['wcmp_add_vendor_offer_endpoint'])) {
	$new_input['wcmp_add_vendor_offer_endpoint'] = sanitize_text_field($input['wcmp_add_vendor_offer_endpoint']);
  }
  if (isset($input['wcmp_all_vendor_offer_endpoint']) && !empty($input['wcmp_all_vendor_offer_endpoint'])) {
	$new_input['wcmp_all_vendor_offer_endpoint'] = sanitize_text_field($input['wcmp_all_vendor_offer_endpoint']);
  }
  if (isset($input['wcmp_edit_vendor_offer_endpoint']) && !empty($input['wcmp_edit_vendor_offer_endpoint'])) {
	$new_input['wcmp_edit_vendor_offer_endpoint'] = sanitize_text_field($input['wcmp_edit_vendor_offer_endpoint']);
  }
  if (isset($input['wcmp_customer_redeem_points_endpoint']) && !empty($input['wcmp_customer_redeem_points_endpoint'])) {
	$new_input['wcmp_customer_redeem_points_endpoint'] = sanitize_text_field($input['wcmp_customer_redeem_points_endpoint']);
  }
  return $new_input;
}
function eww_add_wcmp_endpoints_query_vars($endpoints) {
  $endpoints['vendor-all-reward-point'] = array(
	'label' => __('Vendor Reward Points', 'dc-woocommerce-multi-vendor'),
	'endpoint' => get_wcmp_vendor_settings('wcmp_reward_point_vendor_endpoint', 'vendor', 'general', 'vendor-all-reward-point')
  );
	$endpoints['vendor-add-offer'] = array(
	'label' => __('Vendor Add offers', 'dc-woocommerce-multi-vendor'),
	'endpoint' => get_wcmp_vendor_settings('wcmp_add_vendor_offer_endpoint', 'vendor', 'general', 'vendor-add-offer')
  );
	$endpoints['vendor-all-offer'] = array(
	'label' => __('Vendor Offer', 'dc-woocommerce-multi-vendor'),
	'endpoint' => get_wcmp_vendor_settings('wcmp_all_vendor_offer_endpoint', 'vendor', 'general', 'vendor-all-offer')
  );
	$endpoints['vendor-edit-offer'] = array(
	'label' => __('Vendor Edit Offer', 'dc-woocommerce-multi-vendor'),
	'endpoint' => get_wcmp_vendor_settings('wcmp_edit_vendor_offer_endpoint', 'vendor', 'general', 'vendor-edit-offer')
  );
	$endpoints['customer-redeem-points'] = array(
	'label' => __('Customer Redeem Productoints', 'dc-woocommerce-multi-vendor'),
	'endpoint' => get_wcmp_vendor_settings('wcmp_customer_redeem_points_endpoint', 'vendor', 'general', 'customer-redeem-points')
  );
  return $endpoints;
}
function eww_add_tab_to_vendor_dashboard($nav) {
  $nav['vendor_all_reward_point'] = array(
	   'label' => __('Reward Points', 'dc-woocommerce-multi-vendor') // label of the menu
	   , 'url' => '#' // url of the menu
	   , 'capability' => true
	   , 'position' => 56 //menu position
	   , 'submenu' => array('Rewards' => array(
						'label' => __('All Rewards', 'dc-woocommerce-multi-vendor')
						, 'url' => wcmp_get_vendor_dashboard_endpoint_url('vendor-all-reward-point')
						, 'capability' => true
						, 'position' => 10
						, 'link_target' => '_self'
						, 'nav_icon' => 'wcmp-font'
					),
					  'all-offer' => array(
						'label' => __('All Offers', 'dc-woocommerce-multi-vendor')
						, 'url' => wcmp_get_vendor_dashboard_endpoint_url('vendor-all-offer')
						, 'capability' => true
						, 'position' => 12
						, 'link_target' => '_self'
						, 'nav_icon' => 'wcmp-font'
					),
					'add-offer' => array(
						'label' => __('Add Offers', 'dc-woocommerce-multi-vendor')
						, 'url' => wcmp_get_vendor_dashboard_endpoint_url('vendor-add-offer')
						, 'capability' => true
						, 'position' => 13
						, 'link_target' => '_self'
						, 'nav_icon' => 'wcmp-font '
					) )  
	   , 
		'nav_icon' => 'wcmp-font ico-price2-icon' // menu icon wordpress dashicons resource (https://developer.wordpress.org/resource/dashicons/)
   );
   return $nav;
}
function eww_custom_menu_endpoint_content(){
  include('templates/vendor_reward_points.php');
} 
function eww_vendor_add_offer_endpoint_content(){
  include('templates/vendor_add_offer_product.php');
} 
function eww_vendor_all_offer_endpoint_content(){
  include('templates/vendor_offer_product.php');
}
function eww_vendor_edit_offer_endpoint_content(){
  include('templates/vendor_edit_offer.php');
}
function eww_customer_reedem_points_endpoint_content(){
  include('templates/customer_redeem_points.php');
}
/*** add a dashboard menu and endpoints (END)**/

/** add a reward point when order compreted **/
function eww_reward_order_completed($order_id){
global $woocommerce;
global $wpdb;
global $product;
  //$user_id = get_current_user_id();
  $table_name = $wpdb->prefix . "reward_points";
  $current_order = wc_get_order($order_id);
  
  $order = new WC_Order($order_id );
  $order_email = $order->billing_email;
	
  // check if there are any users with the billing email as user or email
  $email = email_exists( $order_email );  
  $user = username_exists( $order_email );
  
  // if the UID is null, then it's a guest checkout
  if( $user == false && $email == false )
  {
	// random password with 12 chars
	$random_password = wp_generate_password();
	
	// create new user with email as username & newly created pw
	$user_id = wp_create_user( $order_email, $random_password, $order_email );
	
	//WC guest customer identification
	update_user_meta( $user_id, 'guest', 'yes' );
 
	//user's billing data
	update_user_meta( $user_id, 'billing_address_1', $order->billing_address_1 );
	update_user_meta( $user_id, 'billing_address_2', $order->billing_address_2 );
	update_user_meta( $user_id, 'billing_city', $order->billing_city );
	update_user_meta( $user_id, 'billing_company', $order->billing_company );
	update_user_meta( $user_id, 'billing_country', $order->billing_country );
	update_user_meta( $user_id, 'billing_email', $order->billing_email );
	update_user_meta( $user_id, 'billing_first_name', $order->billing_first_name );
	update_user_meta( $user_id, 'billing_last_name', $order->billing_last_name );
	update_user_meta( $user_id, 'billing_phone', $order->billing_phone );
	update_user_meta( $user_id, 'billing_postcode', $order->billing_postcode );
	update_user_meta( $user_id, 'billing_state', $order->billing_state );
 
	// user's shipping data
	update_user_meta( $user_id, 'shipping_address_1', $order->shipping_address_1 );
	update_user_meta( $user_id, 'shipping_address_2', $order->shipping_address_2 );
	update_user_meta( $user_id, 'shipping_city', $order->shipping_city );
	update_user_meta( $user_id, 'shipping_company', $order->shipping_company );
	update_user_meta( $user_id, 'shipping_country', $order->shipping_country );
	update_user_meta( $user_id, 'shipping_first_name', $order->shipping_first_name );
	update_user_meta( $user_id, 'shipping_last_name', $order->shipping_last_name );
	update_user_meta( $user_id, 'shipping_method', $order->shipping_method );
	update_user_meta( $user_id, 'shipping_postcode', $order->shipping_postcode );
	update_user_meta( $user_id, 'shipping_state', $order->shipping_state );
	
	// link past orders to this newly created customer
	wc_update_new_customer_past_orders( $user_id );
  }
  $customer_id = get_post_meta($order_id, '_customer_user', true);

  $reward_percentage = get_option('reward_percentage');
  

   foreach ($current_order->get_items() as $item_id => $item_obj) 
   {
	  $item_data = $item_obj->get_data();
	  $item_total = $item_data['total'];
	  $reward_points = ($item_total * $reward_percentage) / 100;
	 
	  $item_data = $item_obj->get_data();

	  $date = date('Y-m-d H:i:s');
	  $my_part_ID = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE OrderId = '%s' AND ItemId = '%s'",array($item_data['order_id'],$item_data['id'])));
	  if ( $my_part_ID > 0 )
	  {
		return true;
	  }
	  else
	  {
		$wpdb->insert($table_name, array(
								  'OrderId' => $item_data['order_id'],
								  'CustomerId' => $customer_id,
								  'VendorId' => $item_data['meta_data'][2]->value,
								  'ItemId' => $item_data['id'],
								  'RewardPoints' => $reward_points,
								  'Date' => $date
								  ),array(
								  '%s',
								  '%s',
								  '%s',
								  '%s',
								  '%s',
								  '%s') //replaced %d with %s - I guess that your description field will hold strings not decimals
		  );
	  }
  }
  foreach ($current_order->get_items() as $item_id => $item_obj) 
   {
	  $item_data = $item_obj->get_data();
	  $table_name = $wpdb->prefix . "redeem_points";
	  $CurrentDate = date("Y-m-d");
	  $wpdb->insert($table_name, array(
								  'OrderId' => $item_data['order_id'],
								  'CustomerId' => $customer_id,
								  'VendorId' => $item_data['meta_data'][2]->value,
								  'ItemId' => $item_data['id'],
								  'RedeemPoints' => $item_data['meta_data'][0]->value,
								  'Date' => $CurrentDate
								  ),array(
								  '%s',
								  '%s',
								  '%s',
								  '%s',
								  '%s') 
		  );
	}
}
add_action( 'woocommerce_thankyou', 'eww_reward_order_completed', 10, 1);
add_action( 'woocommerce_order_status_completed', 'eww_reward_order_completed', 20, 1);
/** add a reward point when order compreted (END) **/

/** reward delete on cancel ed order **/
add_action( 'woocommerce_order_status_cancelled', 'eww_the_dramatist_woocommerce_auto_delete_order' );
function eww_the_dramatist_woocommerce_auto_delete_order($order_id)
{
	global $woocommerce;
	global $wpdb;
	$table_name = $wpdb->prefix . "reward_points";
	$table_name_redeem = $wpdb->prefix . "redeem_points";
	$wpdb->delete( $table_name, array( 'OrderId' => $order_id ) );
	$wpdb->delete( $table_name_redeem, array( 'OrderId' => $order_id ) );
}
/** reward delete on cancel ed order (End) **/

/** Delete offer from all offer **/
add_action('wp_ajax_your_delete_action', 'eww_delete_row');
add_action( 'wp_ajax_nopriv_your_delete_action', 'eww_delete_row');

function eww_delete_row() {
	global $wpdb;
	$id = htmlspecialchars($_POST['element_id']);
	$table_name = $wpdb->prefix . "reward_offers";
	$wpdb->delete( $table_name, array( 'Id' => $id ) );

}
/** Delete offer from all offer (END) **/

/** Reedem point **/
add_action('wp_ajax_your_redeem_action', 'eww_redeem_points');
add_action( 'wp_ajax_nopriv_your_redeem_action', 'eww_redeem_points');

function eww_redeem_points() {
	global $wpdb;
	$redeem_name = htmlspecialchars($_POST['offer_name']);
	$table_name = $wpdb->prefix . "reward_offers";
	$offer_data = $wpdb->get_results($wpdb->prepare("SELECT ProductId,OfferPoints FROM $table_name WHERE Id = '%s'",$redeem_name));
	$product_id = $offer_data[0]->ProductId;
	$product_title = get_the_title($product_id);
	$offer_data[0]->product_title = $product_title;
	echo json_encode($offer_data);
	wp_die();
}
/** Reedem point (END)**/


//add_action( 'woocommerce_after_shop_loop_item', 'wdm_add_custom_fields', 11 );
add_action('woocommerce_after_add_to_cart_button','eww_reward_points_add_custom_fields', 10);
/**
 * Adds custom field for Product
 * @return [type] [description]
 */
function eww_reward_points_add_custom_fields()
{

  global $product;
  global $post;global $wpdb, $woocommerce, $WCMP; 
  $vendor = get_wcmp_product_vendors($post->ID);
 
  $vendor_id = $vendor->id;
  $cust_id= get_current_user_id(); 
 
  $table_name = $wpdb->prefix . "reward_points";
  $redeem_table = $wpdb->prefix . "redeem_points";
  $vendor_detail = get_wcmp_vendor($vendor_id);
  $current_vendorid = $vendor_detail->id;
  
	//echo $current_vendorid;
  $customer_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RewardPoints) as points FROM $table_name WHERE CustomerId = '%s' AND VendorId = '%s'",array($cust_id,$current_vendorid)));
  
  $redeem_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RedeemPoints) as points FROM $redeem_table WHERE CustomerId = '%s' AND VendorId = '%s'",array($cust_id,$current_vendorid)));
  $cust_reward_points = $customer_points[0]->points;
  
  $cust_redeem_points = $redeem_points[0]->points;
  $remain_points = ($cust_reward_points - $cust_redeem_points);
?><?php
  $table_reward_offers = $wpdb->prefix . "reward_offers";

  $all_offers =  $wpdb->get_results("SELECT * FROM $table_reward_offers WHERE VendorId = $current_vendorid");

  if(!empty($remain_points) && is_user_logged_in()){
	$i = 0;
	global $product;
	$current_product_id = $product->id;
	
	foreach ($all_offers as $all_offer) 
	{ 
	  $prod_id = $all_offer->ProductId;
	  $offer_point = $all_offer->OfferPoints;
	  $offer_start_date= $all_offer->OfferStartDate;
	  $offer_end_date = $all_offer->OfferEndData;
	  $offer_type = $all_offer->OfferType;
	  $product = wc_get_product( $prod_id );
	  
	  //$prod_title =  $product->get_title();
	  $i++;
	}?><?php 
	$offers_list = $wpdb->get_results("SELECT * FROM $table_reward_offers WHERE OfferPoints <= $remain_points AND VendorId = $current_vendorid AND (OfferEndData >= CURDATE() AND OfferStartDate <= CURDATE() OR OfferType = 'TRUE') AND ProductId = $current_product_id ");
   
		if(!empty($offers_list)) { 
		  foreach ($offers_list as $offer_list) {
			  $product_id = $offer_list->ProductId;
			  $offer_title = $offer_list->OfferTitle;
			  $offer_points = $offer_list->OfferPoints; ?>
			  <div class="product-reward-point">
			  <div class="remain-point"> Product Offer Point: <?php echo $offer_points;?></div>
		<?php
		  } 
		 
		}
		else {
			echo "No offer for your points";
		}

		if(isset($cust_reward_points))
		{ ?>
				<div class="remain-point"> Your Available Point: <?php echo $remain_points; ?></div>
				<p class="add-note">For use your point add product to cart</p>
			</div>
		<?php
		}
	 
  }
  else {
	echo "No offer for this product";
  }
}

add_filter('woocommerce_add_cart_item_data','eww_reward_points_add_item_data',10,3);


function eww_reward_points_add_item_data($cart_item_data, $product_id, $variation_id)
{ 

  global $product;
  global $post;global $wpdb;
  $vendor = get_wcmp_product_vendors($product_id);
  $vendor_id = $vendor->id;
  $cust_id= get_current_user_id(); 
  $table_name = $wpdb->prefix . "reward_points";
  $redeem_table = $wpdb->prefix . "redeem_points";
  $vendor_detail = get_wcmp_vendor($vendor_id);
  $current_vendorid = $vendor_detail->id;
	//echo $current_vendorid;
  $customer_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RewardPoints) as points FROM $table_name WHERE CustomerId = '%s' AND VendorId = '%s'",array($cust_id,$current_vendorid)));

  $redeem_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RedeemPoints) as points FROM $redeem_table WHERE CustomerId = '%s' AND VendorId = '%s'",array($cust_id,$current_vendorid)));
  $cust_reward_points = $customer_points[0]->points;
  $cust_redeem_points = $redeem_points[0]->points;
  $remain_points = ($cust_reward_points - $cust_redeem_points);
  ?><?php
  $table_reward_offers = $wpdb->prefix . "reward_offers";

  $all_offers =  $wpdb->get_results("SELECT * FROM $table_reward_offers WHERE VendorId = $current_vendorid");

  if(!empty($remain_points) && is_user_logged_in()){
	$i = 0;
	global $product;
	$current_product_id = $product_id;
	
	foreach ($all_offers as $all_offer) 
	{ 
	  $prod_id = $all_offer->ProductId;
	  $offer_point = $all_offer->OfferPoints;
	  $offer_start_date= $all_offer->OfferStartDate;
	  $offer_end_date = $all_offer->OfferEndData;
	  $offer_type = $all_offer->OfferType;
	  $product = wc_get_product( $prod_id );
	  
	  $i++;
	}?><?php 
	$offers_list = $wpdb->get_results("SELECT * FROM $table_reward_offers WHERE OfferPoints <= $remain_points AND VendorId = $current_vendorid AND (OfferEndData >= CURDATE() AND OfferStartDate <= CURDATE() OR OfferType = 'TRUE') AND ProductId = $current_product_id ");
   
		if(!empty($offers_list)) { 
			
		  foreach ($offers_list as $offer_list) {
		  $product_id = $offer_list->ProductId;
		  $offer_title = $offer_list->OfferTitle;
		  $offer_points = $offer_list->OfferPoints; 
		 
		  if(!empty($offer_points))
		  {
		  $cart_item_data['wdm_reward'] = $offer_points;
		 
		  }
		  
		  return $cart_item_data;  
	
		  }

		}
   
  }
 
}
session_start();
add_filter('woocommerce_cart_item_subtotal','eww_reward_points_additional_shipping_cost',10,3);
function eww_reward_points_additional_shipping_cost($subtotal, $values, $cart_item_key) {
	
	$custom_shipping_cost = $values['wdm_reward'];
	$product_id = $values['product_id'];
	$gen_settings=get_option('reward_point_custom_btn_styling');
	
	$add_btn_title    = (isset($gen_settings['add_btn_title']))?( $gen_settings['add_btn_title'] ):'ADD POINTS';
	$remove_btn_title    = (isset($gen_settings['remove_btn_title']))?( $gen_settings['remove_btn_title'] ):'REMOVE POINTS';

		if ($custom_shipping_cost)
		{
			//echo "test";
			$output .= $subtotal;
			$output .=  '<div id="reward_point"><p class="offer-point-cart">Offer Points:</p><input type="text" data-product="'.$product_id.'"  value="'.$custom_shipping_cost.'" class="reward_point_click" readonly>';

					//if (isset($_SESSION['reward_add_value'])) {
						if(isset($_SESSION['reward_add_value'][$product_id]) && $_SESSION['reward_add_value'][$product_id] >= 1){
							$output .=  '<input type="button" class="remove-point reward-button button" id="remove-point-'.$product_id.'" value="'.$remove_btn_title.'" name="remove_points">';
						}else{
							$output .=  '<input type="button" class="add-point reward-button button"  value="'.$add_btn_title.'" id="add-point-'.$product_id.'" name="apply_points" ></div>';
						}
					//}

			  return $output;
		}
		else { 
			return $subtotal;   
		}
}

add_action('wp_ajax_add_item_from_cart', 'eww_reward_points_add_item_from_cart');
add_action('wp_ajax_nopriv_add_item_from_cart', 'eww_reward_points_add_item_from_cart');

function eww_reward_points_add_item_from_cart(){
		 
		$reward_add_value = htmlspecialchars($_POST['element_id']);
		$product_id = htmlspecialchars($_POST['product_id']);
		//echo $reward_value;
		
		$_SESSION['reward_add_value'][$product_id] = $reward_add_value;
		//die();
  
}
add_action('wp_ajax_remove_item_from_cart', 'eww_reward_points_remove_item_from_cart');
add_action('wp_ajax_nopriv_remove_item_from_cart', 'eww_reward_points_remove_item_from_cart');

function eww_reward_points_remove_item_from_cart(){

		
		$reward_remove_value = htmlspecialchars($_POST['element_id']);
		$product_id = htmlspecialchars($_POST['product_id']);
		
		unset($_SESSION['reward_add_value'][$product_id]);

		//die();
		//unset($_SESSION['reward_value']);
  
}
function eww_reward_points_add_cart_fee() {

		global $woocommerce;
	  
		if (isset($_SESSION['reward_add_value']) && !empty($_SESSION['reward_add_value']) && count($_SESSION['reward_add_value']) >= 1) {
			$rewards = 0;

			foreach ($_SESSION['reward_add_value'] as $product => $value) {
				$rewards -= $value;
				//echo $rewards;
			}
			WC()->cart->add_fee('Reward Point',$rewards);
		}

   
}
add_action( 'woocommerce_cart_calculate_fees', 'eww_reward_points_add_cart_fee', 10, 1);