<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/

if(!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

	$or = originbuilder::globe();
	$settings = $or->settings();
	$plugin_info = get_plugin_data( or_FILE );
	
?>
<style type="text/css">
	#or-settings  div.group input[type="text"],
	#or-settings  div.group input[type="password"]{
		height: 35px;
		box-shadow: none;
		display: block;
		margin-bottom: 5px;
		padding-left: 10px;
	}
	#or-settings div.or-badge{
		background-image: url('<?php echo or_URL; ?>/assets/images/logo.png');
		color: #dedede;
	}
	#or-settings div.p{
		padding-left: 10px; 
		padding-top:15px;
		display: block;
	}
	
	#or-settings p.radio{
		cursor: pointer;
	}
	.or-notice{
	    background: rgb(253, 255, 196);
	    display: inline-block;
	    width: 100%;
	    border-radius: 2px;
	    margin: 20px 0;
	    box-shadow: 0 0 1px 0 rgba(0,0,0,0.2);
	}
	.or-notice p{
		padding: 10px 20px;
		margin: 0px;
	}
   .about-wrap img{width:10%;height:auto;}
   .settings_page_origincomposer #or_general_setting{padding:0!important;}
   .settings_page_origincomposer #or_general_setting table td{padding:0!important;}
 	.settings_page_origincomposer, .settings_page_origincomposer #wpwrap {
  background: #fff none repeat scroll 0 0;
}
.settings_page_origincomposer #wpcontent {
  padding-left: 0;
}
.settings_page_origincomposer .about-wrap {
  margin: 155px 20px 0 !important;
  max-width: inherit;
}

#or-settings .about-text {
  color: #333 !important;
  font-size: 26px !important;
  font-weight: 600 !important;
  margin-top:40px!important;
  margin-bottom:16px!important;
}



#or-settings img {
  display: none;
  margin-right: 20px;
  width: 100px;
}
#or-settings #or_general_setting {
  padding: 0;
}

</style>



<div class="hs_wrapper">
	<div class="hs_tab_container">
	
		<div id="or-settings" class="wrap">
			<div class="hs_heading">
			<h3 class="title">Origin Builder Settings</h3>
			</div>
	 
			<form method="post" action="options.php" enctype="multipart/form-data" id="or-settings-form">
				<?php settings_fields( 'origincomposer_group' ); ?>
				<div id="or_general_setting" class="group p">
					<?php
						
						$update_plugin = get_site_transient( 'update_plugins' );

						if ( isset( $update_plugin->response[ or_BASE ] ) )
						{
					?>
					<div class="or-notice">
						<p>
							<i class="dashicons dashicons-warning"></i> 
							<?php
								printf( __('There is a new version of OriginBuilder available, please go to %s to update', 'originbuilder'),	
									'<a href="'.admin_url('/plugins.php').'">Plugins</a>'
								); ?>.
						</p>
					</div>
					<?php			
						}
					?>
					<table class="form-table">
					
						<tbody>
								 <tr><th scope="row">             Supported WordPress content types   </th>
						
								<td>
									<?php
										
										$post_types = get_post_types( array( 'public' => true ) );
										$ignored_types = array('attachment');
										$settings_types = $or->get_content_types();
										$required_types = $or->get_required_content_types();
					
										foreach( $post_types as $type ){
											if( !in_array( $type, $ignored_types ) ){
												echo '<p class="radio"><input ';
												if( in_array( $type, $settings_types ) )
													echo 'checked ';
												if( in_array( $type, $required_types ) )
													echo 'disabled ';	
												echo'type="checkbox" name="or_options[content_types][]" value="'.esc_attr($type).'"> ';
												echo esc_html( $type );
												if( in_array( $type, $required_types ) )
													echo ' <i> (required)</i>';
												echo '</p>';
											}
										}
										
									?>
							 
								</td>
							</tr>
		 
						</tbody>
					</table>		
				</div>
				<div id="or_product_license" class="group p" >
					<?php
						if ( isset( $update_plugin->response[ or_BASE ] ) )
						{
					?>
					<div class="or-notice">
						<p>
							<i class="dashicons dashicons-warning"></i> 
							<?php
								printf( __('After submitting license informations, please go to %s to update', 'originbuilder'),	
									'<a href="'.admin_url('/plugins.php').'">Plugins</a>'
								); ?>.
						</p>
					</div>
					<?php			
						}	
					?>
					<br />
					<p class="submit">
						<input type="submit" class="button button-large button-primary" value="<?php _e('Save Change', 'originbuilder'); ?>" />
					</p>			
				</div>	
				
			</form>
		</div>
		
		<!--<div class="hs_heading">
			<h3 class="title">SOCIAL</h3>
		</div>-->
		
		<?php //require or_PATH.KDS.'includes'.KDS.'or.social.setting.php'; ?>
		
	</div>
