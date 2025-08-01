<?php
/**
 * Base Abstract Class
 *
 * @package RT_TPG
 */

use Elementor\Widget_Base;
use RT\ThePostGrid\Helpers\Fns;
use RT\ThePostGrid\Helpers\Options;


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Base Abstract Class
 */
abstract class Custom_Widget_Base extends Widget_Base {
	public $tpg_name;
	public $tpg_base;
	public $tpg_category;
	public $tpg_archive_category;
	public $tpg_icon;
	public $tpg_dir;
	public $tpg_pro_dir;
	public $is_post_layout;
	public $pro_label;
	public $get_pro_message;
	public $prefix;
	public $last_post_id;

	/**
	 * Class Constructor
	 * @param $data
	 * @param $args
	 *
	 * @throws Exception
	 */
	public function __construct( $data = [], $args = null ) {
		$this->tpg_category         = RT_THE_POST_GRID_PLUGIN_SLUG . '-elements'; // Category /@dev.
		$this->tpg_archive_category = 'tpg-block-builder-widgets';
		$this->tpg_icon             = 'eicon-gallery-grid tpg-grid-icon';
		$this->tpg_dir              = dirname( ( new ReflectionClass( $this ) )->getFileName() );
		$this->tpg_pro_dir          = null;
		$this->pro_label            = null;
		$this->is_post_layout       = null;
		$this->get_pro_message      = null;
		$this->last_post_id         = Fns::get_last_post_id();

		if ( ! rtTPG()->hasPro() ) {
			$this->pro_label       = sprintf( '<span class="tpg-pro-label">%s</span>', esc_html__( 'Pro', 'the-post-grid' ) );
			$this->is_post_layout  = ' the-post-grid-pro-needed';
			$this->get_pro_message = 'Please <a target="_blank" href="' . esc_url( rtTpg()->proLink() ) . '">upgrade</a> to pro for more options';
		}

		parent::__construct( $data, $args );
	}

	/**
	 * Get Pro Message with markup
	 *
	 * @param $message
	 *
	 * @return string|void
	 */
	public function get_pro_message( $message = 'more options.' ) {
		if ( rtTPG()->hasPro() ) {
			return;
		}

		return 'Please <a target="_blank" href="' . esc_url( rtTpg()->proLink() ) . '">upgrade</a> to pro for ' . esc_html( $message );
	}

	/**
	 * Get Name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->tpg_base;
	}

	/**
	 * Get Title
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->tpg_name;
	}

	/**
	 * Get Icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return $this->tpg_icon;
	}

	/**
	 * Get Categories
	 *
	 * @return string[]
	 */
	public function get_categories() {
		return [ $this->tpg_category ];
	}

	/**
	 * Return Pro Label
	 *
	 * @return string
	 */
	public function pro_label() {
		if ( ! rtTPG()->hasPro() ) {
			return esc_html__( '[Pro]', 'the-post-grid' );
		}

		return '';
	}
}
