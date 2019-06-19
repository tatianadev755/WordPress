<?php
$data = get_option('or_social_settings');
?>
<div class="or_tab_container">

<div class="or_socailtab_id">
	<ul class="or_panel_menu">
		<li><a href="#facebook">Facebook</a></li>
		<li><a href="#twitter">Twitter</a></li>
	</ul>
</div>

<div class="or_socailtab_content">	

	<div class="or_whole_content" id="facebook">
		<div class="or_right_section">
			<div class="or_input_section">
				<label>App ID:</label>
				<input type="text" value="<?php echo isset($data['facebook']['AppId']) ? $data['facebook']['AppId'] : ''; ?>" placeholder="Enter AppId" class="AppId">
				<span></span>
			</div>
			<div class="or_input_section">
				<label>App Secret:</label>
				<input type="text" value="<?php echo isset($data['facebook']['Secret']) ? $data['facebook']['Secret'] : ''; ?>" placeholder="Enter App Secret" class="Secret">
				<span></span>
			</div>
			<div class="or_input_section">
				<button class="or_social_submit" data-social="facebook">Save Setting</button>
				<div class="or_loading"></div>
				<span></span>
			</div>
		</div>
	</div>
	
	<div class="or_whole_content" id="twitter" style="display:none;">
		asasdasd
	</div>
	
</div>

</div>		


<script>
jQuery(document).ready(function($){
	
	$('.or_socailtab_id a').click(function(e){
		e.preventDefault();
		var id = $(this).attr('href');
		$('.or_socailtab_content .or_whole_content').hide();
		$('.or_socailtab_content '+id).show();
	});
	
	$('.or_social_submit').click(function(){
		var social = $(this).attr('data-social');
		var data = { 'action' : 'or_save_social_setting', 'social' : social, 'apikey' : '' };
		var obj = $(this);
		
		$('#' + social).find('span').html('');
		
		switch(social){
			case 'facebook':
				var AppId = $('#' + social).find('.AppId').val();
				var Secret = $('#' + social).find('.Secret').val();
				
				if(AppId == ''){
					$('#' + social).find('.AppId').next('span').html('Facebook AppId is required.');
					return;
				}
				
				if(Secret == ''){
					$('#' + social).find('.Secret').next('span').html('Facebook App Secret is required.');
					return;
				}
			
				data.apikey = { 'AppId' : AppId, 'Secret' : Secret };
			break;
		}
		
		obj.next().next('.or_loading').show();
		console.log(data);
		$.ajax({
			url  :  ajaxurl,
			data : data,
			type : 'post',
			success : function(result){
				console.log(result);
				result = jQuery.parseJSON(result);
				obj.next().next('.or_loading').hide();
				if(result.error){
					obj.parent().find('span').text('Setting isn\'t saved.');
				}else{
					obj.parent().find('span').text('Setting is saved successfully.');
				}
			}
		});
	});
});
</script>