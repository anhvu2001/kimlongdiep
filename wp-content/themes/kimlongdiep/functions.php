<?php

/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0');

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles()
{

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20);


add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

function special_nav_class($classes, $item)
{
	if (in_array('current-menu-item', $classes)) {
		$classes[] = 'active ';
	}
	return $classes;
}
function theme_name_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Filter Product', 'theme-name'),
		'id'            => 'filter-product-sidebar',
		'description'   => __('Widget area for filtering products', 'theme-name'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}
add_action('widgets_init', 'theme_name_widgets_init');

function my_theme_enqueue_scripts()
{
	// Đăng ký và ti tệp JavaScript
	wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

//thêm nút mua tra góp
function custom_button_tra_gop()
{
	echo '<button type="submit" class="custom-button-cart-tra-gop"><i class="fa-solid fa-credit-card"> </i> Mua trả góp</button>';
}
add_action('woocommerce_after_add_to_cart_button', 'custom_button_tra_gop');


//them icon liên hệ để đưc tư vấn trang chi tiết sn phẩm
function lien_he_de_duoc_tu_van_icon()
{
?>
	<div class="container-icon-lien-he">
		<p class="icon-lien-he-text">Liên hệ để được tư vấn: </p>
		<div class="content_icon_lien_he">
			<div class="content_icon_lien_he_facebook">
				<a href="https://www.facebook.com/DiepNguyenJewellry"><i class="fa-brands fa-facebook" style="color: #0A68FE; font-size: 65px;"></i></a>
			</div>
			<div class="content_icon_lien_he_zalo">
				<a href="https://zalo.me/640281988805149775"><i style="color: #000000b5; font-size: 22px; font-weight: 700;  font-style: normal;">ZALO</i></a>
			</div>
		</div>
	</div>
	<?php
}
add_action('woocommerce_single_product_summary', 'lien_he_de_duoc_tu_van_icon', 35);

function change_add_to_cart_text($text)
{
	return 'Thêm vào giỏ hàng';
}
add_filter('woocommerce_product_single_add_to_cart_text', 'change_add_to_cart_text');

//chnh vị trí mã sn phẩm lên trên dưới 	
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7);


// xóa phn sn tưng t v thm phần sản theo categrory
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
function viewed_products()
{ // Lấy danh sch cc danh mc của sn phẩm
	$categories = get_the_terms(get_the_ID(), 'product_cat');
	if ($categories && !is_wp_error($categories)) {
		// Lấy thông tin của danh mục đu tiên
		$category = current($categories);
		$category_id = $category->term_id;
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'term_id',
					'terms' => $category_id,
				),
			),
		);
		$products = new WP_Query($args);
		// Kim tra nếu có sản phm trong danh mục
		if ($products->have_posts()) {
	?>
			<div class="title-product-child-detail">
				<p style="font-family: 'Montserrat'; font-style: normal; font-weight: 600;
				 font-size: 24px; line-height: 29px; display: flex; align-items: center; color: #FDCD81; margin: 0;">
					Sản phẩm <?php echo $category->name; ?> khác
				</p>
				<hr style="border: none; border-top: 2px solid #FDCD81; width: 54%;">
				<a href="<?php echo esc_url(get_term_link($category)); ?>" style="text-decoration: none;">Xem tất cả</a>
			</div>
			<div class="slidermain-featured owl-carousel owl-theme">
				<?php while ($products->have_posts()) {
					$products->the_post();
					$product = wc_get_product(get_the_ID());
					$product_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$product_name = $product->get_name();
					$product_price = $product->get_price_html();
					$product_permalink = $product->get_permalink();
				?>
					<a href="<?php echo esc_url($product_permalink); ?>" class="card-featured item">
						<div class="card-image">
							<img src="<?php echo $product_image[0]; ?>" alt="<?php echo $product_name; ?>">
						</div>
						<p class="card-nameproduct-featured viewed-nameproducts"><?php echo $product_name; ?></p>
                        <?php
						if ($category->term_id === 26) {
							// Lấy danh sách các thuộc tính toàn cục
							$global_attributes = wc_get_attribute_taxonomies();
							if (!empty($global_attributes)) {
								echo '<ul class="list-attributes-product">';
								foreach ($global_attributes as $attribute) {
									$attribute_name = wc_attribute_taxonomy_name($attribute->attribute_name);
									// Kiểm tra xem sản phẩm có sử dụng thuộc tính này không
									if (taxonomy_exists($attribute_name)) {
										// Lấy giá trị của thuộc tính cho sản phẩm
										$attribute_values = wc_get_product_terms(get_the_ID(), $attribute_name, array('fields' => 'names'));
										if (!empty($attribute_values)) {
											echo '<li>' . esc_html(implode(', ', $attribute_values)) . '</li>';
										}
									}
								}
								echo '</ul>';
							}
						}
						?>
						<p class="card-priceproduct-featured  viewed-priceproducts"><?php echo $product_price; ?></p>
					</a>
				<?php }
				?>
			</div>
			<script>
				jQuery(document).ready(function($) {
					$('.owl-carousel').owlCarousel({
						loop: true,
						margin: 20,
						dots: false,
						nav: true,
						autoplay: true,
						autoplayTimeout: 3000,
						autoplayHoverPause: true,
						navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
						responsive: {
							0: {
								items: 2
							},
							600: {
								items: 3
							},
							1000: {
								items: 4
							}
						}
					})
				});
			</script>
	<?php
			wp_reset_postdata();
		} else {
			echo 'Không có sản phẩmm trong danh mục này.';
		}
	} else {
		echo 'Sản phẩm không thuộc danh mục nào.';
	}
}
add_action('woocommerce_after_single_product_summary', 'viewed_products', 30);


