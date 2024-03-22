<?php
class KLD_Get_Product_ByCategory_Widget9 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD Products By Categorys';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD Products By Categorys';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['categoryProducts'];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_text_title',
            [
                'label' => esc_html__('Category Products', 'elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

       
        $this->add_control(
            'input_category_products',
            [
                'label' => esc_html__('Loại sản phẩm', 'elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'Chưa phân loại',
                'options' => $this->get_categories_products(),
            ]
        );


        $this->end_controls_section();
    }
    protected function get_categories_products()
    {
        $categories = get_categories([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $id_category_products = $settings['input_category_products'];
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $id_category_products,
                ),
            ),
        );
        $products_query = new WP_Query($args);
        if ($products_query->have_posts()) {
?>
            <div class="owl-carousel owl-theme">
                <?php
                while ($products_query->have_posts()) {
                    $products_query->the_post();
                    $product = wc_get_product();
                    if ($product && $product->is_visible()) {
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $product_name = $product->get_name();
                        $product_price = $product->get_price_html();
                        $product_permalink = $product->get_permalink();
                ?>
                        <a href="<?= esc_url($product_permalink); ?>" class="card-featured item">
                            <div class="card-featured-image"><img src="<?= $product_image[0] ?>" alt="<?= $product_name ?>"></div>
                            <p class="card-nameproduct-featured"><?= $product_name ?></p>
                            <p class="card-priceproduct-featured"><?= $product_price ?></p>
                        </a>
                <?php
                    }
                }
                wp_reset_postdata();
                ?>
            </div>
        <?php
        } else {
            echo 'Không có sản phẩm nào.';
        }
        ?>
        <script>
            jQuery(document).ready(function($) {
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    dots: false,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 1000,
                    autoplayHoverPause: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
                    responsive: {
                        0: {
                            items: 2
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 4
                        }
                    }
                })
            });
        </script>
<?php
    }
}
