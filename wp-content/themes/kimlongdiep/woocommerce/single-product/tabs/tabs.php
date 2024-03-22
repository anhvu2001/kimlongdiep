<?php

/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
?>
<div class="woocommerce-tabs wc-tabs-wrapper" style="display: flex; gap: 30px; flex-wrap: wrap;">
	<div class="woocommerce-tabs-icon-content">
		<img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/price-tag.png" alt="Kim Long Diệp">
		<p>Giá tham khảo, giá sản phẩm thay đổi tuỳ trọng lượng vàng và đá</p>
	</div>
	<div class="woocommerce-tabs-icon-content">
      	<img class="mdi-star-four-points" style="width: 20px; height: 20px; margin-right: 30px;" src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/mdi_star-four-points.png" alt="Kim Long Diệp">
		<img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/airplance.png" alt="Kim Long Diệp">
		<p>Miễn phí giao hàng trên toàn quốc</p>
	</div>
	<div class="woocommerce-tabs-icon-content">
        <img class="mdi-star-four-points" style="width: 20px; height: 20px; margin-right: 30px;" src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/mdi_star-four-points.png" alt="Kim Long Diệp">
		<img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/jewery-store.png" alt="Kim Long Diệp">
		<p style= "padding-top: 0px;">Bảo hành gắn hột trọn đời</p>
	</div>
	<div class="woocommerce-tabs-icon-content">
        <img class="mdi-star-four-points" style="width: 20px; height: 20px; margin-right: 30px;" src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/mdi_star-four-points.png" alt="Kim Long Diệp">
		<img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/05/material-water.png" alt="Kim Long Diệp">
		<p style= "padding-top: 35px;">Làm sạch trang sức trọn đời bằng máy siêu âm sóng nước</p>
	</div>
	<?php do_action('woocommerce_product_after_tabs'); ?>
</div>
<?php