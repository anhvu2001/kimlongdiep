<?php

/**
 * Plugin Name: Meta box slider product in post
 * Plugin URI: https://ondigitals.com
 * Description: Plugin for Meta box slider product
 * Version: 0.1
 * Author: Vu - Ondigitals
 */
function metabox_register_meta_boxes()
{
    add_meta_box('metabox_slider', 'Slider hiển thị danh sách sản phẩm theo category', 'metabox_display_callback', 'post');
}
add_action('add_meta_boxes', 'metabox_register_meta_boxes');

function metabox_display_callback()
{
    global $post;
    $selected_value = get_post_meta($post->ID, 'category-product-selects', true);
    $categories = get_terms('product_cat');
?>
    <label for="metabox_category">Chọn danh mục hiển thị</label>
    <select name="metabox_category_value" id="metabox_category">
        <option value="0">Chọn danh mục</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo esc_attr($category->term_id); ?>" <?php selected($selected_value, $category->term_id); ?>>
                <?php echo esc_html($category->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
<?php
}

function metabox_save_custom_metabox()
{
    global $post;

    if (isset($_POST["metabox_category_value"])) {
        update_post_meta($post->ID, 'category-product-selects', $_POST["metabox_category_value"]);
    }
}

add_action('save_post', 'metabox_save_custom_metabox');
