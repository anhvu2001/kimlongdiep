<?php
class KLD_CateProduct_Widget1 extends \Elementor\Widget_Base {
    public function get_name() {
        return 'KLD Product Cate';
    }

    public function get_icon() {
        return 'eicon-post-list';
    }

    public function get_title() {
        return 'KLD Product Cate';
    }

    public function get_categories() {
        return ['MyCustomKLD'];
    }

    public function get_keywords() {
        return ['productcategory'];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'section_text1',
            [
                'label' => esc_html__('Text1', 'elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
              
        $this->end_controls_section();

        //TAPSTYLE
        $this->start_controls_section(
            'section_text2',
            [
                'label' => esc_html__('Text2', 'elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
                
      
        $this->add_control(
            'Color titel category',
            [
                'label' => esc_html__('Color titel category', 'elementor'),
                'type'=> \Elementor\Controls_Manager::COLOR,
                'selectors'=> [
                    '{{WRAPPER}} .title-catepro' => 'color: {{VALUE}}',
                ],
               
            ]
        );


        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_span',
                'label'    => esc_html__('Typography (Title)', 'elementor'),
                'selector' => '{{WRAPPER}} span',
            ]
        );
        
        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
    
         // Lấy danh sách danh mục sản phẩm
        $categories = get_terms('product_cat', array('hide_empty' => false));
        if (!empty($categories) && !is_wp_error($categories)) {
            array_shift($categories); //Xóa phần tử đầu tiên trong mảng
            echo '<div class="product-category-widget">';

            foreach ($categories as $category) {
                // Lấy thumbnail của danh mục
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_image_src($thumbnail_id, 'full');

                echo '<div class="category-item">';
                echo '<div class="item-decoration">';
                echo '<a href="' . get_term_link($category->term_id, 'product_cat') . '">';
                // Kiểm tra và hiển thị hình ảnh nếu hợp lệ
                echo isset($image_url[0]) ? '<img src="' . $image_url[0] . '" alt="' . $category->name . '">' : '';
                echo '<img class="sparkle-ring" src="' . get_site_url() . '/wp-content/uploads/2023/05/sparkle-ring.png'. '" alt="' . $category->name . '" >';
                echo '<span class="title-catepro">' . $category->name . '</span>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
            }
    
            echo '</div>';
        }
    }
}

