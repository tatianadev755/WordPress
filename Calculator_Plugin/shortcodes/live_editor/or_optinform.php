<#

if( data === undefined )
	data = {};

var atts = ( data.atts !== undefined ) ? data.atts : {},
	field_email = or.std( atts, 'field_email', ''),
	field_name = or.std( atts, 'field_name', ''),
	responder = or.std( atts, 'responder', ''),
	list_id = or.std( atts, 'list_id', ''),
	form_size = or.std( atts, 'form_size', 'small'),
	btn_txt = or.std( atts, 'btn_txt', ''),
	btn_bgclr = or.std( atts, 'btn_bgclr', ''),
	btn_hover_bgclr = or.std( atts, 'btn_hover_bgclr', ''),
	btn_clr = or.std( atts, 'btn_clr', ''),
	btn_hover_clr = or.std( atts, 'btn_hover_clr', ''),
	form_border_r = or.std( atts, 'form_border_r', '1px'),
	btn_border_r = or.std( atts, 'btn_border_r', '1px'),
	title_align = or.std( atts, 'title_align', 'left'),
	custom_class = or.std( atts, 'custom_class', ''),
	title = or.std( atts, 'title', ''),
	field_name_ck = or.std( atts, 'field_name_ck', ''),
	placeholder_full_name = or.std( atts, 'placeholder_full_name', ''),
	placeholder_email_name = or.std( atts, 'placeholder_email_name', ''),
	placeholder_separate_fname = or.std( atts, 'placeholder_separate_fname', ''),
	placeholder_separate_lname = or.std( atts, 'placeholder_separate_lname', ''),
	successaction = or.std( atts, 'successaction', ''),
	successmsg = or.std( atts, 'successmsg', ''),
	redirecturl = or.std( atts, 'redirecturl', ''),
	successmsg = or.std( atts, 'successmsg', ''),
	new_window = or.std( atts, 'new_window', ''),
	css = or.std( atts, 'css', '');

form_size = (form_size == 'small' ? 'or_sm_input' : (form_size == 'large' ? 'or_lg_input' : '') );

var classes = 'class="or_form' + ' ' + custom_class + ' ' + css + '"';
var form_align = (title_align == 'left' ? '0px;' : (title_align == 'center' ? '0px auto;' : '0px 0px 0px auto;') );
var btn_align = (title_align == 'left' ? 'float:left' : (title_align == 'center' ? '' : 'float:right') );
var loader_align = (title_align == 'left' ? 'left:13%;bottom:5px;right:auto;' : (title_align == 'center' ? 'left:55%;bottom:25px;right:auto;' : 'left:auto;bottom:5px;right:12%;') );

data.selector = custom_class;

data.spancss = "text-align	: "+title_align+";";
data.or_formsubscribe = "margin : "+form_align+";";
data.button = btn_align+";background-color: "+btn_bgclr+";color:"+btn_clr+";border-radius:"+btn_border_r+";";
data.button_hover = "background-color: "+btn_hover_bgclr+";color: "+btn_hover_clr+";";
data.field = "border-radius: "+form_border_r+";";
data.loader = loader_align;

data.callback = function( wrp, $, data ){
	top.or.front.ui.style.add( "body ."+data.selector+" span", data.spancss );
	top.or.front.ui.style.add( "body ."+data.selector+" .or_formsubscribe", data.or_formsubscribe );
	top.or.front.ui.style.add( "body ."+data.selector+" button", data.button );
	top.or.front.ui.style.add( "body ."+data.selector+" button:hover", data.button_hover );
	top.or.front.ui.style.add( "body ."+data.selector+" input[type='text'], body ."+data.selector+" input[type='email']", data.field );
	top.or.front.ui.style.add( "body ."+data.selector+"  .or_lead_form .or_lead_loader", data.loader );
}

#>
<div {{{classes}}}>
	<span>{{{title}}}</span>
	<form class="or_formsubscribe">
		<# if(field_name_ck == 'yes'){ #>
			<# if(field_name == 'name'){ #>
				<div class="or_lead_form wlp_user {{{form_size}}}">
					<input class="or_text_box" type="text" name="name" placeholder="{{{placeholder_full_name}}}"/>
				</div>
			<# } #>
			<# if(field_name == 'separate'){ #>
				<div class="or_lead_form wlp_user_name {{{form_size}}}">
					<input class="or_text_box" type="text" name="fname" placeholder="{{{placeholder_separate_fname}}}"/>
					<input class="or_text_box or_zero_margin" type="text" name="lname" placeholder="{{{placeholder_separate_lname}}}"/>
				</div>
			<# } #>
		<# } #>
		<# if(field_email == 'email'){ #>
			<div class="or_lead_form wlp_email {{{form_size}}}">
				<input class="or_text_box" type="email" name="email" placeholder="{{{placeholder_email_name}}}"/>
				<span class="or_lead_error"></span>
			</div>
		<# } #>
		<div class="or_lead_form {{{form_size}}}">
			<input type="hidden" name="responder" value="{{{responder}}}"/>
			<input type="hidden" name="list_id" value="{{{list_id}}}"/>
			<input type="hidden" name="successaction" value="{{{successaction}}}"/>
			<input type="hidden" name="successmsg" value="{{{successmsg}}}"/>
			<input type="hidden" name="redirecturl" value="{{{redirecturl}}}"/>
			<input type="hidden" name="new_window" value="{{{new_window}}}"/>
			<button><# if(btn_txt != ''){  #> {{{btn_txt}}} <# }else{ #>Submit<# } #></button>
			<span></span>
		</div>
	</form>
</div>