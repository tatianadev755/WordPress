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

if( !function_exists('wp_list_widgets') )
	require_once(ABSPATH . '/wp-admin/includes/widgets.php');

function or_admin_enable( $force = false ){

	if( $force === true )
		return true;

	global $post, $or;

	$type = !empty( $post->post_type ) ? $post->post_type:'';
	$page = !empty( $_GET['page'] ) ? $_GET['page'] : '';

	$settings = $or->settings();
	if( !isset( $settings['content_types'] ) )
		$settings['content_types'] = array();

	$allows_types = array_merge( (array)$settings['content_types'], (array)$or->get_required_content_types() );

	if( is_admin() && ( in_array( $type, $allows_types ) || $page == 'or-sections-manager' || originbuilder::is_live() ) )
		return true;
	else return false;

}

function or_add_map( $map = array() ){

	$or = originbuilder::globe();

	if( !is_array( $map ) )
		return;
	if( empty( $map['name'] ) )
		return;

	$or->add_map( $map );

}

function or_add_param_type( $name = '', $func = '' ){

	$or = originbuilder::globe();

	if( empty( $name ) || empty( $func ) )
		return;

	$or->add_param_type( $name, $func );
	
}

function or_add_icon( $source = '' ){
	
	if( !empty( $source ) ){
		originbuilder::globe()->add_icon_source( $source );	
	}
}