function track_product_views()
{
	if (is_singular('product')) {
		global $post;
		$product_id = $post->ID;

		$viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode('|', $_COOKIE['woocommerce_recently_viewed']) : array();

		$viewed_products = array_diff($viewed_products, array($product_id));
		array_unshift($viewed_products, $product_id);
		$viewed_products = array_slice($viewed_products, 0, 4);

		setcookie('woocommerce_recently_viewed', implode('|', $viewed_products), time() + 3600, '/');
	}
}
add_action('template_redirect', 'track_product_views');


function product_recently_viewed()
{
	?>
	<div class="title-product-child-detail">
		<p style="font-family: 'Montserrat'; font-style: normal; font-weight: 600;
				 font-size: 24px; line-height: 29px; display: flex; align-items: center; color: #FDCD81;">
			Sản phẩm đã xem
		</p>
		<hr style="border: none; border-top: 2px solid #FDCD81; width: 78%;">
	</div>
	<div class="recented-product-detail-container">
		<?php
		$viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode('|', $_COOKIE['woocommerce_recently_viewed']) : array();
		foreach ($viewed_products as $product_id) {
			$product = wc_get_product($product_id);

			if (!$product) {
				continue; // Bỏ qua nu không tìm thy sn phẩm
			}

			$product_permalink = $product->get_permalink();
			$product_price = $product->get_price();
			$product_image = get_the_post_thumbnail_url($product_id, 'full');
          	$product_categories = wp_get_post_terms($product_id, 'product_cat');

			if (!$product_image) {
				$product_image = wc_placeholder_img_src('full'); // Đặt ảnh mặc đnh nếu không c ảnh
			}
		?>
			<div class="card-featured recented-product-detail-card">
				<div class="card-image">
					<a href="<?php echo esc_url($product_permalink); ?>" class="recented-product-detail-card-image">
						<img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
					</a>
				</div>
				<div class="recented-product-detail-card-info">
					<a href="<?php echo esc_url($product_permalink); ?>" class="recented-product-detail-card-name"><?php echo esc_html($product->get_name()); ?></a>
					<?php
					$global_attributes = wc_get_attribute_taxonomies();
					$is_hot_moissanite_category = false;
					foreach ($product_categories as $category) {
						if ($category->slug === 'kim-cuong-thien-nhien') {
							$is_hot_moissanite_category = true;
							break;
						}
					}
					if ($is_hot_moissanite_category && !empty($global_attributes)) {
						echo '<ul class="list-attributes-product">';
						foreach ($global_attributes as $attribute) {
							$attribute_name = wc_attribute_taxonomy_name($attribute->attribute_name);
							if (taxonomy_exists($attribute_name)) {
								$attribute_values = wc_get_product_terms($product_id, $attribute_name, array('fields' => 'names'));
								if (!empty($attribute_values)) {
									echo '<li>' . esc_html(implode(', ', $attribute_values)) . '</li>';
								}
							}
						}
						echo '</ul>';
					}
					?>
                  	<p>
						<?php echo $product_price ? '<a class="recented-product-detail-card-price" href="' . esc_url($product_permalink) . '">' . wp_kses_post(wc_price($product_price)) . '</a>' : ''; ?>
					</p>

				</div>
			</div>
		<?php
		}
		?>
	</div>
	<?php
}
add_action('woocommerce_after_single_product_summary', 'product_recently_viewed', 30);


