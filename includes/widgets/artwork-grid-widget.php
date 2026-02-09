<?php
/**
 * Artwork Grid Widget.
 *
 * Elementor widget that displays a responsive grid of artwork items.
 *
 * @since 1.0.0
 */

namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Artwork_Grid_Widget class.
 */
class Artwork_Grid_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'gm_artwork_grid';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Artwork Grid', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-posts-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'gallery', 'artwork', 'grid', 'portfolio', 'kunst' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'gm-artwork-grid-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends(): array {
		return [ 'gm-artwork-grid-script' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// =============================================
		// CONTENT TAB - Artwork Items
		// =============================================
		$this->start_controls_section(
			'section_artworks',
			[
				'label' => esc_html__( 'Artwork Items', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'artwork_image',
			[
				'label'   => esc_html__( 'Artwork Image', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'    => 'artwork_image_size',
				'default' => 'large',
			]
		);

		$repeater->add_control(
			'artwork_title',
			[
				'label'       => esc_html__( 'Title', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Artwork Title', 'galerie-mueller-widgets' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'artwork_medium',
			[
				'label'       => esc_html__( 'Medium', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Öl auf Leinwand', 'galerie-mueller-widgets' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'artwork_year',
			[
				'label'   => esc_html__( 'Year', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 2024,
				'min'     => 1900,
				'max'     => 2100,
				'step'    => 1,
			]
		);

		$repeater->add_control(
			'artwork_dimensions',
			[
				'label'       => esc_html__( 'Dimensions', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( '80 × 100 cm', 'galerie-mueller-widgets' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'artwork_link',
			[
				'label'   => esc_html__( 'Link', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [ 'url' => '' ],
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'artwork_aspect_ratio',
			[
				'label'   => esc_html__( 'Aspect Ratio', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '4/5',
				'options' => [
					'4/5'    => '4:5 (Portrait)',
					'16/9'   => '16:9 (Widescreen)',
					'1/1'    => '1:1 (Square)',
					'3/2'    => '3:2 (Landscape)',
					'16/10'  => '16:10 (Landscape)',
					'21/9'   => '21:9 (Ultrawide)',
					'4/3'    => '4:3 (Classic)',
					'custom' => esc_html__( 'Custom', 'galerie-mueller-widgets' ),
				],
			]
		);

		$repeater->add_control(
			'artwork_custom_aspect_w',
			[
				'label'     => esc_html__( 'Custom Aspect Width', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 100,
				'condition' => [ 'artwork_aspect_ratio' => 'custom' ],
			]
		);

		$repeater->add_control(
			'artwork_custom_aspect_h',
			[
				'label'     => esc_html__( 'Custom Aspect Height', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 1,
				'max'       => 100,
				'condition' => [ 'artwork_aspect_ratio' => 'custom' ],
			]
		);

		$this->add_control(
			'artworks',
			[
				'label'       => esc_html__( 'Artworks', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'artwork_title'        => esc_html__( 'Ateliernotiz 07', 'galerie-mueller-widgets' ),
						'artwork_medium'       => esc_html__( 'Öl auf Leinwand', 'galerie-mueller-widgets' ),
						'artwork_year'         => 2023,
						'artwork_dimensions'   => '80 × 100 cm',
						'artwork_aspect_ratio' => '4/5',
					],
					[
						'artwork_title'        => esc_html__( 'Linienstudie II', 'galerie-mueller-widgets' ),
						'artwork_medium'       => esc_html__( 'Mischtechnik auf Papier', 'galerie-mueller-widgets' ),
						'artwork_year'         => 2022,
						'artwork_dimensions'   => '42 × 59 cm',
						'artwork_aspect_ratio' => '4/5',
					],
					[
						'artwork_title'        => esc_html__( 'Komposition in Grau', 'galerie-mueller-widgets' ),
						'artwork_medium'       => esc_html__( 'Tusche und Bleistift', 'galerie-mueller-widgets' ),
						'artwork_year'         => 2024,
						'artwork_dimensions'   => '30 × 30 cm',
						'artwork_aspect_ratio' => '4/5',
					],
				],
				'title_field' => '{{{ artwork_title }}}',
			]
		);

		$this->end_controls_section();

		// =============================================
		// CONTENT TAB - Layout Settings
		// =============================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout Settings', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'grid_columns',
			[
				'label'     => esc_html__( 'Columns (Desktop)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'grid_columns_tablet',
			[
				'label'     => esc_html__( 'Columns (Tablet)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
			]
		);

		$this->add_control(
			'grid_columns_mobile',
			[
				'label'   => esc_html__( 'Columns (Mobile)', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
				],
			]
		);

		$this->add_control(
			'show_metadata',
			[
				'label'        => esc_html__( 'Show Metadata Below Image', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_dimensions',
			[
				'label'        => esc_html__( 'Show Dimensions', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_metadata' => 'yes' ],
			]
		);

		$this->add_control(
			'show_hover_overlay',
			[
				'label'        => esc_html__( 'Show Hover Overlay', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// =============================================
		// CONTENT TAB - Empty State
		// =============================================
		$this->start_controls_section(
			'section_empty_state',
			[
				'label' => esc_html__( 'Empty State', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_empty_state',
			[
				'label'        => esc_html__( 'Show Empty State Message', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'empty_message',
			[
				'label'       => esc_html__( 'Empty State Message', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Noch keine Werke in dieser Kategorie.', 'galerie-mueller-widgets' ),
				'label_block' => true,
				'condition'   => [ 'show_empty_state' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// =============================================
		// CONTENT TAB - Click Interaction
		// =============================================
		$this->start_controls_section(
			'section_interaction',
			[
				'label' => esc_html__( 'Click Interaction', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'click_action',
			[
				'label'   => esc_html__( 'Click Action', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'lightbox',
				'options' => [
					'none'     => esc_html__( 'None', 'galerie-mueller-widgets' ),
					'lightbox' => esc_html__( 'Lightbox', 'galerie-mueller-widgets' ),
					'link'     => esc_html__( 'Custom Link (from repeater)', 'galerie-mueller-widgets' ),
				],
			]
		);

		$this->add_control(
			'overlay_text',
			[
				'label'       => esc_html__( 'Overlay Text', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Werk ansehen', 'galerie-mueller-widgets' ),
				'label_block' => true,
				'condition'   => [ 'show_hover_overlay' => 'yes' ],
			]
		);

		$this->add_control(
			'lightbox_trigger_id',
			[
				'label'       => esc_html__( 'Lightbox Trigger ID/Class', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( '.lightbox-trigger', 'galerie-mueller-widgets' ),
				'description' => esc_html__( 'CSS selector for lightbox integration', 'galerie-mueller-widgets' ),
				'condition'   => [ 'click_action' => 'lightbox' ],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Section
		// =============================================
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Section', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Section Padding', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 16,
					'bottom'   => 40,
					'left'     => 16,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-artwork-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_max_width',
			[
				'label'      => esc_html__( 'Content Max Width', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 320, 'max' => 1920, 'step' => 10 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1280 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-artwork-grid__container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Grid
		// =============================================
		$this->start_controls_section(
			'style_grid',
			[
				'label' => esc_html__( 'Grid', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'grid_gap_x',
			[
				'label'      => esc_html__( 'Horizontal Gap', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-artwork-grid__grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap_y',
			[
				'label'      => esc_html__( 'Vertical Gap', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 40 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-artwork-grid__grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Image
		// =============================================
		$this->start_controls_section(
			'style_image',
			[
				'label' => esc_html__( 'Image', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_object_fit',
			[
				'label'     => esc_html__( 'Object Fit', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'galerie-mueller-widgets' ),
					'contain' => esc_html__( 'Contain', 'galerie-mueller-widgets' ),
					'fill'    => esc_html__( 'Fill', 'galerie-mueller-widgets' ),
					'none'    => esc_html__( 'None', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__image' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-artwork-grid__image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'image_bg_color',
			[
				'label'     => esc_html__( 'Placeholder Background', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__image-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Hover Overlay
		// =============================================
		$this->start_controls_section(
			'style_overlay',
			[
				'label'     => esc_html__( 'Hover Overlay', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hover_overlay' => 'yes' ],
			]
		);

		$this->add_control(
			'hover_zoom_scale',
			[
				'label'     => esc_html__( 'Hover Zoom Scale', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 1, 'max' => 1.5, 'step' => 0.01 ],
				],
				'default'   => [ 'size' => 1.03 ],
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__item:hover .gm-artwork-grid__image' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color (Rest)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_hover_color',
			[
				'label'     => esc_html__( 'Overlay Color (Hover)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.2)',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__item:hover .gm-artwork-grid__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__overlay-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'overlay_text_typography',
				'selector' => '{{WRAPPER}} .gm-artwork-grid__overlay-text',
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Metadata
		// =============================================
		$this->start_controls_section(
			'style_metadata',
			[
				'label'     => esc_html__( 'Metadata', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_metadata' => 'yes' ],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gm-artwork-grid__title',
			]
		);

		$this->add_control(
			'medium_color',
			[
				'label'     => esc_html__( 'Medium Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__medium' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'medium_typography',
				'selector' => '{{WRAPPER}} .gm-artwork-grid__medium',
			]
		);

		$this->add_control(
			'dimensions_color',
			[
				'label'     => esc_html__( 'Dimensions Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(107,107,107,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-artwork-grid__dimensions' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_dimensions' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'metadata_gap',
			[
				'label'      => esc_html__( 'Gap Above Metadata', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 40, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-artwork-grid__metadata' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Animation
		// =============================================
		$this->start_controls_section(
			'style_animation',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Enable Entrance Animation', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_delay',
			[
				'label'     => esc_html__( 'Stagger Delay (ms)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 500, 'step' => 10 ],
				],
				'default'   => [ 'size' => 100 ],
				'condition' => [ 'enable_fade_up' => 'yes' ],
			]
		);

		$this->add_control(
			'animation_threshold',
			[
				'label'       => esc_html__( 'Trigger Threshold', 'galerie-mueller-widgets' ),
				'description' => esc_html__( 'Fraction of element visible before animation triggers (0 to 1)', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'     => [ 'size' => 0.15 ],
				'condition'   => [ 'enable_fade_up' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Check if we have artworks
		if ( empty( $settings['artworks'] ) ) {
			if ( 'yes' === $settings['show_empty_state'] ) {
				$this->render_empty_state( $settings );
			}
			return;
		}

		$animation_class = ( 'yes' === $settings['enable_fade_up'] ) ? ' gm-artwork-grid__item--hidden' : '';
		$grid_data_attrs = '';

		if ( 'yes' === $settings['enable_fade_up'] ) {
			$threshold       = $settings['animation_threshold']['size'] ?? 0.15;
			$delay           = $settings['animation_delay']['size'] ?? 100;
			$grid_data_attrs = sprintf(
				' data-threshold="%s" data-delay="%s"',
				esc_attr( $threshold ),
				esc_attr( $delay )
			);
		}
		?>
		<section class="gm-artwork-grid">
			<div class="gm-artwork-grid__container">
				<div class="gm-artwork-grid__grid"<?php echo $grid_data_attrs; ?>>
					<?php foreach ( $settings['artworks'] as $index => $item ) : ?>
						<?php $this->render_artwork_item( $item, $index, $settings, $animation_class ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}

	/**
	 * Render individual artwork item.
	 *
	 * @param array  $item            The artwork item data.
	 * @param int    $index           The item index.
	 * @param array  $settings        Widget settings.
	 * @param string $animation_class Animation class for fade-up.
	 */
	private function render_artwork_item( $item, $index, $settings, $animation_class ): void {
		$has_link     = ! empty( $item['artwork_link']['url'] );
		$click_action = $settings['click_action'] ?? 'none';

		// Prepare click data attributes
		$click_attrs = '';
		if ( 'lightbox' === $click_action ) {
			$click_attrs .= ' data-click-action="lightbox"';
			if ( ! empty( $settings['lightbox_trigger_id'] ) ) {
				$click_attrs .= ' data-trigger-selector="' . esc_attr( $settings['lightbox_trigger_id'] ) . '"';
			}
		} elseif ( 'link' === $click_action && $has_link ) {
			$click_attrs .= ' data-click-action="link"';
			$click_attrs .= ' data-artwork-link="' . esc_attr( wp_json_encode( $item['artwork_link'] ) ) . '"';
		}

		// Aspect ratio handling
		$aspect_ratio = $item['artwork_aspect_ratio'] ?? '4/5';
		$aspect_style = '';
		$aspect_class = '';

		if ( 'custom' === $aspect_ratio ) {
			$w            = intval( $item['artwork_custom_aspect_w'] ?? 4 );
			$h            = intval( $item['artwork_custom_aspect_h'] ?? 5 );
			$aspect_style = 'style="aspect-ratio: ' . $w . ' / ' . $h . ';"';
		} else {
			$aspect_class = 'gm-artwork-grid__image-wrap--' . str_replace( '/', '-', $aspect_ratio );
		}
		?>
		<div class="gm-artwork-grid__item<?php echo esc_attr( $animation_class ); ?>"<?php echo $click_attrs; ?>>
			<div class="gm-artwork-grid__image-wrap <?php echo esc_attr( $aspect_class ); ?>" <?php echo $aspect_style; ?>>
				<?php
				if ( ! empty( $item['artwork_image']['id'] ) ) {
					echo \Elementor\Group_Control_Image_Size::get_attachment_image_html(
						$item,
						'artwork_image_size',
						'artwork_image'
					);
				} elseif ( ! empty( $item['artwork_image']['url'] ) ) {
					echo '<img src="' . esc_url( $item['artwork_image']['url'] ) . '" class="gm-artwork-grid__image" alt="' . esc_attr( $item['artwork_title'] ?? '' ) . '">';
				}
				?>

				<?php if ( 'yes' === $settings['show_hover_overlay'] ) : ?>
					<div class="gm-artwork-grid__overlay">
						<span class="gm-artwork-grid__overlay-text">
							<?php echo esc_html( $settings['overlay_text'] ?? '' ); ?>
						</span>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' === $settings['show_metadata'] ) : ?>
				<div class="gm-artwork-grid__metadata">
					<h3 class="gm-artwork-grid__title"><?php echo esc_html( $item['artwork_title'] ?? '' ); ?></h3>
					<p class="gm-artwork-grid__medium">
						<?php
						echo esc_html( $item['artwork_medium'] ?? '' );
						if ( ! empty( $item['artwork_year'] ) ) {
							echo ', ' . esc_html( $item['artwork_year'] );
						}
						?>
					</p>
					<?php if ( 'yes' === $settings['show_dimensions'] && ! empty( $item['artwork_dimensions'] ) ) : ?>
						<p class="gm-artwork-grid__dimensions"><?php echo esc_html( $item['artwork_dimensions'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render empty state.
	 *
	 * @param array $settings Widget settings.
	 */
	private function render_empty_state( $settings ): void {
		?>
		<section class="gm-artwork-grid">
			<div class="gm-artwork-grid__container">
				<p class="gm-artwork-grid__empty">
					<?php echo esc_html( $settings['empty_message'] ?? '' ); ?>
				</p>
			</div>
		</section>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<#
		var animationClass = ('yes' === settings.enable_fade_up) ? ' gm-artwork-grid__item--hidden' : '';
		var gridDataAttrs = '';
		if ('yes' === settings.enable_fade_up) {
			var threshold = settings.animation_threshold.size || 0.15;
			var delay = settings.animation_delay.size || 100;
			gridDataAttrs = ' data-threshold="' + threshold + '" data-delay="' + delay + '"';
		}
		#>
		<section class="gm-artwork-grid">
			<div class="gm-artwork-grid__container">
				<# if (!settings.artworks || !settings.artworks.length) { #>
					<# if ('yes' === settings.show_empty_state) { #>
						<p class="gm-artwork-grid__empty">{{{ settings.empty_message }}}</p>
					<# } #>
				<# } else { #>
					<div class="gm-artwork-grid__grid"{{{ gridDataAttrs }}}>
						<# _.each(settings.artworks, function(item, index) {
							var aspectRatio = item.artwork_aspect_ratio || '4/5';
							var aspectClass = '';
							var aspectStyle = '';

							if ('custom' === aspectRatio) {
								var w = item.artwork_custom_aspect_w || 4;
								var h = item.artwork_custom_aspect_h || 5;
								aspectStyle = 'style="aspect-ratio: ' + w + ' / ' + h + ';"';
							} else {
								aspectClass = 'gm-artwork-grid__image-wrap--' + aspectRatio.replace('/', '-');
							}
						#>
							<div class="gm-artwork-grid__item{{ animationClass }}">
								<div class="gm-artwork-grid__image-wrap {{ aspectClass }}" {{{ aspectStyle }}}>
									<# if (item.artwork_image && item.artwork_image.url) { #>
										<img src="{{ item.artwork_image.url }}" class="gm-artwork-grid__image" alt="{{ item.artwork_title }}">
									<# } #>

									<# if ('yes' === settings.show_hover_overlay) { #>
										<div class="gm-artwork-grid__overlay">
											<span class="gm-artwork-grid__overlay-text">{{{ settings.overlay_text }}}</span>
										</div>
									<# } #>
								</div>

								<# if ('yes' === settings.show_metadata) { #>
									<div class="gm-artwork-grid__metadata">
										<h3 class="gm-artwork-grid__title">{{{ item.artwork_title }}}</h3>
										<p class="gm-artwork-grid__medium">
											{{{ item.artwork_medium }}}<# if (item.artwork_year) { #>, {{{ item.artwork_year }}}<# } #>
										</p>
										<# if ('yes' === settings.show_dimensions && item.artwork_dimensions) { #>
											<p class="gm-artwork-grid__dimensions">{{{ item.artwork_dimensions }}}</p>
										<# } #>
									</div>
								<# } #>
							</div>
						<# }); #>
					</div>
				<# } #>
			</div>
		</section>
		<?php
	}
}
