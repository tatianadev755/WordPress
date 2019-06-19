<?php
/**
*
*	Origin Builder
*	(c) originbuilder.com
*
*/
if(!defined('or_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}
	
$or = originbuilder::globe();
	
	echo'<script>	jQuery( document ).ready(function() {
		setTimeout(function() {
  if(jQuery(".or_row:first").attr("data-model")==undefined){ 
 jQuery("#or-footers .empty_guide").css("display","block") ; 
 jQuery("#or-footers .svg_arrow").css("display","block") ; 
  }
	 }, 1000);
	
	});</script>';
	
	echo"<script>jQuery('body').on('click', '.quickadd', function(){   
 if(jQuery(this).parent('ul').parent('#or-footers').prev('#or-rows').children('div').length==0){
	 jQuery(this).parent('ul').children('.svg_arrow').css('display','none');
 }
 else{
	  jQuery(this).parent('ul').find('.svg_arrow').css('display','block');
 }
 });</script>";
?>

<div id="or-footers" class="or-footers">
	 	<div class="start_img empty_guide"  style="display:none;">
		<h2>Hey there! It seems there's nothing to display here.</h2>
         <span>Start building your contents by adding a row below.</span>
				<img class="" src="<?php echo or_URL; ?>/assets/images/bg_empty.png" />
					 </div>
	<ul>
	<li class="basic-add" data-action="browse">
			<span class="m-a-tips"><?php _e('Browse all elements', 'originbuilder'); ?></span>
		</li>
		<li class="one-column quickadd" data-content='[or_row][or_column width="12/12"][/or_column][/or_row]'>
			<span class="grp-column" data-action="quick-add" data-action="quick-add"></span>
			<span class="m-a-tips"><?php _e('Add an 1-column row', 'originbuilder'); ?></span>
		</li>	
		
		<li class="two-columns quickadd"  data-content='[or_row][or_column width="6/12"][/or_column][or_column width="6/12"][/or_column][/or_row]'>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="m-a-tips"><?php _e('Add a 2-column row', 'originbuilder'); ?></span>
		</li>
		<li class="three-columns quickadd" data-content='[or_row][or_column width="4/12"][/or_column][or_column width="4/12"][/or_column][or_column width="4/12"][/or_column][/or_row]'>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="m-a-tips"><?php _e('Add a 3-column row', 'originbuilder'); ?></span>
		</li>
		<li class="four-columns quickadd" data-content='[or_row][or_column width="3/12"][/or_column][or_column width="3/12"][/or_column][or_column width="3/12"][/or_column][or_column width="3/12"][/or_column][/or_row]'>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="m-a-tips"><?php _e('Add a 4-column row', 'originbuilder'); ?></span>
		</li>
			 <li class="four-columns quickadd" data-content='[or_row][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][/or_row]'>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span><span class="grp-column" data-action="quick-add"></span>
			<span class="m-a-tips"><?php _e('Add a 5-column row', 'originbuilder'); ?></span>
		</li><li class="four-columns quickadd" data-content='[or_row][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][/or_row]'>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span>
			<span class="grp-column" data-action="quick-add"></span><span class="grp-column" data-action="quick-add"></span><span class="grp-column" data-action="quick-add"></span>
			<span class="m-a-tips"><?php _e('Add a 6-column row', 'originbuilder'); ?></span>
		</li>
		<li class="column-text quickadd" data-action="custom-push" data-content="custom" style="display:none">
			<i class="et-document"></i>
			<span class="m-a-tips"><?php _e('Push customized content and shortcodes', 'originbuilder'); ?></span>
		</li>
		<li class="title quickadd" data-action="paste" data-content='paste' style="display:none">
			<i class="et-clipboard"></i>
			<span class="m-a-tips"><?php _e('Paste copied element', 'originbuilder'); ?></span>
		</li>
		<li class="or-add-sections" data-action="sections" style="display:none">
			<i class="et-lightbulb"></i> 
			<?php _e('Sections Manager', 'originbuilder'); ?>
			<span class="m-a-tips"><?php _e('Installation of sections which were added', 'originbuilder'); ?></span>
		</li>
		
		<div class="svg_arrow" style="display:none;"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="59" height="98" viewBox="0 0 59 98">
  <image id="Shape_28" data-name="Shape 28" width="59" height="98" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADsAAABiCAMAAADZelu+AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAB/lBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA9GyJsAAAAqXRSTlMAE7FAPeHqFAF3+7QVuP65+G/kSZac+TICfcIbw0KT2g2q/YQE8AfOpNfpRh7nKPReCk26YPMZeI6e9yeYawnbKQP6COU/WqeRgn5prFS/QdIuJOgXD/UL5hjZyzS3SKBfjXN2iT7H7fYR0DZicTzK/AbTWLvNRJQx3JfuxGHJ64Opoo9FcgV6N8YcrsjUh3BOT4ahOMAj3rZnf7BSElN7EFdLz2UqDvI7Zt8//gAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAJbSURBVFjDxdhXXxNBFMbhRQ3GEEMoYjSgmNAJCEIEI9JUFERESmiCICrFhoiABQELYgE7FhB7+X9LA1zo7b658FzMXj2/OTM7s3N2DGMtItatN8TYYCFyoyStm2xAlFWg9s04onESI+QbS2RcPFscCVtNStc2G9vdRiJJO9iZbM7uwuNNMYxU7GnpZJizmVnZodZHjmHk7ibPlM1PW2n3UBBqC/HvNT9fRRSvPPYF9pu3JRxYfZaap0YBcYJaizLKVVpR6TioWh+H5JQPkyjbKo7INoajsq2mRrYlHJNtLcdlW8cJ2dZzUrZlNMjWgk+2jTTJNpVm2QbJly3I1PDT8l/G20qbbMN5v+1hrKsOTsm2ky7ZnqZbtj2ckW0vZ2XbbfbU/ifOcV62Pvpk6+pnQMaDXJBtBhdle4l42V7mimxbhpxXZTwcxk4qoVe21xiRbZOjX6nL1uI6o7KtZky24+RUyPhGGGe/l5uyLeeWPtO3mZDtBHdkWzqJ2R+kvzHFtGzb+j25Mo7nrmzdAZve8T2iZBuRyn0ZP2B4RrUp9TyUO54dcpbLuIdH8j7OL8OrZ105lCTjXnIeq9b6hKdySdw8x7RyT7IaDZHMy0OeDYZxPCUl8EzGz20UyfiFk5fyhGUHeSXXAq8neROh4oVM3sqVxMA7Au9V7PrgYdGu6tFYGpdU/HEaFt2qXm7F/0k9Xj+P2bDkuUQ9XgdzX1T99Ru0fxczdy2nw+T8gqatXdEOPCOFyRr/UZwFgcUJbbnMLEclgGOwZ0n6lv6sqv1FKMTrspTfNZ19HX8AJa2m1nKaiz0AAAAASUVORK5CYII="/>
</svg>
		<span>Add row with columns</span></div>
	</ul>
</div>