function or_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) {
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

function or_validate_options( $plugin_options ){

	if( !empty( $_POST['or_options'] ) ){
		return $plugin_options;
	}

}

function or_youtube_id_from_url( $url = '' ) {

    parse_str( parse_url( $url, PHP_URL_QUERY ), $vars );
    
	return isset( $vars['v'] ) ? $vars['v'] : '';   

}

function or_loop_box( $items ){

	if( empty( $items ) )
		return '';

	$output = '';

	foreach( $items as $item ){
			
		if( is_object( $item ) && $item->tag != 'text' ){
			

			if( !isset( $item->attributes ) || !is_object( $item->attributes ) )
				$item->attributes = new stdClass();

			if( !isset( $item->attributes->class ) )
				$item->attributes->class = '';
			
			if( $item->tag == 'image' )
				$item->tag = 'img';
			if( $item->tag == 'icon' )
				$item->tag = 'i';
			if( $item->tag == 'column' ){
				$item->tag = 'div';
				$item->attributes->class .= ' '.$item->attributes->cols;
				unset( $item->attributes->cols );
			}
			
			$output .= '<'.$item->tag;
			
			if( $item->tag == 'img' ){
				if( empty( $item->attributes->src ) )
					$item->attributes->src = or_URL.'/assets/images/get_logo.png';
				
				if( $item->tag == 'img' && !isset( $item->attributes->alt ) )
					$item->attributes->alt = '';
			}
			
			foreach( $item->attributes as $k => $v ){
				if( !empty($v) )$output .= ' '.$k.'="'.trim($v).'"';
			}

			if( $item->tag == 'img' )
				$output .= '/';

			$output .= '>';

			if( is_array( $item->children ) )
				$output .= or_loop_box( $item->children );

			if( $item->tag != 'img' )
				$output .= '</'.$item->tag.'>';

		}else $output .= $item->content;

	}

	return $output;

}

function or_get_terms( $tax = 'category', $key = 'id', $type = '', $default = '' ){

	$get_terms = (array) get_terms( $tax, array( 'hide_empty' => false ) );

	if( $type != '' ){
		$get_terms = or_get_terms_by_post_type( array($tax), array($type) );
	}

	$terms = array();

	if( $default != '' ){
		$terms[] = $default;
	}

	if ( $key == 'id' ){
		foreach ( $get_terms as $term ){
			if( isset( $term->term_id ) && isset( $term->name ) ){
				$terms[$term->term_id] = $term->name;
			}
		}
	}else if ( $key == 'slug' ){
		foreach ( $get_terms as $term ){
			if( !empty($term->name) ){
				if( isset( $term->slug ) && isset( $term->name ) ){
					$terms[$term->slug] = $term->name;
				}
			}
		}
	}

	return $terms;

}

function or_filter_search( $s, &$w ) {
	
	global $wpdb;
	
	if ( empty( $s ) )return '';
	
	$q = $w->query_vars;
	
	$n = ! empty( $q['exact'] ) ? '' : '%';
	$s = $sa = '';
	
	foreach ( (array) $q['search_terms'] as $t ) {
		$t = $wpdb->esc_like( $t );
		$l = $n . $t . $n;
		$s .= $wpdb->prepare( "{$sa}($wpdb->posts.post_title LIKE %s)", $l );
		$sa = ' AND ';
	}
	
	if ( ! empty( $s ) )
		$s = " AND ({$s}) ";

	return $s;
}

function or_get_submit_button( $text = '', $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = '' ) {
	
	if ( ! is_array( $type ) )
		$type = explode( ' ', $type );

	$button_shorthand = array( 'primary', 'small', 'large' );
	$classes = array( 'button' );
	foreach ( $type as $t ) {
		if ( 'secondary' === $t || 'button-secondary' === $t )
			continue;
		$classes[] = in_array( $t, $button_shorthand ) ? 'button-' . $t : $t;
	}
	$class = implode( ' ', array_unique( $classes ) );

	if ( 'delete' === $type )
		$class = 'button-secondary delete';

	$text = $text ? $text : __( 'Save Changes' );

	// Default the id attribute to $name unless an id was specifically provided in $other_attributes
	$id = $name;
	if ( is_array( $other_attributes ) && isset( $other_attributes['id'] ) ) {
		$id = $other_attributes['id'];
		unset( $other_attributes['id'] );
	}

	$attributes = '';
	if ( is_array( $other_attributes ) ) {
		foreach ( $other_attributes as $attribute => $value ) {
			$attributes .= $attribute . '="' . esc_attr( $value ) . '" '; // Trailing space is important
		}
	} elseif ( ! empty( $other_attributes ) ) { // Attributes provided as a string
		$attributes = $other_attributes;
	}

	// Don't output empty name and id attributes.
	$name_attr = $name ? ' name="' . esc_attr( $name ) . '"' : '';
	$id_attr = $id ? ' id="' . esc_attr( $id ) . '"' : '';

	$button = '<input type="submit"' . $name_attr . $id_attr . ' class="' . esc_attr( $class );
	$button	.= '" value="' . esc_attr( $text ) . '" ' . $attributes . ' />';

	if ( $wrap ) {
		$button = '<p class="submit">' . $button . '</p>';
	}

	return $button;
}

function or_process_tab_title( $matches ){

	if( !empty( $matches[0] ) ){

		$tab_atts = shortcode_parse_atts( $matches[0] );

		$title = ''; $adv_title = '';
		if ( isset( $tab_atts['title'] ) )
			$title = $tab_atts['title'];
		
		if( isset( $tab_atts['advanced'] ) && $tab_atts['advanced'] === 'yes' ){
			
			if( isset( $tab_atts['adv_title'] ) && !empty( $tab_atts['adv_title'] ) )
				$adv_title = base64_decode( $tab_atts['adv_title'] );
				
			$icon=$icon_class=$image=$image_id=$image_url=$image_thumbnail=$image_medium=$image_large=$image_full='';
			
			if( isset( $tab_atts['adv_icon'] ) && !empty( $tab_atts['adv_icon'] ) ){
				$icon_class = $tab_atts['adv_icon'];
				$icon = '<i class="'.$tab_atts['adv_icon'].'"></i>';
			}
			
			if( isset( $tab_atts['adv_image'] ) && !empty( $tab_atts['adv_image'] ) ){
				$image_id = $tab_atts['adv_image'];
				$image_url = wp_get_attachment_image_src( $image_id, 'full' );
				$image_medium = wp_get_attachment_image_src( $image_id, 'medium' );
				$image_large = wp_get_attachment_image_src( $image_id, 'large' );
				$image_thumbnail = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				
				if( !empty( $image_url ) && isset( $image_url[0] ) ){
					$image_url = $image_url[0];
					$image_full = $image_url;
				}
				if( !empty( $image_medium ) && isset( $image_medium[0] ) )
					$image_medium = $image_medium[0];
				
				if( !empty( $image_large ) && isset( $image_large[0] ) )
					$image_large = $image_large[0];
					
				if( !empty( $image_thumbnail ) && isset( $image_thumbnail[0] ) )
					$image_thumbnail = $image_thumbnail[0];
				if( !empty( $image_url ) )
					$image = '<img src="'.$image_url.'" alt="" />';
			}
			
			$adv_title = str_replace( array( '{title}', '{icon}', '{icon_class}', '{image}', '{image_id}', '{image_url}', '{image_thumbnail}', '{image_medium}', '{image_large}', '{image_full}', '{tab_id}' ), array( $title, $icon, $icon_class, $image, $image_id, $image_url, $image_thumbnail, $image_medium, $image_large, $image_full, $tab_atts['tab_id'] ), $adv_title );
			
			echo '<li>'.$adv_title.'</li>';
				
		}else{
			if( isset( $tab_atts['icon'] ) )
				$title = '<i class="'.$tab_atts['icon'].'"></i> '.$title;
			echo '<li><a href="#'.$tab_atts['tab_id'].'">'.$title.'</a></li>';
		}

	}

	return $matches[0];

}

function or_js_callback( $callback ){
	
	$or = originbuilder::globe();
	$or->js_callback( $callback );
	
}

/*
 * Return a random string with length
 */
function or_random_string( $length = 10 ){
	$str = "";
	$allow_characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$_max_length = count($allow_characters) - 1;

	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $_max_length);
		$str .= $allow_characters[$rand];
	}

	return $str;
}
if ( ! function_exists( 'wp_editor_fontsize_filter_plugin' ) ) {
function wp_editor_fontsize_filter_plugin( $options ) {
	array_shift( $options );
	array_unshift( $options, 'fontsizeselect');
	array_unshift( $options, 'formatselect');
	array_unshift( $options, 'fontselect');
	return $options;
}
}
add_filter('mce_buttons_2', 'wp_editor_fontsize_filter_plugin');


