<?php
/**
 * Grid Layout Class
 *
 * @package RT_TPG
 */

use Elementor\Controls_Manager;
use RT\ThePostGrid\Helpers\Fns;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Grid Layout Class
 */
class TPGPostTimeline extends Custom_Widget_Base {

	/**
	 * GridLayout constructor.
	 *
	 * @param array $data
	 * @param null $args
	 *
	 * @throws \Exception
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		$this->prefix   = 'timeline';
		$this->tpg_name = esc_html__( 'TPG - Post Timeline', 'the-post-grid' );
		$this->tpg_base = 'tpg-post-timeline';
		$this->tpg_icon = 'eicon-time-line tpg-grid-icon'; // .tpg-grid-icon class for just style
	}


	public function get_script_depends() {
		$scripts = [];
		array_push( $scripts, 'imagesloaded' );
		array_push( $scripts, 'rt-tpg' );
//		array_push( $scripts, 'rttpg-block-pro' );

		return $scripts;
	}

	public function get_style_depends() {
		$settings = get_option( rtTPG()->options['settings'] );
		$style    = [];

		if ( isset( $settings['tpg_load_script'] ) ) {
			array_push( $style, 'rt-fontawsome' );
			array_push( $style, 'rt-flaticon' );
			array_push( $style, 'rt-tpg-block' );
		}

		return $style;
	}

	/**
	 * Hidden some fields from the widget
	 *
	 * @param $ref
	 *
	 * @return void
	 */
	public function hidden_fields() {

		$hidden_fields = [
			'show_taxonomy_filter',
			'show_author_filter',
			'show_order_by',
			'show_sort_order',
			'show_search',
			'filter_btn_style',
		];
		foreach ( $hidden_fields as $item ) {
			$this->add_control(
				$item,
				[
					'type'    => Controls_Manager::HIDDEN,
					'default' => 'no',
				]
			);
		}
	}

