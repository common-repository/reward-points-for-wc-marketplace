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
$current_customer_id = $_REQUEST['customer_id'];
$customer_detail = new WC_Customer( $current_customer_id );
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
?>
<div class="wcmp_main_holder toside_fix">
	<div class="wcmp_headding1">
		<div class="col-md-12 title_offer">
		<h3><?php _e( 'Add Offer', $WCMp->text_domain );?></h3>
		</div>
		<div class="clear"></div>
	</div>
	
		<div class="col-md-12 all-products-wrapper" >
			<div class="panel panel-default panel-pading">
			<form method="post" name="shop_settings_form" class="wcmp_policy_form" >
			    <div class="wcmp_form1">
			    	<div class="form-group">
			    		<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Title', $WCMp->text_domain );?></label>
			    		<div class=" col-md-6 col-sm-9">
			    			<input class="no_input form-control regular-text pro_ele simple variable external grouped" type="text" name="OfferTitle" placeholder="<?php _e( 'Offer Title', $WCMp->text_domain );?>" value="" required />
			    		</div>
					    	<input class="no_input" type="hidden" name="VendorId" placeholder="<?php _e( 'Vendor Id. ', $WCMp->text_domain );?>" value="<?php echo $current_vendorid; ?>" />
			    	</div>	
			    	<div class="form-group">
			    		<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Products', $WCMp->text_domain );?></label>
			    	
			    		<div class="select_box offer_product_select  col-md-6 col-sm-9">
							<select name="offer_product" required class="form-control regular-select pro_ele simple variable external grouped">
								<option value="">---Select Product----</option>
							<?php while($vendor_product_list->have_posts()) : $vendor_product_list->the_post(); ?>
								<option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
							<?php endwhile; wp_reset_query(); ?>	
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Points', $WCMp->text_domain );?></label>	
						<div class=" col-md-6 col-sm-9">
							<input class="no_input form-control regular-text pro_ele simple variable external grouped" type="number" min="1" name="OfferPoints" placeholder="<?php _e( 'Offer Points', $WCMp->text_domain );?>" value="" required />
						</div>
					</div>
					<div class="form-group">		
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Full Time Offer', $WCMp->text_domain );?></label>
						<div class=" col-md-6 col-sm-9">
						<input id="FullOffer" class="no_input form-control regular-text pro_ele simple variable external grouped" type="checkbox" name="FullOffer" placeholder="<?php _e( 'Full Time Offer. ', $WCMp->text_domain );?>" value="FALSE" />
						</div>
					</div>	
					<div class="form-group">
						<label class="offer_dates control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Start Date', $WCMp->text_domain );?></label>		
						<div class=" col-md-6 col-sm-9">
							<input class="pickdate wcmp_stat_start_dt form-control regular-text pro_ele simple variable external grouped no_input"  type="text" name="OfferStartDate" placeholder="<?php _e( 'Offer Start Date', $WCMp->text_domain );?>" value="" required />
						</div>
					</div>	

					<div class="form-group">
						<label class="offer_dates control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer End Date', $WCMp->text_domain );?></label>
						<div class=" col-md-6 col-sm-9">
						 	<input class="pickdate wcmp_stat_end_dt no_input form-control regular-text pro_ele simple variable external grouped" type="text" name="OfferEndDate" placeholder="<?php _e( 'Offer End Date', $WCMp->text_domain );?>" value="" required />
						 </div>
					</div>
				</div>
				<?php do_action('other_exta_field_dcmv'); ?>
				<div id="product_manager_submit" class="wcmp-action-container">
        			
                    <input class="btn btn-default add_offer" name="submit_offer" value="Add Offer" id="" type="submit" >
            	</div>
				
		  </form>
		 </div>
	</div>
</div>
<?php if (isset( $_POST["submit_offer"] ))
	{
		if(isset($_POST['FullOffer']))
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
		}
		$current_vendorid = $_POST['VendorId'];
		$table_offer = $wpdb->prefix . "reward_offers";
		$all_offers =  $wpdb->get_results("SELECT * FROM $table_offer WHERE VendorId = $current_vendorid");
			foreach ($all_offers as $all_offer) {
				$product_id = $all_offer->ProductId;
				$vender_id = $all_offer->VendorId;
			}
			if($_POST['offer_product'] != $product_id && $vender_id != $_POST['VendorId']){
				global $wpdb;
				$table_name = $wpdb->prefix . "reward_offers";
				$wpdb->insert($table_name, array(
	                                'OfferTitle' => $_POST['OfferTitle'],
	                                'ProductId' => $_POST['offer_product'],
	                                'VendorId' => $_POST['VendorId'],
	                                'OfferPoints' => $_POST['OfferPoints'],
	                                'OfferType' => $full_offer,
	                                'OfferStartDate' => $start_dob_format,
	                                'OfferEndData' => $end_dob_format
	                                ),array(
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s') //replaced %d with %s - I guess that your description field will hold strings not decimals
	        					);
		
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.get_permalink().'/vendor-all-offer">';
			}
			else{
				echo '<p class="offer_error col-sm-12">Offer Point for this prodct is already added.</p>';
			}
			// echo '<script>window.location.href = "../vendor-all-offer/"</script>'; 
}