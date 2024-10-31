<?php if ( ! defined( 'ABSPATH' ) ) exit; 

	if ( ! empty( $_POST ) && check_admin_referer( 'reward_point_btn_action', 'reward_point_btn_action_field' ) ) {

		if(sanitize_text_field( $_POST['custom_btn'] ) == 'Save Options'){

			$reward_percentage = (isset($_POST['reward_percentage']))?sanitize_text_field( $_POST['reward_percentage'] ):'REWARD POINT PERCENTAGE';
			
			$add_btn_title    = (isset($_POST['add_btn_title']))?sanitize_text_field( $_POST['add_btn_title'] ):'ADD POINTS';
			
			$add_topmargin    = (isset($_POST['add_topmargin']))?sanitize_text_field( $_POST['add_topmargin'] ):'8';
			
			$add_rightmargin    = (isset($_POST['add_rightmargin']))?sanitize_text_field( $_POST['add_rightmargin'] ):'10';
			
			$add_bottommargin    = (isset($_POST['add_bottommargin']))?sanitize_text_field( $_POST['add_bottommargin'] ):'8';
			
			$add_leftmargin    = (isset($_POST['add_leftmargin']))?sanitize_text_field( $_POST['add_leftmargin'] ):'10';
							
			$add_btn_bg_col    = (isset($_POST['add_btn_bg_col']))?sanitize_text_field( $_POST['add_btn_bg_col'] ):'';
			
			$add_btn_txt_col    = (isset($_POST['add_btn_txt_col']))?sanitize_text_field( $_POST['add_btn_txt_col'] ):'#000000';
			
			$add_btn_txt_hov_col    = (isset($_POST['add_btn_txt_hov_col']))?sanitize_text_field( $_POST['add_btn_txt_hov_col'] ):'';
			
			$add_btn_hov_col    = (isset($_POST['add_btn_hov_col']))?sanitize_text_field( $_POST['add_btn_hov_col'] ):'';
			
			$add_btn_border_style    = (isset($_POST['add_btn_border_style']))?sanitize_text_field( $_POST['add_btn_border_style'] ):'none';
			
			$add_btn_border    = (isset($_POST['add_btn_border']))?sanitize_text_field( $_POST['add_btn_border'] ):'0';
			
			$add_btn_bor_col    = (isset($_POST['add_btn_bor_col']))?sanitize_text_field( $_POST['add_btn_bor_col'] ):'';
			
			$add_btn_rad    = (isset($_POST['add_btn_rad']))?sanitize_text_field( $_POST['add_btn_rad'] ):'0';
				
			$remove_btn_title    = (isset($_POST['remove_btn_title']))?sanitize_text_field( $_POST['remove_btn_title'] ):'REMOVE POINTS';
			
			$div_bg_col    = (isset($_POST['div_bg_col']))?sanitize_text_field( $_POST['div_bg_col'] ):'#fff';
			$div_border_style    = (isset($_POST['div_border_style']))?sanitize_text_field( $_POST['div_border_style'] ):'solid';
			$div_border    = (isset($_POST['div_border']))?sanitize_text_field( $_POST['div_border'] ):'1';
			$div_bor_col    = (isset($_POST['div_bor_col']))?sanitize_text_field( $_POST['div_bor_col'] ):'#ccc';
			$div_rad    = (isset($_POST['div_rad']))?sanitize_text_field( $_POST['div_rad'] ):'0';
			
			$btn_settings=array(

					'reward_percentage' => $reward_percentage,
				
					'add_btn_title'		=>		$add_btn_title,
					
					'add_topmargin'		=>		$add_topmargin,
					
					'add_rightmargin'	=>		$add_rightmargin,
					
					'add_bottommargin'	=>		$add_bottommargin,
					
					'add_leftmargin'	=>		$add_leftmargin,
					
					'add_btn_bg_col'	=>		$add_btn_bg_col,
					
					'add_btn_txt_col'	=>		$add_btn_txt_col,
					
					'add_btn_txt_hov_col'=>$add_btn_txt_hov_col,
					
					'add_btn_hov_col'	=>		$add_btn_hov_col,
					
					'add_btn_border_style'=>	$add_btn_border_style,
					
					'add_btn_border'	=>		$add_btn_border,
					
					'add_btn_bor_col'	=>		$add_btn_bor_col,
					
					'add_btn_rad'		=>		$add_btn_rad,
					
					'remove_btn_title'	=>		$remove_btn_title,
					
					'div_bg_col'		=>		$div_bg_col,
					
					'div_border_style'	=>		$div_border_style,
					
					'div_border'		=>		$div_border,
					
					'div_bor_col'		=>		$div_bor_col,
					'div_rad'=>$div_rad
			);
			
			update_option('reward_point_custom_btn_styling',$btn_settings);
			
		}
	}

