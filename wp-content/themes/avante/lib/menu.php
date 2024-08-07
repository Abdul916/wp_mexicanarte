<?php
/*
 *  Setup main navigation menu
 */
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	register_nav_menu( 'primary-menu', esc_html__('Primary Menu', 'avante' ) );
	register_nav_menu( 'secondary-menu', esc_html__('Secondary Menu', 'avante' ) );
	register_nav_menu( 'top-menu', esc_html__('Top Bar Menu', 'avante' ) );
	register_nav_menu( 'side-menu', esc_html__('Side (Mobile) Menu', 'avante' ) );
	register_nav_menu( 'footer-menu', esc_html__('Footer Menu', 'avante' ) );
}

class Avante_Walker extends Walker_Nav_Menu {

	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) { 
            $element->classes[] = 'arrow'; 
        }
        
        Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
	    $object = $item->object;
    	$type = $item->type;
    	$title = $item->title;
    	$description = $item->description;
    	$permalink = $item->url;
    	$megamenu = get_post_meta( $item->ID, 'menu-item-megamenu', true );
    	
    	//If globally disable mega menu then remove
    	if(!AVANTE_MEGAMENU)
    	{
	    	$megamenu = '';
    	}
    	
	    $output .= "<li class='" .  implode(" ", $item->classes);
	    
	    if($depth == 0 && !empty($megamenu))
	    {
		    $output .= " elementor-megamenu megamenu arrow";
		}
		
		$output .= "'>";
	    
	    $output .= '<a href="'.esc_url($permalink).'" ';
	    
	    if(!empty($item->target)) {
	    	$output.= 'target="' . esc_attr( $item->target ) .'"';  
	    }
	    
	    $output .= '>'.$title;
		$output .= '</a>';
		
		if($depth == 0 && !empty($megamenu) && AVANTE_MEGAMENU)
	    {
		    if(!empty($megamenu) && class_exists("\\Elementor\\Plugin"))
			{
		    	$output .= '<ul class="elementor-megamenu-wrapper"> '.avante_get_elementor_content($megamenu).'</ul>';
		    }
		}
	}
}
?>