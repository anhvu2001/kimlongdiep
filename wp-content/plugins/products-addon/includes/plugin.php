<?php

namespace KLD_Elementor_Addon;

final class Plugin
{
    private static $_instance = null;

    public function __construct()
    {
        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
            add_action('elementor/elements/categories_registered', [$this, 'register_categories']);
            // Enqueue the CSS file
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        }
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function init()
    {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }

    public function register_widgets($widgets_manager)
    {
        // Widget so1
        require_once(__DIR__ . '/widgets/widgets-ProCategory.php');
        $widgets_manager->register_widget_type(new \KLD_CateProduct_Widget1());
        // Widget so2
        require_once(__DIR__ . '/widgets/widgets-sell-products.php');
        $widgets_manager->register_widget_type(new \KLD_SellProduct_Widget2());
        // Widget so3
        require_once(__DIR__ . '/widgets/widgets-featured-products.php');
        $widgets_manager->register_widget_type(new \KLD_FeaturedProduct_Widget3());
      // Widget so4
        require_once(__DIR__ . '/widgets/widgets-post.php');
        $widgets_manager->register_widget_type(new \KLD_FeaturedProduct_Widget4());
       // Widget so5
        require_once(__DIR__ . '/widgets/widgets-NewsPost.php');
        $widgets_manager->register_widget_type(new \KLD_BLog_Newspost_Widget5());
        // Widget so6
        require_once(__DIR__ . '/widgets/widget-blog-MixandMatch.php');
        $widgets_manager->register_widget_type(new \KLD_BLog_MixandMatch_Widget6());
      	// Widget so7
        require_once(__DIR__ . '/widgets/widget-wholesale-NewProduct.php');
        $widgets_manager->register_widget_type(new \KLD_widget_wholesale_NewProduct_Widget7());
        // Widget so8
       require_once(__DIR__ . '/widgets/widget-category-post.php');
        $widgets_manager->register_widget_type(new \KLD_Category_Post_Widget8());
         // Widget so9
      require_once(__DIR__ . '/widgets/widget-get-product-by-category.php');
        $widgets_manager->register_widget_type(new \KLD_Get_Product_ByCategory_Widget9());
    }

     private function is_compatible()
    {
        // Kiểm tra tính tương thích với phiên bản Elementor tại đây
        return true;
    }
    public function register_categories($elements_manager)
    {
        $elements_manager->add_category(
            'MyCustomKLD',
            [
                'title' => esc_html__('My Custom KLD', 'KLD_Elementor_Addon'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    public function enqueue_styles()
    {
        wp_enqueue_style('widget-style-1', plugin_dir_url(__FILE__) . 'widgets/css/style.css');
        wp_enqueue_style('widget-style-2', plugin_dir_url(__FILE__) . 'widgets/css/owl.carousel.min.css');
        wp_enqueue_style('widget-style-3', plugin_dir_url(__FILE__) . 'widgets/css/owl.theme.default.min.css');
    }
    
    public function enqueue_scripts()
    {
        // Enqueue jQuery
        wp_enqueue_script('jquery');
    
        wp_enqueue_script('widget-script-1', plugin_dir_url(__FILE__) . 'widgets/js/script.js', array(), '1.0.0', true);
        wp_enqueue_script('widget-script-2', plugin_dir_url(__FILE__) . 'widgets/js/owl.carousel.js', array(), '1.0.0', true);
        wp_enqueue_script('widget-script-3', plugin_dir_url(__FILE__) . 'widgets/js/owl.carousel.min.js', array(), '1.0.0', true);
    }
    
}