?>
	<div class="cat_mode">
			
		<form method="post" name="reward_point_btn_form">
			
			<?php $gen_settings=get_option('reward_point_custom_btn_styling');
			
					
			wp_nonce_field( 'reward_point_btn_action', 'reward_point_btn_action_field' ); ?>
					
			<table class="form-table" style="width:50%;">
				<tr valign="top">
			        <th scope="row">
			        	<?php echo __( 'Set Reward Point Percentage', 'reward-point' ); ?>
			        </th>
			        <td>
			       		 <input type="number" min="0" max="100" name="reward_percentage" class="form-control" value="<?php echo(isset($gen_settings['reward_percentage'])) ?$gen_settings['reward_percentage']:'REWARD POINT PERCENTAGE';?>">
			        </td>
				</tr> 
				<tr>
					
					<th>
					
						<?php _e('Button Styling Option','reward-point'); ?>
						<hr>
						
					</th>
				</tr>	


				<tr>
					
					<th>
					
						<?php _e('Add Button title','reward-point'); ?>
						
					</th>
					
					<td>
						
						<input type="text" pattern="[a-zA-Z ]*$" title="Only alphabets is allow" class="add_btn_title" name="add_btn_title" value="<?php echo(isset($gen_settings['add_btn_title'])) ?$gen_settings['add_btn_title']:'ADD POINTS';?>">
					
					</td>
				
				</tr>
				<tr>
					
					<th>
					
						<?php _e('Remove Button title','reward-point'); ?>
						
					</th>
					
					<td>
						
						<input type="text" class="remove_btn_title" pattern="[a-zA-Z ]*$" title="Only alphabets is allow" name="remove_btn_title" value="<?php echo(isset($gen_settings['remove_btn_title'])) ?$gen_settings['remove_btn_title']:'REMOVE POINTS';?>">
					
					</td>
				
				</tr>
				
				
				<tr>

				<th> 
				
					<?php _e('Padding','reward-point'); ?>
					
				</th>
					
					<td>
					
						<input class="btn_num"   placeholder="TOP" style="max-width:60px;font-size:12px;" min="0" name="add_topmargin" 	type="number" value="<?php echo(isset($gen_settings['add_topmargin'])) ?$gen_settings['add_topmargin']:'8';?>">
							
						<input class="btn_num"  placeholder="RIGHT" style="max-width:65px;font-size:12px;" min="0" name="add_rightmargin" 	type="number" value="<?php echo(isset($gen_settings['add_rightmargin'])) ?$gen_settings['add_rightmargin']:'10';?>">

						<input class="btn_num"  placeholder="BOTTOM" style="max-width:65px;font-size:12px;" min="0" name="add_bottommargin" 	type="number" value="<?php echo(isset($gen_settings['add_bottommargin'])) ?$gen_settings['add_bottommargin']:'8';?>">
							
						<input class="btn_num"   placeholder="LEFT" style="max-width:65px;font-size:12px;" min="0" name="add_leftmargin" 	type="number" value="<?php echo(isset($gen_settings['add_leftmargin'])) ?$gen_settings['add_leftmargin']:'10';?>"><span class="pixel-11">px</span>

					</td>

				</tr>
				
				<tr>
					
					<th>
					
						<?php _e('Button Background Color','reward-point'); ?>
						
					</th>
					
					<td>
						
						<input class="btn_color_picker btn_bg_col" type="text" name="add_btn_bg_col" value="<?php echo(isset($gen_settings['add_btn_bg_col'])) ?$gen_settings['add_btn_bg_col']:'#000000';?>">
					
					</td>
				
				</tr>
				
				</tr>
				
				<tr>
					<th>
					
						<?php _e('Button Background Hover color','reward-point'); ?>
						
					</th>
					
					<td>
					
						<input class="btn_color_picker btn_hov_col" type="text" name="add_btn_hov_col" value="<?php echo(isset($gen_settings['add_btn_hov_col'])) ?$gen_settings['add_btn_hov_col']:'';?>">
					
					</td>
					
				</tr>
				
				
				<tr>
					<th>
					
						<?php _e('Button Text color','reward-point'); ?>
						
					</th>
					
					<td>
						
						<input class="btn_color_picker btn_txt_col" type="text" name="add_btn_txt_col" value="<?php echo(isset($gen_settings['add_btn_txt_col'])) ?$gen_settings['add_btn_txt_col']:'#fff';?>">
					
					</td>
					
				</tr>
				
				<tr>
					<th>
					
						<?php _e('Button Text Hover color','reward-point'); ?>
						
					</th>
					
					<td>
						
						<input class="btn_color_picker btn_txt_col" type="text" name="add_btn_txt_hov_col" value="<?php echo(isset($gen_settings['add_btn_txt_hov_col'])) ?$gen_settings['add_btn_txt_hov_col']:'#fff';?>">
					
					</td>
					
				
				<tr>
				
					<th>
					
						<?php _e('Border style','reward-point'); ?>
						
					</th>
					
					<td>
					
						<?php $st = (isset($gen_settings['add_btn_border_style'])) ? $gen_settings['add_btn_border_style'] : 'none'; ?>
						
						<select  name="add_btn_border_style" class="btn_border_style">
							
							<option value="none" <?php if($st=='none') echo 'selected';?>>None</option>
							
							<option value="solid" <?php if($st=='solid') echo 'selected';?>>Solid</option>
							
							<option value="dashed" <?php if($st=='dashed') echo 'selected';?>>Dashed</option>
							
							<option value="dotted" <?php if($st=='dotted') echo 'selected';?>>Dotted</option>
							
							<option value="double" <?php if($st=='double') echo 'selected';?>>Double</option>

						</select>
						
					</td>
					
				</tr>
				
				<tr class="btn_bor">
					<th>
					
						<?php _e('Button Border Width','reward-point'); ?>
						
					</th>
					
					<td>
					
						<input class="btn_num"  min="0" type="number" name="add_btn_border" style="max-width:105px;" value="<?php echo(isset($gen_settings['add_btn_border'])) ?$gen_settings['add_btn_border']:'0';?>">px
					
					</td>
					
				</tr>
								
				<tr class="btn_bor">
					<th>
					
						<?php _e('Button border color','reward-point'); ?>
						
					</th>
					
					<td>
						<input class="btn_color_picker btn_bor_col"  type="text" name="add_btn_bor_col" value="<?php echo(isset($gen_settings['add_btn_bor_col'])) ?$gen_settings['add_btn_bor_col']:'';?>">
					
					</td>
					
				</tr>
				
				<tr>
				
					<th>
					
						<?php _e('Button Radius','reward-point'); ?>
						
					</th>
					
					<td>
					
						<input  class="btn_num" min="0" type="number" style="max-width:105px;" name="add_btn_rad" value="<?php echo(isset($gen_settings['add_btn_rad'])) ?$gen_settings['add_btn_rad']:'0';?>">px
					
					</td>
					
				</tr>
				
				<tr>
				
					<th>
					
						<?php _e('Button Box Background Color','reward-point'); ?>
						
					</th>
					
					<td>
					
						<input  class="btn_color_picker" type="text" style="max-width:105px;" name="div_bg_col" value="<?php echo(isset($gen_settings['div_bg_col'])) ?$gen_settings['div_bg_col']:'#fff';?>">
					
					</td>
					
				</tr>
				
				
				
				
				<tr>
				
					<th>
					
						<?php _e('Button Box Border style','reward-point'); ?>
						
					</th>
					
					<td>
					
						<?php $st = (isset($gen_settings['div_border_style'])) ? $gen_settings['div_border_style'] : 'solid'; ?>
						
						<select  name="div_border_style" class="div_border_style">
							
							<option value="none" <?php if($st=='none') echo 'selected';?>>None</option>
							
							<option value="solid" <?php if($st=='solid') echo 'selected';?>>Solid</option>
							
							<option value="dashed" <?php if($st=='dashed') echo 'selected';?>>Dashed</option>
							
							<option value="dotted" <?php if($st=='dotted') echo 'selected';?>>Dotted</option>
							
							<option value="double" <?php if($st=='double') echo 'selected';?>>Double</option>

						</select>
						
					</td>
					
				</tr>
				
				<tr class="btn_bor">
					<th>
					
						<?php _e('Button Box Border Width','reward-point'); ?>
						
					</th>
					
					<td>
					
						<input class="btn_num" min="0"  type="number" name="div_border" style="max-width:105px;" value="<?php echo(isset($gen_settings['div_border'])) ?$gen_settings['div_border']:'1';?>">px
					
					</td>
					
				</tr>
								
				<tr class="btn_bor">
					<th>
					
						<?php _e('Button Box border color','reward-point'); ?>
						
					</th>
					
					<td>
						<input class="btn_color_picker btn_bor_col"  type="text" name="div_bor_col" value="<?php echo(isset($gen_settings['div_bor_col'])) ?$gen_settings['div_bor_col']:'#ccc';?>">
					
					</td>
					
				</tr>
				
				<tr>
				
					<th>
					
						<?php _e('Button Box Radius','reward-point'); ?>
						
					</th>
					
					<td>
					
						<input  class="btn_num" min="0" type="number" style="max-width:105px;" name="div_rad" value="<?php echo(isset($gen_settings['div_rad'])) ?$gen_settings['div_rad']:'0';?>">px
					
					</td>
					
				</tr>
				
				
				
				<tr>
				
					<td>
					
						<input type="submit" class="button button-primary" value="Save Options" name="custom_btn">
						
						
					</td>
					
				</tr>
						
			</table>
		
		</form>
		
	</div>