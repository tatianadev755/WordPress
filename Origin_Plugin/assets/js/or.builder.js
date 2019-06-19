/*
 * 
 *
 *  
 *
 * Must obtain permission before using this script in any other purpose
 *
 * or.builder.js
 *
*/

( function ( $ ) {
	
	if( typeof( or ) == 'undefined' )
		window.or = {};
		
	window.or = $.extend( {

		ver 	: '0',
		auth	: '',
		model 	: 1,
		tags	: '',
		storage	: [],
		maps	: {},
		views	: {},
		params	: {},
		tools	: {},
		mode 	: '',
		widgets : null,
		changed : false,
		live_preview : true,
		ready	: [],
		__		: {},
		cfg		: {
			version : 0,
			limitDeleteRestore : 10,
			limitClipboard : 9,
			sectionsPerpage : 5,
			scrollAssistive : 1,
			preventScrollPopup : 1,
			instantSave : 1,
			showTips : 1,
			columnDoubleContent : '',
			columnKeepContent : '',
			profile : 'origin builder',
			profile_slug : 'origin-builder',
			sectionsLayout : 'grid',
			mode : '',
			defaultImg : plugin_url+'/assets/images/get_logo.png'
		},

		init	: function(){
			
			if( typeof( or_maps ) == 'undefined' )
				return;
				
			this.tags = shortcode_tags;

			this.maps = or_maps;

			this.cfg = $().extend( this.cfg, this.backbone.stack.get('or_Configs') );
			
			if( typeof( or_js_languages ) == 'object' )
				this.__ = or_js_languages;
			
			this.ui.init();

			$('#or-switch-builder').on( 'click', or.switch );

			$('#post').on( 'submit', this.submit );

			this.widgets = $( this.template('wp-widgets') );

			if( $('#or-post-mode').length > 0 )
				this.cfg.mode = $('#or-post-mode').val();

			if( this.cfg.mode == 'or' ){
				or.switch( true );
			}
			
			this.ready.forEach( function( func ){

				if( typeof func == 'function' )
					func( this );
			});
			
			$('#postdivrich').removeClass('first-load');
			
			or.ui.gsections.refresh_list_template();

		},

		backbone : {

			views : function( ismodel ) {

				this.ismodel = ismodel;
				this.el = null;
				this.events = null;
				this.render = function( params, p1, p2, p3, p4, p5 ){

					var rended =  this._render( params, p1, p2, p3, p4, p5 );

					if( this.el === null )
						this.el = rended;

					if( typeof this.events == 'object' ){
						or.trigger( this );
					}

					if( this.ismodel != 'no-model' ){
						var id = or.model++;
						rended.attr({id:'model-'+id}).addClass('or-model').data({ 'model' : id });
						params = $().extend( $().extend( { args : {}, model : id }, params ));
						or.storage[ id ] = params;
					}

					return rended;

				};
				this.extend = function( obj ){
					for( var i in obj ){
						if( i == 'render' ){
							this._render = obj.render;
						}else{
							this[i] = obj[i];
						}
					}
					return this;
				};

			},

			save : function( pop ){

				var mid = pop.data('model');

				if( mid !== undefined ){

					if( or.storage[ mid ] ){

						var datas = or.tools.getFormData( pop.find('form.fields-edit-form .or-param') ),
							prev = {},
							hidden = [],
							exp = new RegExp( site_url, "g" );
							map_params = or.params.merge( or.storage[ mid ].name );

						pop.find('form.fields-edit-form .or-param-row').each(function(){
							if( $(this).hasClass('relation-hidden') ){
								$(this).find('.or-param').each(function(){
									hidden.push( this.name );
								});
							}
						});
						
						for( var name in datas ){

							if( typeof( name ) == 'undefined' || name === '' )
								continue;

							if( hidden.indexOf( name ) > -1 )
								datas[name] = '';

							if( datas[name] !== '' )
							{
								if( typeof datas[name] == 'object' ){
									if( typeof( datas[name][0] ) == 'string' && datas[name][0] == '' )
										delete datas[name][0];
										
								 	datas[name] = or.tools.base64.encode( JSON.stringify( datas[name] ).toString().replace(exp,'%SITE_URL%') );
								 	
								}
								prev[ name ] = datas[name];

							}
							else if( hidden.indexOf( name ) == -1 )
							{
								if( typeof( map_params ) == 'object' )
								{
									for( var p in map_params )
									{
										/* if has default value, save empty too */
										if( map_params[p].name == name && 
											typeof( map_params[p].value ) != 'undefined' && 
											map_params[p].value !== '' && 
											typeof( prev[ name ] ) == 'undefined' )
										{
											prev[ name ] = '__empty__';
										}
									}
								}
							}

							if( datas[name] === '' && typeof( prev[ name ] ) == 'undefined' )
							{
								 if( typeof( or.storage[ mid ].args[ name ] ) == 'undefined' )
								 	continue;
								 else delete or.storage[ mid ].args[ name ];
							}
							else
							{

								or.storage[ mid ].args[ name ] = prev[ name ];

								if( name == 'content' && !_.isUndefined(or.storage[ mid ].end)  ){

								}else{
									or.storage[ mid ].args[ name ] =
									or.tools.esc_attr( or.storage[ mid ].args[ name ] );
								}
							}
						}

						/*Render css (if exist)*/
						or.params.fields.css_box.save( pop );
						
						delete map_params;
						
						or.changed = true;

					}
				}
			},

			/* View Events */

			settings : function( e, atts ){
			
				if( e === undefined )return;

				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;

				var mid = or.get.model( el ),
					data = or.storage[ mid ],
					popup = or.tools.popup;

				if( or.maps[ data.name ] === undefined )
					return false;

				var map = $().extend( {}, or.maps['_std'] );
				map = $().extend( map, or.maps[ data.name ] );

				if( map.title === undefined )
					map.title = map.name;
				
				var attz = { title: map.title, width: map.pop_width, scrollBack: true, class: data.name+'_wrpop', footer_text: or.__.i47 };
				if( atts !== undefined )
					attz = $.extend( attz, atts );
				
				var pop = popup.render( el, attz );
				
				var or_arr = [];

				pop.data({ model: mid, callback: or.backbone.save });
				
				var form = $('<form class="fields-edit-form or-pop-tab form-active"></form>'), tab_icon = 'et-puzzle';
				
				if( map.params[0] !== undefined ){
				
					or.params.fields.render( form, map.params , data.args );
				
				}else {
				
					for( var n in map.params ){
						
						if( typeof( map.tab_icons ) != 'undefined' && map.tab_icons[ n ] !== undefined )
							tab_icon = map.tab_icons[ n ];
						
						if(n == 'animate'){
							or_arr.push({
								title: '<i class="'+tab_icon+'"></i> '+n,
								class: 'or-tab-general-'+or.tools.esc_slug(n),
								cfg: n+'|'+mid+'|'+data.name,
								callback:  or.params.fields.tabs
							});
						}else{
							popup.add_tab( pop, {
								title: '<i class="'+tab_icon+'"></i> '+n,
								class: 'or-tab-general-'+or.tools.esc_slug(n),
								cfg: n+'|'+mid+'|'+data.name,
								callback:  or.params.fields.tabs
							});
						}
						
					}
					
					pop.find('.m-p-wrap>.or-pop-tabs>li').first().trigger('click');
					
				}
				
				if( atts === undefined || atts.noscroll === undefined || atts.noscroll != 'yes' )
					or.ui.preventScroll( pop.find('.m-p-body') );
				
				pop.find('.m-p-body').append( form );

				if( map.css_box === true )
				{
					popup.add_tab( pop,
					{
						title: '<i class="et-adjustments"></i> Design',
						class: 'or-tab-visual-css-title',
						callback:  or.params.fields.css_box.visual
					});
										
					/*popup.add_tab( pop,
					{
						title: 'Animate',
						class: 'or-tab-animate-title',
						callback:  or.params.fields.animate.visual
					});*/
					 popup.add_tab( pop,
					{
						title: '<i class="et-search"></i> CSS Code',
						class: 'or-tab-code-css-title',
						callback:  or.params.fields.css_box.code
					}); 

				}
				//console.log(or_arr);
				//console.log(or_arr.length);
				if(or_arr.length > 0) popup.add_tab( pop, or_arr[0] );
				
				delete groups;
				delete map;

				return pop;

			},

			double : function( e ){

				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;

				var id = or.get.model( el ),
					exp = or.backbone.export( id ),
					data = or.storage[id],
					cdata = $().extend( true, {}, data ),
					cel, func;
					if( data.name != 'or_column_text' )
						cdata.args.content = or.params.process_alter( exp.content, data.name );

					el = $('#model-'+id);

				cdata.model = or.model++;

				if( data.name == 'or_row' ){
					cel = or.views.row.render( cdata, true );
				}else if( data.name == 'or_column' ){
					cel = or.views.column.render( cdata, true );
				}else if( or.tags.indexOf( cdata.name ) ){
					try{
						func = or.maps[ cdata.name ].views.type;
					}catch( ex ){
						func = cdata.name;
					}
					if( typeof or.views[ func ] == 'object' )
						cel = or.views[ func ].render( cdata );
					else cel = or.views.or_element.render( cdata );

				}else{
					cel = or.views.
							  or_undefined
						  	  .render({
				  				  args: { content: cdata.content },
								  name: 'or_undefined',
								  end: '[/or_undefined]',
								  full: cdata.content
							  });
				}

				el.after( cel );

				if( el.height() > 300 && !el.hasClass('or-column') )
					$('html,body').scrollTop( $(window).scrollTop()+el.height() );

				or.ui.sortInit();

				return cel;

			},

			add	 : function( e ){

				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;

				if(typeof( e.tagName ) == 'undefined') {
				var atts = { title: or.__.i02, width: 950, class: 'no-footer none_row', scrollBack : true };
				}
				else{
				var atts = { title: or.__.i02, width: 950, class: 'no-footer', scrollBack : true };
				}
				var pop = or.tools.popup.render( el, atts );

				var pos = 'top';
				if( $(el).closest('.pos-bottom').get(0) )
					pos = 'bottom';
				
				 $('html, body').animate({scrollTop : 0},800);
      
               $( "body" ).prepend( "<div class='backgound_color' style='background-color:#D7D7D7;height: 100%;opacity: 1;width: 100%;position: fixed;z-index: 16;'></div>" );

				pop.data({ model : or.get.model(el), pos : pos });

				pop.find('h3.m-p-header').append(

					$('<input type="search" class="or-components-search search_bar" placeholder="Search elements" />')
						.on('keyup', function(e){
                    $('.or-components-list-main.or-components-list.all').css('display','block');
							if( this.timer === true ){
								setTimeout(function(el){
									el.timer = false;
								}, 100, this);
								return;
							}else{
								this.timer = true;
							}

							$('#or-clipboard,#or-wp-widgets-pop').hide();
							$('#or-components .or-components-list-main.all').show();

							$('#or-components .or-components-categories .active').removeClass('active');
							var key = this.value.toLowerCase();
							var list = $('#or-components .or-components-list-main li');
							list.css({display: 'none'});
							list.each(function(){
								var find = $(this).find('strong').html().toLowerCase();
								if( find.indexOf( key ) > -1 )
									$(this).show();
							});
						})

					).append('<img class="sl-magnifier search_bar" src="'+plugin_url+'/assets/images/search.png" />');
 
		 
              var components = $( or.template( 'components' ) );
				var contens = $( or.template( 'content' ) );
				var social = $( or.template( 'social' ) );
			     var marketing = $( or.template( 'marketing' ) );
				 var mostused = $( or.template( 'mostused' ) );
				 var widgets = $( or.template( 'wp-widgets1-component' ) );

				pop.find('.m-p-body').append( components );
                pop.find('#or-components').append( contens );
                pop.find('#or-components').append( mostused );
                pop.find('#or-components').append( social );
                pop.find('#or-components').append( marketing );
                pop.find('.or-components-list.all').append( widgets );
				
				or.trigger({

					el: components,
					events : {
						'ul.or-components-categories li:click' : 'categories',
						'ul.or-components-list-main li:click' : 'items'
					},

					categories : function( e ){

						var category = $(this).data('category'), atts = {}, el;

						$(this).parent().find('.active').removeClass('active');
						$(this).addClass('active');

						$('#or-clipboard,#or-wp-widgets-pop').remove();
 
	                 if(category=="all"){ 
							 $('#or-components .or_content').css({display:'none'});
							 $('#or-components .or_social').css({display:'none'});
							 $('#or-components .or_marketing').css({display:'none'});
							 $('#or-components .or_mostused').css({display:'none'});
						}
						if( $(this).hasClass('mcl-clipboard') ){

							$('#or-components .or-components-list-main').css({display:'none'});

							el = $( or.template( 'clipboard', atts ) );

							$('#or-components').append( el );

							if( typeof atts.callback == 'function' )
								atts.callback( el );

							return;

						}
						else if( $(this).hasClass('mcl-wp-widgets') ){

							$('#or-components .or-components-list-main').css({display:'none'});

							el = $( or.template( 'wp-widgets-element', atts ) );
							
							$('#or-components').append( el );

							if( typeof atts.callback == 'function' )
								atts.callback( el, e );

							return;

						}
                      else if( $(this).hasClass('mcl-content') ){
 							 $('#or-components .or-components-list-main').css({display:'none'});
							 $('.or_content').css({display:'block'});
							  return;
							  
						}
						else if( $(this).hasClass('mcl-social') ){
 
							 $('#or-components .or-components-list-main').css({display:'none'});
							 $('.or_social').css({display:'block'});
                          	  return;  
						}
						else if( $(this).hasClass('mcl-marketing') ){
 
							 $('#or-components .or-components-list-main').css({display:'none'});
							 $('.or_marketing').css({display:'block'});
                          	  return;  
						}
                         else if( $(this).hasClass('mcl-mostused') ){
 
							 $('#or-components .or-components-list-main').css({display:'none'});
							 $('.or_mostused').css({display:'block'});
                          	  return;  
						}

						$('#or-components .or-components-list-main.all').show();
  
						if( category == 'all' ){
						  
							$('#or-components .or-components-list-main li').show();
						}else{
							$('#or-components .or-components-list-main li, #or-clipboard').css({display:'none'});
							$('#or-components .or-components-list-main .mcpn-'+category).show();
						}

					},

					items : function( e ){
  
						var model = or.get.model( this),
						name = $(this).data('name'),
						maps = or.maps[name],
						map_params = or.params.merge( name ),
						content = ( typeof( or.maps[name].content ) != 'undefined' ) ? or.maps[name].content : '',
						full = '['+name;
					 
						console.log(model);
						 
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

						if( maps.is_container === true ){
							full += content+'[/'+name+']';
						}

						var fid = or.backbone.push( full, model, $(this).closest('.or-params-popup').data('pos')  );

						if( fid !== null ){

							$(this).closest('.or-params-popup').data({'scrolltop':null});

							$( '#model-'+fid+' .or-controls>.edit' ).eq(0).trigger('click');

							or.changed = true;

							setTimeout( function( el, pop ){

								var rect = or.tools.popup.coordinates( el, pop.width(), pop.data('keepCurrentPopups') );

								pop.css({top: rect[0]+'px', left: rect[1]+'px'});

							}, 1000, $( '#model-'+fid+' .or-controls>.edit' ).get(0), $('.or-params-popup.wp-pointer-top') );

						}

						$(this).closest('.or-params-popup').find('.m-p-header .sl-close.sl-func').trigger('click');
						
						delete map_params;
						
					}

				});
				
				return pop;

			},

			remove : function( e ){
            if( !confirm('Are you sure?') ){	
				 return false;
				 }
           
				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;

				var und = $('#or-undo-deleted-element'),
					stg = $('#or-storage-prepare'),
					elm = $('#model-'+or.get.model(el)),
					relate = { parent: elm.parent().get(0) },

					limitRestore = 10;

				if( elm.next().hasClass('or-model') )
					relate.next = elm.next().get(0);
				if( elm.prev().hasClass('or-model') )
					relate.prev = elm.prev().get(0);

				var i = 1 ;
				stg.find('>.or-model').each(function(){
					i++;
					if( i > or.cfg.limitDeleteRestore  ){
						var id = $(this).data('model');
						delete or.storage[ id ];
						$('#model-'+id).remove();
					}
				});

				elm.data({ relate: relate });

				stg.prepend( elm );
				und.find('span.amount').html( stg.find('>.or-model').length );


				und.css({top:0});

				if( und.find('.do-action').data('event') === undefined ){
					
					/*Make sure add event only one time*/

					und.find('.sl-close').off('click').on('click',function(){
						$('#or-undo-deleted-element').css({top:-132});
					});

					und.find('.do-action').off('click').on('click',function(){

						var elm = $('#or-storage-prepare>.or-model').first();
						if( !elm.get(0) ){
							$(this.parentNode).find('.sl-close').trigger('click');
							return false;
						}
						var relate = elm.data('relate');

						if( typeof( relate.next ) != 'undefined' ){
							$(relate.next).before( elm );
						}else if( typeof( relate.prev ) != 'undefined' ){
							$(relate.prev).after( elm );
						}else if( typeof( relate.parent ) != 'undefined' ){
							$(relate.parent).append( elm );
						}else{
							$(this.parentNode).find('.sl-close').trigger('click');
							var id = $(this).data('model');
							delete or.storage[ id ];
							$('#model-'+id).remove();
							return false;
						}

						$('.show-drag-helper').removeClass('show-drag-helper');

						or.ui.scrollAssistive( elm );

						var al = $('#or-storage-prepare>.or-model').length;

						$(this).find('span.amount').html( al );

						if( al === 0 )
							$(this.parentNode).find('.sl-close').trigger('click');

					});

					und.find('.do-action').data({'event':'added'});

				}

				or.changed = true;

			},

			copy : function( e ){

				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;

				var model = or.get.model( el ),
					exp = or.backbone.export( model ),
					admin_view = '', lm = 0, stack = or.backbone.stack,
					list = stack.get( 'or_ClipBoard' ),
					ish;

					$('#model-'+model+' .admin-view').each(function(){
						lm++;
						if( lm < 2 ){
							if( $(this).find('img').length === 0 ){
								ish = or.tools.esc( $(this).text() );
								if( ish.length > 38 )
									ish = ish.substring(0, 35)+'...';
							}else if( $(this).hasClass('gmaps') ){

								ish = $(this).find('.gm-style img');
								ish = '<img src="'+ish.eq( parseInt( ish.length / 2 ) ).attr('src')+'" />';

							}else{
								ish = '<img src="'+$(this).find('img').first().attr('src')+'" />';
							}
							admin_view += '<i>'+ish+'</i>';
						}
					});

				if( list.length > or.cfg.limitClipboard - 2 ){

					list = list.reverse();
					var new_list = [];
					for( var i = 0; i < or.cfg.limitClipboard-2; i++ ){
						new_list[i] = list[i];
					}

					stack.set( 'or_ClipBoard', new_list.reverse() );

				}

				var page = $('#title').val() ? or.tools.esc( $('#title').val().trim() ) : 'origin builder',
					content = ( exp.begin+exp.content+exp.end );

				stack.clipboard.add( {
					page	: page,
					content	: or.tools.base64.encode( content ),
					title	: or.storage[model].name,
					des		: admin_view
				});
				
				// Push to row stack & OS clipboard
				or.backbone.stack.set( 'or_RowClipboard', content );
				or.tools.toClipboard( content );

			},

			cut : function( e ){

				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;
				or.backbone.copy( el );

				$( el ).parent().find('.delete').trigger('click');

			},

			more : function( e ){

				var el = ( typeof( e.tagName ) != 'undefined' ) ? e : this;

				if( $(el).hasClass('active') )
					$(el).removeClass('active');
				else $(el).addClass('active');

			},

			/* End View Events */

			push : function( content, model, pos ){
			/* Push elements to grid */
				
				if( or.front !== undefined && or.front.push !== undefined && typeof( or.front.push ) == 'function' ){
					return or.front.push( content, model, pos );
				}
				
				or.changed = true;

				if( model !== undefined && model !== null && document.getElementById( 'model-'+model ) !== null ){

					var fid = or.params.process_all( content, $('#model-'+model+' > .or-column-wrap') );

					or.ui.sortInit();

					if( pos == 'top' )
						$( '#model-'+fid ).parent().prepend( $( '#model-'+fid ) );

					or.ui.scrollAssistive( $( '#model-'+fid ) );

					return fid;

				}else{

					or.params.process_shortcodes( content, function( args ){
						or.views.row.render( args );
					}, 'or_row' );

					var target = $('#or-rows .or-column-wrap').not('.ui-sortable').last();
					if( !target.hasClass('.or-row') )
						target = target.closest('.or-row');

					or.ui.scrollAssistive( target );
					target.addClass('or-bounceIn');
					setTimeout( function( target ){target.removeClass('or-bounceIn');}, 1200, target );

					or.ui.sortInit();

				}

				return null;


			},

			extend : function( obj, ext, accept ){

				if( accept === undefined )
					accept = [];

				if( typeof ext != 'object' ){
					return ext;
				}else{
					for( var i in ext ){
						if( accept.indexOf( i ) > -1 || accept.length === 0 ){
							/*Except jQuery object*/
							if( ext[i].selector !== undefined )
								obj[i] = ext[i];
							else obj[i] = or.backbone.extend( {}, ext[i] );
						}
					}
					return obj;
				}
			},

			export : function( id, ignored ){

				var storage = or.storage[id];
				if( _.isUndefined(storage) )
					return null;

				if( _.isUndefined( ignored ) )
					ignored = [];

				var name = storage.name;

				if( name == 'or_undefined' )
					return { begin: '', content: or.storage[id].args.content, end : '' };

				if( typeof storage.end == 'string' ){
					while( ignored.indexOf( storage.name ) > -1 ){
						storage.name += '#';
						storage.end = '[/'+storage.name+']';
					}
				}

				var el = $('#model-'+id),
					_begin = '['+storage.name,
					_content = '',
					_end = '';

				if( _.isUndefined(storage.name) )
					return storage.full;

				for( var n in storage.args ){
					if( n == 'content' &&  !_.isUndefined(storage.end) ){
						// stuff
					}else{
						_begin += ' '+n+'="'+storage.args[n]+'"';
					}
				}

				_begin += ']';
				if( typeof storage.end == 'string' ){
					/* shortcode container */
					ignored[ignored.length] = storage.name;
					var children = el.find('.or-model').first().parent().find('> .or-model');
					
					if( children.length === 0 ){
						_content = or.storage[id].args.content;
					}else{
						children.each(function(){
							var mid = $(this).data('model');
							if( !_.isUndefined(mid) ){
								var _exp = or.backbone.export(mid, $().extend( [], ignored ));
								_content += _exp.begin+_exp.content+_exp.end;
							}
						});
						or.storage[id].args.content = _content;
					}
					_end = '[/'+storage.name+']';
					or.storage[id].end = '[/'+name+']';
				}

				or.storage[id].name = name;

				return { begin: _begin, content: _content, end : _end };

			},

			stack : {

				clipboard : {

					sort : function(){

						var list = [];

						$('#or-clipboard>.ms-list>li').each(function(){

							list[ list.length ] = $(this).data('sid');

						});

						or.backbone.stack.sort( 'or_ClipBoard', list );

					},

					add : function( obj ){

						var stack = or.backbone.stack.get( 'or_ClipBoard' ), istack = [], i = -1;

						if( typeof stack == 'object' ){
							if( stack.length > or.cfg.limitClipboard ){
								for( var n in stack ){
									i++;
									if( stack.length-i < or.cfg.limitClipboard )
										istack[ istack.length ] = stack[n];
								}
								or.backbone.stack.set( 'or_ClipBoard', istack );
							}
						}

						or.backbone.stack.add( 'or_ClipBoard', obj );

					}

				},

				sections : {


				},

				add : function( sid, obj ){

					if( typeof(Storage) !== "undefined" ){

					    var stack = this.get(sid);

						if( stack === '' )
							stack = [];
						else if( typeof stack != 'object' )
							stack = [stack];

						stack[ stack.length ] = obj;

					    this.set( sid, stack );

					} else {
					    alert( or.__.i04 );
					}

				},

				update : function( sid, key, value ){

					if( typeof(Storage) !== "undefined" ){

					    var stack = this.get(sid);

						if( stack === '' )
							stack = {};
						else if( typeof stack != 'object' ){
							var ist = {}; ist[sid] = stack; stack = ist;
						}

						stack[key] = value;

					    this.set( sid, stack );

					} else {
					    alert( or.__.i04 );
					}

				},

				get : function( sid, index ){

					if( typeof( Storage ) !== "undefined" ){

						var data = localStorage[ sid ], dataObj;
						if( data === undefined )
							return '';

						data = data.toString().trim();

						if( data !== undefined && data !== '' && ( data.indexOf('[') === 0 || data.indexOf('{') === 0 ) ){
							try{
								dataObj =  JSON.parse( data );
							}catch(e){
								dataObj = data;
							}
							if( index === undefined )
								return dataObj;
							else if( dataObj[index] !== undefined )
								return dataObj[index];
							else return '';

						}else return data;

					}else {
					    alert( or.__.i04 );
					    return '';
					}

				},

				set : function( sid, obj ){

					if( typeof obj == 'object' )
						obj = JSON.stringify( obj );

					localStorage.removeItem( sid );
					localStorage.setItem( sid, obj );

				},

				sort : function( sid, list ){

					var stack = this.get( sid ), istack = [];

					for( var n in list ){
						if( stack[ list[n] ] !== undefined )
							istack[ istack.length ] = stack[ list[n] ];
					}

					this.set( sid, istack );

				},

				remove : function( sid, id ){

					var stack = this.get( sid );
					delete stack[id];

					this.set( sid, stack );

				},

				reset : function( sid ){

					var stack = this.get( sid ), istack = [];

					if( stack === '' ){
						this.clear( sid );
					}else{
						for( var i in stack ){
							if( stack[i] !== null )
								istack[ istack.length ] = stack[i];
						}
					}
					this.set( sid, istack );
				},

				clear : function( sid ){

					if( typeof(Storage) !== "undefined" ){

						localStorage.removeItem( sid );

					}else {
					    alert( or.__.i04 );
					    return {};
					}
				}

			}

		},

		trigger : function( obj ) {

			var func;
			for( var ev in obj.events )
			{
				if( typeof obj.events[ev] == 'function' )
					func = obj.events[ev];
				else if( typeof obj[obj.events[ev]] == 'function' )
					func = obj[obj.events[ev]];
				else if( typeof or.backbone[obj.events[ev]] == 'function' )
					func = or.backbone[obj.events[ev]];
				else return false;

				ev = ev.split(':');

				if( ev.length == 1 )
					obj.el.off(ev[0]).on( ev[0], func );
				else
					obj.el.find( ev[0] ).off(ev[1]).on( ev[1], obj, func );

			}
		},

		template : function( name, atts ){

			var _name = '_'+name;

			if( this[ _name ] == 'exit' )
				return null;
			
			if( this[ _name ] === undefined ){
				if( document.getElementById('tmpl-or-'+name+'-template') )
					this[ _name ] = wp.template( 'or-'+name+'-template' );
				else{
					this[ _name ] = or.ui.get_tmpl_cache( 'tmpl-or-'+name+'-template' );
				}
			}

			if( atts === undefined )
				atts = {};

			if( typeof this[ _name ] == 'function' )
				return this[ _name ]( atts );

			return null;

		},

		ui : {

			elm_start : null, elm_drag : null, elm_over : null, over_delay : false, over_timer : null, key_down : false,
			/* This is element clicked when mousedown on builder */

			init : function(){

				or.body = document.querySelectorAll('body')[0];
				or.html = document.querySelectorAll('html')[0];

				$( document ).on( 'mousedown', function( e ){ or.ui.elm_start = e.target; } );

				$( window ).on( 'scroll', document.getElementById('major-publishing-actions'), or.ui.publishAction );

				if( or.cfg.instantSave == 1 ){
					
					$( window ).on( 'keydown', function(e) {
						
						if( or.cfg.instantSave === 1 && 
							e.keyCode === 83 && 
							(navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)
						){
 							e.preventDefault();
 							or.instantSubmit();
 							e.stopPropagation();
 							return false;
 						}
						else if( e.keyCode === 13  ){
							// enter
							
							var last = $('.or-params-popup').
								not('.no-footer').
								find('>.m-p-wrap>.m-p-header>.sl-check.sl-func').
								last(),
								posible = true,
								el = e.target;
							
							while( el !== undefined && el.parentNode ){
								
								el_type = ( el.tagName !== undefined ) ? el.tagName : '';
								
								if( el_type == 'TEXTAREA' || $(el).attr('contenteditable') == 'true' ){
									posible = false;
									break;
								}
								el = el.parentNode;
							}
							
							if( last.length > 0 && posible === true ){
							
								last.trigger('click');
									
								e.preventDefault();
								e.stopPropagation();
								
								return false;
							
							}
							
						}else if( e.keyCode === 27 ){
							// esc
							
							$('.or-params-popup').
								find('>.m-p-wrap>.m-p-header>.sl-close.sl-func').
								last().trigger('click');
								
							e.preventDefault();
							e.stopPropagation();
							
							return false;
							
						}

					});
				}

			},

			sortInit : function(){

				setTimeout( function(){

					/*Sort elements*/
					or.ui.sortable({

					    items : '.or-element.or-model,.or-views-sections.or-model,.or-row-inner.or-model,.or-element.drag-helper',
					    connecting : true,
					    handle : '>ul>li.move,>div.or-element-control',
					    helper : ['or-ui-handle-image', 25, 25 ],
					    detectEdge: 80,

					    start : function( e, el ){

						    $('#or-undo-deleted-element').addClass('drop-to-delete');

						    var elm = $(el), relate = { parent: elm.parent().get(0) };

							if( elm.next().hasClass('or-model') )
								relate.next = elm.next().get(0);
							if( elm.prev().hasClass('or-model') )
								relate.prev = elm.prev().get(0);

							elm.data({ relate2 : relate });

					    },

					    end : function(){
						    $('#or-undo-deleted-element').removeClass('drop-to-delete');
					    }

				    });

					/*Trigger even drop to delete element*/
					if( document.getElementById('drop-to-delete').draggable !== true ){

						var dtd = document.getElementById('drop-to-delete');

						dtd.setAttribute('droppable', 'true');
				        dtd.setAttribute('draggable', 'true');

				        var args = {

					        dragover : function( e ){
						        this.className = 'over';
						        e.preventDefault();
					        },

					        dragleave : function( e ){
						         this.className = '';
					        },

					        drop : function( e ){

						        this.className = '';
						        $('#or-undo-deleted-element').removeClass('drop-to-delete');

						        if( or.ui.elm_drag !== null ){

							        var atts = $( or.ui.elm_drag ).data('atts');

							        $( or.ui.elm_drag )
							        	.removeClass( atts.placeholder )
								        .find('li.delete')
								        .first()
								        .trigger('click');

								    $( or.ui.elm_drag ).data({ relate : $( or.ui.elm_drag ).data( 'relate2' ) });

							        e.preventDefault();

						        }
					        }

				        };

				        for( var ev in args )dtd.addEventListener( ev, args[ev], false);

					}

					/*Sort Rows*/
					or.ui.sortable({

						items : '#or-rows>.or-row',
						vertical : true,
					    connecting : false,
						handle : '>ul>li.move',
						helper : ['or-ui-handle-image', 50, 50 ],

						start : function(){
							$('#or-rows').addClass('sorting');
						},

						end : function(){
							$('#or-rows').removeClass('sorting');
						}

					});

					/*Sort Columns*/
					or.ui.sortable({

						items : '.or-column,.or-column-inner',
						vertical : false,
					    connecting : false,
						handle : '>.or-column-control',
						helper : ['or-ui-handle-image', 100, 50 ],
						detectEdge : 'auto',
						start : function(e, el){
							$(el).parent().addClass('or-sorting');
						},

						end : function(e, el){
							$(el).parent().removeClass('or-sorting');
						}
					});

				}, 100 );

			},

			sortable_events : {

				mousedown : function( e ){

					if( window.chrome !== undefined || this.draggable === true )
						return;

					var atts = $(this).data('atts'), handle;

					if( atts.handle !== undefined && atts.handle !== '' ){

						handle = $( this ).find( atts.handle );

						if( handle.length > 0 ){
							if( e.target == handle.get(0) || $.contains( handle.get(0), e.target ) ){
								this.draggable = true;
								or.ui.sortable_events.dragstart(e);
							}
						}
					}

				},

				dragstart : function( e ){

					/**
					*	We will get the start element from mousedown of columnsResize
					*/

					if(  or.ui.elm_start === null ){
						e.preventDefault();
						return false;
					}

					or.ui.over_delay = true;

					var atts = $(this).data('atts'), handle, okGo = false;

					if( atts.handle !== '' && atts.handle !== undefined ){

						handle = $( this ).find( atts.handle );

						if( handle.length > 0 ){
							if( or.ui.elm_start == handle.get(0) || $.contains( handle.get(0), or.ui.elm_start ) )
								okGo = true; else okGo = false;

						}else okGo = false;

					}else okGo = true;

					if( okGo === true ){

						$('body').addClass('or-ui-dragging');

						/* Disable prevent scroll -> able to roll mouse when drag */
						if( $(this).closest('.or-prevent-scroll').length > 0 ){
							$(this).closest('.or-prevent-scroll').off('mousewheel DOMMouseScroll');
						}

						if( atts.helperClass !== '' ){
							if( $( or.ui.elm_start ).closest( atts.items ).get(0) == this ){
								$( or.ui.elm_start ).closest( atts.items ).addClass( atts.helperClass );
							}
						}

						or.ui.elm_drag = this;

				        e.dataTransfer.effectAllowed = 'move';
				        e.dataTransfer.dropEffect = 'none';

				        if( e.dataTransfer !== undefined && typeof  e.dataTransfer.setData == 'function' )
				        	e.dataTransfer.setData('text/plain', 'originbuilder.Com');
                          var crt = this.cloneNode(true); 
		  var cls=crt.getAttribute("class"); 
		  if(cls.indexOf("or-element")!=-1) { 
		  $('.add_models').remove();
		  $('body').append('<div class="add_models"></div>');
		  	  
	     this.getElementsByTagName('span')[1].style.color="#fff";	
	    
		  } 
					    if( typeof atts.helper == 'object' && e.dataTransfer !== undefined && typeof  e.dataTransfer.setDragImage == 'function' ){
						 
						var crt = this.cloneNode(true); 
					 
		  var cls=crt.getAttribute("class"); 
		  if(cls.indexOf("or-element")!=-1) {   
    crt.style.backgroundColor = "rgba(0,0,0,1)";
    crt.style.opacity = "1";
    crt.style.borderRadius = "10px";
    crt.style.zIndex = 9999;
    crt.style.width ="200px";
 
	if(crt.lastChild.style!=undefined){
    crt.lastChild.style.display="none";	
	}
   $('.add_models').append(crt);
 
    e.dataTransfer.setDragImage(crt, 0, 0);
		  }
		    
		  else{ 					
  
		  e.dataTransfer.setDragImage(
										document.getElementById( atts.helper[0] ),
										100, 50 
									);
		  }		 
							}

						if( typeof atts.start == 'function' )
							atts.start( e, this );

					}else{

						var check = or.ui.elm_start;
						while( check.draggable !== true && check.tagName != 'BODY' ){
							check = check.parentNode;
						}

						if( check == this ){

							e.preventDefault();
							return false;

						}

					}

				},

				dragover : function( e ){

					var u = or.ui;

					if( u.elm_drag === null ){

						e.preventDefault();
						return false;

					}
					
					if( u.over_delay === false ){
						
						if( u.over_timer === null )
							u.over_timer = setTimeout( function(){ or.ui.over_delay = true;or.ui.over_timer = null; }, 50 );
						
						return false;
						
					}else u.over_delay = false;
					
					u.elm_over = this;

					var oatts = $(this).data('atts'), atts = $( u.elm_drag ).data('atts');

					if(!e) e = window.event;

					if( this == u.elm_drag || $.contains( u.elm_drag, this ) || oatts.items != atts.items ){

						// prevent actions when hover it self or hover its children
						e.preventDefault();
						return false;

					}else{

						var rect = this.getBoundingClientRect();

						if( atts.connecting === false && this.parentNode != u.elm_drag.parentNode ){
							e.preventDefault();
							return false;
						}

						var detectEdge = atts.detectEdge;

						if( atts.vertical === true ){

							if( detectEdge === undefined || detectEdge == 'auto' || detectEdge > (rect.height/2) )
								detectEdge = (rect.height/2);

							if( (rect.bottom-e.clientY) < detectEdge ){

								if( this.nextElementSibling != u.elm_drag ){

									$(this).after( u.elm_drag );
									if( atts.preventFlicker !== false )
										or.ui.preventFlicker( e, u.elm_drag );

								}

								if( typeof atts.over == 'function' )
									atts.over( e, this );

							}else if( (e.clientY-rect.top) < detectEdge ){

								if( this.previousElementSibling != u.elm_drag ){
									$(this).before( u.elm_drag );
									if( atts.preventFlicker !== false )
										or.ui.preventFlicker( e, u.elm_drag );
								}

								if( typeof atts.over == 'function' )
									atts.over( e, this );

							}

						}else{

							if( detectEdge === undefined || detectEdge == 'auto' || detectEdge > (rect.width/2) )
								detectEdge = (rect.width/2);

							if( (rect.right-e.clientX) < detectEdge ){

								if( this.nextElementSibling != u.elm_drag )
									$(this).after( u.elm_drag );

								if( typeof atts.over == 'function' )
									atts.over( e, this );

							}else if( (e.clientX-rect.left) < detectEdge ){

								if( this.previousElementSibling != u.elm_drag )
									$(this).before( u.elm_drag );

								if( typeof atts.over == 'function' )
									atts.over( e, this );

							}

						}

					}

					e.preventDefault();
					return false;
				},

				drag : function( e ){

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

				dragleave : function( e ){

					var atts = $(this).data('atts');

					if( typeof atts.leave == 'function' )
						atts.leave( e, this );

					e.preventDefault();
					return false;
				},

				dragend : function( e ){
		    var crt = this.cloneNode(true); 
		    var cls=crt.getAttribute("class"); 
		    if(cls.indexOf("or-element")!=-1) {
           $('.add_models').remove();
         
	       this.getElementsByTagName('span')[1].style.color="";	
		 
					 }
					var atts = $(this).data('atts');

					$(this).removeClass( atts.helperClass );
					$(this).removeClass( atts.placeholder );

					/*Enable back prevent scroll of popup body*/
					if( $(this).closest('.or-prevent-scroll').length > 0 ){
						or.ui.preventScroll( $(this).closest('.or-prevent-scroll') );
					}

					or.ui.elm_drag = null;
					or.ui.elm_over = null;
					or.ui.elm_start = null;

					or.ui.key_down = false;

					$('body').removeClass('or-ui-dragging');


					if( typeof atts.end == 'function' )
						atts.end( e, this );

					e.preventDefault();
					return false;

				},

				drop : function( e ){

					var atts = $(this).data('atts');

					if( typeof atts.drop == 'function' )
						atts.drop( e, this );

					e.preventDefault();
					return false;

				}


			},

			/*
			*
			*  
			* Must obtain permission before using in any other purpose
			*
			*/

			sortable : function( atts ){

				atts = $().extend({

					items : '',
					handle : '',
					helper : '',
					helperClass : 'or-ui-helper',
					placeholder : 'or-ui-placeholder',
					vertical : true,
					connecting : false,
					detectEdge: 50,
					preventFlicker: false,

				}, atts );

				if( atts.items === '' )
					return;


				var elms = document.querySelectorAll( atts.items );

				[].forEach.call( elms, function( el ){

					if( el.draggable !== true ){

				        el.setAttribute('droppable', 'true');
				        el.setAttribute('draggable', 'true');

				        $(el).data({ atts : atts });

				        for( var ev in or.ui.sortable_events )el.addEventListener( ev, or.ui.sortable_events[ev], false);

			        }

				});

			},

			draggable : function( el, handle ){

				var args = {

					mousedown : function( e ){
						
						if( e.which !== undefined && e.which !== 1 )
							return false;

						if( this.handle !== '' && this.handle !== undefined ){
							if( e.target != $(this).find(this.handle).get(0) && $(e.target).closest(this.handle).length === 0 ){
								return false;
							}
						}

						$('html,body').addClass('or_dragging noneuser');

						var rect = this.getBoundingClientRect(),
							scroll = or.ui.scroll(),
							left = scroll.left + rect.left,
							top = scroll.top + rect.top - or.html.offsetTop;

						$(this).css({ position: 'absolute', top: top+'px', left: left+'px' });

						this.pos = [(e.clientY-rect.top), (e.clientX-rect.left)];

						$(document).off('mousemove').on( 'mousemove', this, function(e){

							var scroll = or.ui.scroll(),
								left = e.clientX + scroll.left,
								top = e.clientY + scroll.top - or.html.offsetTop;

							e.data.style.top = (top-e.data.pos[0])+'px';
							e.data.style.left = (left-e.data.pos[1])+'px';

						});

						$( window ).off('mouseup').on('mouseup', function(){
							$(document).off('mousemove');
							$(window).off('mouseup');
							$('html,body').removeClass('or_dragging noneuser');
						});
						
					}

				};

				if( el.min_draggable !== true ){

			        el.setAttribute('min_draggable', 'true');
			        el.handle = handle;
			        for( var ev in args )el.addEventListener( ev, args[ev], false);
		        }

			},

			preventFlicker : function( e, el ){

				var rect = el.getBoundingClientRect(), st = 0;

				if( e.clientY < rect.top ){
					st = ( rect.top - e.clientY ) + (rect.height/10);
				}else if( e.clientY > (rect.top+rect.height) ){
					st = -( (  e.clientY - (rect.top+rect.height) ) + (rect.height/10) );
				}

				if( st !== 0 ){
					or.body.scrollTop += st;
					or.html.scrollTop += st;
				}

			},

			columnsResize : {

				load : function(){
					$('#or-container').off('mousedown').on( 'mousedown', this.down );
				},

				down : function( e ){
					
					if( e.which !== undefined && e.which !== 1 )
						return false;
							
					$('.or-params-popup:not(.preventCancel) .m-p-header .sl-close').trigger('click');
					
					$('html,body').stop();
					
					if( e.target.className.indexOf( 'or-add-elements-inner' ) > -1 ){
						or.backbone.add(e.target);
						e.preventDefault();
						return false;
					}
					
					if( e.target.className.indexOf( 'column-resize' ) == -1 ){
						return;
					}

					var ge = or.ui.columnsResize, el = $( e.target ).parent();

					$(document).on( 'mouseup', ge.up );
					$(document).on( 'mousemove', { 
						el: el,
						pel: el.prev(),
						nel: el.next(),
						emodel: el.data('model'),
						nmodel: el.next().data('model'),
						pmodel: el.prev().data('model'),
						
						einfo: el.find('>.or-cols-info'),
						ninfo: el.next().find('>.or-cols-info'),
						pinfo: el.prev().find('>.or-cols-info'),
						
						left: e.clientX,
						width: parseFloat( e.target.parentNode.style.width ),
						nwidth: parseFloat( $(e.target.parentNode).next().get(0)?$(e.target.parentNode).next().get(0).style.width:0 ),
						pwidth: parseFloat( $(e.target.parentNode).prev().get(0)?$(e.target.parentNode).prev().get(0).style.width:0 ),
						direct: $(e.target).hasClass('cr-left'),
						offset: 1 
					}, ge.move );
					$('body').css({cursor:'col-resize'});
					
					$( window ).off('mouseup').on('mouseup', function(){
						$(document).off('mousemove');
						$(window).off('mouseup');
						$('html,body').removeClass('or_dragging noneuser');
					});
						
				},

				up : function(e){
					$(document).off( 'mousemove' ).off('mouseup');
					$('body').css({cursor:''});
				},

				move : function(e){

					e.preventDefault();
					e.data.offset = e.clientX-e.data.left;
					
					var d = e.data,
						ratio =  parseFloat( d.el.get(0).style.width )/d.el.get(0).offsetWidth,
						p1 = (d.width-(d.offset*ratio)),
						p2 = d.pwidth+(d.offset*ratio),
						p3 = (d.width+(d.offset*ratio)),
						p4 = d.nwidth-(d.offset*ratio);
					
					if( d.direct ){
						// on  right
						if( p1 > 9 && p2 > 9 ){
							// update width of cols
							d.el.width( p1+'%' );
							d.pel.width( p2+'%' );
							// update info 
							d.einfo.html( Math.round(p1)+'%' );
							d.pinfo.html( Math.round(p2)+'%' );
							
							or.storage[d.emodel].args.width = p1+'%';
							or.storage[d.pmodel].args.width = p2+'%';
							
						}
						
					}else{
						// on left
						if( p3 > 9 && p4 > 9 ){
							
							d.el.width( p3+'%' );
							d.nel.width( p4+'%' );
							
							d.einfo.html( Math.round(p3)+'%' );
							d.ninfo.html( Math.round(p4)+'%' );
							
							or.storage[d.emodel].args.width = p3+'%';
							or.storage[d.nmodel].args.width = p4+'%';
							
						}
					}
					
				},

			},

			views_sections : function( wrp ){

				wrp.find('>.or-views-sections-label .section-label').off('click').on('click', wrp, function(e){

					$(this).closest('.or-views-sections-wrap')
				    .find('>.or-views-section.or-model')
				    .removeClass('or-section-active');
					$('#model-'+$(this).data('pmodel')).addClass('or-section-active');
					e.data.find('>.or-views-sections-label .section-label').removeClass('sl-active');
					$(this).addClass('sl-active');
				});

				wrp.find('>.or-views-section > .or-vertical-label').off('click').on('click', wrp, function(e){

					var itsactive = false;
					if( $(this).parent().hasClass('or-section-active') ){
						itsactive = true;
					}

					$(this).closest('.or-views-sections-wrap')
						   .find('>.or-views-section.or-model')
						   .removeClass('or-section-active');

					if( itsactive === true )
						return;

					$(this).parent().addClass('or-section-active');

					var coor = or.tools.popup.coordinates( this, 100 );
					if( $(window).scrollTop() - coor[0] > 100 )
						$('html,body').scrollTop(coor[0] - 200);

				});

				var pwrp = wrp.closest('.or-views-sections');

				if( !pwrp.hasClass('or-views-vertical') ){

					or.ui.sortable({

						items : 'div.or-views-sections-label>div.section-label',
						vertical : false,

						end : function( e, el ){

							$( el ).closest('.or-views-sections-label')
								.find('>.section-label').each(function(){
									var id = $(this).data('pmodel');
									var el = $('#model-'+id);
									el.parent().append(el);
								});

						}

					});


				}
				else{

					or.ui.sortable({

						items : 'div.or-views-vertical > div.or-views-sections-wrap > div.or-views-section',
						handle : '>h3.or-vertical-label',
						connecting : false,
						vertical : true,
						helper : ['or-ui-handle-image', 25, 25 ],

						start : function(e, el){
							$(el).parent().addClass('or-sorting');
						},

						end : function(e, el){
							$(el).parent().removeClass('or-sorting');
						}

					});

				}

			},

			clipboard : function( el ){

				or.ui.sortable({

					items : '#or-clipboard > ul.ms-list > li',
					connecting : false,
					vertical : false,
					placeholder : 'or-ui-cb-placeholder',

					end : function(){
						or.backbone.stack.clipboard.sort();
					}

				});

				el.find('>ul.ms-list>li').on( 'click', function(){
					if( $(this).hasClass('active') )
						$(this).removeClass('active');
					else $(this).addClass('active');
				});

				or.trigger({

					el : el.find('>ul.ms-funcs'),
					list : el.find('ul.ms-list>li'),

					events : {
						'>li.select:click' : 'select',
						'>li.unselect:click' : 'unselect',
						'>li.delete:click' : 'delete',
						'>li.latest:click' : 'latest',
						'>li.paste:click' : 'paste',
						'>li.pasteall:click' : 'pasteall',
					},

					select : function( e ){
						e.data.list.addClass('active');
					},

					unselect : function( e ){
						e.data.list.removeClass('active');
					},

					delete : function( e ){

						e.data.list.each(function(){
							if( $(this).hasClass('active') ){
								or.backbone.stack.remove( 'or_ClipBoard', $(this).data('sid') );
								$(this).remove();
							}
						});

						or.backbone.stack.reset( 'or_ClipBoard' );

					},

					latest : function( e ){

						var stack = or.backbone.stack.get('or_ClipBoard'),
							latest = stack[stack.length-1],
							content = or.tools.base64.decode( latest.content ),
							model = or.get.model(this);

						if( model ){
							or.backbone.push( content, model, $(this).closest('.or-params-popup').data('pos') );
						}else{
							or.backbone.push( content );
						}

						$('.or-params-popup').remove();

					},

					pasteall : function( e ){

						var stack = or.backbone.stack.get('or_ClipBoard'), model = or.get.model( this ), content = '';

						for( var n in stack ){
							if( typeof stack[n] == 'object' )
								content += or.tools.base64.decode( stack[n].content );
						}

						content = content.trim();

						if( content === '' ){
							alert( or.__.i05 );
							return false;
						}

						if( model ){
							or.backbone.push( content, model, $(this).closest('.or-params-popup').data('pos') );
						}else{
							or.backbone.push( content );
						}

						$('.or-params-popup').remove();

					},

					paste : function( e ){

						var stack = or.backbone.stack.get('or_ClipBoard'), model = or.get.model( this ), content = '', sid;

						list = $(this).closest('#or-clipboard').find('ul.ms-list>li.active').each(function(){

							sid = $(this).data('sid');
							if( typeof stack[sid] == 'object' )
								content += or.tools.base64.decode( stack[sid].content );

						});

						content = content.trim();

						if( content === '' ){
							alert( or.__.i06 );
							return false;
						}

						if( model ){
							or.backbone.push( content, model, $(this).closest('.or-params-popup').data('pos') );
						}else{
							or.backbone.push( content );
						}

						$('.or-params-popup').remove();

					}
				});


			},

			gsections : {
				
				refresh_list_template: function(){
					if( or_profiles[ or.cfg.profile_slug ] !== undefined || or_profiles_external[ or.cfg.profile_slug ] !== undefined ){
			
						$.post( or_ajax_url, {
							'action': 'or_load_profile',
							'name': or.cfg.profile_slug
						}, function ( result ) {
							
							if( result == 0 ){
								alert('Access Denied!');
								return;
							}
							
							if( result.status != 'success' ){
								alert( result.message );
							}else{
								
								result.data = or.tools.base64.decode( result.data );
								//or.backbone.stack.set( 'or_Configs', or.cfg );
								or.backbone.stack.set( 'or_GlobalSections', result.data );
								//alert('asd');
							}
							
						});	
					
					}
				},

				load : function( label, from, to  ){

					var stg = or.backbone.stack.get('or_GlobalSections'), html = '';

					return or.template( 'global-sections', { stg: stg, from: from, to: to, label: label } );

				},

				load_more : function( e ){

					var label = $(this).data('label'),
						from = $(this).data('from'),
						to = $(this).data('to'),
						wrp = $(this).closest('.mgs-select-wrp');

					$(this).after( or.ui.gsections.load( label, from, to ) ).remove();

					wrp.find('.mgs-select-wrp .load-more')
							 .off( 'mouseover')
							 .on( 'mouseover', or.ui.gsections.load_more );

					setTimeout(function(){ $('.mgs-scale-min').removeClass('mgs-scale-min');}, 100 );

				},

				refresh : function( active ){

					var arg = {};

					if( $( '.section-manager-popup.page-sections-manager' ).length > 0 )
						arg.list = 'no';

					var sections = $( or.template( 'install-global-sections', arg ) );

					$('.section-manager-popup .m-p-body').html( sections );

					if( typeof arg.callback == 'function' )
						arg.callback( sections );

					// Refresh list for sections manager page
					if( typeof( or_sections_load ) != "undefined" && typeof or_sections_load == 'function' )
						or_sections_load();

					if( active !== undefined )
						$( '.section-manager-popup .m-p-body .'+active ).trigger( 'click' );

				},

				get_cats : function(){

					var stg = or.backbone.stack.get('or_GlobalSections'), cats = {}, cat = [], j;
					for( var i in stg ){
						if( stg[i] !== null ){
							if( stg[i].category !== null && stg[i].category !== '' ){

								clis = stg[i].category.split(',');
								for( j in clis ){
									clis[j] = clis[j].toString().trim();
									if( cats[ clis[j] ] === undefined )
										cats[ clis[j] ] = 1;
									else cats[ clis[j] ] += 1;
								}
							}
						}
					}

					return cats;

				},

				add_actions : function( wrp ){

					wrp.find('.mgs-select-wrp .mgs-scale-min').removeClass('mgs-scale-min');

					or.trigger( {

						el: wrp,
						events : {
							'.btns .close:click' : 'close',
							'.btns .back:click' : 'back',
							'.btns .apply:click' : 'apply',
							'.mgs-create-new .mgs-category input:focus' : 'focus',
							'.mgs-create-new .mgs-category input:blur' : 'blur',
							'.mgs-create-new .mgs-category .mgs-tips li:click' : 'category',
							'.mgs-create-new .create-section:click' : 'create',
							'.mgs-select-section .filter-by-category:change' : 'filter',
							'.mgs-select-wrp:click' : 'addToSection',
							'.mgs-select-wrp .load-more:mouseover' : 'load_more'
						},

						load_more : function( e ){

							var label = $(this).data('label'),
								from = $(this).data('from'),
								to = $(this).data('to');

							$(this).after( or.ui.gsections.load( label, from, to ) ).remove();

							$(this).closest('.mgs-select-section').find('.filter-by-category').trigger('change');

							if( e.data !== undefined ){

								e.data.el.find('.mgs-select-wrp .load-more')
										 .off( 'mouseover')
										 .on( 'mouseover', e.data, e.data.load_more );

								setTimeout(function( el ){
									el.find('.mgs-select-wrp .mgs-scale-min').removeClass('mgs-scale-min');
								}, 100, e.data.el );

							}

						},

						addToSection : function( e ){

							e.preventDefault();

							var target = e.target;
							if( target === null )
								return;

							if( $(target).hasClass('mgs-sel-sceenshot') ){

								var sid = $(target).data('sid'),
									title = $(target).closest('.mgs-section-item').find('.mgs-si-info span').html(),
									apply = $(this).closest('#or-global-sections').find('.btns .apply');

								e.data.confirm({
									title: or.__.tkl07,
									message: '<input type="radio" name="mgs-add-section-option" checked value="add" /> '+
											 or.__.i08+
											 ' &nbsp; <input type="radio" name="mgs-add-section-option" value="replace" /> '+
											 or.__.i09,
									type: 'noticed',
									el: this
								});

								apply.data({ create : sid });
							}

							if( $(target).hasClass('load-more') ){

								$(target).trigger('mouseover');

							}

						},

						filter : function(){

							var wrp = $(this).closest('.mgs-select-section'),
								sections = wrp.find('.mgs-section-item');
							if( this.value === '' ){
								sections.removeClass('forceHide');
							}else{
								sections.addClass('forceHide');
								wrp.find('.mgs-section-item.category-'+or.tools.esc_slug(this.value)).removeClass('forceHide');
							}

						},

						close : function(){
							$(this).closest('.or-params-popup').remove();
						},

						back : function(){
							var wrp = $(this).closest('#or-global-sections');
							wrp.find('.mgs-create-new').css({display:'block'});
							wrp.find('.mgs-select-section').css({display:'block'});
							wrp.find('.mgs-confirmation').css({display:'none'}).attr({class:'mgs-confirmation'});
						},

						apply : function(e){

							var crp = $(this).closest('#or-global-sections').find('.mgs-create-new'),
								title = or.tools.esc( crp.find('.mgs-title').val() ),
								category = or.tools.esc( crp.find('input.mgs-category').val().toString().toLowerCase() ),
								screenshot = crp.find('.mgc-cn-screenshot .or-param').val(),
								ops = $('input[name="mgs-add-section-option"]:checked').val();

							var model = or.get.model( this ),
								create = $(this).data('create'),
								expo = or.backbone.export( model ),
								data = expo.begin+expo.content+expo.end,
								section = {
									title : title,
									category: category,
									screenshot: screenshot,
									data : data,
									id : create
								};

							if( section.id == 'new' ){

								section.id = parseInt( Math.random()*1000000 );

							}else{

								var stack = or.backbone.stack.get('or_GlobalSections');

								for( var i in stack ){

									if( stack[i].id == section.id ){

										section = stack[i];

										if( ops == 'add' )
											section.data = section.data + data;
										else
											section.data = data;

									}
								}

							}

							or.ui.gsections.update_section( section );

							or.get.popup( this ).remove();

						},

						focus : function( e ){
							$(this).parent().addClass('show-tips');
						},

						blur : function( e ){
							setTimeout( function(el){
								el.removeClass('show-tips');
							}, 200, $(this).parent() );
						},

						category : function( e ){

							var input = $(this).closest('.mgs-category').find('input'),
								value = input.val().toString().trim(),
								data = $(this).data('name'),
								valz = value.split(',');

							for( var i in valz )
								valz[i] = valz[i].trim();

							if( value === '' )
								input.val( data );
							else if( $.inArray( data, valz ) == -1 )
								input.val( value+', '+data );

						},

						create : function( e ){

							var crp = $(this).closest('.mgs-create-new'),
								title = crp.find('.mgs-title').val(),
								category = crp.find('input.mgs-category').val().toString().toLowerCase(),
								screenshot = crp.find('.mgc-cn-screenshot .or-param').val(),

								apply = $(this).closest('#or-global-sections').find('.btns .apply');

							apply.data({ create : 'new' });

							if( title === '' || category === '' ){

								var messa = or.__.i10+': ';
								if( title === ''  )
									messa += '<strong>'+or.__.i11+'</strong>, ';
								if( category === ''  )
									messa += '<strong>'+or.__.i12+'</strong>';

								e.data.confirm({
									title: or.__.i13,
									message: messa,
									type: 'fail',
									el: this
								});

								return;

							}else if( screenshot === '' ){
								e.data.confirm({
									title: or.__.i14,
									message: or.__.i15,
									type: 'noticed',
									el: this
								});
								return;
							}else{
								apply.trigger('click');
								return;
							}

						},

						confirm : function( atts ){

							var wrp = $(atts.el).closest('#or-global-sections'),
							crp = wrp.find('.mgs-create-new');

							wrp.find('.mgs-confirmation').attr({ class : 'mgs-confirmation' });

							crp.css({display:'none'});
							wrp.find('.mgs-select-section').css({display:'none'});
							wrp.find('.mgs-confirmation').css({display:'block'}).addClass( atts.type );
							wrp.find('.mgs-confirmation h1').html( atts.title );
							wrp.find('.mgs-confirmation h2').html( atts.message );

						},

					});

					atts = { value 	: '', name	: 'screenshot' };
					var field = jQuery( or.template( 'field-type-attach_image_url', atts ) );

					wrp.find('.mgs-create-new .mgc-cn-screenshot').append( field );

					if( typeof atts.callback == 'function' )
						setTimeout( atts.callback, 1, field );

					or.ui.preventScroll( wrp.find('.mgs-select-wrp') );

				},

				install_actions : function( wrp ){

					wrp.find('.mgs-select-wrp .mgs-scale-min').removeClass('mgs-scale-min');

					or.trigger({

						el : wrp,

						events : {
							'.mgs-confirmation .btns .back:click' : 'back',
							'.mgs-select-section .filter-by-category:change' : 'filter',
							'.mgs-select-section .filter-by-name:keyup' : 'search',
							'.mgs-select-wrp:click' : 'actions',
							'.mgs-select-wrp .load-more:mouseover' : 'load_more',
							'.mgs-layout-btns i:click' : 'layouts',
							'.mgs-menus li:click' : 'menus',
							'.mgs-download-section span.msg-download-action:click' : 'doDownload',
							'.mgs-download-section a.mgs-delete-profile:click' : 'delete_profile',
							'.mgs-download-section a.mgs-edit-profile:click' : 'edit_profile',
							'.mgs-download-section a.mgs-refresh-profile:click' : 'refresh_profile',

							'.mgs-upload-section .uploadNow:click' : 'processUploadFile',
							'.mgs-upload-section .createNew:click' : 'createNewProfile',

							'.mgs-download-section a.mgs-add-prof:click' : function( e ){
								$(this).closest('#or-global-sections').find('.mgs-menu-upload').trigger('click');
								e.preventDefault();
							},
						},

						load_more : function( e ){

							var label = $(this).data('label'),
								from = $(this).data('from'),
								to = $(this).data('to');

							$(this).after( or.ui.gsections.load( label, from, to ) ).remove();

							$(this).closest('.mgs-select-section').find('.filter-by-category').trigger('change');

							if( e.data !== undefined ){

								e.data.el.find('.mgs-select-wrp .load-more')
										 .off( 'mouseover')
										 .on( 'mouseover', e.data, e.data.load_more );

								setTimeout(function( el ){
									el.find('.mgs-select-wrp .mgs-scale-min').removeClass('mgs-scale-min');
								}, 100, e.data.el );

							}

						},

						actions : function( e ){

							var target = e.target;
							if( target === null )
								return;

							if( $(target).hasClass('edit-section') )
								return true;

							e.preventDefault();

							if( $(target).hasClass('mgs-sel-sceenshot') ){
								
								$(target).parent().find('.or_loadingicon').show();

								var sid = $(target).data('sid');

								var imageid = $(target).next('span').data('imageids'); 
								var status = $(target).next('span').data('status'); 
								
								if(sid == ''){
									alert('This template is coming soon.');
									return;
								}
								
								var obj = $(this);
								
								if(status == 1){
									var stack = or.backbone.stack.get('or_GlobalSections');

									for( var i in stack ){
										if( stack[i].id == sid ){
											if( stack[i].data !== undefined && stack[i].data !== '' )
												or.backbone.push( stack[i].data );
										}

									}

									obj.closest('.or-params-popup').find('.m-p-header .sl-close').trigger('click');
									
									$(target).parent().find('.or_loadingicon').hide();
									
									return;
								}
								
								$.post( or_ajax_url, {

									'action': 'or_upload_image',
									'images': imageid,
									'sid': sid,

								}, function (result) {
									
									//console.log(result);
									
									result.data = or.tools.base64.decode( result.data );
									or.backbone.stack.set( 'or_GlobalSections', result.data );
									
									var stack = or.backbone.stack.get('or_GlobalSections');

									for( var i in stack ){
										if( stack[i].id == sid ){
											if( stack[i].data !== undefined && stack[i].data !== '' )
												or.backbone.push( stack[i].data );
										}

									}
									
									obj.closest('.or-params-popup').find('.m-p-header .sl-close').trigger('click');
									
									$(target).parent().find('.or_loadingicon').hide();

								});	

							}else if( $(target).hasClass('load-more') ){

								$(target).trigger('mouseover');

							}


						},

						filter : function( e ){

							var wrp = $(this).closest('.mgs-select-section'),
								items = wrp.find('.mgs-section-item'),
								sections = wrp.find('.mgs-section-item'),
								i = 0;
							if( this.value === '' ){
								sections.removeClass('forceHide');
							}else{
								sections.addClass('forceHide');
								wrp.find('.mgs-section-item.category-'+or.tools.esc_slug(this.value)).removeClass('forceHide');
							}

						},

						search : function( e ){

							clearTimeout( document.key_up );

							document.key_up = setTimeout( function( inp ){

								var items = $( inp ).closest('.mgs-select-section').find('.mgs-section-item');
								items.addClass('forceHide').removeClass('break-line');

								items.find('.mgs-si-info span').each( function(){

									if( this.innerHTML.toLowerCase().indexOf( inp.value.toLowerCase() ) > -1 )
										$(this.parentNode.parentNode).removeClass('forceHide');

								});

							}, 150, this );


						},

						confirm : function( atts ){

							var wrp = $(atts.el).closest('#or-global-sections'),
								crp = wrp.find('.mgs-menus');

							wrp.find('.mgs-confirmation').attr({ class : 'mgs-confirmation' });

							crp.css({display:'none'});
							wrp.find('.mgs-select-section').css({display:'none'});
							wrp.find('.mgs-confirmation').css({display:'block'}).addClass( atts.type );
							wrp.find('.mgs-confirmation h1').html( atts.title );
							wrp.find('.mgs-confirmation h2').html( atts.message );

						},

						back : function(){
							var wrp = $(this).closest('#or-global-sections');
							wrp.find('.mgs-menus').css({display:'block'});
							wrp.find('.mgs-select-section').css({display:'block'});
							wrp.find('.mgs-confirmation').css({display:'none'}).attr({class:'mgs-confirmation'});
						},

						layouts : function( e ){

							$(this).parent().find('.active').removeClass('active');
							$(this).addClass('active');

							var layout = $(this).data('layout');

							$(this).closest('.mgs-select-section')
									.find('.mgs-select-wrp')
									.attr({ class : 'mgs-select-wrp layout-'+layout });

							or.cfg.sectionsLayout = layout;
							or.backbone.stack.set( 'or_Configs', or.cfg );

						},

						delete_profile : function( e ){

							if( confirm( or.__.i16 ) ){

								$('.m-p-body .or-popup-loading').show();

								var slug = $( this ).data( 'slug' );

								$.post( or_ajax_url, {

									'action': 'or_delete_profile',
									'slug': slug,

								}, function (result) {

									$('.m-p-body .or-popup-loading').hide();

									if( result === 0 ){

										alert( or.__.acc );

									}else if( result.status === undefined ){
										alert( result );
									}else if( result.status == 'success' ){

										for( var i in or_profiles ){
											if( i == slug )
												delete or_profiles[ i ];
										}

										or.ui.gsections.refresh( 'mgs-menu-download' );

									}else alert( result.message );

								});

							}

							e.preventDefault();

						},

						edit_profile : function( e ){

							var name = $( this ).data( 'name' ),
								new_name = prompt( or.__.i17, name ),
								slug = $( this ).data( 'slug' );

							e.preventDefault();

							if( new_name === '' || new_name === null || new_name === undefined )
								return;

							$('.m-p-body .or-popup-loading').show();

							$.post( or_ajax_url, {

								'action': 'or_rename_profile',
								'name': new_name,
								'slug': slug,

							}, function (result) {

								$('.m-p-body .or-popup-loading').hide();

								if( result === 0 ){

										alert( or.__.acc );

								}else if( result.status == 'success' ){

									if( or.cfg.profile_slug == slug ){

										or.cfg.profile = new_name;
										$('.msg-profile-label-display').html( new_name );

										or.backbone.stack.set( 'or_Configs', or.cfg );

									}

									or_profiles[ slug ] = new_name;
									or.ui.gsections.refresh( 'mgs-menu-download' );

								}else if( result.message !== undefined ){
									alert( result.message );
								}else alert( result );

							});


						},

						refresh_profile : function( e ){


							$(this).parent().find('.msg-download-action').trigger( 'click' );

							e.preventDefault();

						},

						doDownload : function( e ){

							var name = $(this).data('path').toString().trim();

							$('.m-p-body .or-popup-loading').show();

							$.post( or_ajax_url, {
								'action': 'or_load_profile',
								'name': or.tools.esc_slug( name )
							}, function ( result ) {

								$('.m-p-body .or-popup-loading').hide();

								if( result === 0 ){
									alert( or.__.acc );
									return;
								}

								if( result.status === undefined ){
									alert( result );
								}else if( result.status != 'success' ){
									alert( result.message );
								}else{

									result.data = or.tools.base64.decode( result.data );
									or.ui.gsections.doDownloadCallback( result );

								}

							});

						},

						processUploadFile : function( e ){

							if ( window.File && window.FileReader && window.FileList && window.Blob ) {

								var input = $(this).closest('.mgs-upload-main').find('input.msg-upload-profile-input'),
									f = input.get(0).files[0];

								if( f ){

									var name = or.tools.basename( f.name ),
										type = '';

									if( f.name.lastIndexOf( '.' ) > -1 )
										type = f.name.substring( f.name.lastIndexOf( '.' )+1 );

									if( type != 'or' ){
										alert( or.__.i18 );
										return;
									}

									var r = new FileReader();
								    r.onload = function(e) {

									    or.ui.gsections.createProfile( name, e.target.result );

								    };

								    r.readAsText(f);

							    }

							} else {
								alert( or.__.i19 );
							}

						},

						createNewProfile : function( e ){

							var input = $(this).closest('.mgs-upload-main').find('input.msg-new-profile-input'),
								name = input.val();

							if( name === undefined )
								return;

							if( name === '' ){

								input.animate({marginLeft:-10,marginRight:10}, 100)
								   .animate({marginLeft:10,marginRight:-10}, 100)
								   .animate({marginLeft:-5,marginRight:5}, 100)
								   .animate({marginLeft:3,marginRight:-3}, 100)
								   .animate({marginLeft:0,marginRight:0}, 100);

								return;
							}

							or.ui.gsections.createProfile( name, '' );

						},

						menus : function( e ){

							$(this).parent().find('.active').removeClass('active');
							$(this).addClass('active');

							var active = $(this).data('active');

							e.data.el.find('>div').css({display:'none'});
							e.data.el.find('>.mgs-menus,>.'+active).show();

						}

					});

					wrp.find('.mgs-select-wrp').on( 'mousewheel DOMMouseScroll', function ( e ) {
					    /*if( or.cfg.preventScrollPopup == 1 ){
						    var e0 = e.originalEvent,
						        delta = e0.wheelDelta || -e0.detail,
						        cu4 =  this.scrollTop;



						    this.scrollTop -= delta;

						    e.preventDefault();

						    if( cu4 == this.scrollTop  && delta < 0  )
						    	$(this).find('.load-more').trigger('mouseover');
					    }*/
					});

					or.ui.preventScroll( wrp.find('.mgs-settings-section') );

				},

				createProfile : function( name, data ){

					if( name === '' ){

						return;
					}

					if( data !== undefined && data !== '' ){

						var error = false;
						try{
							error = true;
							var test = JSON.parse( data );
							if( test[0] !== undefined ){
								if( test[0].title !== undefined && test[0].data !== undefined )
									error = false;
							}
						}catch( ex ){
							error = true;
						}

						if( error === true ){
							alert( or.__.i20 );
							return;
						}

					}

					name = name.replace(/\-/g,' ').replace(/\_/g,' ');
					slug = or.tools.esc_slug( name );

					var is_exist = function( _slug ){

						if( typeof or_profiles == 'object' ){
							for( var i in or_profiles ){
								if( _slug == i ){
									return true;
								}
							}
						}

						if( typeof or_profiles_external == 'object' ){
							for( var j in or_profiles_external ){
								if( _slug == j ){
									return true;
								}
							}
						}

						return false;

					};

					var i = 0;
					while( is_exist( slug ) ){

						i++;
						slug = or.tools.esc_slug( name )+'-'+i;

					}

					if( i > 0 ){
						name = name+' ('+i+')';
					}

					$('.or-popup-loading').show();

					$.post( or_ajax_url, {

						'action': 'or_create_profile',
						'name': name,
						'slug': slug,
						'data': or.tools.base64.encode( data )

					}, function (result) {

						$('.or-popup-loading').hide();

						if( result === 0 ){
							alert( or.__.acc );
							return;
						}else if( result.status === undefined ){
							alert( result );
							return;
						}else if( result.status != 'success' ){
							alert( result.message );
							return;
						}

						or_profiles[ slug ] = name;

						or.ui.gsections.doDownloadCallback({ name : name, data : data });

					});

				},

				doDownloadCallback : function( result ){

					if( result === undefined || result.name === undefined || result.name === '' )
						return;

					or.cfg.profile = result.name;

					if( result.slug !== undefined && result.slug !== '' )
						or.cfg.profile_slug = result.slug;
					else or.cfg.profile_slug = or.tools.esc_slug( result.name );

					$('.msg-profile-label-display').html( result.name.replace(/\-/g,' ').replace('.or','') );

					or.backbone.stack.set( 'or_Configs', or.cfg );
					or.backbone.stack.set( 'or_GlobalSections', result.data );

					/*Update list*/
					or.ui.gsections.refresh();

					var listbtn = $('#or-global-sections .mgs-menus .mgs-menu-list');
					if( listbtn.get(0) ){
						listbtn.trigger('click');
					}else{
						$('.or-params-popup .sl-close.sl-func').trigger('click');
					}

				},

				update_section : function( section ){

					or.loading( 'show', or.__.i21 );

					$.post( or_ajax_url, {

						'action': 'or_update_section',
						'slug': or.cfg.profile_slug,
						'name': or.cfg.profile,
						'id' : section.id,
						'data' : or.tools.base64.encode( JSON.stringify( section ) )

					}, function (result) {

						if( result === 0 ){
							alert( or.__.acc );
						}
						else if( result.status === undefined ){
							alert( result );
						}
						else if( result.status == 'success' )
						{

							or.cfg.profile = result.name;
							or_profiles[ or.cfg.profile_slug ] = result.name;
							if( or_profiles_external[ or.cfg.profile_slug ] !== undefined )
								delete or_profiles_external[ or.cfg.profile_slug ];

							or.backbone.stack.set( 'or_Configs', or.cfg );
							or.backbone.stack.set( 'or_GlobalSections', or.tools.base64.decode( result.data ) );

							if( typeof( or_sections_load ) == 'function' )
								or_sections_load();

							or.loading( 'hide', or.__.i22 );
							return;

						}
						else alert( result.message );

						$('#instantSaving').remove();

					});

				},

				showDownload : function( el ){

					if( or.get.popup( el ) !== null )
					{
						or.get.popup( el ).find('.mgs-menu-download').trigger('click');
					}
					else
					{
						$('#or-section-settings').trigger('click');
						$('.mgs-menu-download').trigger('click');
					}
				}

			},

			scrollAssistive : function( ctop, eff ){

				if( or.cfg.scrollAssistive != 1 )
					return false;

				if( typeof ctop == 'object'  ){
					if( $(ctop).get(0) ){
						var coor = $(ctop).get(0).getBoundingClientRect();
						ctop = (coor.top+$(window).scrollTop()-100);
					}
				}
				
				if( undefined !== eff && eff === false )
					$('html,body').scrollTop( ctop );
				else $('html,body').stop().animate({ scrollTop : ctop });

			},

			preventScroll : function( el ){
			
				if( or.cfg.preventScrollPopup == 1 ){
						
					el.addClass('or-prevent-scroll');

					el.off('mousewheel DOMMouseScroll').on( 'mousewheel DOMMouseScroll',
						
						function ( e ) {
							
						    if( this.scrollHeight > this.offsetHeight ){
								
								if( $('body').hasClass('or-ui-dragging') )
									return true;
									
							    var curS = this.scrollTop;
							    if( this.scrollCalc === undefined )
							    	this.scrollCalc = 0;
	
							    var e0 = e.originalEvent,
							        delta = e0.wheelDelta || -e0.detail;
								
								if( delta !== 0 ){
								
								    //this.scrollTop += ( delta <= 0 ? 1 : -1 ) * e.data.st;
								    this.scrollTop -= delta;
								    
									if( curS == this.scrollTop ){
										
										var pop = this.parentNode.parentNode,
											top = pop.offsetTop - 80,
											bottom = pop.offsetTop + ( pop.offsetHeight - window.innerHeight ) + 100;
										
										if( delta < 0 ){
											//scroll down
											
											if( or.body.scrollTop - delta < bottom )
												or.body.scrollTop -= delta;
											else or.body.scrollTop = bottom;
											
											if( or.html.scrollTop - delta < bottom )
												or.html.scrollTop -= delta;
											else or.html.scrollTop = bottom;
											
										}else{
											
											if( or.body.scrollTop - delta > top )
												or.body.scrollTop -= delta;
											else or.body.scrollTop = top;
											
											if( or.html.scrollTop - delta > top )
												or.html.scrollTop -= delta;
											else or.html.scrollTop = top;
										}
										
									}
									
								}
								
								if( e.target !== null && ( e.target.tagName === 'OPTION' || e.target.tagName === 'SELECT' || e.target.className.indexOf('or-free-scroll') > -1 ) ){
									return true;
								}
								
								e.preventDefault();
								e.stopPropagation();
								
								return false;
								
						    }

					});

				}
			},

			scroll : function( st ){

				if( typeof st == 'object' ){

					if( st.top !== undefined ){
						or.body.scrollTop = st.top;
						or.html.scrollTop = st.top;
					}

					if( st.left !== undefined ){
						or.body.scrollLeft = st.left;
						or.html.scrollLeft = st.left;
					}

				}else{
					return { top: (or.body.scrollTop?or.body.scrollTop:or.html.scrollTop),
						 left: (or.body.scrollLeft?or.body.scrollLeft:or.html.scrollLeft)};
				}
			},
			
			verify_tmpl : function(){
				
				
				var cfg = $().extend( or.cfg, or.backbone.stack.get('or_Configs') );
				
			//	if( cfg.version != or_version || localStorage['or_TMPL_CACHE'] === undefined || localStorage['or_TMPL_CACHE'] === '' ){
					
				//	or.loading( 'show', 'originbuilder is installed caching' );
					
					$.post(
		
						or_ajax_url,
		
						{
							'action': 'or_tmpl_storage',
							'security': or_ajax_nonce
						},
		
						function (result) {
							
							if( result != -1 && result != 0 ){
								
								cfg.version = or_version;
								
								or.backbone.stack.set( 'or_Configs', cfg );
								or.backbone.stack.set( 'or_TMPL_CACHE', result );
								
								or.init(); 
								
							}
							
							$('#instantSaving').remove();
							
						}
					);
				
			//	}else return true;
				
			},
			
			get_tmpl_cache : function( tmpl_id ){
			
				if( localStorage['or_TMPL_CACHE'] !== undefined && localStorage['or_TMPL_CACHE'].indexOf('id="'+tmpl_id+'"') > -1 ){
					
					var s1 = localStorage['or_TMPL_CACHE'].indexOf('>', localStorage['or_TMPL_CACHE'].indexOf('id="'+tmpl_id+'"') )+1,
						s2 = localStorage['or_TMPL_CACHE'].indexOf('</script>', s1),
						string = localStorage['or_TMPL_CACHE'].substring( s1, s2 ),
						options = {
                            evaluate:    /<#([\s\S]+?)#>/g,
                            interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                            escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
                            variable:    'data'
                        };
	
	                return _.template( string, null, options );
					
				}
				
				return 'exit';	
				
			},
			
			uncache : function(){
			
				localStorage.removeItem('or_TMPL_CACHE');
				
			},
			
			or_Box : {

				sort : function(){

					or.ui.sortable({

					    items : '.or-box:not(.or-box-column)',
					    connecting : true,
					    handle : '>ul.mb-header',
					    helper : ['or-ui-handle-image', 25, 25 ],
					    detectEdge: 30

				    });

				    if( window.chrome === undefined ){

						 $('.or-box-body .or-box-inner-text').off('mousedown').on( 'mousedown', function( e ){
								var el = this;
								while( el.parentNode ){
									el = el.parentNode;
								  	if( el.draggable === true ){
								  		el.draggable = false;
								  		el.templDraggable = true;
								  	}
								}
							}).off('blur').on( 'blur', function( e ){
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

				},

				renderBack : function( pop ){

					var exp = JSON.stringify(
						or.ui.or_Box.accessNodesVisual( pop.find('.or-box-render') )
					).toString(), rex = new RegExp( site_url, "g");
					
					exp = exp.replace( rex, '%SITE_URL%' );
					
					pop.find('.or-param.or-box-area').val( or.tools.base64.encode( exp ) );

				},

				wrapFreeText : function( el ){

					var nodes = el.childNodes, text, n, ind;

					if( nodes === undefined )
						return null;

					for( var i=0; i < nodes.length; i++ ){
						/* node text has type = 3 */
						
						n = nodes[i];
						
						if( nodes[i].nodeType == 3 ){

							if( n.parentNode.tagName != 'TEXT' && n.textContent.trim() !== '' ){

								text = document.createElement('text');

								if( n.nextElementSibling !== null )
									$( n.nextElementSibling ).before( text );
								else if( n.previousElementSibling !== null )
									$( n.previousElementSibling ).after( text );
								else n.parentNode.appendChild( text );

								text.appendChild(n);

							}
						}else{

							if( ['input', 'br', 'select', 'textarea', 'button'].indexOf( nodes[i].tagName.toLowerCase() ) > -1 ){

								ind = false;

								if( n.previousElementSibling !== null ){
									if( n.previousElementSibling.tagName == 'TEXT' ){
										$( n.previousElementSibling ).append( nodes[i] );
										ind = true;
									}
								}if( n.nextElementSibling !== null ){
									if( n.nextElementSibling.tagName == 'TEXT' ){
										$( n.nextElementSibling ).prepend( nodes[i] );
										ind = true;
									}
								}

								if( ind === false ){

									text = document.createElement('text');
									$( nodes[i] ).after(text);

									text.appendChild( nodes[i] );

								}

							}else or.ui.or_Box.wrapFreeText( nodes[i] );
						}
					}

					return el;

				},

				accessNodes : function( node, thru ){

					if( node === null )
						return [];

					var nodes = node.childNodes, nod, ncl, atts;

					if( thru === undefined )
						thru = [];

					if( nodes === null )
						return thru;

					for( var i=0; i < nodes.length; i++ ){
						/* node element has type = 1 */
						if( nodes[i].nodeType == 1 ){

							atts = {};

							for( var j=0; j< nodes[i].attributes.length; j++ ){
								atts[ nodes[i].attributes[j].name ] = nodes[i].attributes[j].value;
							}

							nod = {
								tag : nodes[i].tagName.toLowerCase(),
								attributes : atts,
							};

							if( nod.tag != 'text' )
								nod.children = or.ui.or_Box.accessNodes( nodes[i] );

							ncl = ( typeof( nodes[i].className ) != 'undefined' ) ? nodes[i].className : '';

							if( nod.tag == 'text' )
								nod.content = nodes[i].innerHTML;
							else if( nod.tag == 'img' )
								nod.tag = 'image';
							else if( ncl.indexOf('fa-') > -1 || ncl.indexOf('et-') > -1 || ncl.indexOf('sl-') > -1 )
								nod.tag = 'icon';
							else if( nod.tag == 'column' ){
								if( ncl === '' )
									ncl = 'one-one';
								['one-one','one-second','one-third','two-third'].forEach(function(c){
									if( ncl.indexOf( c ) > -1 ){
										ncl = ncl.replace( c, '').trim();
										nod.attributes.cols = c;
										nod.attributes.class = ncl;
									}
								});
							}

							thru[ thru.length ] = nod;

						}
					}

					return thru;

				},

				accessNodesVisual : function( wrp ){

					var nodes = wrp.find('>.or-box:not(.mb-helper)'), nod, thru = [];

					if( nodes.length === 0 )
						return thru;

					nodes.each(function(){

						nod = {
								tag : $(this).data('tag'),
								attributes : $(this).data('attributes'),
								children : or.ui.or_Box.accessNodesVisual( $(this).find('>.or-box-body') )
							};

						if( nod.attributes === undefined )
							nod.attributes = {};

						if( nod.tag == 'text' )
							nod.content = $(this).find('.or-box-inner-text').html();
						else if( nod.tag == 'icon' )
							nod.attributes.class = $(this).find('>.or-box-body i').attr('class');
						else if( nod.tag == 'image' )
							nod.attributes.src = $(this).find('>.or-box-body img').attr('src');

						thru[ thru.length ] = nod;

					});

					return thru;

				},

				exportCode : function( visual, cols ){

					var thru = '';
					if( cols === undefined )
						cols = '';
					var incol = cols+'	', count = 0;

					visual.forEach(function(n){

						if( n.tag == 'text' ){
							if( n.content !== '' )
								thru += cols+'<text>'+n.content.trim().replace(/\<text\>/g,'').replace(/\<\/text\>/g,'')+'</text>';
						}else{
							if( n.attributes.cols == 'one-one' ){
								if( n.children.length > 0 ){
									thru += or.ui.or_Box.exportCode( n.children, cols );
								}
							}else{

								if( n.attributes.cols !== undefined ){
									n.attributes.class = ( n.attributes.class !== undefined ) ?
														 (n.attributes.class+' '+n.attributes.cols) : n.attributes.cols;
									delete n.attributes.cols;
								}

								thru += cols+'<'+n.tag;
								for( var i in n.attributes )
									thru += ' '+i+'="'+or.tools.esc(n.attributes[i])+'"';
								thru += '>';
								if( n.children.length > 0 ){
									thru += "\n"+or.ui.or_Box.exportCode( n.children, incol )+"\n"+cols;
								}

								thru += '</'+n.tag+'>';

							}
						}
						if( count++ < visual.length-1 )
							thru += "\n";

					});

					return thru;

				},

				setColumns : function( e ){

					var el = or.get.popup( this ).data('el').closest('.or-box'),
						wrp = el.find('>.or-box-body'),
						cols = $(this).data('cols').split(' '),
						objCols = wrp.find('>.or-box.or-box-column'),
						elms, colElm, i, j, atts;

					for( i=0; i<cols.length; i++ ){

						if( objCols.get(i) ){

							objCols
							.eq(i)
							.attr({ 'class' : 'or-box or-box-column or-column-'+cols[i] })
							.data('attributes').cols = cols[i];

						}else{
							wrp.append(
								or.template(
									'box-design', [{ tag: 'column', attributes: { cols: cols[i] } }]
								)
							);
						}
					}
					if( i<objCols.length ){

						for( j = i; j < objCols.length; j++ ){
							objCols.eq(j).find('>.or-box-body>.or-box:not(.mb-helper)').each(function(){
								objCols.eq(i-1).append(this);
							});
							objCols.eq(j).remove();
						}

					}

					or.get.popup( this, 'close' ).trigger('click');

					or.ui.or_Box.sort();

				},

				actions : function( el, e ){

					var wrp = el.closest('.or-param-row').find('.or-box-render'), pos, btns, pop, cols, atts;

					switch( el.data('action') ){

						case 'add' :

							$('.or-box-subPop').remove();
							el.closest('.mb-header').addClass('editting');
							pos = el.data('pos');
							btns = '<div class="or-nodes">';
							pop = or.tools.popup.render( el.get(0), {
								title: 'Select Node Tag',
								class: 'no-footer or-nodes or-box-subPop',
								scrollBack: true,
								keepCurrentPopups: true,
								drag: false,
							});

							pop.data({ pos: pos, el: el, cancel: function( pop ){
								pop.data('el').closest('.mb-header').removeClass('editting');
							} });

							['text','image','icon', 'div','span','a','ul','ol','li','p','h1','h2','h3','h4','h5','h6']
							.forEach(function(n){
								btns += '<button class="button">'+n+'</button> ';
							});

							btns += '</div>';

							btns = $(btns);

							pop.find('.m-p-body').append( btns );

							btns.find('button').on('click', function(e){

								var html = or.template( 'box-design', [{ tag: this.innerHTML }] ),
									pop = or.get.popup( this ),
									pos = pop.data('pos'),
									el = pop.data('el');

								if( pos == 'top' )
									wrp.prepend( html );
								else if( pos == 'bottom' )
									wrp.append( html );
								else if( pos == 'inner' ){
									el.closest('.or-box:not(.mb-helper)').find('>.or-box-body').append( html );
								}

								or.ui.or_Box.sort();

								or.get.popup( this, 'close' ).trigger('click');

								e.preventDefault();
								return false;

							});

							e.preventDefault();

						break;

						case 'columns' :

							$('.or-box-subPop').remove();
							el.closest('.mb-header').addClass('editting');
							btns = '<div class="or-nodes">';
							pop = or.tools.popup.render( el.get(0), {
								title: 'Select Layout - Columns',
								class: 'no-footer or-nodes or-columns or-box-subPop',
								scrollBack: true,
								keepCurrentPopups: true,
								drag: false,
							});

							pop.data({ el: el, cancel: function( pop ){
								pop.data('el').closest('.mb-header').removeClass('editting');
							} });

							[['one-one','1/1'],
							 ['one-second one-second','1/2 + 1/2'],
							 ['one-third two-third','1/3 + 2/3'],
							 ['two-third one-third','2/3 + 1/3'],
							 ['one-third one-third one-third','1/3 + 1/3 + 1/3']].forEach(function(n){
								btns += '<button data-cols="'+n[0]+'" class="button '+n[0].replace(' ','')+
									'"><span>'+n[1]+'</span></button> ';
							});

							btns += '</div>';

							btns = $(btns);

							pop.find('.m-p-body').append( btns );

							btns.find('button').on('click', or.ui.or_Box.setColumns );

							e.preventDefault();

						break;

						case 'remove' :

							if( el.closest('.or-box').data('tag') == 'column' ){

								if( el.closest('.or-box').find('>.or-box-body>.or-box:not(.mb-helper)').length > 0 ){
									if( !confirm( or.__.i23 ) )
										return;
								}

								cols = el.closest('.or-box').parent().get(0);
								el.closest('.or-box').remove();
								var _cols = $(cols).find('>.or-box.or-box-column'), _clas = 'one-one';

								if( _cols.length == 2 )
									_clas = 'one-second';

								_cols.each(function(){
									$(this).attr({ 'class' : 'or-box or-box-column or-column-'+_clas })
										   .data('attributes').cols = _clas;
								});

								return;
							}

							var trash = el.closest('.or-param-row').find('.or-box-trash'),
								item = el.closest('.or-box').get(0);

							pos = {};

							pos.parent = item.parentNode;
							if( item.nextElementSibling )
								pos.next = item.nextElementSibling;
							if( item.previousElementSibling )
								pos.prev = item.previousElementSibling;

							$(item).data({ pos : pos });

							trash.append( item );
							trash.find('a.button')
							.html('<i class="sl-action-undo"></i> '+or.__.i24+'('+trash.find('>.or-box').length+')')
							.removeClass('forceHide');


						break;

						case 'undo' :

							trash = el.closest('.or-param-row').find('.or-box-trash');
							var last = trash.find('>.or-box').last().get(0);
							pos = $(last).data('pos');

							if( !last )
								return;

							if( pos.next !== undefined )
								$(pos.next).before( last );
							else if( pos.prev !== undefined )
								$(pos.prev).after( last );
							else if( pos.parent !== undefined )
								$(pos.parent).append( last );

							var nu = trash.find('>.or-box').length;

							trash.find('a.button')
							.html('<i class="sl-action-undo"></i> '+or.__.i24+'('+nu+')');

							if( nu === 0 )
								trash.find('a.button').addClass('forceHide');

							e.preventDefault();

						break;

						case 'double' :

							var clone = el.closest('.or-box').clone(true);
							clone.attr({draggable:'',dropable:''});
							clone.find('.or-box').attr({draggable:'',dropable:''});

							el.closest('.or-box').after( clone );
							or.ui.or_Box.sort();

						break;

						case 'settings' :

							$('.or-box-subPop').remove();
							el.closest('.mb-header').addClass('editting');
							atts = el.closest('.or-box').data('attributes');
							pop = or.tools.popup.render( el.get(0), {
								title: 'Node Settings',
								class: 'or-box-settings-popup or-box-subPop',
								scrollBack: true,
								keepCurrentPopups: true,
								drag: false,
							});

							pop.data({

								model : null,

								el: el,

								cancel : function( pop ){

									pop.data('el').closest('.mb-header').removeClass('editting');

								},

								callback : function( pop ){

									pop.data('el').closest('.mb-header').removeClass('editting');

									var el = pop.data('el').closest('.or-box'),
										attrs = {};

									pop.find('.fields-edit-form .or-param').each(function(){
										if( this.value !== '' )
											attrs[ this.name ] = or.tools.esc( this.value );
									});

									or.params.fields.css_box.save( pop );

									if( pop.data('css') !== undefined && pop.data('css') !== '' )
										attrs.style = pop.data('css');

									if( el.data('attributes').cols !== undefined )
										attrs.cols = el.data('attributes').cols;

									el.data({ attributes : attrs });

									['id','class','href'].forEach(function(n){
										if( attrs[n] !== undefined ){
											var elm = el.find('>.mb-header>.mb-'+n), str = attrs[n].substr(0,30)+'..';

											if( elm.length > 0 )
												elm.find('span').html( str ).attr({title:attrs[n]});
											else
												el.find('>.mb-header>.mb-funcs')
													.before('<li class="mb-'+n+'">'+n+
													': <span title="'+or.tools.esc(attrs[n])+'">'+str+'</span></li>');
										}
									});

								},

								css : ( typeof( atts.style ) != 'undefined' ) ? atts.style : ''

							});

							wrp = $('<div class="fields-edit-form or-pop-tab form-active"></div>');

							var form = $('<form class="attrs-edit"><input type="submit" class="forceHide" /></form>'),

								field = function( n, v ){
									var field = $('<div class="or-param-row"><div class="m-p-r-label"><label>'+
										   or.tools.esc(n)+':</label></div><div class="m-p-r-content"><input name="'+
										   or.tools.esc(n)+'" class="or-param" value="'+
										   v+'" style="width:90%;" type="text">'+
										   ' &nbsp; <a href="#"><i class="fa-times"></i></a></div></div>');
									field.find('a').on('click', function(e){
										$(this).closest('.or-param-row').remove();
										e.preventDefault();
									});

									return field;

								},

								addInput = function(){

									var add = $('<div style="padding: 10px 0 10px" class="or-param-row align-right"><div class="m-p-r-label"></div><form class="m-p-r-content">'+
									'<input style="height: 34px;width: 52.5%;" type="text" placeholder="'+or.__.i25+'" /> '+
									'<button style="margin-right: 33px;height: 34px;" class="button button-primary">'+or.__.i26+'</button>'+
									'<input type="submit" class="forceHide" /></form></div>');

									add.find('button').on('click', function(e){

										var input = $(this.parentNode).find('input'),
											val = input.val().replace(/[^a-z-]/g,'');

										input.val('');

										if( val === '' ||
											$(this).closest('.m-p-body').find('input[name='+val+']').length > 0 ||
											val == 'style' ){

											$(this).stop()
												  .animate({marginRight:50},100)
												  .animate({marginRight:28},100)
												  .animate({marginRight:38},80)
												  .animate({marginRight:30},80)
												  .animate({marginRight:33},50);
											return false;
										}

										$(this).closest('.or-param-row').before( field(val,'') );

										e.preventDefault();
										return false;
									});

									add.find('form').on('submit',function(){
										$(this).find('button').trigger('click');
										return false;
									});

									return add;
								};

							form.append( field( 'id', ( typeof( atts['id'] ) != 'undefined' ) ? atts['id'] : '' ) );
							form.append( field( 'class', ( typeof( atts['class'] ) != 'undefined' ) ? atts['class'] : '' ) );

							if( el.closest('.or-box').get(0).tagName == 'A' )
								form.append( field( 'href', ( typeof( atts['href'] ) != 'undefined' ) ? atts['href'] : '' ) );

							for( var i in atts ){
								if( i != 'id' && i != 'class' && i != 'style' && i != 'cols' )
									form.append( field( i, atts[i] ) );
							}

							wrp.append( form );
							wrp.append( addInput() );

							or.ui.preventScroll( pop.find('.m-p-body').append( wrp ), 100 );

							form.on( 'submit', function(e)
							{
								or.get.popup( this, 'save' ).trigger('click');
								e.preventDefault();
								return false;
							});

							or.tools.popup.add_tab( pop,
							{
								title: '<i class="et-adjustments"></i> '+or.__.i27,
								class: 'or-tab-visual-css-title',
								callback:  or.params.fields.css_box.visual
							});
							or.tools.popup.add_tab( pop,
							{
								title: '<i class="et-search"></i> '+or.__.i28,
								class: 'or-tab-code-css-title',
								callback:  or.params.fields.css_box.code
							});

						break;

						case 'editor' :

							$('.or-box-subPop').remove();
							el.closest('.mb-header').addClass('editting');
							atts = el.closest('.or-box').data('attributes');
							pop = or.tools.popup.render( el.get(0), {
								title: 'Node Settings',
								class: 'or-box-editor-popup or-box-subPop',
								scrollBack: true,
								keepCurrentPopups: true,
								drag: false,
								width: 750
							});

							pop.data({

								model : null,

								el: el,

								cancel : function( pop ){

									pop.data('el').closest('.mb-header').removeClass('editting');

								},

								callback : function( pop ){
									
									var content = pop.find('.wp-editor-area.or-param').val().toString().trim();
									
									//content = content.replace( /\n/g, '<br>' );
									//console.log(content + 'rahul');
									content = switchEditors.wpautop( content );
									//console.log(content);
									
									var inner = pop.data('el').closest('.or-box').find('.or-box-inner-text'),
										content = $( content );
									
									if( content.length === 1 && content.get(0).tagName == 'P' )    
										inner.html( content.get(0).innerHTML );
									else inner.html( content );

								}

							});

							atts = {

								value 	: el.closest('.or-box').find('.or-box-inner-text').html(),
								options : [],
								name	: 'content',
								type	: 'textarea_html'

							};
							field = or.template( 'field', {
									label: '',
									content: or.template( 'field-type-textarea_html', atts ),
									des: '',
									name: 'textarea_html',
									base: 'content'
							});

							or.ui.preventScroll( pop.find('.m-p-body').append( field ), 100 );

							if( typeof atts.callback == 'function' ){
								/* callback from field-type template */
								setTimeout( atts.callback, 1, pop.find('.m-p-body'), $ );
							}

						break;

						case 'toggle' :

							wrp = el.closest('.or-box');
							if( wrp.hasClass('or-box-toggled') )
								wrp.removeClass('or-box-toggled');
							else wrp.addClass('or-box-toggled');

						break;

						case 'html-code' :

							$('.or-box-html-code').remove();

							atts = {
								title: or.__.i29,
								width: 700,
								class: 'or-box-html-code',
								keepCurrentPopups: true,
								drag : false
							};

							pop = or.tools.popup.render( el.get(0), atts );
							pop.data({ target: el, scrolltop: $(window).scrollTop() });

							/*Render from Visual*/
							var code = or.ui.or_Box.exportCode(
								or.ui.or_Box.accessNodesVisual(
									or.get.popup(el).find('.or-box-render')
								)
							);

							pop.find('.m-p-body').html('<textarea>'+code+'</textarea>');

							pop.data({ popParent : or.get.popup( el ), callback : function( pop ){

								var code = '<div>'+pop.find('.m-p-body textarea').val().trim()+'</div>',
									visual = or.ui.or_Box.wrapFreeText( $( code ).get(0) ),
									items = or.ui.or_Box.accessNodes( visual ),
									popParent = pop.data('popParent');

								popParent.find('.or-box-render').html(
									or.template( 'box-design', items )
								);

								or.ui.or_Box.sort();

								/* Clear Trash */
								popParent.find('.or-box-trash .or-box').remove();
								popParent.find('.or-box-trash>a.button').addClass('forceHide');

							} });

						break;

						case 'css-code' :

							$('.or-box-html-code').remove();

							atts = {
								title: or.__.i30,
								width: 700,
								class: 'or-box-html-code',
								keepCurrentPopups: true,
								drag : false
							};

							var popParent = or.get.popup( el );

							pop = or.tools.popup.render( el.get(0), atts );
							pop.data({ target: el, scrolltop: $(window).scrollTop() });

							var css = popParent.find('.field-hidden.field-base-css_code input').val(), css_code = '';
							
							pop.find('.m-p-body').html('<p></p><textarea>'+or.tools.decode_css( css )+'</textarea><i class="ntips">'+or.__.i31+'</i>');

							var btn = $('<button class="button button-larger"><i class="sl-energy"></i> '+or.__.i32+'</button>');

							pop.find('.m-p-body').prepend( btn );

							btn.on( 'click', function(){
								var txta = $(this).parent().find('textarea');
								txta.val( or.tools.decode_css( txta.val() ) );
							});

							pop.data({ popParent : or.get.popup( el ), callback : function( pop ){


								var css = or.tools.encode_css( pop.find('textarea').val() );

								pop.data('popParent').find('.field-hidden.field-base-css_code input').val( css );

							} });

						break;

						case 'icon-picker' :

							$('.or-icons-picker-popup,.or-box-subPop').remove();

							var listObj = $( '<div class="icons-list noneuser">'+or.tools.get_icons()+'</div>' );

							atts = { title: 'Select Icons', width: 600, class: 'no-footer or-icons-picker-popup or-box-subPop', keepCurrentPopups: true };
							pop = or.tools.popup.render( el.get(0), atts );
							pop.data({ target: el, scrolltop: jQuery(window).scrollTop() });

							var search = $( '<input type="search" class="or-components-search" placeholder="Search elements" />' );
							pop.find('.m-p-header').append(search);
							search.after('<img class="sl-magnifier search_bar" src="'+plugin_url+'/assets/images/search.png" />');
							search.data({ list : listObj });

							search.on( 'keyup', listObj, function( e ){

								clearTimeout( this.timer );
								this.timer = setTimeout( function( el, list ){
									var sr;
									if( list.find('.seach-results').length === 0 ){

										sr = $('<div class="seach-results"></div>');
										list.prepend( sr );

									}else sr = list.find('.seach-results');

									var found = ['<span class="label">'+or.__.i33+'</span>'];
									list.find('>i').each(function(){

										if( this.className.indexOf( el.value.trim() ) > -1 &&
											found.length < 14 &&
											$.inArray( this.className, found )
										)found.push( '<span data-icon="'+this.className+'"><i class="'+this.className+'"></i>'+this.className+'</span>' );

									});
									if( found.length > 1 ){
										sr.html( found.join('') );
										sr.find('span').on('click', function(){
											var tar = or.get.popup(this).data('target');
											tar.find('i').attr({ class : $(this).data('icon') });
											or.get.popup(this,'close').trigger('click');
										});
									}
									else sr.html( '<span class="label">'+or.__.i34+'</span>' );

								}, 150, this, e.data );

							});

							listObj.find('i').on('click', function(){

								var tar = or.get.popup(this).data('target');
								tar.find('i').attr({class:this.className});
								or.get.popup(this,'close').trigger('click');

							});

							setTimeout(function( el, list ){
								el.append( list );
							}, 10, pop.find('.m-p-body'), listObj );

						break;

						case 'select-image' :

							var media = or.tools.media.open({ data : { callback : function( atts ){

								var url = atts.url;

								if( atts.size !== undefined && atts.size !== null && atts.sizes[atts.size] !== undefined ){
									url = atts.sizes[atts.size].url;
								}else if( typeof atts.sizes.medium == 'object' ){
									url = atts.sizes.medium.url;
								}

								if( url !== undefined && url !== '' ){

									el.attr({ src : url });

								}
							}, atts : {frame:'post'} } } );

							media.$el.addClass('or-box-media-modal');

						break;
					}

					if( el.hasClass('or-box-toggled') &&  el.hasClass('or-box') )
						el.removeClass('or-box-toggled');

					e.preventDefault();
					return false;

				}

			},

			elms : function( e, el ){

				var type = $( el ).data('type'),
					cfg = $( el ).data('cfg'),
					value = '';

				if( e.target.tagName == 'LI' && type == 'radio' ){

					var wrp = $(e.target).parent();
					wrp.find('.active').removeClass('active');
					wrp.find('input[type="radio"]').attr({checked:false});
					$(e.target).addClass('active');

					value = $(e.target).find('input[type="radio"]').attr({checked:true}).val();

				}

				if( type == 'select' ){
					value = el.value;
				}

				if( value !== '' && cfg !== '' && cfg !== undefined ){
					or.cfg[ cfg ] = value;
					or.backbone.stack.set( 'or_Configs', or.cfg );
				}

			},

			publishAction : function( e ){

				if( e.data )
				{
					var rect = e.data.getBoundingClientRect();
					var sctop = $( window ).scrollTop();
					if( e.data.sctop === undefined )
						e.data.sctop = rect.top + sctop;

					if( e.data.sctop < sctop + 35 )
						$( e.data ).addClass('float_publish_action');
					else
						$( e.data ).removeClass('float_publish_action');
				}

			}

		},

		get : {

			model : function( el ){

				var id = $(el).data('model');
				if( id !== undefined && id !== -1 )
					return id;
				else if( el.parentNode ){
					if( el.parentNode.id != 'or-container' )
						return this.model( el.parentNode );
					else
						return null;
				}else return null;
			},

			storage : function( el ){
				return or.storage[ this.model(el) ];
			},

			maps : function( el ){
				return or.maps[ this.storage(el).name ];
			},

			popup : function( el, btn ){

				var pop = $(el).closest('.or-params-popup');

				if( pop.length === 0 )
					return null;

				if( btn == 'close' )
					return pop.find('.m-p-header .sl-close.sl-func');
				else if( btn == 'save' )
					return pop.find('.m-p-header .sl-check.sl-func');
				else return pop;

			}

		},

		submit : function(){

			or.changed = false;

			$('#or-post-mode').val( or.cfg.mode );

			if( or.cfg.mode != 'or' )
					return;

			$('#or-container').find('form,input,select,textarea').remove();

			var content = '';
			$('#or-container > #or-rows > .or-row').each(function(){
				var exp =  or.backbone.export( $(this).data('model') );
				content += exp.begin+exp.content+exp.end;
			});
				
			if( content === '' && !confirm( or.__.i53 ) )
				return false;
				
			$('#content').val(content);
			try{
				tinyMCE.get('content').setContent( content );
			}catch(ex){}

		},

		instantSubmit : function(){

			if( or.curentContentType !== undefined &&  or.curentContentType == 'or-sections' ){
				$('#publishing-action button').trigger('click');
				return;
			}

			if( $('#instantSaving').length > 0 || or.cfg.mode != 'or' )
				return;

			if( $('#post').length === 0 || $('#title').length === 0 || $('#post_ID').length === 0 )
				return;

			or.loading( 'show', or.__.i35 );

			document.raw_title = document.title;
			document.title = 'Saving...';

			var list = $('.or-params-popup .sl-check.sl-func, .or-params-popup .save-post-settings');
			if( list.length > 0 ){
				for( var i = list.length - 1; i>=0; i-- )
					list.eq(i).trigger('click');
			}

			$('.or-params-popup .or-pop-tabs>li').first().trigger('click');


			var content = '', id = $('#post_ID').val(), title = $('#title').val(), css = $('#or-page-css-code').val(), classes = $('#or-page-body-classes').val();

			$('#or-container > #or-rows > .or-row').each(function(){
				var exp =  or.backbone.export( $(this).data('model') );
				content += exp.begin+exp.content+exp.end;
			});

			$.post(

				or_ajax_url,

				{
					'action': 'or_instant_save',
					'security': or_ajax_nonce,
					'title': title,
					'id': parseInt( id ),
					'content': content,
					'classes': classes,
					'css': css
				},

				function (result) {

					document.title = document.raw_title;
					if( result == '-1' )
						or.loading( 'hide', 'Error: secure session is invalid. Reload and try again' );
					else if( result == '-2' )
						or.loading( 'hide', 'Error: Post not exist' );
					else if( result == '-3' )
						or.loading( 'hide', 'Error: You do not have permission to edit this post' );
					else or.loading( 'hide', 'Successful' );
					
					if( $('#content').length > 0 ){
						$('#content-html').trigger('click');
						$('#content').val( content );
					}
					
					or.changed = false;

				}
			);

		},

		switch : function( force ){

			if( force === true )
				or.cfg.mode = '';
			
			if( or.front !== undefined )
				return;
				
			/*Clear Trash*/
			$('#or-undo-deleted-element').css({top:-132});
			$('#or-storage-prepare>.or-model').remove();

			if( or.cfg.mode == 'or' ){

				or.cfg.mode = '';
				or.backbone.stack.set( 'or_Configs', or.cfg );

				var content = '';
					
				or.changed = false;
				
				$('#or-container > #or-rows > .or-row').each( function(){
					var exp =  or.backbone.export( $(this).data('model') );
					content += exp.begin + exp.content + exp.end;
				});

				or.model = 1; 
				or.storage = [];

				$('#or-container,.or-params-popup').remove();
				$('#postdivrich').css({ visibility: 'visible', display: 'block' });
				$('html,body').stop().animate({ scrollTop : $(window).scrollTop()+3 });
				
				//tinymce.EditorManager.execCommand('mceAddEditor',true, 'content');
				
				window.wpActiveEditor = 'content';
				if( content !== '' ){
					$('#content').val(content);
					try{
						tinyMCE.get('content').setContent( content );
					}catch(ex){}
				}
				
				if( typeof( or.wp_beforeunload ) == 'function' )
					$( window ).off( 'beforeunload' ).on('beforeunload', or.wp_beforeunload );

				return false;

			}else{
				
				or.cfg.mode = 'or';
				or.model = 1;
				or.storage = [];
				or.changed = false;
				
				if( typeof( or.wp_beforeunload ) != 'function' )
					try{ or.wp_beforeunload = $(window).data('events').beforeunload[0].handler; }catch( ex ){}
				
				$( window ).off('beforeunload').on('beforeunload', function(e){
				
				    if( or.changed === true )
						return or.__.i01;
				    else{
				    	
				    	if( or.cfg.mode == 'or' ){
				    		e = null;
						}
				    	e = null;
				    }
				});


			}

			/*Update config about activate of builder*/
			or.backbone.stack.set( 'or_Configs', or.cfg );

			or.views.builder.render();
			or.params.process();
			or.ui.columnsResize.load();
			or.ui.sortInit();

		},

		loading : function( mode, message ){

			if( mode == 'show' ){
				$('body').append('<div id="instantSaving"><span><i class="fa fa-spinner fa-spin fa-3x"></i><br /><br />'+message+'</span></div>');
			}else{
				$('#instantSaving').html('<span><i class="fa fa-check fa-3x"></i><br /><strong class="fa-2x">'+message+'</strong></span>');
				setTimeout( function(){ $('#instantSaving').remove(); }, 1000 );
			}

		},
		
		std : function( ob, key, std ){
			
			if( typeof( ob ) !== 'object' )
				return std;
			if( ob[key] !== undefined && ob[key] !== '' )
				return ob[key];
			
			return std;
			
		}

	}, window.or );

	$( document ).ready(function(){
		if( or.ui.verify_tmpl() === true )
			or.init(); 
	});

})( jQuery );



jQuery(document).ready(function() {
	//drag and drop
    jQuery('body').on('change', '.btn-upload1.upload_image', function(e){ 
	var p=jQuery(this).parent('.fe_image').closest('.or-attach-field-wrp');
        e.preventDefault;
        var fd1 = new FormData();
        var files_data1 = jQuery('.files-data'); 
        jQuery.each(jQuery(files_data1), function(i, obj) {
            jQuery.each(obj.files,function(j,file){
                fd1.append('files[' + j + ']', file);
            })
        });
		//jQuery('#loading-image1').css('display','block');
        fd1.append('action', 'cvf_upload_files1');  
        jQuery.ajax({
            type: 'POST',
            url: 'admin-ajax.php',
            data: fd1,
            contentType: false,
            processData: false,
            success: function(response){ 
			sr=response.split("--yes--"); 
		
            if(sr[1]!=undefined){	 
			p.find('.or-param').val(sr[0]);
		   p.find('.img-wrp:first-child').remove();
			  p.prepend('<div class="img-wrp"><img src="'+sr[1]+'" alt="" /><span class="sl-close drag_close"></span></div>');
			}
			if(sr[1]==undefined){
				jQuery('#errr').html('Error In uploading try again');
			  }
            },
			complete: function(){
            //jQuery('#loading-image1').css('display','none');
          }
        });
    });
	  jQuery('body').on('click', '.drag_close', function(){  
	                var p1=jQuery(this).parent('.img-wrp').closest('.or-attach-field-wrp');
	                   p1.find('input.or-param').val('');
						jQuery(this).closest('div.img-wrp').remove();
	 });
	 
	 
	 jQuery(document).ready(function() {
	//drag and drop
    jQuery('body').on('change', '.btn-upload1.image_url', function(e){ 
	var p=jQuery(this).parent('.fe_image').closest('.or-attach-field-wrp');
        e.preventDefault;
        var fd1 = new FormData();
        var files_data1 = jQuery('.files-data'); 
        jQuery.each(jQuery(files_data1), function(i, obj) {
            jQuery.each(obj.files,function(j,file){
                fd1.append('files[' + j + ']', file);
            })
        });
		//jQuery('#loading-image1').css('display','block');
        fd1.append('action', 'cvf_upload_files2');  
        jQuery.ajax({
            type: 'POST',
            url: 'admin-ajax.php',
            data: fd1,
            contentType: false,
            processData: false,
            success: function(response){ 
			sr=response.split("--yes--"); 
		
            if(sr[1]!=undefined){	 
			p.find('.or-param').val(sr[1]);
		   p.find('.img-wrp:first-child').remove();
			  p.prepend('<div class="img-wrp"><img src="'+sr[1]+'" alt="" /><span class="sl-close drag_close"></span></div>');
			}
			if(sr[1]==undefined){
				jQuery('#errr').html('Error In uploading try again');
			  }
            },
			complete: function(){
            //jQuery('#loading-image1').css('display','none');
          }
        });
    });
	  jQuery('body').on('click', '.drag_close', function(){  
	                var p1=jQuery(this).parent('.img-wrp').closest('.or-attach-field-wrp');
	                   p1.find('input.or-param').val('');
						jQuery(this).closest('div.img-wrp').remove();
	 }); });
	 
	 
	 
	 	  jQuery('body').on('change', '.btn-upload1.attach-images', function(e){ 
	    var p=jQuery(this).parent('.fe_image').closest('.or-attach-field-wrp');
        e.preventDefault;
        var fd1 = new FormData();
        var files_data1 = jQuery('.files-data'); 
        jQuery.each(jQuery(files_data1), function(i, obj) {
            jQuery.each(obj.files,function(j,file){
                fd1.append('files[' + j + ']', file);
            })
        });
		 
	 
        fd1.append('action', 'cvf_upload_files1');  
        jQuery.ajax({
            type: 'POST',
            url: 'admin-ajax.php',
            data: fd1,
            contentType: false,
            processData: false,
            success: function(response){ 
			sr=response.split("--yes--"); 
		
            if(sr[1]!=undefined){	 
			var v= p.find('.or-param').val();
			if(v==''){
				p.find('.or-param').val(sr[0]);
			}
			else{
				p.find('.or-param').val(v+","+sr[0]);
			}
			  p.prepend('<div class="img-wrp"  droppable="true" draggable="true" data-id="'+sr[0]+'"><img src="'+sr[1]+'" alt="" /><span class="sl-close drag_close1" id="'+sr[0]+'"></span></div>');
			}
			if(sr[1]==undefined){
				jQuery('#errr').html('Error In uploading try again');
			  }
            },
			complete: function(){
           
          } 
        });
    });
	   jQuery('body').on('click', '.drag_close1', function(){  
	   var p1=jQuery(this).parent('.img-wrp').closest('.or-attach-field-wrp');
       var value= this.id;
       var list=p1.find('input.or-param').val();
       separator = ","; 
       var values = list.split(separator);
       for(var i=0; i<values.length; i++) {
       if(values[i]===value) { 
       values.splice(i, 1);
       var l= values.join(separator);
    }
  }   
  		jQuery(this).closest('div.img-wrp').remove();
        p1.find('input.or-param').val(l);  
	 });
	 
	  /*jQuery('body').on('click', '.or-column-control .or-column-add.mtips,.or-column-control .sl-plus', function(){ 
	   jQuery('.or_row_inner').trigger("click");  
      
	    });*/
	    jQuery('body').on('click', '.right.columns.mtips .sl-list', function(){ 
	//var a= jQuery(this).parent(".right.columns.mtips").parent(".or-row-control.pos-left").parent(".or-row-inner.or-model").find(".or-row-wrap .or-column-inner.or-model").length;
	var a= jQuery(this).parent(".right.columns.mtips").parent(".or-row-control.pos-left").parent(".or-column-inner.or-model").parent('.or-row-wrap').find(".or-column-inner.or-model").length;
	 	   if(a==1){
	   jQuery('.or-col-btns .button.two').trigger("click");
	   
	   }
	    if(a==2){
	   
	   jQuery('.or-col-btns .button.three').trigger("click");
	   
	   } if(a==3){
	  
	   jQuery('.or-col-btns .button.four').trigger("click");
	  
	   }
	   if(a==4){
	  
	   jQuery('.or-col-btns .button.five').trigger("click");
	   
	   }
	   if(a==5){
	   
	   jQuery('.or-col-btns .button.six').trigger("click");
	   
	   }
	   if(a==6){
	   
	   jQuery('.or-col-btns .button.seven').trigger("click");
	   
	   }  
	   
	   });
	   jQuery('body').on('click', '.right.columns.mtips', function(){ 
       var b=jQuery(this).parent('.row-container-control.pos-left').next('.or-row-wrap').find('.or-column.or-model').length; 
 
	   if(b==1){
	   jQuery('.or-col-btns .button.two').trigger("click");
	   
	   }
	    if(b==2){
	   
	   jQuery('.or-col-btns .button.three').trigger("click");
	   
	   } if(b==3){
	  
	   jQuery('.or-col-btns .button.four').trigger("click");
	  
	   }
	   if(b==4){
	  
	   jQuery('.or-col-btns .button.five').trigger("click");
	   
	   }
	    if(b==5){ 
	   jQuery('.or-col-btns .button.six').trigger("click");
	     
jQuery(this).find('#col_six').html("This row has reached the maximum allowed number of columns") ;	  
	  }
	  if(b==6){
	    jQuery('.or-col-btns .button.six').trigger("click");
	    jQuery('#col_six').html("This row has reached the maximum allowed number of columns") ;
jQuery(this).find('#col_six').html("This row has reached the maximum allowed number of columns") ;	  
	  }
	   
	   });
});
 
jQuery(document).ready(function() {
	 jQuery('body').on('click', '.m-f-u-li-link .row_checked', function(){ 
	 
      if ( jQuery(this).find('input[type="checkbox"]').is(':checked') ) {
     jQuery(this).parent('.m-f-u-li-link').find('.mt-mes').html('Unlock');		  
         jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-left"]').attr("disabled",true); 
         jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-right"]').attr("disabled",true); 
         jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-bottom"]').attr("disabled",true); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-left"]').css("cursor","not-allowed"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-right"]').css("cursor","not-allowed"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-bottom"]').css("cursor","not-allowed"); 
		 
		  jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-left"]').attr("disabled",true); 
         jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-right"]').attr("disabled",true); 
         jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-bottom"]').attr("disabled",true); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-left"]').css("cursor","not-allowed"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-right"]').css("cursor","not-allowed"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-bottom"]').css("cursor","not-allowed"); 
     } else { 
	  jQuery(this).parent('.m-f-u-li-link').find('.mt-mes').html('Lock');
        jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-left"]').attr("disabled",false); 
		
        jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-right"]').attr("disabled",false); 
        jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-bottom"]').attr("disabled",false); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-left"]').css("cursor","default"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-right"]').css("cursor","default"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="margin-bottom"]').css("cursor","default"); 
		  
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-left"]').attr("disabled",false); 
		
        jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-right"]').attr("disabled",false); 
        jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-bottom"]').attr("disabled",false); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-left"]').css("cursor","default"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-right"]').css("cursor","default"); 
		 jQuery(this).parent('.m-f-u-li-link').parent('.multi-fields-ul').find('input[name="padding-bottom"]').css("cursor","default"); 
		 
     }
 }); 
  
  
 jQuery(document).on('click', '.or-row-wrap .right.columns.mtips .sl-list.blue_img', function(){
 jQuery(this).addClass("sd");
if(jQuery(this).parent('.right.columns.mtips').parent('.or-row-control').parent('.or-column-inner').parent('.or-row-wrap').find('.or-column-inner.or-model').eq(0).find('.sl-list.blue_img').hasClass("sd")==false) { 

jQuery(this).parent('.right.columns.mtips').parent('.or-row-control').parent('.or-column-inner').parent('.or-row-wrap').find('.or-column-inner.or-model').eq(0).find('.sl-list.blue_img').trigger("click"); 
}
  
jQuery(this).removeClass("sd");
 
 }); 
  
    jQuery(document).on('mouseover', '.front .icon', function(e){  
	
    jQuery(this).closest('.flip-container').addClass("hover");
      
  });
  jQuery(document).on('mouseleave', '.or-components-list-main li', function(e){  
    jQuery(this).find('.flip-container').removeClass("hover");
     
  });
  
 });  

 
