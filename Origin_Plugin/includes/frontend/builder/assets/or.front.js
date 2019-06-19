/*
 * Origin Builder Project
 *
 *  
 *
 * Must obtain permission before using this script in any other purpose
 *
 * or.front.js
 *
*/

( function($){
	
	if( typeof( or ) == 'undefined' ){
		console.error('Could not load originbuilder core library');
		return;
	}
	
	or.front = {
		
		init : function( frame_doc ){
			
			or.widgets = $( or.template('wp-widgets') );

			or.model = or.storage.length;
			or.detect.init( frame_doc );
			or.front.ui.init( frame_doc );
			
			$('.or_template_button').click(function(){
				or.views.builder.front_live_sections(this);
			});
			
			or.trigger({
				
				el: $('.or-top-toolbar'),
				
				events: {
					'.or-bar-devices:click': 'screen',
					'#or-enable-inspect:click': 'switch',
					'#or-bar-tour-view:click': 'tour',
					'#or-front-exit:click': 'exit',
					'#or-front-save:click': 'save'
				},
				
				screen: function(e){
				 
					var screen = $(this).data('screen');
					if( screen == 'custom' ){
						screen = prompt( 'Enter custom screen size (unit px)', this.innerHTML );
						if( screen === null )
							return;
					}
					
					var id = $(this).attr('id');
					
					if(id != 'or-bar-desktop-view'){
						jQuery('body').css({'background':'#1b1e27'});
						jQuery('#wpcontent').css({'background':'#1b1e27'});
					}else{
						jQuery('body').css({'background':''});
						jQuery('#wpcontent').css({'background':''});
					}
					
					  jQuery("#or-live-frame").contents().find("#or-footers").removeClass('or_foot');
					  jQuery("#or-live-frame").contents().find("#or-footers").removeClass('or_foottab');
					  jQuery('.or-bar-devices').removeClass('active');
		              e.data.el.find('.or-bar-devices').removeClass('active');
					  $(this).addClass('active')
	                  jQuery('.check_device').css('display','block');
				 	  jQuery("#or-live-frame").removeAttr('class');
					 
					 if(screen==768){ 
					 jQuery('.origin_front').removeClass('admin_origin');
                     jQuery("#or-live-frame").contents().find("#or-footers").addClass('or_foottab');					 
					 jQuery("#or-bar-tablet-view").addClass("active");
					 if(jQuery(".seven_fourty .device_attach input[type=checkbox]").is(':checked')) {   
					 jQuery("#or-live-frame").addClass('black_img');
					  }
                      else {   
                      jQuery("#or-live-frame").removeClass('black_img');
		               }
					  
					   jQuery('#or-bar-tablet-view').addClass('active');
					     jQuery('.seven_fourty .vertical').css('display','block');
		                 jQuery('.seven_fourty .horizontal').css('display','none');
		                 jQuery('.seven_fourty').css('display','block');
		                 jQuery('.three_twenty').css('display','none');
						   
						 if(!jQuery('html').hasClass('black_background')){
							
						   jQuery("html").addClass('black_background');
						  }
					    	jQuery("#or-live-frame").addClass('seven_screen');
				    	 }
					 
						if(screen==1024){  
						jQuery('.origin_front').removeClass('admin_origin');
						    jQuery("#or-live-frame").contents().find("#or-footers").addClass('or_foottab');	
						 jQuery("#or-bar-tablet-view").addClass("active");
						    if(jQuery(".seven_fourty .device_attach input[type=checkbox]").is(':checked')) {   
						 
                         jQuery("#or-live-frame").addClass('black_img');
					    }
                       else {   
                        jQuery("#or-live-frame").removeClass('black_img');
		                }
						jQuery('.seven_fourty .horizontal').css('display','block');
		                 jQuery('.seven_fourty .vertical').css('display','none');
						 jQuery('.seven_fourty').css('display','block');
		                 jQuery('.three_twenty').css('display','none');
						 
						 if(!jQuery('html').hasClass('black_background')){
							
						 jQuery("html").addClass('black_background');
						}
					  	jQuery("#or-live-frame").addClass('medium_screen');
					   }
					   if(screen=='100%'){
						   jQuery('.origin_front').addClass('admin_origin');
						 jQuery('.seven_fourty').css('display','none');
		                 jQuery('.three_twenty').css('display','none');
						 jQuery('.footer_width').css('display','none') ;
						 jQuery("#or-live-frame").removeAttr('class');
						 jQuery('.check_device').css('display','none');
						 jQuery("html").removeClass('black_background');
						 jQuery("#or-live-frame").addClass('hundred_screen');
					 }
					  if(screen==320){ 
					 jQuery('.origin_front').removeClass('admin_origin');
					   jQuery("#or-bar-mobile-view").addClass("active");
					    jQuery("#or-live-frame").contents().find("#or-footers").addClass('or_foot');
                      if(jQuery(".three_twenty .device_attach input[type=checkbox]").is(':checked')) {   
						  
                        jQuery("#or-live-frame").addClass('black_img');
					  }
                    else {   
					
                     jQuery("#or-live-frame").removeClass('black_img');
		             }					 
					  jQuery('.seven_fourty').css('display','none');
					  jQuery('.three_twenty .vertical').css('display','block');
		                 jQuery('.three_twenty .horizontal').css('display','none');
		                 jQuery('.three_twenty').css('display','block');
						if(!jQuery('html').hasClass('black_background')){
							
						 jQuery("html").addClass('black_background');
						}
						jQuery("#or-live-frame").addClass('three_screen');
					}
					if(screen==480){   
					jQuery('.origin_front').removeClass('admin_origin');
				    jQuery("#or-live-frame").contents().find("#or-footers").addClass('or_foot');
					 jQuery("#or-bar-mobile-view").addClass("active");
                    if(jQuery(".three_twenty .device_attach input[type=checkbox]").is(':checked')) {   
						 
                        jQuery("#or-live-frame").addClass('black_img');
					  }
                     else {   
                     jQuery("#or-live-frame").removeClass('black_img');
		             }						
					  jQuery('.seven_fourty').css('display','none');
		                 jQuery('.three_twenty').css('display','block');
                         jQuery('.three_twenty .horizontal').css('display','block');
		                 jQuery('.three_twenty .vertical').css('display','none');
						if(!jQuery('html').hasClass('black_background')){
							
						 jQuery("html").addClass('black_background');
						}
						jQuery("#or-live-frame").addClass('six_screen');
					}
  
					$('#or-live-frame').stop().animate({ width: screen });
					or.detect.untarget();
					$('#or-curent-screen-view').html( screen );
	
				},
				
				switch : function(e){
					if( $(this).find('.toggle').hasClass('disable') ){
						$(this).find('.toggle').removeClass('disable');
						$(this).find('.toggle').next().removeClass('edit_peview');
						$(this).find('.toggle').prev().removeClass('edit_btn');
						or.detect.frame.$('body').removeClass('or-disable-inspect');
						or.detect.disabled = false;
					}else{
						$(this).find('.toggle').addClass('disable');
						$(this).find('.toggle').next().addClass('edit_peview');
						$(this).find('.toggle').prev().addClass('edit_btn');
						or.detect.frame.$('body').addClass('or-disable-inspect');
						or.detect.disabled = true;
						or.detect.untarget();
					}
					$('#or-frame-scroll-pad').hide();
				},
				
				tour : function(e){
					or.cfg.tour = '';
					or.front.ui.tour();
					e.preventDefault();
				},
				
				exit : function(e){
					window.location.href = $('#or-live-frame').attr('src').replace('&or_action=live-editor','').replace('?or_action=live-editor','');
				},
				
				save : function(){
					
				 //$('body').append('<div id="or-preload"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				 $('body').append('<div id="or-preload"><div class="load"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="43px" height="46px" viewBox="0 0 86 92" enable-background="new 0 0 86 92" xml:space="preserve"><g><g><path id="ring1" fill="#FFD400" d="M27.02,25.431c11.591,0,21.021,9.228,21.021,20.569s-9.43,20.57-21.021,20.57C15.43,66.57,6,57.342,6,46S15.43,25.431,27.02,25.431 M27.02,19.431C12.098,19.431,0,31.326,0,46c0,14.675,12.098,26.57,27.02,26.57c14.924,0,27.021-11.896,27.021-26.57C54.041,31.326,41.944,19.431,27.02,19.431L27.02,19.431z"/></g></g><g><path id="ring2" fill="#F655A0" d="M58.98,44.854c11.59,0,21.02,9.228,21.02,20.569c0,11.343-9.43,20.57-21.02,20.57c-11.592,0-21.021-9.228-21.021-20.57C37.959,54.082,47.389,44.854,58.98,44.854 M58.98,38.854c-14.924,0-27.021,11.896-27.021,26.569c0,14.675,12.097,26.57,27.021,26.57c14.922,0,27.02-11.896,27.02-26.57C86,50.75,73.902,38.854,58.98,38.854L58.98,38.854z"/></g><g><g><path id="ring3" fill="#05A6F3" d="M58.98,5.93C70.57,5.93,80,15.157,80,26.499c0,11.342-9.43,20.57-21.02,20.57c-11.592,0-21.021-9.228-21.021-20.57C37.959,15.157,47.389,5.93,58.98,5.93 M58.98-0.07c-14.924,0-27.021,11.896-27.021,26.569c0,14.675,12.097,26.57,27.021,26.57c14.922,0,27.02-11.896,27.02-26.57C86,11.825,73.902-0.07,58.98-0.07L58.98-0.07z"/></g></g></svg></div></div>');
					
					var exp='';
					var con= $('#or-live-frame').contents().find(".or_row:not(.or_row .or_row)") ;
					for (i = 0; i < con.length; i++) { 
					var exp1 =  or.backbone.export(con[i].getAttribute('data-model') );
				    beg= exp1.begin;
				     
				    break;
				    }					
						 
					for (i = 0; i < con.length; i++) { 
				
					exp +=  or.front.build_shortcode(con[i].getAttribute('data-model'));
					 
			     	//content += exp.begin+exp.content+exp.end;
							          	 
					} 
                     
						  
				   id=getParameterByName('id');
			 
			 $.ajax({
			 type: "POST",
            url: or_ajax_url,
            data: {
            'action':'ajax_request',
            'content' : exp,
			'id':id
			
			
        },
        success:function(data) {
            $('body #or-preload').remove();
			$('body .m-p-overlay').remove();
		 setTimeout(function() {
			 
		 $('body').append('<div class="m-p-overlay"><span>All changes saved<span></div>');
	    $('body').find('.m-p-overlay').stop().
	    css({display: 'block', opacity: 0}).
	    animate({opacity: 1}, 250).
	    delay(2000).
	    animate({opacity:0, bottom: -1}, function(){
	    $(this).css({display: 'none'});
		});
	}, 100); 
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    }); 
				}
				
			});
			
		},
		
		load : function( frame_doc ){
			
			// onload event
				
		},
		
		params : {
		
			before_save : function( pop ){
					
				var model = pop.data('model');
				if( or.storage[ model ] !== undefined && 
					or.storage[ model ].args !== undefined && 
					or.storage[ model ].args.css !== undefined 
				){
					css = or.storage[ model ].args.css.split('|')[0];
					or.front.ui.style.remove( '.'+css );
				}
				
				pop.data({ active_scroll : pop.find('.m-p-body').scrollTop() });
	
			},
			
			save : function( pop ){
					
				var model = typeof(pop) == 'number' ? pop : pop.data('model'),
					name = (or.storage[model]!==undefined)?or.storage[model].name:'',
					el = or.frame.$('[data-model="'+model+'"]')
					code = or.front.build_shortcode( model );
					
				if( or.storage[model] === undefined )
					return;
					
				if( or_maps_view.indexOf( name ) > -1 ){
					var ob = or.detect.closest( el.parent().get(0) );
					model = ob[1];
					name = or.storage[model].name;
					code = or.front.build_shortcode( model );
					setTimeout( function(pop){ pop.remove(); }, 1, pop );
					$('#or-inspect-breadcrumns').html('');
					$('#or-frame-scroll-pad').hide();
				}
				
				if( code !== '' ){
					
					or.tools.popup.no_close = true;
					
					var active = or.frame.$('[data-model="'+model+'"]').data('tab-active'),
						fid = or.front.push( code, model, 'replace' ),
						el = or.frame.$('[data-model="'+fid+'"]');
					
					if( or_maps_views.indexOf( name ) > -1 && active !== undefined ){
						el.find('>div.or_accordion_section>h3.or_accordion_header>a,>.or_wrapper>.ui-tabs-nav>li').
							eq( active-1 ).trigger('click').trigger('mouseover');
					}
						
					pop.data({ model : fid });
					$('#or-inspect-breadcrumns>ul>li.item.active').data({'e-model': fid});
					
					pop.find('.or-pop-tabs>li').eq( pop.data('tab_active') ).trigger('click');
					
					if( pop.data('active_scroll') !== undefined ){
						pop.find('.m-p-body').scrollTop( pop.data('active_scroll') );
					}
					 
				 
					if( pop.find('.sl-check.sl-func').css('visibility') == 'hidden' )
						return;
						
					 //pop.find('.sl-check.sl-func, button.save').css({visibility: 'hidden'});
				 
						 /*$('body').append('<div class="m-p-overlay"><span>All changes saved<span></div>');
					     $('body').find('.m-p-overlay').stop().
						 css({display: 'block', opacity: 0}).
						 animate({opacity: 1, top: screen.height-200 }, 150).
						 delay(2000).
					    animate({opacity:0, bottom: -1}, function(){
						 	$(this).css({display: 'none'});
					 	$(this).closest('.or-params-popup').find('.sl-check.sl-func, button.save').attr({style:''});
						 });*/
					
				}
			},
			
			cancel : function(){
				or.detect.locked = false;
				or.detect.clicked = false;
				$('#or-live-frame').css({left:'0px'});
				$('#or-frame-scroll-pad').hide();
				$('#or-inspect-breadcrumns>ul>li.item.active').removeClass('active');
			}
			
		},
		
		build_shortcode : function( model ){
			
			var string = css = '';
			if( model !== null && or.storage[ model ] !== undefined ){
				string += '['+or.storage[ model ].name;
				for( var n in or.storage[ model ].args ){
					if( n !== 'content' && n !== 'css_data' ){
						
						if( n == 'css' ){
							
							css = or.storage[ model ].args.css;
							
							if( or.storage[ model ].args.css_data !== undefined )
								css = ' css="'+or.tools.esc_attr( or.storage[ model ].args.css )+'|'+or.storage[ model ].args.css_data+'"';
							else if( css.indexOf('|') > -1 )
								css = ' css="'+or.tools.esc_attr( css )+'"';
							else css = '';
							
							string += css;
							
						}else{
							string += ' '+n+'="'+or.tools.esc_attr( or.storage[ model ].args[n] )+'"';
						}
							
					}
				}
				string += ']';
				
				or.front.export( model );
				
				if( or.storage[ model ].args.content !== undefined && or.storage[ model ].end !== undefined ){
					string += or.storage[ model ].args.content+or.storage[ model ].end;
				}
			}
			
			return string;
				
		},
		
		do_shortcode : function( input, callback ){
		
			if( input === undefined  )
				return null;
		
			var regx = new RegExp( '\\[(\\[?)(' + or.tags + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)', 'g' ), result, agrs, content = input;
		
			var split_arguments = /([a-zA-Z0-9\-\_]+)="([^"]+)+"/gi;
			var output = input;
			
			while ( result = regx.exec( input ) ) {

				var paramesArg 	= [];
				while( agrs = split_arguments.exec( result[3] ) ){
					if(  agrs[1] != '__name' &&  agrs[1] != '__content' && agrs[2] !== '__empty__' )
						paramesArg[ agrs[1] ] = agrs[2];
				}
				
				var args = {
					full		: result[0],
					name 		: result[2],
					/*parames 	: result[3],*/
					/*content 	: result[5],*/
					end		 	: result[6],
					atts	 	: paramesArg,
					/*input		: input,
					result		: result*/
				};
				
				if( undefined !== result[5] && '' !== result[5] ){
					args.content = or.front.process_alter( result[5], result[2] );
				}
				
				output = output.replace( result[0], or.front.do_shortcode_tag( args, callback ) );
				
			}
			
			return output;
			
		},
		
		do_shortcode_tag : function( atts, callback ){
			
			var selector = '';
			
			if( atts.content !== undefined && atts.content !== '' ){
				atts._content = atts.content; 
				atts.content = this.do_shortcode( atts.content, callback ); 
			}
			
			if( atts['atts']['css'] === undefined ){
				selector = 'or-css-'+parseInt( Math.random()*1000000 );
				atts['atts']['css'] = selector;
			}else{
				selector = atts['atts']['css'].split('|');
				atts['atts']['css'] = selector[0];
				atts['atts']['css_data'] = selector[1];
			}
			
			var result = or.template( atts['name'], atts );
			
			or.model++;
			var model = or.model;
			
			or.storage[ model ] = {
				name : atts['name'],
				args : atts['atts'],
				full : atts['full'],
			}
			
			if( callback !== undefined && 
				atts.callback !== undefined && 
				typeof( atts.callback ) == 'function' 
			){
				atts.model = model;
				callback.push( atts );
			}
			
			if( atts['end'] !== undefined ){
				or.storage[ model ].end = atts['end'];
				or.storage[ model ].args.content = atts._content;
				delete or.storage[ model ].args._content;
			}
			
			or.front.ui.style.process( atts['atts'] );
			
			if( result !== null && result !== undefined )
				return '<!--or s '+model+'-->'+result.trim()+'<!--or e '+model+'-->';
			else return '<div class="or-element or-undefined-layout or-loadElement-via-ajax" data-model="'+model+'"><span><i class="fa-spinner fa-spin fa-2x"></i><br /><h3>'+atts['name'].replace('or_','').replace(/\_/g,' ')+'</h3></span></div>';
				
		},
		
		process_alter : function( input, tag ){
	
			/* remove ### of containers loop */
			var start = input.indexOf('['+tag+'#');
			if( start > -1 ){
				var str = input.substring( start+1, input.indexOf( ']', start ) ).split(' ')[0];
				var exp = new RegExp( str, 'g' );
				input = input.replace( exp, tag);
			}
	
			return input;
	
		},
		
		loop_box : function( items ){
		
			if( typeof( items ) != 'object' )
				return '';
		
			var output = '';
			
			for( var n in items ){
				
				if( items[n]['tag'] == 'image' )
					items[n]['tag'] = 'img';
				if( items[n]['tag'] == 'icon' )
					items[n]['tag'] = 'i';
				if( items[n]['tag'] == 'column' )
					items[n]['tag'] = 'div';
				
				if( typeof( items[n] == 'object' ) && items[n]['tag'] != 'text' ){
		
					output += '<'+items[n]['tag'];
					
					if( typeof( items[n]['attributes'] ) != 'object' )
						items[n]['attributes'] = {};
		
					if( items[n]['attributes']['class'] === undefined )
						items[n]['attributes']['class'] = '';
		
					if( items[n]['tag'] == 'column' )
					{
						items[n]['attributes']['class'] += ' '+items[n]['attributes']['cols'];
						delete items[n]['attributes']['cols'];
					}else if( items[n]['tag'] == 'img' && ( items[n]['attributes']['src'] === undefined || items[n]['attributes']['cols'] === '' ) )
						items[n]['attributes']['cols'] = plugin_url+'/assets/images/get_logo.png';
		
					for( var at in items[n]['attributes'] )
					{
						if( items[n]['attributes'][at] !== '' )
							output += ' '+at+'="'+items[n]['attributes'][at]+'"';
					}
		
					if( items[n]['tag'] == 'img' )
						output += '/';
		
					output += '>';
		
					if( typeof( items[n]['children'] ) == 'object' )
						output += or.front.loop_box( items[n]['children'] );
		
					if( items[n]['tag'] != 'img' )
						output += '</'+items[n]['tag']+'>';
		
				}else output += items[n]['content'];
		
			}
		
			return output;
	
		},
		
		ui : {
			
			bag : {},
						
			delay : [ 100 ],
			
			init : function(){
				
				var el = or.frame.$('#or-element-placeholder .move, #or-sections-placeholder .move').each(function(){
					this.setAttribute('droppable', 'true');
			        this.setAttribute('draggable', 'true');
					this.addEventListener( 'dragstart', or.front.ui.events.dragstart, false);
				});
				
				var row = or.detect.frame.contents.find('#or-row-placeholder .move').get(0);
				row.setAttribute('droppable', 'true');
		        row.setAttribute('draggable', 'true');
				row.addEventListener( 'dragstart', this.events.row_dragstart, false);
				
				or.detect.frame.doc.addEventListener( 'dragover', this.events.dragover, false);
				or.detect.frame.doc.addEventListener( 'dragend', this.events.dragend, false);
				or.detect.frame.doc.addEventListener( 'drop', this.events.drop, false);
				
				this.style.sheet = or.detect.frame.$('#or-css-render').get(0).sheet;
				
				$('#wpbody-content').on( 'click', function(e){
					
					if( e.target.id == 'wpbody-content' )
						or.detect.untarget();
						
				});
				
				or.views.column.apply_all = or.front.ui.column.responsive_all;
				
				or.tools.popup.margin_top = -40;
					
			},
			
			events : {

				dragstart : function( e ){
					
					/**
					*	We will get the start element from mousedown of columnsResize
					*/
					
					var u = or.front.ui, model = or.get.model( this );
					
					if( or.detect.holder.el === null && or.detect.holder.sections.el === null ){
						e.preventDefault();
						return false;
					}
					
					u.bag.e = or.frame.$('[data-model="'+model+'"]').get(0);				
					u.bag.e.classList.add('or-ui-placeholder');
					u.bag.model = model;
					
					or.detect.frame.$('body').addClass('or-ui-dragging');
					
			        e.dataTransfer.effectAllowed = 'move';
			        e.dataTransfer.dropEffect = 'none';

			        if( e.dataTransfer !== undefined && typeof  e.dataTransfer.setData == 'function' )
			        	e.dataTransfer.setData('text/plain', 'originbuilder.Com');

				    if( e.dataTransfer !== undefined && typeof  e.dataTransfer.setDragImage == 'function' ){
						e.dataTransfer.setDragImage(
							or.frame.$( '#or-ui-handle-image' ).get(0), 25, 25
						);
					}

				},
				
				row_dragstart : function( e ){
					
					var model = or.get.model( this );
					
					var u = or.front.ui;
					
					if( or.detect.holder.row.el === null ){
						e.preventDefault();
						return false;
					}
					
					u.bag.e = or.detect.holder.row.el;					
					u.bag.e.classList.add('or-ui-placeholder');
					u.bag.model = model;
					
					$('body').addClass('or-ui-dragging');
					
			        e.dataTransfer.effectAllowed = 'move';
			        e.dataTransfer.dropEffect = 'none';

			        if( e.dataTransfer !== undefined && typeof  e.dataTransfer.setData == 'function' )
			        	e.dataTransfer.setData('text/plain', 'originbuilder.Com');

				    if( e.dataTransfer !== undefined && typeof  e.dataTransfer.setDragImage == 'function' ){
						e.dataTransfer.setDragImage(
							or.frame.$( '#or-ui-handle-image' ).get(0), 25, 25
						);
					}
					
					setTimeout( or.detect.untarget, 10 );
					
				},
				
				dragover : function( e ){
					
					var u = or.front.ui;

					if( u.bag.e === null ){

						e.preventDefault();
						return false;

					}else if( or.detect.holder.el !== null || or.detect.holder.sections.el !== null ){
						or.detect.untarget();
					}
					
					
					// Slow down each process when dragging
					
					if( u.delay[1] !== true ){
						if( u.delay[2] !== true ){
							
							u.delay[2] = true;
							
						}else{
							
							u.delay[1] = true;
							setTimeout( function(){
	
								or.front.ui.delay[1] = false;
								or.front.ui.delay[2] = false;
	
							}, u.delay[0] );
	
							e.preventDefault();
							return false;
						}
					}else{
						e.preventDefault();
						return false;
					}

					if(!e) e = window.event;
					
					if( or.storage[u.bag.model] !== undefined ){
						if( or.storage[u.bag.model].name == 'or_row' )
							return or.front.ui.events.row_dragover( e, u );
						//if( or.storage[u.bag.model].name == 'or_row_inner' )
							//return or.front.ui.events.row_inner_dragover( e, u );
					}
					
					u.bag.t = or.detect.closest( e.target );
					
					if( u.bag.t === null || 
						( 
							!or.detect.is_element( u.bag.t[1] ) && 
							u.bag.t[1] != '-1'
						) || 
						$.contains( u.bag.e, u.bag.t[0] ) ){

						// prevent actions when hover it self or hover its children
						e.preventDefault();
						return false;

					}else{

						u.bag.r = u.bag.t[0].getBoundingClientRect();
							
						u.bag.b = (u.bag.r.height/3);
						if( u.bag.b < 100 )
							u.bag.b = u.bag.r.height/2;
							
						if( (u.bag.r.bottom-e.clientY) < u.bag.b ){

							if( u.bag.t[0].nextElementSibling != u.bag.e ){
								$( u.bag.t[0] ).after( u.bag.e );
								or.ui.preventFlicker( e, u.bag.e );
							}

						}else if( (e.clientY-u.bag.r.top) < u.bag.b ){

							if( u.bag.t[0].previousElementSibling != u.bag.e ){
								$( u.bag.t[0] ).before( u.bag.e );
								or.ui.preventFlicker( e, u.bag.e );
							}
						}
						
					}

					e.preventDefault();
					return false;
				},

				row_dragover : function( e, u ){
					
					u.bag.t = or.detect.closest( e.target );
				
					while( u.bag.t !== null && or.storage[ u.bag.t[1] ] !== undefined ){
						
						if( or.storage[ u.bag.t[1] ].name == 'or_row' )
							break;
						
						u.bag.t = or.detect.closest( u.bag.t[0].parentNode );
					}
					
					if( u.bag.t === null || ( or.storage[ u.bag.t[1] ] !== undefined && or.storage[ u.bag.t[1] ].name != 'or_row' ) ){

						// prevent actions when hover it self or hover its children
						e.preventDefault();
						return false;

					}else{
						
						u.bag.r = u.bag.t[0].getBoundingClientRect();
							
						u.bag.b = (u.bag.r.height/3);
						if( u.bag.b < 100 )
							u.bag.b = u.bag.r.height/2;
							
						if( (u.bag.r.bottom-e.clientY) < u.bag.b ){

							if( u.bag.t[0].nextElementSibling != u.bag.e ){
								$( u.bag.t[0] ).after( u.bag.e );
								or.ui.preventFlicker( e, u.bag.e );
							}

						}else if( (e.clientY-u.bag.r.top) < u.bag.b ){

							if( u.bag.t[0].previousElementSibling != u.bag.e ){
								$( u.bag.t[0] ).before( u.bag.e );
								or.ui.preventFlicker( e, u.bag.e );
							}
						}
						
					}

					e.preventDefault();
					return false;
				},				
				
				row_inner_dragover : function( e, u ){
					
					u.bag.t = or.detect.closest( e.target );
				
					while( u.bag.t !== null && or.storage[ u.bag.t[1] ] !== undefined ){
						
						if( u.bag.t[0].parentNode === u.bag.e.parentNode )
							break;
						
						u.bag.t = or.detect.closest( u.bag.t[0].parentNode );
					}
					
					if( u.bag.t === null || 
						( or.storage[ u.bag.t[1] ] !== undefined && u.bag.t[0].parentNode !== u.bag.e.parentNode ) 
					){

						// prevent actions when hover it self or hover its children
						e.preventDefault();
						return false;

					}else{
						
						u.bag.r = u.bag.t[0].getBoundingClientRect();
							
						u.bag.b = (u.bag.r.height/3);
						if( u.bag.b < 100 )
							u.bag.b = u.bag.r.height/2;
							
						if( (u.bag.r.bottom-e.clientY) < u.bag.b ){

							if( u.bag.t[0].nextElementSibling != u.bag.e ){
								$( u.bag.t[0] ).after( u.bag.e );
								or.ui.preventFlicker( e, u.bag.e );
							}

						}else if( (e.clientY-u.bag.r.top) < u.bag.b ){

							if( u.bag.t[0].previousElementSibling != u.bag.e ){
								$( u.bag.t[0] ).before( u.bag.e );
								or.ui.preventFlicker( e, u.bag.e );
							}
						}
						
					}

					e.preventDefault();
					return false;
				},

				_drag : function( e ){

					var atts = $(this).data('atts'),
						h = atts.helperClass,
						p = atts.placeholder,
						el = or.ui.elm_drag ;

					if( h !== '' && el !== null ){

						if( el.className.indexOf( h ) > -1 ){

							$( el ).removeClass( h );

							if( p !== '' )
								$( el ).addClass( p );
						}
					}

					if( typeof atts.drag == 'function' )
						atts.drag( e, this );

					e.preventDefault();
					return false;

				},

				_dragleave : function( e ){

					var atts = $(this).data('atts');

					if( typeof atts.leave == 'function' )
						atts.leave( e, this );

					e.preventDefault();
					return false;
				},

				dragend : function( e ){
					
					if( or.front.ui.bag.e !== undefined )
						or.front.ui.bag.e.classList.remove('or-ui-placeholder');
					$('body').removeClass('or-ui-dragging');
					e.preventDefault();
					or.detect.clicked = false;
					or.detect.locked = false;
					return false;

				},

				drop : function( e ){

					e.preventDefault();
					return false;

				}

			},
			
			column : {
				
				width_calc : function( wid ){
					
					if( wid === undefined )
						wid = '12/12';
					
					wid = wid.split('/'); 
					var n = 12, m = 12;
					
					if( wid[0] !== undefined && wid[0] !== '' )
						n = wid[0];
					
					if( wid[1] !== undefined && wid[1] !== '' )
						m = wid[1];
					
					if( n == '2.4'){
						return 2.4;
					}else{
						n = parseInt( n );
						if ( n > 0 && m > 0 ){
							var calc = 12/(m/n);
							if( calc > 0 && calc <= 12 )
								return calc;
						}
					}
					
					return 12;
					
				},
				
				width_class : function( wid ){
					
					wid = this.width_calc( wid );
					
					if( wid === 2.4 )
						return 'or_col-of-5';
					else return 'or_col-sm-'+wid;
					
				},
				
				change_width : function( model, wid ){
					
					var wd = this.width_calc(  or.storage[ model ].args.width ), _$ = or.detect.frame.$;
					
					if( ( wd <= 1 && wid === -1 ) || ( wd >= 12 && wid === 1 ) || wd === 2.4 )
						return false;
						
					_$( '[data-model="'+model+'"]' ).removeClass( this.width_class( or.storage[ model ].args.width ) );
					
					or.storage[ model ].args.width = (this.width_calc( or.storage[ model ].args.width ) + wid )+'/12';
						
					_$( '[data-model="'+model+'"]' ).addClass( this.width_class( or.storage[ model ].args.width ) );
					
					or.detect.columnsWidthChanged = true;
					
					return true;
					
				},
				
				layout : function( el ){
					
					var model = el.data('e-model');
					if( or.storage[model] === undefined || ['or_row', 'or_row_inner'].indexOf( or.storage[model].name ) === -1 )
						return;
							
					var columns = or.frame.$('[data-model="'+model+'"] [data-model]');
					
					if( columns.length === 0 )
						return;
					
					var count = 0, col = columns.get(0), mol;
					columns = [];
					while( col !== undefined && col !== null ){
						mol = col.getAttribute( 'data-model' );
						if( mol !== null &&  or.storage[ mol ] !== undefined && ( or.storage[ mol ].name == 'or_column' ||  or.storage[ mol ].name == 'or_column_inner' ) )
							columns.push( col );
						col = col.nextElementSibling;
					}
					
					var pop = or.tools.popup.render( 
								el.find('span.pointer').get(0), 
								{ 
									title: 'Row Layout', 
									class: 'no-footer row_layout',
									width: 341,
									content: or.template( 'row-columns', {current:columns.length} ),
									help: 'http://docs.originbuilder.com/documentation/resize-sortable-columns/?source=client_installed' 
								}
							), rect = el.find('span.pointer').get(0).getBoundingClientRect();
					
					pop.css({ left: (rect.left-63+(rect.width/2))+'px', top: '32px', zIndex: 1000000 });
						
					pop.find('.button').off('click').on( 'click', 
						{ 
							model: model,
							columns: columns,
							pop: pop
						}, 
						or.front.ui.column.set_columns 
					);
					
					pop.find('input[type=checkbox]').on('change',function(){
						
						var name = $(this).data('name');
						if( name == undefined )
							return;
							
						if( this.checked == true )
							or.cfg[ name ] = 'checked';
						else or.cfg[ name ] = '';
						
						or.backbone.stack.set( 'or_Configs', or.cfg );
							
					});	
					
				},
				
				set_columns : function( e ){
					
					var newcols = $(this).data('column'),
						uc = or.front.ui.column,
						_$ = or.detect.frame.$,
						columns = _$(e.data.columns),
						wrow = columns.eq(0).parent(),
						colWidths = [],
						model;
					
						
					if( newcols == 'custom' ){
						
						newcols = $(this).parent().find('input').val();
						if( newcols === '' || ( newcols.indexOf('%') === -1 && newcols.indexOf('/') === -1 ) ){
							alert('Invalid value, it must be some thing like: 40%+60%');
							return;
						}
						
						newcols = newcols.split('+');
						if( newcols.length > 10 ){
							alert('Maximum 10 columns, you entered '+newcols.length+' columns');
							return;
						}
						var totalcols = 0;
						for( i=0; i<newcols.length; i++ ){
							
							colWidths[i] = newcols[i].trim();
							
							if( colWidths[i].indexOf('/') > -1 ){
								colWidths[i] = colWidths[i].split('/');
								colWidths[i] = or.tools.nfloat( (parseFloat( colWidths[i][0] )/parseFloat( colWidths[i][1] ))*100 );
							}else if( colWidths[i].indexOf('%') > -1 ){
								colWidths[i] = parseFloat( colWidths[i] );
							}
							
							totalcols += parseFloat( colWidths[i] );
							
						}
						
						if( totalcols > 100 || totalcols < 99 ){
							alert("\nTotal is incorrect: "+totalcols+"%, it must be 100%\n");
							return;
						}
						
						newcols = newcols.length;
						
					}else{
						
						newcols = parseInt( newcols );
						
						for( i=0; i<newcols; i++ ){
							colWidths[i] = or.tools.nfloat( 100/newcols );
						}
						
					}
					
					if( columns.length < newcols ){
						
						/* Add new columns */
						var id = columns.last().data('model'), el, reInit = false;
						
						for( var i = 0; i < (newcols-columns.length) ; i++ ){
							
							var dobl = or.front.ui.element.double( columns.last().data('model') );
							
							if( or.cfg['columnDoubleContent'] != 'checked' ){
								
								dobl.find('[data-model]').each(function(){
									if( this.getAttribute('data-model') != '-1' ){
										delete or.storage[this.getAttribute('data-model')];
										_$(this).remove();
									}
								});
								
							}
							
						}
							
					}else
					{
						/* Remove columns */
						var remove = [], found_empty, el, last, plast;
						
						for( var i = 0; i < (columns.length-newcols) ; i++ ){
						
							found_empty = false;
							wrow.find(' > [data-model]').each(function(){
								if( _$(this).find('[data-model]').length === 1 )
									found_empty = this;
							});
						
							if( found_empty !== false ){
								_$(found_empty).remove();
						
							}else{
						
								last = wrow.find(' > [data-model]').last();
								plast = last.prev();
								
								plast = plast.find('[data-model]').first().parent();
								
								if( or.cfg['columnKeepContent'] == 'checked' ){
									
									el = last.find('[data-model]').get(0).parentNode.children;
									[].forEach.call( el, function( elm ){
										
										if( elm.getAttribute('data-model') !== undefined && elm.getAttribute('data-model') != '-1' )
											plast.append( elm );
									});
									
								}
								
								or.front.clean_storage( last.data('model') );
								last.remove();
								
							}		
						}
						
					}
					
					i = 0;
					wrow.find('>[data-model]').each(function(){
							
						model = _$(this).data('model');
						
						_$( '[data-model="'+model+'"]' ).
							removeClass( uc.width_class( or.storage[ model ].args.width ) ).
							removeClass('or_col-of-5').
							css({width: colWidths[i]+'%' });
							
						or.storage[ model ].args.width = colWidths[i]+'%';
						
						or.detect.columnsWidthChanged = true;
						i++;
						
					});
					
					e.data.pop.remove();
					or.detect.untarget();
					
				},
				
				responsive_all : function( el ){
					
					var model = or.get.model(el), 
						res = or.storage[model].args.responsive,
						col = or.detect.frame.$('[data-model="'+model+'"]').get(0),
						pcol = col.previousElementSibling,
						ncol = col.nextElementSibling;
					
					or.front.ui.style.update_responsive( model );
					
					while( pcol !== null ){
						if( pcol.getAttribute('data-model') !== null ){
							or.storage[ pcol.getAttribute('data-model') ].args.responsive = res;
							or.front.ui.style.update_responsive( pcol.getAttribute('data-model') );
							pcol = pcol.previousElementSibling;
						}else pcol = pcol.previousElementSibling;
					}
					while( ncol !== null ){
						if( ncol.getAttribute('data-model') !== null ){
							or.storage[ ncol.getAttribute('data-model') ].args.responsive = res;
							or.front.ui.style.update_responsive( ncol.getAttribute('data-model') );
							ncol = ncol.nextElementSibling;
						}else ncol = ncol.nextElementSibling;
					}
					
					setTimeout( or.detect.untarget, 100 );
					
				}
				
			},
			
			element : {
				
				edit : function( model, e ){
					
					if( or.storage[model] !== undefined && or.storage[model].args.css_data !== undefined &&
					    or.storage[model].args.css !== undefined && or.storage[model].args.css.indexOf('|') === -1 
					){
						or.storage[model].args.css += '|'+or.storage[model].args.css_data;
					}
					
					var el = or.detect.frame.contents.find('[data-model="'+model+'"]').get(0), 
						name = or.storage[model].name,
						pop = or.backbone.settings( el, { 
								scrollTo: false, 
								success_mesage: '<i class="fa-check"></i> '+or.__.i50,
								noscroll: 'yes'
							});
					if( or.storage[model].name =='or_column_text' ){
						
						pop.data({ 'on_editor_change': function( raw ){
							if( or.cfg.live_preview !== false ){
								or.storage[model].args.content = raw;
								or.frame.$('[data-model="'+pop.data('model')+'"]').html( raw );
							}
						} });
					}
					or.tools.popup.callback( pop, {
						before_callback : or.front.params.before_save, 
						after_callback : or.front.params.save, 
						cancel : or.front.params.cancel
					});
					
					or.detect.clicked = true;
					
					or.detect.frame.contents.find('.or-boxholder, .or-boxholder div').attr({style:''});
					
					or.front.ui.element.popup_to_sidebar( pop, el, e );
					
					or.detect.locked = true;
					
					setTimeout( function( pop ){
	
						or.tools.popup.callback( pop, {
							
							change : function( el, pop ){
								
								var model = pop.data('model');
								
								if( pop.find('.or-pop-tabs').length > 0 ){
									if( pop.find('.or-pop-tabs li.active').data('tab') != 'fields-edit-form' ){
										
										or.front.ui.style.element( or.frame.doc.querySelectorAll('[data-model="'+model+'"]')[0], model, [el.name, el.value] );
										return;	
									}
								}
								
								if( or.cfg.live_preview === false || 
									( el.classList !== undefined && el.classList.contains('m-p-rela') ) )
										return;	
									
								pop.find('button.button.save').trigger('click');	
								
							}
						});
					}, 100, pop );
					
					if( or.detect.bone.indexOf( name ) > -1 ||
						document.getElementById('tmpl-or-'+name+'-template') === null )
							return;
					
					var lp_btn = $('<li><button class="button button-large preview"><input type="checkbox"> '+or.__.i52+'</button></li>');
					pop.find('.m-p-footer .m-p-controls').append( lp_btn );
					
					if( or.cfg.live_preview !== false )
						lp_btn.find('input').attr({checked: true});
					
					lp_btn.on('click', function( e ){
						
						if( e.target.tagName == 'INPUT' ){
							
							if( e.target.checked === true ){
								or.cfg.live_preview = true;
								or.get.popup( this, 'save' ).trigger('click');
								
							}else or.cfg.live_preview = false;
							
							or.backbone.stack.set( 'or_Configs', or.cfg );
							
							return;
						}
						
						if( $(this).find('input').get(0).checked === false ){
							$(this).find('input').attr({checked: true});
							or.cfg.live_preview = true;
							or.get.popup( this, 'save' ).trigger('click');
							
						}else{ 
							or.cfg.live_preview = false;
							$(this).find('input').attr({checked: false});
						}
						
						or.backbone.stack.set( 'or_Configs', or.cfg );
						
					});
						
				},
				
				double : function( model ){
					
					var el = or.detect.frame.contents.find('[data-model="'+model+'"]').get(0);
						code = or.front.build_shortcode( model );
					
					if( el !== null && el !== undefined && code !== '' ){
						
						or.model++;
						
						var callback = [],
							elm = $( or.front.do_shortcode( code, callback ) ),
							wrp = el.parentNode,
							name = or.storage[model].name;
						
						 if( ['or_column', 'or_column_inner'].indexOf( name ) > -1 ){
							var columns = or.frame.$( wrp ).find('>[data-model]');
							if( columns.length >= 10 ){
								alert( or.__.i54 );
								return;
							}
						}
						
						$( el ).after( elm );
						
						or.detect.wrap_node( wrp );
						
						if( or_maps_view.indexOf( name ) > -1 ){
							
							var ob = or.detect.closest( wrp );
							if( ob[1] !== undefined )
								or.front.params.save( parseInt( ob[1] ) );
							return;
							
						}else if( ['or_column', 'or_column_inner'].indexOf( name ) > -1 ){
							var cmodel, cwidth = or.tools.nfloat( 100/( columns.length+1 ) )+'%';
							or.frame.$( wrp ).find('>[data-model]').each(function(){
								cmodel = $(this).data('model');
								if( or.storage[ cmodel ] !== undefined ){
									if( or.storage[ cmodel ].args !== undefined  )
										or.storage[ cmodel ].args.width = cwidth;
									else or.storage[ cmodel ].args = { width : cwidth };
								}
								this.style.width = cwidth;
							});
						}
												
						if( callback.length > 0 )
							or.do_callback( callback, elm.eq(1) );
						
						or.front.element_vs_ajax();
						or.detect.untarget();
						
						return elm;
						
					}
					
					return null;
					
				},
				
				copy : function( model ){
					
					var content = or.front.build_shortcode(model),
						admin_view = '<strong>Copy from live-editor</strong>', 
						lm = 0, stack = or.backbone.stack,
						page = 'live editor', list = stack.get( 'or_ClipBoard' ), ish;
	
					if( list.length > or.cfg.limitClipboard - 2 ){
	
						list = list.reverse();
						var new_list = [];
						for( var i = 0; i < or.cfg.limitClipboard-2; i++ ){
							new_list[i] = list[i];
						}
	
						stack.set( 'or_ClipBoard', new_list.reverse() );
	
					}
	
					stack.clipboard.add( {
						page	: page,
						content	: or.tools.base64.encode( content ),
						title	: or.storage[model].name,
						des		: admin_view
					});
					
					// Push to row stack & OS clipboard
					or.backbone.stack.set( 'or_RowClipboard', content );
					or.tools.toClipboard( content );
					
					or.detect.untarget();
					$('body').append('<div id="or-small-notice"><i class="fa-check"></i> Copy successful!</div>');
					$('#or-small-notice').animate({opacity:1}).delay(1000).animate({opacity:0}, function(){$(this).remove();});
					
				},
				
				add : function( el ){
				
					var pop = or.backbone.add( el ), 
						_top = ( ($(window).height()-pop.height())/2 ),
						_left = ( ($(window).width()-pop.width())/2 );
						
					pop.find('.wp-pointer-arrow').remove();
					
					pop.css({top: (_top>50?_top:50)+'px', left: (_left>0?_left:0)+'px'});
					
					or.detect.clicked = true;
					or.detect.locked = true;
						
					pop.find( 'ul.or-components-list-main li').off('click').on( 'click', function(){
						
						var model = or.get.model( this ),
						name = $(this).data('name'),
						full = or.front.ui.element.from_map( name );
								if(name=="or_wp_widget"){
							var c='#or-wp-widgets-pop #'+$(this).data("id");
							$('.mcl-wp-widgets').trigger("click");
					        $(c).trigger("click");
					        $('#wpcontent').trigger("click");
                             return;
							 
							}
						var fid = or.front.push( full, model, or.get.popup(this).data('pos')  );
						
						$(this).closest('.or-params-popup').find('.m-p-header .sl-close.sl-func').trigger('click');
						
						or.detect.untarget();
						or.front.element_vs_ajax();
						
						var last = or.detect.frame.doc.querySelectorAll('[data-model="'+fid+'"] [data-model]'), mol;
						
						if( last.length > 0 ){
							for( var i = 0; i < last.length; i++  ){
								mol = last[i].getAttribute('data-model');
								if( mol != '-1' && or.storage[ mol ] !== undefined &&
									['or_row','or_row_inner','or_column','or_column_inner'].
										indexOf( or.storage[ mol ].name ) === -1 
									){ fid = mol; break; }
							}	
						}
						
						if( or.detect.bone.indexOf( or.storage[fid].name ) === -1 ){
							or.detect.build_nav( [ or.frame.$('[data-model="'+fid+'"]').get(0), fid ] );
						}
							
					});
					
					return pop;
					
				},
				
				from_map : function( name ){
					
					var maps = or.maps[name],
					map_params = or.params.merge( name ),
					content = ( typeof( or.maps[name].content ) != 'undefined' ) ? or.maps[name].content : '',
					full = '['+name;

					for( var i in map_params ){

						if( map_params[i].type == 'random' ){

							full += ' '+map_params[i].name+'="'+parseInt(Math.random()*1000000)+'"';

						}else if( !_.isUndefined( map_params[i].value ) ){
							if( map_params[i].name == 'content' && maps.is_container === true ){
								content = map_params[i].value;
							}else{
								full += ' '+map_params[i].name+'="'+map_params[i].value+'"';
							}
						}
					}

					if( name == 'or_wp_widget' )
						full += ' data="'+$(this).data('data')+'"';
					
					full += ']';
					
					if( name == 'or_row_inner' ){
						content += '[or_column_inner][/or_column_inner]';
					}
					
					if( maps.is_container === true ){
						full += content+'[/'+name+']';
					}
					
					return full;
	
				},
				
				popup_to_sidebar : function( pop, el, e ){
					
					pop.addClass('or-sidebar-popup');
					
					if( or.cfg.pop_width === undefined )
						or.cfg.pop_width = 430;
					if( or.cfg.pop_left === undefined )
						or.cfg.pop_left = 0;
					
					var fleft = 0;
					
					if( e !== undefined ){
						if( e.clientX < (or.cfg.pop_width+or.cfg.pop_left)){

							fleft = (or.cfg.pop_width+or.cfg.pop_left) - e.target.getBoundingClientRect().left + 10;
						}
					}
					
					$('#or-live-frame').css({ width: $('#or-live-frame').get(0).offsetWidth+'px'});	
					 
					pop.css({width: or.cfg.pop_width+'px', left: or.cfg.pop_left+'px' });
					
					pop.find('.wp-pointer-arrow').on('mousedown', function(e){
						
						if( e.which !== undefined && e.which !== 1 )
							return false;
						
						var mouseUp = function(){
							
							$(document).off('mousemove').off('mouseup');
							$('html,body').css({cursor:''}).removeClass('noneuser overlay-dragging');
							
						},
						
						mouseMove = function( e ){
							
							e.preventDefault();
							var d = e.data;
							d.offset = e.clientX-d.left+d.eleft;
							
							var _w = (d.width+d.offset);
							
							if( _w <= 430 ){
								d.el.style.left = (_w-430)+'px';
								or.cfg.pop_left = (_w-430);
								_w = 430;
							}else{
								or.cfg.pop_left = 0;
								d.el.style.left = '0px';
							}
							or.cfg.pop_width = _w;
							d.el.style.width = _w+'px';
							d.frame.style.left = ((d.fleft+d.offset)>0?(d.fleft+d.offset):0)+'px';
							
						};
							
						$('html,body').css({cursor:'col-resize'}).addClass('noneuser overlay-dragging');
	
						$(document).on( 'mouseup', mouseUp )
								   .on( 'mousemove', {
										
										el: pop.get(0),
										width: parseInt(pop.width()),
										eleft: parseInt(pop.css('left')),
										left: e.clientX,
										frame: $('#or-live-frame').get(0),
										fleft: $('#or-live-frame').get(0).offsetLeft-or.cfg.pop_left,
										offset: 1,
										
									}, mouseMove );

					});
					
					if( $('#or-frame-scroll-pad').length === 0 ){
						
						$('body').append('<div id="or-frame-scroll-pad" style="visibility:hidden"></div>');
						$('#or-frame-scroll-pad').on('mousedown', function(e){
							
							if( e.which !== undefined && e.which !== 1 )
								return false;
							
							$('#or-live-frame').addClass('notransition');
							
							$('html,body').css({cursor:'ew-resize'}).addClass('noneuser overlay-dragging');
								
							$(document).on( 'mouseup', function(){
							
								$(document).off('mousemove').off('mouseup');
								$('html,body').css({cursor:''}).removeClass('noneuser overlay-dragging');
								$('#or-live-frame').removeClass('notransition');
								
							}).on( 'mousemove', {
									
									el: $('#or-live-frame').get(0),
									sleft: parseInt($('#or-live-frame').css('left')),
									left: e.clientX,
									offset: 1,
										
								}, function( e ){
								
									e.preventDefault();
									var d = e.data;
									d.offset = e.clientX-d.left;
									var value = d.sleft-d.offset;
									
									if( value < 0 )
										d.el.style.left = '0px';
									else if( value > (or.cfg.pop_width+or.cfg.pop_left) )
										d.el.style.left = (or.cfg.pop_width+or.cfg.pop_left)+'px';
									else d.el.style.left = value+'px';	
								
								});
								
						});
						
					}else $('#or-frame-scroll-pad').show();
					
				},
				
				add_section : function( model ){
					
					var shortcode = '';
					
					if( model !== null && or.storage[ model ] !== undefined ){
						
						shortcode += '['+or.storage[ model ].name;
						
						for( var n in or.storage[ model ].args ){
							if( n !== 'content' )
								shortcode += ' '+n+'="'+or.tools.esc_attr( or.storage[ model ].args[n] )+'"';
						}
						shortcode += ']';
						
						or.front.export( model );
						
						or.storage[ model ].args.content += 
							or.front.ui.element.from_map( or.maps[ or.storage[ model ].name ]['views']['sections'] );
						
						if( or.storage[ model ].args.content !== undefined && or.storage[ model ].end !== undefined ){
							shortcode += or.storage[ model ].args.content+or.storage[ model ].end;
						}
					}
					
					var fid = or.front.push( shortcode, model, 'replace' );
					or.detect.untarget();
					
					or.detect.build_nav( [ or.frame.$('[data-model="'+fid+'"]').get(0), fid ] );
					
				},
				
			},
			
			scrollAssistive : function( ctop, eff ){

				if( or.cfg.scrollAssistive != 1 )
					return false;

				if( typeof ctop == 'object'  ){
					ctop = or.detect.frame.$(ctop).get(0);
					if( ctop ){
						
						if( ctop.tagName === 'or' && ctop.querySelectorAll('*').length > 0 )
							ctop = ctop.querySelectorAll('*')[0];
							
						var coor = ctop.getBoundingClientRect();
						ctop = (coor.top+or.detect.frame.$(or.detect.frame.window).scrollTop()-100);
						
					}
				}
				
				if( undefined !== eff && eff === false )
					or.detect.frame.$('html,body').scrollTop( ctop );
				else or.detect.frame.$('html,body').stop().animate({ scrollTop : ctop });

			},
			
			style : {
				
				sheet : null,
				
				remove : function( selector ){
					
					for( var i in this.sheet.cssRules ){
						if( this.sheet.cssRules[i].selectorText == selector.trim() ){
							if( this.sheet.removeRule )
								this.sheet.removeRule ( i );
							else if( this.sheet.deleteRule )
								this.sheet.deleteRule ( i );
						}
							
					}
					
				},
				
				add : function( selector, rule ){
					
					if( this.sheet.addRule ){
				        this.sheet.addRule( selector, rule );
				    } else if( this.sheet.insertRule ){
				        this.sheet.insertRule(selector + ' { ' + rule + ' }', this.sheet.cssRules.length);
				    }
				    
				},
				
				get : function( selector ){
					
					for( var i in this.sheet.cssRules ){
						if( this.sheet.cssRules[i].selectorText == selector.trim() ){
							return {
								sheet : this.sheet.cssRules[i],
								index : i,
								css : this.sheet.cssRules[i].cssText
							}
						}	
					}
					
					return null;
					
				},
				
				process : function( atts ){
					
					if( atts['css'] !== undefined ){
						
						var css = atts['css'].split('|'), rule = '';
						
						if( atts['css_data'] !== undefined )
							rule = atts['css_data'];
						else rule = css[1];
						
						if( rule !== undefined ){
							or.front.ui.style.remove( 'body.originbuilder .'+css[0] );
							or.front.ui.style.add( 'body.originbuilder .'+css[0], rule );
						}
						
					}
					
				},
				
				responsive : function( rules, selector ){
					
					rules = JSON.parse( or.tools.base64.decode( rules ) );
					
					var screen = '', css = '', string = '', brc = ';', offset = '', width = '';
					
					for( var i in rules ){
						
						css = '';
						
						if( rules[i]['screen'] !== undefined && rules[i]['screen'] !== '' ){
							
							screen = rules[i]['screen']
							
							if( screen == 'custom' ){
								if( rules[i]['range'] === undefined )
									continue;
									
								rules[i]['range'] = explode( '|', rules[i]['range'] );
								
								if( rules[i]['range'][1] !== '' && rules[i]['range'][1] !== undefined )
									screen = '(min-width: '+rules[i]['range'][0]+') and (max-width: '+rules[i]['range'][1]+')';
								else continue;
							}
							
							screen = '@media only screen and '+screen.replace( /[^0-9a-z\(\)\:\-\,\.\ ]/g, '' );
							
							if( rules[i]['important'] !== undefined && 
								rules[i]['important'] !== '' && 
								rules[i]['important'] == 'yes' )
									brc = ' !important;';
							
							if( rules[i]['offset'] !== undefined && rules[i]['offset'] !== '' ){
								
								offset = parseInt( rules[i]['offset'] );
								
								if( offset > 0 && offset < 11 ){
									offset = (offset/12)*100;
									css += 'margin-left:'+offset+'%'+brc;
								}
							}
							
							if( rules[i]['columns'] !== undefined && rules[i]['columns'] !== '' ){
								
								width = parseInt( rules[i]['columns'] );
								
								if( width > 0 && width < 13 ){
									width = (width/12)*100;
									css += 'width:'+width+'%'+brc;
								}
							}
							
							if( rules[i]['display'] !== undefined && rules[i]['display'] == 'hide' )
								css += 'display:none'+brc;
								
							if( css !== '' ){
								css = screen+'{body.originbuilder .'+selector+'{'+css+'}}';
								string += css;
							}
							
						}
					}
					
					return string;

				},
				
				update_responsive( model ){
					
					if( or.storage[ model ] === undefined )
						return;
						
					var atts = or.storage[ model ].args;
					if( atts['css'] === undefined )
						return;
					
					var css = atts['css'].split('|'), selector = 'or-css-'+parseInt( Math.random()*10000 );
					
					or.detect.frame.$('.'+css[0]).removeClass( css[0] ).addClass( selector );
						
					or.front.ui.style.remove( css[0] );
					
					or.storage[ model ].args.css = selector+'|'+css[1];
					
					or.front.ui.style.add( selector, css[1] );
					or.front.ui.style.responsive( atts['responsive'], selector );
					
					
					
				},
				
				element : function( elm, model, css ){
					
					if( typeof css == 'string' )
						css = css.split(':');
						
					elm.style[css[0]] = css[1];
					
					var st = or.storage[model];
					if( st === undefined )
						return;
					
					if( or.storage[model].args.css === undefined )
						or.storage[model].args.css = 'or-css-'+parseInt((Math.random()*1000000));
					
					var data = st.args.css_data ? st.args.css_data.toString().trim().replace(/\ \:/g,':').split(';') : [];
  
					for(var i = 0; i < data.length; i++){
						if( data[i] !== '' ){
							if( data[i].indexOf( css[0]+':' ) >-1 ){
								if( css[0] !== undefined && css[1] !== undefined && css[1] !== '' )
									data[i] = css[0]+': '+css[1];
								else data[i] = '';
								css = '';
								break;
							}
						}
					}
					
					if( css !== '' ){
						data.push( css[0]+': '+css[1] );
					}
					for (var i = 0; i < data.length; i++) {
						if (data[i] === '' ) {         
							data.splice(i, 1);
							i--;
						}
					}
					
					st.args.css_data = data.join(';')+';';
					
				}
				
			},
			
			process_tab_titles : function( data ){
				
				var regx = /or_tab\s([^\]\#]+)/gi,
					split = /([a-zA-Z0-9\-\_]+)="([^"]+)+"/gi,
					title = '', adv_title = '', html = '';
				
				while ( result = regx.exec( data._content ) ) {
				
					if( result[0] !== undefined && result[0] !== '' ){
						var atts = [], agrs;
						while( agrs = split.exec( result[0]) ){
							atts[ agrs[1] ] = agrs[2];
						}
						
						title = '';
						adv_title = '';
						if ( atts['title'] !== undefined && atts['title'] !== '' )
							title = atts['title'];
				
						if( atts['advanced'] !== undefined && atts['advanced'] !== '' ){
								
								if( atts['adv_title'] !== undefined && atts['adv_title'] !== '' )
									adv_title = or.tools.base64.decode( atts['adv_title'] );
									
								var icon=icon_class=image=image_id=image_url=image_thumbnail=image_medium=image_large=image_full='';
								var svurl = or_ajax_url+'?action=or_get_thumbn&id=';
								
								if( atts['adv_icon'] !== undefined && atts['adv_icon'] !== '' ){
									icon_class = atts['adv_icon'];
									icon = '<i class="'+atts['adv_icon']+'"></i>';
								}
								
								if( atts['adv_image'] !== undefined && atts['adv_image'] !== '' ){
									image_id = atts['adv_image'];
									image_url = image_full = svurl+image_id+'&size=full';
									image_medium = svurl+image_id+'&size=medium';
									image_large = svurl+image_id+'&size=large';
									image_thumbnail = svurl+image_id+'&size=thumbnail';
									image = '<img src="'+image_url+'" alt="" />';
								}
								
								adv_title = adv_title.replace( /\{icon\}/g, icon ).
											  replace( /\{icon_class\}/g, icon_class ).
											  replace( /\{title\}/g, title ).
											  replace( /\{image\}/g, image ).
											  replace( /\{image_id\}/g, image_id ).
											  replace( /\{image_url\}/g, image_url ).
											  replace( /\{image_thumbnail\}/g, image_thumbnail ).
											  replace( /\{image_medium\}/g, image_medium ).
											  replace( /\{image_large\}/g, image_large ).
											  replace( /\{image_full\}/g, image_full ).
											  replace( /\{tab_id\}/g, atts['tab_id'] );
								
								html += '<li>'+adv_title+'</li>';
									
							}else{ 
							if ( atts['icon'] !== undefined && atts['icon'] !== '' )
								title = '<i class="'+atts['icon']+'"></i> '+title;	
							html += '<li><a href="#'+atts['tab_id']+'">'+title+'</a></li>';
							
						}
				
					}
							
				}

				return html;
					
			},
			
			tour : function(){
				
				if(  or.cfg.tour !== undefined && or.cfg.tour === 'nope' )
					return;
				
				$('#or-tour-show').html('<img src="'+$('#or-tours #or-tour-nav li[data-media]').first().data('media')+'" />');
				$('#or-tours').css({display: 'block'});
				
				or.trigger({
					el : $('#or-tours'),
					events : {
						'#or-tour-nav li:click' : 'nav',
						'#or-tour-nope:click' : 'nope',
						'#or-tour-close a.tour-next:click' : 'next',
						'#or-tour-close a.tour-prev:click' : 'prev',
						'#or-tour-close i.fa-times:click' : function(){
							$('#or-tours').css({display: 'none'});
							$('body').removeClass('or-ui-blur');
						},
						'click' : function(e){
							if( e.target.id == 'or-tours' ){
								$('#or-tours').css({ display : 'none' });
								$('body').removeClass('or-ui-blur');
							}
						}
					},
					nav : function(e){
						if( $(this).data('media') !== undefined ){
							$('#or-tours #or-tour-nav li.active').removeClass('active');
							$(this).addClass('active');
							$('#or-tour-show img').attr({ src : this.getAttribute('data-media') });
						}
					},
					nope : function(e){
						$('#or-tours').css({display: 'none'});
						$('body').removeClass('or-ui-blur');
						or.cfg.tour = 'nope';
						or.backbone.stack.set( 'or_Configs', or.cfg );
						e.preventDefault();
					},
					next : function(e){
						if( $('#or-tours #or-tour-nav li.active').next().data('media') !== undefined )
							$('#or-tours #or-tour-nav li.active').next().trigger('click');
						else $('#or-tours #or-tour-nav li[data-media]').first().trigger('click');
						e.preventDefault();
					},
					prev : function(e){
						if( $('#or-tours #or-tour-nav li.active').prev().data('media') !== undefined )
							$('#or-tours #or-tour-nav li.active').prev().trigger('click');
						else $('#or-tours #or-tour-nav li[data-media]').last().trigger('click');
						e.preventDefault();
					}
				});
				
			},
			
			ask_to_buy : function(){
				
				$('body').addClass('or-ui-blur');
				or.trigger({
					el: $('#or-preload').html( $('#or-as-to-buy').html() ),
					'events' : {
						'a.close:click': 'close',
						'a.verify:click': 'verify'
					},
				
					close: function(){
						$('body').removeClass('or-ui-blur');
						$('#or-preload').remove();
					},
					verify: function( e ){
						
						$('#or-preload .or-preload-body').append('<div class="pl-loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
						
						var sercurity = e.data.el.find('input[name="sercurity"]').val(),
							license = e.data.el.find('input[name="or-license-key"]').val().toString();
						
						if( license.length !== 41 ){
							e.data.el.find('p.notice').attr({'class':'notice error'}).html('Your license code is invalid.');
							e.data.el.find('.pl-loading').remove();
							return;
						}
							
						jQuery.post(
		
							or_ajax_url,
						
							{
								'action': 'or_verify_license',
								'security': sercurity,
								'license': license
							},
						
							function (result) {
								
								if( result == -1 || result == 0 || result.stt == -1 || result.stt == 0 ){
									e.data.el.find('p.notice').attr({'class':'notice error'}).html('Invalid security session! Please reload the page and try again.');
									e.data.el.find('.pl-loading').remove();
									return;
								}else if( result == -2 ){
									e.data.el.find('p.notice').attr({'class':'notice error'}).html('Your license code is invalid (code -2)');
									e.data.el.find('.pl-loading').remove();
									return;
								}else{
									e.data.el.find('.pl-loading').remove();
									if( result.stt == 1 ){
										e.data.el.find('p.notice').attr({'class':'notice success'}).html('<i class="sl-check" style="font-size: 40px;"></i><br /><br />Your domain has been actived successful');
										e.data.el.find('#or-preload-footer, input').remove();
										e.data.el.find('h3').html('Congratulation!');
										$('body').append('<script>'+result.code+'</script>');
									}else{
										e.data.el.find('p.notice').attr({'class':'notice error'}).html( result.stt );			
									}
								}
							}
						);
						
					}
				});
			}
			
		},
		
		push : function( full, model, pos ){
			
			var callback = [], elm;
			
			if( model === undefined || or.storage[ model ] === undefined ){
				
				full = full.toString().trim();
				// push before or-footer
				if( full.indexOf('[or_row ') !== 0 && full.indexOf('[or_row]') !== 0 )
					full = '[or_row][or_column width="12/12"]'+full+'[/or_column][/or_row]';
				elm = $( or.front.do_shortcode( full, callback ) );
				or.detect.frame.contents.find('#or-footers').before( elm );
				or.detect.wrap_node( or.detect.frame.body );
			
			}else{
				
				elm = or.detect.frame.$( or.front.do_shortcode( full, callback ) );
				
				var wrp = or.detect.frame.$('[data-model="'+model+'"]').get(0);
				if( wrp !== undefined ){
					
					if( pos == 'replace' ){
						
						var pwrp = wrp.parentNode;
						
						$(wrp).after( elm ).remove();
						
						or.detect.wrap_node( pwrp );
						
					}else{	
					
						var items = wrp.querySelectorAll('[data-model]');
						
						if( items.length > 0 ){
							
							if( pos == 'top' ){
								$( items[0] ).before( elm );
							}else{
								$( items[ items.length - 1 ] ).after( elm );
							}
							
							or.detect.wrap_node( wrp );
							
						}
					}
				}
			}
			
			if( callback.length > 0 )
				or.do_callback( callback, elm.eq(1) );
			
			or.front.element_vs_ajax();
			
			var fid = elm.get(0);
			if( fid.nodeType === 8 )
				fid = fid.data.replace( /[^0-9]/g,'' );
			else fid = elm.data('model');
			
			elm = or.detect.frame.$('[data-model="'+fid+'"]');

			if( pos != 'replace' ){
				elm.addClass('or-bounceIn');
				setTimeout( function( target ){ target.removeClass('or-bounceIn'); }, 1200, elm );
			}
			
			return fid;
			
		},
		
		export : function( model ){
			
			var string = '', _$ = or.detect.frame.$;
			if( model !== null && or.storage[ model ] !== undefined ){
				
				if( _$('[data-model="'+model+'"]').find('[data-model]').length > 0 ){
						
					var checked = [], fm;
						
					_$('[data-model="'+model+'"]').find('[data-model]').each(function(){
						fm = this.getAttribute('data-model');
						
						if( fm !== null && fm !== '-1' && checked.indexOf( fm ) === -1 && or.front.check_parent( this, model ) === true ){
							string += or.front.build_shortcode( fm );
							checked.push( fm );
						}
					});	
					
					or.storage[ model ].args.content = string;
				
				}else string = or.storage[ model ].args.content;
				
			}else{
				_$('[data-model]').first().parent().find(' > [data-model]').each(function(){
					string += or.front.export( _$(this).data('model') );
				});
			}
			
			return string;
				
		},
		
		check_parent : function( el, model ){
			
			el = el.parentNode;
			
			while( el !== null && el !== undefined ){
				if( el.getAttribute('data-model') !== null &&  el.getAttribute('data-model') !== '-1' ){
					if(  el.getAttribute('data-model') == model )
						return true;
					else return false;
				}
				el = el.parentNode;
			}
			return false;
		},
		
		clean_storage : function( model ){
			
			var el = or.detect.frame.$('[data-model="'+model+'"]').get(0)
			
			if( el !== undefined ){
				
				var model = el.getAttribute( 'data-model' ), css;
				
				if( or.storage[ model ] !== undefined ){
					if( or.storage[ model ].args !== undefined && or.storage[ model ].args.css !== undefined ){
						css = or.storage[ model ].args.css.split('|')[0];
						or.front.ui.style.remove( '.'+css );
					}
					delete or.storage[ model ];
				}
				
				var els = el.querySelectorAll('[data-model]');
				for( var i = 0; i < els.length; i++ ){
					or.front.clean_storage( els[i].getAttribute('data-model') );
				}
			}
		},
		
		element_vs_ajax : function(){
			
			var _$ = or.detect.frame.$;
			_$('.or-loadElement-via-ajax').each(function(){
				
				if( _$(this).data('is_loaded') === true )
					return;
				else _$(this).data({ 'is_loaded' : true });
				
				_$.post( or_ajax_url, {

					'action' : 'or_load_element_via_ajax',
					'model' : $(this).data('model'),
					'ID' : (or_post_ID !== undefined) ? or_post_ID : 0,
					'code' : or.tools.base64.encode( or.front.build_shortcode( $(this).data('model') ) )
					
				}, function (result) {
					
					if( typeof( result ) != 'object' || result.model === undefined )
						return;
					
					var elm = _$(result.html), wrp = _$('[data-model="'+result.model+'"]').parent();
					_$('div[data-model="'+result.model+'"]').after( elm ).remove();
					
					elm.data({ model: result.model });
					
					or.detect.wrap_node( wrp.get(0) );
					
					if( result.callback !== undefined && typeof( result.callback ) == 'object' ){
						for( var i in result.callback )
							result.callback[i].model = result.model;
						or.do_callback( result.callback, _$('[data-model="'+result.model+'"]') );
						
					}
					
					if( result.css !== undefined && result.css !== '' ){
						_$('[data-model="'+result.model+'"]').append('<style type="text/css">'+result.css+'</style>');
					}
						
				});
			
			});
			
		}
	 
	}

	$( document ).ready( function(){
		
		if( or.init_front_ready === true )
			or.front.init();
		
		if(  or.cfg.tour === undefined || or.cfg.tour !== 'nope' )
		{
			$('body').addClass('or-ui-blur');
		}
			
	});
	
	$( window ).on( 'load', function(){
		
		if(  or.cfg.tour === undefined || or.cfg.tour !== 'nope' )
		{
			$('#or-preload>i.fa').remove();
			$('#or-preload>#or-welcome').css({display: 'block'});
			or.trigger({
				el: $('#or-preload>#or-welcome'),
				events : {
					'.tour:click' : function(e){
						$('#or-preload').remove();
						or.cfg.tour = '';
						or.front.ui.tour();
						e.preventDefault();
					},
					'.nope:click' : function(e){
						$('#or-tours').css({display: 'none'});
						$('body').removeClass('or-ui-blur');
						$('#or-preload').remove();
						or.cfg.tour = 'nope';
						or.backbone.stack.set( 'or_Configs', or.cfg );
						e.preventDefault();
					},
					'.enter:click' : function(e){
						$('#or-preload').remove();
						$('body').removeClass('or-ui-blur');
					},
					'.verify:click' : function(e){
						$('#or-preload').remove();
						$('body').removeClass('or-ui-blur');
						$('#or-front-save').trigger('click');
					}
				}
			});
		}else $('#or-preload').remove();
		
	});

} )( jQuery );


jQuery( document ).ready(function() {
 
	jQuery('.origin_front').addClass('admin_origin');
	jQuery('#or-live-frame').addClass('hundred_screen');
	
	});
 
 
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}