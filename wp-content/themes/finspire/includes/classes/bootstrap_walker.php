<?php



/**

 * Class Name: wp_bootstrap_navwalker

 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker

 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.

 * Version: 2.0.4

 * Author: Edward McIntyre - @twittem

 * License: GPL-2.0+

 */



class Bootstrap_walker extends Walker_Nav_Menu {

    /**
     * Set has_children property before start_el()
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output = '' ) {
        if ( isset( $args[0] ) && is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[ $element->ID ] );
        }
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    /**
     * Start the <ul> for sub menus with Bootstrap class
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    /**
     * Start each menu element
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        // Elementor mega menu template check
        $template_id = get_post_meta( $item->ID, '_menu_item_mega_template', true );
        $has_mega    = ! empty( $template_id ) && \Elementor\Plugin::$instance->documents->get( $template_id );
        $width_type  = get_post_meta( $item->ID, '_menu_item_mega_width', true ); // 'full' or 'default'

        // Base classes for <li>
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item menu-item-' . $item->ID;

        // Add mega menu class
        if ( $has_mega ) {
            $classes[] = 'has-mega-menu';
            if ( $width_type === 'full' ) {
                $classes[] = 'full-width';
            } elseif ( $width_type === 'default' ) {
                $classes[] = 'default-width';
            }
        }

        // Add dropdown class for parent items with children
        if ( ! empty( $args->has_children ) ) {
            $classes[] = 'dropdown';
        }

        // Current menu highlighting
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes ) ) {
            $classes[] = 'current';
        }

        // Build class string
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        // ID attribute
        $id_attr = apply_filters( 'nav_menu_item_id', 'nav-item menu-item-' . $item->ID, $item, $args );
        $id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

        // Output LI tag
        $output .= $indent . '<li' . $id_attr . $class_names . '>';

        // Link attributes
        $atts            = array();
        $atts['title']   = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target']  = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']     = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']    = ! empty( $item->url ) ? $item->url : '';

        // ====== CLASS LOGIC ======
        if ( $has_mega ) {
            // 1) Mega menu → "nav-link"
            $atts['class'] = '';

        } elseif ( ! empty( $args->has_children ) && $depth === 0 ) {
            // 2) Parent with children (dropdown) → "nav-link dropdown-toggle"
            $atts['class']             = '';
            $atts['data-bs-toggle']    = 'dropdown';
            $atts['aria-haspopup']     = 'true';
            $atts['aria-expanded']     = 'false';

        } elseif ( $depth > 0 ) {
            // 2b) Child menu items → "dropdown-item"
            $atts['class'] = 'dropdown-item';

        } else {
            // 3) Default → "nav-link"
            $atts['class'] = 'nav-link';
        }

        // Apply filters
        $atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Start link
        $item_output  = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';

        // Elementor Mega Menu content
        if ( $has_mega && $depth === 0 ) {
            $content      = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $template_id );
            $item_output .= '<div class="finspire-mega-menu-content mega-menu">' . $content . '</div>';
        }

        // End link
        $item_output .= $args->after;

        // Append to output
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}



