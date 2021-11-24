<?php
/**
 * Support template.
 *
 * @package Barcodeman
 */

?>

<div class="wrap">

<?php
	$base_url = '?page=barcodeman-dashboard';
?>

<h2 class="nav-tab-wrapper barcodeman-tabs">
	<?php foreach ( $tabs as $tab_item ) : ?>

		<?php

		if ( isset( $_GET['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'view_tab' ) ) {
			$tab_value = ( isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '' );
		}

		$active = '';
		if ( ! empty( $tab_value ) && $tab_value === $tab_item['tab_url'] ) {
			$active = 'nav-tab-active';
		}
		if ( empty( $tab_value ) && '' === $tab_item['tab_url'] ) {
			$active = 'nav-tab-active';
		}

		$bare_url = $base_url . ( $tab_item['tab_url'] ? '&tab=' . $tab_item['tab_url'] : '' );
		$url      = wp_nonce_url( $bare_url, 'view_tab' );
		?>

		<a href="<?php echo esc_url( $url ); ?>" class="nav-tab <?php echo esc_attr( $active ); ?>"><?php echo esc_html( $tab_item['name'] ); ?></a>
	<?php endforeach; ?>
</h2>