// đi icon / thành icon > trn thanh breadcumb trang chi tit sn phm
function custom_woocommerce_breadcrumb_separator($defaults)
{
	$defaults['delimiter'] = '<i class="fa-solid fa-chevron-right">  </i>';
	return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumb_separator');

function add_image_size_product_detail($termSlug, $imagePath)
{
	if (has_term($termSlug, 'product_cat')) {
		$categoryName = get_term_by('slug', $termSlug, 'product_cat')->name;
	?>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				var cart = document.querySelector(".cart");
				var cartchild1 = document.querySelector(".cart .custom-button-cart-tra-gop");
				var cartchild2 = document.querySelector(".cart .single_add_to_cart_button");
				var bangSize = document.querySelector(".bang-size-image");
				var mainImage = document.querySelector(".woocommerce-product-gallery__image")
				console.log()
				cart.style.setProperty("flex-direction", "column");
				cartchild1.style.setProperty("width", "100%");
				cartchild2.style.setProperty("width", "100%");
				cartchild1.style.setProperty("margin", "10px 0 0 0");
				mainImage.style.setProperty("height", "550px");

				function setWidthBasedOnScreenSize() {
					if (window.innerWidth < 1024) {
						cartchild1.style.setProperty("width", "50%");
						cartchild2.style.setProperty("width", "50%");
						cart.style.setProperty("flex-direction", "unset");
						bangSize.style.setProperty("float", "unset");
					}
				}

				// Gi hm setWidthBasedOnScreenSize khi trang ưc ti và thay i kích thưc màn hình
				setWidthBasedOnScreenSize();
				window.addEventListener("resize", setWidthBasedOnScreenSize);
			});
		</script>
		<div class="bang-size-main">
			<p>Cách đo Size <?php echo $categoryName; ?>:</p>
			<a href="<?php echo get_site_url(); ?>/<?php echo $imagePath; ?>">
				<img class="bang-size-image" style="float: left; margin-right: 20px; width: 65%;" src="<?php echo get_site_url(); ?>/<?php echo $imagePath; ?>" alt="Bảng o Size">
			</a>

		</div>
	<?php
	}
}

