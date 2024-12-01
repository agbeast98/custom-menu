<?php

function cpm_product_menu_shortcode($atts) {
    $atts = shortcode_atts(array('category' => ''), $atts);
    $category_name = sanitize_text_field($atts['category']);
    $categories = get_option('cpm_product_categories', array());

    ob_start();
    echo '<div class="cpm-category-list">';
    foreach ($categories as $category) {
        if ($category['name'] == $category_name) {
            foreach ($category['products'] as $product) {
                echo '<div class="product-item">';
                echo '<div class="product-info">';
                echo '<span class="product-name">' . esc_html($product['name']) . '</span>';
                echo '<span class="separator"></span>';
                echo '<span class="product-price">' . esc_html($product['price']) . ' هزار تومان</span>';
                echo '</div>';
                echo '<div class="product-description">' . esc_html($product['description']) . '</div>';
                echo '</div>';
            }
        }
    }
    echo '</div>';

    return ob_get_clean();
}
add_shortcode('cpm_product_menu', 'cpm_product_menu_shortcode');
