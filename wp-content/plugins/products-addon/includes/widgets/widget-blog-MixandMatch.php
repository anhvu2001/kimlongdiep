<?php
class KLD_BLog_MixandMatch_Widget6 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD Blog Mix and Match';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD List Post Mix and Match';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['mixandmatch'];
    }
    protected function render()
    {

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        $total_count = $query->post_count - 5;
        wp_reset_query();
        $total_pages = ceil($total_count / 8);
?>
        <div id="getallposts" class="mix-match-container" ></div>
        <div id="pagination" class="KLD-Pagination-Blog">
             <button id="btn-pagination-mix-match-prev" class="btn-pagination-posts">
                <i class="fas fa-chevron-left"></i>
            </button>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="page<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
            <button id="btn-pagination-mix-match-next" class="btn-pagination-posts">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
<?php
        wp_enqueue_script('scriptPost.js', plugin_dir_url(__FILE__) . 'js/scriptPost.js', array('jquery'), '1.0', true);
    }
}