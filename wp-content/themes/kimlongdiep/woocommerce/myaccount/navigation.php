<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<?php
			$icon_class = '';
			switch ($endpoint) {
				case 'dashboard':
					$icon_class = 'fas fa-tachometer-alt';
					break;
				case 'orders':
					$icon_class = 'fas fa-shopping-cart';
					break;
				case 'downloads':
					$icon_class = 'fa-solid fa-download';
					break;
				case 'edit-address':
					$icon_class = 'fa-regular fa-address-book';
					break;
				case 'edit-account':
					$icon_class = 'fa-regular fa-user';
					break;
				case 'customer-logout':
					$icon_class = 'fa-solid fa-arrow-right-from-bracket';
					break;
			}
			?>
			<li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
				<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
					<i style="margin-right: 10px;" class="<?php echo esc_attr($icon_class); ?>"></i>
					<?php echo esc_html($label); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>