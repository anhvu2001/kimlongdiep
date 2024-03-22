<?php
class KLD_FeaturedProduct_Widget4 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD List Posts';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD List Posts ';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['listPost'];
    }
    public function render()
    {
        // Query posts
        $query_args = [
            'post_type' => 'post',
            'posts_per_page' => 3
        ];
        $posts_query = new WP_Query($query_args);

        // Output post list
        if ($posts_query->have_posts()) {
            echo '<div class="post-homepage-Kld">';
        
            while ($posts_query->have_posts()) {
                $posts_query->the_post();
                $short_description = get_the_excerpt();
                $short_description = wp_strip_all_tags($short_description);
                $short_description = mb_substr($short_description, 0, 80, 'UTF-8') . "..."; 
        
                echo '<a class="card-post-homepage-Kld" href="' . get_permalink() . '">';
                echo '<img style="height: 300px; object-fit: cover; border-radius: 15px;" src="' . get_the_post_thumbnail_url(get_the_ID(), 'full') . '" alt="' . get_the_title() . '">';
                echo '<h3 style="font-weight: 600; font-size: 16px; line-height: 21px;font-family: Montserrat;">' . get_the_title() . '</h3>';
                echo '<p style="font-weight: 400; font-size: 14px; line-height: 21px; color: #FFFFFF;font-family: Montserrat;">' . $short_description . '</p>';
                echo '</a>';
            }
            echo '</div>';
            wp_reset_postdata();
        }
    }
}
