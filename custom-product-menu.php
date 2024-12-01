<?php
/*
Plugin Name: Custom Product Menu
Description: A custom plugin to manage product categories and items without WooCommerce.
Version: 1.0
Author: khateweb
*/

// افزودن صفحه مدیریت به پنل ادمین
function cpm_add_admin_menu() {
    add_menu_page('Product Menu', 'Product Menu', 'manage_options', 'custom-product-menu', 'cpm_admin_page');
}
add_action('admin_menu', 'cpm_add_admin_menu');

// بارگذاری فایل استایل افزونه
function cpm_load_styles() {
    wp_enqueue_style('cpm-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('admin_enqueue_scripts', 'cpm_load_styles');

// شامل کردن فایل مدیریت
include(plugin_dir_path(__FILE__) . 'admin-page.php');

// شورت‌کد برای نمایش محصولات براساس دسته‌بندی
function cpm_render_products_by_category($atts) {
    $attributes = shortcode_atts(array('category' => ''), $atts);
    $selected_category = $attributes['category'];

    $categories = get_option('cpm_product_categories', array());

    ob_start();

    foreach ($categories as $category) {
        if ($category['name'] === $selected_category) {
            echo '<div class="product-category">';
            foreach ($category['products'] as $product) {
                echo '<div class="product-item">';
                echo '<span class="product-name">' . esc_html($product['name']) . '</span>';
                echo '<span class="product-price">' . esc_html($product['price']) . ' هزار تومان</span>';
                echo '<div class="product-description">' . esc_html($product['description']) . '</div>';
                echo '</div>';
            }
            echo '</div>';
            break;
        }
    }

    return ob_get_clean();
}
add_shortcode('cpm_products', 'cpm_render_products_by_category');
