<?php

add_action('wp', function () {
	if (! get_theme_mod('blocksy_has_checkout_coupon', false)) {
		remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
	}
});

if (! class_exists('FluidCheckout')) {
	add_action('woocommerce_checkout_before_customer_details', function () {
		echo '<div class="ct-customer-details">';
	}, PHP_INT_MIN);

	add_action('woocommerce_checkout_after_customer_details', function () {
		echo '</div>';
	}, PHP_INT_MAX);

	add_action('woocommerce_checkout_before_order_review_heading', function () {
		echo '<div class="ct-order-review">';
	}, PHP_INT_MIN);

	add_action('woocommerce_checkout_after_order_review', function () {
		echo '</div>';
	}, PHP_INT_MAX);
}

add_action(
	'woocommerce_before_template_part',
	function ($template_name, $template_path, $located, $args) {
		if (! class_exists('Woocommerce_German_Market')) {
			return;
		}

		if ($template_name !== 'checkout/form-checkout.php') {
			return;
		}

		ob_start();
	},
	1,
	4
);

add_action(
	'woocommerce_after_template_part',
	function ($template_name, $template_path, $located, $args) {
		if (! class_exists('Woocommerce_German_Market')) {
			return;
		}

		if ($template_name !== 'checkout/form-checkout.php') {
			return;
		}

		$result = ob_get_clean();

		$search = '/' . preg_quote('<h3 id="order_review_heading">', '/') . '/';

		echo preg_replace(
			$search,
			'<div class="ct-order-review"><h3 id="order_review_heading">',
			$result,
			1
		);
	},
	1,
	4
);