</div>
	
	
<?php 
$data = get_option('or_subscriber_settings');
$connect = $disconnect = '';

if(isset($data['ConstantContact']) && !empty($data['ConstantContact'])){
	$connect .= '<li class="active"><a id="parent" href="#ConstantContact"> <img src="'. or_URL . '/assets/images/subscriber/ConstantContact.png" alt=""><p class="hs_connect">Disconnect</p>
	<p class="hs_name">Constant Contact</p> </a></li>';
}else{
	$disconnect .= '<li class="active"><a id="parent" href="#ConstantContact"> <img src="'. or_URL . '/assets/images/subscriber/ConstantContact.png" alt=""><p class="hs_connect">Connect</p>
	<p class="hs_name">Constant Contact</p> </a></li>';
}

if(isset($data['iContact']) && !empty($data['iContact'])){
	$connect .= '<li><a href="#iContact"><img src="' . or_URL . '/assets/images/subscriber/iContact.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">iContact</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#iContact"><img src="' . or_URL . '/assets/images/subscriber/iContact.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">iContact</p> </a></li>';
}

if(isset($data['Aweber']) && !empty($data['Aweber'])){
	$connect .= '<li><a href="#Aweber"><img src="' . or_URL . '/assets/images/subscriber/Aweber.png" alt="">
	<p class="hs_connect">Disconnect</p><p class="hs_name">Aweber</p></a></li>';
}else{
	$disconnect .= '<li><a href="#Aweber"><img src="' . or_URL . '/assets/images/subscriber/Aweber.png" alt="">
	<p class="hs_connect">Connect</p><p class="hs_name">Aweber</p></a></li>';
}

if(isset($data['GoToWebinar']) && !empty($data['GoToWebinar'])){
	$connect .= '<li><a href="#GoToWebinar"><img src="' . or_URL . '/assets/images/subscriber/GoToWebinar.png" alt=""><p class="hs_connect">Disconnect</p><p class="hs_name">GoToWebinar</p></a></li>';
}else{
	$disconnect .= '<li><a href="#GoToWebinar"><img src="' . or_URL . '/assets/images/subscriber/GoToWebinar.png" alt=""><p class="hs_connect">Connect</p><p class="hs_name">GoToWebinar</p></a></li>';
}

if(isset($data['Mailchimp']) && !empty($data['Mailchimp'])){
	$connect .= '<li><a href="#Mailchimp"><img src="' . or_URL . '/assets/images/subscriber/Mailchimp.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">Mailchimp</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#Mailchimp"><img src="' . or_URL . '/assets/images/subscriber/Mailchimp.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">Mailchimp</p> </a></li>';
}

if(isset($data['CampaignMonitor']) && !empty($data['CampaignMonitor'])){
	$connect .= '<li><a href="#CampaignMonitor"><img src="' . or_URL . '/assets/images/subscriber/CampaignMonitor.png" alt=""><p class="hs_connect">Disconnect</p><p class="hs_name">CampaignMonitor</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#CampaignMonitor"><img src="' . or_URL . '/assets/images/subscriber/CampaignMonitor.png" alt=""><p class="hs_connect">Connect</p><p class="hs_name">CampaignMonitor</p> </a></li>';
}

if(isset($data['GetResponse']) && !empty($data['GetResponse'])){
	$connect .= '<li><a href="#GetResponse"><img src="' . or_URL . '/assets/images/subscriber/GetResponse.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">GetResponse</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#GetResponse"><img src="' . or_URL . '/assets/images/subscriber/GetResponse.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">GetResponse</p> </a></li>';
}

if(isset($data['ActiveCampaign']) && !empty($data['ActiveCampaign'])){
	$connect .= '<li><a href="#ActiveCampaign"><img src="' . or_URL . '/assets/images/subscriber/ActiveCampaign.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">ActiveCampaign</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#ActiveCampaign"><img src="' . or_URL . '/assets/images/subscriber/ActiveCampaign.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">ActiveCampaign</p> </a></li>';
}

