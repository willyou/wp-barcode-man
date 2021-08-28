<div class="barcodeman-connect">

    <div class="barcodeman-connect-inner">

        <h1><?php esc_html_e('Connect to Barcodeman', 'barcodeman'); ?></h1>

        <?php
        if ( ! empty( $issues ) ) {
            ?>
            <p><?php esc_html_e('To connect your store to Barcode Man, fix the following errors:', 'barcodeman'); ?></p>
            <div class="barcodeman-notice">
                <ul>
                    <?php
                    foreach ( $issues as $issue ) {
                        echo '<li>' . wp_kses_post( $issue ) . '</li>';
                    }
                    ?>
                </ul>
            </div>
            <?php
            $url = '#';
        } else {
            ?><p class="connect-description"><?php esc_html_e('You\'re almost done! Just 2 more steps to have your WooCommerce store connected to Barcode Man for automatic order fulfillment.', 'barcodeman'); ?></p><?php
        }

        echo '<a href="' . esc_url($url) . '" class="button button-primary barcodeman-connect-button ' . ( ! empty( $issues ) ? 'disabled' : '' ) . '" target="_blank">' . esc_html__('Connect', 'barcodeman') . '</a>';
        ?>

        <img src="<?php echo esc_url( admin_url( 'images/spinner-2x.gif' ) ) ?>" class="loader hidden" width="20px" height="20px" alt="loader"/>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                Barcode Man_Connect.init('<?php echo esc_url( admin_url( 'admin-ajax.php?action=ajax_force_check_connect_status' ) ); ?>');
            });
        </script>
    </div>
</div>
