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

$id = isset( $_GET['id'] ) ? $_GET['id'] : 0;
$link = get_permalink( $id );

if( strpos( $link, '?' ) === false )
	$link .= '?or_action=live-editor';
else $link .= '&or_action=live-editor';
echo'<script>jQuery( document ).ready(function() {
    jQuery(".check_device").click(function(){
    if(jQuery(this).find("input[type=checkbox]").is(":checked")) {   
						 
                        jQuery("#or-live-frame").addClass("black_img");
					  }else {   
                 jQuery("#or-live-frame").removeClass("black_img");
		       }
});
});</script>';
 
?>
<iframe id="or-live-frame" src="<?php echo esc_url( $link ); ?>"></iframe>
 
      
		<ul class="footer_width ab-top-secondary ab-top-menu or-top-toolbar seven_fourty" style="display:none;">
        <li class="left_device fix_width or-bar-devices vertical"  data-screen="1024">  
         <svg viewBox="24 39 87 46" height="40" width="40" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke-linecap: round;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-1 {
        stroke: #646b81;
      }

      .cls-2 {
        stroke: #e8ebf5;
      }
    </style>
  </defs>
  <g id="rotate-hor">
    <g>
      <path transform="translate(-280 -996)" d="M312,1049v-19a4,4,0,0,1,4-4h22a4,4,0,0,1,4,4v19" class="cls-1" data-name="Rounded Rectangle 4" id="Rounded_Rectangle_4"/>
      <path transform="translate(-280 -996)" d="M347,1033h10a4,4,0,0,1,4,4v12" class="cls-1" data-name="Rounded Rectangle 4" id="Rounded_Rectangle_4-2"/>
      <path transform="translate(-280 -996)" d="M366,1045l-5,5-5-5" class="cls-1"/>
      <path transform="translate(-280 -996)" d="M316,1056h48a4,4,0,0,1,4,4v22a4,4,0,0,1-4,4H316a4,4,0,0,1-4-4v-22A4,4,0,0,1,316,1056Z" class="cls-2" data-name="Rounded Rectangle 4" id="Rounded_Rectangle_4-3"/>
    </g>
  </g>
</svg>  <span>Rotate orientation</span></li>

 <li class="left_device fix_width or-bar-devices horizontal"  data-screen="768" >  
 
 
 <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="24 39 87 46">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke-linecap: round;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-1 {
        stroke: #646b81;
      }

      .cls-2 {
        stroke: #e8ebf5;
      }
    </style>
  </defs>
  <g id="rotate-ver">
    <g>
      <path id="Rounded_Rectangle_4" data-name="Rounded Rectangle 4" class="cls-1" d="M567,1084h19a4,4,0,0,0,4-4v-22a4,4,0,0,0-4-4H567" transform="translate(-500 -996)"/>
      <path id="Rounded_Rectangle_4-2" data-name="Rounded Rectangle 4" class="cls-1" d="M584,1049v-10a4,4,0,0,0-4-4H568" transform="translate(-500 -996)"/>
      <path class="cls-1" d="M572,1030l-5,5,5,5" transform="translate(-500 -996)"/>
      <path id="Rounded_Rectangle_4-3" data-name="Rounded Rectangle 4" class="cls-2" d="M534,1028h22a4,4,0,0,1,4,4v48a4,4,0,0,1-4,4H534a4,4,0,0,1-4-4v-48A4,4,0,0,1,534,1028Z" transform="translate(-500 -996)"/>
    </g>
  </g>
</svg> <span>Rotate orientation</span></li>
<div class="right_device check_device" style="display:none;">
 
<div class="checkbox checkbox1 device_attach" name="custom_check">
       <label>
        <input type="checkbox" class="custom_check"/> Device Attachment
         <span> </span>
        </label>
      </div>
</div>
</ul>
   
   
   	<ul class="footer_width ab-top-secondary ab-top-menu or-top-toolbar three_twenty"  style="display:none;">
        <li class="left_device fix_width or-bar-devices vertical"  data-screen="480">  
         <svg viewBox="24 39 87 46" height="40" width="40" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke-linecap: round;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-1 {
        stroke: #646b81;
      }

      .cls-2 {
        stroke: #e8ebf5;
      }
    </style>
  </defs>
  <g id="rotate-hor">
    <g>
      <path transform="translate(-280 -996)" d="M312,1049v-19a4,4,0,0,1,4-4h22a4,4,0,0,1,4,4v19" class="cls-1" data-name="Rounded Rectangle 4" id="Rounded_Rectangle_4"/>
      <path transform="translate(-280 -996)" d="M347,1033h10a4,4,0,0,1,4,4v12" class="cls-1" data-name="Rounded Rectangle 4" id="Rounded_Rectangle_4-2"/>
      <path transform="translate(-280 -996)" d="M366,1045l-5,5-5-5" class="cls-1"/>
      <path transform="translate(-280 -996)" d="M316,1056h48a4,4,0,0,1,4,4v22a4,4,0,0,1-4,4H316a4,4,0,0,1-4-4v-22A4,4,0,0,1,316,1056Z" class="cls-2" data-name="Rounded Rectangle 4" id="Rounded_Rectangle_4-3"/>
    </g>
  </g>
</svg>  <span>Rotate orientation</span></li>

 <li class="left_device fix_width or-bar-devices horizontal"  data-screen="320" >  
 
 
 <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="24 39 87 46">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke-linecap: round;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-1 {
        stroke: #646b81;
      }

      .cls-2 {
        stroke: #e8ebf5;
      }
    </style>
  </defs>
  <g id="rotate-ver">
    <g>
      <path id="Rounded_Rectangle_4" data-name="Rounded Rectangle 4" class="cls-1" d="M567,1084h19a4,4,0,0,0,4-4v-22a4,4,0,0,0-4-4H567" transform="translate(-500 -996)"/>
      <path id="Rounded_Rectangle_4-2" data-name="Rounded Rectangle 4" class="cls-1" d="M584,1049v-10a4,4,0,0,0-4-4H568" transform="translate(-500 -996)"/>
      <path class="cls-1" d="M572,1030l-5,5,5,5" transform="translate(-500 -996)"/>
      <path id="Rounded_Rectangle_4-3" data-name="Rounded Rectangle 4" class="cls-2" d="M534,1028h22a4,4,0,0,1,4,4v48a4,4,0,0,1-4,4H534a4,4,0,0,1-4-4v-48A4,4,0,0,1,534,1028Z" transform="translate(-500 -996)"/>
    </g>
  </g>
</svg> <span>Rotate orientation</span></li>
<div class="right_device check_device" style="display:none;" >
 
<div class="checkbox checkbox1 device_attach" name="custom_check">
       <label>
        <input type="checkbox" class="custom_check"/> Device Attachment
         <span> </span>
        </label>
      </div>
</div>
</ul>
<div style="height: 0px;width: 0px;overflow:hidden;">
	<?php wp_editor( '', 'or-editor-preload', array( "wpautop" => false, "quicktags" => true ) ); ?>
</div>