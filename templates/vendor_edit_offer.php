<?php
/**
 * The template for displaying vendor reward points
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/shortcode/vendor_reward_points.php
 *
 * @author 		dualcube
 * @package 	WCMp/Templates
 * @version   2.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
global $WCMp;
$wcmp_policy_settings = get_option("wcmp_general_policies_settings_name");
$wcmp_capabilities_settings_name = get_option("wcmp_capabilities_settings_name");
$customer_support_details_settings = get_option('wcmp_general_customer_support_details_settings_name');
$current_customer_id = $_REQUEST['offer_id'];
//$customer_detail = new WC_Customer( $current_customer_id );
global $wpdb;
$table_name = $wpdb->prefix . "reward_points";
$vendor_detail = get_wcmp_vendor(get_current_user_id());
$current_vendorid = $vendor_detail->id;
$current_vendor_term_id = $vendor_detail->term_id;
$vendor_product_args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'order' => 'desc',
				'orderby' => 'date',
				'tax_query' => array(
					array(
							'taxonomy' => 'dc_vendor_shop',
							'field' => 'id',
							'terms' => $current_vendor_term_id,
							'operator'=> 'IN'
					),
				),
			);
$vendor_product_list = new WP_Query( $vendor_product_args );
$table_name = $wpdb->prefix . "reward_offers";
$offer_data =  $wpdb->get_results("SELECT * FROM $table_name where Id=$current_customer_id");
?>
<div class="wcmp_main_holder toside_fix">
	<div class="wcmp_headding1">
		<div class="col-md-12 title_offer">
			<h3><?php _e( 'Edit Offer', $WCMp->text_domain );?></h3>
		</div>
		<div class="clear"></div>
	</div>
	<div class="col-md-12 all-products-wrapper" >
		<div class="panel panel-default panel-pading">
			<form method="post" name="shop_settings_form" class="wcmp_policy_form" >
			    <div class="wcmp_form1">
			    	<div class="form-group">
			    		<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Name', $WCMp->text_domain );?></label>
			    		<div class=" col-md-6 col-sm-9">
			    			<input class="no_input form-control regular-text pro_ele simple variable external grouped" type="text" name="offer_name" placeholder="<?php _e( 'Offer Name. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->OfferTitle; ?>" />
			    		</div>
					    
			    	</div>
			    		<input class="no_input" type="hidden" name="VendorId" placeholder="<?php _e( 'Vendor Id. ', $WCMp->text_domain );?>" value="<?php echo $current_vendorid; ?>" />
			    		<input class="no_input" type="hidden" name="offer_id" placeholder="<?php _e( 'Offer id. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->Id; ?>" />
			    		<input class="no_input" type="hidden" name="offer_vendor" placeholder="<?php _e( 'Offer Vendor. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->VendorId; ?>" />	
			    	<div class="form-group">
			    		<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Products', $WCMp->text_domain );?></label>
			    		
			    		<div class="select_box offer_product_select  col-md-6 col-sm-9">
							<?php $product = wc_get_product( $offer_data[0]->ProductId ); ?>
			    			
								<select name="offer_product" class="form-control regular-select pro_ele simple variable external grouped">
									<option value="<?php echo $offer_data[0]->ProductId; ?>" selected><?php echo $product->get_title(); ?></option>
									<?php while($vendor_product_list->have_posts()) : $vendor_product_list->the_post(); ?>
									<option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
									<?php endwhile; wp_reset_query(); ?>
								</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Points', $WCMp->text_domain );?></label>	
						<div class=" col-md-6 col-sm-9">
							<input class="no_input form-control regular-text pro_ele simple variable external grouped" type="number" min="1" name="OfferPoints" placeholder="<?php _e( 'Offer Points. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->OfferPoints; ?>" required />
						</div>
					</div>		
			   		<div class="form-group">		
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Full Time Offer', $WCMp->text_domain );?></label>
						<div class=" col-md-6 col-sm-9">
							<input id="FullOffer-Edit" class="no_input form-control regular-text pro_ele simple variable external grouped" type="checkbox" name="FullOffer" placeholder="<?php _e( 'Full Time Offer. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->OfferType; ?>" <?php if($offer_data[0]->OfferType == 'TRUE'){ echo "checked"; } ?>/>
						</div>
					</div>
					<div class="form-group">
						<label class="offer_dates control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Start Date', $WCMp->text_domain );?></label>		
						<div class=" col-md-6 col-sm-9">
							<input class="pickdate wcmp_stat_start_dt form-control regular-text pro_ele simple variable external grouped no_input" class="no_input" type="text" name="OfferStartDate" placeholder="<?php _e( 'Offer Start Date. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->OfferStartDate; ?>" required />
						</div>
					</div>	
					<div class="form-group">
						<label class="offer_dates control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer End Date', $WCMp->text_domain );?></label>
						<div class=" col-md-6 col-sm-9">
							<input class="pickdate wcmp_stat_end_dt form-control regular-text pro_ele simple variable external grouped" class="no_input" type="text" name="OfferEndDate" placeholder="<?php _e( 'Offer End Date. ', $WCMp->text_domain );?>" value="<?php echo $offer_data[0]->OfferEndData; ?>" required />
						</div>
					</div>	
						
				</div>
					<?php do_action('other_exta_field_dcmv'); ?>
					<div id="product_manager_submit" class="wcmp-action-container">
        				<input class="btn btn-default add_offer" name="edit_offer" value="Edit Offer" id="" type="submit" >
            		</div>
			
			  </form>
		</div>
	</div>			  
</div>
<?php
global $woocommerce;
global $WCMp;global $wpdb;
if ( isset( $_POST["edit_offer"] ))
{
	global $wpdb;
	$table_name = $wpdb->prefix . "reward_offers";
	$offer_type = $_POST['FullOffer'];
	/*if(isset($_POST['FullOffer']))
		{
			$full_offer = "TRUE";
			$startdob = new DateTime($_POST['OfferStartDate']);
        	$start_dob_format = "";
        	$enddob = new DateTime($_POST['OfferEndDate']);
        	$end_dob_format = "";
		}
		else
		{
			$full_offer = "FALSE";
			$startdob = new DateTime($_POST['OfferStartDate']);
        	$start_dob_format = $startdob->format('Y-m-d');
        	$enddob = new DateTime($_POST['OfferEndDate']);
        	$end_dob_format = $enddob->format('Y-m-d');
		}*/
	if($offer_type == 'TRUE')
	{
		$offer_type = 'TRUE';
		$offerstartdob = new DateTime($_POST['OfferStartDate']);
    	$offer_start_dob_format = '0000-00-00';
    	$offerenddob = new DateTime($_POST['OfferEndDate']);
    	$offer_end_dob_format = '0000-00-00';
	}
	else
	{
		$offer_type = 'FALSE';
		$offerstartdob = new DateTime($_POST['OfferStartDate']);
    	$offer_start_dob_format = $offerstartdob->format('Y-m-d');
    	$offerenddob = new DateTime($_POST['OfferEndDate']);
    	$offer_end_dob_format = $offerenddob->format('Y-m-d');
	}
	$offer_id = $_POST['offer_id'];
	$offer_vendor = $_POST['offer_vendor'];
	$offer_name = $_POST['offer_name'];
	$offer_product = $_POST['offer_product'];
	$offer_points = $_POST['OfferPoints'];
    $update_data = array('OfferTitle' => $offer_name,'ProductId' => $offer_product,'VendorId' => $offer_vendor,'OfferPoints' => $offer_points,'OfferType' => $offer_type,'OfferStartDate' => $offer_start_dob_format,'OfferEndData' => $offer_end_dob_format);
    $update_query = $wpdb->update(
    			$table_name,    
                $update_data,
                array('Id'=>$offer_id),
                array(
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s'));

echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.get_permalink().'/vendor-all-offer">';
}	