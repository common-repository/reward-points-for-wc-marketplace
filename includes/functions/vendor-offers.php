<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
   global $woocommerce;
    global $wpdb;
    $offer_table_name = $wpdb->prefix . "reward_offers";
    $reward_offers =  $wpdb->get_results("SELECT * FROM $offer_table_name"); ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Vendor Offers</h1>
        <table id="vendor_offer_points" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr class="phoen_rewpts_user_reward_point_tr">
                    <th align="center" valign="top"><span>Vendor Id</span></th>
                    <th align="center" valign="top"><span>Vendor Name</span></th>
                    <th align="center" valign="top"><span>Offer Name </span></th>
                    <th align="center" valign="top"><span>Offer Product </span></th>
                    <th align="center" valign="top"><span>Offer Point</span></th>
                    <th align="center" valign="top"><span>Offer Type</span></th>
                    <th align="center" valign="top"><span>Offer Start Date</span></th>
                    <th align="center" valign="top"><span>Offer End Date</span></th>
                </tr>
            </thead>    
            <tbody> 
            <?php foreach ($reward_offers as $reward_offer) {    ?>
                <tr>
                    <td align="center" valign="top"><span><?php echo $reward_offer->VendorId; ?></span></td>
                    <?php $vendor_data = get_userdata( $reward_offer->VendorId ); ?>
                    <td align="center" valign="top"><span><?php echo $vendor_data->data->display_name; ?></span></td>
                    <td align="center" valign="top"><span><?php echo $reward_offer->OfferTitle; ?></span></td>
                    <?php $product_detail = wc_get_product( $reward_offer->ProductId );
                    $product_title = $product_detail->get_title(); ?>
                    <td align="center" valign="top"s><span><?php echo $product_title; ?></span></td>
                    <td align="center" valign="top"><span><?php echo $reward_offer->OfferPoints; ?></span></td>
                    <td align="center" valign="top"><span><?php if($reward_offer->OfferType == "TRUE"){ echo "Full Time"; }else{ echo "Not Full Time"; } ?></span></td>
                    <td align="center" valign="top"><span><?php echo $reward_offer->OfferStartDate; ?></span></td>
                    <td align="center" valign="top"><span><?php echo $reward_offer->OfferEndData; ?></span></td>  
                </tr>   
            <?php }?>
            </tbody>
            <tfoot>         
                <tr>      
                    <th align="center" valign="top"><span>Vendor Id</span></th>
                    <th align="center" valign="top"><span>Vendor Name</span></th>
                    <th align="center" valign="top"><span>Offer Name </span></th>
                    <th align="center" valign="top"><span>Offer Product </span></th>
                    <th align="center" valign="top"><span>Offer Point</span></th>
                    <th align="center" valign="top"><span>Offer Type</span></th>
                    <th align="center" valign="top"><span>Offer Start Date</span></th>
                    <th align="center" valign="top"><span>Offer End Date</span></th>
                </tr>
            </tfoot>
        </table>
    </div>