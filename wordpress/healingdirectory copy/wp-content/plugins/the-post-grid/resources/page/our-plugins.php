<?php
/**
 * Get Help Page
 *
 * @package RT_TPG
 */

// Do not allow directly accessing this file.
use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Get Help
 */
?>


<div class="rttpg-our-plugins-wrapper">
    <header class="title-section">
        <h1>Unlock the Full Potential of Your WordPress Site</h1>
        <p>Discover feature-rich plugins built to extend WordPress, Gutenberg, Elementor, and WooCommerce with seamless functionality.</p>
    </header>

    <div class="rttpg-plugins-row">


        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/classified-listing.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Classified Listing – Classified ads & Business Directory Plugin</h3>
            <div class="rt-plugin-excerpt">
                Classified Listing classified ads Business Directory plugin comes with all the features necessary for building a classified listing website.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'classified-listing' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/classified-listing/" class="documentation">Documentation</a>
            </footer>
        </div>

        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/shopbuilder.png' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">ShopBuilder – Elementor WooCommerce Builder Addons</h3>
            <div class="rt-plugin-excerpt">
                ShopBuilder is a powerful WooCommerce Builder for Elementor that lets you easily create custom WooCommerce pages with a drag and drop interface.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'shopbuilder' ); ?>
                <a target="_blank" href="https://shopbuilderwp.com/docs/" class="documentation">Documentation</a>
            </footer>
        </div>

        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/food-menu.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Food Menu – Restaurant Menu & Online Ordering for WooCommerce</h3>
            <div class="rt-plugin-excerpt">
                Food Menu is a simple WordPress restaurant menu plugin that can use to display food menu of a restaurant or can use for online order using Woocommerce.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'tlp-food-menu' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/food-menu/" class="documentation">Documentation</a>
            </footer>
        </div>

        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/variation-swatches.png' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Variation Swatches for WooCommerce</h3>
            <div class="rt-plugin-excerpt">
                Woocommerce variation swatches plugin converts the product variation select fields into radio, images, colors, and labels.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'woo-product-variation-swatches' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/variation-swatches/" class="documentation">Documentation</a>
            </footer>
        </div>


        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/variation-gallery.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Variation Images Gallery for WooCommerce</h3>
            <div class="rt-plugin-excerpt">
                Variation Images Gallery for WooCommerce plugin allows to add UNLIMITED additional images for each variation of product.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'woo-product-variation-gallery' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/variation-gallery/" class="documentation">Documentation</a>
            </footer>
        </div>

        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/testimonials.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Testimonial – Testimonial Slider and Showcase Plugin</h3>
            <div class="rt-plugin-excerpt">
                Testimonial Slider and Showcase plugin for WordPress website. It is a developer and user-friendly testimonial plugin that facilitates easy management of customer testimonials.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'testimonial-slider-and-showcase' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/testimonial-slider/" class="documentation">Documentation</a>
            </footer>
        </div>


        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/team.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Team – Team Members Showcase Plugin</h3>
            <div class="rt-plugin-excerpt">
                Team is the WordPress team plugin that facilitates the display of your team members on your site. It is fully responsive and mobile friendly, which guarantees the views across all devices.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'tlp-team' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/team/" class="documentation">Documentation</a>
            </footer>
        </div>

        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/portfolio.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Portfolio – WordPress Portfolio Plugin</h3>
            <div class="rt-plugin-excerpt">
                Best WordPress Portfolio Plugin for WordPress to display your portfolio work in grid, filterable portfolio and slider view.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'tlp-portfolio' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/portfolio/" class="documentation">Documentation</a>
            </footer>
        </div>

        <div class="card rt-plugin-item">
            <img src="<?php echo esc_url( rtTPG()->get_assets_uri( 'images/our-plugins/review-schema.gif' ) ); ?>" alt="client1">
            <h3 class="rt-plugin-title">Review Schema – Review & Structure Data Schema Plugin</h3>
            <div class="rt-plugin-excerpt">
                WordPress Review Plugin with JSON-LD based Structure Data Schema solution for your website. Add Schema.org Structured Data to enhance your website in Google Search Results.
            </div>
            <footer>
				<?php Fns::get_plugin_install_button( 'review-schema' ); ?>
                <a target="_blank" href="https://www.radiustheme.com/docs/review-schema/" class="documentation">Documentation</a>
            </footer>
        </div>

    </div>

</div>
