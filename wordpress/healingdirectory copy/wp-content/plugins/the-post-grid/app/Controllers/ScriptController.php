<?php
/**
 * Script Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers;

// Do not allow directly accessing this file.
use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Script Controller class.
 */
class ScriptController {

	/**
	 * Version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Settings
	 *
	 * @var array
	 */
	private $settings;

	/**
	 * Class construct
	 */
	public function __construct() {
		$this->version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : RT_THE_POST_GRID_VERSION;
		add_action( 'wp_head', [ $this, 'header_scripts' ] );
		add_action( 'admin_head', [ $this, 'admin_header_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'init', [ $this, 'init' ] );
	}

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init() {
		//phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$current_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		if ( 'rttpg_settings' === $current_page ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}

		// register scripts.
		$scripts = [];
		$styles  = [];

		$scripts[] = [
			'handle' => 'rt-isotope-js',
			'src'    => rtTPG()->get_assets_uri( 'vendor/isotope/isotope.pkgd.min.js' ),
			'deps'   => [ 'jquery' ],
			'footer' => true,
		];

		$scripts[] = [
			'handle' => 'rt-tpg',
			'src'    => rtTPG()->get_assets_uri( 'js/rttpg.js' ),
			'deps'   => [ 'jquery' ],
			'footer' => true,
		];

		$scripts[] = [
			'handle' => 'rt-select2',
			'src'    => rtTPG()->get_assets_uri( 'vendor/select2/select2.min.js' ),
			'deps'   => [ 'jquery' ],
			'footer' => false,
		];

		// register acf styles.
		$styles['rt-fontawsome'] = rtTPG()->get_assets_uri( 'vendor/font-awesome/css/font-awesome.min.css' );

		if ( Fns::tpg_option( 'tpg_icon_font' ) === 'flaticon' ) {
			$styles['rt-flaticon'] = rtTPG()->get_assets_uri( 'vendor/flaticon/flaticon_the_post_grid.css' );
		}

		// Plugin specific css.
		$styles['rt-tpg']           = rtTPG()->tpg_can_be_rtl( 'css/thepostgrid' );
		$styles['rt-tpg-block']     = rtTPG()->tpg_can_be_rtl( 'css/tpg-block' );
		$styles['rt-tpg-shortcode'] = rtTPG()->tpg_can_be_rtl( 'css/tpg-shortcode' );
		$styles['rt-select2']       = rtTPG()->get_assets_uri( 'vendor/select2/select2.min.css' );

		if ( is_admin() ) {
			$scripts[]                      = [
				'handle' => 'rt-tpg-admin',
				'src'    => rtTPG()->get_assets_uri( 'js/admin.js' ),
				'deps'   => [ 'jquery', 'wp-color-picker', 'jquery-ui-sortable' ],
				'footer' => true,
			];
			$scripts[]                      = [
				'handle' => 'rt-tpg-admin-preview',
				'src'    => rtTPG()->get_assets_uri( 'js/admin-preview.js' ),
				'deps'   => [ 'jquery' ],
				'footer' => true,
			];
			$styles['rt-tpg-admin']         = rtTPG()->get_assets_uri( 'css/admin/admin.css' );
			$styles['rt-tpg-admin-preview'] = rtTPG()->get_assets_uri( 'css/admin/admin-preview.css' );
		}

		foreach ( $scripts as $script ) {
			wp_register_script( $script['handle'], $script['src'], $script['deps'], isset( $script['version'] ) ? $script['version'] : $this->version, $script['footer'] );
		}

		foreach ( $styles as $k => $v ) {
			wp_register_style( $k, $v, false, isset( $script['version'] ) ? $script['version'] : $this->version );
		}
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 */
	public function enqueue() {
		$settings         = get_option( rtTPG()->options['settings'] );
		$block_type       = Fns::tpg_option( 'tpg_block_type', 'default' );
		$load_script_type = Fns::tpg_option( 'tpg_load_script' );

		wp_enqueue_script( 'jquery' );

		if ( ! $load_script_type ) {
			wp_enqueue_style( 'rt-fontawsome' );
			wp_enqueue_style( 'rt-flaticon' );

			if ( 'default' === $block_type ) {
				wp_enqueue_style( 'rt-tpg' );
			}

			if ( 'elementor' === $block_type ) {
				wp_enqueue_style( 'rt-tpg-block' );
			}

			if ( 'shortcode' === $block_type ) {
				wp_enqueue_style( 'rt-tpg-shortcode' );
			}
		}

		$scriptBefore = isset( $settings['script_before_item_load'] ) ? stripslashes( $settings['script_before_item_load'] ) : null;
		$scriptAfter  = isset( $settings['script_after_item_load'] ) ? stripslashes( $settings['script_after_item_load'] ) : null;
		$scriptLoaded = isset( $settings['script_loaded'] ) ? stripslashes( $settings['script_loaded'] ) : null;

		$script = "(function($){
						$('.rt-tpg-container').on('tpg_item_before_load', function(){{$scriptBefore}});
						$('.rt-tpg-container').on('tpg_item_after_load', function(){{$scriptAfter}});
						$('.rt-tpg-container').on('tpg_loaded', function(){{$scriptLoaded}});
					})(jQuery);";
		wp_add_inline_script( 'rt-tpg', $script );
	}

	public function admin_frontend_script() {
		$settings = get_option( rtTPG()->options['settings'] );
		?>
        <style>
            :root {
                --tpg-primary-color: <?php echo isset( $settings['tpg_primary_color_main'] ) ? sanitize_hex_color( $settings['tpg_primary_color_main'] ) : '#0d6efd'; ?>;
                --tpg-secondary-color: <?php echo isset( $settings['tpg_secondary_color_main'] ) ? sanitize_hex_color( $settings['tpg_secondary_color_main'] ) : '#0654c4'; ?>;
                --tpg-primary-light: #c4d0ff
            }

            <?php if ( isset( $settings['tpg_loader_color'] ) ) : ?>
            body .rt-tpg-container .rt-loading,
            body #bottom-script-loader .rt-ball-clip-rotate {
                color: <?php echo sanitize_hex_color( $settings['tpg_loader_color'] ); ?> !important;
            }

            <?php endif; ?>
        </style>
		<?php
	}

