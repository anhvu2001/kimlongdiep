<?php
class KLD_widget_wholesale_NewProduct_Widget7 extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'KLD sản phẩm bán sỉ mới nhất';
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_title()
    {
        return 'KLD sản phẩm bán sỉ mới nhất';
    }

    public function get_categories()
    {
        return ['MyCustomKLD'];
    }

    public function get_keywords()
    {
        return ['newproduct'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_text_link-product',
            [
                'label' => esc_html__('Text link', 'elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text_link_product',
            [
                'label' => esc_html__('Text link', 'elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Liên hệ',
                'placeholder' => 'Liên hệ',
            ]
        );
        //TAPSTYLE
        $this->add_control(
            'Color title name products',
            [
                'label' => esc_html__('Color title name products', 'elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-wholesale-content-title' => 'color: {{VALUE}}',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_span',
                'label'    => esc_html__('Typography (Title)', 'elementor'),
                'selector' => '{{WRAPPER}} .product-wholesale-content-title',
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $text_link = $settings['text_link_product'];
        $paged = max(1, get_query_var('paged')); // Lấy số trang hiện tại
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 10, // Số sản phẩm hiển thị trên mỗi trang
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged, // Số trang hiện tại
        );

        $products = wc_get_products($args);

        if ($products) {
            echo '<div class="product-wholesale-container">';

            foreach ($products as $product) {
                echo '<div class="product-wholesale-card">';
                if ($product->get_image_id()) {
                    echo '<div class="product-wholesale-thumbnail">';
                    echo '<a href="' . $product->get_permalink() . '">';
                    echo wp_get_attachment_image($product->get_image_id(), 'thumbnail');
                    echo '</a>';
                    echo '</div>';
                }
                echo '<div class="product-wholesale-content">';
                echo '<a href="' . $product->get_permalink() . '" class="product-wholesale-content-title">' . $product->get_name() . '</a>';
                echo '<a class="product-wholesale-content-link" href="/lien-he">' . $text_link . '</a>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';

            // Hiển thị phân trang
            $total_products = wp_count_posts('product')->publish;
            $total_pages = ceil($total_products / 10); // Tính tổng số trang
            $current_page = max(1, get_query_var('paged'));
            echo '<div class="KLD-Pagination pagination-product-wholesale">';
            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '/page/%#%', // Định dạng URL
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text' => '<i class="fas fa-chevron-left"></i>',
                'next_text' => '<i class="fas fa-chevron-right"></i>',
            ));
            echo '</div>';
        } else {
            echo 'Không có sản phẩm nào.';
        }
    }
}