if(isset($data['SendReach']) && !empty($data['SendReach'])){
	$connect .= '<li><a href="#SendReach"><img src="' . or_URL . '/assets/images/subscriber/SendReach.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">SendReach</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#SendReach"><img src="' . or_URL . '/assets/images/subscriber/SendReach.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">SendReach</p> </a></li>';
}

if(isset($data['Sendlane']) && !empty($data['Sendlane'])){
	$connect .= '<li><a href="#Sendlane"><img src="' . or_URL . '/assets/images/subscriber/Sendlane.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">Sendlane</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#Sendlane"><img src="' . or_URL . '/assets/images/subscriber/Sendlane.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">Sendlane</p> </a></li>';
}

if(isset($data['Mailpoet']) && !empty($data['Mailpoet'])){
	$connect .= '<li><a href="#Mailpoet"><img src="' . or_URL . '/assets/images/subscriber/Mailpoet.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">Mailpoet</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#Mailpoet"><img src="' . or_URL . '/assets/images/subscriber/Mailpoet.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">Mailpoet</p> </a></li>';
}

if(isset($data['Sendy']) && !empty($data['Sendy'])){
	$connect .= '<li><a href="#Sendy"><img src="' . or_URL . '/assets/images/subscriber/Sendy.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">Sendy</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#Sendy"><img src="' . or_URL . '/assets/images/subscriber/Sendy.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">Sendy</p> </a></li>';
}

if(isset($data['Sendinblue']) && !empty($data['Sendinblue'])){
	$connect .= '<li><a href="#Sendinblue"><img src="' . or_URL . '/assets/images/subscriber/Sendinblue.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">Sendinblue</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#Sendinblue"><img src="' . or_URL . '/assets/images/subscriber/Sendinblue.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">Sendinblue</p> </a></li>';
}

