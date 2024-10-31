<?php  if ( ! defined( 'ABSPATH' ) ) exit; 

	$gen_settings=get_option('reward_point_custom_btn_styling');
	
	$add_topmargin    = (isset($gen_settings['add_topmargin']))?( $gen_settings['add_topmargin'] ):'8';
	
	$add_rightmargin    = (isset($gen_settings['add_rightmargin']))?( $gen_settings['add_rightmargin'] ):'10';
	
	$add_bottommargin    = (isset($gen_settings['add_bottommargin']))?( $gen_settings['add_bottommargin'] ):'8';
	
	$add_leftmargin    = (isset($gen_settings['add_leftmargin']))?( $gen_settings['add_leftmargin'] ):'10';
					
	$add_btn_bg_col    = (isset($gen_settings['add_btn_bg_col']))?( $gen_settings['add_btn_bg_col'] ):'';
	
	$add_btn_txt_col    = (isset($gen_settings['add_btn_txt_col']))?( $gen_settings['add_btn_txt_col'] ):'#000000';
	$add_btn_txt_hov_col=  (isset($gen_settings['add_btn_txt_hov_col']))?( $gen_settings['add_btn_txt_hov_col'] ):'';
	$add_btn_hov_col    = (isset($gen_settings['add_btn_hov_col']))?( $gen_settings['add_btn_hov_col'] ):'';
	
	$add_btn_border_style    = (isset($gen_settings['add_btn_border_style']))?( $gen_settings['add_btn_border_style'] ):'none';
	
	$add_btn_border    = (isset($gen_settings['add_btn_border']))?( $gen_settings['add_btn_border'] ):'0';
	
	$add_btn_bor_col    = (isset($gen_settings['add_btn_bor_col']))?( $gen_settings['add_btn_bor_col'] ):'';
	
	$add_btn_rad    = (isset($gen_settings['add_btn_rad']))?( $gen_settings['add_btn_rad'] ):'0';
	
	$div_rad    = (isset($gen_settings['div_rad']))?( $gen_settings['div_rad'] ):'0';
	
	
			
	$div_bg_col    = (isset($gen_settings['div_bg_col']))?( $gen_settings['div_bg_col'] ):'#fff';
	
	$div_border_style   = (isset($gen_settings['div_border_style']))?( $gen_settings['div_border_style'] ):'solid';
	
	$div_border    = (isset($gen_settings['div_border']))?( $gen_settings['div_border'] ):'1';
	
	$div_bor_col    = (isset($gen_settings['div_bor_col']))?( $gen_settings['div_bor_col'] ):'#ccc';
			
		
			?>

<style>

#reward_point .reward-button.button {
	padding: <?php echo $add_topmargin;?>px <?php echo $add_rightmargin;?>px <?php echo $add_bottommargin;?>px <?php echo $add_leftmargin;?>px; 
    font-weight: 400;
	background: <?php echo $add_btn_bg_col;?>;
	border: <?php echo $add_btn_border; ?>px <?php echo $add_btn_border_style; ?> <?php echo $add_btn_bor_col; ?>;
	color: <?php echo $add_btn_txt_col; ?>;
	border-radius:<?php echo $add_btn_rad;?>px;
}

#reward_point .reward-button.button:hover {
	background: <?php echo $add_btn_hov_col;?>;
	color: <?php echo $add_btn_txt_hov_col; ?>;
}

</style>