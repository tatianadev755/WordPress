<?php
add_action('admin_menu', 'or_settings_menu_verified');
function or_settings_menu_verified() {
	add_submenu_page(
		'options-general.php',
		esc_html__('Origin Builder WP', 'originbuilder'),
		esc_html__('Origin Builder', 'originbuilder'),
		'manage_options',
		'orverifiedpage',
		'or_verified_function'
	);
}


function or_admin_notice_error() {
	
	if(isset($_GET['page']) && $_GET['page'] == 'orverifiedpage'){
		//remove_action( 'admin_notices' );
		return;
	}
	$class = 'notice notice-error';
	$message1 = 'Origin Builder is pending domain authorization.';
	$message2 = 'Activate Origin Builder';

	printf( '<div class="%1$s"><p>%2$s</p><p><strong><a href="'.admin_url().'options-general.php?page=orverifiedpage">%3$s</a></strong></p></div>', $class, $message1, $message2 ); 
}
add_action( 'admin_notices', 'or_admin_notice_error' );

function or_verified_function(){
	if(isset($_POST['purchase_email'])) {
		$email = ($_POST["purchase_email"]);
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$domain = $_SERVER['SERVER_NAME'];
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, 'http://originbuilder.net/nigeria/check/validate_domain');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"useremail=".$_POST['purchase_email']."&userdomain=".$domain."");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($ch);
			curl_close ($ch);
			$output = json_decode($result);
			if(isset($output->error)) {
				$msg = '<p style="color:red;"> '.$output->message.'</p>';
			}else {
				update_option('originbuilder-'.OR_chk.'-chk', base64_encode(OR_chk));
			}
		}else {
			$msg = '<p style="color:red;"> Email should be correct.</p>';
		}
	}
	else {
		$msg = '';
	}
    /*}
    else {
        echo 'Already Verified!!';
    }*/
	
	?>
	<style>
	.or_varified_domain {
		margin: 10px 15px 2px;
		padding: 20px 12px;
		text-align: center;
		/*max-width: 960px;*/
		font-size: 14px;
		font-weight: 600;
		width: 96%;
		background: #fff;
	}
	.or_varified_domain input[type=text] {
		box-shadow: none;
		border-color: #ccc;
		width: 50%;
		height: 35px;
		clear: both;
		margin-top: 15px;
	}
	.or_varified_domain p {
		font-size: 14px;
	}
	.or_varified_domain .button {
		margin: 0px auto;
		margin-top: 15px;
		font-size: 14px;
		height: 46px;
		line-height: 44px;
		padding: 0 36px;
	}
		</style>
	<?php
	
	$var = get_option('originbuilder-'.OR_chk.'-chk');
	if(base64_decode($var) == OR_chk){
		echo '<div class="or_varified_domain"><p>Congratulations! You have activated your Origin Builder.</p></div>';
	}else{
	?>
	<div class="or_varified_domain">
		<?php echo isset($msg) ? $msg : ''; ?>
		<p>Thank you for purchasing Origin Builder. We have determined your domain name as <?php echo $_SERVER['SERVER_NAME'];?></p>
		<p>Enter your purchase email below to activate</p>
		<form action="" method="post"> 
			<input type="text" name="purchase_email" placeholder="Enter your purchase email" /><br/> <input type="submit" value="Submit" class="button button-primary">
		</form>
	</div>
	<?php
	}
}
?>