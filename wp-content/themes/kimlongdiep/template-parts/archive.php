<?php
$category_name = single_cat_title('', false);
?>
<main id="content" <?php post_class('site-main'); ?>>
    <div class="page--post-content-col" style="display: flex; margin: 1% 0; gap:80px; text-align: start;">
        <div class="page-content-col-1" style="width: 65%;">
            <h1 id="title-category-posts">Danh mục bài viết: <?php echo $category_name; ?></h1>
            <div class="page-content">
                <?php
                $excluded_posts = array();
                while (have_posts()) {
                    the_post();
                    $post_link = get_permalink();
                ?>
                    <article class="post">
                        <?php
                        if (has_post_thumbnail()) {
                        ?>
                            <a href="<?php echo esc_url($post_link); ?>">
                                <div class="post-image-page-category-posts">
                                    <img style="width: 100%;height: 100%;" src="<?php echo esc_url(get_the_post_thumbnail_url($post, 'full')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                        <p class="entry-title"><a href="<?php echo esc_url($post_link); ?>"><?php echo wp_kses_post(get_the_title()); ?></a></p>
                        <span class="post-date-page-blog-detail"><?php echo get_the_date(); ?></span>
                        <?php
                        $excerpt = get_the_excerpt();
                        if (!empty($excerpt)) {
                            echo '<p class="post-excerpt">' . $excerpt . '</p>';
                        }
                        ?>
                        <a style="text-decoration: none;" href="<?php echo esc_url($post_link); ?>">
                            <p>Đọc thêm>></p>
                        </a>
                    </article>
                    <?php
                    $excluded_posts[] = get_the_ID();
                    ?>
                <?php } ?>
            </div>

            <?php wp_link_pages(); ?>
        </div>
        <div class="page-content-col-2" style="width: 30%;margin-top: 10px;">
            <div class="page-content-col-2-title">
                <p class="text-mix-and-match" style="width: 100%;">Mix & Match</p>
            </div>
            <?php
            $category = get_queried_object();
            $category_id = $category->term_id;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 5,
                'orderby' => 'rand',
                'post__not_in' => $excluded_posts,
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
    </div>
    <?php
    global $wp_query;
    if ($wp_query->max_num_pages > 1) :
        $big = 999999999;
        $pagination_args = array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => '<i class="fas fa-chevron-left"></i>',
            'next_text' => '<i class="fas fa-chevron-right"></i>',
        );
    ?>
        <div class="pagination-page-category-post">
            <nav class="pagination">
                <?php echo paginate_links($pagination_args); ?>
            </nav>
        </div>
    <?php endif; ?>

</main>