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
	
?>
<script type="text/html" id="tmpl-or-container-template">
	<div id="or-container" <# if( or.cfg.showTips == 0 ){ #>class="hideTips"<# } #>>
		<div id="or-controls">
			<button class="button button-large red classic-mode">
				<!--<i class="sl-action-undo"></i> -->
				<img class="sl-action-undo black_img" src="<?php echo or_URL; ?>/assets/images/back.png " />
				<img class="sl-action-undo blue_img" src="<?php echo or_URL; ?>/assets/images/back1.png" />
				<span><?php _e('Basic editor', 'originbuilder'); ?></span>
			</button>
			
			
			<button class="button button-large green live-editor">
				<!--<i class="sl-paper-plane"></i> -->
				<img class="sl-action-undo black_img" src="<?php echo or_URL; ?>/assets/images/get_logo_w.png" />
				<img class="sl-action-undo blue_img" src="<?php echo or_URL; ?>/assets/images/get_logo_b.png" />
				<span><?php  _e('Frontend editor', 'originbuilder'); ?></span>
			</button>
		 
		 	<button class="button button-large green live-template or-add-sections dublicate" data-action="sections" style="display:none">
			 
				<span><?php _e('Duplicate template', 'originbuilder'); ?></span>
			</button>
		 
			<li class="button button-large green live-template or-add-sections" data-action="sections">
				<!--<i class="sl-paper-plane"></i> -->
				<img class="sl-settings black_img" src="<?php echo or_URL; ?>/assets/images/template_w@2x.png" />
				<img class="sl-settings blue_img" src="<?php echo or_URL; ?>/assets/images/template_b@2x.png" />
				<span><?php _e('Templates', 'originbuilder'); ?></span>
			</li>
			<div class="button button-large green help">
				<!--<i class="sl-paper-plane"></i> -->
				<a href="http://originbuilder.net/product/basic" class="black_a" target="_blank"><img class="black_img" src="<?php echo or_URL; ?>/assets/images/g_h.png" /> 
			   <img class="blue_img" src="<?php echo or_URL; ?>/assets/images/g_h1.png" />
			   <span><?php _e('Help', 'originbuilder'); ?></span>
			   </a>			
			</div>
			<?php /*<button class="button button-large alignright post-settings">
				<i class="sl-settings"></i> <?php _e('Content Settings', 'originbuilder'); ?>
			</button>
			<span class="alignright inss" <# if( or.cfg.instantSave == 0 ){ #>style="display: none;"<# } #>>
				<?php _e('Press Ctrl + S to quick save', 'originbuilder'); ?>
			</span>*/?>
		</div>
		
		<div id="or-rows">
		<div class="start_img empty_guide" style="display:none;">
		<h2>Hey there! It seems there's nothing to display here.</h2>
         <span>Start building your contents by adding a row below.</span>
				<img class="" src="<?php echo or_URL; ?>/assets/images/bg_empty.png" />
				 </div>	 </div>	 
		
		<div id="or-footers">
			<ul>
					<li class="basic-add">
					<span class="m-a-tips"><?php _e('Browse all elements', 'originbuilder'); ?></span>
				</li>
				<li class="one-column quickadd" data-content='[or_row][/or_row]'>
					<span class="grp-column"></span>
					<span class="m-a-tips"><?php _e('New row - 1 column', 'originbuilder'); ?></span>
				</li>
			
				<li class="two-columns quickadd" data-content='[or_row][or_column width="6/12"][/or_column][or_column width="6/12"][/or_column][/or_row]'>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="m-a-tips"><?php _e('New row - 2 column', 'originbuilder'); ?></span>
				</li>
				<li class="three-columns quickadd" data-content='[or_row][or_column width="4/12"][/or_column][or_column width="4/12"][/or_column][or_column width="4/12"][/or_column][/or_row]'>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="m-a-tips"><?php _e('New row - 3 column', 'originbuilder'); ?></span>
				</li>
				<li class="four-columns quickadd" data-content='[or_row][or_column width="3/12"][/or_column][or_column width="3/12"][/or_column][or_column width="3/12"][/or_column][or_column width="3/12"][/or_column][/or_row]'>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="m-a-tips"><?php _e('New row - 4 column', 'originbuilder'); ?></span>
				</li>
				<li class="five-columns quickadd" data-content='[or_row][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][or_column width="1/5"][/or_column][/or_row]'>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="m-a-tips"><?php _e('New row - 5 column', 'originbuilder'); ?></span>
				</li>
				<li class="six-columns quickadd" data-content='[or_row][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][or_column width="2/12"][/or_column][/or_row]'>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="grp-column"></span>
					<span class="m-a-tips"><?php _e('New row - 6 column', 'originbuilder'); ?></span>
				</li>
				<li class="column-text quickadd" data-content="custom">
					<i class="et-document"></i>
					<span class="m-a-tips"><?php _e('Push customized content and shortcodes', 'originbuilder'); ?></span>
				</li>
				<li class="title quickadd" data-content='paste'>
					<i class="et-clipboard"></i>
					<span class="m-a-tips"><?php _e('Paste copied element', 'originbuilder'); ?></span>
				</li>
				<li class="or-add-sections">
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
	</div>	
</script>
<script type="text/html" id="tmpl-or-clipboard-template">
	<div id="or-clipboard">
		<ul class="ms-funcs">
			<li class="delete button delete left">
				<?php _e('Delete selected items', 'originbuilder'); ?> 	<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close">
			</li>
			<li class="select button left">
				<?php _e('Select all items', 'originbuilder'); ?> <i class="sl-check"></i>
			</li>
			<li class="unselect button left ">
				<?php _e('Unselect all items', 'originbuilder'); ?> 	<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close">
			</li>
			<li class="latest button prime">
				<?php _e('Paste latest item', 'originbuilder'); ?> <i class="sl-clock"></i>
			</li>
			<li class="paste button">
				<?php _e('Paste selected items', 'originbuilder'); ?> <i class="sl-check"></i>
			</li>
			<li class="pasteall button">
				<?php _e('Paste all items', 'originbuilder'); ?> <i class="sl-list"></i>
			</li>
		</ul>
		<#
		try{
			var clipboards = or.backbone.stack.get( 'or_ClipBoard' ), 
				outer = '<div style="text-align:center;margin:20px auto;"><?php _e('The ClipBoard is empty, Please copy elements to clipboard', 'originbuilder'); ?>.</div>';
			
			if( clipboards.length > 0 ){
				
				var stack, map, li = '';
					
				for( var n in clipboards ){
					if( clipboards[n] != null && clipboards[n] != undefined ){
						
						stack = clipboards[n];
						map = or.maps[stack.title];
						
						li += '<li data-sid="'+n+'" title="Copy from page: '+stack.page+'">';
						if( map != undefined ){
							if( map['icon'] != undefined )
								li += '<span class="ms-icon cpicon '+map['icon']+'"></span>';
						}
						li += '<span class="ms-title">'+stack.title.replace(/\_/g,' ').replace(/\-/g,' ')+'</span>';
						li += '<span class="ms-des">'+or.tools.unesc(stack.des)+'</span>';
						li += '</li>';
						
					}
				}
				
			}
		}catch(e){console.log(e);}	
		#>
		<ul class="ms-list">{{{li}}}</ul>
		<br />
		<span class="ms-tips">
			<strong><?php _e('Tips', 'originbuilder'); ?>:</strong> 
			<?php _e('Drag and drop to arrange items, click to select an item. Read more', 'originbuilder'); ?> 
			<a href="<?php echo esc_url('http://docs.originbuilder.com/documentation/copy-cut-double-paste-for-element-column-row/?source=client_installed'); ?>" target="_blank"><?php _e('Document', 'originbuilder'); ?></a>
		</span>
	</div>
	<# 
		data.callback = or.ui.clipboard;
	#>
