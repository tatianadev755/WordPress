<?php
$output = $field_email = $field_name = $responder = $list_id = $form_size = $btn_txt = $btn_bgclr = $btn_clr = $custom_class = $title = $field_name_ck = $css = '';
$form_size = 'small';

extract( $atts );

$form_size = ($form_size == 'small' ? 'or_sm_input' : ($form_size == 'large' ? 'or_lg_input' : '') );

$class = array(
	'or_form',
	$custom_class,
	$css
);

$output .= '<div class="'.implode(' ',$class).'">';
	$output .= '<span>'.$title.'</span>';
	$output .= '<form class="or_formsubscribe">';
		if($field_name_ck == 'yes'){
			if($field_name == 'name'){
				$output .= '<div class="or_lead_form wlp_user '.$form_size.'">';
					$output .= '<input class="or_text_box" type="text" name="name" placeholder="'.$placeholder_full_name.'"/>';
				$output .= '</div>';
			}
			if($field_name == 'separate'){
				$output .= '<div class="or_lead_form wlp_user_name '.$form_size.'">';
					$output .= '<input class="or_text_box" type="text" name="fname" placeholder="'.$placeholder_separate_fname.'"/>';
					$output .= '<input class="or_text_box or_zero_margin" type="text" name="lname" placeholder="'.$placeholder_separate_lname.'"/>';
				$output .= '</div>';
			}
		}
		if($field_email == 'email'){
			$output .= '<div class="or_lead_form wlp_email '.$form_size.'">';
				$output .= '<input class="or_text_box" type="email" name="email" placeholder="'.$placeholder_email_name.'"/>';
				$output .= '<span class="or_lead_error"></span>';
			$output .= '</div>';
		}
		$output .= '<div class="or_lead_form '.$form_size.'">';
			$output .= '<input type="hidden" name="responder" value="'.$responder.'"/>';
			$output .= '<input type="hidden" name="list_id" value="'.$list_id.'"/>';
			$output .= '<input type="hidden" name="successaction" value="'.$successaction.'"/>';
			$output .= '<input type="hidden" name="successmsg" value="'.$successmsg.'"/>';
			$output .= '<input type="hidden" name="redirecturl" value="'.$redirecturl.'"/>';
			$output .= '<input type="hidden" name="new_window" value="'.$new_window.'"/>';
			$output .= '<button>';$output .= !empty($btn_txt) ? $btn_txt : 'Submit';$output .= '</button>';
			$output .= '<span></span>';
		$output .= '</div>';
	$output .= '</form>';
$output .= '</div>';

echo $output;
?>