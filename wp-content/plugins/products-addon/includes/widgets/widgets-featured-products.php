<?php
class KLD_FeaturedProduct_Widget3 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD Featured Products';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD Featured Products ';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['featuredProduct'];
    }
    public function render()
    {
        // Lấy danh sách ID của sản phẩm nổi bt
        $featured_product_ids = wc_get_featured_product_ids();
        // Kiểm tra nếu có sản phẩm nổi bật
        if (!empty($featured_product_ids)) {
            // Vòng lp qua từng ID sản phm
?>
            <div class="slidermain-featured owl-carousel owl-theme">
                <?php
                foreach ($featured_product_ids as $product_id) {
                    // Lấy thông tin chi tiết của sản phẩm
                    $product = wc_get_product($product_id);
                    // Kiểm tra nếu sản phẩm tồn tại
                    if ($product) {
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'full');
                        $product_name = $product->get_name();
                        $product_price = $product->get_price_html();
                        $product_permalink = $product->get_permalink();
                        $number_heart = get_post_meta($product_id, 'number-heart', true);
                        $product_sold_total = get_post_meta($product_id, 'product-sold', true);
                        $randomNumber_heart = (($product_id + 123) % 11) + 5;
                        $randomNumber_producut_sold = (($product_id  + 789) % 11) + 15;
                ?>
                        <a href="<?= esc_url($product_permalink); ?>" class="card-featured item">
                            <div class="card-featured-image"> <img src="<?= $product_image[0] ?>" alt="<?= $product_name ?>"></div>
                            <p class="card-nameproduct-featured"><?= $product_name ?></p>
                            <p class="card-priceproduct-featured"><?= $product_price ?></p>
                         <?php
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

                                        ?>
                        </a>
                <?php
                    }
                }
                ?>
            </div>
        <?php
        } else {
            echo 'Khng có sản phẩm nổi bật.';
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
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true,
                    navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
                    responsive: {
                        0: {
                            items: 2,
                          	slideBy: 2
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
