<?php
/**
*
*	or ajax front end
*	(c) originbuilder.com
*
*/

if(!defined('or_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

class or_ajax_front{

	public function __construct(){

		$ajax_events = array(
			'instagrams_feed' 		=> true,
			'twitter_timeline' 		=> true,
			'facebook_recent_post' 	=> true
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {

			add_action( 'wp_ajax_or_' . $ajax_event, array( &$this, esc_attr( $ajax_event ) ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_or_' . $ajax_event, array( &$this, esc_attr( $ajax_event ) ) );
			}
		}
	}

	function facebook_recent_post(){

		$output = $header_html = $fb_cover = '';

		if( !isset( $_POST['cfg'] ) || empty( $_POST['cfg'] ) ){

			wp_send_json( array(
				'html' => '',
				'header_data' => '',
				'message' => __('Fail', 'originbuilder')
			));
			
			exit;
				
		}

		$atts = (array) json_decode( base64_decode( $_POST['cfg'] ) );
		
		$fb_app_id = $fb_page_id = $fb_app_secret = $number_post_show = '';
		
		extract( $atts );

		$fb_input_data = array(
			'fb_page_id' => $fb_page_id,
			'fb_app_id' => $fb_app_id,
			'fb_app_secret' => $fb_app_secret,
			'number_post_show' => $number_post_show
		);

		$fb_page_info = $this->get_facebook_page_feed( $fb_input_data, true );

		if(isset($fb_page_info->id)){
			if(isset($fb_page_info->cover->source)){
				$fb_cover = 'background-image: url('. $fb_page_info->cover->source. ');';
			}

			$header_html .= '<div class="fb-header" style="'. esc_attr($fb_cover) .'">
				<div class="overlay"></div>
				<div class="fb-line-1">
					<img class="img-profile" src="https://graph.facebook.com/'. $fb_page_id .'/picture?width=200" />
					<span class="username">'. $fb_page_info->username .'</span>
					<span class="likes">'. number_format( $fb_page_info->likes ) .' likes</span>
				</div>
				<div class="fb-line-2">
					<a class="like_page" href="'. $fb_page_info->link .'" target="_blank"><i class="fa fa-facebook-square"></i> Like page</a>
					<a class="share_page" href="http://www.facebook.com/sharer/sharer.php?u='. $fb_page_info->link .'" target="_blank"><i class="fa fa-share"></i> Share</a>
				</div>
			</div>';
		}else{
			$header_html .= __('Can not get page id', 'originbuilder');
		}

		$fb_page_posts = $this->get_facebook_page_feed( $fb_input_data );
		//print_r($fb_page_posts);
		if ( isset( $open_link_new_window ) && $open_link_new_window == 'yes' ) {
			$link_target = ' target="_blank"';
		} else {
			$link_target = '';
		}

		if($fb_page_posts){
			foreach($fb_page_posts as $data => $value){

				$fb_post_id = explode('_', $value->id);
				$post_id = $fb_post_id[1];

				$output .= '<li>';

				if( isset( $show_image ) && $show_image == 'yes' ){
					$a_end = '';
					if( isset( $value->link ) ){
						$output .= '<a href="'. esc_url($value->link) .'" '. $link_target .'>';
						$a_end = '</a>';
					}

					if ( isset( $value->name ) ){
						$alt = $value->name;
					}

					if( isset( $value->full_picture ) ){
						$output .= '<img src="'. esc_url( $value->full_picture ) .'" alt="'. $alt .'">';
					}

					$output .= $a_end;

				}

				if( isset( $value->message ) ){
					// remove emoji's
					$_message = preg_replace( '/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F1E0}-\x{1F1FF}]/u', '', $value->message );
					$_message = sanitize_text_field( $_message ); // sanitize content

					if(!empty($number_of_des) && $number_of_des > 0){
						$_message = wp_trim_words( $_message, $number_of_des, $more = null );
					}

					$output .= '<div class="fb-message">'. $_message .'</div>';
				}

				if( !empty( $show_time ) || !empty( $show_like_count ) || !empty( $show_comment_count ) ){
					$output .= '<div class="fb-post-info">';
					$output .= '<a href="https://www.facebook.com/'. $fb_page_id .'/posts/'. $post_id .'" '. $link_target .'>';

					if( isset( $show_like_count ) && $show_like_count == 'yes' ){
						$output .= '<span class="fb-like"><i class="fa fa-thumbs-o-up"></i> '. ( isset( $value->likes->summary->total_count ) ? $value->likes->summary->total_count : 0) .'</span>';
					}

					if( isset( $show_comment_count ) && $show_comment_count == 'yes' ){
						$output .= '<span class="fb-comment"><i class="fa fa-comment-o"></i> '. ( isset( $value->comments->summary->total_count ) ? $value->comments->summary->total_count : 0) .'</span>';
					}

					if( isset( $show_time ) && $show_time == 'yes' ){
						$_time = strtotime( $value->created_time );
						$output .= '<span class="fb-time">'. $this->time_ago( $_time ) .'</span>';
					}

					$output .= '</a>';
					$output .= '</div>';
				}

				$output .= '</li>';
			}
		}else{
			$output .= __('Warning: Fill correct facebook infomation to show new feed.', 'originbuilder');
		}

		$data = array(
			'html' => $output,
			'header_html' => $header_html,
			'message' => __('ok', 'originbuilder')
		);

		wp_send_json( $data );
	}


	function get_facebook_page_feed( $args = array(), $only_info = false ) {

		$defaults = array(
			'fb_page_id' => 'wordpress',
			'fb_app_id' => '301439076655535',
			'fb_app_secret' => 'afddd33dc09cb364c79e8f0a46e7dff6',
			'number_post_show' => 10
		);

		$args = wp_parse_args( $args, $defaults );

		$fb_page_id 		= $args['fb_page_id'];
		$fb_app_id 			= $args['fb_app_id'];
		$fb_app_secret 		= $args['fb_app_secret'];
		$number_post_show 	= $args['number_post_show'];

		if ( isset( $fb_page_id ) && isset( $fb_app_id ) && isset( $fb_app_secret ) && isset( $number_post_show ) ) {

			$facebook_page_info_url = 'https://graph.facebook.com/'. $fb_page_id .'/?access_token='. $fb_app_id .'|'. $fb_app_secret;

			$facebook_api_url = 'https://graph.facebook.com/' . $fb_page_id . '/posts?&access_token=' . $fb_app_id . '|' . $fb_app_secret . '&fields=id,picture,full_picture,actions,type,from,message,status_type,object_id,name,caption,description,link,created_time,comments.limit(1).summary(true),likes.limit(1).summary(true)&limit=' . $number_post_show;

			if($only_info == true){
				$result_data = json_decode( $this->file_get_contents( $facebook_page_info_url ) );
			}else{
				$facebook_data = json_decode( $this->file_get_contents( $facebook_api_url ) );
				if( isset( $facebook_data ) && isset( $facebook_data->data ) )
					$result_data = $facebook_data->data;
			}

			if ( isset( $result_data ) ) {
				return $result_data;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}


	function instagrams_feed(){

		$html = '';
		$count = 1;

		if( !isset( $_POST['cfg'] ) || empty( $_POST['cfg'] ) ){

			wp_send_json( array(
				'html' => '',
				'header_data' => '',
				'message' => __('Fail', 'originbuilder')
			));
			
			exit;
				
		}

		$atts = (array) json_decode( base64_decode( $_POST['cfg'] ) );
		
		$access_token = $username = '';
		extract( $atts );
		
		
		$ins_feed_data = $this->get_instagrams_feed( $username, $access_token );

		if($ins_feed_data)
		{
			foreach ( $ins_feed_data as $key => $value )
			{
				switch ($count%$columns_style) {
					case '1':
						$li_class = 'el-start';
						break;
					case '0':
						$li_class = 'el-end';
						break;
					default:
						$li_class = '';
						break;
				}

				$html 	.= '<li class="'. esc_attr($li_class) .' loaded">'
						.'<a href="'. esc_url( $value->link ) .'" target="_blank">'
						.'<img src="'. esc_url( $value->images->$image_size->url ) .'" />'
						.'</a></li>';

				if($count >= $number_show){
					break;
				}

				$count++;
			}
		}else{
			$html .= __('Warning: Fill correct instagram infomation to show new feed.', 'originbuilder');
		}

		$data = array(
			'html' => $html,
			'message' => __('ok', 'originbuilder')
		);

		wp_send_json( $data );
	}

	/*
	 * twitter_timeline
	 * Add this function to wp_ajax_or_twitter_timeline hook
	 * Get new tweets update from user
	 */
	function twitter_timeline() {

		if( !isset( $_POST['cfg'] ) || empty( $_POST['cfg'] ) ){

			wp_send_json( array(
				'html' => '',
				'header_data' => '',
				'message' => __('Fail', 'originbuilder')
			));
			
			exit;
				
		}

		$atts = (array) json_decode( base64_decode( $_POST['cfg'] ) );

		extract( $atts );

		$output = $css_class = $rand_class = '';
		$display_style = (!empty($display_style)) ? $display_style : 1;
		$twitter_feed_data = array();

		$consumer_key = !empty($consumer_key) ? $consumer_key : 'tHWsp0yQQioooQZJfXJdGP3d4';
		$consumer_secret = !empty($consumer_secret) ? $consumer_secret : 'bl1kN9xH6nf167d0SJXnv9V5ZXuGXSShr5CeimLXaIGcUEQnsp';
		$access_token = !empty($access_token) ? $access_token : '120290116-vmLx4sPp5O3hjhRxjpl28i0APJkCpg04YVsoZyb7';
		$access_token_secrect = !empty($access_token_secrect) ? $access_token_secrect : 'B9mAhgZhQG0cspt1doF2cxDky40OEatjftRI5NCmQh1pE';

		$number_tweet = (!empty( $number_tweet )) ? $number_tweet : 5;

		switch ($display_style) {
			case '1':
				$el_in_start = '<ul>';
				$el_in_end = '</ul>';
				$el_item_start = '<li>';
				$el_item_end = '</li>';
				break;

			case '2':
				$el_in_start = '<div class="or-tweet-owl owl-carousel owl-theme">';
				$el_in_end = '</div>';
				$el_item_start = '<div class="item">';
				$el_item_end = '</div>';
				break;

			default:
				# code...
				break;
		}

		if (
			isset( $username )
			&& isset( $consumer_key )
			&& isset( $consumer_secret )
			&& isset( $access_token )
			&& isset( $access_token_secrect )
			&& isset( $number_tweet )
		){
			$twitter_feed_data = $this->get_tweets_feed_data(
				$consumer_key,
				$consumer_secret,
				$access_token,
				$access_token_secrect,
				$number_tweet,
				$username
			);

			$header_data = '';

			if( isset( $show_follow_button ) && $show_follow_button == 'yes' && $display_style == 1  ){
				$header_data .= '<div class="tweet_user user_twitter">
				<img src="https://twitter.com/' . esc_attr( $username ) . '/profile_image?size=normal" class="twitter_profile_avatar"/>
				<a class="or_twitter_follow" href="https://twitter.com/intent/user?screen_name='. esc_attr( $username ) .'" target="_blank"><i class="fa fa-twitter"></i>Follow Us</a>
				<span class="screen_name">@'. esc_html( $username ). '</span>
				</div>';
			}

			if(isset($twitter_feed_data)){
				$output .= $el_in_start;

				foreach($twitter_feed_data as $tweet){
					if( empty( $tweet['text'] ) )
						continue;
					$latestTweet = $tweet['text'];
					//Convert plain text URLs into HTML hyperlinks
					$latestTweet = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $latestTweet);

					//Convert @username twiter to link clickable
					$latestTweet = preg_replace('/(^|\s)@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$2" target="_blank">@$2</a>&nbsp;', $latestTweet);

					//Automatically create email link from a static text
					$latestTweet = preg_replace('/(\S+@\S+\.\S+)/', '&nbsp;<a href="mailto:$1">$1</a>&nbsp;', $latestTweet);

					$twitterTime = strtotime( $tweet['created_at'] );
					$timeAgo 	 = $this->time_ago( $twitterTime );

					$output .= $el_item_start;
						if(!empty( $latestTweet )){
							$avatar = '';
							$has_avatar = '';
							if ( isset( $show_avatar ) && $show_avatar == 'yes' ){
								//$avatar = '<span class="or_tweet_icon"><i class="fa fa-twitter"></i></span>';
								if(isset($tweet['user']['profile_image_url'])){
									$avatar = '<span class="user_twitter"><img src="'. esc_url($tweet['user']['profile_image_url']) .'" /></span>';
									$has_avatar = ' show_avatar';
								}

							}
							if($display_style == 1){
								$output .= '<div class="tweet_desc' . $has_avatar . '">'. $avatar. '
								<span class="name">'. esc_html($tweet['user']['name']) .'</span>
								<span class="screen_name">@'. esc_html($tweet['user']['screen_name']) .'</span>
								<span class="description">' . $latestTweet . '</span></div>';
							}else {
								$output .= '<div class="tweet_desc">
								<span class="description">' . $latestTweet . '</span></div>';
							}


						}

						$output .= '<div class="twitter-footer' . $has_avatar . '">';

						if( isset( $show_time ) && $show_time == 'yes' ){
							$output .= '<span class="tweet_date">'. $timeAgo .'</span>';
						}

						if( isset( $show_reply ) && $show_reply == 'yes' ){
							$output .= '<span class="tweet_reply"><a href="https://twitter.com/intent/tweet?in_reply_to='. esc_attr( $tweet['id_str'] ) .'" title="Reply"><i class="fa fa-reply"></i></a></span>';
						}

						if( isset( $show_retweet ) && $show_retweet == 'yes' ){
							$output .= '<span class="tweet_retweet"><a href="https://twitter.com/intent/retweet?tweet_id='. esc_attr( $tweet['id_str'] ) .'" title="Retweet"><i class="fa fa-retweet"></i></a></span>';
						}

						$output .= '</div>';

					$output .= $el_item_end;
				}

				$output .= $el_in_end;
				if( isset( $show_follow_button ) && $show_follow_button == 'yes' && $display_style == 2  ){
					$output .= '<div class="tweet_user user_twitter">
					<a class="or_twitter_follow" href="https://twitter.com/intent/user?screen_name='. esc_attr( $username ) .'" target="_blank"><i class="fa fa-twitter"></i>Follow Us</a>
					</div>';
				}
			}

		}

		$data = array(
			'html' => $output,
			'header_data' => $header_data,
			'message' => __('Ok', 'originbuilder')
		);

		wp_send_json( $data );
	}


	/*
	 * get_tweets_feed_data
	 * @ $consumer_key
	 * @ $consumer_secret
	 * @ $access_token
	 * @ $access_token_secret
	 * @ $number_tweet
	 * @ $username
	 * Get new tweets update from user
	 */
	function get_tweets_feed_data( $consumer_key, $consumer_secret, $access_token, $access_token_secret, $number_tweet, $username ) {
		$rd_twitter = or_random_string( 20 );
		$trans_name = 'list_tweets_'.$rd_twitter;
		$twitter_cache_time = 10;

		if(false === ($twitter_twitter_data = get_transient($trans_name))) {

			$twitter_token = get_option('cfTwitterToken_'.$rd_twitter);

			// get a new token anyways
			delete_option('cfTwitterToken_'.$rd_twitter);

			// getting new auth bearer only if we don't have one
			if(!$twitter_token) {
				// preparing credentials
				$twitter_credentials = $consumer_key . ':' . $consumer_secret;
				$twitter_to_send = base64_encode( $twitter_credentials );

				// http post arguments
				$twitter_args = array(
					'method' => 'POST',
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => 'Basic ' . $twitter_to_send,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);

				add_filter('https_ssl_verify', '__return_false');
				$twitter_response = wp_remote_post('https://api.twitter.com/oauth2/token', $twitter_args);

				$twitter_keys = json_decode(wp_remote_retrieve_body($twitter_response));

				if($twitter_keys) {
					// saving token to wp_options table
					update_option('cfTwitterToken_'.$rd_twitter, $twitter_keys->access_token);
					$twitter_token = $twitter_keys->access_token;
				}
			}

			// we have bearer token wether we obtained it from API or from options
			$twitter_args = array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => "Bearer ".$twitter_token
				)
			);

			add_filter('https_ssl_verify', '__return_false');
			$twitter_api_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$username.'&count='.$number_tweet;
			$twitter_response = wp_remote_get($twitter_api_url, $twitter_args);

			set_transient($trans_name, wp_remote_retrieve_body($twitter_response), 60 * $twitter_cache_time);
		}
		@$twitter_feed_data = json_decode(get_transient($trans_name), true);

		return $twitter_feed_data;
	}

	function time_ago($time) {
		$periods = array(
			__( 'second', 'originbuilder' ),
			__( 'minute', 'originbuilder' ),
			__( 'hour', 'originbuilder' ),
			__( 'day', 'originbuilder' ),
			__( 'week', 'originbuilder' ),
			__( 'month', 'originbuilder' ),
			__( 'year', 'originbuilder' ),
			__( 'decade', 'originbuilder' )
		);

		$periods_plural = array(
			__( 'seconds', 'originbuilder' ),
			__( 'minutes', 'originbuilder' ),
			__( 'hours', 'originbuilder' ),
			__( 'days', 'originbuilder' ),
			__( 'weeks', 'originbuilder' ),
			__( 'months', 'originbuilder' ),
			__( 'years', 'originbuilder' ),
			__( 'decades', 'originbuilder' )
		);

		$lengths = array( '60', '60', '24', '7', '4.35', '12', '10' );
		$now = time();
		$difference = $now - $time;
		$tense = __( 'ago', 'originbuilder' );

		for( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths )-1; $j++ ) {
			$difference /= $lengths[$j];
		}

		$difference = round( $difference );

		if( $difference != 1 ) {
			$periods[$j] = $periods_plural[$j];
		}

		return sprintf('%s %s %s', $difference, $periods[$j], $tense);
	}

	function get_instagrams_feed( $username, $access_token ) {
		$ins_user_id = $this->get_instagram_user_id( $username, $access_token );

		if ($ins_user_id) {
			$ins_api_url = 'https://api.instagram.com/v1/users/' . $ins_user_id . '/media/recent?access_token=' . $access_token;

			$ins_ch = curl_init();
			curl_setopt($ins_ch, CURLOPT_URL, $ins_api_url);
			curl_setopt($ins_ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ins_ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ins_ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ins_ch, CURLOPT_SSL_VERIFYHOST, false);
			$ins_data = curl_exec($ins_ch);
			curl_close($ins_ch);

			$ins_data = json_decode($ins_data);

			return $ins_data->data;
		} else {
			return 0;
		}
	}

	function get_instagram_user_id( $username, $access_token ) {
		$ins_url = 'https://api.instagram.com/v1/users/self/?access_token=' . $access_token;

		$ins_ch = curl_init();
		curl_setopt($ins_ch, CURLOPT_URL, $ins_url);
		curl_setopt($ins_ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ins_ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ins_ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ins_ch, CURLOPT_SSL_VERIFYHOST, false);
		$ins_json_data = curl_exec($ins_ch);
		curl_close($ins_ch);

		$ins_json_data = json_decode($ins_json_data);

		if (isset($ins_json_data->data->username) && ($ins_json_data->data->username == $username)) {
			return $ins_json_data->data->id;
		} else {
			return 0;
		}
	}


	function file_get_contents( $url ){
		$url_ch = curl_init();
		curl_setopt( $url_ch, CURLOPT_URL, $url );
		curl_setopt( $url_ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $url_ch, CURLOPT_TIMEOUT, 20 );
		curl_setopt( $url_ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $url_ch, CURLOPT_SSL_VERIFYHOST, false );
		$_return = curl_exec( $url_ch );
		curl_close( $url_ch );

		return $_return;
	}

}

#Start or_ajax_front
new or_ajax_front();
