<?php
class KLD_Category_Post_Widget8 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD Category Post';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD All Post By Category';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['Category Post'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_text_title',
            [
                'label' => esc_html__('Category Post', 'elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        //TAPSTYLE
        $this->add_control(
            'Color title category post',
            [
                'label' => esc_html__('Color title category post', 'elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mix-match-post-title' => 'color: {{VALUE}}',
                ],

            ]
        );
        // tạo ô nhập category post
        $this->add_control(
            'input_category_post',
            [
                'label' => esc_html__('Loi bài viết', 'elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'chưa phân loại',
                'options' => $this->get_post_categories(),
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_span',
                'label'    => esc_html__('Typography (Title)', 'elementor'),
                'selector' => '{{WRAPPER}} .mix-match-post-title',
            ]
        );

        $this->end_controls_section();
    }
    protected function get_post_categories()
    {
        $categories = get_categories([
            'taxonomy' => 'category',
            'hide_empty' => false,
        ]);

        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }
    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $id_category_post = $settings['input_category_post'];
        $args = array(
            'category' => $id_category_post,
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $posts = get_posts($args);
        $total_count = count($posts);
        $total_pages = ceil($total_count / 8);
?>
        <div id="idCategoryPost<?php echo  $id_category_post ?>" class="mix-match-container-category-post" data-id=<?php echo  $id_category_post ?>></div>
        <div id="pagination-category-post" class="KLD-Pagination-Blog" data-id="<?= $id_category_post ?>">
            <button id="btn-pagination-byCategory-prev" class="btn-pagination-posts">
                <i class="fas fa-chevron-left"></i>
            </button>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="page<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
            <button id="btn-pagination-byCategory-next" class="btn-pagination-posts">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>


<?php
        wp_enqueue_script('scriptCatePost.js', plugin_dir_url(__FILE__) . 'js/scriptCatePost.js', array('jquery'), '1.0', true);
    }
}