<?php
class KLD_SellProduct_Widget2 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD Sell Products';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD Sell Product ';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['sellproduct'];
    }
    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $categories = get_terms('product_cat', array('hide_empty' => true));

?>
        <ul class="tabs">
            <?php
            foreach ($categories as $category) {
                $tab_id = 'tab' . $category->term_id;
                $tab_class = ($category === reset($categories)) ? 'active' : '';
            ?>
                <li class="tab-link <?php echo $tab_class; ?>" data-tab="<?php echo $tab_id; ?>" data-id="<?php echo $category->term_id; ?>">
                    <?php echo $category->name; ?>
                </li>

            <?php } ?>
        </ul>

        <?php
        foreach ($categories as $category) {
            $tab_id = 'tab' . $category->term_id;
            $tab_class = ($category === reset($categories)) ? 'active' : '';
            $tab_id_children = 'tabchildren' . $category->term_id;
        ?>
            <div id="<?php echo $tab_id; ?>" class="tab <?php echo $tab_class; ?>">
                <div class="owl-carousel owl-theme  <?php echo $tab_id_children; ?>">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $category->term_id,
                            ),
                        ),
                    );
                    $products_query = new WP_Query($args);

                    if ($products_query->have_posts()) {


                        while ($products_query->have_posts()) {
                            $products_query->the_post();
                            global $product;
                            $product_id = get_the_ID();
                
                            $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            $product_name = $product->get_name();
                            $product_price = $product->get_price_html();
                            $product_permalink = $product->get_permalink();
							 $number_heart = get_post_meta($product_id, 'number-heart', true);
                            $product_sold_total = get_post_meta($product_id, 'product-sold', true);
                            $randomNumber_heart = (($product_id + 123) % 11) + 5;
                            $randomNumber_producut_sold = (($product_id  + 789) % 11) + 15;

                    ?>
                            <a href="<?= esc_url($product_permalink); ?>" class="card item">
                                <div class="card-image">
                                    <img src="<?= $product_image[0] ?>" alt="<?= $product_name ?>">
                                </div>
                                <p class="card-nameproduct"><?= $product_name ?></p>
                                 <?php
                                if ($category->term_id === 26) {
                                    // Lấy danh sách các thuộc tính toàn cục
                                    $global_attributes = wc_get_attribute_taxonomies();
                                    if (!empty($global_attributes)) {
                                        echo '<ul class="list-attributes-product">';
                                        foreach ($global_attributes as $attribute) {
                                            $attribute_name = wc_attribute_taxonomy_name($attribute->attribute_name);
                                            // Kiểm tra xem sản phẩm có sử dụng thuộc tính này không
                                            if (taxonomy_exists($attribute_name)) {
                                                // Lấy giá trị của thuộc tính cho sản phẩm
                                                $attribute_values = wc_get_product_terms(get_the_ID(), $attribute_name, array('fields' => 'names'));
                                                if (!empty($attribute_values)) {
                                                    echo '<li>'. esc_html(implode(', ', $attribute_values)) . '</li>';
                                                }
                                            }
                                        }
                                        echo '</ul>';
                                    }
                                }
                                ?>
                                <p class="card-priceproduct"><?= $product_price ?></p>
                         <?php
                                 if ($category->term_id != 26) {
                                    if (!empty($number_heart) && !empty($product_sold_total)) {
                                ?>
                                        <div style="display: flex; justify-content: space-between;">
                                            <p class="number-heart"><i style="color: #ffa61a;margin-right: 5px;" class="fa-solid fa-heart"></i><?= $number_heart ?></p>
                                            <p style="color: #ffa61a;font-weight:700 ;" class="product-sold"><?= $product_sold_total . '+ ' ?><span style="color: white;font-weight:400 ;">đã bán</span></p>
                                        </div><?php
                                            } else {
                                                ?>
                                        <div style="display: flex; justify-content: space-between;">
                                            <p class="number-heart"><i style="color: #ffa61a;margin-right: 5px;" class="fa-solid fa-heart"></i><?= $randomNumber_heart ?></p>
                                            <p style="color: #ffa61a; font-weight:700 ;" class="product-sold"><?= $randomNumber_producut_sold . '+ ' ?><span style="color: white; font-weight:400 ;">đã bán</span></p>
                                        </div><?php
                                            }
                                        }

                                            ?>
                            </a>
                    <?php

                        }
                        wp_reset_postdata();
                    } else {
                        echo '<p>Không có sản phẩm nào.</p>';
                    }
                    ?>
                </div>

            </div>
        <?php } ?>
<?php
    }
}