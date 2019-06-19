/*
 * Origin Builder
 *
 * URI originbuilder.com
 *
 * 
 *
 *
*/

var or_front = ( function($){
	
	jQuery.extend( jQuery.easing, {
		easeInOutQuart: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
			return -c/2 * ((t-=2)*t*t*t - 2) + b;
		},
	});
	
	return {

		win_height : 0,

		win_width : 0,
		
		body : $('body'),

		parallax_timer : null,

		init : function(){

			var parallaxable = $('div[data-or-parallax="true"]');
			if( parallaxable.length > 0 )
			{
				parallaxable.each( function(){
					var speed = $(this).data('speed')*0.4;
					$(this).parallax("50%", speed);
				});
			}

			this.accordion();

			this.tabs();

			this.youtube_row_background.init();

			$( window ).on( 'resize', or_row_action );
			$( window ).on( 'load', or_row_action );

			if( window.location.href.indexOf('#') > -1 ){
				$('a[href="#'+window.location.href.split('#')[1]+'"]').trigger('click');
			}

			this.google_maps();

			this.image_gallery.slider();

			this.image_gallery.masonry();
			
			this.image_gallery.lightbox();

			this.carousel_images();

			this.carousel_post();

			this.countdown_timer();

			this.piechar.init();

			this.progress_bar.run();

			this.ajax_action();
			
			this.optinform();
			
			this.socialMedia();
			
			this.social_svg_icon();
					
		},
		
		social_loader_hide:function(){
			$('.or_social_loader').hide();
			$('.or_socialmain_ul').show();
		},
		
		social_svg_icon:function(){
			jQuery('img.or_svg').each(function(){
				var $img = jQuery(this);
				var imgID = $img.attr('id');
				var imgClass = $img.attr('class');
				var imgURL = $img.attr('src');
			
				jQuery.get(imgURL, function(data) {
					// Get the SVG tag, ignore the rest
					var $svg = jQuery(data).find('svg');
			
					// Add replaced image's ID to the new SVG
					if(typeof imgID !== 'undefined') {
						$svg = $svg.attr('id', imgID);
					}
					// Add replaced image's classes to the new SVG
					if(typeof imgClass !== 'undefined') {
						$svg = $svg.attr('class', imgClass+' replaced-svg');
					}
			
					// Remove any invalid XML tags as per http://validator.w3.org
					$svg = $svg.removeAttr('xmlns:a');
					
					// Check if the viewport is set, else we gonna set it if we can.
					if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
						$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
					}
			
					// Replace image with new SVG
					$img.replaceWith($svg);
			
				}, 'xml');
			
			});	
			//setTimeout(this.social_loader_hide(), 100000);	
		},
		
		socialMedia:function(){
			var new_window = '', timer = '';
			/*var data = {'action':'','url':''};
			var count = '', shareaction = '', redirecturl = '', currenturl = '';*/
			// upon clicking a share button
			jQuery('.or_linkedin_share,.or_google_share,.or_pinterest_share,.or_print_share,.or_reddit_share,.or_stumbleupon_share,.or_tumblr_share,.or_vk_share,.or_facebook_share,.or_twitter_share,.or_pocket_share').click(function(event){

				// don't go the the href yet
				event.preventDefault();

				// if it's facebook mobile
				if(jQuery(this).data('facebook') == 'mobile') {
					FB.ui({
						method: 'share',
						mobile_iframe: true,
						href: jQuery(this).data('href')
					}, function(response){});
				} else {
					// these share options don't need to have a popup
					if (jQuery(this).data('site') == 'email' || jQuery(this).data('site') == 'print' || jQuery(this).data('site') == 'pinterest') {

						// just redirect
						window.location.href = jQuery(this).attr("href");
					} else {

						// prepare popup window
						var width  = 575,
							height = 520,
							left   = (jQuery(window).width()  - width)  / 2,
							top    = (jQuery(window).height() - height) / 2,
							opts   = 'status=1' +
								',width='  + width  +
								',height=' + height +
								',top='    + top    +
								',left='   + left;

						// open the share url in a smaller window
						new_window = window.open(jQuery(this).attr("href"), 'share', opts);
						//console.log(new_window);
						//timer = setInterval(checkChild, 3000)
					}
				}
				
				/*shareaction = jQuery(this).data('shareaction');
				redirecturl = jQuery(this).data('redirecturl');
				currenturl = jQuery(this).data('currenturl');
				count = jQuery(this).data('count');
				data.url = jQuery(this).data('href');*/
				
				
			});

			/*function checkChild() {
				if (new_window.closed) {
					console.log(data);
					jQuery.ajax({
						type : 'POST',
						url  :  ajaxurl.url,
						data : data,
						cache: false,
						success : function(result){
							console.log(result + ' > ' + count);
							if(result > count){
								if(shareaction == '1'){
									if(redirecturl == ''){
										window.location.href = currenturl;
									}else{
										window.location.href = redirecturl;
									}
								}else{
									alert('setting issue');
								}
							}else{
								alert('No progress');
							}
						}					
					});   
					clearInterval(timer);
				}
			}*/
			
		},
		
		optinform:function(){
			
			$('.or_formsubscribe').submit(function(e){
				e.preventDefault();		
				
				$(this).find('input[name=email]').next('span').text('');
				
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				
				var responder = $(this).find('input[name=responder]').val();
				var name = ''; 
				var email = $(this).find('input[name=email]').val();
				var listid = $(this).find('input[name=list_id]').val();
				
				if($(this).find('input[name=name]').length){
					name = $(this).find('input[name=name]').val();
					if(responder == 'GoToWebinar'){
						name = { 'fname': name, 'lname' : ''};
					}
				}else{
					fname = $(this).find('input[name=fname]').val();
					lname = $(this).find('input[name=lname]').val();
					if(responder == 'GoToWebinar'){
						name = { 'fname': fname, 'lname' : lname};
					}else{
						name = fname + ' ' + lname;
					}
				}
				
				/*if(responder == 'GoToWebinar' && name == ''){
					$(this).find('input[name=email]').next('span').text('First and Last name is required.');
					return false;
				}*/
				
				if(email == ''){
					$(this).find('input[name=email]').next('span').text('Email is required.');
					return false;
				}
				
				if(!filter.test(email)){
					$(this).find('input[name=email]').next('span').text('Please enter a valid email address.');
					return false;
				}
				
				if(listid == ''){
					$(this).find('button').next('span').text('Subscribe unsuccessfully, please contact administrator for more information.');
					return false;
				}
				
				if(responder == ''){
					$(this).find('button').next('span').text('Subscribe unsuccessfully, please contact administrator for more information.');
					return false;
				}
				
				if(name == ''){
					var data = {
						
						'action' : 'or_responder_subscribes',
						'responder' : responder,
						'email' : email,
						'listid' : listid,
						
					};
				}else{
					var data = {
						
						'action' : 'or_responder_subscribes',
						'responder' : responder,
						'email' : email,
						'name' : name,
						'listid' : listid,
						
					};
				}	
				//console.log(data);
				
				var obj = $(this);
				obj.find('button').append('<i class="fa fa-spinner fa-spin fa-3x fa-fw remove_loader"></i>');
				
				var successaction = $(this).find('input[name=successaction]').val();
				var successmsg = $(this).find('input[name=successmsg]').val();
				var redirecturl = $(this).find('input[name=redirecturl]').val();
				var new_window = $(this).find('input[name=new_window]').val();
				
				jQuery.ajax({
					type : 'POST',
					url  :  ajaxurl.url,
					data : data,
					cache: false,
					success : function(result){
						//console.log(result);
						var result = jQuery.parseJSON(result);
						if(result.success){
							if(successaction == 'yes'){
								obj.find('button').next('span').addClass('or_lead_success');
								obj.find('button').next('span').text(successmsg);
							}else{
								if(new_window == 'yes'){
									window.open(redirecturl, '_blank');
								}else{
									window.location.replace(redirecturl);
								}
							}
						}else{
							obj.find('button').next().next('span').addClass('or_lead_error');
							obj.find('button').next().next('span').text(result.error);
						}
						
						obj.find('.remove_loader').remove();
					},
					error : function(e){
						console.log(e);
					}
				});
			
			});
		},
		
		jssor_slider: function(){
			var jssoroptions = $( '.or_slider_container_jssor' ).data('jssor-options');
			console.log(jssoroptions);
			if( typeof jssoroptions !== 'object' )
				return;
			
			
			
			var _SlideshowTransitions = [this.slidertransition[jssoroptions.transition]];
			console.log(_SlideshowTransitions);
			var options = {
				$FillMode: 0,
				$AutoPlaySteps: 1,
				$PauseOnHover: 1,
				$ArrowKeyNavigation: true,	
				$SlideDuration: 500,
				$MinDragOffsetToSlide: 20,													
				$SlideSpacing: 0, 													
				$DisplayPieces: 1,																	
				$ParkingPosition: 0,																
				$UISearchMode: 1,	
				$PlayOrientation: 1,															
				$DragOrientation: 0,	
				$AutoPlay: (jssoroptions.auto_play == 'yes' ? true : false),
				$AutoPlayInterval: 2000,
				$SlideDuration: parseInt(jssoroptions.transitionspeed) * 1000,
				$SlideshowOptions: {											
					$Class: $JssorSlideshowRunner$,
                    $Transitions: _SlideshowTransitions,
                    $TransitionsOrder: 1,
                    $ShowLink: true														
				},
				$ThumbnailNavigatorOptions: {
					$Class: $JssorThumbnailNavigator$,						 
					$ChanceToShow: 2,															 
					$ActionMode: 0,																 
					$DisableDrag: true,														 
					$Orientation: 2																 
				}
			};
			
			alert(jssoroptions.id);
			var jssor_slider = new $JssorSlider$(jssoroptions.id, options);
			
			//slideshow_transition_controller_starter(jssoroptions.id);
		},

		refresh: function( el ){

			setTimeout( function( el){
				
				or_front.piechar.update( el );
				or_front.progress_bar.update( el );
				or_front.image_gallery.masonry_refresh( el );

				if($('.or_video_play').length > 0){
					or_video_play.refresh( el );
				}

			}, 100, el );

		},

		google_maps: function( wrp ){
			
			$('.or_google_maps').each( function(){
			
				if( $(this).data('loaded') === true )
					return;
				else $(this).data({ 'loaded' : true });
				
				var $_this = $( this );

				$_this.find('.close').on('click', function(){
					$_this.find('.map_popup_contact_form').toggleClass( "hidden" );
					$_this.find('.show_contact_form').fadeIn('slow');
				});

				$_this.find('.show_contact_form').on('click', function(){
					$_this.find('.map_popup_contact_form').toggleClass( "hidden" );
					$_this.find('.show_contact_form').fadeOut('slow');
				});
			});
		},

		accordion: function( wrp ){

			$('.or_accordion_wrapper').each(function(){
				
				if( $(this).data('loaded') === true )
					return;
				else $(this).data({ 'loaded' : true });
				
				var active = $(this).data('tab-active')!==undefined?($(this).data('tab-active')-1):0;
				
				$( this ).find('>div.or_accordion_section>h3.or_accordion_header>a').off('click').on('click',function( e ){

					var wrp = $(this).closest('.or_accordion_wrapper'),
						section = $(this).closest('.or_accordion_section'),
						allowopenall = (true === wrp.data('allowopenall')) ? true : false,
						changed = section.find('>h3.or_accordion_header').hasClass('ui-state-active');

					if( allowopenall === false ){

						wrp.find( '>.or_accordion_section>.or_accordion_content' ).slideUp();

						wrp.find('>h3.or_accordion_header').removeClass('ui-state-active');

						section.find('>.or_accordion_content').stop().slideDown( 'normal', function(){ $(this).css({height:''}) } );
						section.find('>h3.or_accordion_header').addClass('ui-state-active');

					}else{

						if( section.find('>h3.or_accordion_header').hasClass('ui-state-active') ){
							section.find('>.or_accordion_content').stop().slideUp();
							section.find('>h3.or_accordion_header').removeClass('ui-state-active');
						}else{
							section.find('>.or_accordion_content').stop().slideDown( 'normal', function(){ $(this).css({height:''}) } );
							section.find('>h3.or_accordion_header').addClass('ui-state-active');
						}

					}
					
					if( changed != section.find('>h3.or_accordion_header').hasClass('ui-state-active') )
						or_front.refresh( section.find('>.or_accordion_content') );
					
					e.preventDefault();
					
					var index = $(this).closest('.or_accordion_section');
						index = index.parent().find('>.or_accordion_section').index( index.get(0) );
						
					$(this).closest('.or_accordion_wrapper').data({'tab-active':(index+1)});
					
				}).eq(active).trigger('click');

			});
		},

		tabs: function( wrp ){

			$('.or_tabs > .or_wrapper').each( function( index ){
				
				if( $(this).data('loaded') === true )
					return;
				else $(this).data({ 'loaded' : true });
				
				var $_this = $(this),
					tab_group = $_this.parent('.or_tabs.group'),
					tab_event = ('yes' === tab_group.data('open-on-mouseover')) ? 'mouseover' : 'click',
					effect_option = ('yes' === tab_group.data('effect-option')) ? true : false,
					active_section = parseInt( tab_group.data('tab-active') )-1;

					$( this ).find('>.ui-tabs-nav>li')
						.off('click')
						.on( 'click', function(e){
							e.preventDefault();
						} )
						.off( tab_event )
						.on( tab_event, function(e){
		
							if( $(this).hasClass('ui-tabs-active') ){
								e.preventDefault();
								return;
							}
		
							var labels = $(this).closest('.or_tabs_nav,.ui-tabs-nav').find('>li'),
								index = labels.index( this ),
								tab_list = $(this).closest('.or_wrapper').find('>.or_tab'),
								new_panel = tab_list.eq( index );
		
							labels.removeClass('ui-tabs-active');
							$(this).addClass('ui-tabs-active');
		
							tab_list.removeClass('ui-tabs-body-active');
							new_panel.addClass('ui-tabs-body-active');
		
							if( effect_option === true)
								new_panel.css({'opacity':0}).animate({opacity:1});
		
							e.preventDefault();
							
							$(this).closest('.or_tabs').data({'tab-active':(index+1)});
		
						}).eq( active_section ).trigger( tab_event );

			});
			
			$('.or_tabs.or-tabs-slider .or-tabs-slider-nav li').each(function( index ){
				
				if( $(this).data('loaded') === true )
					return;
				else $(this).data({ 'loaded' : true });
				
				$( this ).on( 'click', index, function( e ){
					$(this).parent().find('.or-title-active').removeClass('or-title-active');
					$(this).addClass('or-title-active');
					$(this).closest('.or-tabs-slider').find('.owl-carousel').trigger('owl.goTo', e.data);
					e.preventDefault();
					$(this).closest('.or_tabs').data({'active':e.data});
				});
				if( index === 0 )
					$( this ).addClass('or-title-active');
			});

			or_front.owl_slider();

		},

		youtube_row_background: {

			init: function(){

				$( '.or_row' ).each( function () {
					var $row = $( this ),
						youtubeUrl,
						youtubeId;

					if ( $row.data( 'or-video-bg' ) ) {
						youtubeUrl = $row.data( 'or-video-bg' );
						youtubeId = or_front.youtube_row_background.getID( youtubeUrl );

						if ( youtubeId ) {
							$row.find( '.or_wrap-video-bg' ).remove();
							or_front.youtube_row_background.add( $row, youtubeId );
						}

					} else {
						$row.find( '.or_wrap-video-bg' ).remove();
					}
				} );
			},

			getID: function ( url ) {
				if ( 'undefined' === typeof(url) ) {
					return false;
				}

				var id = url.match( /(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/ );
				if ( null !== id ) {
					return id[ 1 ];
				}

				return false;
			},

			add: function( $obj, youtubeId, counter ) {

				if( YT === undefined )
					return;

				if ( 'undefined' === typeof( YT.Player ) ) {

					counter = 'undefined' === typeof( counter ) ? 0 : counter;
					if ( counter > 100 ) {
						console.warn( 'Too many attempts to load YouTube api' );
						return;
					}

					setTimeout( function () {
						or_front.youtube_row_background.add( $obj, youtubeId, counter++ );
					}, 100 );

					return;
				}

				var player,
					$container = $obj.prepend( '<div class="or_wrap-video-bg"><div class="ifr_inner"></div></div>' ).find( '.ifr_inner' );

				player = new YT.Player( $container[0], {
					width: '100%',
					height: '100%',
					videoId: youtubeId,
					playerVars: {
						playlist: youtubeId,
						iv_load_policy: 3,
						enablejsapi: 1,
						disablekb: 1,
						autoplay: 1,
						controls: 0,
						showinfo: 0,
						rel: 0,
						loop: 1
					},
					events: {
						onReady: function ( e ) {
							e.target.mute().setLoop( true );
						}
					}
				} );

				or_front.youtube_row_background.resize( $obj );

				$( window ).on( 'resize', function () {
					or_front.youtube_row_background.resize( $obj );
				} );
			},

			resize: function( $obj ) {

				var ratio = 1.77, ifr_w, ifr_h,
					marginLeft, marginTop,
					inner_width = $obj.innerWidth(),
					inner_height = $obj.innerHeight();

				if ( ( inner_width / inner_height ) < ratio ) {
					ifr_w = inner_height * ratio;
					ifr_h = inner_height;
				} else {
					ifr_w = inner_width;
					ifr_h = inner_width * (1 / ratio);
				}

				marginLeft = - Math.round( ( ifr_w - inner_width ) / 2 ) + 'px';
				marginTop = - Math.round( ( ifr_h - inner_height ) / 2 ) + 'px';

				ifr_w += 'px';
				ifr_h += 'px';

				$obj.find( '.or_wrap-video-bg iframe' ).css( {
					maxWidth: '1000%',
					marginLeft: marginLeft,
					marginTop: marginTop,
					width: ifr_w,
					height: ifr_h
				} );
			}

		},

		image_gallery : {

			slider: function( wrp ){
				/*
				 * OWL slider
				 * For each item OWL slider
				 */
				$( '.or-owlslider' ).each( function( index ){
					
					if( $(this).data('loaded') === true )
						return;
					else $(this).data({ 'loaded' : true });
					
					var slider_options =  $( this ).data('slide_options'),
						_autoplay 	= ( 'yes' === slider_options.auto_rotate ) ? true : false,
						_navigation = ( 'yes' === slider_options.navigation ) ? true : false,
						_pagination = ( 'yes' === slider_options.pagination ) ? true : false;

					$( this ).owlCarousel({

						autoPlay		: _autoplay,
						navigation 		: _navigation, // Show next and prev buttons
						pagination		: _pagination,
						slideSpeed 		: 300,
						paginationSpeed : 400,
						singleItem		:true,
						autoHeight		: true,
						items 			: 1

					});

				});
			},

			masonry : function( wrp ){
				
				if( wrp === undefined )
					wrp = or_front.body;
				
				wrp.find('.or_image_gallery').each(function(){
					var $container = $( this );

					if(( 'yes' === $( this ).data('image_masonry')) ){
						$container.imagesLoaded( function(){
							$container.masonry({
						    	itemSelector : '.item-grid'
							});
						});
					}

				});
				
				if( typeof( $.prettyPhoto ) == 'object' ){
					$("a[rel^='prettyPhoto']").prettyPhoto({
						social_tools: false
					});
				}
				
			},

			masonry_refresh : function( el ){

				el.find('.or_image_gallery').each(function(){

					var $container = $( this );
					var load = $container.data('load');

					if(true !== load){
						if(( 'yes' === $( this ).data('image_masonry')) ){
							$container.imagesLoaded( function(){
								$container.masonry({
							    	itemSelector : '.item-grid'
								});
							});
						}

						$container.attr('data-load', true);
					}

				});
				
				if( typeof( $.prettyPhoto ) == 'object' ){
					$("a[rel^='prettyPhoto']").prettyPhoto({
						social_tools: false
					});
				}
			
			},
			
			lightbox:function(){
				$('.or-image-link').click(function(){
					$(this).find("a[rel^='prettyPhoto']").prettyPhoto();
				});
				

				//$(".gallery.slideshow a[rel^='prettyPhoto']").prettyPhoto({slideshow:5000, autoplay_slideshow:true}); });
			},

		},

		carousel_images : function( wrp ){
			/*
			 * Carousel images
			 * For each item Carousel images
			 */

			$( '.or-carousel-images' ).each( function( index ){
				
				if( $(this).data('loaded') === true )
					return;
				else $(this).data({ 'loaded' : true });
				
				var options 		= $( this ).data('owl-options'),
					_auto_play 		= ( 'yes' === options.auto_play ) ? true : false,
					_navigation 	= ( 'yes' === options.navigation ) ? true : false,
					_pagination 	= ( 'yes' === options.pagination ) ? true : false,
					_speed 			= options.speed,
					_items 			= options.items,
					_auto_height 	= ( 'yes' === options.auto_height ) ? true : false,
					_progress_bar 	= ( 'yes' === options.progress_bar ) ? true : false,
					_show_thumb 	= ( 'yes' === options.show_thumb ) ? true : false,
					_singleItem 	= false;

				if(_auto_play) _auto_play = parseInt( _speed ) * 1000;

				var progressBar = function(){};
				var moved = function(){};
				var pauseOnDragging = function(){};

				if( true === _auto_height || true === _progress_bar || true === _show_thumb )
					_singleItem = true;

				if( true === _progress_bar )
				{
					var time = parseInt( _speed ); // time in seconds

					var $progressBar,
						$bar,
						$elem,
						isPause,
						tick,
						percentTime;


					progressBar = function( elem ){
						$elem = elem;
						//build progress bar elements
						buildProgressBar();
						//start counting
						start();
					};

					var buildProgressBar =  function(){

						$progressBar = $("<div>",{
							class:"progressBar"
						});

						$bar = $("<div>",{
							class:"bar"
						});

						$progressBar.append($bar).prependTo($elem);

					};

					var start = function() {
						//reset timer
						percentTime = 0;
						isPause = false;
						//run interval every 0.01 second
						tick = setInterval(interval, 10);
					};


					var interval = function() {
						if(isPause === false){
							percentTime += 1 / time;

							$bar.css({
							   width: percentTime+"%"
							});
							//if percentTime is equal or greater than 100

							if(percentTime >= 100){
							  	//slide to next item
							  	$elem.trigger('owl.next');
							}
						}
					};

					pauseOnDragging = function (){
						isPause = true;
					};

					moved =    function(){
						//clear interval
						clearTimeout(tick);
						//start again
						start();
					};
				}

				if( true !== _show_thumb)
				{
					$( this ).owlCarousel({

						autoPlay		: _auto_play,
						navigation 		: _navigation,
						pagination 		: _pagination,
						slideSpeed 		: 300,
						paginationSpeed : 400,
						singleItem		: _singleItem,
						autoHeight		: _auto_height,
						items 			: _items,
						afterInit 		: progressBar,
						afterMove 		: moved,
						lazyLoad : true,
						startDragging 	: pauseOnDragging

					});
				}
				else
				{
					var sync1 = $( this );
					var sync2 = sync1.next('.or-sync2');

					var syncPosition =  function(el){
						var current = this.currentItem;

						$(sync2)
							.find(".owl-item")
							.removeClass("synced")
							.eq(current)
							.addClass("synced");

						if($(sync2).data("owlCarousel") !== undefined)
						{
							center(current);
						}
					};

					sync2.on("click", ".owl-item", function(e){
						e.preventDefault();

						var number = $(this).data("owlItem");
						sync1.trigger("owl.goTo",number);
					});

					var center =  function(number){
						var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
						var num = number;
						var found = false;

						for(var i in sync2visible){
							if(num === sync2visible[i])
							{
								found = true;
							}
						}

						if(found===false){
							if( num> sync2visible[sync2visible.length-1] )
							{
								sync2.trigger("owl.goTo", num - sync2visible.length+2);
							}else
							{
								if(num - 1 === -1){
									num = 0;
								}

								sync2.trigger("owl.goTo", num);
							}
						}
						else if(num === sync2visible[sync2visible.length-1])
						{
							sync2.trigger("owl.goTo", sync2visible[1]);
						}
						else if(num === sync2visible[0])
						{
							sync2.trigger("owl.goTo", num-1);
						}

					};

					sync1.owlCarousel({
						autoPlay				: _auto_play,
						singleItem 				: true,
						lazyLoad : true,
						slideSpeed 				: 1000,
						navigation				: _navigation,
						pagination				: _pagination,
						afterAction 			: syncPosition,
						responsiveRefreshRate 	: 200,
						autoHeight				: _auto_height,
						afterInit 				: progressBar,
						afterMove 				: moved,
						startDragging 			: pauseOnDragging
					});

					sync2.owlCarousel({
						items 				: 10,
						lazyLoad : true,
						itemsDesktop      	: [1199, 8],
						itemsDesktopSmall   : [979, 6],
						itemsTablet       	: [768, 4],
						itemsMobile       	: [479, 2],
						pagination			: _pagination,
						responsiveRefreshRate : 100,
						afterInit : function(el){
							el.find(".owl-item").eq(0).addClass("synced");
						}
					});
				}

			});
			
			if( typeof( $.prettyPhoto ) == 'object' ){
				$("a[rel^='prettyPhoto']").prettyPhoto({
					social_tools: false
				});
			}

		},

		carousel_post : function( wrp ){
				
			or_front.owl_slider( '.or-owl-post-carousel' );
		
		},

		countdown_timer : function(){

			$( '.or-countdown-timer' ).each( function( index ){
				var countdown_data = $( this ).data('countdown');
				
				$(this).countdown(countdown_data.date, function(event) {
			    	$(this).html(event.strftime(countdown_data.template));
					if(event.offset.days == 0){
						console.log($(this).find('.days').html());
						$(this).find('.days').parent().css({'display':'none'});
					}
			    });

			});
		},

		piechar : {

			init: function(){

				$('.or_piechart').each(function(index){

					$( this ).viewportChecker({

						callbackFunction: function( elm ){

							or_front.piechar.load( elm );

						},

						classToAdd: 'or-pc-loaded'

					});

				});
			},

			load : function( el ){
				
				if( el.parent('div').width() < 10 )
					return 0;
					
				var _size 		= el.data( 'size' ),
					_linecap 	= ( 'yes' === el.data( 'linecap' )) ? 'round' : 'square',
					_barColor 	= el.data( 'barcolor' ),
					_trackColor = el.data( 'trackcolor' ),
					_autowidth 	= el.data( 'autowidth' ),
					_linewidth 	= el.data( 'linewidth' );

				if('yes' === _autowidth){
					_size = el.parent('div').width();
					el.data( 'size', _size );
					el.find('.percent').css({ 'line-height' : _size + 'px' });
				}

				//Fix percent middle
				var percent_width = el.find('.percent').width() + el.find('.percent:after').width();
				var percent_height = el.find('.percent').height();

				el.easyPieChart({

					barColor: _barColor,
					trackColor: _trackColor,
					lineCap: _linecap,
					easing: 'easeOutBounce',

					onStep: function(from, to, percent) {

						$(this.el).find('.percent').text(Math.round(percent));
						$(this.el).find('.percent').show();
						$( this.el ).css({'width': _size, 'height': _size});

					},

					scaleLength: 0,
					lineWidth: _linewidth,
					size: _size,

				});

			},

			update: function( el ){

				$('.or_piechart').each( function(){
					
					if( $(this).data('loaded') === true )
						return;
					else $(this).data({ 'loaded' : true });
				
					or_front.piechar.load( $( this ) );

				});

			}

		},

		progress_bar : {

			run: function(){

			    $('.or_progress_bars').each(function(){

			  		$( this ).viewportChecker({

						callbackFunction: function( el ){

							or_front.progress_bar.update( el );

						},
						classToAdd : 'or-pb-loaded'
					});

			    });
			},

			update: function( el ){

				$('.or-progress-bar .or-ui-progress').each(function(){	
					
					if( $(this).data('loaded') === true )
						return;
					else $(this).data({ 'loaded' : true });
					
					$( this ).css({ width: '5%' }).
							  stop().
							  animate({ 
								 		width: this.getAttribute('data-value')+'%' 
								 	},{ 
							  			duration: parseInt( this.getAttribute('data-speed') ), 
							  			easing : 'easeInOutQuart',
							  			step : function( st, tl ){
								  			if( tl.now/tl.end > 0.3 )
								  				this.getElementsByClassName('ui-label')[0].style.opacity = tl.now/tl.end;
							  			}
							  		}
							  ).find('.ui-label').css({opacity:0});
				    
				});

			}
		},

		ajax_action : function(){

			$('.or_facebook_recent_post').each(function(){
				
				if( this.getAttribute('data-cfg') === null || 
					this.getAttribute('data-cfg') === undefined || 
					this.getAttribute('data-cfg') === '' )
						return;
					
				var $_this = $( this ),
					data_send = {
						action: 'or_facebook_recent_post',
						cfg: $( this ).data( 'cfg' )
					};
				
				this.removeAttribute('data-cfg');
				
				$.ajax({
					url: or_script_data.ajax_url,
					method: 'POST',
					dataType: 'json',
					data: data_send,
					success: function( response_data ){
						$_this.find('ul').html(response_data.html).before(response_data.header_html);
					}
				});

			});

			/*
			 * instagram feed images
			 * Send data to shortcode
			 */
			$('.or_wrap_instagram').each(function(index){
				
				if( this.getAttribute('data-cfg') === null || 
					this.getAttribute('data-cfg') === undefined || 
					this.getAttribute('data-cfg') === '' )
						return;
				
				var $_this = $( this ),
					data_send = {
						action: 'or_instagrams_feed',
						cfg: $( this ).data( 'cfg' )
					};
				
				this.removeAttribute('data-cfg');
				
				$.ajax({
					url: or_script_data.ajax_url,
					method: 'POST',
					dataType: 'json',
					data: data_send,
					success: function( response_data ){
						$_this.find('ul').html(response_data.html);
					}
				});
			});

			/*
			 * Twitter feed sider
			 * For each item Twitter feed sider
			 */
			$( '.or_twitter_feed' ).each( function( index ) {
				
				if( this.getAttribute('data-cfg') === null || 
					this.getAttribute('data-cfg') === undefined || 
					this.getAttribute('data-cfg') === '' )
						return;
				
				var $_this = $( this ),
					atts_data = {
						action: 'or_twitter_timeline',
						cfg: $( this ).data( 'cfg' )
					};
				
				this.removeAttribute('data-cfg');
				 	
				var owl_option = $( this ).data( 'owl_option' );

				$.ajax({
					url: or_script_data.ajax_url,
					method: 'POST',
					dataType: 'json',
					data: atts_data,
					success: function( response_data ){
						var display_style = $_this.data( 'display_style' );

						$_this.find('.result_twitter_feed').html( response_data.html );

						$_this.find('.result_twitter_feed').before('<div class="button_follow_wrap">'+response_data.header_data+'</div>');

						var _navigation = ( 'yes' === owl_option.show_navigation )? true : false,
							_pagination = ( 'yes' === owl_option.show_pagination )? true : false,
							_autoHeight = ( 'yes' === owl_option.auto_height )? true : false;

						if( 2 === display_style ){
							$_this.find('.or-tweet-owl').owlCarousel({
								navigation 		: _navigation,
								pagination 		: _pagination,
								slideSpeed 		: 300,
								paginationSpeed : 400,
								singleItem		: true,
								items 			: 1,
								autoHeight		: _autoHeight
							});
						}
					}
				});

			});
		},
		
		owl_slider : function(){
				
			$('[data-owl-options]').each( function( index ){
				
				var options = $( this ).data('owl-options');
				
				if( typeof options !== 'object' )
					return;
					
				if( $(this).data('loaded') === true )
					return;
				else $(this).data({ 'loaded' : true });
					
				$( this ).attr({'data-owl-options':null});
				var	_auto_play 			= ( 'yes' === options.autoplay ) ? true : false,
					_navigation 		= ( 'yes' === options.navigation ) ? true : false,
					_pagination 		= ( 'yes' === options.pagination ) ? true : false,
					_speed 				= options.speed ? options.speed : 450,
					_items 				= (options.items!==undefined)?options.items:1,
					_tablet 			= (options.tablet!==undefined)?options.tablet:1,
					_mobile 				= (options.mobile!==undefined)?options.mobile:1,
					_auto_height 		= ( 'yes' === options.autoheight ) ? true : false,
					_transition 		= ( '' != options.transition ) ? options.transition : '',
					_singleItem 		= false;
				
				if(_auto_height === true){
					_singleItem = true;
					_items = 1;
				}
				//console.log(options);
				$( this ).owlCarousel({
					autoPlay		: _auto_play,
					navigation 		: _navigation,
					pagination 		: _pagination,
					slideSpeed 		: parseInt(_speed),
					paginationSpeed : parseInt(_speed),
					singleItem		: _singleItem,
					autoHeight		: _auto_height,
					items 			: parseInt(_items),
					itemsCustom 	: false,
					itemsDesktop 	: [1199,_items],
					itemsDesktopSmall : [980,_tablet],
					itemsTablet: [640,_mobile],
					itemsTabletSmall: false,
					itemsMobile : [480,_mobile],
					transitionStyle : _transition,
				});

			});
			
			if( typeof $.prettyPhoto == 'function' ){
				$("a[rel^='prettyPhoto']").prettyPhoto({
					social_tools: false
				});
			}
	
		},
		
		or_end : {}

	};
		
}(jQuery));

