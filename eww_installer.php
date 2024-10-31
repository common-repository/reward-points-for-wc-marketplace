<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
global $wpdb;
$table_name = $wpdb->prefix . "reward_points";
$table_redeem = $wpdb->prefix . "redeem_points";
$table_offer = $wpdb->prefix . "reward_offers";
//$my_products_db_version = '1.0.0';
$charset_collate = $wpdb->get_charset_collate();

if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

    $sql = "CREATE TABLE $table_name (
            Id mediumint(9) NOT NULL AUTO_INCREMENT,
            `OrderId` varchar(50) NOT NULL,
            `CustomerId` varchar(50) NOT NULL,
            `VendorId` varchar(50) NOT NULL,
            `ItemId` varchar(50) NOT NULL,
            `RewardPoints` varchar(50) NOT NULL,
            `Date` timestamp NOT NULL,
            PRIMARY KEY  (Id)
    )    $charset_collate;

        CREATE TABLE $table_redeem  (
            Id mediumint(9) NOT NULL AUTO_INCREMENT,
            `OrderId` varchar(50) NOT NULL,
            `CustomerId` varchar(50) NOT NULL,
            `VendorId` varchar(50) NOT NULL,
            `ItemId` varchar(50) NOT NULL,
            `RedeemPoints` varchar(50) NOT NULL,
            `Date` date NOT NULL,
            PRIMARY KEY  (Id)
    )    $charset_collate;
        CREATE TABLE $table_offer  (
            Id mediumint(9) NOT NULL AUTO_INCREMENT,
            `OfferTitle` varchar(255) NOT NULL,
            `ProductId` varchar(50) NOT NULL,
            `VendorId` varchar(50) NOT NULL,
            `OfferPoints` varchar(50) NOT NULL,
            `OfferType` varchar(50) NOT NULL,
            `OfferStartDate` date NOT NULL,
            `OfferEndData` date NOT NULL,
            PRIMARY KEY  (Id)
    )    $charset_collate;
    ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    //add_option( my_db_version', $my_products_db_version );
}