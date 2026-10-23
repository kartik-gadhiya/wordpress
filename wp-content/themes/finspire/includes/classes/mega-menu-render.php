<?php
function finspire_render_mega_menu($menu_item_id) {
    $enabled = get_post_meta($menu_item_id, '_menu_item_mega_enabled', true);
    $template_id = get_post_meta($menu_item_id, '_menu_item_mega_template', true);

    if ($enabled === 'on' && $template_id) {
        $content = apply_filters('the_content', get_post_field('post_content', $template_id));
        echo '<div class="finspire-mega-menu">' . $content . '</div>';
    }
}
