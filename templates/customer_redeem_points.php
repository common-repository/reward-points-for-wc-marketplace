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
$customer_email = $customer_detail->data['email'];
global $wpdb;
$table_name = $wpdb->prefix . "reward_points";
$offer_table_name = $wpdb->prefix . "reward_offers";
$vendor_detail = get_wcmp_vendor(get_current_user_id());
$vendor_name = $vendor_detail->user_data->data->display_name;
$current_vendorid = $vendor_detail->id;
$current_date = date("Y-m-d");
?>
<div class="wcmp_main_holder toside_fix">
	<div class="wcmp_headding1">
		<ul>
			<li><?php _e( 'Redeem Points ', $WCMp->text_domain );?></li>
		</ul>
		<div class="clear"></div>
	</div>
	<?php $customer_orders = $wpdb->get_results($wpdb->prepare("SELECT SUM(RewardPoints) as points , COUNT(DISTINCT(OrderId)) as cnt_order FROM $table_name WHERE CustomerId = '%s' AND VendorId = '%s'",array($current_customer_id,$current_vendorid)));
    		$val = $customer_orders[0]->points; 
    		$redeem_table = $wpdb->prefix . "redeem_points";	
			$redeem_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RedeemPoints) as points,ItemId as items FROM $redeem_table WHERE CustomerId = '%s' AND VendorId = '%s'",array($current_customer_id,$current_vendorid)));
			$redeem_products = $wpdb->get_results($wpdb->prepare("SELECT ItemId FROM $redeem_table WHERE CustomerId = '%s' AND VendorId = '%s'",array($current_customer_id,$current_vendorid)));
			//$redeem_item = $redeem_products[0]->ItemId;
			foreach ($redeem_products as $redeem_product)
			{
				$redeem_product_ids[] = $redeem_product->ItemId;
			}
			if(!empty($redeem_product_ids))
			{
				$redeem_product_ids = $redeem_product_ids;

				$remain_points = (Float)($val - $redeem_points[0]->points);

    		    $offers_list = $wpdb->get_results("SELECT * FROM $offer_table_name WHERE OfferPoints <= $remain_points AND VendorId = $current_vendorid AND (OfferEndData >= CURDATE() AND OfferStartDate <= CURDATE() OR OfferType = 'TRUE') AND ProductId NOT IN (".implode(',',$redeem_product_ids).")");
			}
			else
			{
				$redeem_product_ids = '';
				$remain_points = (Float)($val - $redeem_points[0]->points);
    		    $offers_list = $wpdb->get_results("SELECT * FROM $offer_table_name WHERE OfferPoints <= $remain_points AND VendorId = $current_vendorid AND (OfferEndData >= CURDATE() AND OfferStartDate <= CURDATE() OR OfferType = 'TRUE')");
			}
			
    if(!empty($offers_list)){ ?>
    <div class="col-md-12 all-products-wrapper" >
		<div class="panel panel-default panel-pading">
			<form method="post" name="shop_settings_form" class="wcmp_policy_form">
		    <div class="wcmp_form1">
		    	
					<div class="form-group">
			    		<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Customer Name', $WCMp->text_domain );?></label>
			    		<div class=" col-md-6 col-sm-9">
			    			<input class="no_input form-control regular-text pro_ele simple variable external grouped" type="text" readonly name="customer_username" placeholder="<?php _e( 'Customer Name. ', $WCMp->text_domain );?>" value="<?php echo $customer_detail->data['display_name']; ?>" />
			    		</div>
					    	<input id="prod_id" class="no_input" type="hidden" readonly name="prod_id" placeholder="<?php _e( 'Product Id', $WCMp->text_domain );?>" value="" />
			    	</div>
			    	<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Offer Name', $WCMp->text_domain );?></label>	
		    			<div class="select_box offer_product_select col-md-6 col-sm-9">
							<select name="offer_name" id="offer_name" class="form-control regular-select pro_ele simple variable external grouped">
								<option value="">---Select Offer----</option>
							<?php foreach($offers_list as $offer_list){ ?>
								<option value="<?php echo $offer_list->Id; ?>"><?php echo $offer_list->OfferTitle; ?></option>
							<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e('Offer Products', $WCMp->text_domain);?></label>	
						<div class=" col-md-6 col-sm-9">
							<input id="offer_product_ajax" class="no_input form-control regular-text pro_ele simple variable external grouped" type="text" name="offer_product" placeholder="<?php _e( 'Offer Products', $WCMp->text_domain );?>" value="" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Total Points', $WCMp->text_domain );?></label>	
						<div class=" col-md-6 col-sm-9">
							<input class="no_input form-control regular-text pro_ele simple variable external grouped" type="text" readonly name="total_points" placeholder="<?php _e( 'Total Points. ', $WCMp->text_domain );?>" value="<?php echo $customer_orders[0]->points;?>" />
						</div>
					</div>	
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 title pro_title pro_ele simple variable external grouped" for="title"><?php _e( 'Redeem Points', $WCMp->text_domain );?></label>	
						<div class=" col-md-6 col-sm-9">
							<input id="offer_points_ajax" class="no_input form-control regular-text pro_ele simple variable external grouped" type="text" name="redeem_points" placeholder="<?php _e( 'Redeem Points', $WCMp->text_domain );?>" value="" />
						</div>
					</div>
			</div>
				<?php do_action('other_exta_field_dcmv'); ?>
				<div id="product_manager_submit" class="wcmp-action-container">
        			<input class="btn btn-default add_offer" name="redeem_offer" value="Redeem Offer" id="" type="submit" >
            	</div>
		  </form>
		</div>
	</div>	  
  <?php }
  else{?>
  <p style="margin: 10px 4% 0;">This Customer is not eligible for any Offer or there is no any offer</p>
  <?php }?>
</div>
<?php if ( isset( $_POST["redeem_offer"] ))
	{
		global $wpdb;
		global $woocommerce;
		$CustomerId = $current_customer_id;
		$VendorId = $current_vendorid;
		$ItemId = $_POST['prod_id']; ;
		$RedeemPoints = $_POST['redeem_points'];
		$CurrentDate = date("Y-m-d");
		$table_name = $wpdb->prefix . "redeem_points";
		$wpdb->insert($table_name, array(
	                                'CustomerId' => $CustomerId,
	                                'VendorId' => $VendorId,
	                                'ItemId' => $ItemId,
	                                'RedeemPoints' => $RedeemPoints,
	                                'Date' => $CurrentDate
	                                ),array(
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s',
	                                '%s') 
	        );
		$mailer = $woocommerce->mailer();
		$reward_offer_table = $wpdb->prefix . "reward_offers";
		$mail_offer_name = $_POST['offer_name'];
		$offer_name = $wpdb->get_results($wpdb->prepare("SELECT OfferTitle FROM $reward_offer_table WHERE Id = '%s'",$mail_offer_name));
		$offer_title = $offer_name[0]->OfferTitle;
		$mail_product_id = wc_get_product( $_POST['prod_id'] );
		$mail_product_title =  $mail_product_id->get_title();
		$mail_redeem_point = $_POST['redeem_points'];
		$Delievery_boy_message_body = __( 'Your Redeem Offer Detail' );
      	$Delievery_boy_message_body .= "<h3>Redeem Detail</h3><div class='address'><p><strong>Vendor Name :</strong>".$vendor_name."</p><p><strong>Offer Name :</strong>".$offer_title."</p><p><strong>Offer Product :</strong>".$mail_product_title."</p><p><strong>Offer Points :</strong>".$mail_redeem_point."</p></div>";
      	$delievery_boy_message = $mailer->wrap_message(sprintf( __( 'You have Redeem for Offer' )), $Delievery_boy_message_body );
		$mailer->send( $customer_email, sprintf( __( 'You have Redeem for Offer' )), $delievery_boy_message );
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.get_permalink().'/vendor-all-reward-point">';
	}