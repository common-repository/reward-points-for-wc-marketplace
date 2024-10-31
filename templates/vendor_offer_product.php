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
global $woocommerce;
global $WCMp;global $wpdb;global $wp;
// $endpoints = new WCMp_Endpoints();
?>
<div class="wcmp_main_holder toside_fix">
	<div class="wcmp_headding1">
		<div class="col-md-12 	">
			<h3><?php _e( 'Reward Offers', $WCMp->text_domain );?></h3>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="wcmp_vendor_orders">
		<div class="col-md-12 all-products-wrapper" id="all">
			<?php
			global $wpdb;
			$table_name = $wpdb->prefix . "reward_offers";
			$vendor_detail = get_wcmp_vendor(get_current_user_id());
			$current_vendorid = $vendor_detail->id;
			$all_offers =  $wpdb->get_results("SELECT * FROM $table_name WHERE VendorId = $current_vendorid");

			?>
						 <div class="panel panel-default panel-pading">
							<table id="offer_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
						        <thead>
						            <tr>
						                <th valign="top"  ><?php _e( 'Offer Name', $WCMp->text_domain );?></th>
										<th  valign="top" ><?php _e( 'Product Name', $WCMp->text_domain );?></th>
										<th class="no_display"  valign="top" > <?php _e( 'Offer Points', $WCMp->text_domain );?> </th>
										<th class="no_display" valign="top"  > <?php _e( 'Start Date', $WCMp->text_domain );?> </th>
										<th valign="top" ><?php _e( 'End Date', $WCMp->text_domain );?> </th>
										<th valign="top" ><?php _e( 'Actions', $WCMp->text_domain );?></th>
						            </tr>
						        </thead>
						        <?php if(!empty($all_offers)) {  ?>
						        <tbody>
						        <?php foreach ($all_offers as $all_offer) { ?>
									<tr class="row_<?php echo $all_offer->Id; ?>">
										<td valign="top"  ><?php echo $all_offer->OfferTitle; ?></td>
										<?php $product_title =  wc_get_product( $all_offer->ProductId ); ?>
										<td  valign="top" ><?php echo $product_title->get_name(); ?></td>
										<td class="no_display"  valign="top" > <?php echo $all_offer->OfferPoints; ?> </td>
										<td class="no_display" valign="top"  > <?php echo $all_offer->OfferStartDate; ?> </td>
										<td valign="top" ><?php echo $all_offer->OfferEndData; ?> </td>
										<td  valign="top" >

										<?php $edit_product_link = 
	 											
												$actions = array();
												global $wp;	
												$editurl = get_permalink();
												
												$actions['delete'] = array(
													'url'  => esc_url( add_query_arg( array( 'offer_id' => $all_offer->Id ), get_permalink($wp->request))),
													//'img' => $WCMp->plugin_url . 'assets/images/view.png',
													'title' => __('Delete' ,$WCMp->text_domain),
													);
												$actions['edit'] = array(
													'url'  => esc_url(add_query_arg( array( 'offer_id' => $all_offer->Id ), wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_edit_vendor_offer_endpoint', 'vendor', 'general', 'vendor-edit-offer')))),
													'title' => __('Edit' ,$WCMp->text_domain),
													);
												$actions = apply_filters( 'wcmp_my_account_my_orders_actions', $actions, $order );
												
												if ($actions) {
													foreach ( $actions as $key => $action ) { 
														 if ($key == 'delete') { ?> 
															<a class="delete_row" data-id="<?php echo $all_offer->Id; ?>" title="<?php echo $action['title']; ?>" href="<?php echo $action['url']; ?>">Delete</a>&nbsp;
														<?php } 
										 				elseif ($key == 'edit') { ?>
											 				<a class="edit_row" title="<?php echo $action['title']; ?>" href="<?php echo $action['url']; ?>">Edit</a>&nbsp; 
											 			<?php }
													}
												} ?> 
										</td>
									</tr>
						           <?php } ?>
						        </tbody>
						    <?php } 
					        ?>
						        <tfoot>
						            <tr>
						                <th valign="top"  ><?php _e( 'Offer Name', $WCMp->text_domain );?></th>
										<th  valign="top" ><?php _e( 'Product Name', $WCMp->text_domain );?></th>
										<th class="no_display"  valign="top" > <?php _e( 'Offer Points', $WCMp->text_domain );?> </th>
										<th class="no_display" valign="top"  > <?php _e( 'Start Date', $WCMp->text_domain );?> </th>
										<th valign="top" ><?php _e( 'End Date', $WCMp->text_domain );?> </th>
										<th valign="top" ><?php _e( 'Actions', $WCMp->text_domain );?></th>
						            </tr>
						        </tfoot>
						    </table>
						</div>
				
			</div>
	</div>
</div>