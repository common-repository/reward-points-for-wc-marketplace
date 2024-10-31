// Delete offer js
jQuery(document).on('click', '.delete_row', function () {
    var id = jQuery(this).attr('data-id');
    jQuery.ajax({

        type: 'POST',
        url: ajax_object.ajaxurl,

        data: {"action": "your_delete_action", "element_id": id},
        success: function (data) {
            //run stuff on success here.  You can use `data` var in the 
           //return so you could post a message.
            console.log(data);
        }
    });
    jQuery(".row_"+id).html(""); 
     alert("Record Deleted Successfully");
}); 

// Add a reward at cart page 
jQuery(document).ready(function($){
   jQuery(document).on('click', '.add-point', function (e) {
                     
         var _ = $(this).siblings('input[class="reward_point_click"]');

         var value = _.val();
         var product = _.attr('data-product');
        
         jQuery.ajax({

          type: 'POST',
          url: cart_ajax.ajaxurl,

          data: {"action": "add_item_from_cart", "element_id":value,'product_id' : product},
          success: function (data) {
            console.log(data);
            window.location.reload();
          },
         
         });
                            
    });
 //Remove a reward at cart page    
    jQuery(document).on('click', '.remove-point', function (e) {
                    

         var _ = $(this).siblings('input[class="reward_point_click"]');

         var value = _.val();
         var product = _.attr('data-product');
         
          jQuery.ajax({

          type: 'POST',
          url: cart_ajax.ajaxurl,

          data: {"action": "remove_item_from_cart","element_id":value,'product_id' : product},
          success: function (data) {
            console.log(data);
            window.location.reload();
          },
         
          });
                    
                   
    });
// Customer Redeem point  js
    jQuery('#offer_name').on('change', function() {
         var redeem_offer_name = this.value;

         jQuery.ajax({
              type: 'POST',
              url: ajax_object.ajaxurl,
              data: {"action": "your_redeem_action", "offer_name": redeem_offer_name},
              success: function (data) {
                var obj = JSON.parse(data);
                  var product_title = "<?php echo get_the_title('obj[0].ProductId'); ?>";
                  jQuery("#offer_product_ajax").val(obj[0].product_title);
              jQuery("#offer_points_ajax").val(obj[0].OfferPoints);
              jQuery("#prod_id").val(obj[0].ProductId); 
              }
          });
    });

// Add offer full time and datewise js
    jQuery('#FullOffer').click(function() {
        //var offer_val = jQuery(this).val() + ' ' + (this.checked ? 'FullTime' : 'NotFullTime');
        if(jQuery(this).attr('checked'))
        {
          jQuery('.wcmp_stat_start_dt').removeAttr('required');
          jQuery('.wcmp_stat_end_dt').removeAttr('required');
          jQuery('.wcmp_stat_start_dt').css('display','none');
          jQuery('.wcmp_stat_start_dt').prev().css('display','none');
          jQuery('.wcmp_stat_end_dt').css('display','none');
          jQuery('.wcmp_stat_end_dt').prev().css('display','none');
          jQuery('.offer_dates').css('display','none');
          
          }
          else
          {
          jQuery('.wcmp_stat_start_dt').prop('required',true);
          jQuery('.wcmp_stat_end_dt').prop('required',true);
          jQuery('.wcmp_stat_start_dt').css('display','inline-block');
          jQuery('.wcmp_stat_start_dt').prev().css('display','inline-block');
          jQuery('.wcmp_stat_end_dt').css('display','inline-block');
          jQuery('.wcmp_stat_end_dt').prev().css('display','inline-block');
          jQuery('.offer_dates').css('display','inline-block');
          }
        
       });
 // Edit offer full time and date wise
    
    var offer_val = jQuery('#FullOffer-Edit').val();
      if(offer_val == "TRUE")
      {
        jQuery('.wcmp_stat_start_dt').removeAttr('required');
          jQuery('.wcmp_stat_end_dt').removeAttr('required');
          jQuery('.wcmp_stat_start_dt').css('display','none');
          jQuery('.wcmp_stat_start_dt').prev().css('display','none');
          jQuery('.wcmp_stat_end_dt').css('display','none');
          jQuery('.wcmp_stat_end_dt').prev().css('display','none');
          jQuery('.offer_dates').css('display','none');
      }
      jQuery("#FullOffer-Edit").on("change",function(){
         if(jQuery(this).is(":checked"))
         {
            jQuery(this).val("TRUE");
            jQuery('.wcmp_stat_start_dt').removeAttr('required');
            jQuery('.wcmp_stat_end_dt').removeAttr('required');
            jQuery('.wcmp_stat_start_dt').css('display','none');
            jQuery('.wcmp_stat_start_dt').prev().css('display','none');
            jQuery('.wcmp_stat_end_dt').css('display','none');
            jQuery('.wcmp_stat_end_dt').prev().css('display','none');
            jQuery('.offer_dates').css('display','none');
        }
          else
          {
            jQuery(this).val("FALSE");
            jQuery('.wcmp_stat_start_dt').prop('required',true);
            jQuery('.wcmp_stat_end_dt').prop('required',true);
            jQuery('.wcmp_stat_start_dt').css('display','inline-block');
            jQuery('.wcmp_stat_start_dt').prev().css('display','inline-block');
            jQuery('.wcmp_stat_end_dt').css('display','inline-block');
            jQuery('.wcmp_stat_end_dt').prev().css('display','inline-block');
            jQuery('.offer_dates').css('display','inline-block');
         }
      });
// Vendor offer page data table
    jQuery('#offer_table').dataTable();
    jQuery('#offer_table_length select').addClass('form-control input-sm');
    jQuery('#offer_table_filter input').addClass('form-control input-sm');  

// Reward Point page data table
    jQuery('#reward_table').dataTable();
    jQuery('#reward_table_length select').addClass('form-control input-sm');
    jQuery('#reward_table_filter input').addClass('form-control input-sm');  
    
});
