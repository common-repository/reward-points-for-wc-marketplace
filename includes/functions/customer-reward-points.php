<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}
   global $woocommerce;
	global $wpdb;
	$table_name = $wpdb->prefix . "reward_points";
	$unique_customers =  $wpdb->get_results("SELECT DISTINCT CustomerId FROM $table_name"); ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Customer Reward Points</h1>
        <table id="customer_reward_points" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
    			<tr class="phoen_rewpts_user_reward_point_tr">
    				<th align="center" valign="top"><span>Customer Id</span></th>
    				<th align="center" valign="top"><span>Customer Email</span></th>
    				<th align="center" valign="top"><span>Completed Orders </span></th>
    				<th align="center" valign="top"><span>Redeem Points</span></th>
    				<th align="center" valign="top"><span>Reward Points</span></th>
                    <th align="center" valign="top"><span>Remain Points</span></th>
    			</tr>
    		</thead>	
    		<tbody>	
    		<?php foreach ($unique_customers as $unique_customer) {
    			//$customer_51_rewards = $wpdb->get_results($wpdb->prepare("SELECT RewardPoints FROM $table_name WHERE CustomerId = '%s'",51));
    			$customer_detail = new WC_Customer( $unique_customer->CustomerId ); ?>
    			<tr>
    				<td align="center" valign="top"><?php echo $unique_customer->CustomerId; ?></td>						
    				<td align="center" valign="top"><?php echo $customer_detail->data['email']; ?></td>
    				<?php $customer_orders = $wpdb->get_results($wpdb->prepare("SELECT SUM(RewardPoints) as points , COUNT(DISTINCT(OrderId)) as cnt_order FROM $table_name WHERE CustomerId = '%s'",$unique_customer->CustomerId)); ?>
    				<td align="center" valign="top"><?php echo $customer_orders[0]->cnt_order; ?></td>
                    <?php $redeem_table = $wpdb->prefix . "redeem_points";
                    $redeem_points = $wpdb->get_results($wpdb->prepare("SELECT SUM(RedeemPoints) as points FROM $redeem_table WHERE CustomerId = '%s'",$unique_customer->CustomerId));
                    $remaining_points = $customer_orders[0]->points - $redeem_points[0]->points; ?>
    				<td align="center" valign="top"><?php if($redeem_points[0]->points != ''){ echo $redeem_points[0]->points; }else{ echo "-"; } ?></td>
    				<td align="center" valign="top"><?php echo $customer_orders[0]->points; ?></td>
                    <td align="center" valign="top"><?php echo $remaining_points; ?></td>
    			</tr>	
    		<?php }?>		
    		</tbody>
    		<tfoot>			
    			<tr>		
    				<th align="center" valign="top"><span>Customer Id</span></th>
    				<th align="center" valign="top"><span>Customer Email </span></th>
    				<th align="center" valign="top"><span>Completed Orders</span></th>
    				<th align="center" valign="top"><span>Redeem Points</span></th>
    				<th align="center" valign="top"><span>Reward Points</span></th>
                    <th align="center" valign="top"><span>Remain Points</span></th>
    			</tr>
    		</tfoot>
    	</table>
    </div>
<script type="text/javascript">
    jQuery(document).ready(function() {
    jQuery('#customer_reward_points').dataTable();
    // jQuery('#customer_reward_points_length select').addClass('form-control input-sm');
    // jQuery('#customer_reward_points_filter input').addClass('form-control input-sm');  
    
} );
</script>