</script>
<script type="text/html" id="tmpl-or-post-settings-template">
	<div id="or-page-settings">
		<h1 class="mgs-t02">
			<?php _e('Page Settings', 'originbuilder'); ?>
		</h1>
		<button class="button pop-btn save-post-settings"><?php _e('Save', 'originbuilder'); ?></button>
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Body Class', 'originbuilder'); ?></label>
				<span><?php _e('The class will be added to body tag on the front-end', 'originbuilder'); ?> </span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<input class="or-post-classes-inp" type="text" placeholder="Body classes" value="{{data.classes}}" />
				</div>
			</div>
		</div>
		<div class="m-settings-row">
			<div class="msr-left msr-single">
				<label><?php _e('Css Code', 'originbuilder'); ?></label>
				<button class="button button-larger css-beautifier float-right">
					<i class="sl-energy"></i> <?php _e('Beautifier', 'originbuilder'); ?>
				</button>
				<textarea class="rt03 or-post-css-inp">{{data.css}}</textarea>
				<i><?php _e('Notice: CSS must contain selectors', 'originbuilder'); ?></i>
			</div>
		</div>
		
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Scroll Assistant', 'originbuilder'); ?></label>
				<span>
					<?php _e('Keep the viewport in a reasonable place while a popup is opened', 'originbuilder'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<div class="or-el-ui meu-boolen" data-cfg="scrollAssistive" data-type="radio" onclick="or.ui.elms(event,this)">
						<ul>
							<li<# if(or.cfg.scrollAssistive==1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="1" />
							</li>
							<li<# if(or.cfg.scrollAssistive!=1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="0" />
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Scroll Prevention', 'originbuilder'); ?></label>
				<span>
					<?php _e('Keep the web page unmoved while scrolling a popup', 'originbuilder'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<div class="or-el-ui meu-boolen" data-cfg="preventScrollPopup" data-type="radio" onclick="or.ui.elms(event,this)">
						<ul>
							<li<# if(or.cfg.preventScrollPopup==1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="1" />
							</li>
							<li<# if(or.cfg.preventScrollPopup!=1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="0" />
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Tooltips display', 'originbuilder'); ?></label>
				<span>
					<?php _e('A brief description will appear when you hover the function icon', 'originbuilder'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<div class="or-el-ui meu-boolen showTipsCfg" data-cfg="showTips" data-type="radio">
						<ul>
							<li<# if(or.cfg.showTips==1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="1" />
							</li>
							<li<# if(or.cfg.showTips!=1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="0" />
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Instant Save', 'originbuilder'); ?></label>
				<span>
					<?php _e('Press Ctrl + S to save changes immediately without reloading the builder', 'originbuilder'); ?>.
					<br />
					<?php _e('Even When you are editting an element, do not need to close editing popup', 'originbuilder'); ?>.
					<br />
					<?php _e('Notice: This function isn’t activated when you are typing in an input box or textarea', 'originbuilder'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<div class="or-el-ui meu-boolen instantSaveCfg" data-cfg="instantSave" data-type="radio">
						<ul>
							<li<# if(or.cfg.instantSave==1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="1" />
							</li>
							<li<# if(or.cfg.instantSave!=1){ #> class="active"<# } #>>
								<input type="radio" name="m-c-layout" value="0" />
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<#
		data.callback = function( wrp, $ ){
			
			wrp.find('.save-post-settings').on( 'click', wrp, function(e){
				
				$('#or-page-body-classes').val( e.data.find('input.or-post-classes-inp').val() );
				$('#or-page-css-code').val( e.data.find('textarea.or-post-css-inp').val() );
				
				or.get.popup( this, 'close' ).trigger('click');
				
			});
			
			wrp.find('.css-beautifier').on( 'click', function(){
				var txta = $(this).parent().find('textarea');
				txta.val( or.tools.decode_css( txta.val() ) );
			});
			
			wrp.find('.showTipsCfg').on( 'click', function(event){
				or.ui.elms( event, this );
				if( or.cfg.showTips == 1 )
					$('#or-container').removeClass('hideTips');
				else $('#or-container').addClass('hideTips');
			});
			
			wrp.find('.instantSaveCfg').on( 'click', function(event){
				or.ui.elms( event, this );
				if( or.cfg.instantSave == 1 )
					$('#or-controls .inss').show();
				else $('#or-controls .inss').hide();
			});
		}
	#>
</script>
<script type="text/html" id="tmpl-or-global-sections-template">
<#

	var stg = data.stg, from = data.from, to = data.to, label = data.label, html = '';

	if( stg.length > 0 )
	{
		
		if( from >= to )
			from = 0;
	
		if( stg.length < to )
			to = stg.length;
		
		var n = 0;
		
		for( var i=from; i<to; i++ ){
			
			if( stg[i] != null )
			{
				n++;
				if( stg[i].screenshot == '' )
					stg[i].screenshot = or.cfg.defaultImg;
				
				stg[i].sid = i;
				stg[i].label = label;
				stg[i].n = n;
				html += or.template( 'global-section', stg[i] );
			}
		}		
		
		if( to < stg.length)
		{
			html += '<button class="button load-more" data-label="'+label+'" data-from="'+to+
					'" data-to="'+(or.cfg.sectionsPerpage+to)+'">'+
					'<?php _e('Load More', 'originbuilder'); ?> <i class="fa fa-caret-down"></i></button>'
		}
		#>{{{html}}}<#
	}
	else
	{
		#>
			<div class="msg-emptylist">
				<?php _e('Currently no sections in this profile', 'originbuilder'); ?> <strong>{{or.cfg.profile}}</strong>
				<br />
				<?php 
					printf( __('Please add New Section or %s', 'originbuilder'),
					'<a href="#" onclick="or.ui.gsections.showDownload(this)">select another profile</a>'
				); ?>.
				<br />
				<br />
				<p>
					<img src="<?php echo or_URL; ?>/assets/images/new_section.png" width="473" />
				</p>
			</div>
		<#	   
	}	
	
#>
</script>
<script type="text/html" id="tmpl-or-global-section-template">
<div class="mgs-scale-min mgs-section-item<#
	if( data.category !== undefined ){
		var cats = data.category.split(',');
		for( var i in cats ){
			#> category-{{or.tools.esc_slug(cats[i].trim())}}<#
		}
	}
#> mgs-section-{{data.id}}">
	<a href="#or-install" class="mgs-si-sceenshot">
		<img data-sid="{{data.id}}" src="{{{data.screenshot}}}" alt="" class="mgs-sel-sceenshot" />
		<span data-sid="{{data.id}}" class="mgs-sel-sceenshot" data-status="{{data.status}}" data-imageids="{{data.imageids}}">
			{{data.label}}
		</span>
		<i class="fa fa-refresh fa-spin fa-3x fa-fw or_loadingicon"></i>
	</a>
	<div class="mgs-si-info">
		<span>{{data.title}}</span><i>{{data.category}}</i>
		<div class="mgs-si-funcs">
			<a class="edit-section" href="<?php echo admin_url('admin.php?page=or-sections-manager'); ?>&id={{data.id}}" target="_blank">
				<i title="<?php _e('Edit this section', 'originbuilder'); ?>" class="sl-pencil edit-section"></i>
			</a>
			<a href="#delete" data-sid="{{data.id}}" class="mgs-delete" title="<?php _e('Delete this section', 'originbuilder'); ?>"></a>
		</div>
	</div>
</div>
</script>
<script type="text/html" id="tmpl-or-add-global-sections-template">
	<div id="or-global-sections" class="or-add-sections">
		<div class="mgs-select-section">
			<h1 class="mgs-t01"><?php _e('Add to an available section', 'originbuilder'); ?></h1>
			<select class="filter-by-category">
				<option value=""> -- <?php _e('Filter by Category', 'originbuilder'); ?> -- </option>
				<#
					var cats = or.ui.gsections.get_cats();
					for( var i in cats ){
						if( i !== undefined && i.trim() != '' ){
							#><option value="{{i}}">{{i}} ({{cats[i]}})</option><#
						}
					}
				#>
			</select>
			<div class="mgs-select-wrp">
				{{{or.ui.gsections.load( '<?php _e('Add to this section', 'originbuilder'); ?>', 0, or.cfg.sectionsPerpage )}}}
			</div>
		</div>
		<div class="mgs-create-new">
			<div class="mgs-cn-row">
				<h1><?php _e('Create a new section', 'originbuilder'); ?></h1>
				<input class="mgs-title" type="text" placeholder="<?php _e('Enter title', 'originbuilder'); ?>" value="" spellcheck="true" autocomplete="off" />
			</div>
			<div class="mgs-cn-row mgs-category">
				<input  class="mgs-category" type="text" placeholder="<?php _e('Enter category name', 'originbuilder'); ?>" value="" spellcheck="true" autocomplete="off" />
				<div class="mgs-tips">
					<ul>
						<#
							var cats = or.ui.gsections.get_cats();
							if( Object.keys(cats).length > 0 ){
								for( var i in cats ){
									if( typeof( i ) != 'undefined' && i != '' ){
										#><li data-name="{{i}}"><i class="fa fa-caret-right"></i> {{i}} ({{cats[i]}})</li><#
									}
								}
							}else{
								#><li data-name="first category"><i class="fa fa-caret-right"></i> First Category</li><li></li><#
							}
						#>
					</ul>
				</div>	
			</div>
			<div class="mgc-cn-screenshot"></div>
			<button class="create-section">
				<?php _e('Create Now', 'originbuilder'); ?> 
				<i class="sl-check"></i>
			</button>
		</div>
		<div class="mgs-confirmation">
			<div class="mgs-c-status">
				<i class="et-caution"></i>
				<i class="et-happy"></i>
				<i class="et-sad"></i>
			</div>
			<br />
			<h1 class="mgs-t02"></h1>
			<h2></h2>
			<ul class="btns">
				<li>
					<button class="button button-large back">
						<i class="sl-action-undo"></i> <?php _e('Go Back', 'originbuilder'); ?>
					</button>
					<button class="button button-large button-primary apply">
						<i class="sl-check"></i> <?php _e('Apply Now', 'originbuilder'); ?>
					</button>
					<button class="button button-large button-primary close">
							<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close"><?php _e('Close Popup', 'originbuilder'); ?>
					</button>
				</li>
			</ul>
		</div>
	</div>
	<# 
		data.callback = or.ui.gsections.add_actions;
	#>
</script>
<script type="text/html" id="tmpl-or-install-global-sections-template">
	<div id="or-global-sections" class="or-install-sections">
		<div class="mgs-menus">
			<ul>
				<li class="mgs-menu-download mtips mtips-right <# if(data.list=='no'){ #> active<# } #>" data-active="mgs-download-section">
					<i class="et-notebook"></i>
					<span class="mt-mes"><?php _e('List profiles', 'originbuilder'); ?></span>
				</li>
				<# if(data.list!='no'){ #>
				<li class="mgs-menu-list mtips mtips-right active" data-active="mgs-select-section">
					<i class="et-document"></i>
					<span class="mt-mes"><?php _e('List sections of activated profile', 'originbuilder'); ?></span>
				</li>
				<# } #>
				<li class="mgs-menu-upload mtips mtips-right" data-active="mgs-upload-section">
					<i class="et-upload"></i>
					<span class="mt-mes"><?php _e('Upload profile or create new profile', 'originbuilder'); ?></span>
				</li>
				<li class="mgs-menu-settings mtips mtips-right" data-active="mgs-settings-section">
					<i class="et-gears"></i>
					<span class="mt-mes"><?php _e('Settings', 'originbuilder'); ?></span>
				</li>
			</ul>
		</div>
		<div class="mgs-download-section"<# if(data.list=='no'){ #> style="display:block;"<# } #>>
			<h1 class="mgs-t01"><?php _e('Profiles', 'originbuilder'); ?></h1>
			<a href="#" class="mgs-add-prof"><?php _e('Add new Profile', 'originbuilder'); ?></a>
			<span class="mgs-4rs2"><?php _e('You are using profile: ', 'originbuilder'); ?><span class="msg-profile-label-display">{{or.cfg.profile}}</span></span>
			<div class="mgs-download-main or-scroll">
				<ul>
				<#
					for( var i in or_profiles ){
				#>
					<li<# if(i==or.cfg.profile_slug){ #> class="active"<# } #>>
						<span>{{or_profiles[i]}}</span>
						<span data-path="{{i}}" class="msg-download-action" title="{{or_profiles[i]}}">
							<?php _e('Use this profile', 'originbuilder'); ?>
						</span>
						<a href="#" data-slug="{{i}}" title="<?php _e('Delete this profile', 'originbuilder'); ?>" class="mgs-delete-profile"></a>
						<a href="#" data-name="{{i}}" title="<?php _e('Refresh profile', 'originbuilder'); ?>" class="mgs-refresh-profile"><i class="sl-refresh"></i></a>
						<a href="#" data-slug="{{i}}"  data-name="{{or_profiles[i]}}" title="<?php _e('Rename this profile', 'originbuilder'); ?>" class="mgs-edit-profile">
							<i class="et-pencil"></i>
						</a>
						<a download="{{i}}.or" href="<?php echo admin_url('admin-ajax.php?action=or_download_profile&name=') ?>{{i}}" title="<?php _e('Download this profile', 'originbuilder'); ?>" class="mgs-download-direct"></a>
						</li>
				<#
					}
				#>
				
				<#
					for( var i in or_profiles_external ){
						
						var path = or_profiles_external[i],
							base = or.tools.basename( path );
				#>
					<li<# if( i == or.cfg.profile_slug || base == or.cfg.profile_slug ){ #> class="active"<# } #>>
						<span>{{base.replace(/\-/g,' ')}}</span>
						<span data-path="{{i}}" class="msg-download-action" title="{{base.replace(/\-/g,' ')}}">
							<?php _e('Use this profile', 'originbuilder'); ?>
						</span>
						<i class="msg-external"><?php _e('External','originbuilder'); ?></i>
						<a download="{{i}}.or" href="<?php echo site_url('/'); ?>{{path}}" title="<?php _e('Download this profile', 'originbuilder'); ?>" class="mgs-download-direct"></a>
						</li>
				<#
					}
				#>

				</ul>
				<br />
				<?php _e('What is external profile?', 'originbuilder'); ?>
				<a href="http://docs.originbuilder.com/documentation/locate-your-sections-profile/" target="_blank"><?php _e('Check Document', 'originbuilder'); ?></a>
			</div>
			<div class="mgs-sub-confirmation">
				<h2><?php _e('Are you sure?', 'originbuilder'); ?></h2>
				<button class="button back">
					<i class="sl-action-undo"></i> <?php _e('Cancel', 'originbuilder'); ?>
				</button> 
				<button class="button button-primary apply">
					<i class="sl-arrow-down-circle"></i> <?php _e('Yes, do it please!', 'originbuilder'); ?> 
				</button>
			</div>
		</div>
		<# if(data.list!='no'){ #>
		<div class="mgs-select-section">
			<h1 class="mgs-t01">
				<?php _e('Sections', 'originbuilder'); ?>
			</h1>
			<select class="filter-by-category">
				<option value=""> -- <?php _e('Filter by Category', 'originbuilder'); ?> -- </option>
				<#
					var cats = or.ui.gsections.get_cats();
					for( var i in cats ){
						if( i !== undefined && i.trim() != '' ){
							#><option value="{{i}}">{{i}} ({{cats[i]}})</option><#
						}
					}
				#>
			</select>
			<input type="search" class="filter-by-name" placeholder="<?php _e('Search by name', 'originbuilder'); ?>" />
			<img src="<?php echo or_URL; ?>/assets/images/search.png" class="sl-magnifier search_bar">
			<div class="mgs-layout-btns">
				<i data-layout="list" class="sl-list<# if(or.cfg.sectionsLayout=='list'){ #> active<# } #>"></i>
				<i data-layout="grid" class="sl-grid<# if(or.cfg.sectionsLayout=='grid'){ #> active<# } #>"></i>
			</div>
			<div data-label="<?php _e('Use this template', 'originbuilder'); ?>" class="mgs-select-wrp layout-{{or.cfg.sectionsLayout}}">
				{{{or.ui.gsections.load( '<?php _e('Use this template', 'originbuilder'); ?>', 0, or.cfg.sectionsPerpage )}}}
			</div>
		</div>
		<# } #>
		<div class="mgs-confirmation">
			<div class="mgs-c-status">
				<i class="et-caution"></i>
				<i class="et-happy"></i>
				<i class="et-sad"></i>
			</div>
			<br />
			<h1 class="mgs-t02"></h1>
			<h2></h2>
			<ul class="btns">
				<li>
					<button class="button button-large back">
						<i class="sl-action-undo"></i> <?php _e('Go Back', 'originbuilder'); ?>
					</button>
					<button class="button button-large button-primary apply">
						<i class="sl-check"></i> <?php _e('Apply Now', 'originbuilder'); ?>
					</button>
					<button class="button button-large button-primary close">
						<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close"> <?php _e('Close Popup', 'originbuilder'); ?>
					</button>
				</li>
			</ul>
		</div>
		<div class="mgs-upload-section">
			<div class="mgs-upload-main">
				<div class="mgs-left-side">
					<h1 class="mgs-t02"><?php _e('Upload profile', 'originbuilder'); ?></h1>
					<br />
					<p>
						<input type="file" class="msg-upload-profile-input" />
					</p>
					<button class="button button-primary uploadNow"><?php _e('Upload Now', 'originbuilder'); ?></button>
				</div>
				<div class="mgs-right-side">
					<h1 class="mgs-t02"><?php _e('New profile', 'originbuilder'); ?></h1>
					<br />
					<p>
						<input class="msg-new-profile-input" type="text" placeholder="Enter profile name" />
					</p>
					<button class="button button-primary createNew"><?php _e('Create Now', 'originbuilder'); ?></button>
				</div>
			</div>
		</div>
		<div class="mgs-settings-section or-scroll">
			<h1 class="mgs-t02 alignleft">
				<?php _e('Quick Settings Builder', 'originbuilder'); ?>
				<span><?php _e('Settings will be applied instantly when you change parameter value', 'originbuilder'); ?></span>
			</h1>
			<div class="m-settings-row">
				<div class="msr-left">
					<label><?php _e('Layout Display', 'originbuilder'); ?></label>
					<span><?php _e('Set default layout for sections', 'originbuilder'); ?></span>
				</div>
				<div class="msr-right">
					<div class="msr-content">
						<div class="or-el-ui meu-radio" data-cfg="sectionsLayout" data-type="radio" onclick="or.ui.elms(event,this)">
							<ul>
								<li<# if(or.cfg.sectionsLayout=='grid'){ #> class="active"<# } #>>
									<?php _e('Grid', 'originbuilder'); ?>
									<input type="radio" name="m-c-layout" value="grid" />
								</li>
								<li<# if(or.cfg.sectionsLayout=='list'){ #> class="active"<# } #>>
									<?php _e('List', 'originbuilder'); ?>
									<input type="radio" name="m-c-layout" value="list" />
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<div class="m-settings-row">
				<div class="msr-left">
					<label><?php _e('Number of sections', 'originbuilder'); ?></label>
					<span>
						<?php _e('will be shown in a page, each load-more scrolling down', 'originbuilder'); ?>
					</span>
				</div>
				<div class="msr-right">
					<div class="msr-content">
						<div class="or-el-ui meu-select">
							<select data-cfg="sectionsPerpage" data-type="select" onchange="or.ui.elms(event,this)">
								<option<# if(or.cfg.sectionsPerpage==5){ #> selected<# } #> value="5">5</option>
								<option<# if(or.cfg.sectionsPerpage==10){ #> selected<# } #> value="10">10</option>
								<option<# if(or.cfg.sectionsPerpage==15){ #> selected<# } #> value="15">15</option>
								<option<# if(or.cfg.sectionsPerpage==30){ #> selected<# } #> value="30">30</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="or-popup-loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
	<# 
		data.callback = or.ui.gsections.install_actions;
	#>
</script>

<script type="text/html" id="tmpl-or-row-template">
<#
 
var fEr3 = '', Hrdw = '', sEtd4 = '';

if( data[0] !== undefined && data[0] != '__empty__' )
	sEtd4 = '#'+data[0];

if( data[1] !== undefined && data[1] == 'on' ){
	fEr3 = ' collapse',
	Hrdw = ' disabled';
}

#>
	<div class="or-row m-r-sortdable{{fEr3}}">
		<ul class="or-row-control row-container-control">
		<li class="right move mtips">
				 
				<img src="<?php echo or_URL; ?>/assets/images/move.png" class="sl-cursor-move black_img">
				<img src="<?php echo or_URL; ?>/assets/images/move1.png" class="sl-cursor-move blue_img">
				<span class="mt-mes"><?php _e('Click & Drag to rearrange row ', 'originbuilder'); ?></span>
			</li>
			<li class="right close mtips">
				<!--<i class="sl-close"></i>-->
				<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close black_img">
				<img src="<?php echo or_URL; ?>/assets/images/delete1.png" class="sl-close blue_img">
				<span class="mt-mes"><?php _e('Delete row', 'originbuilder'); ?></span>
			</li>
			
			<!--<li class="right copy mtips">
				<i class="sl-doc"></i>
				<span class="mt-mes"><?php //_e('Copy this row', 'originbuilder'); ?></span>
			</li>-->
			<li class="right double mtips">
				<img src="<?php echo or_URL; ?>/assets/images/copy.png" class="sl-docs black_img">
				<img src="<?php echo or_URL; ?>/assets/images/copy1.png" class="sl-docs blue_img">
				<span class="mt-mes"><?php _e('Duplicate row', 'originbuilder'); ?></span>
			</li>
			<li class="right settings mtips">
				<!--<i class="sl-note"></i>-->
					<img src="<?php echo or_URL; ?>/assets/images/setting.png" class="sl-note black_img">
					<img src="<?php echo or_URL; ?>/assets/images/setting1.png" class="sl-note blue_img">
				<span class="mt-mes"><?php _e('Row preferences', 'originbuilder'); ?></span>
			</li>
			
			<li class="rowStatus{{Hrdw}} mtips">
				<i></i>
				<span class="mt-mes"><?php _e('Publish/Unpublish row', 'originbuilder'); ?></span>
			</li>
		</ul>
		<div class="or-row-admin-view">{{sEtd4}}</div>
		<ul class="or-row-control row-container-control pos-left">
			<li class="right collapse mtips">
				<!--<i class="sl-arrow-down"></i>-->
				<img src="<?php echo or_URL; ?>/assets/images/arw.png" class="sl-arrow-down black_img">
				 
				<span class="mt-mes"><?php _e('Expand / Collapse this row', 'originbuilder'); ?></span>
			</li>
			<li class="right columns mtips">
				<div class="Add_section"><img src="<?php echo or_URL; ?>/assets/images/pplus.png" class="sl-list black_img">
				 <img src="<?php echo or_URL; ?>/assets/images/pplus1.png" class="sl-list blue_img">
				<span class="add_column">Add column</span>
				</div>
				<span class="mt-mes" id="col_six"><?php _e('Add a another column to this row', 'originbuilder'); ?></span>
			</li>
			<li class="right addToSections mtips">
				<i class="sl-share-alt"></i>
				<span class="mt-mes"><?php _e('Storage this row in profile', 'originbuilder'); ?></span>
			</li>
			
		</ul>	
		<div class="or-row-wrap"></div>
	</div>
</script>
<script type="text/html" id="tmpl-or-row-inner-template">
	<div class="or-row-inner">
		<ul class="or-row-control or-row-inner-control">
			<li class="right move mtips">
					<img src="<?php echo or_URL; ?>/assets/images/move.png" class="sl-cursor-move black_img">
					<img src="<?php echo or_URL; ?>/assets/images/move1.png" class="sl-cursor-move blue_img">
				<span class="mt-mes"><?php _e('Click & Drag to rearrange row', 'originbuilder'); ?></span>
			</li>
			<li class="right delete mtips">
			
				<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close black_img">
				<img src="<?php echo or_URL; ?>/assets/images/delete1.png" class="sl-close blue_img">
				<span class="mt-mes"><?php _e('Delete row', 'originbuilder'); ?></span>
			</li>
			<li class="right double mtips">
				 
				<img src="<?php echo or_URL; ?>/assets/images/copy.png" class="sl-docs black_img">
				<img src="<?php echo or_URL; ?>/assets/images/copy1.png" class="sl-docs blue_img">
				<span class="mt-mes"><?php _e('Duplicate row', 'originbuilder'); ?></span>
			</li>
			<li class="right settings mtips">
			<img src="<?php echo or_URL; ?>/assets/images/setting.png" class="sl-note black_img">
			<img src="<?php echo or_URL; ?>/assets/images/setting1.png" class="sl-note blue_img">
				<span class="mt-mes"><?php _e('Row preferences', 'originbuilder'); ?></span>
			</li>
		</ul>
		<?php /* ?><ul class="or-row-control pos-left or-row-inner-control">
			<!--<li class="right collapse mtips">
				<i class="sl-arrow-down"></i>
				<span class="mt-mes"><?php _e('Expand / Collapse this row', 'originbuilder'); ?></span>
			</li>-->
			<li class="right columns mtips">
				<!--<i class="sl-list"></i>-->
	         <img src="<?php echo or_URL; ?>/assets/images/pplus.png" class="sl-list">
			 <span class="list_column">Add column</span>
				<span class="mt-mes"><?php _e('Set number of columns for this row', 'originbuilder'); ?></span>
			</li>
			<!--<li class="right copyRowInner mtips">
				<i class="sl-doc"></i>
				<span class="mt-mes"><?php _e('Copy this row', 'originbuilder'); ?></span>
			</li>-->
		</ul> <?php */?>	
		<div class="or-row-wrap"></div>	
	</div>	
</script>
<script type="text/html" id="tmpl-or-column-template">
	<div class="or-column" style="width: {{data.width}}">
		<ul class="or-column-control column-container-control">
			<li class="or-column-settings mtips">
				<img src="<?php echo or_URL; ?>/assets/images/setting.png" class="sl-note black_img">
				<img src="<?php echo or_URL; ?>/assets/images/setting1.png" class="sl-note blue_img">
				<span class="mt-mes"><?php _e('Column preferences', 'originbuilder'); ?></span>
			</li>
			<li class="or-column-add mtips" style="display:none">
				<i class="sl-plus"></i>
				<span class="mt-mes"><?php _e('Add elements to top of this column', 'originbuilder'); ?></span>
			</li>
			<li class="close mtips">
				<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-trash black_img">
				<img src="<?php echo or_URL; ?>/assets/images/delete1.png" class="sl-trash blue_img">
				<span class="mt-mes"><?php _e('Delete column', 'originbuilder'); ?></span>
			</li>
		</ul>
		<div class="or-column-wrap">
			<div class="or-element drag-helper">
				<a href="javascript:void(0)" class="or-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Element', 'originbuilder'); ?>
				</a>
			</div>
		</div>
		<ul class="or-column-control pos-bottom">
			<li class="or-column-add mtips">
				<!--<i class="sl-plus"></i>-->
				<img src="<?php echo or_URL; ?>/assets/images/pplus.png" class="sl-plus black_img">
				<img src="<?php echo or_URL; ?>/assets/images/pplus1.png" class="sl-plus blue_img">
				<span class="mt-mes"><?php _e('Add elements to bottom of this column', 'originbuilder'); ?></span>
			</li>
		</ul>
		 <div class="column-resize cr-left"></div>
		<div class="column-resize cr-right"></div> 
		<div class="or-cols-info">{{Math.round(parseFloat(data.width))}}%</div>
	</div>
</script>
<script type="text/html" id="tmpl-or-column-inner-template">
	<div class="or-column-inner" style="width: {{data.width}}">
		<ul class="or-column-control column-inner-control">
			<li class="or-column-settings mtips">
				 
				<img src="<?php echo or_URL; ?>/assets/images/setting.png" class="sl-note black_img">
				<img src="<?php echo or_URL; ?>/assets/images/setting1.png" class="sl-note blue_img">
				<span class="mt-mes"><?php _e('Column preferences', 'originbuilder'); ?></span>
			</li>
			<!--<li class="or-column-add mtips">
				 
				<img src="<?php// echo or_URL; ?>/assets/images/pplus.png" class="sl-plus">
				<span class="mt-mes"><?php //_e('Add elements to top of this column', 'originbuilder'); ?></span>
			</li>-->
			<li class="close mtips">
			<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-trash black_img">
			<img src="<?php echo or_URL; ?>/assets/images/delete1.png" class="sl-trash blue_img">
				<span class="mt-mes"><?php _e('Delete column', 'originbuilder'); ?></span>
			</li>
		</ul>
		<div class="or-column-wrap">
			<div class="or-element drag-helper">
				<a href="javascript:void(0)" class="or-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Elements', 'originbuilder'); ?>
				</a>
			</div>
		</div><ul class="or-row-control pos-left or-row-inner-control">
		 
			<li class="right columns mtips">
	         <img src="<?php echo or_URL; ?>/assets/images/add_col.png" class="sl-list black_img">
	         <img src="<?php echo or_URL; ?>/assets/images/add_col1.png" class="sl-list blue_img">
			 <span class="mt-mes"><?php _e('Add column - Inner row'); ?></span>
			</li>
			 
		</ul>
		<!--<ul class="or-column-control pos-bottom">
			<li class="or-column-add mtips">
				<i class="sl-plus"></i>
				<span class="mt-mes"><?php //_e('Add elements to bottom of this column', 'originbuilder'); ?></span>
			</li>
		</ul>-->
			 <div class="column-resize cr-left"></div>
		<div class="column-resize cr-right"></div> 
		 <div class="or-cols-info">{{Math.round(parseFloat(data.width))}}%</div>
	</div>
</script>
<script type="text/html" id="tmpl-or-views-sections-template">
	<#
		try{
			var sct = or.maps[data.name].views.sections;
			if( or.maps[data.name].views.display == 'vertical' )
				var vertical = ' or-views-vertical';
		}catch(e){
			var sct = 'or_tab', vertical = 'or-views-horizontal';
		}	
	#>
	<div class="or-views-sections or-views-{{data.name}}{{vertical}}">
		<ul class="or-views-sections-control or-controls">
			<li class="right move mtips">
				<!--<i class="sl-cursor-move"></i>--> 
				<img src="<?php echo or_URL; ?>/assets/images/move.png" class="sl-cursor-move black_img">
				<img src="<?php echo or_URL; ?>/assets/images/move1.png" class="sl-cursor-move blue_img">
				{{or.maps[data.name].name}}
				<span class="mt-mes"><?php _e('Drag and drop to arrange this section', 'originbuilder'); ?></span>
			</li>
			<li class="right edit mtips">
				<!--<i class="sl-note"></i>-->
				<img src="<?php echo or_URL; ?>/assets/images/edit-white.png" class="sl-note">
				<span class="mt-mes"><?php _e('Open settings', 'originbuilder'); ?></span>
			</li>
			<li class="double mtips">
				<!--<i class="sl-docs"></i>-->
				<img src="<?php echo or_URL; ?>/assets/images/copy-white.png" class="sl-docs">
				<span class="mt-mes"><?php _e('Dublicate sections', 'originbuilder'); ?></span>
			</li>
			<li class="delete trash_delete mtips" title="<?php _e('Delete element', 'originbuilder'); ?>">
							 <img src="<?php echo or_URL; ?>/assets/images/delete-white.png" class="fa fa-trash-o">
											<span class="mt-mes"><?php _e('Delete element', 'originbuilder'); ?></span>			</li>
			<?php /*<li class="more mtips" title="<?php _e('More Actions', 'originbuilder'); ?>">
				<i class="fa fa-caret-right"></i>
				<div class="mme-more-actions">
					<ul>
						<li class="copy" title="<?php _e('Copy this element', 'originbuilder'); ?>">
							<i class="fa fa-copy"></i> <?php _e('Copy', 'originbuilder'); ?>
						</li>
						<li class="cut" title="<?php _e('Cut this element', 'originbuilder'); ?>">
							<i class="fa fa-cut"></i> <?php _e('Cut', 'originbuilder'); ?>
						</li>
						<li class="delete trash_delete" title="<?php _e('Delete this element', 'originbuilder'); ?>">
						 
							 <img src="<?php echo or_URL; ?>/assets/images/delete.png" class="fa fa-trash-o">
							<span ><?php _e('Delete', 'originbuilder'); ?></span>
							 
						</li>
					</ul>
				</div>
				<span class="mt-mes"><?php _e('More actions', 'originbuilder'); ?></span>
			</li>*/?>
		</ul>
		<div class="or-views-sections-wrap">
			<div class="or-views-sections-label">
				<div class="add-section">
				<img class="sl-list" src="<?php echo or_URL; ?>/assets/images/pplus.png"> <span> <?php _e('Add', 'originbuilder'); ?> {{or.maps[sct].name}}</span>
				</div>
			</div>	
		</div>
	</div>
</script>
<script type="text/html" id="tmpl-or-views-section-template">
	<#
		var icon = '';
		if( data.args.icon != undefined )
			icon = '<i class="'+data.args.icon+'"></i> ';
	#>
	<div class="or-views-section<# if(data.first==true){ #> or-section-active<# } #>">
		<h3 class="or-vertical-label sl-arrow-down">{{{icon}}}{{data.args.title}}</h3>
		<ul class="or-controls-2 or-vs-control">
			<!--<li class="right add mtips">
			 
				<img src="<?php //echo or_URL; ?>/assets/images/pplus.png" class="sl-plus">
				<span class="mt-mes"><?php// _e('Add Elements', 'originbuilder'); ?></span>
			</li>-->
			<li class="right double mtips">
				 
					<img src="<?php echo or_URL; ?>/assets/images/copy.png" class="sl-docs">
				<span class="mt-mes"><?php _e('Dublicate section', 'originbuilder'); ?></span>
			</li>
			<li class="right settings mtips">
			<li class="right settings mtips">
			 
				<img src="<?php echo or_URL; ?>/assets/images/edit.png" class="sl-note">
				<span class="mt-mes"><?php _e('Open settings', 'originbuilder'); ?></span>
			</li>
			<li class="right delete mtips" title="<?php _e('Remove', 'originbuilder'); ?>">
			 
				<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close">
				<span class="mt-mes"><?php _e('Remove this section', 'originbuilder'); ?></span>
			</li>
		</ul>
		<div class="or-views-section-wrap or-column-wrap">
			<div class="or-element drag-helper">
				<a href="javascript:void(0)" class="or-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Element', 'originbuilder'); ?>
				</a>
			</div>
		</div>
	</div>
</script>
<script type="text/html" id="tmpl-or-element-template">
	 <div class="or-element {{data.params.name}}<# if(data.map.preview_editable == true){ #> viewEditable<# } #>">
		<div class="or-element-icon"><span class="cpicon {{data.map.icon}}"></span></div>
		<span class="or-element-label">{{data.map.name}}</span>
		<div class="or-element-control" title="<?php _e('Drag to move this element', 'originbuilder'); ?>">
			<ul class="or-controls">
				<!--li class="move" title="<?php// _e('Move', 'originbuilder'); ?>">
					<i class="sl-cursor-move"></i>
				</li-->
				<li class="edit mtips" title="">
					<!--<i class="sl-note"></i>-->
					<img src="<?php echo or_URL; ?>/assets/images/edit-white.png" class="sl-note">
					<span class="mt-mes"><?php _e('Edit element', 'originbuilder'); ?></span>
				</li>
				<li class="double mtips" title="">
					<!--<i class="sl-docs"></i>-->
					<img src="<?php echo or_URL; ?>/assets/images/copy-white.png" class="sl-docs">
					<span class="mt-mes"><?php _e('Duplicate element', 'originbuilder'); ?></span>
				</li>
				<li class="delete mtips" title="<?php _e('Delete element', 'originbuilder'); ?>">
								<img src="<?php echo or_URL; ?>/assets/images/delete-white.png" class="fa fa-trash-o">
								<span class="mt-mes"><?php _e('Delete element', 'originbuilder'); ?></span>
							</li>
				<?php /*<li class="more mtips" title="">
					<i class="fa fa-caret-right"></i>
					<div class="mme-more-actions">
						<ul>
							<li class="copy" title="<?php _e('Copy this element', 'originbuilder'); ?>">
								<i class="fa fa-copy"></i> <?php _e('Copy', 'originbuilder'); ?>
							</li>
							<li class="cut" title="<?php _e('Cut this element', 'originbuilder'); ?>">
								<i class="fa fa-cut"></i> <?php _e('Cut', 'originbuilder'); ?>
							</li>
							
						</ul>
					</div>
					<span class="mt-mes"><?php _e('More Actions', 'originbuilder'); ?></span>
				</li> */?>
			</ul>
		</div>
		<br />
	</div>
</script>
<script type="text/html" id="tmpl-or-undefined-template">
	 <div class="or-undefined or-element {{data.params.name}}">
		<div class="admin-view content">{{data.params.args.content}}</div>
		<div class="or-element-control">
			<ul class="or-controls">
				<li class="move" title="<?php _e('Move', 'originbuilder'); ?>">
						<img src="<?php echo or_URL; ?>/assets/images/move.png" class="sl-cursor-move">
				</li>
				<li class="double" title="<?php _e('Double', 'originbuilder'); ?>">
					<i class="sl-docs"></i>
				</li>
				<li class="edit" title="<?php _e('Edit', 'originbuilder'); ?>">
					<!--<i class="sl-note"></i>-->
					<img src="<?php echo or_URL; ?>/assets/images/edit.png" class="sl-note">
				</li>
				<li class="delete" title="<?php _e('Delete', 'originbuilder'); ?>">
				<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-note">
					<!--<i class="sl-close"></i>-->
				</li>
			</ul>
		</div>		
	</div>
</script>
<script type="text/html" id="tmpl-or-popup-template">
	<div class="or-params-popup wp-pointer-top {{data.class}}<# if(data.bottom!=0){ #> posbottom<# } #>" style="<# if(data.bottom!=0){ #>bottom:{{data.bottom}}px;top:auto;<# }else{ #>top:{{data.top}}px;<# } #>left:{{data.left}}px;<#
			if( data.width != undefined ){ #>width:{{data.width}}px<# } 
		#>">
		<div class="m-p-wrap wp-pointer-content">
			<h3 class="m-p-header"> 
				<span class="heading_element">{{data.title}}</span>
				<# if( data.help != '' ){ #>
				<a href="{{data.help}}" target="_blank" title="<?php _e('Help', 'originbuilder'); ?>" class="sl-help sl-func">
					&nbsp;
				</a>
				<# } #>
				<!--<i title="<?php// _e('Cancel & close popup', 'originbuilder'); ?>" class="sl-close sl-func"></i>-->
				<span class="close"> <img src="<?php  echo or_URL; ?>/assets/images/cross.png" class="sl-close sl-func black_img" title="<?php _e('Cancel & close popup', 'originbuilder');?>" > 
				 <img src="<?php  echo or_URL; ?>/assets/images/cross1.png" class="sl-close sl-func blue_img" title="<?php _e('Cancel & close popup', 'originbuilder');?>"> 
				 </span>
				<!--<i title="<?php //_e('Save & close popup', 'originbuilder'); ?>" class="sl-check sl-func"></i>-->
				<span class="save">  <img src="<?php  echo or_URL; ?>/assets/images/tick.png" class="sl-check sl-func black_img" title="<?php _e('Save & close popup', 'originbuilder');?>" data-id="sl-check"> 
				 <img src="<?php  echo or_URL; ?>/assets/images/tick1.png" class="sl-check sl-func blue_img" title="<?php _e('Save & close popup', 'originbuilder');?>" data-id="sl-check"> </span>
				</h3>
			<div class="m-p-body">
				{{{data.content}}}
			</div>
			<# if( data.footer === true ){ #>
			<div class="m-p-footer">
				<ul class="m-p-controls">
					<li style="display:none">
						<button class="button save button-large">
							<i class="sl-check"></i> {{data.save_text}}
						</button>
					</li>
					<li>
						<button class="sl-check sl-func save save_button">
							 {{data.save_text}}
						</button>
					</li>
					<li>
						<button class="button cancel button-large">
							  {{data.cancel_text}}
						</button>
					</li>
					<li class="pop-tips"><i>{{data.footer_text}}</i></li>
				</ul>
			</div>
			<# } #>
			 
		</div>
		<div class="wp-pointer-arrow"<#
				if( data.pos != undefined ){
					var css = '';
					if( data.pos == 'center' ){
						css += 'left:50%;margin-left:-13px;';
					}else if( data.pos == 'right' ){
						css += 'left:auto;right:50px;';
					}
					if( css != '' ){
						#> style="{{css}}"<#
					}
				}
			#>>
			<div class="wp-pointer-arrow-inner"></div>
		</div>
	</div>

</script>
<script type="text/html" id="tmpl-or-field-template">
	<#
		var class_base = data.base;
		if( data.base.indexOf('[') > -1 ){
			class_base = class_base.replace(/\]\[/g,'-').replace( /[^a-zA-Z\-\_]/g, '' );
		}
	#>
	<div class="or-param-row field-{{data.name}} field-base-{{class_base}}<# 
			if( data.relation != undefined ){
				#> relation-hidden<# 
			} 
		#>">
		<# if( data.label != undefined && data.label != '' ){ #>
		<div class="m-p-r-label">
			<label>{{{data.label}}}:</label>
		</div>
		<div class="m-p-r-content">
		<# }else{ #>
		<div class="m-p-r-content full-width">
		<# } #>	
			{{{data.content}}}
			<# if( data.des != undefined && data.des != '' ){ #>
				<div class="m-p-r-des">{{{data.des}}}</div>
			<# } #>
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-or-row-columns-template">
	<div class="or-row-columns">
		<?php /*?>	&nbsp; <input type="checkbox" data-name="columnDoubleContent" id="m-r-c-double-content" {{or.cfg.columnDoubleContent}} /> 
		<?php _e('Double content', 'originbuilder'); ?> <a href="javascript:alert('<?php _e('Copy content in the last column to the newly-created column. This option is available when you choose to set the column amount greater than the current column amount', 'originbuilder'); ?>.\n\n<?php _e('For example: Currently there is 1 column and you are going to set 2 columns', 'originbuilder'); ?>')"> <i class="sl-question"></i> </a> &nbsp; &nbsp; 
		<input type="checkbox" data-name="columnKeepContent" id="m-r-c-keep-content" {{or.cfg.columnKeepContent}} /> 
		<?php _e('Keep content', 'originbuilder'); ?> <a href="javascript:alert('<?php _e('Keep content of the removed column and transfer it to the last existing column', 'originbuilder'); ?>.\n\n<?php _e('This option is available when you choose to set the column amount smaller than the current column amount', 'originbuilder'); ?>.\n\n<?php _e('For example: Currently there are 2 columns and you are going to set 1 column', 'originbuilder'); ?>.')"> <i class="sl-question"></i> </a>
		<br /><br />
		<?php */?>
	<p class="or-col-btns">
			<button class="button one button-large<# if( data.current == 1 ){ #> active<# } #>" data-column="1">
				1 <?php _e('Column', 'originbuilder'); ?> &nbsp;
			</button>
			<button class="button two button-large<# if( data.current == 2 ){ #> active<# } #>" data-column="2">
				2 <?php _e('Columns', 'originbuilder'); ?> &nbsp;
			</button>
			<button class="button three button-large<# if( data.current == 3 ){ #> active<# } #>" data-column="3">
				3 <?php _e('Columns', 'originbuilder'); ?> &nbsp;
			</button>
		</p>
		<p class="or-col-btns">
			<button class="button four button-large<# if( data.current == 4 ){ #> active<# } #>" data-column="4">
				4 <?php _e('Columns', 'originbuilder'); ?> &nbsp;
			</button>
			<button class="button five button-large<# if( data.current == 5 ){ #> active<# } #>" data-column="5">
				5 <?php _e('Columns', 'originbuilder'); ?> &nbsp;
			</button>
			<button class="button six button-large<# if( data.current == 6 ){ #> active<# } #>" data-column="6">
				6 <?php _e('Columns', 'originbuilder'); ?> &nbsp;
			</button>
		</p>
	 
		<p class="or-col-custom">
			<input type="text" placeholder="Example: 15% + 35% + 6/12" />
			<button data-column="custom" class="button button-large">Apply</button>
		</p>
	</div>
</script>

<script type="text/html" id="tmpl-or-box-design-template">
<#
	if( typeof data == 'object' && data.length > 0 ){
		
		data.forEach( function( item ){
			
	        if( typeof item.attributes != 'object' )
	        	item.attributes = {};
	        if( item.tag == 'a' && item.attributes.href == undefined )
	        	item.attributes.href = '';
	        
	        var classes = '';	
	        if( item.tag == 'icon' || item.tag == 'text' || item.tag == 'image' ){
	        	classes += ' or-box-elm';
			}else if( item.tag == 'clumn' ){
				var ncl = 'one-one';
				if( item.attributes.class !== undefined ){
					['one-one','one-second','one-third','two-third'].forEach(function(cl){
						if( item.attributes.class.indexOf( cl ) > -1 )
							ncl = cl;
					});
				}
				classes += ' or-column-'+ncl;
			}
			
			
	        if( item.attributes.cols != undefined )
	        	classes += ' or-column-'+item.attributes.cols;
	        	
#>
			<div class="or-box or-box-{{item.tag}}{{classes}}" data-tag="{{item.tag}}" data-attributes='{{JSON.stringify(item.attributes)}}'>
		        <ul class="mb-header">
			        <li class="mb-toggle" data-action="toggle"><i class="mb-toggle fa-caret-down"></i></li>
			        <li class="mb-tag">{{item.tag}}</li>
			        <# if( item.attributes.id != undefined && item.attributes.id != '' ){ #>
			        	<li class="mb-id">Id: <span>{{item.attributes.id}}</span></li>
			        <# } if( item.attributes.class != undefined && item.attributes.class != '' ){ #>
			        	<li class="mb-class">
			        		Class: <span title="{{item.attributes.class}}">{{item.attributes.class.substr(0,30)}}..</span>
			        	</li>
			        <# } if( item.attributes.href != '' && item.attributes.href != undefined ){ #>
			        	<li class="mb-href">
			        		Href: <span title="{{item.attributes.href}}">{{item.attributes.href.substr(0,30)}}..</span>
			        	</li>
			        <# } #>
			        <li class="mb-funcs">
			        	<ul>
					        <li title="<?php _e('Remove', 'originbuilder'); ?>" class="mb-remove mb-func" data-action="remove">
					      <img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close" data-action="delete">
					        </li>
					        <# if( item.tag == 'text' ){ #>
					        <li  title="<?php _e('Edit with Editor', 'originbuilder'); ?>"class="mb-edit mb-func" data-action="editor">
					        	<i class="sl-pencil"></i>
					        </li>
					        <# }else{ #>
					        <li  title="<?php _e('Settings', 'originbuilder'); ?>"class="mb-edit mb-func" data-action="settings">
					        	<i class="sl-settings"></i>
					        </li>
					        <# } #>
					        <li title="<?php _e('Double', 'originbuilder'); ?>" class="mb-double mb-func" data-action="double">
					        	<i class="sl-docs"></i>
					        </li>
					        <# if( item.tag != 'div' ){ #>
					        <li title="<?php _e('Add Node', 'originbuilder'); ?>" class="mb-add mb-func" data-action="add" data-pos="inner"><i class="sl-plus"></i></li>
					        <# }else{ #>
					        <li title="<?php _e('Columns', 'originbuilder'); ?>" class="mb-columns mb-func" data-action="columns"><i class="sl-list"></i></li>    
							<# } #>
						</ul>
				    </li>
		        </ul>
		        <div class="or-box-body"><# 
			        
			        var empcol = false;
			        
		        	if( item.tag == 'div' ){
			        	if( item.children == undefined )
				        		empcol = true;
			        	else if( item.children.length == 0 )
				        		empcol = true;
				        else if( item.children[0].tag != 'column' )
				        	empcol = true;
			        }
			        
			        if( empcol == true ){
				        
				       #>{{{or.template( 'box-design', [{ tag: 'column', attributes: { cols:'one-one' }, children: item.children }]
				       	)}}}<# 
				        
			        }else{
			        
			        	
				        if( empcol == true ){
					        #><div data-cols="one-one" class="or-box-column one-one"><#
				        }	


				        if( item.tag == 'text' ){
					        if( item.content == undefined )
					        	item.content = 'Sample Text';
					        #>
								<div class="or-box-inner-text" contenteditable="true">{{{item.content}}}</div>
						    <#
					    }else if( item.tag == 'image' ){
						    if( item.attributes.src == undefined )
						    	item.attributes.src = plugin_url+'/assets/images/get_logo.png';
					        #>
								<img data-action="select-image" src="{{item.attributes.src}}" />
						    <#
					    }else if( item.tag == 'icon' ){
						    if( item.attributes.class == undefined )
						    	item.attributes.class = 'fa-leaf';
					        #>
							<span data-action="icon-picker"><i class="{{item.attributes.class}}"></i></span>
						    <#
					    }else{
				        
					       					        	
					        #>{{{or.template( 'box-design', item.children )}}}<#
				        
				        }
				        
				        #><div class="or-box mb-helper">
					        <a href="#" data-action="add" data-pos="inner">
						        <i class="sl-plus"></i> 
						        <?php _e('Add Node', 'originbuilder'); ?>
						    </a>
					    </div>
				    
				    <# }/*EndIf*/ #>
				    
		        </div>
		    </div>
		    
		<#
		
		});
	}	
#>
</script>

<script type="text/html" id="tmpl-or-param-group-template">

	<div class="or-group-row">
		<div class="or-group-controls">
			<ul>
				<li class="collapse" data-action="collapse" title="<?php _e('expand / collapse', 'originbuilder' ); ?>">
						 <!--<i class="sl-arrow-down" data-action="collapse"></i>--> 
					 <img src="<?php echo or_URL; ?>/assets/images/arw.png" class="sl-arrow-down" data-action="collapse">
					 
				</li>
				<li class="counter"> #1 </li>
				<li class="delete" data-action="delete" title="<?php _e('Delete this group', 'originbuilder' ); ?>">
				 
						<img src="<?php echo or_URL; ?>/assets/images/delete.png" class="sl-close" data-action="delete">
				</li>

				<li class="double" data-action="double" title="<?php _e('Dublicate group', 'originbuilder' ); ?>">
					<!--<i class="sl-docs" data-action="double"></i>-->
					<img src="<?php echo or_URL; ?>/assets/images/copy.png" class="sl-docs">
				</li>			
			</ul>
		</div>
		<div class="or-group-body"></div>
	</div>

</script>

<script type="text/html" id="tmpl-or-wp-widgets-element-template">
<ul class="or-wp-widgets-ul or-components-list or-components-list-main" id="or-wp-widgets-pop"><#
	or.widgets.find('>div.widget').each(function(){
		var tit = jQuery(this).find('.widget-title').text(),
			des = jQuery(this).find('.widget-description').html(),
			base = '{"'+jQuery(this).find('input[name="id_base"]').val()+'":{}}';
			if(tit!="Text") {
			if(tit!="Meta") {
					if(tit=="Archives" || tit=="Calendar" || tit=="Categories" || tit=="Custom Menu" || tit=="Pages" ||tit=="Recent Comments" || tit=="Recent Posts" || tit=="RSS" || tit=="Search" || tit=="Tag Cloud") {
				var t1=	tit.split(' ').join('_');
#>	
	 <li id="{{t1}}" data-data="{{or.tools.base64.encode(base)}}" data-category="wp_widgets" data-name="or_wp_widget" class="or_{{tit}}">
			<div>
				<span class="cpicon or-icon-wordpress {{tit}}"></span>
				<span class="cpdes">
					<strong>{{tit}}</strong>	</span>
					 <# if(tit=="Archives") {#>
					<span class="desc">Monthly archive of posts</span>
					<# } #>
					<# if(tit=="Calendar") {#>
					<span class="desc">Calendar of site's posts</span>
					<# } #>
					<# if(tit=="Categories") {#>
					<span class="desc">Lists or dropdown of Categories</span>
					<# } #>
					<# if(tit=="Custom Menu") {#>
					<span class="desc">Custom menu to sidebar</span>
					<# } #>
					<# if(tit=="Pages") {#>
					<span class="desc">List of site's pages</span>
					<# } #>
					<# if(tit=="Recent Comments") {#>
					<span class="desc">Most recent comments</span>
					<# } #>
					<# if(tit=="Recent Posts") {#>
					<span class="desc">Most recent posts</span>
					<# } #>
					 	<# if(tit=="RSS") {#>
					<span class="desc">Entries from any RSS feed</span>
					<# } #>
					 <# if(tit=="Search") {#>
					<span class="desc">A search from site</span>
					<# } #> <# if(tit=="Tag Cloud") {#>
					<span class="desc">A cloud of most used tags</span>
					<# } #>
					 
			</div>
		</li>
			<#	 } }  }
	});
#>
</ul>
<#
	data.callback = function( wrp, e ){
		wrp.find( 'li' ).on( 'click', e.data.items );
	}
#>
</script>

<script type="text/html" id="tmpl-or-wp-widgets1-component-template">
 <#
	or.widgets.find('>div.widget').each(function(){
		var tit = jQuery(this).find('.widget-title').text(),
			des = jQuery(this).find('.widget-description').html(),
			base = '{"'+jQuery(this).find('input[name="id_base"]').val()+'":{}}';
			if(tit!="Text") {
			if(tit!="Meta") {
				if(tit=="Archives" || tit=="Calendar" || tit=="Categories" || tit=="Custom Menu" || tit=="Pages" ||tit=="Recent Comments" || tit=="Recent Posts" || tit=="RSS" || tit=="Search" || tit=="Tag Cloud") {
				var t=	tit.split(' ').join('_');
#>	
 <li data-id="{{t}}" data-data="{{or.tools.base64.encode(base)}}" data-category="wp_widgets" data-name="or_wp_widget" class="or_{{tit}}">
		<div>
				<span class="cpicon or-icon-wordpress {{tit}}"></span>
				<span class="cpdes">
					<strong>{{tit}}</strong>	</span>
					 <# if(tit=="Archives") {#>
					<span class="desc">Monthly archive of posts</span>
					<# } #>
					<# if(tit=="Calendar") {#>
					<span class="desc">Calendar of site's posts</span>
					<# } #>
					<# if(tit=="Categories") {#>
					<span class="desc">Lists or dropdown of Categories</span>
					<# } #>
					<# if(tit=="Custom Menu") {#>
					<span class="desc">Custom menu to sidebar</span>
					<# } #>
					<# if(tit=="Pages") {#>
					<span class="desc">List of site's pages</span>
					<# } #>
					<# if(tit=="Recent Comments") {#>
					<span class="desc">Most recent comments</span>
					<# } #>
					<# if(tit=="Recent Posts") {#>
					<span class="desc">Most recent posts</span>
					<# } #>
					 	<# if(tit=="RSS") {#>
					<span class="desc">Entries from any RSS feed</span>
					<# } #>
					 <# if(tit=="Search") {#>
					<span class="desc">A search from site</span>
					<# } #> <# if(tit=="Tag Cloud") {#>
					<span class="desc">A cloud of most used tags</span>
					<# } #>
					 
			</div>
		</li>
			<# } }	}
	});
#>
 
<#
	data.callback = function( wrp, e ){
		wrp.find( 'li' ).on( 'click', e.data.items );
	}
#>
</script>

<script type="text/html" id="tmpl-or-animate-template">
	<div class="or-param-row field-{{data.name}}">
		<# if( data.label != undefined && data.label != '' ){ #>
		<div class="m-p-r-label">
			<label>{{data.label}}:</label>
		</div>
		<div class="m-p-r-content">
		<# }else{ #>
		<div class="m-p-r-content full-width">
		<# } #>	
			{{data.content}}
			<# if( data.des != undefined && data.des != '' ){ #>
				<div class="m-p-r-des">{{data.des}}</div>
			<# } #>
		</div>
	</div>
</script>