// Customize mce editor font sizes
if ( ! function_exists( 'wpex_mce_text_sizes' ) ) {
	function wpex_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 31px 32px 33px 34px 35px 36px 37px 38px 39px 40px 41px 42px 43px 44px 45px 46px 47px 48px 49px 50px 51px 52px 53px 54px 55px 56px 57px 58px 59px 60px 61px 62px 63px 64px 65px 66px 67px 68px 69px 70px 71px 72px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_text_sizes' );

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'AllertaStencil=AllertaStencil;ArchitectsDaughter=ArchitectsDaughter;Arvo=Arvo;Anton=Anton;Anke=Anke;Comic Sans MS=comic sans ms,sans-serif;caliban=caliban;Courier New=courier new,courier;DroidSans=DroidSans;DroidSerif=DroidSerif;Georgia=georgia,palatino;Impact=impact,chicago;Lato=Lato;Limelight=Limelight;Lora=Lora;Monda=Monda;Montez=Montez;Montserrat=Montserrat;NotoSans=NotoSans;Open Sans=Open Sans;Orbitron=Orbitron;Oswald=Oswald;PT Sans Caption Web=PT Sans Caption Web;Raleway=Raleway;Righteous=Righteous;Roboto=Roboto;ShadowsIntoLight=ShadowsIntoLight;Slabo=Slabo;SourceSansPro=SourceSansPro;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;TitilliumWeb=TitilliumWeb;Trebuchet MS=trebuchet ms,geneva;Ubuntu=Ubuntu;Verdana=verdana,geneva;';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );

 
// Add Google Scripts for use with the editor
if ( ! function_exists( 'wpex_mce_google_fonts_styles' ) ) {
	function wpex_mce_google_fonts_styles() {
	   $font_url = 'http://fonts.googleapis.com/css?family=Lato:300,400,700';
           add_editor_style( str_replace( ',', '%2C', $font_url ) );
		    add_editor_style( or_URL.'/assets/css/adminicons.css' );
	} 
          
	
	 
}
add_action( 'init', 'wpex_mce_google_fonts_styles' );


function or_facebook_load_sdk(){
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&version=v2.8&appId=149299702170011";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

function or_twitter_load_sdk(){
	?>
	<script>window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
		t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);

	  t._e = [];
	  t.ready = function(f) {
		t._e.push(f);
	  };

	  return t;
	}(document, "script", "twitter-wjs"));</script>
	<?php
}

