<?php
/**
 * The template for displaying header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! hello_get_header_display() ) {
	return;
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$header_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-1',
	'fallback_cb' => false,
	'echo' => false,
] );
?>
<header id="site-header" class="site-header dynamic-header <?php echo esc_attr( hello_get_header_layout_class() ); ?>" role="banner">
	<div class="header-inner">
		<div class="site-branding show-<?php echo esc_attr( hello_elementor_get_setting( 'hello_header_logo_type' ) ); ?>">
			<?php if ( has_custom_logo() && ( 'title' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<div class="site-logo <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<?php the_custom_logo(); ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== hello_elementor_get_setting( 'hello_header_logo_type' ) || $is_editor ) ) : ?>
				<h1 class="site-title <?php echo esc_attr( hello_show_or_hide( 'hello_header_logo_display' ) ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'hello-elementor' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</h1>
			<?php endif;

			if ( $tagline && ( hello_elementor_get_setting( 'hello_header_tagline_display' ) || $is_editor ) ) : ?>
				<p class="site-description <?php echo esc_attr( hello_show_or_hide( 'hello_header_tagline_display' ) ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $header_nav_menu ) : ?>
			<nav class="site-navigation <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
			<div class="site-navigation-toggle-holder <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>">
				<div class="site-navigation-toggle" role="button" tabindex="0">
					<i class="eicon-menu-bar" aria-hidden="true"></i>
					<span class="screen-reader-text"><?php echo esc_html__( 'Menu', 'hello-elementor' ); ?></span>
				</div>
			</div>
			<nav class="site-navigation-dropdown <?php echo esc_attr( hello_show_or_hide( 'hello_header_menu_display' ) ); ?>">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $header_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>
		<!-- add Cart & Account -->
		<div class="header__icon-list">
			<div class="cart-icon">
				<svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M13.0677 0.501709C13.5049 0.58716 13.9511 0.64391 14.3772 0.762628C15.71 1.13692 16.8845 1.8963 17.7352 2.93368C18.5859 3.97106 19.0697 5.23408 19.1185 6.5446C19.1185 6.6007 19.1268 6.6568 19.133 6.74616H19.4097C20.1706 6.74616 20.9315 6.74616 21.6876 6.74616C22.2472 6.74616 22.5599 7.011 22.6035 7.53284C22.7598 9.43059 22.9134 11.3283 23.0642 13.2261C23.2487 15.4726 23.4317 17.7191 23.6134 19.9657C23.7407 21.5229 23.868 23.0799 23.9953 24.6368C24.034 25.1247 23.6819 25.4848 23.1652 25.4984C23.105 25.4984 23.0448 25.4984 22.984 25.4984H2.01701C1.26438 25.4984 0.953095 25.2049 1.00567 24.4965C1.12742 22.8742 1.26508 21.2526 1.39582 19.6304C1.52356 18.0405 1.65107 16.4508 1.77835 14.8614C1.92777 13.0124 2.07696 11.1642 2.22592 9.31687C2.27019 8.76503 2.31446 8.21384 2.3532 7.66134C2.39885 7.00513 2.68662 6.74812 3.38667 6.74812H5.83132C5.87697 6.37827 5.90049 6.01559 5.96967 5.65944C6.46911 2.95044 8.84873 0.842209 11.7306 0.546065C11.7978 0.535296 11.8644 0.520702 11.9298 0.502361L13.0677 0.501709ZM22.268 23.9271C21.8481 18.7087 21.4296 13.5138 21.0111 8.31038H19.1226V8.60195C19.1226 9.0253 19.1295 9.44994 19.1191 9.87133C19.1181 10.0649 19.0413 10.2513 18.9036 10.3949C18.7659 10.5385 18.5769 10.6291 18.3727 10.6495C18.1822 10.6657 17.9915 10.6192 17.8331 10.5181C17.6746 10.4169 17.5581 10.2673 17.5032 10.0944C17.4739 9.97605 17.4616 9.8545 17.4666 9.73304C17.4624 9.26469 17.4666 8.79569 17.4666 8.32864H7.51988C7.51988 8.83483 7.51988 9.32274 7.51988 9.81001C7.51988 10.1362 7.38153 10.3971 7.07647 10.5569C6.95293 10.6207 6.814 10.6532 6.67317 10.6515C6.53234 10.6497 6.3944 10.6136 6.27272 10.5467C6.15105 10.4798 6.04977 10.3844 5.97874 10.2697C5.9077 10.155 5.86931 10.025 5.86729 9.8922C5.85345 9.37428 5.86729 8.8557 5.86729 8.3319H3.96359C3.54854 13.5405 3.12865 18.7243 2.71014 23.9271H22.268ZM17.4721 6.73573C17.3822 4.97974 16.6095 3.60469 15.0129 2.728C13.2268 1.74956 11.4096 1.81479 9.69336 2.89173C8.26697 3.78995 7.57245 5.10237 7.51227 6.73573H17.4721Z" fill="white" stroke="white" stroke-width="0.5"/>
				</svg>
			</div>
			<div class="account">
				<svg width="65" height="60" viewBox="0 0 65 60" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M33.1466 17.6726C33.6659 17.7949 34.2035 17.8604 34.7009 18.0395C36.678 18.7587 37.9527 20.1695 38.4336 22.2066C39.0279 24.728 38.4086 26.9608 36.5578 28.8015C34.552 30.7964 31.2763 30.9603 29.0905 29.1642C27.0993 27.5277 26.3274 25.3824 26.6612 22.8506C26.9144 20.9315 27.8963 19.4559 29.5689 18.4658C30.2664 18.0627 31.0398 17.8093 31.8401 17.7215C31.9188 17.7117 31.9963 17.6891 32.0751 17.6726H33.1466ZM36.8281 24.0064C36.8189 22.7833 36.523 21.7938 35.8121 20.9627C34.8107 19.7953 33.5134 19.3611 32.0147 19.5427C30.7149 19.6999 29.6897 20.3408 29.0203 21.4801C27.9079 23.3759 28.3124 25.9945 29.9277 27.5032C31.3092 28.7942 33.2876 28.9599 34.8235 27.8701C36.1935 26.9021 36.7719 25.5102 36.8281 24.0064Z" fill="white" stroke="white" stroke-width="0.25"/>
				<path d="M32.6184 42.3274H22.097C21.3183 42.3274 20.9852 41.9672 20.9986 41.1795C21.0267 39.7607 21.2427 38.3786 21.7919 37.062C22.6608 34.9772 24.1717 33.5303 26.2074 32.6038C27.6665 31.9397 29.211 31.6314 30.7957 31.4932C32.2928 31.3592 33.8 31.3893 35.2906 31.5831C37.1945 31.8357 39.002 32.3696 40.5953 33.4924C42.4259 34.7821 43.5189 36.5611 43.9582 38.7345C44.1266 39.5662 44.1718 40.4255 44.2353 41.2755C44.2847 41.9415 43.8886 42.3268 43.2192 42.3268C39.6844 42.3272 36.1508 42.3274 32.6184 42.3274ZM42.3765 40.4927C42.3539 40.2689 42.3393 40.0598 42.3112 39.8525C42.1526 38.6856 41.8035 37.5855 41.1384 36.6051C40.2041 35.2255 38.8781 34.3938 37.3239 33.888C36.2255 33.5272 35.0868 33.3499 33.9329 33.2838C31.8532 33.1652 29.7949 33.2624 27.7995 33.926C26.6767 34.299 25.6637 34.8684 24.8247 35.7172C23.9673 36.5825 23.4254 37.6264 23.1295 38.7957C22.991 39.343 22.9257 39.9087 22.8244 40.4915L42.3765 40.4927Z" fill="white" stroke="white" stroke-width="0.25"/>
				</svg>

			</div>
		</div>
	</div>
</header>
