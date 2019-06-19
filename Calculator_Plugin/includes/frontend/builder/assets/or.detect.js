/*
 * Origin Builder Project
 *
 *  
 *
 * Must obtain permission before using this script in any other purpose
 *
 * or.detect.js
 *
*/

( function($){
	
	if( typeof( or ) == 'undefined' ){
		console.error('Could not load originbuilder core library');
		return;
	}

	or.detect = {
		
		frame : or.frame !== undefined ? or.frame : {},
		
		holder : null,
		
		ob : null,
		
		locked : false,
		
		clicked : false,
		
		disabled : false,
		
		columnsWidthChanged : false,
		
		bone : ['or_row', 'or_row_inner', 'or_column', 'or_column_inner'],
		
		init : function(){
			
			this.frame.contents = $('#or-live-frame').contents();
			
			this.wrap_node( this.frame.contents.find('body').get(0) );
			
			var main = this.frame.contents.find('#or-element-placeholder');
			
			var get_holder = function( main ){
				return{
					main : main,
					tooltip : main.find('.mpb-tooltip').get(0),
					top : main.find('.mpb-top').get(0),
					right : main.find('.mpb-right').get(0),
					bottom : main.find('.mpb-bottom').get(0),
					left : main.find('.mpb-left').get(0)
				}
			}
			
			this.holder = get_holder( main );
			
			this.holder.row = get_holder( this.frame.contents.find('#or-row-placeholder') );
			this.holder.sections = get_holder( this.frame.contents.find('#or-sections-placeholder') );
			this.holder.section = get_holder( this.frame.contents.find('#or-section-placeholder') );
			this.holder.columns = [];
			
			for( var i = 0; i < 6; i ++ )
				this.holder.columns.push( get_holder( this.frame.contents.find('#or-column-'+i+'-placeholder') ) );
				
			this.bone = this.bone.concat( or_maps_views ).concat( or_maps_view );
			
			or.trigger({
				
				el: this.frame.$('.or-boxholder'),
				
				events: {
					'[data-action="edit"]:click': function( e ){ or.front.ui.element.edit( or.get.model( e.target ) ); },
					'[data-action="double"]:click': function( e ){ 
						
						if( e.target.getAttribute('data-action') !== undefined && e.target.getAttribute('data-action') == 'copy' )
							or.front.ui.element.copy( or.get.model( e.target ) );
						else or.front.ui.element.double( or.get.model( e.target ) );
						
					},
					'[data-action="add-element"]:click': function( e ){ 
						var pop = or.front.ui.element.add( e.target );
						if( $(this).closest('.mpb-bottom').length > 0 )
							pop.data({'pos':'bottom'});
						else pop.data({'pos':'top'});
					},			
					'.handle-resize:mousedown' : 'col_resize',
					'[data-action="col-exchange"]:click' : 'col_exchange',
					'[data-action="delete"]:click' : 'delete',
					
					'span.marginer:mousedown': 'marginer'
				},
				
				delete : function( e ){
					
					var model = or.get.model( e.target );
					if( model !== null && confirm( or.__.sure ) ){
						
						var el = or.detect.frame.$('[data-model="'+model+'"]'),
							ob = or.detect.closest( el.parent().get(0) );
						
						el.remove();
						
						if( or.storage[ model ] !== undefined ){
							if( or_maps_view.indexOf( or.storage[ model ].name ) > -1 ){
								
								delete or.storage[ model ];
								
								if(  ob !== null){
									var code = or.front.build_shortcode( ob[1] );
									if( code !== '' )
										or.front.push( code, ob[1], 'replace' );
								}
							}else delete or.storage[ model ];
						}
						
						or.detect.untarget();
						
					}
							
				},
				
				col_resize : function( e ){
				
					if( e.which !== undefined && e.which !== 1 )
						return false;
						
					$('html,body').stop();
					
					var index = $( e.target ).closest('div.or-boxholder').data('col-index'),
						holder = or.detect.holder.columns[index],
						pholder = or.detect.holder.columns[index-1],
						el = or.frame.$('[data-model="'+holder.main.data('model')+'"' ),
						width = or.storage[holder.main.data('model')].args.width,
						pwidth = or.storage[pholder.main.data('model')].args.width,
						mouseUp = function(e){
							or.frame.$(or.frame.doc).off('mousemove').off('mouseup');
							or.frame.$('html,body').css({cursor:''}).removeClass('noneuser or-resizing-cols');
							or.detect.disabled = false;
							or.detect.untarget();
							or.detect.columns( e.data.el.get(0) );
						},
						mouseMove = function( e ){
							
							e.preventDefault();
							e.data.offset = e.clientX-e.data.left;
							
							var d = e.data,
								p1 = (d.width-(d.offset*d.ratio)),
								p2 = d.pwidth+(d.offset*d.ratio);
							
							
							
							if( p1 > 9 && p2 > 9 ){
								// update width of cols
								d.el.style.width = p1+'%';
								d.pel.style.width = p2+'%';
								
								d.col.style.left = e.data.offset+'px';
								
								d.holder.right.style.height = 
								d.holder.left.style.height = 
								d.holder.bottom.style.top = 
								d.pholder.right.style.height = 
								d.pholder.left.style.height = 
								d.pholder.bottom.style.top = d.el.offsetHeight+'px';
								
								// update info 
								d.einfo.innerHTML = Math.round(p1)+'%';
								d.pinfo.innerHTML = Math.round(p2)+'%';
								
								or.storage[d.emodel].args.width = or.tools.nfloat(p1)+'%';
								or.storage[d.pmodel].args.width = or.tools.nfloat(p2)+'%';
								
							}
						};
					
					$(this).data({ curentWidth: or.storage[holder.main.data('model')].args.width });
						
					or.frame.$('html,body').css({cursor:'col-resize'}).addClass('noneuser or-resizing-cols');
					or.detect.disabled = true;
					pholder.right.style.display = 'none';
					
					if( width.indexOf('%') > -1 ){
						width = parseFloat( width );
					}else if( width.indexOf('/') > -1 ){
						width = width.split('/');
						width = (parseInt(width[0])/parseInt(width[1]))*100;
					}
					if( pwidth.indexOf('%') > -1 ){
						pwidth = parseFloat( pwidth );
					}else if( pwidth.indexOf('/') > -1 ){
						pwidth = pwidth.split('/');
						pwidth = (parseInt(pwidth[0])/parseInt(pwidth[1]))*100;	
					}
					
					or.frame.$(or.frame.doc)
						.on( 'mouseup', {el:el}, mouseUp )
						.on( 'mousemove', {
							
							el: el.get(0),
							pel: el.prev().get(0),
							col: $(e.target).closest('.mpb.mpb-left').get(0),
							holder: holder,
							pholder: pholder,
							
							einfo: holder.main.find('.col-info').get(0),
							pinfo: pholder.main.find('.col-info').get(0),
							emodel: holder.main.data('model'),
							pmodel: pholder.main.data('model'),
							
							left: e.clientX,
							width: width,
							pwidth: pwidth,
							
							offset: 1,
							ratio: width/el.get(0).offsetWidth
							
						}, mouseMove );

						
				},
				
				col_exchange : function( e ){
						
					var r_col = parseInt( or.detect.frame.$( e.target ).closest('.or-boxholder').data('col-index') ),
						r_model = or.detect.holder.columns[ r_col ].model,
						l_model = or.detect.holder.columns[ r_col - 1 ].model,
						l_el = or.detect.frame.$('[data-model="'+l_model+'"]'),
						r_el = or.detect.frame.$('[data-model="'+r_model+'"]'),
						cwidth = $(this).closest('.handle-resize').data('curentWidth');;
					
					if( cwidth != or.storage[r_model].args.width )
						return;
					
					l_el.stop().animate({ marginLeft: r_el.get(0).offsetWidth, marginRight: -r_el.get(0).offsetWidth });
					r_el.stop().animate({ marginLeft: -l_el.get(0).offsetWidth, marginRight: l_el.get(0).offsetWidth }, function(){
						l_el.before( r_el );
						l_el.css({marginLeft:'',marginRight:''})
						r_el.css({marginLeft:'',marginRight:''})
					});
					
					or.detect.untarget();
										
				},
				
				marginer : function( e ){
				
					if( e.which !== undefined && e.which !== 1 )
						return false;
						
					$('html,body').stop();
					
					var model = or.get.model( e.target ),
						el = or.frame.$('[data-model="'+model+'"]'),
						value = 0,
						direct = $(this).data('direct'),
						css = or.detect.get_margin( model, direct ),
						
						mouseUp = function(e){
							
							or.frame.$(or.frame.doc).off('mousemove').off('mouseup');
							or.frame.$('html,body').css({cursor:''}).removeClass('noneuser or-resizing-cols');
							or.detect.disabled = false;
							
						},
						
						mouseMove = function( e ){
							
							e.preventDefault();
							var d = e.data;
							d.offset = e.clientY-d.top;
							
							if( d.direct == 'top' ){
								
								or.front.ui.style.element( d.el, d.model, ['margin-top', (d.value+d.offset)+'px'] );
								
								var coor = e.data.el.getBoundingClientRect();
								or.detect.holder.main.get(0).style.top = (coor.top+or.detect.frame.window.scrollY)+'px';
								
								$(or.detect.holder.top).find('.marginer').attr({ 
									'data-value': (d.value+d.offset)+'px'
								});
								
							}else if( e.data.direct == 'bottom' ){
								or.front.ui.style.element( d.el, d.model, ['margin-bottom', (d.value+d.offset)+'px'] );
								$(or.detect.holder.bottom).find('.marginer').attr({ 
									'data-value': (d.value+d.offset)+'px'
								});
							}
							
						};
						
					or.frame.$('html,body').css({cursor:'ns-resize'}).addClass('noneuser or-marginer');
					or.detect.disabled = true;
										
					value = parseInt( css.toString().replace(/[^0-9\-]/g,'') );

					or.frame.$(or.frame.doc)
						.on( 'mouseup', { direct: direct, el: el.get(0), model: model }, mouseUp )
						.on( 'mousemove', {
							
							el: el.get(0),
							value: value,
							direct: direct,
							
							model: model,
							top: e.clientY,
							offset: 1,
							
						}, mouseMove );

						
				},

			});
			
			or.trigger({
				
				el: this.frame.$('#or-footers'),
				
				events: {
					'[data-action="browse"]:click' : function( e ){ or.front.ui.element.add( e.target ); },
					'[data-action="quick-add"]:click' : function( e ){  or.front.push( $( e.target ).parent().data('content') ); },
					'[data-action="custom-push"]:click' : 'custom_push',
					'[data-action="paste"]:click' : 'paste',
					'[data-action="sections"]:click' : 'sections',
					
				},
				
				custom_push : function(e){
					
					var atts = { 
							title: or.__.i36, 
							width: 750, 
							class: 'push-custom-content',
							save_text: 'Push to builder'
						},
						pop = or.tools.popup.render( e.target, atts );
						
					var copied = or.backbone.stack.get('or_RowClipboard');
					if( copied === undefined || copied == '' )
						copied = '';
					pop.find('.m-p-body').html( or.__.i37+'<p></p><textarea style="width: 100%;height: 300px;">'+copied+'</textarea>');
					
					pop.data({
						callback : function( pop ){
							
							var content = pop.find('textarea').val();
							if( content !== '' ){
								if( content.trim().indexOf('[') !== 0 )
									content = '[or_column_text]<p>'+content+'</p>[/or_column_text]';
								or.front.push( content );
							}
						}
					});
				},
				
				paste : function( e ){
				
					content = or.backbone.stack.get('or_RowClipboard');
				
					if( content === undefined || content == '' || content.trim().indexOf('[') !== 0 ){
						content = '[or_column_text]<p>'+or.__.i38+'</p>[/or_column_text]';
					}
				
					if( content != '' )
						or.front.push( content );
							
				},
				
				sections : function( e ){
					
					or.cfg = $().extend( or.cfg, or.backbone.stack.get('or_Configs') );
						
					var atts = { 
							title: 'Templates', 
							width: 950, 
							class: 'no-footer bg-blur-style section-manager-popup', 
							 
						},
						pop = or.tools.popup.render( e.target, atts ),
						arg = {},
						sections = $( or.template( 'install-global-sections', arg ) );
					
					if( or.cfg.profile !== undefined )
						//pop.find('h3.m-p-header').append( ' - Actived Profile <span class="msg-profile-label-display">'+or.cfg.profile.replace(/\-/g,' ')+'</span>' );
					
					pop.find('.m-p-body').append( sections );
					
					if( typeof arg.callback == 'function' )
						arg.callback( sections );
						
				}
				
			});
					
		},
		
		hover : function( e ){
			
			// Disabled inspector
			if( or.detect.disabled === true || or.detect.clicked === true || or.detect.trust( e ) === false )
				return;
				
			var u = or.detect;
			
			// Find closest or object at target			
			u.ob = u.closest( e.target );
			
			if( u.ob === null )
				return;
				
			// If detect or object at hover target
			if( or.storage[ u.ob[1] ] !== undefined && or.detect.bone.indexOf( or.storage[ u.ob[1] ].name ) === -1 ){
				u.target( u.ob );
			}else{
				if( u.ob[1] == '-1' )
					this.columns( e.target.parentNode );
				else this.columns( e.target );
			}

		},
		
		click : function( e ){
			
			if( or.detect.disabled === true || or.detect.trust( e ) === false )
				return false;
			
			if( e.target === undefined )
				return false;
			else if( e.target.tagName == 'A' || or.frame.$( e.target ).closest('a').length > 0 )
				e.preventDefault();
			else if( [ 'INPUT', 'SELECT', 'TEXTAREA' ].indexOf( e.target.tagName ) > -1 ){
				return true;
			}
			
			if( $(e.target).hasClass('or-add-elements-inner') ){
				or.front.ui.element.add( e.target );
				return;
			}
			if( or.detect.locked !== false )
				or.detect.locked = false;
			
			or.detect.untarget();
				
			var ob = or.detect.closest( e.target );
			
			if( ob !== null ){
				
				if( ob[1] == '-1' )
					var ob = or.detect.closest( ob[0].parentNode );
					
				or.detect.clicked = true;
				
				$('.or-params-popup.wp-pointer-top .m-p-header .sl-close.sl-func').trigger('click');

				var name = ( or.storage[ ob[1] ] !== undefined ) ? or.storage[ ob[1] ].name : '';
					
				if( name !== '' ){
					
					var holder;
					
					if( this.bone.indexOf( name ) === -1  )
						holder = this.holder;
					else if( name == 'or_column' || name == 'or_column_inner' )
						holder = this.holder.columns[0];
					else if( name == 'or_row' || name == 'or_row_inner' )
						holder = this.holder.row;
					else if( or_maps_views.indexOf( name ) > -1 )
						holder = this.holder.sections;
					else if( or_maps_view.indexOf( name ) > -1 )
						holder = this.holder.section;
					
					if( this.rect( ob, holder ) === false )
						return;
						
					if( or.storage[ ob[1] ] !== undefined && holder.tooltip !== undefined )
						holder.tooltip.querySelectorAll('span.label')[0].innerHTML = or.storage[ ob[1] ].name.replace('or_','');
						
					this.build_nav( ob, e );
						
				}
								
			};
			
			return false;
			
		},
		
		dblclick : function( e ){
			
			if( or.detect.disabled === true )
				return false;
				
			if( !or.detect.trust( e ) )
				return false;
			
			or.detect.click( e );
			or.detect.holder.main.find('.sl-pencil').trigger('click');
			
			e.preventDefault();
			e.stopPropagation();
			
			if (window.getSelection)
		        window.getSelection().removeAllRanges();
		    else if (document.selection)
		        document.selection.empty();
		        
			return false;
				
		},
		
		focus : function( model, hid ){
			
			or.detect.clicked = true;
			
			var ob = [ or.frame.$('[data-model="'+model+'"]').get(0), model ], holder;
			
			if( hid == 'column' )
				holder = this.holder.columns[0];
			else if( hid == 'element' )
				holder = this.holder;
			else if( hid == 'row' )
				holder = this.holder.row;
			else if( hid == 'sections' )
				holder = this.holder.sections;
			else if( hid == 'section' )
				holder = this.holder.section;
			
			holder.main.data({'model':''});		
			if( this.rect( ob, holder ) === false )
				return;
				
			if( or.storage[ ob[1] ] !== undefined )
				$(holder.tooltip).find('span.label').html( or.storage[ ob[1] ].name.replace('or_','') );
				
			$(holder.top).find('.marginer').attr({ 'data-value': or.detect.get_margin( ob[1], 'top' ) });
			$(holder.bottom).find('.marginer').attr({ 'data-value': or.detect.get_margin( ob[1], 'bottom' ) });
			
		},
		
		trust : function( e ){
			
			if( e.originalEvent === undefined )
				return false;
			
			var el = e.target, i, 
				ignored = [
					'or-boxholder',
					'wp-core-ui',
					'or-params-popup',
					'sys-colorPicker',
					'or-footers',
					'mce-container'
				];
				
			while( el !== null && el !== undefined ){
				for( i in el.classList ){
					if( ignored.indexOf( el.classList[i] ) > -1 )
						return false;
				}
				el = el.parentNode;
			}
			
			return true;	
			
		},
		
		closest : function( el, tag ){
			
			if( el === null || el === undefined || typeof( el.getAttribute ) != 'function' )
				return null;
			
			var model = el.getAttribute('data-model');
			
			if( model !== null ){
				
				if( tag === undefined || 
					( tag !== undefined && or.storage[ model ] !== undefined && or.storage[ model ].name == tag )
				)return [ el, el.getAttribute('data-model') ];
				
			}
			
			if( el.parentNode !== null )
				return or.detect.closest( el.parentNode, tag );
				
			return null;
		},
				
		target : function( ob ){
			
			var u = or.detect, itself = false;
			
			if( this.holder === null || this.holder.model === ob[1] )
				itself = true;
			
			if( !itself ){
				
				var name = ( or.storage[ ob[1] ] !== undefined ) ? or.storage[ ob[1] ].name : '';
					
				if( name !== '' && this.bone.indexOf( name ) === -1 ){
						
					if( this.rect( ob, this.holder ) === false )
						return;
						
					if( or.storage[ ob[1] ] !== undefined )
						this.holder.tooltip.querySelectorAll('span.label')[0].innerHTML = or.storage[ ob[1] ].name.replace('or_','');
						
					$(this.holder.top).find('.marginer').attr({ 'data-value': or.detect.get_margin( ob[1], 'top' ) });
					$(this.holder.bottom).find('.marginer').attr({ 'data-value': or.detect.get_margin( ob[1], 'bottom' ) });
						
				}
			}
		
			if( ob[1] == '-1' )
				ob[3] = ob[0].parentNode;
			else ob[3] = ob[0];
			
			if( name != 'or_row' && name != 'or_row_inner' ){
				this.columns( ob[3] );
				return;
			}
			
			if( ob[0].querySelectorAll('[data-model]')[0] !== undefined ){
				this.columns( ob[0].querySelectorAll('[data-model]')[0] );
			}
			
		},
		
		untarget : function(){
			
			or.detect.clicked = false;
			
			or.frame.$('.or-boxholder, .or-boxholder div, #or-overlay-placeholder').attr({style:''});
			$('.or-params-popup .button.cancel').trigger('click');
			try{
				this.holder.model = '';
				this.holder.el = null;
				this.holder.main.data({'el':'','model':''});
				this.holder.row.main.data({'el':'','model':''});
				this.holder.sections.main.data({'el':'','model':''});
				this.holder.section.main.data({'el':'','model':''});
				for( var i=0; i<this.holder.columns.length; i++ ){
					this.holder.columns[i].main.data({'el':'','model':''});
				}
			}catch(ex){}
		},
		
		rect : function( ob, holder, padding ){
			
			if( ob[0] === null || typeof( ob[0].getBoundingClientRect ) != 'function' || ob[1] === holder.main.data('model') )
				return false;
				
			var pr = 0;
			if( padding === undefined ){
				padding = 0;
				pr = 0;
			}
				
			holder.main.data({ el : ob[0], model : ob[1], s : ob[1] });
			
			if( ob[0].tagName == 'or' )
				$(ob[0]).addClass('fix-to-get-rect');
			
			
			ob[0].style.overflow = 'hidden';
			var coor = ob[0].getBoundingClientRect(),
				top = coor.top+or.detect.frame.window.scrollY,
				left = coor.left+or.detect.frame.window.scrollX,
				height = Math.round( ( coor.height >= 27 ) ? coor.height : 27 ),
				width = coor.width;
			ob[0].style.overflow = '';
			
			if( ob[0].tagName == 'or' )
				$(ob[0]).removeClass('fix-to-get-rect');
			
			holder.width = width;
			holder.height = height;
			holder.el = ob[0];
			holder.model = ob[1];
				
			holder.main.css({ top: (top-padding)+'px', left: left+'px', width: width+'px' });
	
			holder.top.style.width = (width)+'px';
			
			holder.right.style.left = (width-1)+'px';
			holder.right.style.height = (height+padding)+'px';
			
			holder.bottom.style.top = (height+padding)+'px';
			holder.bottom.style.width = (width)+'px';
			
			holder.left.style.height = (height+padding)+'px';

			return true;
			
		},
		
		wrap_node : function( node ){

		    if( node !== null && node !== undefined ){
			    
			    var spc = node.firstChild, spcx;
			    
			    while( spc !== null ){
				    spcx = spc.nextSibling;
				 	if( spc.nodeType === 3 && ( spc.data === "\n" || spc.data.trim() === '' )  ){
					 	spc.parentNode.removeChild( spc );
				 	}
				 	spc = spcx;
				}
			    
		        node = node.firstChild;
		        var wrp,discover, nd, ind;
		        
		        while( node !== null ){
			        
			        if( node.nodeType === 8 )
			        	ind = node;
			        else ind = false;
			        
		            if(
		            	node.nodeType === 8 && 
		            	node.data.indexOf('or s') === 0 && 
		            	node.nextSibling !== null
		            ){

			            if( node.nextSibling.nextSibling !== null ){
				            
				            if( node.nextSibling.nextSibling.nodeType === 8 && 
				            	node.nextSibling.nextSibling.data.indexOf('or e') === 0 ){
					            	if( node.nextSibling.nodeType !== 1 ){
						            	nd = $('<or data-model="'+node.data.replace( /[^0-9]/g, '' )+'"></or>');
						            	$( node.nextSibling ).after( nd );
						            	nd.append( node.nextSibling );
					            	}else node.nextSibling.setAttribute( 'data-model', node.data.replace( /[^0-9]/g, '' ) );
				            }else{
			            	
				            	discover = node.nextSibling;
				            	wrp = document.createElement('or');
				            	
				            	node.parentNode.insertBefore( wrp, discover );
				            	wrp.setAttribute( 'data-model', node.data.replace( /[^0-9]/g, '' ) );
				            	
				            	while( discover !== null ){
					            	
				            		wrp.appendChild( discover );
				            		
				            		if( wrp.nextSibling !== null && 
				            			wrp.nextSibling.nodeType === 8  && 
										wrp.nextSibling.data.indexOf('or e') === 0 
									)break;
				            		
				            		if( discover.nodeType === 1 )
				            			or.detect.wrap_node( discover );
				            		
				            		discover = wrp.nextSibling;
				            		
				            	}
				            	node = wrp;
				            }
				        }
		            
		            }else if( node.nodeType === 1 )or.detect.wrap_node( node );
		            
		            node = node.nextSibling;
		            
			        if( ind !== false && ind != null && ind.parentNode !== null )
			        	ind.parentNode.removeChild( ind );
		        }
		    }
    
		},
		
		is_element : function( model ){
				
			if( or.storage[ model ] === undefined )
				return false;
				
			var ignored = [ 'or_row', 'or_column', 'or_column_inner' ]/*.concat( or_maps_views )*/.concat( or_maps_view );
			
			if( ignored.indexOf( or.storage[ model ].name ) > -1 )
				return false;
				
			return true;
			
		},
		
		build_nav : function( ob, e ){
			
			or.front.ui.element.edit( ob[1], e );
			
			$('#or-inspect-breadcrumns').html('<ul></ul>');
			
			while( ob !== null ){
				
				ob[2] = or.storage[ob[1]].name;
				ob[3] = ob[2].replace(/or\_/g,'').replace(/\_/g,' ');			
				
				var acts = [
						'<li data-act="focus"><i class="et-focus"></i> Focus</li>',
						'<li data-act="edit"><i class="et-tools-2"></i> Edit</li>',
						//'<li data-act="copy"><i class="et-clipboard"></i> Copy</li>',
						'<li data-act="double"><i class="et-documents"></i> Dublicate</li>',
						'<li data-act="delete"><i class="et-caution"></i> Delete</li>'
					], holder;
						  
					if( ['or_row', 'or_row_inner'].indexOf( ob[2] ) > -1 ){
						holder = 'row';
						acts.splice( 1, 0, '<li data-act="layout"><i class="et-browser"></i> Layouts</li>' );
					}else if( ['or_column', 'or_column_inner'].indexOf( ob[2] ) > -1 ){
						acts.splice( 2, 1);
						acts.splice( 1, 0, '<li data-act="add"><i class="et-calendar"></i> Add Element</li>' );
						holder = 'column';
					}else if( or_maps_views.indexOf( ob[2] ) > -1 ){
						acts.splice( 1, 0, '<li data-act="section"><i class="et-layers"></i> Add Section</li>' );
						holder = 'sections';
					}else if( or_maps_view.indexOf( ob[2] ) > -1 ){
						acts.splice( 0, 1);
						acts.splice( 1, 1);
						acts.splice( 1, 0, '<li data-act="add"><i class="et-calendar"></i> Add Element</li>' );
						holder = 'section';
					}else{
						holder = 'element';
					}
					
				var li = '<li class="item" data-holder="'+holder+'" data-e-model="'+ob[1]+'" data-e-name="'+ob[2]+'">'+
						'<span class="pointer" data-act="edit">'+ob[3]+'</span><ul>'+acts.join('')+'</ul></li>';
						
				$('#or-inspect-breadcrumns>ul').prepend(li+'<li><i class="fa-angle-right"></i></li>');
				
				ob = this.closest( ob[0].parentNode );
				
			}
			
			$('#or-inspect-breadcrumns>ul>li').last().remove();
			
			var cl = 'active';
			if( $('.or-sidebar-popup .or-pop-tabs').length === 0 )
				cl += ' notab';
				
			$('#or-inspect-breadcrumns>ul>li.item').last().addClass(cl);
			
			if( $('#or-inspect-breadcrumns').data('added-event') !== true ){
				
				$('#or-inspect-breadcrumns').data({ 'added-event': true })
					.on('mouseover',function(e){ 
						if( $(e.target).closest('li.item').length > 0 ){
							var model = $(e.target).closest('li.item').data('e-model'),
								el = or.frame.$('[data-model="'+model+'"]').get(0);
							
							if( el !== undefined && el !== null && typeof el.getBoundingClientRect == 'function' ){
							 el = el.getBoundingClientRect();
							 console.log(el);
						   
								or.frame.$('#or-overlay-placeholder').css({width:el.width+'px', height:el.height+'px', top:(el.top+or.detect.frame.window.scrollY)+'px', left:el.left+'px', });
							}
						}
					})
					.on('mouseout',function(e){
						or.frame.$('#or-overlay-placeholder').attr({'style':''});
					})
					.on('click', function(e){
						
						if( e.target.getAttribute('data-act') !== null ){
							
							var el = $(e.target).closest('li.item'),
								model = el.data('e-model'),
								holder = el.data('holder');
							
							switch( e.target.getAttribute('data-act') ){
								case 'focus': 
									or.detect.untarget();
									or.detect.focus( model, holder ); 
								break;
								case 'layout': 
									or.front.ui.column.layout( el );
								break;
								case 'add': 
									var pop = or.front.ui.element.add( or.frame.$('[data-model="'+model+'"]').get(0) );
									pop.data({'pos':'bottom'});
								break;
								case 'edit': 
									or.front.ui.element.edit( model );
									$('#or-inspect-breadcrumns>ul>li.item.active').removeClass('active');
									$('#or-inspect-breadcrumns>ul>li.notab').removeClass('notab');
									
									el.addClass('active');
									if( $('.or-sidebar-popup .or-pop-tabs').length === 0 )
										el.addClass('notab');
										
									or.detect.focus( model, holder ); 
										
								break;
								case 'section': 
									or.front.ui.element.add_section( model );
								break;
								case 'copy': 
									or.front.ui.element.copy( model );
									$('#or-inspect-breadcrumns>ul>li.item.active').removeClass('active');
								break;
								case 'double':
									or.front.ui.element.double( model );
									$('#or-inspect-breadcrumns>ul>li.item.active').removeClass('active');
								break;
								case 'delete': 
								
									if(confirm( or.__.sure ) ){
						
										var elm = or.detect.frame.$('[data-model="'+model+'"]'),
											ob = or.detect.closest( elm.parent().get(0) ),
											name = or.storage[ model ].name;
										
										if( ['or_column', 'or_column_inner'].indexOf( name ) > -1 ){
											
											var cols = elm.parent().find('>[data-model]');
											
											if(cols.length === 1){
												// if there are only one column
												// we will delete the row
												model = ob[1];
												elm = $(ob[0]);
											}else{
												cols.each(function(){
													var cid = $(this).data('model'), _w = or.tools.nfloat(100/(cols.length-1))+'%';
													or.storage[ cid ].args.width = _w;
													$(this).css({ width: _w });
												});
											}
										}
										
										elm.find('[data-model]').each(function(){
											delete or.storage[ $(this).data('model') ];
										});
										
										delete or.storage[ model ];
										elm.remove();
										
										if( or_maps_view.indexOf( name ) > -1 ){
												
											if(  ob !== null){
												var code = or.front.build_shortcode( ob[1] );
												if( code !== '' )
													or.front.push( code, ob[1], 'replace' );
											}
										}
										
										or.detect.untarget();
										$('#or-inspect-breadcrumns').html('');
										
									}
								break;
							}
						}
					});
				
				
			}
			
		},
		
		get_margin : function( model, direct ){
			
			var css = or.storage[model].css_data?or.storage[model].css_data:'', value = 0;
			css = css.split(';');
			if( css.length > 0 ){
				for( var i = 0; i< css.length; i++ ){
					if( css[i].indexOf('margin') > -1 ){
						if( direct == 'top' ){
							if( css[i].indexOf('margin-top') > -1 )
								value = css[i];
							else{
								css[i] = css[i].split(':')[1].split(' ');
								value = css[i][0];
							}
							value = parseInt(value.replace(/[^0-9]/g,''));
						}else if( direct == 'bottom' ){
							if( css[i].indexOf('margin-bottom') > -1 )
								value = css[i];
							else{
								css[i] = css[i].split(':')[1].split(' ');
								if( css[i].length === 1 || css[i].length === 2 )
									value = css[i][0];
								else if( css[i].length === 3 || css[i].length === 4 )
									value = css[i][2];
							}
							
						}
					}
				}
			}
			
			if( value === 0 ){
				if( direct == 'top' )
					value = or.frame.$('[data-model="'+model+'"]').css('margin-top');
				else if( direct == 'bottom' )
					value = or.frame.$('[data-model="'+model+'"]').css('margin-bottom');	
			}
			
			var ext = value.replace(/[0-9\.\-\ ]/g,'');
			return parseInt( value )+ext;
			
		},
		
		row : function( el ){
			
			this.ob = or.detect.closest( el );
				
			while( this.ob !== null && or.storage[ this.ob[1] ] !== undefined ){
				
				// we will check is_section while finding row
				if( this.section( this.ob ) === true )
					return;
				
				if( or.storage[ this.ob[1] ].name == 'or_row' ||  or.storage[ this.ob[1] ].name == 'or_row_inner' ){
					
					if( this.rect( this.ob, this.holder.row, 28 ) !== false ){
						// if target row success
						this.holder.row.tooltip.querySelectorAll('.label')[0].innerHTML = or.storage[ this.ob[1] ].name.replace('or_','');
					}
					break;
				}
				this.ob = or.detect.closest( this.ob[0].parentNode );
			}
			
		},
		
		columns : function( el ){
				
			this.ob = or.detect.closest( el );
			var i = 0, el;
			
			while( this.ob !== null && or.storage[ this.ob[1] ] !== undefined ){
				
				if( or.storage[ this.ob[1] ].name == 'or_column' ||  or.storage[ this.ob[1] ].name == 'or_column_inner' ){
					
					el = this.ob[0].parentNode.firstChild;
					i = 0;
					while( el !== null ){
						this.column( el, i++ );
						el = el.nextElementSibling;
					}
					while( i < 6 ){
						this.holder.columns[i++].main.data({'el':'', 'model':''}).attr({style:''}).find('div').attr({style:''});
					}
					break;
				}
				this.ob = or.detect.closest( this.ob[0].parentNode );
			}
			
		},
		
		column : function( el, index ){
			
			if( this.rect( [ el, el.getAttribute( 'data-model' ) ], this.holder.columns[ index ], 0 ) !== false ){
				// if target column success
				var st = or.storage[el.getAttribute( 'data-model' )], _w;
				if( st !== undefined && st.args !== undefined && st.args.width !== undefined ){
					_w = st.args.width;
					if( _w.indexOf('%') > -1 ){
						_w = Math.round( parseFloat( _w ) )+'%';
					}
					this.holder.columns[ index ].main.find('.col-info').html( _w );
				}
			}
			
		},
		
		section : function( ob ){
			
			if(ob === null)
				return false;
			
			if( or.storage[ ob[1] ] === undefined )
				return false;
				
			if( or_maps_view.indexOf( or.storage[ ob[1] ].name ) > -1 ){
				if( this.rect( ob, this.holder.section, 0 ) !== false ){
						
					ob = or.detect.closest( ob[0].parentNode );
					// target sections when found a section
					if( this.rect( ob, this.holder.sections ) !== false ){
						// if target sections success
						$(this.holder.sections.tooltip).find('.label').html( 
							or.storage[ ob[1] ].name.replace('or_','' ) 
						);
						
					}
					
					return true;
				}
			}else if( or_maps_views.indexOf( or.storage[ ob[1] ].name ) > -1 )
				return true;
			
			return false;
			
		},
		
		

	};
	
} )( jQuery );