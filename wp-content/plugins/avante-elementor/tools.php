<?php

if(!function_exists('avante_is_registered'))
{
	function avante_is_registered() {
		$avante_is_registered = get_option("envato_purchase_code_".ENVATOITEMID);
		
		if(!empty($avante_is_registered)) {
			return $avante_is_registered;
		}
		else {
			return false;
		}
	}
}

if(!function_exists('avante_get_course_price_html') && function_exists('learn_press_get_course'))
{	
	function avante_get_course_price_html($course_id = '')
	{
		$price_html = '';
		if(!empty($course_id))
		{
			$course = learn_press_get_course($course_id);
			$price_html = $course->get_price_html();
		}
		
		return $price_html;
	}
}

if(!function_exists('avante_highlight_keyword'))
{
	function avante_highlight_keyword($str, $search) {
	    $occurrences = substr_count(strtolower($str), strtolower($search));
	    $newstring = $str;
	    $match = array();
	 
	    for ($i=0;$i<$occurrences;$i++) {
	        $match[$i] = stripos($str, $search, $i);
	        $match[$i] = substr($str, $match[$i], strlen($search));
	        $newstring = str_replace($match[$i], '[#]'.$match[$i].'[@]', strip_tags($newstring));
	    }
	 
	    $newstring = str_replace('[#]', '<strong>', $newstring);
	    $newstring = str_replace('[@]', '</strong>', $newstring);
	    return $newstring;
	}
}
	
if(!function_exists('avante_sanitize_title'))
{
	function avante_sanitize_title($title = '')
	{
		if(!empty($title))
		{
			$title = str_replace(' ', '-', $title);
			$title = preg_replace('/[^A-Za-z0-9]/', '-', $title);
			$title = strtolower($title);
			return $title;
		}
	}
}
	
if(!function_exists('avante_get_lazy_img_attr'))
{
	function avante_get_lazy_img_attr()
	{
		$tg_enable_lazy_loading = get_theme_mod('tg_enable_lazy_loading');
		$return_attr = array('class' => '','source' => 'src');
		
		if(!empty($tg_enable_lazy_loading))
		{
			$return_attr = array('class' => 'lazy','source' => 'data-src');
		}
		
		return $return_attr;
	}
}
	
if(!function_exists('avante_get_blank_img_attr'))
{
	function avante_get_blank_img_attr()
	{
		$tg_enable_lazy_loading = get_theme_mod('tg_enable_lazy_loading');
		$return_attr = '';
		
		if(!empty($tg_enable_lazy_loading))
		{
			$return_attr = 'src=""';
		}
		
		return $return_attr;
	}
}

if(!function_exists('avante_get_post_format_icon'))
{
	function avante_get_post_format_icon($post_id = '')
	{
		$return_html = '';
		
		if(!empty($post_id))
		{
			$post_format = get_post_format($post_id);
			
			if($post_format == 'video')
			{
				$return_html = '<div class="post-type-icon"><span class="ti-control-play"></span></div>';	
			}
		}
		
		return $return_html;
	}
}

if(!function_exists('avante_limit_get_excerpt'))
{
	function avante_limit_get_excerpt($excerpt = '', $limit = 50, $string = '...')
	{
		$excerpt = preg_replace(" ([*?])",'',$excerpt);
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $limit);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = $excerpt.$string;
		
		return '<p>'.$excerpt.'</p>';
	}
}

if(!function_exists('avante_get_image_id'))
{
	function avante_get_image_id($url) 
	{
		$attachment_id = attachment_url_to_postid($url);
		
		if(!empty($attachment_id))
		{
			return $attachment_id;
		}
		else
		{
			return $url;
		}
	}
}
 
function avante_attachment_field_credit ($form_fields, $post) {
	$form_fields['avante-purchase-url'] = array(
		'label' => esc_html__('Purchase URL', 'avante-elementor'),
		'input' => 'text',
		'value' => esc_url(get_post_meta( $post->ID, 'avante_purchase_url', true )),
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'avante_attachment_field_credit', 10, 2 );

function avante_attachment_field_credit_save ($post, $attachment) {
	if( isset( $attachment['avante-purchase-url'] ) )
update_post_meta( $post['ID'], 'avante_purchase_url', esc_url( $attachment['avante-purchase-url'] ) );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'avante_attachment_field_credit_save', 10, 2 );
?>