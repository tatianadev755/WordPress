<?php
/**
*
*	 
*	(c) originbuilder.com
*
*/
if(!defined('or_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

global $or_front;
 
?>
<div id="or-element-placeholder" class="or-boxholder">
	<div class="mpb-tooltip move">
		<i data-action="delete" title="<?php _e( 'Delete this element', 'originbuilder' ); ?>" class="sl-close delete"></i>
		<span class="label" title="<?php _e( 'Drag & drop to arrange this element', 'originbuilder' ); ?>"></span>
	</div>
	<div class="mpb mpb-top">
		<span class="marginer" data-direct="top" data-value="0px" title="<?php _e('Hold and move to change margin','originbuilder'); ?>"></span>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<span class="marginer" data-direct="bottom" data-value="0px" title="<?php _e('Hold and move to change margin','originbuilder'); ?>"></span>
	</div>
	<div class="mpb mpb-left"></div>
</div>
<div id="or-row-placeholder" class="or-boxholder">
	<div class="mpb-tooltip move" title="<?php _e( 'Drag & drop to arrange rows', 'originbuilder' ); ?>">
		<i data-action="delete" title="<?php _e( 'Delete row', 'originbuilder' ); ?>" class="sl-close delete"></i>
		<span class="label"></span>
	</div>
	<div class="mpb mpb-top"></div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom"></div>
	<div class="mpb mpb-left"></div>
</div>
<div id="or-column-0-placeholder" class="or-boxholder" data-col-index="0">
	<div class="mpb mpb-top">
		<ul class="center top">
			<li class="tip" data-action="add-element">
			<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
			<li class="col-info">100%</li>
		</ul>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left"></div>
</div>
<div id="or-column-1-placeholder" class="or-boxholder" data-col-index="1">
	<div class="mpb mpb-top">
		<ul class="center top">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
			<li class="col-info">100%</li>
		</ul>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-element">
			<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left">
		<div class="handle-resize">
			<i class="fa-exchange" data-action="col-exchange" title="<?php _e( 'Exchange columns', 'originbuilder' ); ?>"></i>
		</div>
	</div>
</div>
<div id="or-column-2-placeholder" class="or-boxholder" data-col-index="2">
	<div class="mpb mpb-top">
		<ul class="center top">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
			<li class="col-info">100%</li>
		</ul>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left">
		<div class="handle-resize">
			<i class="fa-exchange" data-action="col-exchange" title="<?php _e( 'Exchange columns', 'originbuilder' ); ?>"></i>
		</div>
	</div>
</div>
<div id="or-column-3-placeholder" class="or-boxholder" data-col-index="3">
	<div class="mpb mpb-top">
		<ul class="center top">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
			<li class="col-info">100%</li>
		</ul>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left">
		<div class="handle-resize">
			<i class="fa-exchange" data-action="col-exchange" title="<?php _e( 'Exchange columns', 'originbuilder' ); ?>"></i>
		</div>
	</div>
</div>
<div id="or-column-4-placeholder" class="or-boxholder" data-col-index="4">
	<div class="mpb mpb-top">
		<ul class="center top">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
			<li class="col-info">100%</li>
		</ul>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-element">
				<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left">
		<div class="handle-resize">
			<i class="fa-exchange" data-action="col-exchange" title="<?php _e( 'Exchange columns', 'originbuilder' ); ?>"></i>
		</div>
	</div>
</div>
<div id="or-column-5-placeholder" class="or-boxholder" data-col-index="5">
	<div class="mpb mpb-top">
		<ul class="center top">
			<li class="tip" data-action="add-element">
			<!--<i class="sl-plus" ></i>-->
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
			<li class="col-info">100%</li>
		</ul>
	</div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-element">
			<!--<i class="sl-plus" ></i>-->
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus1.png" class="sl-plus blue_img"/>
				<span class="tips">
					<?php _e( 'Add element to column', 'originbuilder' ); ?>
				</span>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left">
		<div class="handle-resize">
			<i class="fa-exchange" data-action="col-exchange" title="<?php _e( 'Exchange columns', 'originbuilder' ); ?>"></i>
		</div>
	</div>
</div> 
<div id="or-sections-placeholder" class="or-boxholder">
	<div class="mpb-tooltip move">
		<i data-action="delete" title="<?php _e( 'Delete element', 'originbuilder' ); ?>" class="sl-close delete"></i>
		<span class="label"></span>
	</div>
	<div class="mpb mpb-top"></div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom">
		<ul class="center">
			<li class="tip" data-action="add-section">
				<!--<i class="sl-plus" ></i>-->
				<img  src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus black_img"/>
				<img   src="<?php echo or_URL; ?>/assets/images/w_plus.png" class="sl-plus blue_img"/>
				<?php _e( 'Add section', 'originbuilder' ); ?>
			</li>
		</ul>
	</div>
	<div class="mpb mpb-left"></div>
</div>
<div id="or-section-placeholder" class="or-boxholder">
	<div class="mpb mpb-top"></div>
	<div class="mpb mpb-right"></div>
	<div class="mpb mpb-bottom"></div>
	<div class="mpb mpb-left"></div>
</div>
<div id="or-overlay-placeholder"></div>
 
<div id="or-ui-handle-image">
<svg xmlns="http://www.w3.org/2000/svg" width="90" height="52" viewBox="0 0 90 52"  >
  <defs>
    <style>
      .cls-1 {
        fill: none;
        stroke: #000;
        stroke-width: 2px;
      }
    </style>
  </defs>
  <rect id="Rounded_Rectangle_3" data-name="Rounded Rectangle 3" class="cls-1" x="1" y="1" width="88" height="50" rx="5" ry="5"/>
</svg>
 </div>
<img  src="<?php echo or_URL; ?>/assets/images/drag-copy.png" id="or-ui-handle-image-copy" />
<script type="text/javascript">
	
	if( top.or === undefined )
		top.or = { front : {}, frame : {} };
	
	top.or.storage = <?php echo json_encode( $or_front->storage ); ?>;
	
	( function ( $ ) {
		
		top.or.frame = {
			doc : document,
			window : window,
			html : $('html').get(0),
			body : $('body').get(0),
			$ : jQuery
		}
		
		if( top.or.detect !== undefined )
			top.or.detect.frame = top.or.frame;
		
		$( document ).ready( function(){ 
							
			if( top.or.front === undefined || typeof(top.or.front.init) != 'function' )
				top.or.init_front_ready = true;
			else top.or.front.init();
			 
		  }).
		  on( 'mouseover', function( e ){ top.or.detect.hover(e) } ).
		  on( 'click', function( e ){ top.or.detect.click(e) } ).
		  on( 'dblclick', function( e ){ top.or.detect.dblclick(e) } );
					  
		top.or.do_callback = function( callback, el ){
			for( var i in callback )
				eval( '('+callback[i].callback.toString()+')( jQuery(\'[data-model="'+callback[i].model+'"]\'), jQuery, callback[i] );' );
		}
	
		
	}) ( jQuery );
	
</script>