	public function admin_header_scripts() {
		$this->admin_frontend_script();
	}

	/**
	 * Header Scripts
	 *
	 * @return void
	 */
	public function header_scripts() {
		$settings = get_option( rtTPG()->options['settings'] );

		$this->admin_frontend_script();
		if ( isset( $settings['tpg_load_script'] ) ) :
			?>
            <style>
                .rt-container-fluid {
                    position: relative;
                }

                .rt-tpg-container .tpg-pre-loader {
                    position: relative;
                    overflow: hidden;
                }

                .rt-tpg-container .rt-loading-overlay {
                    opacity: 0;
                    visibility: hidden;
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 1;
                    background-color: #fff;
                }

                .rt-tpg-container .rt-loading {
                    color: var(--tpg-primary-color);
                    position: absolute;
                    top: 40%;
                    left: 50%;
                    margin-left: -16px;
                    z-index: 2;
                    opacity: 0;
                    visibility: hidden;
                }

                .rt-tpg-container .tpg-pre-loader .rt-loading-overlay {
                    opacity: 0.8;
                    visibility: visible;
                }

                .tpg-carousel-main .tpg-pre-loader .rt-loading-overlay {
                    opacity: 1;
                }

                .rt-tpg-container .tpg-pre-loader .rt-loading {
                    opacity: 1;
                    visibility: visible;
                }


                #bottom-script-loader {
                    position: absolute;
                    width: calc(100% + 60px);
                    height: calc(100% + 60px);
                    z-index: 999;
                    background: rgba(255, 255, 255, 0.95);
                    margin: -30px;
                }

                #bottom-script-loader .rt-ball-clip-rotate {
                    color: var(--tpg-primary-color);
                    position: absolute;
                    top: 80px;
                    left: 50%;
                    margin-left: -16px;
                    z-index: 2;
                }

                .tpg-el-main-wrapper.loading {
                    min-height: 300px;
                    transition: 0.4s;
                }

                .tpg-el-main-wrapper.loading::before {
                    width: 32px;
                    height: 32px;
                    display: inline-block;
                    float: none;
                    border: 2px solid currentColor;
                    background: transparent;
                    border-bottom-color: transparent;
                    border-radius: 100%;
                    -webkit-animation: ball-clip-rotate 0.75s linear infinite;
                    -moz-animation: ball-clip-rotate 0.75s linear infinite;
                    -o-animation: ball-clip-rotate 0.75s linear infinite;
                    animation: ball-clip-rotate 0.75s linear infinite;
                    left: 50%;
                    top: 50%;
                    position: absolute;
                    z-index: 9999999999;
                    color: red;
                }


                .rt-tpg-container .slider-main-wrapper,
                .tpg-el-main-wrapper .slider-main-wrapper {
                    opacity: 0;
                }

                .md-modal {
                    visibility: hidden;
                }

                .md-modal.md-show {
                    visibility: visible;
                }

                .builder-content.content-invisible {
                    visibility: hidden;
                }

                .rt-tpg-container > *:not(.bottom-script-loader, .slider-main-wrapper) {
                    opacity: 0;
                }

                .rt-popup-content .rt-tpg-container > *:not(.bottom-script-loader, .slider-main-wrapper) {
                    opacity: 1;
                }

            </style>

            <script>
                jQuery(document).ready(function () {
                    setTimeout(function () {
                        jQuery('.rt-tpg-container > *:not(.bottom-script-loader, .slider-main-wrapper)').animate({ 'opacity': 1 })
                    }, 100)
                })

                jQuery(window).on('elementor/frontend/init', function () {
                    if (elementorFrontend.isEditMode()) {
                        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
                            jQuery('.rt-tpg-container > *:not(.bottom-script-loader, .slider-main-wrapper)').animate({ 'opacity': 1 })
                        })
                    }
                })
            </script>
		<?php
		endif;
	}

}
