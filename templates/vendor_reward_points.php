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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce, $WCMp;
$pages = get_option('wcmp_pages_settings_name');

?>
<div class="wcmp_main_holder toside_fix">
	<div class="wcmp_headding1">
		<div class="col-md-12 	">
			<h3><?php _e( 'Reward Point', $WCMp->text_domain );?></h3>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="wcmp_vendor_orders">
		<div class="col-md-12 all-products-wrapper" id="all">
			<?php
			global $wpdb;
			$table_name = $wpdb->prefix . "reward_points";
			$vendor_detail = get_wcmp_vendor(get_current_user_id());
			$current_vendorid = $vendor_detail->id;
			$unique_customers =  $wpdb->get_results("SELECT DISTINCT CustomerId FROM $table_name WHERE VendorId = $current_vendorid");
				if(!empty($unique_customers)) { ?>
						<div class="panel panel-default panel-pading">
							<table id="reward_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th valign="top"  ><?php _e( 'Customer Id', $WCMp->text_domain );?></th>
										<th align="center" valign="top" ><?php _e( 'Customer Email', $WCMp->text_domain );?></th>
										<th align="center" class="no_display"  valign="top" > <?php _e( 'Redeem Points', $WCMp->text_domain );?> </th>
										<th align="center" class="no_display" valign="top"  > <?php _e( 'Reward Points', $WCMp->text_domain );?> </th>
										<th align="center"  valign="top" ><?php _e( 'Remain Points', $WCMp->text_domain );?> </th>
										<th align="center"  valign="top" ><?php _e( 'Actions', $WCMp->text_domain );?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($unique_customers as $unique_customer) {
								$customer_detail = new WC_Customer( $unique_customer->CustomerId ); ?>
								<tr>
									<td  valign="top"  ><?php echo $unique_customer->CustomerId; ?></td>
									<td   valign="top" ><?php echo $customer_detail->data['display_name']; ?></td>
									<?php $customer_orders = $wpdb->get_results($wpdb->prepare("SELECT SUM(RewardPoints) as points , COUNT(DISTINCT(OrderId)) as cnt_order FROM $table_name WHERE CustomerId = '%s' AND VendorId = '%s'",array($unique_customer->CustomerId,$current_vendorid)));
										$redeem_table = $wpdb->prefix . "redeem_points";	
										$redeem_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RedeemPoints) as points FROM $redeem_table WHERE CustomerId = '%s' AND VendorId = '%s'",array($unique_customer->CustomerId,$current_vendorid)));
										$remain_points = ($customer_orders[0]->points - $redeem_points[0]->points);
									?>
									<td class="no_display"  valign="top" > <?php if(!empty($redeem_points[0]->points)){ echo $redeem_points[0]->points; }else{ echo "0"; }?> </td>
									<td class="no_display" valign="top"  > <?php echo $customer_orders[0]->points;?> </td>
									<td valign="top"><?php echo $remain_points;?> </td>
									<td  valign="top">
										<?php
											
											
											$actions = array();
											$actions['view'] = array(
												'url'  => esc_url(add_query_arg( array( 'customer_id' => $customer_detail->id ), wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_customer_redeem_points_endpoint', 'vendor', 'general', 'customer-redeem-points')))),
												//'img' => $WCMp->plugin_url . 'assets/images/view.png',
												'title' => __('Redeem' ,$WCMp->text_domain),
											);
											$actions = apply_filters( 'wcmp_my_account_my_orders_actions', $actions, $order );

											if ($actions) {
												foreach ( $actions as $key => $action ) { 
												 if ($key == 'view') { 
												 	 ?> 
								<a title="<?php echo $action['title']; ?>" href="<?php echo $action['url']; ?>">Redeem</a>&nbsp; 
							<?php } 
							 else {
							 ?>
								<a title="<?php echo $action['title']; ?>" href="<?php echo $action['url']; ?>" data-id="<?php echo $order; ?>" class="<?php echo sanitize_html_class( $key ); ?>" href="#">Redeem</a>&nbsp;
							<?php 
									}
							}
							} 
										 ?> 
									</td>
								</tr>

								<?php } ?>
								<tbody>
								<tfoot>
						            <tr>
						                <th valign="top"  ><?php _e( 'Customer Id', $WCMp->text_domain );?></th>
										<th  align="center" valign="top" ><?php _e( 'Customer Email', $WCMp->text_domain );?></th>
										<th align="center" class="no_display"  valign="top" > <?php _e( 'Redeem Points', $WCMp->text_domain );?> </th>
										<th align="center" class="no_display" valign="top"  > <?php _e( 'Reward Points', $WCMp->text_domain );?> </th>
										<th align="center"  valign="top" ><?php _e( 'Remain Points', $WCMp->text_domain );?> </th>
										<th align="center"  valign="top" ><?php _e( 'Actions', $WCMp->text_domain );?></th>
						            </tr>
						        </tfoot>
							</table>
						</div>
				<?php } else { ?>
				<div class="wcmp_table_loader"> <?php _e( 'Showing Results', $WCMp->text_domain );?><span> 0 </span></div> 
			<?php } ?>
			</div>
	</div>
</div>