if(isset($data['Verticalresponse']) && !empty($data['Verticalresponse'])){
	$connect .= '<li><a href="#Verticalresponse"><img src="' . or_URL . '/assets/images/subscriber/Verticalresponse.png" alt=""> <p class="hs_connect">Disconnect</p><p class="hs_name">Verticalresponse</p> </a></li>';
}else{
	$disconnect .= '<li><a href="#Verticalresponse"><img src="' . or_URL . '/assets/images/subscriber/Verticalresponse.png" alt=""> <p class="hs_connect">Connect</p><p class="hs_name">Verticalresponse</p> </a></li>';
}
?>	
	
	<div class="hs_wrapper">
	<div class="hs_tab_container">
		<div class="hs_heading">
			<h3 class="title">Applications</h3>
		</div>
		<ul class="hs_panel_menu or_connect" id="dis-panel-nav">
			<?php echo $disconnect; ?>
		</ul>	
		
		<div class="hs_heading">
			<h3 class="title">Connected</h3>
		</div>
		<ul class="hs_panel_menu or_disconnect" id="panel-nav">
			<?php echo $connect; ?>
		</ul>
		<!--popup for disconnect -->
		<div class="hs_dis_popup">
			<div class="hd_dis_content">
				<div class="hs_heading_section">	
					<span>Disconnect Aweber</span>
					<a class="popup_closer popup_dis_closer"></a>
				</div>
				<a class="hs_dis_btn" data-responder="" >Disconnect</a> 
				<a class="hs_dis_cancel popup_dis_closer">Cancel</a>
			</div>
		</div>
		<!--popup for disconnect -->
		<div id="tab-container" class="hs_tabs_box hs_connect_popup">
		<div class="hs_popup_content">  
		<div class="hs_heading_section">	
			<span class="hs_popup_heading">Connect CampaignMonitor</span>
			<a class="popup_closer"></a>
		</div>
			<div class="hs_whole_content" id="ConstantContact" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Username:</label>
						<input type="text" value="<?php echo isset($data['ConstantContact']['username']) ? $data['ConstantContact']['username'] : ''; ?>" placeholder="Enter Username" class="username">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>Password:</label>
						<input type="text" value="<?php echo isset($data['ConstantContact']['password']) ? $data['ConstantContact']['password'] : ''; ?>" placeholder="Enter Password" class="password">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['ConstantContact'])){ ?>
							<button class="hs_btn_submit" data-responder="ConstantContact">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="ConstantContact" >Disconnect</button>
						<?php } ?>					
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			<div class="hs_whole_content" id="SendReach" style="display:none;"> 
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Public Key:</label>
						<input type="text" value="<?php echo isset($data['SendReach']['public_key']) ? $data['SendReach']['public_key'] : ''; ?>" placeholder="Enter Public Key" class="public_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>Private Key:</label>
						<input type="text" value="<?php echo isset($data['SendReach']['private_key']) ? $data['SendReach']['private_key'] : ''; ?>" placeholder="Enter Private Key" class="private_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['SendReach'])){ ?>
							<button class="hs_btn_submit" data-responder="SendReach">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="SendReach" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="iContact" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Login Email:</label>
						<input type="text" value="<?php echo isset($data['iContact']['login_email']) ? $data['iContact']['login_email'] : ''; ?>" placeholder="Enter Login Email" class="login_email">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>APP Id:</label>
						<input type="text" value="<?php echo isset($data['iContact']['app_id']) ? $data['iContact']['app_id'] : ''; ?>" placeholder="Enter APP ID" class="app_id">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>APP Password:</label>
						<input type="text" value="<?php echo isset($data['iContact']['app_password']) ? $data['iContact']['app_password'] : ''; ?>" placeholder="Enter APP Password" class="app_password">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['iContact'])){ ?>
							<button class="hs_btn_submit" data-responder="iContact">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="iContact" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Verticalresponse" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Accesstoken:</label>
						<input type="text" value="<?php echo isset($data['Verticalresponse']['accesstoken']) ? $data['Verticalresponse']['accesstoken'] : ''; ?>" placeholder="Enter Login Email" class="accesstoken">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Verticalresponse'])){ ?>
							<button class="hs_btn_submit" data-responder="Verticalresponse">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Verticalresponse" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Infusionsoft" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Host URL:</label>
						<input type="text" value="<?php echo isset($data['Infusionsoft']['host_url']) ? $data['Infusionsoft']['host_url'] : ''; ?>" placeholder="Enter Host url" class="host_url">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Infusionsoft']['api_key']) ? $data['Infusionsoft']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Infusionsoft'])){ ?>
							<button class="hs_btn_submit" data-responder="Infusionsoft">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Infusionsoft" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Hubspot" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Hubspot']['api_key']) ? $data['Hubspot']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Hubspot'])){ ?>
							<button class="hs_btn_submit" data-responder="Hubspot">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Hubspot" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Aweber" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Aweber Code:</label>
						<input type="text" value="<?php echo isset($data['Aweber']['aweber_code']) ? $data['Aweber']['aweber_code'] : ''; ?>" placeholder="Enter aweber code" class="aweber_code">
						<span></span>
						<a href="https://auth.aweber.com/1.0/oauth/authorize_app/1622c940" target="_blank" style="    float: left;">Where can I find this?</a>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Aweber'])){ ?>
							<button class="hs_btn_submit" data-responder="Aweber">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Aweber" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Sendlane" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>User URL:</label>
						<input type="text" value="<?php echo isset($data['Sendlane']['user_url']) ? $data['Sendlane']['user_url'] : ''; ?>" placeholder="Enter user url" class="user_url">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Sendlane']['api_key']) ? $data['Sendlane']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>HASH Key:</label>
						<input type="text" value="<?php echo isset($data['Sendlane']['hash_key']) ? $data['Sendlane']['hash_key'] : ''; ?>" placeholder="Enter HASH Key" class="hash_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Sendlane'])){ ?>
							<button class="hs_btn_submit" data-responder="Sendlane">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Sendlane" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Mailpoet" style="display:none;">
				<div>
					<?php if(class_exists('WYSIJA')){ ?>
						<p>There is no special requirement.</p>
					<?php }else{ ?>
						<a href="https://wordpress.org/plugins/wysija-newsletters/" target="_blank">Active Mailpoet plugin here</a>
					<?php } ?>
				</div>
				<div class="hs_input_section">
					<?php if(empty($data['Mailpoet'])){ ?>
						<button class="hs_btn_submit" data-responder="Mailpoet">Connect</button>
						<button class="hs_popup_cancel popup_closer">Cancel</button>
					<?php }else{ ?>
						<button class="hs_btn_cancel" data-responder="Mailpoet" >Disconnect</button>
					<?php } ?>
					<div class="hs_loading"></div>
					<span></span>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Benchmark" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Username:</label>
						<input type="text" value="<?php echo isset($data['Benchmark']['username']) ? $data['Benchmark']['username'] : ''; ?>" placeholder="Enter username" class="username">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>Password:</label>
						<input type="text" value="<?php echo isset($data['Benchmark']['password']) ? $data['Benchmark']['password'] : ''; ?>" placeholder="Enter password" class="password">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Benchmark'])){ ?>
							<button class="hs_btn_submit" data-responder="Benchmark">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Benchmark" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Sendy" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Sendy']['api_key']) ? $data['Sendy']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>List Name:</label>
						<input type="text" value="<?php echo isset($data['Sendy']['list_nm']) ? $data['Sendy']['list_nm'] : ''; ?>" placeholder="Enter List Name" class="list_nm">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>List ID:</label>
						<input type="text" value="<?php echo isset($data['Sendy']['list_id']) ? $data['Sendy']['list_id'] : ''; ?>" placeholder="Enter List ID" class="list_id">
						<span></span>
					</div>
					<div class="hs_input_section">
						<?php if(empty($data['Sendy'])){ ?>
							<button class="hs_btn_submit" data-responder="Sendy">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Sendy" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Madmimi" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Madmimi']['api_key']) ? $data['Madmimi']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>Username:</label>
						<input type="text" value="<?php echo isset($data['Madmimi']['username']) ? $data['Madmimi']['username'] : ''; ?>" placeholder="Enter Username" class="username">
						<span></span>
					</div>					
					<div class="hs_input_section">
						<?php if(empty($data['Madmimi'])){ ?>
							<button class="hs_btn_submit" data-responder="Madmimi">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Madmimi" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Mailchimp" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Mailchimp']['api_key']) ? $data['Mailchimp']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>					
					<div class="hs_input_section">
						<?php if(empty($data['Mailchimp'])){ ?>
							<button class="hs_btn_submit" data-responder="Mailchimp">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Mailchimp" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="CampaignMonitor" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key;</label>
						<input type="text" value="<?php echo isset($data['CampaignMonitor']['api_key']) ? $data['CampaignMonitor']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>	
					<div class="hs_input_section">
						<label>Client Id:</label>
						<input type="text" value="<?php echo isset($data['CampaignMonitor']['client_id']) ? $data['CampaignMonitor']['client_id'] : ''; ?>" placeholder="Enter Client Id" class="client_id"> 
						<span></span>
					</div>					
					<div class="hs_input_section">
						<?php if(empty($data['CampaignMonitor'])){ ?>
							<button class="hs_btn_submit" data-responder="CampaignMonitor">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="CampaignMonitor" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="Sendinblue" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['Sendinblue']['api_key']) ? $data['Sendinblue']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>					
					<div class="hs_input_section">
						<?php if(empty($data['Sendinblue'])){ ?>
							<button class="hs_btn_submit" data-responder="Sendinblue">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="Sendinblue" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="GetResponse" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['GetResponse']['api_key']) ? $data['GetResponse']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>					
					<div class="hs_input_section">
						<?php if(empty($data['GetResponse'])){ ?>
							<button class="hs_btn_submit" data-responder="GetResponse">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="GetResponse" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="ActiveCampaign" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>API Url:</label>
						<input type="text" value="<?php echo isset($data['ActiveCampaign']['api_url']) ? $data['ActiveCampaign']['api_url'] : ''; ?>" placeholder="Enter API Url" class="api_url">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>API Key:</label>
						<input type="text" value="<?php echo isset($data['ActiveCampaign']['api_key']) ? $data['ActiveCampaign']['api_key'] : ''; ?>" placeholder="Enter API Key" class="api_key">
						<span></span>
					</div>					
					<div class="hs_input_section">
						<?php if(empty($data['ActiveCampaign'])){ ?>
							<button class="hs_btn_submit" data-responder="ActiveCampaign">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="ActiveCampaign" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
			
			<div class="hs_whole_content" id="GoToWebinar" style="display:none;">
				<div class="hs_right_section">
					<div class="hs_input_section">
						<label>Consumer Key:</label>
						<input type="text" value="<?php echo isset($data['GoToWebinar']['consumer_key']) ? $data['GoToWebinar']['consumer_key'] : ''; ?>" placeholder="Enter API Url" class="consumer_key">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>Consumer Secret:</label>
						<input type="text" value="<?php echo isset($data['GoToWebinar']['consumer_secret']) ? $data['GoToWebinar']['consumer_secret'] : ''; ?>" placeholder="Enter API Key" class="consumer_secret">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>User Id:</label>
						<input type="text" value="<?php echo isset($data['GoToWebinar']['user_id']) ? $data['GoToWebinar']['user_id'] : ''; ?>" placeholder="Enter API Url" class="user_id">
						<span></span>
					</div>
					<div class="hs_input_section">
						<label>Password:</label>
						<input type="text" value="<?php echo isset($data['GoToWebinar']['password']) ? $data['GoToWebinar']['password'] : ''; ?>" placeholder="Enter API Key" class="password">
						<span></span>
					</div>	
					<div class="hs_input_section">
						<?php if(empty($data['GoToWebinar'])){ ?>
							<button class="hs_btn_submit" data-responder="GoToWebinar">Connect</button>
							<button class="hs_popup_cancel popup_closer">Cancel</button>
						<?php }else{ ?>
							<button class="hs_btn_cancel" data-responder="GoToWebinar" >Disconnect</button>
						<?php } ?>
						<div class="hs_loading"></div>
						<span></span>
					</div>
				</div>
			</div>
		</div>
			
		</div>
	</div>
	
</div>


<script>
jQuery(document).ready(function($){
	// jQuery('.hs_panel_menu li a').on('click',function(e){
		// e.preventDefault();
		// jQuery(".hs_panel_menu li").removeClass('active');
		// jQuery(this).parent('li').addClass('active');
		// var loc=jQuery(this).attr('href');
		// jQuery("#tab-container>div").css({'display':'none'});
		// jQuery(loc).fadeIn(100);
		// var px = jQuery(this).parent('li').parent().children().index(jQuery(this).parent('li'));
		// jQuery(loc).css({'margin-top': (px * 108) + 'px', 'transition': 'ease-in-out 0.25s'});
	// });
	
	$('.hs_dis_btn').click(function(){
		var responder = $(this).attr('data-responder');
		var data = { 'action' : 'or_save_subscriber_setting', 'responder' : responder, 'apikey' : '', 'eraser' : 1 };
		var obj = $(this);
		
		//obj.next('.hs_loading').show();
		//alert('asd');
		$.ajax({
			url  :  ajaxurl,
			data : data,
			type : 'post',
			success : function(result){
				//console.log(result);
				location.reload();
			}
		});
		
	});
	
	$('.hs_btn_submit').click(function(){
		var responder = $(this).attr('data-responder');
		var data = { 'action' : 'or_save_subscriber_setting', 'responder' : responder, 'apikey' : '' };
		var obj = $(this);
		
		$('#' + responder).find('span').html('');
		
		switch(responder){
			case 'ConstantContact':
			
				var username = $('#' + responder).find('.username').val();
				var password = $('#' + responder).find('.password').val();
				
				if(username == ''){
					$('#' + responder).find('.username').next('span').html('username is required.');
					//alert('username is required.');
					return;
				}
				
				if(password == ''){
					$('#' + responder).find('.password').next('span').html('password is required.');
					//alert('password is required.');
					return;
				}
			
				data.apikey = { 'username' : username, 'password' : password };
				
			break;
			
			case 'SendReach':
			
				var public_key = $('#' + responder).find('.public_key').val();
				var private_key = $('#' + responder).find('.private_key').val();
				
				if(public_key == ''){
					$('#' + responder).find('.public_key').next('span').html('Public Key is required.');
					//alert('Public Key is required.');
					return;
				}
				
				if(private_key == ''){
					$('#' + responder).find('.private_key').next('span').html('Private Key is required.');
					//alert('Private Key is required.');
					return;
				}
			
				data.apikey = { 'public_key' : public_key, 'private_key' : private_key };
			
			break;
			
			case 'iContact':
				
				var login_email = $('#' + responder).find('.login_email').val();
				var app_id = $('#' + responder).find('.app_id').val();
				var app_password = $('#' + responder).find('.app_password').val();
				
				if(login_email == ''){
					$('#' + responder).find('.login_email').next('span').html('Login Email is required.');
					//alert('Login Email is required.');
					return;
				}
				
				if(app_id == ''){
					$('#' + responder).find('.app_id').next('span').html('APP ID is required.');
					//alert('APP ID is required.');
					return;
				}
				
				if(app_password == ''){
					$('#' + responder).find('.app_password').next('span').html('APP Password is required.');
					//alert('APP Password is required.');
					return;
				}
			
				data.apikey = { 'login_email' : login_email, 'app_id' : app_id, 'app_password' : app_password };
				
			break;
			
			case 'Infusionsoft':
			
				var host_url = $('#' + responder).find('.host_url').val();
				var api_key = $('#' + responder).find('.api_key').val();
				
				if(host_url == ''){
					alert('Host Url is required.');
					return;
				}
				
				if(api_key == ''){
					alert('API Key is required.');
					return;
				}
			
				data.apikey = { 'host_url' : host_url, 'api_key' : api_key };
				
			break;
			
			case 'Hubspot':
			
				var api_key = $('#' + responder).find('.api_key').val();
								
				if(api_key == ''){
					alert('API Key is required.');
					return;
				}
			
				data.apikey = { 'api_key' : api_key };
				
			break;
			
			case 'Aweber':
			
				var aweber_code = $('#' + responder).find('.aweber_code').val();
								
				if(aweber_code == ''){
					$('#' + responder).find('.aweber_code').next('span').html('Aweber Code is required.');
					//alert('Aweber Code is required.');
					return;
				}
			
				data.apikey = { 'aweber_code' : aweber_code };
				
			break;
			
			case 'Sendlane':
			
				var user_url = $('#' + responder).find('.user_url').val();
				var api_key = $('#' + responder).find('.api_key').val();
				var hash_key = $('#' + responder).find('.hash_key').val();
				
				if(user_url == ''){
					$('#' + responder).find('.user_url').next('span').html('User Url is required.');
					//alert('User Url is required.');
					return;
				}
				
				if(api_key == ''){
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					//alert('API Key is required.');
					return;
				}
				
				if(hash_key == ''){
					$('#' + responder).find('.hash_key').next('span').html('Hash Key is required.');
					//alert('Hash Key is required.');
					return;
				}
			
				data.apikey = { 'user_url' : user_url, 'api_key' : api_key, 'hash_key' : hash_key };
				
			break;
			
			case 'Benchmark':
				
				var username = $('#' + responder).find('.username').val();
				var password = $('#' + responder).find('.password').val();
				
				if(username == ''){
					alert('username is required.');
					return;
				}
				
				if(password == ''){
					alert('password is required.');
					return;
				}
			
				data.apikey = { 'username' : username, 'password' : password };
				
			break;
			
			case 'Sendy':
				
				var list_nm = $('#' + responder).find('.list_nm').val();
				var api_key = $('#' + responder).find('.api_key').val();
				var list_id = $('#' + responder).find('.list_id').val();
				
				if(api_key == ''){
					//alert('API Key is required.');
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					return;
				}
				
				if(list_nm == ''){
					//alert('User Url is required.');
					$('#' + responder).find('.list_nm').next('span').html('List Name is required.');
					return;
				}
				
				if(list_id == ''){
					//alert('Hash Key is required.');
					$('#' + responder).find('.list_id').next('span').html('List Id is required.');
					return;
				}
			
				data.apikey = { 'list_nm' : list_nm, 'api_key' : api_key, 'list_id' : list_id };
				
			break;
			
			case 'Madmimi':
			
				var username = $('#' + responder).find('.username').val();
				var api_key = $('#' + responder).find('.api_key').val();
				
				if(list_nm == ''){
					alert('User Url is required.');
					return;
				}
				
				if(api_key == ''){
					alert('API Key is required.');
					return;
				}
			
				data.apikey = { 'username' : username, 'api_key' : api_key };
				
			break;
			
			case 'Mailchimp':
				
				var api_key = $('#' + responder).find('.api_key').val();
								
				if(api_key == ''){
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					//alert('API Key is required.');
					return;
				}
			
				data.apikey = { 'api_key' : api_key };
				
			break;
			
			case 'CampaignMonitor':
				
				var api_key = $('#' + responder).find('.api_key').val();
				var client_id = $('#' + responder).find('.client_id').val();
								
				if(api_key == ''){
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					//alert('API Key is required.');
					return;
				}
				
				if(client_id == ''){
					$('#' + responder).find('.client_id').next('span').html('Client Id is required.');
					//alert('Client Id is required.');
					return;
				}
			
				data.apikey = { 'api_key' : api_key, 'client_id' : client_id };
				
			break;
			
			case 'Sendinblue':
				
				var api_key = $('#' + responder).find('.api_key').val();
								
				if(api_key == ''){
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					//alert('API Key is required.');
					return;
				}
			
				data.apikey = { 'api_key' : api_key };
				
			break;
			
			case 'GetResponse':
				
				var api_key = $('#' + responder).find('.api_key').val();
								
				if(api_key == ''){
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					//alert('API Key is required.');
					return;
				}
			
				data.apikey = { 'api_key' : api_key };
				
			break;
			
			case 'ActiveCampaign':
				
				var api_key = $('#' + responder).find('.api_key').val();
				var api_url = $('#' + responder).find('.api_url').val();
				
				if(api_url == ''){
					//alert('API Url is required.');
					$('#' + responder).find('.api_url').next('span').html('API Url is required.');
					return;
				}
				
				if(api_key == ''){
					//alert('API Key is required.');
					$('#' + responder).find('.api_key').next('span').html('API Key is required.');
					return;
				}
				
				data.apikey = { 'api_key' : api_key, 'api_url' : api_url };
				
			break;
			
			case 'GoToWebinar':
				
				var consumer_key = $('#' + responder).find('.consumer_key').val();
				var consumer_secret = $('#' + responder).find('.consumer_secret').val();
				var user_id = $('#' + responder).find('.user_id').val();
				var password = $('#' + responder).find('.password').val();
								
				if(consumer_key == ''){
					$('#' + responder).find('.consumer_key').next('span').html('Consumer Key is required.');
					return;
				}
				
				if(consumer_secret == ''){
					$('#' + responder).find('.consumer_secret').next('span').html('Consumer Secret is required.');
					return;
				}
				
				if(user_id == ''){
					$('#' + responder).find('.user_id').next('span').html('User Id is required.');
					return;
				}
				
				if(password == ''){
					$('#' + responder).find('.password').next('span').html('Password is required.');
					return;
				}
			
				data.apikey = { 'consumer_key' : consumer_key, 'consumer_secret' : consumer_secret, 'user_id' : user_id, 'password' : password, };
				
			break;
			
			case 'Mailpoet':
				data.apikey = { 'mailpoet' : 'activate' };
			break;
			
			case 'Verticalresponse':
			
				var accesstoken = $('#' + responder).find('.accesstoken').val();
				
				if(accesstoken == ''){
					$('#' + responder).find('.accesstoken').next('span').html('Accesstoken is required.');
					return;
				}
				
				data.apikey = { 'accesstoken' : accesstoken };
			break;
		}
			
		obj.next().next('.hs_loading').show();
		console.log(data);
		$.ajax({
			url  :  ajaxurl,
			data : data,
			type : 'post',
			success : function(result){
				console.log(result);
				result = jQuery.parseJSON(result);
				obj.next().next('.hs_loading').hide();
				if(result.error){
					obj.parent().find('span').text('An error occurred while getting your list.');
				}else{
					location.reload();
				}
			}
		});
		
	});
	
});
    jQuery(document).ready(function($) {
        $('.nav-tab-wrapper a').on( 'click', function(e) {
	        var clicked = $(this).attr('href');
	        if( clicked.indexOf('#') == -1 )
	        	return true;
            $('.nav-tab-wrapper a').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active').blur();
            $('.group').hide();
            $(clicked).fadeIn();
            if (typeof(localStorage) != 'undefined' ) {
                localStorage.setItem('activeTab', clicked );
            }
            e.preventDefault();
        });
		var id = "";
		$('.hs_tab_container ul.or_connect li a').on( 'click', function(e) {
			e.preventDefault();
			id = $(this).attr('href');
			var name = id.substring(1);
			$(id).show();
			$('.hs_popup_content').find('.hs_popup_heading').html('Connect ' + name);
			$('#tab-container').show();
		});
		
		$('.hs_tab_container ul.or_disconnect li a').on( 'click', function(e) {
			e.preventDefault();
			var responder = $(this).attr('href');
			responder = responder.substring(1);
			$('.hs_dis_btn').prev().html('Disconnect ' + responder);
			$('.hs_dis_popup').show();
			$('.hs_dis_btn').attr('data-responder',responder);
		});
		$('.popup_closer').on( 'click', function(e) {
			$('#tab-container').hide();
			$(id).hide();
		});
		$('.popup_dis_closer').on( 'click', function(e) {
			$('.hs_dis_popup').hide();
			//$(id).hide();
		});	
        $('p.radio').on('click',function(e){
	        if( e.target.tagName != 'INPUT' ){
	        	var inp = $(this).find('input').get(0);
	        	if( inp.disabled == true )
		        	e.preventDefault();
				else if( inp.checked == true )
	        		inp.checked = false;
	        	else inp.checked = true;	
	        }	
        });
        if (typeof(localStorage) != 'undefined' ) {
            activeTab = localStorage.getItem('activeTab');
            if( activeTab != undefined ){
	            $('.nav-tab-wrapper a[href='+activeTab+']').trigger('click');
            }
        }
        if(window.location.href.indexOf('#')>-1)
        	$('.nav-tab-wrapper a[href=#'+window.location.href.split('#')[1]+']').trigger('click');
    });
</script>