add_action('woocommerce_single_product_summary', function () {
	add_image_size_product_detail('day-chuyen', 'wp-content/uploads/2023/05/bangsizedaychuyen.png');
	add_image_size_product_detail('lac-vong-tay', 'wp-content/uploads/2023/05/bangsizevong.png');
	add_image_size_product_detail('nhan', 'wp-content/uploads/2023/05/bangsizenhan.png');
}, 25);
// Thay đi nội dung placeholder nhp m m u đãi trong ô nhp m gim giá
function change_coupon_form_placeholder($translated_text, $text, $domain)
{
	if ($text === 'Coupon code' && $domain === 'woocommerce') {
		$translated_text = 'Nhập mã ưu đãi';
	}
	return $translated_text;
}
add_filter('gettext', 'change_coupon_form_placeholder', 10, 3);
//thay đi vị trí ca hình thc thanh ton
do_action('my_custom_action');
add_action('my_custom_action', 'woocommerce_checkout_payment', 20);
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
//thay đi vị tr ca hnh thức thanh toán
function custom_checkout_button()
{
	?> <button type="button" class="button-mua-tra-gop-page-thanh-toan">Mua trả góp</button>
	<?php
}
add_action('woocommerce_review_order_after_submit', 'custom_checkout_button');
// lay mo ta san pham trong trang chi tiet san pham
function get_short_description()
{
	global $product;

	if ($product) {
		$description = $product->get_description();
		if ($description) {
	?>
			<fieldset style="border: 1px solid rgba(255, 191, 65, 1); border-radius: 5px; margin-bottom: 20px;">
				<legend>Mô tả sản phẩm</legend>
				<p><?php echo $description ?></p>
			</fieldset>
<?php
		}
	}
}
add_action('woocommerce_single_product_summary', 'get_short_description', 22);
function enqueue_library_assets() {
	if ( is_page_template( 'page-sanpham.php' ) || is_tax( 'product_cat' )){
		 // Bao gồm file CSS
		 wp_enqueue_style( 'library-style', get_stylesheet_directory_uri() . '/nouislider/nouislider.min.css', array(), '1.0.0', 'all' );

		 // Bao gồm file JS
		 wp_enqueue_script( 'library-script', get_stylesheet_directory_uri() . '/nouislider/nouislider.min.js', array('jquery'), '1.0.0', false );
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_library_assets' );

function custom_header_code() {
    ?>
    <!-- Hotjar Tracking Code for https://kimlongdiep.com -->
    <!-- <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:3594177,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script> -->
    <?php
}
add_action( 'wp_head', 'custom_header_code' );

// Add style for Product page & category product

function enqueue_product_page_stylesheet() {
	if(is_page_template( 'page-sanpham.php' )||is_product_category()){
		wp_enqueue_style( 'product-page-style', get_stylesheet_directory_uri() . '/css/style_product.css' );
		wp_enqueue_script( 'product-page-script', get_stylesheet_directory_uri() . '/js/script_product_page.js', array(), '1.0.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_product_page_stylesheet' );

function add_security_headers() {
  header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
  header('X-Content-Type-Options: nosniff');
  header('X-Frame-Options: SAMEORIGIN');
  header('Content-Security-Policy: upgrade-insecure-requests');
}
add_action('send_headers', 'add_security_headers');
function remove_cart_noindex_meta() {
    if (is_cart()) {
        echo '<meta name="robots" content="index, follow" />' . "\n";
    }
}
add_action('wp_head', 'remove_cart_noindex_meta', 1);

function categrory_post()
{
	$labels = array(
		'name'               => __('Bài viết danh mục', 'text-domain'),
		'singular_name'      => __('Bài viết danh mục', 'text-domain'),
		'add_new'            => _x('Thêm bài viết danh mục', 'text-domain', 'text-domain'),
		'add_new_item'       => __('Thêm bài vit danh mục', 'text-domain'),
		'edit_item'          => __('Sửa bài viết danh mục', 'text-domain'),
		'new_item'           => __('New bài viết danh mục', 'text-domain'),
		'view_item'          => __('Xem bài viết danh mục', 'text-domain'),
		'search_items'       => __('Tìm bài viết danh mục', 'text-domain'),
		'not_found'          => __('Không tìm thấy bài viết danh mục', 'text-domain'),
		'not_found_in_trash' => __('Không tìm thấy bài viết danh mục', 'text-domain'),
		'parent_item_colon'  => __('', 'text-domain'),
		'menu_name'          => __('Bài viết danh mục', 'text-domain'),
	);
	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array('product_cat'),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-paperclip',
		'show_in_nav_menus'   => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => false,
		'capability_type'     => 'post',
		'supports'            => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'trackbacks',
			'comments',
			'revisions',
			'page-attributes',
			'post-formats',
		),
	);
	register_post_type('categrory_post', $args);
}

add_action('init', 'categrory_post');
function add_custom_meta_tags() {
    ?>
    <link rel="alternate" href="https://kimlongdiep.com/" hreflang="vi">
    <meta name="geo.region" content="VN-SG">
    <meta name="geo.placename" content="Ho Chi Minh">
    <meta name="geo.position" content="10.758576351746216, 106.6726572347974">
    <meta name="ICBM" content="10.758576351746216, 106.6726572347974">
    <?php
}
add_action('wp_head', 'add_custom_meta_tags');


function hotjar_script() {
    echo "<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:3594177,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>";
}
add_action("wp_head", "hotjar_script", 0);