function or_format_number($intNumber){
    // if the number is greater than or equal to 1000
    if ($intNumber >= 1000) {
        // divide by 1000 and add k
        $intNumber = round(($intNumber / 1000), 1).'k';
    }

    // return the number
    return $intNumber;
}

function or_getFacebookShareCount($urlCurrentPage){
    $cache_key = sprintf(
        'facebook_sharecount_%s',
        wp_hash( $urlCurrentPage )
    );
    if ( $cachedCount = wp_cache_get( $cache_key, 'orfb' ) ) {
        return or_format_number( $cachedCount );
    }

    // Get the longer cached value from the Transient API.
    $longCachedCount = get_transient( "orfb_{$cache_key}" );
    if ( false === $longCachedCount ) {
        $longCachedCount = 0;
    }

   
	// get results from facebook
	$htmlFacebookShareDetails = wp_remote_get('http://graph.facebook.com/'.$urlCurrentPage, array('timeout' => 6));

	// if no error
	if (is_wp_error($htmlFacebookShareDetails)) {
		return or_format_number( $longCachedCount );
	}

	// decode and return count
	$arrFacebookShareDetails = json_decode($htmlFacebookShareDetails['body'], true);
	$intFacebookShareCount = $longCachedCount;
	if ( isset( $arrFacebookShareDetails['share']['share_count'] ) ) {
		$intFacebookShareCount = (int) $arrFacebookShareDetails['share']['share_count'];
		wp_cache_set( $cache_key, $intFacebookShareCount, 'orfb', MINUTE_IN_SECONDS * 2 );
		set_transient( "orfb_{$cache_key}", $intFacebookShareCount, DAY_IN_SECONDS );
	}
	return or_format_number( $intFacebookShareCount );
    
}

function or_twitter_count($urlCurrentPage){
    // get results from newsharecounts and return the number of shares
    $result = wp_remote_get('http://public.newsharecounts.com/count.json?url=' . $urlCurrentPage, array('timeout' => 6));

    // check there was an error
    if (is_wp_error($result)) {
        return 0;
    }

    // decode data
    $result = json_decode($result['body'], true);
    $count = (isset($result['count']) ? $result['count'] : 0);

    // return
    return or_format_number($count);
}

// get google share count
function or_getGoogleShareCount($urlCurrentPage) {
	
	if(isset($_POST['url'])){
		$urlCurrentPage = $_POST['url'];
	}

    $args = array(
        'method' => 'POST',
        'headers' => array(
            // setup content type to JSON
            'Content-Type' => 'application/json'
        ),
        // setup POST options to Google API
        'body' => json_encode(array(
                'method' => 'pos.plusones.get',
                'id' => 'p',
                'method' => 'pos.plusones.get',
                'jsonrpc' => '2.0',
                'key' => 'p',
                'apiVersion' => 'v1',
                'params' => array(
                    'nolog'=>true,
                    'id'=> $urlCurrentPage,
                    'source'=>'widget',
                    'userId'=>'@viewer',
                    'groupId'=>'@self'
                )
            )),
        // disable checking SSL sertificates
        'sslverify'=>false
    );

    // retrieves JSON with HTTP POST method for current URL
    $json_string = wp_remote_post("https://clients6.google.com/rpc", $args);

	if(isset($_POST['url'])){
		if (is_wp_error($json_string)){
			// return zero if response is error
			echo "0";
		} else {
			$json = json_decode($json_string['body'], true);
			// return count of Google +1 for requsted URL
			echo or_format_number(intval($json['result']['metadata']['globalCounts']['count']));
		}
		die();
	}else{
		if (is_wp_error($json_string)){
			// return zero if response is error
			return "0";
		} else {
			$json = json_decode($json_string['body'], true);
			// return count of Google +1 for requsted URL
			return or_format_number(intval($json['result']['metadata']['globalCounts']['count']));
		}
	}
}

