/*
 * Origin Builder Project
 *
 *  
 *
 * Must obtain permission before using this script in any other purpose
 *
 * or.builder.js
 *
*/

( function($){
	 
	if( typeof( or ) == 'undefined' )
		window.or = {};
	 
	$().extend( or.views, {
			
		builder : new or.backbone.views('no-model').extend({
			
			render : function(){
				
				var el = $( or.template( 'container' ) );
				
				$('#or-container').remove();
				$('#postdivrich').hide().removeClass('first-load').after( el );
				
				this.el = el;
				
				return el;
							
			},
			
			events : {
				'.classic-mode:click' : or.switch,
				'.live-editor:click' : function( e ){
					
					var id = $('#post_ID').val(),
						type = $('#post_type').val();
					
					if( typeof( id ) == 'undefined' )
						alert( or.__.i48 );
					else if( typeof( type ) == 'undefined' )
						alert( or.__.i49 );
					else if( $('#original_post_status').val() == 'auto-draft' ||  $('#original_post_status').val() == 'draft' )
						alert( or.__.i51 );
					else window.open( site_url+'/wp-admin/options-general.php?page=originbuilder&or_action=live-editor&id='+id );
					
					e.preventDefault();
					return;
						
				},
				'.basic-add:click' : or.backbone.add,
				'.or-add-sections:click' : 'sections',
				'.post-settings:click' : 'post_settings',
				'#or-footers li.quickadd:click' : 'footer'
			},
			
			front_live_sections : function(e1){
				$( "body" ).prepend( "<div class='backgound_color' style='background-color:#D7D7D7;height: 100%;opacity: 1;width: 100%;position: fixed;z-index: 16;'></div>" );
				
				or.cfg = $().extend( or.cfg, or.backbone.stack.get('or_Configs') );
				
				var atts = { 
						title: 'Templates', 
						width: 950, 
						class: 'no-footer bg-blur-style section-manager-popup or_template_popup', 
						 
					},
					pop = or.tools.popup.render( e1, atts ),
					arg = {},
					sections = $( or.template( 'install-global-sections', arg ) );
					
				if( or.cfg.profile !== undefined )
					//pop.find('h3.m-p-header').append( ' - Actived Profile <span class="msg-profile-label-display">'+or.cfg.profile.replace(/\-/g,' ')+'</span>' );
				
				pop.find('.m-p-body').append( sections );
				
				if( typeof arg.callback == 'function' )
					arg.callback( sections );

			},
			
			sections : function(){
				$( "body" ).prepend( "<div class='backgound_color' style='background-color:#D7D7D7;height: 100%;opacity: 1;width: 100%;position: fixed;z-index: 16;'></div>" );
				
				or.cfg = $().extend( or.cfg, or.backbone.stack.get('or_Configs') );
				
				var atts = { 
						title: 'Templates', 
						width: 950, 
						class: 'no-footer bg-blur-style section-manager-popup or_template_popup', 
						 
					},
					pop = or.tools.popup.render( this, atts ),
					arg = {},
					sections = $( or.template( 'install-global-sections', arg ) );
					
				if( or.cfg.profile !== undefined )
					//pop.find('h3.m-p-header').append( ' - Actived Profile <span class="msg-profile-label-display">'+or.cfg.profile.replace(/\-/g,' ')+'</span>' );
				
				pop.find('.m-p-body').append( sections );
				
				if( typeof arg.callback == 'function' )
					arg.callback( sections );

			},
			
			post_settings : function( e ){
				
				var atts = { title: 'Page Settings', width: 800, class: 'no-footer bg-blur-style' },
					pop = or.tools.popup.render( this, atts ),
					arg = { classes : $('#or-page-body-classes').val(), css : $('#or-page-css-code').val() },
					sections = $( or.template( 'post-settings', arg ) );
				
				pop.find('.m-p-body').append( sections );
				
				if( typeof arg.callback == 'function' )
					arg.callback( sections, $ );
				
				return false;
					
			},
			
			footer : function(){
				
				var content = $(this).data('content');
				
				if( content == 'custom' ){
					
					var atts = { 
						title: or.__.i36, 
						width: 750, 
						class: 'push-custom-content',
						save_text: 'Push to builder'
					},
					pop = or.tools.popup.render( this, atts );
					
					var copied = or.backbone.stack.get('or_RowClipboard');
					if( copied === undefined || copied == '' )
						copied = '';
					pop.find('.m-p-body').html( or.__.i37+'<p></p><textarea style="width: 100%;height: 300px;">'+copied+'</textarea>');
					
					pop.data({
						callback : function( pop ){
							
							var content = pop.find('textarea').val();
							if( content !== '' )
								or.backbone.push( content );
						}
					});
					
					return;
					
				}else if( content == 'paste' ){
					content = or.backbone.stack.get('or_RowClipboard');
					if( content === undefined || content == '' ){
						content = '[or_column_text]<p>'+or.__.i38+'</p>[/or_column_text]';
					}
				}
				
				if( content != '' )
					or.backbone.push( content );
				
			}
			
		} ),

		views_sections : new or.backbone.views().extend({
			
			render : function( params ){
				
				var el = new $( or.template( 'views-sections', params ) );
				or.params.process_all( params.args.content, el.find('> .or-views-sections-wrap'), 'views_section' );
				
				this.el = el;
				
				return el;
				
			},
			
			events : {
				'>.or-views-sections-control .edit:click' : 'settings',
				'>.or-views-sections-control .delete:click' : 'remove',
				'>.or-views-sections-control .double:click' : 'double',
				'>.or-views-sections-wrap .add-section:click' : 'add_section',
				'>.or-views-sections-control .more:click' : 'more',
				'>.or-views-sections-control .copy:click' : 'copy',
				'>.or-views-sections-control .cut:click' : 'cut',
				'>.or-views-sections-control:click' : function( e ){
					var tar = $(e.target);
					if( tar.hasClass('more') || tar.parent().hasClass('more') )
						return;
					$(this).find('.active').removeClass('active');
				},
			},
			
			add_section : function( e ){

				var wrp = $(this).closest('.or-views-sections-wrap'),
					maps = or.get.maps(this),
					smaps = or.maps[maps.views.sections],
					content = '['+maps.views.sections+' title="New '+smaps.name+'"][/'+maps.views.sections+']';
				
				wrp.find('> .or-views-sections-label .sl-active').removeClass('sl-active');
				wrp.find('> .or-section-active').removeClass('or-section-active');
					
				or.params.process_all( content, wrp, 'views_section' );
				
			}
			
		} ),
		
		views_section : new or.backbone.views().extend({
			
			render : function( params ){

				var el = $( or.template( 'views-section', params ) );
				
				this.el = el;
				
				return el;
				
			},
			
			init : function( params, el ){
				
				var id = el.data('model'), 
					btn = params.parent_wrp.find('>.or-views-sections-label .add-section'), 
					title = or.tools.esc( params.args.title ),
					icon = '';
				if( params.args.icon != undefined )
					icon = '<i class="'+params.args.icon+'"></i> ';
					
				or.ui.sortInit();
				
				var label = '<div class="section-label';
				if( params.first == true )
					label += ' sl-active';
				label += '" id="or-pmodel-'+id+'" data-pmodel="'+id+'">'+icon+title+'</div>';
				
				btn.before( label );
				
				return btn;
	
			},
			
			events : {
				'>.or-vs-control .settings:click' : 'settings',
				'>.or-vs-control .double:click' : 'double',
				'>.or-vs-control .add:click' : 'add',
				'>.or-vs-control .delete:click' : 'remove',
				
			},
			
			settings : function(){
				
				var pop = or.backbone.settings( this );
				if( !pop ){
					alert( or.__.i39 );
					return;
				}
				pop.data({
					after_callback : function( pop ){
						
						var id = or.get.model( pop.data('button') ),
							storage = or.storage[ id ],
							el = $('#model-'+id),
							icon = '';
						if( storage.args.icon != undefined )
							icon = '<i class="'+storage.args.icon+'"></i> ';
							
						$('#or-pmodel-'+id).html( icon+or.tools.esc( storage.args.title ) );
						el.find('.or-vertical-label').html( icon+or.tools.esc( storage.args.title ) );
					}
				});
			},
			
			double : function(){
				
				var id = or.get.model( this ),
					exp = or.backbone.export( id ),
					wrp = $(this).closest('.or-views-sections-wrap');
				
				wrp.find('> .or-views-sections-label .sl-active').removeClass('sl-active');
				wrp.find('> .or-section-active').removeClass('or-section-active');
					
				or.params.process_all( exp.begin+exp.content+exp.end, wrp, 'views_section' );
			},
			
			remove : function(){
				
				var id = or.get.model( this ),
					lwrp = $('#or-pmodel-'+id).parent();
					
				if( confirm('Are you sure?') ){	
					$('#or-pmodel-'+id).remove();
					lwrp.find('.section-label').first().trigger('click');
					delete or.storage[ id ];
					$('#model-'+id).remove();
				}
			}
	
			
		} ),
		
		row : new or.backbone.views().extend({
			
			render : function( params, _return ){
				
				params.name = 'or_row';
				params.end = '[/or_row]';
				
				var el = $( or.template( 'row', [ params.args.row_id, params.args.disabled ] ) ), atts = ' width="12/12"';
				
				var content = params.args.content.toString().trim();
				if( content.indexOf('[or_column') !== 0 ){
					
					content = content.replace(/or_column#/g,'or_column##');
					content = content.replace(/or_column /g,'or_column# ').replace(/or_column\]/g,'or_column#]');
					
					var params = or.params.merge( 'or_column' );
					
					for( var i in params ){
						if( typeof( params[i] ) != 'undefined' && typeof( params[i].value ) != 'undefined' )
							atts += ' '+params[i].name
								 +'="'+or.tools.esc_attr( params[i].value )+'"';
					}
					
					content = '[or_column'+atts+']'+content+'[/or_column]';
					
					delete params;
					
				}
				
				or.params.process_columns( content, el.find('.or-row-wrap') );
				
				if( _.isUndefined(_return) )
					$('#or-container>#or-rows').append( el );
			
				this.el = el;
				
				return el;
				
			},
			
			events : {
				'.row-container-control .close:click' : 'remove',
				'.row-container-control .settings:click' : 'edit',
				'.row-container-control .double:click' : 'double',
				'.row-container-control .copy:click' : 'copy',
				'.row-container-control .columns:click' : 'columns',
				'.row-container-control .collapse:click' : 'collapse',
				'.row-container-control .addToSections:click' : 'sections',
				'.row-container-control .rowStatus:click' : 'status',
			},
			
			columns : function(){
				
				var columns = $(this).closest('.or-row').find('>.or-row-wrap>.or-column.or-model');

				var pop = or.tools.popup.render( 
							this, 
							{ 
								title: 'Row Layout', 
								class: 'no-footer row_layout',
								width: 341,
								content: or.template( 'row-columns', {current:columns.length} ),
								help: 'http://originbuilder.com/documentation/resize-sortable-columns/?source=client_installed' 
							}
						);
						
				pop.find('.button').on( 'click', 
					{ 
						model: or.get.model( this ),
						columns: columns,
						pop: pop
					}, 
					or.views.row.set_columns 
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
			
			set_columns : function(e){
				
				var newcols = $(this).data('column'),
					columns = e.data.columns,
					wrow = $( '#model-'+e.data.model+' > .or-row-wrap' ),
					colWidths = [], i = 0;
					
				if( newcols == 'custom' ){
					
					newcols = $(this).parent().find('input').val();
					if( newcols === '' || ( newcols.indexOf('%') === -1 && newcols.indexOf('/') === -1 ) ){
						alert('Invalid value');
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
					var reInit = false, j = 0;
					
					columns.each(function(){
						or.storage[$(this).data('model')].args.width = colWidths[j]+'%';
						$(this).css({width: colWidths[j]+'%'}).find('>.or-cols-info').html(Math.round(colWidths[j])+'%');
						j++;
					});
					
					for( var i = 0; i < (newcols-columns.length) ; i++ ){
						
						var dobl = or.backbone.double( columns.last().get(0) );
						
						or.storage[dobl.data('model')].args.width = colWidths[j]+'%';
						dobl.css({width: colWidths[j]+'%'}).find('>.or-cols-info').html(Math.round(colWidths[j])+'%');
						j++;
						
						if( $('#m-r-c-double-content').attr('checked') == undefined || columns.length === 0 ){
							
							dobl.find('.or-model').each(function(){
								delete or.storage[$(this).data('model')];
								$(this).remove();
							});
							
						}
						
					}
					
					if( reInit == true )
						or.ui.sortInit();
						
				}else{
					/* Remove columns */
					var remove = [];
					
					for( var i = 0; i < (columns.length-newcols) ; i++ ){
					
						var found_empty = false;
					
						wrow.find('>.or-column.or-model,>.or-column-inner.or-model').each(function(){
							if( $(this).find('>.or-column-wrap>.or-model').length == 0 ){
								found_empty = this;
							}
						});
					
						if( found_empty != false ){
					
							$(found_empty).remove();
					
						}else{
					
							var last = wrow.find('>.or-column.or-model,>.or-column-inner.or-model').last(), 
								plast = last.prev();
								
							if( $('#m-r-c-keep-content').attr('checked') != undefined && plast.get(0) != undefined ){
								last.find('>.or-column-wrap>.or-model').each(function(){
									plast.find('>.or-column-wrap').append( this );
								});
							}else{
								last.find('>.or-column-wrap>.or-model').each(function(){
									delete or.storage[$(this).data('model')];
								});
							}
							
							
							last.remove();
							
						}		
					}
					
					i = 0;
					wrow.find('>.or-column.or-model,>.or-column-inner.or-model').each(function(){
					
						or.storage[ $(this).data('model') ].args.width = colWidths[i]+'%';
						$(this).css({width: colWidths[i]+'%'}).find('>.or-cols-info').html(Math.round(colWidths[i])+'%');
						i++;
					
					});
				}
				
				e.data.pop.remove();
				
			},
			
			collapse : function(){
				var elm = $(this).closest('.or-row');
				if( !elm.hasClass('collapse') ){
					elm.addClass('collapse');
				}else{
					elm.removeClass('collapse');
				}	
			},
			
			sections : function( e ){
				
				or.cfg = $().extend( or.cfg, or.backbone.stack.get('or_Configs') );
				
				var atts = { title: or.__.i40, width: 800, class: 'no-footer bg-blur-style', help: 'http://originbuilder.com/documentation/sections-manager/?source=client_installed' };
				var pop = or.tools.popup.render( this, atts );
				
				if( or.cfg.profile !== undefined )
					pop.find('h3.m-p-header').append( ' - <span class="msg-profile-label-display">'+or.cfg.profile.replace(/\-/g,' ')+'</span>' );
				
				pop.data({ model: or.get.model(this) });
				
				var args = {};
				var sections = $( or.template( 'add-global-sections', args ) );
				
				pop.find('.m-p-body').append( sections );
				
				if( typeof args.callback == 'function' )
					args.callback( sections );
				
			},
			
			copy : function( e ){
					
				if( $(this).hasClass('copied') )
					return;
									
				var model = or.get.model( this ),
					expo = or.backbone.export( model );
					
				or.backbone.stack.set( 'or_RowClipboard', expo.begin+expo.content+expo.end );
				
				or.tools.toClipboard( expo.begin+expo.content+expo.end );
				
				$(this).addClass('copied');
				
				setTimeout( function( el ){
					$(el).removeClass('copied');
				}, 600, this );
				
				return;
	
			},
			
			edit : function( e ){
				
				var pop = or.backbone.settings( this );
				if( !pop ){
					alert( or.__.i41 );
					return;
				}
				
				pop.data({ after_callback : function( pop ){
					
					var id = or.get.model( pop.data('button') ),
						params = or.storage[ id ].args,
						html = '',
						el = $('#model-'+id+'>.or-row-admin-view');

					if( params.row_id != undefined && params.row_id != '__empty__' )
						html += '#'+params.row_id+' ';
					
					el.html( html );
					
				}});
				
			},
			
			status : function( e ){
					
				var model = or.get.model( this ), stt = '';
				if( or.storage[ model ] !== undefined && or.storage[ model ].args !== undefined ){
					
					if( $(this).hasClass('disabled') ){
						
						$(this).removeClass('disabled').closest('.or-model').removeClass('collapse');
						delete or.storage[ model ].args.disabled;
						
					}else{
						
						$(this).addClass('disabled').closest('.or-model').addClass('collapse');
						or.storage[ model ].args.disabled = 'on';
						
					}
					
					or.changed = true;
					
				}
				
			}
			
		} ),
				
		column : new or.backbone.views().extend({
			
			render : function( params ){
				
				params.name = 'or_column'; params.end = '[/or_column]';
				
				var _w = params.args['width'];
				if( _w != undefined ){
					if( _w.toString().indexOf('/') > -1 ){
						_w = _w.split('/');
						_w = parseFloat((_w[0]/_w[1])*100).toFixed(4)+'%';
					}else if( _w.toString().indexOf('%') === -1 )
						_w += '%';
				}else{
					_w = '100%';
				}
				
				var el = $( or.template( 'column', { width: _w } ) );

				or.params.process_all( params.args.content, el.find('.or-column-wrap') );
				
				this.el = el;
				
				return el;
				
			},
			
			events : {
				'>.column-container-control .or-column-settings:click' : 'settings',
				'>.or-column-control .or-column-add:click' : 'add',
				'>.or-column-control >.close:click' : 'remove',
			},
			
			
			remove : function( e, id ){
				
				if( !confirm( or.__.sure ) )
					return;
				
				if( id == undefined )
					var id = or.get.model( this );
				
				var col = $( '#model-'+id ),
					row = $( '#model-'+or.get.model( col.parent().get(0) ) );
				
				col.find('.or-model').each(function(){
					delete or.storage[ or.get.model(this) ];
				});
				$('#model-'+id).parent('.or-row-wrap').parent('.or-row.m-r-sortdable').find('#col_six').html("Add a another column to this row") ;	
				col.remove();
				delete or.storage[ id ];
				
				var cols = row.find('> .or-row-wrap > .or-model');
				cols.each(function(){
					var cid = $(this).data('model');
					or.storage[ cid ].args.width = (12/cols.length)+'/12';
					$(this).css({ width: (100/cols.length)+'%' });
				});
				
			},
			
			apply_all : function( el, arg ){
				
				var pop = or.get.popup(el), model = pop.data('model');
			    pop.find('.sl-check.sl-func').trigger('click');
			    
			    try{
				    var data = or.storage[ model ].args[ arg ];
				    $('#model-'+model).parent().find('>div').each(function(){
				    	
				    	model = $(this).data('model');
				    	if( model !== undefined )
				    		or.storage[ model ].args[ arg ] = data;
				    	
				    });
			    }catch( ex ){}
			    
			    event.preventDefault();
			    return false;
				
			}
			
		}),
		
		or_row_inner : new or.backbone.views().extend({
			
			render : function( params ){
				
				params.name = 'or_row_inner'; params.end = '[/or_row_inner]';
				
				var el = $( or.template( 'row-inner' ) );
				
				var content = params.args.content;
				if( content !== undefined )
					content = content.toString().trim();
				else content = '';
				
				if( content.indexOf('[or_column') !== 0 ){
					content = '[or_column_inner width="12/12"]'+
							   content.replace(/or_column_inner/g,'or_column_inner#')+
							   '[/or_column_inner]';
				}			   
					
				or.params.process_all( content, el.find('.or-row-wrap') );
				
				this.el = el;
				
				return el;
			
			},
			
			events : {
				'.or-row-inner-control > .settings:click' : 'settings',
				'.or-row-inner-control > .double:click' : 'double',
				'.or-row-inner-control > .delete:click' : 'remove',
				'.or-row-inner-control > .copyRowInner:click' : 'copy',
				'.or-row-inner-control > .columns:click' : 'columns',
				'.or-row-inner-control > .collapse:click' : 'collapse',
			},
			
			collapse : function(){
				var elm = $('#model-'+or.get.model(this));
				if( !elm.hasClass('collapse') ){
					elm.addClass('collapse');
				}else{
					elm.removeClass('collapse');
				}	
			},
			
			columns : function(){
				
				var columns = $(this).closest('.or-row-inner').find('>.or-row-wrap>.or-column-inner.or-model');

				var pop = or.tools.popup.render( 
							this, 
							{ 
								title: or.__.i42, 
								class: 'no-footer row_layout',
								width: 341,
								content: or.template( 'row-columns', {current:columns.length} ),
								help: 'http://originbuilder.com/documentation/resize-sortable-columns/?source=client_installed' 
							}
						);
						
				pop.find('.button').on( 'click', 
					{ 
						model: or.get.model( this ),
						columns: columns,
						pop: pop
					}, 
					or.views.row.set_columns 
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
			
			copy : function(){
				
				if( $(this).hasClass('copied') )
					return;
					
				$(this).addClass('copied');
				setTimeout( function( el ){ el.removeClass('copied'); }, 1000, $(this) );
				
				or.backbone.copy( this );
				
			}
			
		}),
		
		or_column_inner : new or.backbone.views().extend({
			
			render : function( params ){
				
				params.name = 'or_column_inner'; params.end = '[/or_column_inner]';
				
				var _w = params.args['width'];
				if( _w != undefined ){
					if( _w.toString().indexOf('/') > -1 ){
						_w = _w.split('/');
						_w = ((_w[0]/_w[1])*100)+'%';
					}else if( _w.toString().indexOf('%') === -1 )
						_w += '%';
				}else{
					_w = '100%';
				}
				
				var el = $( or.template( 'column-inner', { width: _w } ) );
	
				if( params.args.content !== undefined && params.args.content != '' )
					or.params.process_all( params.args.content, el.find('.or-column-wrap') );
				
				this.el = el;
					
				return el;
			
			},
			
			events : {
				'>.column-inner-control .or-column-settings:click' : 'settings',
				'>.column-inner-control .or-column-toleft:click' : 'toLeft',
				'>.column-inner-control .or-column-toright:click' : 'toRight',
				'>.or-column-control .or-column-add:click' : 'add',
				'>.or-column-control >.close:click' : 'remove',
			},

			toLeft : function( e ){
				
				var id = 	or.get.model( this ),
					el = 	$('#model-'+id),
					prev = 	el.prev();
				
				if( !prev.get(0))
					return false;
					
				if( or.views.column.change_width( prev.data('model'), -1 ))
					return or.views.column.change_width( id, 1 );
				
			},
			
			toRight : function( e ){
				
				var id = 	or.get.model( this ),
					el = 	$('#model-'+id),
					next = 	el.next();
				
				if( !next.get(0))
					return false;
				
				if( or.views.column.change_width( next.data('model'), -1 ))
					return or.views.column.change_width( id, 1 );
				
			},
			
			remove : function( e  ){
				
				or.views.column.remove( e, or.get.model( this ) );

			},
			
		}),
					
		or_element : new or.backbone.views().extend({
			
			render : function( params ){
				
				var map = $().extend( {}, or.maps._std );
				map = $().extend( map, or.maps[ params.name ] );
				
				var el = $( or.template( 'element', { map : map, params : params } ) );
				
				setTimeout( function( params, map, el ){
					el.append( or.params.admin_label.render({map: map, params: params, el: el }));
				}, parseInt(Math.random()*100)+100, params, map, el );
				
				this.el = el;
					
				return el;
				
			},
			
			events : {
				'>.or-element-control .edit:click' : 'edit',
				'>.or-element-control .delete:click' : 'remove',
				'>.or-element-control .double:click' : 'double',
				'>.or-element-control .more:click' : 'more',
				'>.or-element-control .copy:click' : 'copy',
				'>.or-element-control .cut:click' : 'cut',
				'>.or-element-control:click' : function( e ){
					var tar = $(e.target);
					if( tar.hasClass('more') || tar.parent().hasClass('more') )
						return;
					$(this).find('.active').removeClass('active');
				},
			},
			
			edit : function( e ){
				
				var pop = or.backbone.settings( this );
				if( !pop ){
					alert( or.__.i43 );
					return;
				}	
				
				$(this).closest('.or-element').addClass('editting');
				pop.data({cancel: function(pop){
					
					$( pop.data('button') ).closest('.or-element').removeClass('editting');
					
				},after_callback : function( pop ){
					
					var id = or.get.model( pop.data('button') ),
						params = or.storage[ id ], 
						map = $().extend( {}, or.maps._std ),
						el = $('#model-'+id);
					
					map = $().extend( map, or.maps[ params.name ] );
					el.find('>.admin-view').remove();
					el.append( or.params.admin_label.render({map: map, params: params, el: el }));
	
				}});
				
			}
			
		}),
							
		or_undefined : new or.backbone.views().extend({
			
			render : function( params ){
				
				var map = $().extend( {}, or.maps._std );
				map = $().extend( map, or.maps[ params.name ] );
				
				var el = $( or.template( 'undefined', { map : map, params : params } ) );
				
				this.el = el;
				
				return el;
				
			},
			
			events : {
				'>.or-element-control .edit:click' : 'edit',
				'>.or-element-control .delete:click' : 'remove',
				'>.or-element-control .double:click' : 'double'
			},
			
			edit : function( e ){

				var pop = or.backbone.settings( this );
				if( !pop ){
					alert( or.__.i45 );
					return;
				}	
				
				$(this).closest('.or-element').addClass('editting');
				pop.data({cancel: function(pop){
					
					$( pop.data('button') ).closest('.or-element').removeClass('editting');
					
				},after_callback : function( pop ){
					
					$( pop.data('button') ).closest('.or-element').removeClass('editting');
					
					var id = or.get.model( pop.data('button') ),
						params = or.storage[ id ], 
						map = $().extend( {}, or.maps._std ),
						el = $('#model-'+id);
					
					map = $().extend( map, or.maps[ params.name ] );
					el.find('>.admin-view').remove();
					el.append( or.params.admin_label.render({map: map, params: params, el: el }));
	
				}});
				
			},
			
			remove : function( e ){
				if( confirm( or.__.sure ) ){
					var elm = $(this).closest('div.or-element');
					var mid = elm.data('model');
					elm.remove();
					delete or.storage[mid];	
				}
			}
			
		}),

	} );
	
} )( jQuery );