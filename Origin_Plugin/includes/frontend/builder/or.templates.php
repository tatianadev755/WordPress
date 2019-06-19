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
$or_maps = $or->get_maps();

?>
<script type="text/javascript">jQuery('#wpadminbar,#wpfooter,#adminmenuwrap,#adminmenuback,#adminmenumain,#screen-meta').remove();</script>
 
<div id="wpadminbar" class="origin_front">
    <a class="screen-reader-shortcut" href="#wp-toolbar" tabindex="1">Skip to toolbar</a>
    <div class="quicklinks" id="wp-toolbar" role="navigation" aria-label="Toolbar" tabindex="0">
        <ul class="ab-top-menu">
		<li class="template_btn mtips or_template_button" data-action="sections">
		<a href="#" class="black_temp">
	<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 120 120">
  <defs>
    <style>
      .cls-1 {
        fill: none;
        stroke: #292e38;
        stroke-width: 2px;
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <g id="templates">
    <path class="cls-1" d="M782,1037h18v12H782v-12Zm0,15h18v18H782v-18Zm-21-15h18v38H761v-38Z" transform="translate(-720 -996)"/>
  </g>
</svg></a>
<a href="#" class="blue_temp">
		<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 120 120">
  <defs>
    <style>
      .cls-1 {
        fill: none;
        stroke: #646b81;
        stroke-width: 2px;
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <g id="templates-hover">
    <path class="cls-1" d="M1002,1037h18v12h-18v-12Zm0,15h18v18h-18v-18Zm-21-15h18v38H981v-38Z" transform="translate(-940 -996)"/>
  </g>
</svg></a> <span class="mt-mes"><?php _e('Templates'); ?></span></li>
            <li id="or-bar-logo" class="menupop">
            	<a class="ab-item"  target=_blank href="#">
	            	<img src="<?php echo or_URL; ?>/assets/images/get_logo.png" height="25" />
	            <span>origin<span></a>
				
            </li>
            <li id="or-inspect-breadcrumns"></li>
        </ul>
        <ul id="or-top-toolbar" class="ab-top-secondary ab-top-menu or-top-toolbar">
            <li id="wp-admin-bar-exit" class="or-bar-save mtips">
                <div class="ab-item">
                	<a href="#exit" id="or-front-exit">
	                	<svg viewBox="30 30 60 60" height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>       .cls-1 {         fill: none;         stroke: #fff;         stroke-linecap: round;         stroke-width: 2px;         fill-rule: evenodd;       }     </style>
  </defs>
  <g id="close-modal">
    <path transform="translate(-1380 -996)" d="M1455,1042l-29,29" class="cls-1"/>
    <path transform="translate(-1380 -996)" d="M1426,1042l29,29" class="cls-1"/>
  </g>
</svg>
	                </a>
                </div>
                <span class="mt-mes"><?php _e('Exit editor', 'originbuilder'); ?></span>
            </li>
           
			<li id="wp-admin-bar-save" class="or-bar-save">
                <div class="ab-item">
                	<a href="#save" id="or-front-save"> <?php _e('Save page', 'originbuilder'); ?></a>
                </div>
            </li>  
<li id="help" class="or-help mtips">
                <div class="ab-item"><a href="http://originbuilder.net/product/basic" target="_blank">
                	<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 120 120">
  <defs>
    <style>
      .cls-1 {
        fill: #525f6f;
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <g id="help">
    <path id="_" data-name="?" class="cls-1" d="M779.246,640.474a1.955,1.955,0,0,0-.532,1.446,1.851,1.851,0,0,0,.532,1.369,1.659,1.659,0,0,0,2.435,0,1.855,1.855,0,0,0,.532-1.369,1.884,1.884,0,0,0-.57-1.446,1.731,1.731,0,0,0-1.179-.532A1.68,1.68,0,0,0,779.246,640.474Zm1.9-15.594a18.123,18.123,0,0,1,.266-3.271,9,9,0,0,1,.951-2.7,13.437,13.437,0,0,1,1.9-2.587,29.457,29.457,0,0,1,3.195-2.928q1.37-1.141,2.586-2.321a16.226,16.226,0,0,0,2.168-2.586,12.42,12.42,0,0,0,1.522-3.195,13.944,13.944,0,0,0,.57-4.222,13.462,13.462,0,0,0-1.065-5.515,11.3,11.3,0,0,0-2.967-4.031,13.527,13.527,0,0,0-4.412-2.511,16.1,16.1,0,0,0-5.324-.875,14.352,14.352,0,0,0-9.433,3.195,14.7,14.7,0,0,0-4.945,9.129l1.6,0.3a13.722,13.722,0,0,1,4.108-7.873,11.918,11.918,0,0,1,8.519-3.081,15.416,15.416,0,0,1,4.755.723,11.165,11.165,0,0,1,3.917,2.168,10.114,10.114,0,0,1,2.625,3.575,11.845,11.845,0,0,1,.951,4.868,12.422,12.422,0,0,1-.419,3.424,10.673,10.673,0,0,1-1.141,2.624A14.077,14.077,0,0,1,789.4,609.4q-0.952,1.028-2.092,2.092l-2.587,2.282a14.921,14.921,0,0,0-2.7,2.624,12.389,12.389,0,0,0-1.6,2.663,10.545,10.545,0,0,0-.76,2.624,17.239,17.239,0,0,0-.19,2.51v4.032h1.673V624.88Z" transform="translate(-720 -556)"/>
  </g>
</svg>
                </a></div><span class="mt-mes"><?php _e(' Help ', 'originbuilder'); ?></span>
            </li>
			 
             <li id="or-enable-inspect" class="mtips" data-screen="custom">
			
            	<span class="edit_label">Edit</span>
				<i class="toggle"></i>
				 <span class="edit_prev">Preview</span>
            	<span class="mt-mes"><?php _e('Edit / Preview mode', 'originbuilder'); ?></span>
            </li>
			
            <li id="or-bar-desktop-view" data-screen="100%" class="or-bar-devices active mtips">
			<svg viewBox="0 0 120 120" height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke: #3a4054;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-2 {
        opacity: 0.3;
      }
    </style>
  </defs>
  <g id="desktop">
    <g>
      <path transform="translate(-1160 -556)" d="M1185.91,584.906h69.18a4,4,0,0,1,4,4v42.813a4,4,0,0,1-4,4h-69.18a4,4,0,0,1-4-4V588.906A4,4,0,0,1,1185.91,584.906Z" class="cls-1" data-name="Rounded Rectangle 2" id="Rounded_Rectangle_2"/>
      <path transform="translate(-1160 -556)" d="M1258.53,625.209h-76.06" class="cls-2" data-name="Rounded Rectangle 2" id="Rounded_Rectangle_2-2"/>
      <path transform="translate(-1160 -556)" d="M1233.07,635.813l4.33,7.8c1.02,1.837-.52,3.5-3.57,3.5h-26.65c-3.05,0-4.59-1.659-3.57-3.5l4.33-7.8" class="cls-1" data-name="Rounded Rectangle 2" id="Rounded_Rectangle_2-3"/>
    </g>
  </g>
</svg>
				<span class="mt-mes"><?php _e('Desktop view', 'originbuilder'); ?></span>
            </li>
            <li id="or-bar-tablet-view" data-screen="768" class="or-bar-devices mtips">
				<svg viewBox="0 0 120 120" height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke: #3a4054;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-2 {
        opacity: 0.3;
      }
    </style>
  </defs>
  <g id="tablet">
    <path transform="translate(-1160 -776)" d="M1189,808h63a4,4,0,0,1,4,4v49a4,4,0,0,1-4,4h-63a4,4,0,0,1-4-4V812A4,4,0,0,1,1189,808Z" class="cls-1" data-name="Rounded Rectangle 2" id="Rounded_Rectangle_2"/>
    <path transform="translate(-1160 -776)" d="M1193.03,814.375h54.94v44.25h-54.94v-44.25Z" class="cls-2" data-name="Rounded Rectangle 2" id="Rounded_Rectangle_2-2"/>
  </g>
</svg>
				<span class="mt-mes"><?php _e('Tablet view', 'originbuilder'); ?></span>
            </li>
           <!-- <li id="or-bar-mobile-landscape-view" data-screen="667" class="or-bar-devices mtips">
				<i class="fa-mobile"></i>
				<span class="mt-mes"><?php //_e('Mobile Mode', 'originbuilder'); ?> (landscape 667px)</span>
            </li>-->
            <li id="or-bar-mobile-view" data-screen="320" class="or-bar-devices mtips">
				<svg viewBox="0 0 120 120" height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <style>
      .cls-1, .cls-2 {
        fill: none;
        stroke: #3a4054;
        stroke-width: 2px;
        fill-rule: evenodd;
      }

      .cls-2 {
        opacity: 0.3;
      }
    </style>
  </defs>
  <g id="mobile">
    <g>
      <path transform="translate(-1160 -996)" d="M1194.25,1040.25h51.5a4,4,0,0,1,4,4v23.5a4,4,0,0,1-4,4h-51.5a4,4,0,0,1-4-4v-23.5A4,4,0,0,1,1194.25,1040.25Z" class="cls-1" data-name="Rounded Rectangle 2" id="Rounded_Rectangle_2"/>
      <path transform="translate(-1160 -996)" d="M1200.07,1071.06v-30.12" class="cls-2"/>
      <path transform="translate(-1160 -996)" d="M1242,1071v-30" class="cls-2"/>
    </g>
  </g>
</svg>
				<span class="mt-mes"><?php _e('Mobile view', 'originbuilder'); ?></span>
            </li>
            
        </ul>
		
    </div>
</div>
<div id="or-tours">
	<div id="or-tour-show"></div>
	<ul id="or-tour-nav">
		<li class="label"><?php _e('Quick Guide', 'originbuilder'); ?></li>
		<li class="active" data-media="http://service.originbuilder.com/guide/tour/inspect.jpg">Inspect elements</li>
		<li data-media="http://service.originbuilder.com/guide/tour/add_element.jpg">Add Element</li>
		<li data-media="http://service.originbuilder.com/guide/tour/edit.jpg">Edit Element, row, column</li>
		<li data-media="http://service.originbuilder.com/guide/tour/nested_column.jpg">Nested Rows & Columns</li>
		<li data-media="http://service.originbuilder.com/guide/tour/columns.jpg">Add, remove, change width, exchange columns</li>
		<li data-media="http://service.originbuilder.com/guide/tour/copy.jpg">Copy & paste element, row</li>
		<li data-media="http://service.originbuilder.com/guide/tour/dummy_content.jpg">Dummy contents (sample)</li>
		<li data-media="http://service.originbuilder.com/guide/tour/responsive.jpg">Responsive</li>
		<li data-media="http://service.originbuilder.com/guide/tour/css_box.jpg">CSS Box</li>
		<li data-media="http://service.originbuilder.com/guide/tour/tabs.jpg">New Tab/Accordion</li>
	</ul>
	<div id="or-tour-close">
		<span id="tour-follows">
			Follow us: 
			<a href="https://facebook.com/originbuilder" target=_blank>
				<i class="fa-facebook"></i>
			</a>
			<a href="https://twitter.com/originbuilder" target=_blank>
				<i class="fa-twitter"></i>
			</a>
		</span>
		<i class="fa-times"></i>
		<a href="#" id="or-tour-nope"><?php _e('Don\'t show again', 'originbuilder'); ?> |</a>
		<a href="#" class="tour-prev">Prev</a>
		<a href="#" class="tour-next">Next</a>
	</div>
</div>
<div id="or-as-to-buy" class="hidden">
	<div id="or-welcome" class="or-preload-body enter-license">
		<h3><?php printf( __( 'Oops, hold on a sec!', 'originbuilder' ), '<br />' ); ?></h3>
		<div class="or-pl-form">
			<p class="notice">
				<?php _e( 'You need to verify your license key to do this action and use full of all another premium features.', 'originbuilder' ); ?>
			</p>
			<input type="hidden" value="<?php echo wp_create_nonce( "or-verify-nonce" ); ?>" name="sercurity" />
			<input type="text" value="" placeholder="<?php _e('Enter your license key', 'originbuilder'); ?>" name="or-license-key" />
			<br />
			<p><?php  printf( __( 'If you\'ve got one %s to login and copy the license', 'originbuilder' ), '<a href="https://originbuilder.com/my-account/" target=_blank>Click Here</a>' ); ?></p>
		</div>
		<a href="#" class="enter close"><i class="sl-close"></i></a>
		<div id="or-preload-footer">
			<a href="https://originbuilder.com#pricing" target=_blank class="button gray left"><?php _e('Buy the license', 'originbuilder'); ?> <i class="fa-shopping-cart"></i></a>
			<a class="button verify right"><?php _e('Verify your license', 'originbuilder'); ?> <i class="fa-unlock-alt"></i></a>
		</div>
	</div>
</div>
<?php 
	
	foreach( $or_maps as $name => $map ){
		
		if( isset( $map['live_editor'] ) && is_file( $map['live_editor'] ) ){
			echo '<script type="text/html" id="tmpl-or-'.esc_attr( $name ).'-template">';
			@include( $map['live_editor'] );
			echo '</script>';
		} 
	} 

?>