jQuery( document ).ready(function($){ or_front.init($); });
/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;

		//get the starting position of each element to have parallax applied to it
		$this.each(function(){
		    firstTop = $this.offset().top;
		});

		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}

		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;

		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = $window.scrollTop();

			$this.each(function(){
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);

				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}

				$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
			});
		}

		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);

effect_set = Array();
stat = new Array();
function or_animateDiv( targetID, the_class, ad ){
	if(typeof targetID==="object") {id = targetID.id; }
	else { id = targetID;}
	stat = id.split('_');
	
   setTimeout(function() {
        window.effect_set[stat[2]] = 0;
   }, ad);
   if(window.effect_set[stat[2]]==0 || typeof window.effect_set[stat[2]] == "undefined"){
      window.effect_set[stat[2]] = 1;
      current_class = jQuery( targetID ).attr('class');
      if( typeof current_class!='undefined' && current_class.indexOf(the_class) != -1 ){
          new_class = current_class.replace( the_class, '' );
          jQuery( targetID ).attr( 'class', new_class );
          setTimeout(function() {
              jQuery( targetID ).addClass(the_class);
          }, 5);
      }else jQuery( targetID ).addClass(the_class);
   }
}

or_wow = new WOW({
	  boxClass:     'wow',      // default
	  offset:       0,          // default
	  mobile:       true,       // default
	  live:         true        // default
});
or_wow.init();