/***
 * Video play JS
 *  
 ***/

var or_video_play = ( function($){
	return {
		init: function(){
			$( '.or_video_wrapper' ).each( function () {
				if( or_video_play.youtube.url_valid( $(this).data('video') ) )
				{
					or_video_play.youtube.add( $( this ) );
				}
				else
				{
					if( or_video_play.vimeo.getID( $(this).data('video') ) )
					{
						or_video_play.vimeo.add( $( this ) );
					}
				}

			});
		},

		youtube: {
			url_valid : function( url )
			{
				if( url === undefined )
					return false;
					
				var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
				return (url.match(p)) ? RegExp.$1 : false;
			},

			getID: function ( url )
			{
				if ( 'undefined' === typeof(url) ) {
					return false;
				}

				var id = url.match( /(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/ );
				if ( null !== id ) {
					return id[ 1 ];
				}

				return false;
			},

			add: function( $obj, counter ) {

				var youtubeUrl,
					youtubeId,
					autoplay = ('yes' === $obj.data('autoplay')) ? 1: 0,
					_vd_width = $obj.data('width'),
					_vd_height = $obj.data('height');

				if('yes' === $obj.data('fullwidth')){
					_vd_width = '100%';
				}

				youtubeUrl = $obj.data( 'video' );
				youtubeId = or_video_play.youtube.getID( youtubeUrl );

				if( YT === undefined )
					return;

				if ( 'undefined' === typeof( YT.Player ) ) {

					counter = 'undefined' === typeof( counter ) ? 0 : counter;
					if ( counter > 100 ) {
						console.warn( 'Too many attempts to load YouTube api' );
						return;
					}

					setTimeout( function () {
						or_video_play.youtube.add( $obj, youtubeId, counter++ );
					}, 100 );

					return;
				}

				var player,
					ratio = 1.77,
					$container = $obj.prepend( '<div class="or-video-inner"><div class="ifr_inner"></div></div>' ).find( '.ifr_inner' );

				player = new YT.Player( $container[0], {
					width: _vd_width,
					height: _vd_height,
					videoId: youtubeId,
					playerVars: {
						playlist: youtubeId,
						iv_load_policy: 3,
						enablejsapi: 1,
						disablekb: 1,
						autoplay: autoplay,
						controls: 1,
						showinfo: 0,
						rel: 0,
						loop: 1
					},
					events: {
						onReady: function ( e ) {
							//e.target.mute().setLoop( true );
							var w = $($obj).find('.ifr_inner').width();
							$($obj).find('.ifr_inner').height( w/ratio );
						}
					}
				} );

			}
		},

		vimeo: {
			getID: function( url )
			{
				if( url === undefined )
					return false;
					
				var regExp = /http(s)?:\/\/(www\.)?vimeo.com\/(\d+)(\/)?(#.*)?/;

				var match = url.match(regExp);

				if (match)
					return match[3];
			},

			add: function( $obj ){
				var vimeoUrl,
					vimeoId,
					autoplay = ('yes' === $obj.data('autoplay')) ? 1: 0,
					_vd_width = $obj.data('width'),
					_vd_height = $obj.data('height');

				vimeoUrl = $obj.data( 'video' );
				vimeoId = or_video_play.vimeo.getID( vimeoUrl );

				if('yes' === $obj.data('fullwidth')){
					_vd_width = '100%';
				}

				var player,
					iframe,
					player_iframe,
					ratio = 1.77,
					$container = $obj.prepend( '<div class="or-video-inner"><div class="ifr_inner"></div></div>' ).find( '.ifr_inner' );

				player_iframe = '<iframe id="player_'+ vimeoId +'" src="https://player.vimeo.com/video/'+ vimeoId +'?api=1&player_id=player_'+ vimeoId +'" width="'+ _vd_width +'" height="'+ _vd_height +'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

				$($container[0]).html( player_iframe );

				iframe = $('#player_'+vimeoId)[0];
				player = $f(iframe);

				player.addEvent('ready', function() {
					if(autoplay === 1){
						player.api('play');
					}

					var w = $($obj).find('iframe').width();
					$($obj).find('iframe').height( w/ratio );
				});
			}
		},

		refresh: function( el ){
			var ratio = 1.77,
				w = el.find('.ifr_inner').width();

			el.find('.ifr_inner').height( w/ratio );
			el.find('.ifr_inner>iframe').height( w/ratio );
		}
	};

}(jQuery));

jQuery( document ).ready(function($){ or_video_play.init($); });