	/**
	 * Grid Layout Settings
	 *
	 * @param $ref
	 */
	public function grid_layouts() {
		$prefix = $this->prefix;

		$this->start_controls_section(
			$prefix . '_layout_settings',
			[
				'label' => esc_html__( 'Layout', 'the-post-grid' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->hidden_fields();

		$layout_class = 'timeline-layout';

		$this->add_control(
			$prefix . '_layout',
			[
				'label'          => esc_html__( 'Choose Layout', 'the-post-grid' ),
				'type'           => Controls_Manager::CHOOSE,
				'label_block'    => true,
				'options'        => [
					$prefix . '-layout1' => [
						'title' => esc_html__( 'Layout 1', 'the-post-grid' ),
					],
					$prefix . '-layout2' => [
						'title' => esc_html__( 'Layout 2', 'the-post-grid' ),
					],
					$prefix . '-layout3' => [
						'title' => esc_html__( 'Layout 3', 'the-post-grid' ),
					],
					$prefix . '-layout4' => [
						'title' => esc_html__( 'Layout 4', 'the-post-grid' ),
					],
				],
				'toggle'         => false,
				'default'        => $prefix . '-layout1',
				'style_transfer' => true,
				'classes'        => 'tpg-image-select ' . $layout_class . ' ' . $this->is_post_layout,
			]
		);

		$tag_type = Fns::timeline_tag_type();

		foreach ( $tag_type as $post_type => $args ) {
			$this->add_control(
				$post_type . '_tag_type',
				[
					'label'     => esc_html__( 'Choose Tag Type', 'the-post-grid' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => $args,
					'default'   => 'date',
					'condition' => [
						'post_type' => $post_type,
					],
				]
			);
		}

		$this->add_control(
			'timeline_layout_style',
			[
				'label'        => esc_html__( 'Layout Orientation', 'the-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'vertical',
				'options'      => [
					'vertical'    => esc_html__( 'Vertical', 'the-post-grid' ),
					'style-left'  => esc_html__( 'Left Side', 'the-post-grid' ),
					'style-right' => esc_html__( 'Right Side', 'the-post-grid' ),
				],
				'prefix_class' => 'timeline-',
			]
		);

		$this->add_control(
			'timeline_animation',
			[
				'label'   => esc_html__( 'Animation', 'the-post-grid' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'flip-left'  => esc_html__( 'Flip Left', 'the-post-grid' ),
					'flip-right' => esc_html__( 'Flip Right', 'the-post-grid' ),
					'scale-up'   => esc_html__( 'Scale Up', 'the-post-grid' ),
					'fade-in'    => esc_html__( 'Fade In', 'the-post-grid' ),
					'fade-in-up' => esc_html__( 'Fade In Up', 'the-post-grid' ),
					'slide-up'   => esc_html__( 'Side Up', 'the-post-grid' ),
					'none'       => esc_html__( 'No Animation', 'the-post-grid' ),
				],
			]
		);

		$this->add_control(
			'timeline_title_style',
			[
				'label'        => esc_html__( 'Tag Title Style', 'the-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => [
					'default' => esc_html__( 'Default', 'the-post-grid' ),
					'circle'  => esc_html__( 'Circle', 'the-post-grid' ),
					'left'    => esc_html__( 'Left Side', 'the-post-grid' ),
					'right'   => esc_html__( 'Right Side', 'the-post-grid' ),
				],
				'prefix_class' => 'tag-title-',
			]
		);

		$this->add_control(
			'timeline_icon_shape',
			[
				'label'        => esc_html__( 'Navigate Icon Shape', 'the-post-grid' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '1',
				'options'      => [
					'1' => esc_html__( 'Default Arrow', 'the-post-grid' ),
					'2' => esc_html__( 'Arrow 2', 'the-post-grid' ),
				],
				'prefix_class' => 'timeline-icon-',
			]
		);

		$this->add_control(
			'layout_options_heading',
			[
				'label'   => esc_html__( 'Layout Options:', 'the-post-grid' ),
				'type'    => Controls_Manager::HEADING,
				'classes' => 'tpg-control-type-heading',
			]
		);

		$this->add_responsive_control(
			'full_wrapper_align',
			[
				'label'        => esc_html__( 'Text Align', 'the-post-grid' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'the-post-grid' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'the-post-grid' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'the-post-grid' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'tpg-wrapper-align-',
				'render_type'  => 'template',
				'toggle'       => true,
				'selectors'    => [
					'{{WRAPPER}} .tpg-post-holder div'               => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .rt-tpg-container .rt-el-post-meta' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Timeline Style
	 *
	 * @return void
	 */
	public function timeline_style() {

		$this->start_controls_section(
			'timeline_style',
			[
				'label' => esc_html__( 'Timeline Style', 'the-post-grid' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tag_title_style_heading',
			[
				'label'   => esc_html__( 'Tag Title:', 'the-post-grid' ),
				'type'    => Controls_Manager::HEADING,
				'classes' => 'tpg-control-type-heading',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'tag_title_borer',
				'selector' => '{{WRAPPER}} .tpg-timeline-container .tag-timeline-title .timeline-title',
			]
		);

		$this->add_responsive_control(
			'tag_title_border_radius',
			[
				'label'              => esc_html__( 'Border Radius', 'the-post-grid' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'allowed_dimensions' => 'all',
				'selectors'          => [
					'{{WRAPPER}} .tpg-timeline-container .tag-timeline-title .timeline-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tag_title_color',
			[
				'label'     => esc_html__( 'Tag Title Color', 'the-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tpg-timeline-container .tag-timeline-title .timeline-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tag_title_bg',
			[
				'label'     => esc_html__( 'Tag Title Background', 'the-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tpg-timeline-container .tag-timeline-title .timeline-title' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_arrow_style_heading',
			[
				'label'   => esc_html__( 'Indicator Arrow:', 'the-post-grid' ),
				'type'    => Controls_Manager::HEADING,
				'classes' => 'tpg-control-type-heading',
			]
		);

		$this->add_control(
			'indicator_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'the-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tpg-timeline-container .timeline-arrow' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'vertical_line_style_heading',
			[
				'label'   => esc_html__( 'Vertical Line:', 'the-post-grid' ),
				'type'    => Controls_Manager::HEADING,
				'classes' => 'tpg-control-type-heading',
			]
		);

		$this->add_control(
			'vertical_line_width',
			[
				'label'     => esc_html__( 'Line Width', 'the-post-grid' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 20,
				'selectors' => [
					'{{WRAPPER}} .tpg-timeline-container' => '--tpg-line-width: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'vertical_line_color',
			[
				'label'     => esc_html__( 'Line Color', 'the-post-grid' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tpg-timeline-container .tpg-vertical-line' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {
		/** Content TAB */

		// Layout.
		$this->grid_layouts();

		// Query.
		rtTPGElementorHelper::query( $this );

		// Filter  Settings.
		// rtTPGElementorHelper::filter_settings( $this );

		// Pagination Settings.
		rtTPGElementorHelper::pagination_settings( $this );

		// Links.
		rtTPGElementorHelper::links( $this );

		/**
		 * Settings Tab
		 * ===========
		 */

		// Field Selection.
		rtTPGElementorHelper::field_selection( $this );

		// Section Title Settings.
		rtTPGElementorHelper::section_title_settings( $this );

		// Title Settings.
		rtTPGElementorHelper::post_title_settings( $this );

		// Thumbnail Settings.
		rtTPGElementorHelper::post_thumbnail_settings( $this );

		// Excerpt Settings.
		rtTPGElementorHelper::post_excerpt_settings( $this );

		// Meta Settings.
		rtTPGElementorHelper::post_meta_settings( $this );

		// Advanced Custom Field ACF Settings.
		rtTPGElementorHelper::tpg_acf_settings( $this );

		// Readmore Settings.
		rtTPGElementorHelper::post_readmore_settings( $this );

		/** Style TAB */

		// Section Title Style.
		rtTPGElementorHelper::sectionTitle( $this );

		$this->timeline_style();

		// Title Style.
		rtTPGElementorHelper::titleStyle( $this );

		// Thumbnail Style.
		rtTPGElementorHelper::thumbnailStyle( $this );

		// Content Style.
		rtTPGElementorHelper::contentStyle( $this );

		// Meta Info Style.
		rtTPGElementorHelper::metaInfoStyle( $this );

		// Social Icon Style.
		rtTPGElementorHelper::socialShareStyle( $this );

		// ACF Style.
		rtTPGElementorHelper::tpg_acf_style( $this );

		// Read More Style.
		rtTPGElementorHelper::readmoreStyle( $this );

		// Link Style.
		rtTPGElementorHelper::linkStyle( $this );

		// Pagination - Load more Style.
		rtTPGElementorHelper::paginationStyle( $this );

		// Front-end Filter Style
		rtTPGElementorHelper::frontEndFilter( $this );

		// Box Settings.
		rtTPGElementorHelper::articlBoxSettings( $this );

		// Promotions.
		rtTPGElementorHelper::promotions( $this );
	}

	public function categorize_posts( $query, $by = 'date' ) {

		$all_posts = $query->posts ?? '';

		if ( ! $all_posts ) {
			return [];
		}

		$grouped_posts = [];

		foreach ( $all_posts as $_post ) {
			$post_id = $_post->ID;
			if ( 'date' == $by ) {
				$group_by = date( 'Y', strtotime( $_post->post_date ) );
			} else {
				$term_obj = wp_get_object_terms( $post_id, $by, [ 'fields' => 'names' ] );
				$group_by = $term_obj[0];
			}
			$grouped_posts[ $group_by ][] = $_post->post_title;

		}

		if ( 'date' == $by ) {
			krsort( $grouped_posts );
		}

		return $grouped_posts;
	}

	protected function render() {
		$data    = $this->get_settings();
		$_prefix = $this->prefix;

		if ( rtTPG()->hasPro() && ( 'popup' == $data['post_link_type'] || 'multi_popup' == $data['post_link_type'] ) ) {
			wp_enqueue_style( 'rt-magnific-popup' );
			wp_enqueue_script( 'rt-scrollbar' );
			wp_enqueue_script( 'rt-magnific-popup' );
			add_action( 'wp_footer', [ Fns::class, 'get_modal_markup' ] );
		}

		if ( 'show' == $data['show_pagination'] && 'pagination_ajax' == $data['pagination_type'] ) {
			wp_enqueue_script( 'rt-pagination' );
		}

		wp_enqueue_script( 'rttpg-block-pro' );

		// Query.
		$query_args = rtTPGElementorQuery::post_query( $data, $_prefix );

		if ( 'current_query' == $data['post_type'] && is_archive() ) {
			$query = $GLOBALS['wp_query'];
		} else {
			$query = new WP_Query( $query_args );
		}

		$_tag_type = $data[ $data['post_type'] . '_tag_type' ];

		$group_posts = $this->categorize_posts( $query, $_tag_type );

		$rand           = wp_rand();
		$layoutID       = 'rt-tpg-container-' . $rand;
		$posts_per_page = $data['display_per_page'] ?: $data['post_limit'];

		/**
		 * Get Post Data for render post
		 */

		$post_data = Fns::get_render_data_set( $data, $query->max_num_pages, $posts_per_page, $_prefix );

		$post_data['timeline_layout_style'] = $data['timeline_layout_style'] ?? '';
		$post_data['animation']             = $data['timeline_animation'] ?? '';
		/**
		 * Post type render
		 */
		$post_types = Fns::get_post_types();
		foreach ( $post_types as $post_type => $label ) {
			$_taxonomies = get_object_taxonomies( $post_type, 'object' );

			if ( empty( $_taxonomies ) ) {
				continue;
			}

			$post_data[ $data['post_type'] . '_taxonomy' ] = isset( $data[ $data['post_type'] . '_taxonomy' ] ) ? $data[ $data['post_type'] . '_taxonomy' ] : '';
			$post_data[ $data['post_type'] . '_tags' ]     = isset( $data[ $data['post_type'] . '_tags' ] ) ? $data[ $data['post_type'] . '_tags' ] : '';
		}

		$template_path = Fns::tpg_template_path( $post_data );
		$_layout       = $data[ $_prefix . '_layout' ];
		$_layout_style = $data[ $_prefix . '_layout_style' ];
		$dynamicClass  = ! empty( $data['enable_external_link'] ) && $data['enable_external_link'] === 'show' ? ' has-external-link' : '';

		?>

        <div class="rt-container-fluid rt-tpg-container tpg-el-main-wrapper tpg-timeline-container clearfix <?php echo esc_attr( $_layout . '-main' . ' ' . $dynamicClass ); ?>"
             id="<?php echo esc_attr( $layoutID ); ?>"
             data-layout="<?php echo esc_attr( $data[ $_prefix . '_layout' ] ); ?>"
             data-grid-style="<?php echo esc_attr( $data[ $_prefix . '_layout_style' ] ); ?>"
             data-sc-id="elementor"
             data-el-settings='<?php Fns::is_filter_enable( $data ) ? Fns::print_html( htmlspecialchars( wp_json_encode( $post_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) ), true ) : ''; ?>'
             data-el-query='<?php Fns::is_filter_enable( $data ) ? Fns::print_html( htmlspecialchars( wp_json_encode( $query_args ) ), true ) : ''; ?>'
             data-el-path='<?php echo Fns::is_filter_enable( $data ) ? esc_attr( $template_path ) : ''; ?>'
        >

			<?php
			$settings = get_option( rtTPG()->options['settings'] );
			if ( isset( $settings['tpg_load_script'] ) || isset( $settings['tpg_enable_preloader'] ) ) {
				?>
                <div id="bottom-script-loader" class="bottom-script-loader">
                    <div class="rt-ball-clip-rotate">
                        <div></div>
                    </div>
                </div>
				<?php
			}

			$wrapper_class   = [];
			$wrapper_class[] = str_replace( '-2', '', $_layout );
			$wrapper_class[] = 'grid-behaviour';
			$wrapper_class[] = $_prefix . '_layout_wrapper';

			switch ( $_layout ) {
				case 'timeline-layout3':
					$wrapper_class[] = 'grid-layout3';
					break;
				case 'timeline-layout4':
					$wrapper_class[] = 'grid_hover-layout1 grid_hover_layout_wrapper';
					break;
			}
			?>
            <div class='tpg-header-wrapper'>
				<?php Fns::get_section_title( $data ); ?>
            </div>

            <div data-title="Loading ..." class="rt-row rt-content-loader <?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
                <div class="tpg-vertical-line"></div>
				<?php

				if ( $group_posts ) {
					$pCount = 1;

					foreach ( $group_posts as $tag => $group_post ) {
						$tagId = str_replace( ' ', '-', $tag );
						echo "<div id='$tagId' class='tag-timeline-title clearfix'><h3 class='timeline-title'>$tag</h3></div>";

						echo "<div class='tpg-timeline-posts clearfix'>";
						foreach ( $group_post as $post ) {
							setup_postdata( $post );
							$query->the_post();
							set_query_var( 'tpg_post_count', $pCount );
							set_query_var( 'tpg_total_posts', $query->post_count );
							Fns::tpg_template( $post_data );
							$pCount ++;
						}
						echo '</div>';
					}
				} else {
					if ( $data['no_posts_found_text'] ) {
						printf( "<div class='no_posts_found_text rt-col-xs-12'>%s</div>", esc_html( $data['no_posts_found_text'] ) );
					} else {
						printf( "<div class='no_posts_found_text rt-col-xs-12'>%s</div>", esc_html__( 'No post found', 'the-post-grid' ) );
					}
				}
				wp_reset_query();
				?>
            </div>
			<?php Fns::print_html( Fns::get_pagination_markup( $query, $data ) ); ?>

        </div>
		<?php
		if ( 'masonry' === $data[ $_prefix . '_layout_style' ] && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			?>
            <script>jQuery('.rt-row.rt-content-loader.tpg-masonry').isotope();</script>
			<?php
		}

		do_action( 'tpg_elementor_script' );
	}
}
