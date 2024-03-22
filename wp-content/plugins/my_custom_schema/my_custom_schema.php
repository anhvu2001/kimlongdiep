<?php
/*
Plugin Name: Custom Schema category products
Version: 1.0
Author: vu ondigitals
*/

function add_custom_schema_page()
{
    add_menu_page(
        'Custom Schema Category Product',
        'Schema Category Product',
        'manage_options',
        'schema-category-product',
        'custom_schema_page_content',
        'dashicons-media-code',
        4
    );
}
add_action('admin_menu', 'add_custom_schema_page');
function custom_schema_page_content()
{
?>
    <div class="wrap">
        <h1>Custom Schema Category Products</h1>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="save_schema_scripts">
            <?php
            $taxonomy = 'product_cat';
            $args = array(
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
            );

            $categories = get_terms($args);
            $categories = array_slice($categories, 1);
            foreach ($categories as $category) {
            ?>
                <h1 style="margin: 0; display: block; padding:0"><?php echo esc_html($category->name); ?></h1>
                <?php
                $schema_script = get_option('schema_script_' . $category->term_id);
                $json_decoded = stripslashes($schema_script);
                ?>
                <label style="display: block; margin:15px 0;" for="schema_script_<?php echo $category->term_id; ?>">Schema Script cho <?php echo esc_html($category->name); ?>:</label>
                <textarea style="width:100%; height: 100px;" id="schema_script_<?php echo $category->term_id; ?>" name="schema_script_<?php echo $category->term_id; ?>" rows="8"><?php echo esc_textarea($json_decoded); ?></textarea>
            <?php
            }


            ?>
            <?php
            submit_button();
            ?>
        </form>
    </div>
<?php
}
function save_schema_scripts_handler()
{
    if (isset($_POST['action']) && $_POST['action'] === 'save_schema_scripts') {
        $taxonomy = 'product_cat';
        $args = array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        );
        $categories = get_terms($args);
        $categories = array_slice($categories, 1);
        foreach ($categories as $category) {
            $schema_script = isset($_POST['schema_script_' . $category->term_id]) ? $_POST['schema_script_' . $category->term_id] : '';
            update_option('schema_script_' . $category->term_id, $schema_script);
        }
    }
    wp_safe_redirect(wp_get_referer());
    exit;
}
add_action('admin_post_save_schema_scripts', 'save_schema_scripts_handler');
// Add the product category schema to the <head> tag of each product category page
function add_product_category_schema()
{

    if (is_product_category()) {
        $category = get_queried_object();
        $schema_script = get_option('schema_script_' . $category->term_id);
        if ($schema_script) {
            $json_decoded = stripslashes($schema_script);
            echo $json_decoded;
        }
    }
}
add_action('wp_head', 'add_product_category_schema');