jQuery(document).on('input', '.or-components-search', function(){
  
  if(jQuery(this).val()==''){
	  
	  jQuery('.or-components-categories .all').addClass("active");
	   jQuery('.or-components-categories .all').trigger("click");
  }
  
}) ;
/*
 jQuery('body').on('click', '.quickadd', function(){  

 if(jQuery(this).parent('ul').parent('#or-footers').prev('#or-rows').children('div').length==2){
	 jQuery(this).parent('ul').children('.svg_arrow').css('display','none');
 }
 
 });
 
 jQuery('body').on('click', '.right.close', function(){  
 
 if(jQuery('#or-rows').children('div').length==1){
	 
	   jQuery('#or-footers').find('.svg_arrow').css('display','block');
 }
 else{
	  jQuery('#or-footers').find('.svg_arrow').css('display','none');
 }
 });
 jQuery('body').on('click', '#or-switch-builder', function(){  
 
if(jQuery('#or-rows').children('div').length==1){
	 
	   jQuery('#or-footers').find('.svg_arrow').css('display','block');
 }
 else{
	  jQuery('#or-footers').find('.svg_arrow').css('display','none');
 }
 });
 
 jQuery(document).ready(function() {
	 
	setTimeout(function() {   
	if(jQuery('#or-rows').children('div').length!=1){ 
		 jQuery('#or-footers').find('.svg_arrow').css('display','none');
	 }
	 else{ 
		 jQuery('#or-footers').find('.svg_arrow').css('display','block');
	 }
	  }, 1000);
 });*/
 