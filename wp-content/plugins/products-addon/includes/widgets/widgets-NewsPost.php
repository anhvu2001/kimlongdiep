<?php
class KLD_BLog_Newspost_Widget5 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD Blog News Post';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD Blog News Post';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['newsposst'];
    }

    protected function register_controls()
    {
        //TAPSTYLE
        $this->start_controls_section(
            'section_text2',
            [
                'label' => esc_html__('Text title', 'elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'Color title newspost',
            [
                'label' => esc_html__('Color title blogs Newspost', 'elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}}',
                ],

            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_span',
                'label'    => esc_html__('Typography (Title)', 'elementor'),
                'selector' => '{{WRAPPER}} a',
            ]
        );

        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
        );

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            $dem = 1;
            echo '<div class="news-post-container">';
            while ($query->have_posts()) {
                $query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $title = get_the_title();
                $date = get_the_date();
                $post_link = get_permalink();
?>
                <div class="post-item<?php echo $dem; ?> ">
  					<div class="link-post-item-image">
                        <a href="<?php echo $post_link; ?>"><img class="post-item-image" src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" /></a>
                    </div>       
                  <a  class="post-item-title" href="<?php echo $post_link; ?>"><?php echo $title ?></a>
                    <p><?php echo $date ?></p>
                </div>
<?php
                $dem++;
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo 'Không có bài viết.';
        }
    }
}
