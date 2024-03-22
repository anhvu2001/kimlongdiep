<?php


get_header();
while (have_posts()) : the_post();
?>
    <?php
    global $post;
    $categoryId = get_post_meta($post->ID, 'category-product-selects', true);
    $category = get_term_by('id', $categoryId, 'product_cat');
    ?>
    <main id="content" <?php post_class('site-main'); ?>>
        <div class="page--post-content-col" style="display: flex; margin: 1% 0; gap:80px; text-align: start;">
            <div class="page-content-col-1" style="width: 65%;">
                <h1><?php the_title(); ?></h1>
                <span class= "name-date-post-detail"><?php echo get_the_date() ?> |</span>
                <span class= "name-date-post-detail">Tiệm vàng Kim Long Diệp</span>
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
                            echo "<h4>Một số mẫu sn phẩm mới tại Kim Long iệp</h4>";
                        } ?>
                        <div class="slider-container-featured">
                            <div class="slidermain-featured">
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
                                        <a href="<?= esc_url($product_permalink); ?>" class="card-featured">
                                            <img src="<?= $product_image[0] ?>" alt="<?= $product_name ?>">
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
                            <button class="prev-btn-featured"><i class="fa-solid fa-chevron-left" style="color: #FFFFFF;"></i></button>
                            <button class="next-btn-featured"><i class="fa-solid fa-chevron-right" style="color: #FFFFFF;"></i></button>
                        </div>
                    <?php
                    } else {
                        echo '<div style= "display:none;"></div>';
                    }
                    ?>

                </div>
                <?php comments_template(); ?>
                <script>
                    const sliderFeatured = document.querySelector(".slidermain-featured");
                    const prevBtnFeatured = document.querySelector(".prev-btn-featured");
                    const nextBtnFeatured = document.querySelector(".next-btn-featured");
                    const slideWidthFeatured =
                        document.querySelector(".card-featured").offsetWidth;
                    const slidesFeatured = document.querySelectorAll(
                        ".slidermain-featured .card-featured"
                    );
                    console.log(slideWidthFeatured)
                    const totalSlidesFeatured = slidesFeatured.length;

                    function updateSlidesToShowFeatured() {
                        if (window.innerWidth >= 1024) {
                            let slidesToShow = 3; // S slide hin th mc nh
                            let currentPosition = 0;
                            prevBtnFeatured.addEventListener("click", () => {
                                prevBtnFeatured.style.backgroundColor = "rgba(217, 217, 217, 0.2)";
                                currentPosition += slideWidthFeatured + 20; // Thêm khong cch 20px vào v tr hin tại
                                if (currentPosition > 0) {
                                    currentPosition = -slideWidthFeatured * (totalSlidesFeatured - slidesToShow);
                                    currentPosition -= 20 * (totalSlidesFeatured - slidesToShow);
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            });

                            nextBtnFeatured.addEventListener("click", () => {
                                nextBtnFeatured.style.backgroundColor = "rgba(217, 217, 217, 0.2)";
                                currentPosition -= slideWidthFeatured + 20; // Thm khong cch 20px vo v trí hin ti
                                if (
                                    currentPosition <
                                    -slideWidthFeatured * (totalSlidesFeatured - slidesToShow)
                                ) {
                                    currentPosition = 0;
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            });
                            setInterval(() => {
                                try {
                                    currentPosition -= slideWidthFeatured + 20;
                                    if (
                                        currentPosition <
                                        -slideWidthFeatured * (totalSlidesFeatured - slidesToShow)
                                    ) {
                                        currentPosition = 0;
                                    }
                                    sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                                } catch (error) {
                                    console.error("Đã xảy ra lỗi:", error);
                                }
                            }, 4000);
                        } else if (window.innerWidth >= 820) {
                            let slidesToShow = 2; // Hin th 3 slide trn tablet
                            let currentPosition = 0;
                            prevBtnFeatured.addEventListener("click", () => {
                                prevBtnFeatured.style.backgroundColor = "rgba(217, 217, 217, 0.2)";
                                currentPosition += slideWidthFeatured + 20; // Thm khong cách 20px vo v tr hin tại
                                if (currentPosition > 0) {
                                    currentPosition = -slideWidthFeatured * (totalSlidesFeatured - slidesToShow);
                                    currentPosition -= 20 * (totalSlidesFeatured - slidesToShow);
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            });

                            nextBtnFeatured.addEventListener("click", () => {
                                nextBtnFeatured.style.backgroundColor = "rgba(217, 217, 217, 0.2)";
                                currentPosition -= slideWidthFeatured + 20; // Thm khong cách 20px vào v tr hin ti
                                if (
                                    currentPosition <
                                    -slideWidthFeatured * (totalSlidesFeatured - slidesToShow)
                                ) {
                                    currentPosition = 0;
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            });
                            setInterval(() => {
                                currentPosition -= slideWidthFeatured + 20;
                                if (
                                    currentPosition <
                                    -slideWidthFeatured * (totalSlidesFeatured - slidesToShow)
                                ) {
                                    currentPosition = 0;
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            }, 4000);
                        } else {
                            let slidesToShow = 1; // Hin th 1 slide trên mobile
                            let currentPosition = 0;
                            prevBtnFeatured.addEventListener("click", () => {
                                prevBtnFeatured.style.backgroundColor = "rgba(217, 217, 217, 0.2)";
                                nextBtnFeatured.style.border = "black";
                                currentPosition += slideWidthFeatured + 20; // Thm khong cch 20px vo v tr hin ti
                                if (currentPosition > 0) {
                                    currentPosition = -slideWidthFeatured * (totalSlidesFeatured - slidesToShow);
                                    currentPosition -= 20 * (totalSlidesFeatured - slidesToShow);
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            });

                            nextBtnFeatured.addEventListener("click", () => {
                                nextBtnFeatured.style.backgroundColor = "rgba(217, 217, 217, 0.2)";
                                nextBtnFeatured.style.border = "black";
                                currentPosition -= slideWidthFeatured + 20; // Thm khong cách 20px vo v trí hin ti
                                if (
                                    currentPosition <
                                    -slideWidthFeatured * (totalSlidesFeatured - slidesToShow)
                                ) {
                                    currentPosition = 0;
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            });
                            setInterval(() => {
                                currentPosition -= slideWidthFeatured + 20;
                                if (
                                    currentPosition <
                                    -slideWidthFeatured * (totalSlidesFeatured - slidesToShow)
                                ) {
                                    currentPosition = 0;
                                }
                                sliderFeatured.style.transform = `translateX(${currentPosition}px)`;
                            }, 4000);
                        }
                    }

                    updateSlidesToShowFeatured();
                    // Thc hin x lý khi kch thớc trình duyt thay đi
                    window.addEventListener("resize", updateSlidesToShowFeatured);
                    const fields = [{
                            element: document.getElementById('comment'),
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
                        if (field.element.value === '') {
                            field.element.value = field.placeholder;
                        }

                        field.element.addEventListener('input', () => {
                            if (field.element.value === field.placeholder) {
                                field.element.value = '';
                            }
                        });
                    });
                </script>
            </div>
            <div class="page-content-col-2" style="width: 30%;margin-top: 10px;">
                <div class="page-content-col-2-title">
                    <h2>Bài viết nổi bật</h2>
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
                                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                                            echo '<img src="' . $thumbnail_url . '" alt="' . get_the_title() . '">';
                                        }
                                        ?>
                                    </div>
                                    <div class="post-content-page-blog-detail">
                                        <h3 class="post-title-page-blog-detail"><?php the_title(); ?></h3>
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
                        <h2 style="width: 43%;">Mix & Match</h2>
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
                                                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                                                echo '<img src="' . $thumbnail_url . '" alt="' . get_the_title() . '">';
                                            }
                                            ?>
                                        </div>
                                        <div class="post-content-page-blog-detail">
                                            <h3 class="post-title-page-blog-detail"><?php the_title(); ?></h3>
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
                    <div class="page-content-col-2-title-sale" style= "margin: 10px 0;">
                        <h2 style="width:unset; font-size: 21px;">Khuyến mãi sieu hot ti KLD</h2>
                        <span style="color:#FDCD81">&#x2726;</span>
                        <span style="color:#FDCD81">&#x2726;</span>
                        <span style="color:#FDCD81">&#x2726;</span>
                    </div>
                    <div>
                        <img src="<?php echo get_site_url(); ?>/<?php echo "wp-content/uploads/2023/05/anh-khuyen-mai-post-deatil.png" ?>" alt="">

                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
endwhile;
get_footer();
?>