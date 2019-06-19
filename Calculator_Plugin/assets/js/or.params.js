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
		
	$().extend( or.params, {

		process : function(){
			
			if( typeof( tinyMCE ) != 'undefined' )
				tinyMCE.triggerSave();
			var content = $('#content').val();

			if( content === undefined || content === '' )
				return;

			content = content.replace( /\[vc\_/g,'[or_' ).replace( /\[\/vc\_/g,'[/or_' ).replace( /\[mini\_/g,'[or_' ).replace( /\[\/mini\_/g,'[/or_' ).toString().trim();

			this.process_rows( content );

		},

		process_rows : function( content ){
			
			var atts = '';
			if( content.indexOf('[or_row') !== 0 ){
				
				var params = or.params.merge( 'or_row' );
				
				for( var i in params ){
					if( typeof( params[i] ) == 'object' && typeof( params[i].value ) != 'undefined' )
						atts += ' '+params[i].name
							 +'="'+or.tools.esc_attr( params[i].value )+'"';
				}
				content = '[or_row'+atts+']'+content.replace(/or_row/g,'or_row#')+'[/or_row]';
				
				delete params;
				
			}
			
			this.process_shortcodes( content, function( args ){

				or.views.row.render( args );

			}, 'or_row' );

		},
		
		process_columns : function( content, parent_row ){
			
			this.process_shortcodes( content, function( args ){

				parent_row.append( or.views.column.render( args ) );

			}, 'or_column' );

		},

		process_all : function( content, parent_wrp, js_views ){

			if( content === '' )
				return false;

			if( parent_wrp === undefined )
				return false;

			var thru = false, first = true, id, btn, js_view;
			or.params.process_shortcodes( content, function( args ){

				thru = true;
				args.parent_wrp = parent_wrp;
				args.first = first;
				first = false;

				if( or.maps[ args.name ] === undefined ){
					args.name = 'or_undefined';
					args.end = '[/or_undefined]';
					args.args.content = args.full;
				}

				if( _.isUndefined( js_views ) ){

					js_view = args.name;

					if( or.maps[ args.name ].views !== undefined ){
						if( or.maps[ args.name ].views.type !== undefined )
							js_view = or.maps[ args.name ].views.type;
						if( or.maps[ args.name ].views.default !== undefined && args.args.content === '' )
							args.args.content = or.maps[ args.name ].views.default;
					}

				}else{
					js_view = js_views;
				}
				var el;
				if( typeof or.views[ js_view ] == 'object' ){
					el = or.views[ js_view ].render( args );
				}else{
					el = or.views.or_element.render( args );
				}

				id = el.data('model');
				parent_wrp.append( el );

				if( js_view == 'views_section' ){
					setTimeout(function( content, el ){
						or.params.process_all( content, el );
					},1, args.args.content, el.find('> .or-views-section-wrap') );
					or.views.views_section.init( args, el );
				}

			}, or.tags );

			if( thru === false ){

				var el = or.views.
							  or_undefined.
							  render({
									args: { content: content },
									name: 'or_undefined',
									end: '[/or_undefined]',
									full: content
							  });
				id = el.data('model');
				parent_wrp.append( el );

			}else if( js_views === 'views_section' ){
				setTimeout( function(el){ or.ui.views_sections( el ); }, 1, parent_wrp );
			}

			return id;
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

		process_shortcodes : function( input, callback, tags ){

			if( _.isUndefined( input ) )
				return null;

			var regx = new RegExp( '\\[(\\[?)(' + tags + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)', 'g' ), result, agrs, content = input;

			var split_arguments = /([a-zA-Z0-9\-\_]+)="([^"]+)+"/gi;

			while ( result = regx.exec( input ) ) {

				var paramesArg 	= [];
				while( agrs = split_arguments.exec( result[3]) ){
					paramesArg[ agrs[1] ] = agrs[2];
				}
				var args = {
					full		: result[0],
					name 		: result[2],
					/*parames 	: result[3],*/
					/*content 	: result[5],*/
					end		 	: result[6],
					args	 	: paramesArg,
					/*input		: input,
					result		: result*/
				};
				if( !_.isUndefined( result[5] ) ){
					args.args.content = or.params.process_alter( result[5], result[2] );
				}
				callback( args );
				content = content.replace( result[0], '' );

			}
			if( content !== '' )
				callback({ full: content, name: 'or_column_text', end: '[/or_column_text]', args: { content: content } });

		},

		admin_label : {

			render : function( data ){

				var html = '', item = '';
				/**
				*	register admin view
				*/
				if( data.map.admin_view !== undefined )
				{
					if( typeof( window[data.map.admin_view] ) == 'function' )
						item = window[data.map.admin_view]( data.params.args, data.el );
					else if( typeof or.params.admin_view[data.map.admin_view] == 'function' )
						item = or.params.admin_view[data.map.admin_view]( data.params.args, data.el );
					else console.log('or Error: the admin_view function "'+data.map.admin_view+'" is undefined');

					if( item !== '' )
					{
						return '<div class="admin-view custom-admin-view '+data.map.admin_view+'">'+item+'</div>';
					}

				}

				var dmp = data.map.params, dp = data.params, mpa = or.params.admin_label;

				for( var n in dmp ){

					item = '';

					if( dmp[n].name == 'image' && dp.args[dmp[n].name] === undefined )
						dp.args[dmp[n].name] = 'undefined';

					if( dmp[n].admin_label === true && dp.args[dmp[n].name] !== undefined ){

						if( typeof mpa[dmp[n].type] == 'function' )
						{
							item = mpa[dmp[n].type](
								dp.args[dmp[n].name], dmp[n].label, data.el
							);
						}
						else
						{
							item = '<span class="admin-view-label"><strong>'+dmp[n].name+'</strong></span> : ';
							item += or.tools.unesc_attr( dp.args[dmp[n].name] );
						}

						if( item !== '' )
						{

							html += '<div class="admin-view '+dmp[n].name+'" data-name="'+dmp[n].name+'">'+item+'</div>';

						}
					}
				}

				return html;

			},

			update : function(){

				clearTimeout( this.timer );

				this.timer = setTimeout(function(el){

					var name = $(el).data('name').trim(),
						model = or.get.model( el );

					if( or.storage[ model ] === undefined )
						return;

					or.storage[ model ].args[ name ] = el.innerHTML;

					if( name == 'content' )
						or.storage[ model ].content = el.innerHTML;

					or.changed = true;

				}, 500, this );

			},

			attach_image : function( id ){

				return '<img src="'+or_ajax_url+'?action=or_get_thumbn&id='+id+'" />';
			},

			attach_images : function( ids ){

				if( ids === undefined || ids === '' )
					return '<img src="'+or_ajax_url+'?action=or_get_thumbn&id=undefined" />';

				var html = '';
				ids.split(',').forEach( function( id ){
					html += '<img src="'+or_ajax_url+'?action=or_get_thumbn&id='+id+'&size=thumbnail" />';
				});
				return html;

			},

			textarea_html : function( content ){
				return content;
			},
			
			editor : function( content ){
				return or.tools.base64.decode( content );
			},

			textarea : function( content ){
				var string = or.tools.esc( or.tools.base64.decode( content.replace(/(?:\r\n|\r|\n)/g,'') ) ).toString();
				if( string.length < 350 )
					return string;
				else return string.substr(0, 347)+'...';
			},

			or_box : function( content ){

				var html = '', obj;
				try{
					content = or.tools.base64.decode( content.replace(/(?:\r\n|\r|\n)/g,'') ).toString();
					content = content.replace(/\%SITE\_URL\%/g,site_url).replace(/\%SITE\_URI\%/g,site_url);
					obj = JSON.parse( content );
				}catch(e){
					obj = [{tag:'div',children:[{tag:'text', content:'There was an error with content structure.'}]}];
				}
				function loop( items ){

					if( items === undefined || items === null )
						return '';

					var html = '';

					items.forEach( function(n){

						if( n.tag != 'text' ){

							html += '<'+n.tag;

							if( typeof n.attributes != 'object' )
								n.attributes = {};

							if( n.tag == 'column' ){
								n.attributes.class += ' '+n.attributes.cols;
							}else if( n.tag == 'img' ){
								if( n.attributes.src === undefined || n.attributes.src === '' )
									n.attributes.src = plugin_url+'/assets/images/get_logo.png';
							}

							for( var i in n.attributes )
								html += ' '+i+'="'+n.attributes[i]+'"';

							if( n.tag == 'img' )
								html += '/';

							html += '>';

							if( typeof n.children == 'object' )
								html += loop( n.children );

							if( n.tag != 'img' )
								html += '</'+n.tag+'>';

						}else html += n.content;

					});

					return html;

				}

				return loop( obj );
			},

			wp_widget : function( data ){
				
				var obj;
				try{
					obj = JSON.parse( or.tools.base64.decode( data ) );
				}catch(e){
					return 'There was an error with content structure.';
				}
				var html = '', vl, prp;
				for( var n in obj ){
					html += '<strong class="prime">'+n.replace(/\-/g,' ').replace(/\_/g,' ')+'</strong>: ';
					prp = [];
					for( var m in obj[n] ){
						if( obj[n][m] !== '' ){
							vl = or.tools.esc( obj[n][m] );
							if( vl.length > 250 )
								vl = vl.substr(0,247)+'...';
							prp[prp.length] = '<strong>'+m+'</strong>: '+vl;
						}
					}
					html += prp.join(', ');
				}
				return html;
			},

			icon_picker : function( data, label, el ){

				return '<i class="'+data+'" style="font-size: 14px;margin: 0px;font-weight: bold;"></i>';

			},

			color_picker : function( data, label ){
				return '<strong>'+label+'</strong>: '+data+' <span style="background: '+data+'"></span>';
			}

		},

		admin_view : {

			image : function( params, el ){

				var url = or_ajax_url+'?action=or_get_thumbn&id=undefined',
					mid = ( params.image !== undefined ) ? params.image : '';

				if( params.image_source !== undefined ){

					switch( params.image_source ){

						case 'media_library':
							url = or_ajax_url+'?action=or_get_thumbn&id='+mid;
						break;
						case 'external_link':
							url = params.image_external_link;
						break;

					}

				}

				setTimeout(function(el){

					el.find('.admin-view.custom-admin-view img')
						.attr({title: 'Click to select media from library' })
						.css({cursor: 'pointer' })
						.on( 'click', { callback: function( atts ){

							var url = atts.url;

							if( typeof atts.sizes.medium == 'object' )
								url = atts.sizes.medium.url;

							this.el.src = url;
							var model = or.get.model( this.el );

							if( or.storage[ model ] === undefined )
								return;

							or.storage[ model ].args[ 'image' ] = atts.id;
							or.storage[ model ].args[ 'image_source' ] = 'media_library';

							$(this.el).parent().find('.or-param').val( atts.id );

							or.changed = true;

					}, atts : { frame: 'select' } }, or.tools.media.open );

				}, 10, el);

				return '<input type="hidden" class="or-param" value="'+mid+'" /><img src="'+url+'" />';

			},

			gmaps : function( params, el ){

				var value = '', html = '';
				
				if ( typeof( params['title'] ) != 'undefined' && params['title'] !== '' )
					html += '<strong>Title</strong>: '+params['title']+' ';
				
				if ( typeof( params['map_location'] ) != 'undefined' && params['map_location'] !== '' )
					value = or.tools.base64.decode( params['map_location'] );

				if ( value !== '' ){
					value = value.match(/src\=\"([^\s]*)\"\s/);
					if( value !== null && typeof( value[1] ) != 'undefined' ){
						value = value[1].split('!');
						value = value[value.length-6].substr(2);
						if( value.match(/[^0-9,.]/) !== null )
							html += '<strong>Location</strong>: '+decodeURIComponent(value).replace(/[^a-zA-Z ]/g, " ");
					}
				}
				
				return html;
			},

			text : function( params, el ){

				setTimeout( function(el){

					el.find('.admin-view.custom-admin-view')
					  .attr({contentEditable : true})
					  .data({name: 'content'})
					  .on( 'keyup', or.params.admin_label.update );

					  if( window.chrome === undefined ){

						  el.find('.admin-view.custom-admin-view')
						  .on( 'mousedown', function( e ){
							  var el = this;
							  while( el.parentNode ){
								  	el = el.parentNode;
								  	if( el.draggable === true ){
								  		el.draggable = false;
								  		el.templDraggable = true;
								  	}
							  }
						  }).on( 'blur', function( e ){
							  var el = this;
							  while( el.parentNode ){
								  	el = el.parentNode;
								  	if( el.templDraggable === true ){
								  		el.draggable = true;
								  		el.templDraggable = null;
								  	}
							  }
						  });
					  }

				}, 10, el );
				
				return switchEditors.wpautop( params['content'] );
				//return params['content'];

			}

		},

		fields : {

			render : function( el, params, data ){

				if( typeof params != 'object' )
					return false;

				var param, value, atts;

				for( var index in params )
				{

					param = params[ index ]; value = '';

					if( data[param.name] !== undefined )
						value = data[param.name];
					else if( param !== undefined && param.value !== undefined )
					{
					
						value = param.value.toString();
						
						if( value.indexOf( '%time%' ) > -1 ){
							var d = new Date();
							value = value.replace( '%time%', d.getTime() );
						}
		
					}

					if( value == '__empty__' )
						value = '';

					if( or_param_types_support.indexOf( param.type ) == -1 )
						param.type = 'undefined';

					atts = {
							value 	: value,
							options : (( param.options !== undefined ) ? param.options : [] ),
							params : (( param.params !== undefined ) ? param.params : [] ),
							name	: param.name,
							type	: param.type
						};

					if( param.type != 'textarea_html' )
						atts.value = or.tools.unesc_attr( atts.value );

					var tmpl_html = or.template( 'field', {
										label: param.label,
										content: or.template( 'field-type-'+param.type, atts ),
										des: param.description,
										name: param.type,
										base: param.name,
										relation: param.relation
									});
					
					tmpl_html = tmpl_html.replace( /\&lt\;script/g, '<script' ).replace( /\&lt\;\/script\&gt\;/g, '</script>' );
					
					var field = $( tmpl_html );
					
					$( el ).append( field );

					if( param.relation !== undefined ){

						var thru = false, pr = param.relation;

						if( pr.parent !== undefined && ( pr.show_when !== undefined || pr.hide_when !== undefined  ) ){

							var parent = el.find('>.field-base-'+pr.parent);

							if( parent.get(0) ){

								if( parent.data('child') !== undefined )
								{
									var child = parent.data('child');
									child[child.length] = field;
								}
								else
								{
									var child = [];
									child[0] = field;
								}

								parent.data({ child : child });

								var iparent = parent.find('input.or-param[type="radio"],input.or-param[type="checkbox"],select.or-param');
								if( pr.show_when !== undefined ){
									if( typeof pr.show_when != 'object' )
										pr.show_when = pr.show_when.toString().split(',');
								}
								if( pr.hide_when !== undefined ){
									if( typeof pr.hide_when != 'object' )
										pr.hide_when = pr.hide_when.toString().split(',');
								}

								if( iparent.get(0) ){

									thru = true;
									iparent.on( 'change',

										{ el : field, show: pr.show_when, hide: pr.hide_when, iparent: iparent, parent : parent },

										function(e){

											var vparent = e.data.iparent.serializeArray(), sh, hi;
											if( e.data.show !== undefined )sh = false;
											if( e.data.hide !== undefined )hi = true;
											for( var n in vparent ){
												if( e.data.show !== undefined ){
													if( e.data.show.indexOf( vparent[n].value ) > -1 ){
														e.data.el.removeClass('relation-hidden');
														sh = true;
													}
												}
												if( e.data.hide !== undefined ){
													if( e.data.hide.indexOf( vparent[n].value ) > -1 ){
														e.data.el.addClass('relation-hidden');
														hi = false;
													}
												}
											}
											if( e.data.show !== undefined ){
												if( sh === false )
													e.data.el.addClass('relation-hidden');
											}
											if( e.data.hide !== undefined ){
												if( hi === true )
													e.data.el.removeClass('relation-hidden');
											}

											if( e.data.parent.hasClass('relation-hidden'))
												e.data.el.addClass('relation-hidden');

											if( e.data.el.data('child') !== undefined ){
												if( e.data.el.hasClass('relation-hidden') ){

													function hide_children( child ){
														child.forEach( function(_child){
															_child.addClass('relation-hidden');
															if( _child.data('child') !== undefined ){
																hide_children( _child.data('child') );
															}
														});
													}

													hide_children( e.data.el.data('child') );

												}else{
													e.data.el.find('input.or-param[type="radio"],input.or-param[type="checkbox"],select.or-param').trigger('change');
												}
											}

										}
									).addClass('m-p-rela');

									iparent.trigger('change');

								}
							}
						}
						/*Show back if invalid config*/
						if( thru === false )
							field.removeClass('relation-hidden');
					}

					if( typeof atts.callback == 'function' ){
						/* callback from field-type template */
						setTimeout( atts.callback, 1, field, $, atts );
					}

				}
				
				$(el).find('.or-param').on( 'change', function(e){
					
					var pop = or.get.popup( el );
					
					if( pop === null || typeof pop.data('change') ===  undefined )
						return;
						
					var calb = pop.data('change');
					if( typeof calb == 'function' ){
						calb( this );
					}else if( calb !== undefined && calb.length > 0 ){
						for( i = 0; i< calb.length; i++ ){
							if( typeof calb[i] == 'function' )
								calb[i]( this, pop );	
						}
					}
					
				});

			},
			
			tabs : function( tab, form ){
					
				form.addClass('fields-edit-form'); // make this form as settings param to save
					
				var model = or.get.model( tab ),
					tab_content = $(tab).closest('.m-p-wrap').find('.m-p-body').find('>.'+$(tab).data('tab') ),
					fields = $(tab).closest('.m-p-wrap').find('.m-p-body').find('>.fields-edit-form');
					
				var cfg = $(tab).data( 'cfg' ).split('|'),
					data = or.storage[ cfg[1] ],
					map = $().extend( {}, or.maps['_std'] );

				if( data === undefined || or.maps[ data.name ] === undefined )
					return false;
					
				map = $().extend( map, or.maps[ cfg[2] ] );
				
				or.params.fields.render( tab_content, map.params[cfg[0]] , data.args );
				
				$(tab).data( 'callback', function( tit, tab ){

					

				});

				return tab_content;
				
			},
			
			animate : {
				visual : function( tab ){
					var data = [
						{
							name:'ani-element',
							label:'Animate Element',
							content:'',
							des:''
						},
						{
							name:'event',
							label:'Event',
							content:'',
							des:''
						},
						{
							name:'effect',
							label:'Effect',
							content:'',
							des:''
						}	
					];
					var html = '';
					for(var i = 0; i < data.length; i++){
						html += or.template('animate',data[i]);
					}
					
					return html;
				}
			},
			
			css_box : {

				test : document.createElement('div'),

				save : function( pop ){
					
					var tab = pop.find('.or-pop-tabs .or-tab-code-css-title'), 
						tab2 = pop.find('.or-pop-tabs .or-tab-visual-css-title');

					if( tab.length === 0 )
						return;

					if( !tab2.hasClass('active') ){
						tab2.trigger('click');
					}

					if( !tab.hasClass('active') ){
						tab.trigger('click');
					}
					
					var model = or.get.model( pop ),
						css = pop.find('.or-css-box-code-tab textarea').val();;
					
					css = css.replace( /\s+/g, ' ' )
							 .replace(/\/\*[^\/\*]+\*\//g,'')
							 .replace(/[^a-zA-Z0-9\-\_\. \:\(\)\%\+\~\;\#\,\'\/]+/g,'')
							 .trim();
					if( css !== '' )
					{
						if( or.storage[model] !== undefined )
						{
							or.storage[model].args.css =
							'or-css-'+parseInt(Math.random()*10000000 )+'|'+or.tools.esc_attr( css );
						}
						else pop.data({ css: or.tools.esc_attr( css ) });
					}else{
						try{ delete or.storage[model].args.css; }catch(e){}
						pop.data({ css: '' });
					}
				},

				visual : function( tab ){

					var model = or.get.model( tab ),
						tab_content = $(tab).closest('.m-p-wrap').find('.m-p-body').find('>.'+$(tab).data('tab') ),
						fields = $(tab).closest('.m-p-wrap').find('.m-p-body').find('>.fields-edit-form'),
						css = '';
					
					if( or.storage[model] !== undefined ){
						if( or.storage[model].args !== undefined ){
							if( or.storage[model].args.css !== undefined ){
								css = or.tools.unesc_attr( or.storage[model].args.css );
								if( css.split('|').length > 1 )
									css = css.split('|')[1];
							}
						}
					}else{
						css = or.tools.unesc_attr( or.get.popup( tab ).data('css') );
					}

					tab_content.addClass('or-css-box-visual-tab');

					var css_obj =  or.params.fields.css_box.to_visual( css );

					or.params.fields.render( tab_content, or.maps['or_css_box'].params, css_obj );

					$(tab).data( 'callback', function( tit, tab ){

						var ccw = tab.parent().find('.or-css-box-code-tab');
						if( !ccw.get(0) )
							return;

						var css_code = ccw.find('textarea').val();
						css_code = or.params.fields.css_box.to_visual( css_code );
						
						$('.sys-colorPicker').remove();
						
						tab.html('');

						or.params.fields.render( tab, or.maps['or_css_box'].params, css_code );

					});

					return tab_content;

				},

				code : function( tab ){

					var model = or.get.model(tab), css = '',
						tab_content = $(tab).closest('.m-p-wrap').find('.m-p-body>.'+$(tab).data('tab') );
	
					$(tab).data( 'callback', function( tit, tab ){
	
						var cvw = tab.parent().find('.or-css-box-visual-tab'),
							css = tab.find('textarea').val(),
							cssBox = or.params.fields.css_box,
							cssObj = {},
							cssStr = '',
							ind;
		
						css = css.replace( /\s+/g, ' ' )
								 .replace(/\/\*[^\/\*]+\*\//g,'')
								 .replace(/[^a-zA-Z0-9\-\_\. \:\(\)\%\+\~\;\,\#\'\/]+/g,'')
								 .trim().split( ';' );
		
						for( var n in css ){
							if( css[n].trim() !== '' ){
								ind = css[n].indexOf(':');
								if( ind > -1 ){
									cssObj[ css[n].substring( 0, ind ).trim() ] = css[n].substring( ind+1 ).trim();
								}
							}
						}
		
						if( cvw.get(0) ){
		
							for( var n in { margin:'', padding: '', border: '', background: '' } ){
								for( var m in cssObj ){
									if( m == n || m.indexOf[n+'-'] > -1 )
										delete cssObj[m];
								}
							}
		
							cssObj = $().extend( cssObj, cssBox.from_visual( cvw ) );
		
						}
		
						cssObj = cssBox.group( cssObj );
		
						var pos = { 'color': 0, 'image': 1, 'repeat': 2, 'attachment': 3, 'position': 4 };
						/*, 'origin': 6, 'clip': 7 */
		
						if( cssObj['background'] === undefined )
							cssObj['background'] = '';
		
						if( cssObj['background'].indexOf('url') > -1 ){
							for( n in cssObj ){
								if( n != 'background' && n.indexOf('background-') > -1 ){
									if( n == 'background-size' )
										cssStr += n+': '+cssObj[n]+'; ';
									delete cssObj[n];
								}
							}
						}else
						{
							for( n in cssObj ){
								if( n != 'background-color' && n.indexOf('background') > -1 )
									delete cssObj[n];
							}
						}
		
						for( n in cssObj ){
							if( cssObj[n] !== '' )
								cssStr = n+': '+cssObj[n]+'; '+cssStr;
						}
		
						cssStr = cssStr.replace( /\s+/g, ' ' )
									   .replace(/\/\*[^\/\*]+\*\//g,'')
									   .replace(/[^a-zA-Z0-9\-\_\. \:\(\)\%\+\~\;\#\,\'\/]+/g,'')
									   .replace(/\; /g,";\n").trim();
						tab.find('textarea').val( cssStr );

					});

					tab_content.addClass('or-css-box-code-tab');

					if( or.storage[model] !== undefined ){
						if( or.storage[model].args !== undefined ){
							if( or.storage[model].args.css !== undefined ){
								css = or.storage[model].args.css;
								if( css.split('|').length > 1 )
									css = css.split('|')[1];
							}
						}
					}else{
						css = or.tools.unesc_attr( or.get.popup( tab ).data('css') );
					}
					css = css.replace( /\s+/g, ' ' ).replace(/\/\*[^\/\*]+\*\//g,'').replace(/\; /g,";\n").trim();

					return '<textarea style="max-width: 550px;" cols="74" rows="12">'+css+'</textarea><i class="ntips">'+or.__.i44+'</i>';

				},
				
				to_visual : function( css ){

					$( this.test ).attr({ style : css });
					var test = this.test.style;

					var atts = { 'background-image-option' : '' },
						m = '', pos = { top : 0, left : 3, bottom : 2, right : 1 }, ind;

					css = css.replace( /\s+/g, ' ' ).replace(/\/\*[^\/\*]+\*\//g,'').trim().split( ';' );

					var prop = function( input ){
						input = input.split(' ');
						var rt;
						switch( input.length ){
							case 1 : rt = input[0]+' '+input[0]+' '+input[0]+' '+input[0]; break;
							case 2 : rt = input[0]+' '+input[1]+' '+input[0]+' '+input[1]; break;
							case 3 : rt = input[0]+' '+input[1]+' '+input[2]+' '+input[1]; break;
							default : rt = input[0]+' '+input[1]+' '+input[2]+' '+input[3]; break;
						}
						return rt;
					};

					var border = { a : false, b : false };

					for( var n in css){

						if( css[n].indexOf(':') > -1 ){

							m = [];
							ind = css[n].indexOf(':');
							m[0] = css[n].substring( 0, ind ).trim();
							m[1] = css[n].substring( ind+1 ).trim();

							if( m[1] !== '' ){
								if( m[0] == 'margin' || m[0] == 'padding' ){

									atts[ m[0] ] = prop( m[1] );

								}else if( m[0].indexOf('margin') === 0 || m[0].indexOf('padding') === 0 ){

									m[0] = m[0].split('-');
									if( atts[ m[0][0] ] === undefined )
										atts[ m[0][0] ] = '';

									atts[ m[0][0] ] = prop( atts[ m[0][0] ] ).split(' ');

									if( m[1].indexOf('!important') > -1 )
										atts[ m[0][0] ][4] = '!important';

									atts[ m[0][0] ][ pos[m[0][1]] ] = m[1].replace('!important','').trim();

									atts[ m[0][0] ] = atts[ m[0][0] ].join(' ');

								}else if( m[0].indexOf('background') === 0 ){

									atts['background-image'] = test.backgroundImage.replace('url(','').replace(/[\"|\'|\)|\(]/g,'').trim();
									atts['background-color'] = (test.backgroundColor!='initial')?test.backgroundColor:'';
									if( atts['background-color'].indexOf('rgb(' > -1) )
										atts['background-color'] = or.tools.rgb2hex( atts['background-color'] );

									if( atts['background-image'] != '' && atts['background-image'] != 'initial' && atts['background-image'] != 'none' ){
										atts['background-image-option'] = 'yes';
										atts['background-image'] = test.backgroundImage.replace('url(','').replace(/[\"|\'|\)|\(]/g,'').trim();
										atts['background-repeat'] = (test.backgroundRepeat!='initial')?test.backgroundRepeat:'';
										atts['background-position'] = (test.backgroundPosition!='initial')?test.backgroundPosition:'';
										atts['background-attachment'] = (test.backgroundAttachment!='initial')?test.backgroundAttachment:'';
										atts['background-size'] = (test.backgroundSize!='initial')?test.backgroundSize:'';
									}else{
										for( var n in atts ){
											if( n != 'background-color' && n.indexOf('background') > -1 )
												delete atts[n];
										}
									}
								}else{
									atts[ m[0] ] = m[1];
								}

								if( m[0] == 'border' )
									border.a = true;
								if( m[0].indexOf('border-') > -1 )
									border.b = true;

								if( border.b == true && border.a == false ){
									if( atts['border-width'] !== '' && atts['border-style'] !== '' && atts['border-color'] !== '' &&
										atts['border-width'] !== undefined && atts['border-style'] !== undefined &&
										atts['border-color'] !== undefined ){
										atts['border'] = atts['border-width']+' '+atts['border-style']+' '+atts['border-color'];
										delete atts['border-width'];
										delete atts['border-style'];
										delete atts['border-color'];
									}else{
										for( var i in atts ){
											if( i.indexOf('border') > -1 )
												delete atts[i];
										}
										atts['border'] = '';
									}
								}

							}
						}
					}

					return atts;

				},

				from_visual : function( obj ){

					var atts = {};

					obj.find('.or-param').each(function(){
						if( this.type!='checkbox'||(this.type == 'checkbox' && this.checked == true && this.value != '')){
							
							if( this.value.match(/^[0-9]+$/) != null )
									this.value = this.value+'px';

							if( this.name == 'background-image' ){
								this.value = this.value.replace('url(','').replace(/[\"|\'|\)|\(]/g,'').trim();
								if( this.value != '' )
									this.value = 'url('+this.value.replace('url(','').replace(/[\"|\'|\)|\(]/g,'').trim()+')';
								else return;
							}

							atts[this.name] = this.value;

						}
					});

					if( atts['background-image-option'] == undefined || atts['background-image-option'] == ''){
						for( var i in atts ){
							if( i != 'background-color' && i.indexOf('background-') >-1 )
								delete atts[i];
						}
					}
					if( atts['border-width'] != '' && atts['border-style'] != '' && atts['border-color'] != '' &&
						atts['border-width'] != undefined && atts['border-style'] != undefined &&
						atts['border-color'] != undefined ){
						atts['border'] = atts['border-width']+' '+atts['border-style']+' '+atts['border-color'];
						delete atts['border-width'];
						delete atts['border-style'];
						delete atts['border-color'];
					}else{
						for( var i in atts ){
							if( i.indexOf('border') >-1 )
								delete atts[i];
						}
						atts['border'] = '';
					}

					return atts;

				},

				group : function( atts ){

					var ok, pos;

					for( var tag in { margin:'', padding:'', border:'', background:'' } ){

						ok = true;
						pos = { top: 0, right: 1, bottom: 2, left: 3, important: 4 };

						if( tag != 'background' ){

							if( tag == 'border' )
								pos = { width: 0, style: 1, color: 2, important: 3 };

							for( var i in pos ){
								if( ( atts[tag+'-'+i] == undefined || atts[tag+'-'+i] == '' ) && i != 'important' )
									ok = false;
							}
							if( ok == true ){

								atts[tag] = '';
								var same = atts[tag+'-top'];

								for( var i in pos ){
									if( atts[tag+'-'+i] != undefined && atts[tag+'-'+i] != '' ){

										atts[tag] += atts[tag+'-'+i]+' ';
										if( i != 'important' && atts[tag+'-'+i] != same )
											same = false;

										delete atts[tag+'-'+i];

									}
								}
								if( same != false ){

									atts[tag] = same;

									if( atts[tag+'-important'] != undefined && atts[tag+'-important'] != '' )
										atts[tag] += atts[tag+'-important'];
								}
							}

						}else{
							pos = { 'color': 0, 'image': 1, 'repeat': 2, 'attachment': 3, 'position': 4 };
							/*, 'origin': 6, 'clip': 7 */

							if( atts['background-image'] != undefined && atts['background-image-option'] == 'yes' ){
								atts['background'] = '';
								for( var i in pos ){
									if( atts['background-'+i] != undefined ){
										atts['background'] += atts['background-'+i]+' ';
										delete atts['background-'+i];
									}
								}
								atts['background'] = atts['background'].trim();
							}
						}
					}

					return atts;

				}

			},
						
			group : {

				callback : function( wrp ){

					this.el = wrp;

					or.trigger( this );
					wrp.find('.or-group-row').first().addClass('active');

					this.re_index( wrp );

					this.sortable();

				},

				events : {
					'.or-group-rows:click': 'actions',
					'.or-add-group:click': 'add_group',
				},

				actions : function( e ){

					var target = $( e.target );

					if( target.data('action') )
					{
						var wrp = $(this).closest('.or-param-row.field-group');
						switch( target.data('action') )
						{
							case 'collapse' : e.data.collapse( target ); break;
							case 'delete' : e.data.remove( target, e.data, wrp ); break;
							case 'double' : e.data.double( target, e.data, wrp ); break;
						}
					}

				},

				collapse : function( el ){

					var row = el.closest('.or-group-row');

					if( row.hasClass('active') )
					{
						row.removeClass('active');
					}
					else
					{
						el.closest('.or-group-rows').
								find('.or-group-row.active').
								removeClass('active');

						row.addClass('active');

					}
				},

				remove : function( el, obj, wrp  ){

					if( confirm( or.__.sure ) ){
						el.closest('.or-group-row').remove();
						obj.re_index( wrp );
					}

				},

				double : function( el, obj, wrp  ){

					var row = el.closest('.or-group-row'),
						clone_values = row.find('.or-param').serializeArray(),
						values = {},
						grow = $( or.template( 'param-group' ) ),
						index = row.find('.or-param').get(0).name;

					index = index.substring( index.indexOf('[')+1, index.indexOf(']') );

					params = or.params.fields.group.set_index( wrp.data('params'), wrp.data('name'), index );

					row.after( grow );

					$.map( clone_values, function( n, i ){
						if( n['name'] != undefined )
							values[ n['name'] ] = n['value'];
					});

					or.params.fields.render( grow.find('.or-group-body'), params, values );

					// reset index of groups list
					or.params.fields.group.re_index( wrp );

					obj.collapse( grow.find('li.collapse') );

					obj.sortable();

				},

				add_group : function( e ){

					var wrp = $(this).closest('.or-param-row.field-group');

					var grow = $( or.template( 'param-group' ) );
					$(this).before( grow );

					var params = or.params.fields.group.set_index( wrp.data('params'), wrp.data('name'), 0 );
					
					or.params.fields.render( grow.find('.or-group-body'), params, {} );

					// reset index of groups list
					or.params.fields.group.re_index( wrp );

					e.data.collapse( grow.find('li.collapse') );

					e.data.sortable();

				},

				set_index : function( data_params, data_name, index ){

					var params = [];
					for( var i=0; i<data_params.length; i++ )
					{
						if( data_params[i]['type'] != 'group' )
						{
							params[ params.length ] = $().extend( {}, data_params[i] );
							if( data_params[i]['name'].indexOf( data_name+'[' ) == -1 )
								params[ params.length-1 ]['name'] = data_name+'['+index+']['+data_params[i]['name']+']';
						}
					}
					
					return params;

				},

				re_index : function( wrp ){

					var i = 1;
					wrp.find('.or-group-row').each(function(){
						
						var label = $(this).find('input, select, textarea').each(function(){
							if( this.name.indexOf('[') > -1 ){
								
								var name = this.name.substring( 0, this.name.indexOf('[')+1 );
								name += i;
								name += this.name.substr( this.name.indexOf(']') );
								this.name = name;
							}
							
							this.label = this.name.substr( this.name.indexOf('][')+2 ).replace(']','');
							
						}).first().off('blur').on('blur',function(){
							
							var ct = $(this).closest('.or-group-row').find('li.counter');
							ct.html( this.label+': '+or.tools.esc( this.value ) );
							
						}).get(0);
						
						$(this).find('li.counter').html( label.label+': '+or.tools.esc( label.value ));
						i++;
						
					});

				},

				sortable : function(){

					or.ui.sortable({

						items : 'div.or-group-rows>div.or-group-row',
						handle : '>.or-group-controls',
						helper : ['or-ui-handle-image', 25, 25 ],
						connecting : false,
						vertical : true,
						end : function( e, el ){
							or.params.fields.group.re_index( $(el).closest('.or-param-row.field-group') );
						}

					});
				}

			},

		},
		
		merge : function( name ){
			
			if( name === undefined || name == '' || or.maps[ name ] === undefined )
				return [];
				
			var params = or.maps[ name ].params, merge = [];
			
			if( params[0] !== undefined ){
				
				return params;
			
			}else{
				
				var i, j;
				for( i in params ){
					if( params[ i ][0] !== undefined ){
						j = 0;
						for( j in params[ i ] )
							merge.push( params[ i ][ j ] );
					}
				}
				
			}
			
			return merge;
			
		}

	} );

} )( jQuery );
