<?php
/**
* Plugin Name: Livestream Plugin
* Plugin URI: https://ondigitals.com
* Description: Plugin for livestream KLD.
* Version: 0.1
* Author:Danh - Ondigitals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register livestream Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_livestream_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/livestream.php' );

	$widgets_manager->register( new \Elementor_livestream_Widget() );

}
add_action( 'elementor/widgets/register', 'register_livestream_widget' );

// Register js and CSS
function live_stream_widget() {
  // Enqueue CSS file
  wp_enqueue_style( 'livestream-style', plugin_dir_url( __FILE__ ) . 'css/livestreamStyle.css' );

  
  wp_register_script( 'livestreamKLD', plugins_url( 'js/livestreamKLD.js', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'live_stream_widget' );
// function register_widget_scripts() {
// 	// wp_register_script( 'livestreamKLD', plugins_url( 'assets/js/livestreamKLD.js', __FILE__ ) );
// }
// add_action( 'wp_enqueue_scripts', 'register_widget_scripts' );

// Register a custom settings page
function livestream_settings_page() {
    add_options_page(
        'Facebook Access Token for Livestream facebook KLD', // Page title
        'LiveStream Access Token', // Menu title
        'manage_options', // Capability required to access the page
        'livestream-settings', // Page slug
        'des_settings_callback' // Callback function to render the settings page
    );
}
add_action('admin_menu', 'livestream_settings_page');

// Register and initialize the custom settings
function my_custom_settings_init() {
    // Register a section
    add_settings_section(
        'livestream_settings_section', // Section ID
        'General Settings', // Section title
        'render_livestream_settings_section_callback', // Callback function to render the section
        'livestream-settings' // Page slug of the settings page
    );

    // Register a field
    add_settings_field(
        'access_token_field', // Field ID
        'Access Token', // Field label
        'render_accesstoken_field_callback', // Callback function to render the field
        'livestream-settings', // Page slug of the settings page
        'livestream_settings_section' // Section ID
    );

    // Register the field's value
    register_setting(
        'livestream_settings_group', // Option group
        'access_token_field' // Option name
    );
}
add_action('admin_init', 'my_custom_settings_init');

// Render the custom settings page
function des_settings_callback() {
    ?>
    <div class="wrap">
        <h1>Livestream Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('livestream_settings_group');
            do_settings_sections('livestream-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Render the section
function render_livestream_settings_section_callback() {
    echo 'Access token sẽ hết hạn 3 tháng/lần, login tài khoản Ngọc Ái để tạo token!';
}

// Render the field
function render_accesstoken_field_callback() {
    $value = get_option('access_token_field');
    echo '<input style="width:50%" type="text" name="access_token_field" value="' . esc_attr($value) . '" />';
}

/**
 * Register Live Stream Template
 */
function my_plugin_register_templates() {
    $template_path = plugin_dir_path( __FILE__ ) . 'templates/livestream_template.php';
    $template_name = 'LiveStream Template';

    if ( file_exists( $template_path ) ) {
        add_filter( 'theme_page_templates', function ( $templates ) use ( $template_path, $template_name ) {
            $templates['templates/livestream_template.php'] = $template_name;
            return $templates;
        } );
    }
}
    add_action( 'init', 'my_plugin_register_templates' );
    //register a endpoint api for livestream
    add_action( 'rest_api_init', function () {

    
    register_rest_route( 'livestream/v1', '/getlivestream', array(
      'methods' => 'GET',
      'callback' => 'get_livestream',
    ) );
  } );


  function get_livestream() {
    $access_token = get_option('access_token_field');
    $url = 'https://graph.facebook.com/v17.0/111060231385247/live_videos?fields=video%2Cpermalink_url%2Cdescription%2Cstatus%2Ccreation_time&limit=12&access_token='.$access_token;
    $response = wp_remote_get( $url );
    $body = wp_remote_retrieve_body( $response );
    $array_data = json_decode( $body );
    //Get thumbnail
    foreach ($array_data->data as $value) {
        $video_id = $value->video->id;
        $url_get_thumbnail = 'https://graph.facebook.com/v17.0/'.$video_id.'/thumbnails?fields=uri&limit=10&access_token='.$access_token;
        $response_thumb = wp_remote_get($url_get_thumbnail);
        $body_thumb = wp_remote_retrieve_body( $response_thumb );
        $array_thumbnail = json_decode( $body_thumb );
        $link_thumbnail = $array_thumbnail->data[0]->uri;
        $value->video->thumbnail = $link_thumbnail;
    }
    return $array_data;

    
  }
  function get_thumbnail_image_livesteam($request){
    $liveStream_id = $request->get_param('liveStream_id');
    $access_token = get_option('access_token_field');
    
    $url=  "https://graph.facebook.com/v17.0/".$liveStream_id."/thumbnails?fields=uri&limit=10&access_token=".$access_token;

    $response = wp_remote_get( $url );
    $body = wp_remote_retrieve_body( $response );

    $data_thumbnail = json_decode( $body );

    return $data_thumbnail;

  }
  //register a endpoint api for livestream thumbnail
  add_action( 'rest_api_init', function () {
    register_rest_route( 'livestream/v1', '/getthumbnail/(?P<liveStream_id>[a-zA-Z0-9-]+)', array(
      'methods' => 'GET',
      'callback' => 'get_thumbnail_image_livesteam',
    ) );
  });
  //register a endpoint api for livestream

    function paggingLivestream() {
        register_rest_route( 'livestream/v1', '/paggingLivestream/(?P<before_after>[a-zA-Z0-9-]+)/(?P<value>[a-zA-Z0-9-]+)', array(
            'methods'  => 'GET',
            'callback' => 'render_livestream_callback',
        ) );
    }
    add_action( 'rest_api_init', 'paggingLivestream' );

    function render_livestream_callback( $request ) {
        $before_after = $request->get_param( 'before_after' );
        $value = $request->get_param( 'value' );
        $access_token = get_option('access_token_field');

        $url = 'https://graph.facebook.com/v17.0/111060231385247/live_videos?fields=video%2Cpermalink_url%2Cdescription%2Cstatus%2Ccreation_time&limit=12&access_token='.$access_token.'&'.$before_after.'='.$value;
        $response = wp_remote_get($url );
        $body = wp_remote_retrieve_body( $response );
        $array_data = json_decode( $body );
        //Get thumbnail
        foreach ($array_data->data as $value) {
            $video_id = $value->video->id;
            $url_get_thumbnail = 'https://graph.facebook.com/v17.0/'.$video_id.'/thumbnails?fields=uri&limit=10&access_token='.$access_token;
            $response_thumb = wp_remote_get($url_get_thumbnail);
            $body_thumb = wp_remote_retrieve_body( $response_thumb );
            $array_thumbnail = json_decode( $body_thumb );
            $link_thumbnail = $array_thumbnail->data[0]->uri;
            $value->video->thumbnail = $link_thumbnail;
        }
        return $array_data;
    }
    // add nouislider script to a custom page template to a specific page
    // TODO: lỗi khi load script ra url parent theme
    // add_action('wp_enqueue_scripts','Load_Template_Scripts_wpa83855');
    // function Load_Template_Scripts_wpa83855(){
    //     if ( is_product_category() ) {
    //         wp_enqueue_script('noUiSlider-script', get_template_directory_uri().'/node_modules/nouislider/dist/nouislider.min.js', array('jquery'), '1.0.0', true);   
    //     } 
    // }
?>