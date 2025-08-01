<?php
/**
 * Notice Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers\Admin\Notice;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Notice Controller class.
 */
class SummerSale {

	/**
	 * Class Constructor
	 */
	public function __construct() {
		add_action( 'admin_notices', [ __CLASS__, 'summer_special_deal_admin_notice' ] );
		add_action( 'wp_ajax_dismiss_summer_notice', [ __CLASS__, 'dismiss_summer_notice' ] );
	}

	public static function summer_special_deal_admin_notice() {
		// Set expiration date (April 7)
		$expiration_date = strtotime( 'May 31, 2025' );

		// Check if the current date is past the expiration date
		if ( time() > $expiration_date ) {
			return;
		}

		// Check if notice is dismissed
		if ( get_user_meta( get_current_user_id(), 'dismissed_summer_notice', true ) ) {
			return;
		}


		$plugin_name   = 'The Post Grid';
		$download_link = 'https://www.radiustheme.com/downloads/the-post-grid-pro-for-wordpress/';

		?>


        <div class="notice notice-info is-dismissible summer-notice" data-rttpg-dismissable="rttpg_dismiss_bf_notice"
             style="display:grid !important;grid-template-columns: 100px auto;padding-top: 25px; padding-bottom: 22px;">
            <img alt="<?php echo esc_attr( $plugin_name ); ?>"
                 src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/post-grid-gif.gif' ) ); ?>"
                 width="74px" height="74px" style="grid-row: 1 / 4; align-self: center;justify-self: center"/>
            <h3 style="margin:0;display: inline-flex;align-items: center;gap: 4px;">
				<?php echo sprintf( ' %s – ☀️ Summer Sale', esc_html( $plugin_name ) ); ?>
                <img alt="Deal" style="width: 60px;position: static" src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/deal.gif' ) ); ?>">
            </h3>
            <p style="margin-top: 0; font-size: 14px;">
                <strong>Hot Summer Deals:</strong>
                Beat the heat with cool discounts on
                <b><a href="<?php echo esc_url( $download_link ); ?>" style="text-decoration: none;color: inherit">The Post Grid</a></b>. Save
                <b style="display:inline-block;color: white;background:red;padding: 0 8px;border-radius:3px; transform: skewX(-10deg);">UP TO 40%</b>
                for a limited time! ☀️🔥🌴
            </p>
            <p style="margin:0;">
                <a class="button button-primary" href="<?php echo esc_url( $download_link ); ?>"
                   style="background: #4e13ff;"
                   target="_blank">Buy Now</a>
            </p>
        </div>


        <script>
            jQuery(document).on('click', '.summer-notice .notice-dismiss', function () {
                jQuery.post(ajaxurl, {
                    action: 'dismiss_summer_notice',
                    security: '<?php echo wp_create_nonce( "dismiss_summer_notice" ); ?>',
                })
            })
        </script>
		<?php
	}

	public static function dismiss_summer_notice() {
		check_ajax_referer( 'dismiss_summer_notice', 'security' );
		update_user_meta( get_current_user_id(), 'dismissed_summer_notice', true );
		wp_die();
	}

}