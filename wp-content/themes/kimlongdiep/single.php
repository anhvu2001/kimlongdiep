<?php

/*
Template Name: test
Template Post Type: post
*/
get_header();
while (have_posts()) : the_post();
?>
    <?php
    global $post;
    $categoryId = get_post_meta($post->ID, 'category-product-selects', true);
    $category = get_term_by('id', $categoryId, 'product_cat');
    ?>
    <main id="content" <?php post_class('site-main'); ?>>
        <div class="page--post-content-col">
            <div class="page-content-col-1" style="width: 65%;">
                <h1><?php the_title(); ?></h1>
                <span class="name-date-post-detail"><?php echo get_the_date() ?> |</span>
                <span class="name-date-post-detail">Tiệm vàng Kim Long Diệp</span>
                <?php the_content(); ?>
                <div class="slider-post-detail-main">
                    <?php
                    if ($categoryId != 0) {
                    ?>
                        <?php
                        if ($category) {
                            $category_name = $category->name;
                            echo "<h4 class='title-slider-post-detail'>Một số mẫu " . $category_name . " tại Kim Long Diệp</h4>";
                        } else {
                            echo "<h4>Một số mẫu sản phẩmm mới tại Kim Long Điệp</h4>";
                        } ?>
                        <div class="slidermain-featured owl-carousel owl-theme">
                            <?php
                            $args = array(
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' =>  $categoryId,
                                    ),
                                ),
                            );
                            $products_query = new WP_Query($args);

                            if ($products_query->have_posts()) {

                                while ($products_query->have_posts()) {
                                    $products_query->the_post();
                                    global $product;

                                    $product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                    $product_name = $product->get_name();
                                    $product_price = $product->get_price_html();
                                    $product_permalink = $product->get_permalink();


                            ?>
                                    <a href="<?= esc_url($product_permalink); ?>" class="card-featured item">
                                        <div style="height: 300px;" class="card-featured-image">
                                            <img src="<?= $product_image[0] ?>" alt="<?= $product_name ?>">

                                        </div>
                                        <p class="card-nameproduct-featured"><?= $product_name ?></p>
                                        <p class="card-priceproduct-featured"><?= $product_price ?></p>
                                    </a>
                            <?php
                                }
                                wp_reset_postdata();
                            } else {
                                echo '<p>No products found.</p>';
                            }
                            ?>
                        </div>
                    <?php
                    } else {
                        echo '<div style= "display:none;"></div>';
                    }
                    ?>
                    <hr style="border: none; border-top: 2px solid #FDCD81; width: 100%;margin: 40px 0px;">
                </div>
                <?php comments_template(); ?>
                <script>
                    jQuery(document).ready(function($) {
                        $('.owl-carousel').owlCarousel({
                            loop: true,
                            margin: 10,
                            dots: false,
                            nav: true,
                            autoplay: true,
                            autoplayTimeout: 3000,
                            autoplayHoverPause: true,
                            navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items: 1
                                },
                                1000: {
                                    items: 3
                                }
                            }
                        })
                    });
                    const fields = [{
                            element: document.querySelector('.page-content-col-1 #comment'),
                            placeholder: '* Viết bình luận của bạn ở đây'
                        },
                        {
                            element: document.getElementById('author'),
                            placeholder: '* Tên'
                        },
                        {
                            element: document.getElementById('email'),
                            placeholder: '* Email'
                        }
                    ];

                    fields.map(field => {
                        if (field.element?.value === '') {
                            field.element.placeholder = field.placeholder;
                        }
                        field.element?.addEventListener('input', () => {
                            if (field.element.value !== '') {
                                field.element.placeholder = '';
                            }
                        });
                        field.element?.addEventListener('blur', () => {
                            if (field.element.value === '') {
                                field.element.placeholder = field.placeholder;
                            }
                        });
                    });
                </script>
            </div>
            <div class="page-content-col-2" style="width: 30%;margin-top: 10px;">
                <div class="page-content-col-2-title">
                    <p>Bài viết nổi bật</p>
                    <hr style="border: none; border-top: 2px solid #FDCD81; width: 15%;margin: 8px 10px;">
                    <a style="width: 25%;" href="https://kimlongdiep.com/bai-viet/">Xem tất cả <i class="fa-solid fa-chevron-right" style="color:#FFFFFF"></i></a>
                </div>
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $list_posts = get_posts($args);
                if (count($list_posts) > 0) {
                    echo '<div class="page-content-col-2-new-post-container">';
                    foreach ($list_posts as $post) {
                        setup_postdata($post);
                ?>
                        <article <?php post_class(); ?>>
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <div class="page-content-col-2-new-post">
                                    <div class="post-image-page-blog-detail">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                            echo '<img src="' . $thumbnail_url . '" alt="' . get_the_title() . '">';
                                        }
                                        ?>
                                    </div>
                                    <div class="post-content-page-blog-detail">
                                        <p class="post-title-page-blog-detail"><?php the_title(); ?></p>
                                        <span class="post-date-page-blog-detail"><?php echo get_the_date(); ?></span>
                                    </div>
                                </div>
                            </a>
                        </article>
                <?php
                    }
                    echo '</div>';
                } else {
                    echo 'Không có bài viết nào.';
                }

                wp_reset_postdata();
                ?>
                <!-- phần bài vit mix and match -->
                <div style="margin:40px 0;">
                    <div class="page-content-col-2-title">
                        <p style="width: 43%;">Mix & Match</p>
                        <hr style="border: none; border-top: 2px solid #FDCD81; width: 25%;margin: 8px 10px;">
                        <a style="width: 25%;" href="https://kimlongdiep.com/bai-viet/">Xem tất cả <i class="fa-solid fa-chevron-right" style="color:#FFFFFF"></i></a>
                    </div>
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'orderby' => 'rand',
                    );

                    $list_posts = get_posts($args);

                    if (count($list_posts) > 0) {
                        echo '<div class="page-content-col-2-new-post-container">';
                        foreach ($list_posts as $post) {
                            setup_postdata($post);
                    ?>
                            <article <?php post_class(); ?>>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <div class="page-content-col-2-new-post">
                                        <div class="post-image-page-blog-detail">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                                echo '<img src="' . $thumbnail_url . '" alt="' . get_the_title() . '">';
                                            }
                                            ?>
                                        </div>
                                        <div class="post-content-page-blog-detail">
                                            <p class="post-title-page-blog-detail"><?php the_title(); ?></p>
                                            <span class="post-date-page-blog-detail"><?php echo get_the_date(); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                    <?php
                        }
                        echo '</div>';
                    } else {
                        echo 'Không có bài viết nào.';
                    }

                    wp_reset_postdata();
                    ?>
                </div>
                <!-- phần quảng cáo -->
                <div style="margin:40px 0;">
                    <div class="page-content-col-2-title-sale" style="margin: 10px 0;">
                        <p style="width:unset; font-size: 21px;">Khuyến mãi siêu hot tại KLD</p>
                        <span style="color:#FDCD81">&#x2726;</span>
                        <span style="color:#FDCD81">&#x2726;</span>
                        <span style="color:#FDCD81">&#x2726;</span>
                    </div>
                    <div>
                       <img style="border-radius: 15px;" src="https://kimlongdiep.com/wp-content/uploads/2024/01/anh-khuyen-mai-post-deatil-2-jpg.webp" alt="Khuyến mãi Kim Long Diệp" >

                    </div>
                </div>
            </div>
        </div>
    </main>
	<script>
    	//Fixed position header
		const headerElement = document.getElementById("masthead");
        headerElement.style.backgroundColor = "#242424";
        headerElement.style.position = "fixed";
        headerElement.style.top = 0;
        headerElement.style.width = "100%";
                        
       	const contentElement = document.querySelector(".page--post-content-col");
        const margintopValue = +window.getComputedStyle(contentElement).marginTop.replace("px", "");
        const headerHeight = +headerElement.clientHeight;
        const computedMarginTop = headerHeight + margintopValue; 
        contentElement.style.marginTop = `${computedMarginTop}px`;
    </script>
<?php
endwhile;
get_footer();
?>