<?php namespace FINSPIREPLUGIN\Element;

class Mega_Menu_Walker extends \Walker_Nav_Menu {
    
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="sub-menu">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $template_id = get_post_meta($item->ID, '_menu_item_mega_template', true);
        $has_mega = \Elementor\Plugin::$instance->documents->get($template_id);

        // Add "has-mega__menu" if a mega menu template is assigned
        $classes = $item->classes;
        if ($has_mega) {
			// Mega menu case
			$classes[] = 'has-mega__menu';
		} elseif (isset($args->walker->has_children) && $args->walker->has_children) {
			// Only add "dropdown" if this item has sub-menu items
			$classes[] = 'dropdown';
		}

        $class_names = implode(' ', array_filter($classes));
        $output .= "<li class='" . esc_attr($class_names) . "'>";

        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

        // If mega menu template is assigned, render its content
        if ($has_mega) {
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($template_id);
            $output .= '<div class="finspire-mega-menu-content">';
            $output .= $content;
            $output .= '</div>';
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}
