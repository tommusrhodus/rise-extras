<?php 
/*-----------------------------------------------------------------------------------*/
/*	REGISTER SHORTCODES
/*-----------------------------------------------------------------------------------*/

//Button [button link='google.com' details='light small' target='blank']Link Text[/button]
function ebor_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '#',
		'details' => 'light small',
		'target' => ''
	), $atts));
		
	if($target == 'blank') 
		$target = 'target="_blank"';
	
    return '<a href="' . esc_url($link) . '" '.$target.' class="rise-btn '. $details .'">' . $content . '</a>';
}
add_shortcode('button', 'ebor_button');

//Dropcap [dropcap]Link Text[/dropcap]
function ebor_dropcap( $atts, $content = null ) {
	return '<p class="dropcaps">' . $content . '</p>';
}
add_shortcode('dropcap', 'ebor_dropcap');