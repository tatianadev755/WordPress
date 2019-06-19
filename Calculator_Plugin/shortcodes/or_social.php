<?php
$output = $sharetxt = $showcount = $fullname = $chngcolor = $color = $shareaction = $url = '';
$type = 'share';
$icondesign = '01';
$network = '';
$shareaction = '0';
$urlCurrentPage = esc_url(get_permalink());

extract( $atts );

if(empty($network)){
	return false;
}

$effect = 'animated '.$animateeffect;

$network = explode(',',$network);

$class = array(
	'or_social',
	$css,
	$custom_class
);

echo '<div class="'.implode(' ',$class).'">';
echo '<div class="or_social_loader"></div>';
echo '<ul class="or_socialmain_ul">';
for($i=0;$i<count($network);$i++){
	echo '<li>';
	switch($network[$i]){
		case 'facebook':
			
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_getFacebookShareCount($urlCurrentPage) . '</span>';
			}
			echo '<a data-site="facebook" class="or_facebook_share" href="http://www.facebook.com/sharer.php?u=' . $urlCurrentPage  . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/facebook/'.$icondesign.'.svg" class="or_svg" alt="">';			
			echo '</a>';
			
		break;
		case 'linkedin':
		
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_getLinkedinShareCount($urlCurrentPage) . '</span>';
			}
			echo '<a data-site="linkedin" class="or_linkedin_share" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $urlCurrentPage  . '" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/linkedin/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
		break;
		case 'twitter':
			
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_twitter_count($urlCurrentPage) . '</span>';
			}
			echo '<a data-site="" class="or_twitter_share" href="https://twitter.com/intent/tweet?url=' . urlencode($urlCurrentPage) . '&amp;text=' . $sharetxt . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),' >';
				echo '<img src="'.or_URL.'/assets/images/social/twitter/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
		break;
		case 'google-plus':
				echo '<a data-site="google-plus" data-href="' . $urlCurrentPage  . '" data-shareaction="'.$shareaction.'"  data-redirecturl="'.$url.'" data-currenturl="'.$urlCurrentPage.'" data-count="' . or_getGoogleShareCount($urlCurrentPage) . '" class="or_google_share" href="https://plus.google.com/share?url=' . $urlCurrentPage  . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
					echo '<img src="'.or_URL.'/assets/images/social/google-plus/'.$icondesign.'.svg" class="or_svg" alt="">';
				echo '</a>';
				
				if($showcount == 'yes'){
					echo '<span class="or_sharecount">' . or_getGoogleShareCount($urlCurrentPage) . '</span>';
				}
				
				
		break;
		case 'pinterest':
			echo "<a data-site='pinterest' class='or_pinterest_share' href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'",($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),">";
				echo '<img src="'.or_URL.'/assets/images/social/pinterest/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo "</a>";
				
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_getPinterestShareCount($urlCurrentPage) . '</span>';
			}
		break;
		case 'print':
			echo '<a data-site="print" class="or_print_share or_share_link" href="#" onclick="window.print()" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/print/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
		break;
		case 'reddit':
			echo '<a data-site="reddit" class="or_reddit_share" href="http://reddit.com/submit?url=' . $urlCurrentPage  . '&amp;title=' . $sharetxt . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/reddit/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_getRedditShareCount($urlCurrentPage) . '</span>';
			}
		break;
		case 'stumbleupon':
			echo '<a data-site="stumbleupon" class="or_stumbleupon_share or_share_link" href="http://www.stumbleupon.com/submit?url=' . $urlCurrentPage  . '&amp;title=' . $sharetxt . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/stumbleupon/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_getStumbleUponShareCount($urlCurrentPage) . '</span>';
			}
		break;
		case 'tumblr':
			echo '<a data-site="tumblr" class="or_tumblr_share" href="http://www.tumblr.com/share/link?url=' . $urlCurrentPage . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/tumblr/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_getTumblrShareCount($urlCurrentPage) . '</span>';
			}
		break;
		case 'vk':
		
			if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_vkontakteCount($urlCurrentPage) . '</span>';
			}
			echo '<a data-site="vk" class="or_vk_share or_share_link" href="http://vkontakte.ru/share.php?url=' . $urlCurrentPage  . '" target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/vk/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
		break;
		case 'skype':
			wp_enqueue_script('or-skype');
			/*if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_vkontakteCount($urlCurrentPage) . '</span>';
			}*/
			echo '<a data-site="skype" data-href="'.$urlCurrentPage.'" data-lang="" data-text="" data-style="" class="or_skype_share skype-share or_share_link" href="#"  target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/skype/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
		break;
		case 'pocket':
			/*if($showcount == 'yes'){
				echo '<span class="or_sharecount">' . or_vkontakteCount($urlCurrentPage) . '</span>';
			}*/
			echo '<a data-site="pocket" class="or_pocket_share or_share_link" href="https://getpocket.com/save?url=' . $urlCurrentPage  . '&title='.$sharetxt.'"  target="_blank" ',($animateswitch == 'yes' ? "onmouseenter='or_animateDiv( this,  \"{$effect}\", 1000 );'" : ''),'>';
				echo '<img src="'.or_URL.'/assets/images/social/pocket/'.$icondesign.'.svg" class="or_svg" alt="">';
			echo '</a>';
			
		break;
	}
	echo '</li>';
}
echo '</ul>';
echo '</div>';
?>