function or_getLinkedinShareCount($urlCurrentPage) {
    // get results from linkedin and return the number of shares
    $htmlLinkedinShareDetails = wp_remote_get('http://www.linkedin.com/countserv/count/share?url='.$urlCurrentPage, array('timeout' => 6));

     // if there was an error
    if (is_wp_error($htmlLinkedinShareDetails)) {
        return 0;
    }

    // extract/decode share count
    $htmlLinkedinShareDetails = str_replace('IN.Tags.Share.handleCount(', '', $htmlLinkedinShareDetails);
    $htmlLinkedinShareDetails = str_replace(');', '', $htmlLinkedinShareDetails);
    $arrLinkedinShareDetails = json_decode($htmlLinkedinShareDetails['body'], true);
    $intLinkedinShareCount =  $arrLinkedinShareDetails['count'];
    return ($intLinkedinShareCount) ? or_format_number($intLinkedinShareCount) : '0';
}

function or_getPinterestShareCount($urlCurrentPage) {

     // get results from pinterest
    $htmlPinterestShareDetails = wp_remote_get('http://api.pinterest.com/v1/urls/count.json?url='.$urlCurrentPage, array('timeout' => 6));

    // check there was an error
    if (is_wp_error($htmlPinterestShareDetails)) {
        return 0;
    }

    // decode data
    $htmlPinterestShareDetails = str_replace('receiveCount(', '', $htmlPinterestShareDetails);
    $htmlPinterestShareDetails = str_replace(')', '', $htmlPinterestShareDetails);
    $arrPinterestShareDetails = json_decode($htmlPinterestShareDetails['body'], true);
    $intPinterestShareCount =  $arrPinterestShareDetails['count'];
    return ($intPinterestShareCount) ? or_format_number($intPinterestShareCount) : '0';
}

function or_getStumbleUponShareCount($urlCurrentPage) {

    // get results from stumbleupon and return the number of shares
    $htmlStumbleUponShareDetails = wp_remote_get('http://www.stumbleupon.com/services/1.01/badge.getinfo?url='.$urlCurrentPage, array('timeout' => 6));

    // check there was an error
    if (is_wp_error($htmlStumbleUponShareDetails)) {
        return 0;
    }

    // decode data
    $arrStumbleUponResult = json_decode($htmlStumbleUponShareDetails['body'], true);
    $intStumbleUponShareCount = (isset($arrStumbleUponResult['result']['views']) ? $arrStumbleUponResult['result']['views'] : 0);
    return ($intStumbleUponShareCount) ? or_format_number($intStumbleUponShareCount) : '0';
}

function or_getRedditShareCount($urlCurrentPage) {
    // get results from reddit and return the number of shares
    $htmlRedditShareDetails = wp_remote_get('http://www.reddit.com/api/info.json?url='.$urlCurrentPage, array('timeout' => 6));

    // check there was an error
    if (is_wp_error($htmlRedditShareDetails)) {
        return 0;
    }

    // decode and get share count
    $arrRedditResult = json_decode($htmlRedditShareDetails['body'], true);
    $intRedditShareCount = (isset($arrRedditResult['data']['children']['0']['data']['score']) ? $arrRedditResult['data']['children']['0']['data']['score'] : 0);
    return ($intRedditShareCount) ? or_format_number($intRedditShareCount) : '0';
}

function or_getTumblrShareCount($urlCurrentPage){
    // get results from tumblr and return the number of shares
    $result = wp_remote_get('http://api.tumblr.com/v2/share/stats?url=' . $urlCurrentPage, array('timeout' => 6));

    // check there was an error
    if (is_wp_error($result)) {
        // return
        return 0;
    }

    // decode data
    $array = json_decode($result['body'], true);
    $count = (isset($array['response']['note_count']) ? $array['response']['note_count'] : 0);

    // return
    return ($count) ? $count : '0';
}

function or_vkontakteCount($urlCurrentPage){
	// get results from tumblr and return the number of shares
    $result = wp_remote_get('http://vk.com/share.php?act=count&url=' . $urlCurrentPage, array('timeout' => 6));
	
    // check there was an error
    if (is_wp_error($result)) {
        // return
        return 0;
    }
	//print_r($result);
    // decode data
    //$array = json_decode($result['body'], true);
	
	preg_match('#\((.*?)\)#', $result['body'], $match);
    $count = (isset($match[1]) ? explode(',',$match[1]) : 0);

    // return
    return isset($count[1]) ? $count[1] : '0';
}