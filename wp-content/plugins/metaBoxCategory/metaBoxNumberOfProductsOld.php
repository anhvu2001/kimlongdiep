<?php

/**
 * Plugin Name: Meta box Number of product
 * Plugin URI: https://ondigitals.com
 * Description: Plugin for Meta box Number of product
 * Version: 1.0
 * Author: Vu - Ondigitals
 */
function metabox_display_callback_products($post) {
    // Lấy giá trị hiện tại của hai trường số (nếu có)
    $number_heart = get_post_meta($post->ID, 'number-heart', true);
    $product_sold = get_post_meta($post->ID, 'product-sold', true);
    ?>
    <label for="number-heart">Nhập số lượng tim yêu thích: </label>
    <input type="number" id="number-heart" name="number-heart" value="<?php echo esc_attr($number_heart); ?>" required>
    <label for="product-sold">Nhập số lượng sản phẩm đã bán:</label>
    <input type="number" id="product-sold" name="product-sold" value="<?php echo esc_attr($product_sold); ?>" required>
    <?php
}
function metabox_save_callback_products($post_id) {
    if (isset($_POST['number-heart'])) {
        $number_heart = sanitize_text_field($_POST['number-heart']);
        update_post_meta($post_id, 'number-heart', $number_heart);
    }

    if (isset($_POST['product-sold'])) {
        $product_sold = sanitize_text_field($_POST['product-sold']);
        update_post_meta($post_id, 'product-sold', $product_sold);
    }
}
function metabox_register_meta_boxes_products() {
    add_meta_box('metabox_slider', 'Số lượng sản phẩm đã bán', 'metabox_display_callback_products', 'product');
}
add_action('add_meta_boxes_product', 'metabox_register_meta_boxes_products');
add_action('save_post_product', 'metabox_save_callback_products');


