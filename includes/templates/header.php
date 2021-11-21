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

		$active = '';
		if ( ! empty( $_GET['tab'] ) && $_GET['tab'] === $tab_item['tab_url'] ) {
			$active = 'nav-tab-active';
		}
		if ( empty( $_GET['tab'] ) && '' === $tab_item['tab_url'] ) {
			$active = 'nav-tab-active';
		}
		?>

	<a href="<?php echo esc_url( $base_url . ( $tab_item['tab_url'] ? '&tab=' . $tab_item['tab_url'] : '' ) ); ?>" class="nav-tab <?php echo esc_attr( $active ); ?>"><?php echo esc_html( $tab_item['name'] ); ?></a>
	<?php endforeach; ?>
</h2>
