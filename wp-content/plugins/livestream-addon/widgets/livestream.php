<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor livestream Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_livestream_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve livestream widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Feature Livestream ';
	}
	public function get_script_depends() {
		return [ 'livestreamKLD'];
	}
	/**
	 * Get widget title.
	 *
	 * Retrieve livestream widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Feature Livesteam', 'elementor-livestream-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve  widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-video-camera';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the livestream widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the livestream widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'livestream', 'url', 'link' ];
	}


	/**
	 * Register livestream widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

	
	}

	/**
	 * Render livestream widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$url = 'https://graph.facebook.com/v17.0/111060231385247/live_videos?';
		
		$access_token = get_option('access_token_field');
		$response = wp_remote_get( $url."fields=status%2Cdescription%2Ctitle%2Clive_views%2Cpermalink_url&limit=1&access_token=".$access_token );

		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			$headers = $response['headers']; // array of http header lines
			$body    = $response['body']; // use the content
			$data_fectch = json_decode($body,true);
			if($data_fectch["data"][0]['status'] === "VOD"){
				$khungGioLiveIMG = 'https://kimlongdiep.com/wp-content/uploads/2024/01/khunggiolivestream1.webp';
				echo '<img src="'.$khungGioLiveIMG.'" alt="Khung giờ livestream">';
			}else{
				$permalink_url = $data_fectch["data"][0]['permalink_url'];
				echo "<script async defer src=\"https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2\"></script>
				<div class=\"fb-video\"
						data-href=\"https://www.facebook.com/".$permalink_url."\"
						data-width=\"auto\"
						data-show-captions=\"false\">
				</div>";
			}
		};
		
	}
}
?>