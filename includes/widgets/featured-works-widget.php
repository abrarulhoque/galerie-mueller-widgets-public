<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

/**
 * Featured Works Widget
 *
 * Asymmetric artwork grid with hover zoom, overlay labels, and CTA link.
 *
 * @since 1.0.0
 */
class Featured_Works_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_featured_works';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Featured Works', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'gallery', 'works', 'artwork', 'grid', 'portfolio', 'featured' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-featured-works-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-featured-works-script' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {
		$this->register_content_heading_controls();
		$this->register_content_artworks_controls();
		$this->register_content_cta_controls();
		$this->register_content_layout_controls();
		$this->register_style_section_controls();
		$this->register_style_heading_controls();
		$this->register_style_grid_controls();
		$this->register_style_overlay_controls();
		$this->register_style_labels_controls();
		$this->register_style_cta_controls();
		$this->register_animation_controls();
	}

	/**
	 * Content Tab: Section Heading
	 */
	private function register_content_heading_controls(): void {

		$this->start_controls_section(
			'content_heading',
			[
				'label' => esc_html__( 'Section Heading', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Heading Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Ausgewählte Werke',
				'placeholder' => esc_html__( 'Enter section heading', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'Heading HTML Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'span',
					'div'  => 'div',
				],
			]
		);

		$this->add_control(
			'show_accent_bar',
			[
				'label'        => esc_html__( 'Show Accent Bar', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Artwork Items (Repeater)
	 */
	private function register_content_artworks_controls(): void {

		$this->start_controls_section(
			'content_artworks',
			[
				'label' => esc_html__( 'Artwork Items', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'artwork_image',
			[
				'label'       => esc_html__( 'Artwork Image', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'artwork_title',
			[
				'label'       => esc_html__( 'Title', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Artwork Title',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'artwork_medium',
			[
				'label'       => esc_html__( 'Medium / Technique', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Öl auf Leinwand, 2023',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'artwork_link',
			[
				'label'   => esc_html__( 'Link', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '' ],
			]
		);

		$repeater->add_control(
			'artwork_aspect_ratio',
			[
				'label'   => esc_html__( 'Aspect Ratio', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '4/5',
				'options' => [
					'4/5'    => '4:5 (Portrait)',
					'16/9'   => '16:9 (Widescreen)',
					'1/1'    => '1:1 (Square)',
					'3/2'    => '3:2 (Landscape)',
					'16/10'  => '16:10 (Desktop)',
					'21/9'   => '21:9 (Ultrawide)',
					'4/3'    => '4:3 (Classic)',
				],
			]
		);

		$this->add_control(
			'artworks',
			[
				'label'   => esc_html__( 'Artworks', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'artwork_title'        => 'Ateliernotiz 07',
						'artwork_medium'       => 'Öl auf Leinwand, 2023',
						'artwork_aspect_ratio' => '4/5',
					],
					[
						'artwork_title'        => 'Linienstudie II',
						'artwork_medium'       => 'Mischtechnik auf Papier, 2022',
						'artwork_aspect_ratio' => '16/10',
					],
					[
						'artwork_title'        => 'Komposition in Grau',
						'artwork_medium'       => 'Tusche und Bleistift, 2024',
						'artwork_aspect_ratio' => '16/10',
					],
					[
						'artwork_title'        => 'Horizont',
						'artwork_medium'       => 'Acryl auf Leinwand, 2023',
						'artwork_aspect_ratio' => '21/9',
					],
				],
				'title_field' => '{{{ artwork_title }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Call to Action
	 */
	private function register_content_cta_controls(): void {

		$this->start_controls_section(
			'content_cta',
			[
				'label' => esc_html__( 'Call to Action', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_cta',
			[
				'label'        => esc_html__( 'Show CTA', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'cta_text',
			[
				'label'       => esc_html__( 'CTA Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Alle Werke ansehen →',
				'label_block' => true,
				'condition'   => [ 'show_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'cta_link',
			[
				'label'     => esc_html__( 'CTA Link', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::URL,
				'default'   => [ 'url' => '/galerie' ],
				'condition' => [ 'show_cta' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Layout Settings
	 */
	private function register_content_layout_controls(): void {

		$this->start_controls_section(
			'content_layout',
			[
				'label' => esc_html__( 'Layout Settings', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_labels_below',
			[
				'label'        => esc_html__( 'Show Labels Below Image', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_overlay_labels',
			[
				'label'        => esc_html__( 'Show Overlay Labels on Hover', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Section Style
	 */
	private function register_style_section_controls(): void {

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Section', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-section' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 64,
					'right'    => 24,
					'bottom'   => 64,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-fw-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'      => esc_html__( 'Content Max Width', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 600, 'max' => 1920 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [
					'size' => 1152,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-fw-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Heading Style
	 */
	private function register_style_heading_controls(): void {

		$this->start_controls_section(
			'style_heading',
			[
				'label' => esc_html__( 'Heading', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-heading-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .gm-fw-heading-text',
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'   => esc_html__( 'Bottom Spacing', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 48,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-fw-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_bar_heading',
			[
				'label'     => esc_html__( 'Accent Bar', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'show_accent_bar' => 'yes' ],
			]
		);

		$this->add_control(
			'accent_bar_color',
			[
				'label'     => esc_html__( 'Bar Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-accent-bar' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_accent_bar' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Grid Style
	 */
	private function register_style_grid_controls(): void {

		$this->start_controls_section(
			'style_grid',
			[
				'label' => esc_html__( 'Grid', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'   => esc_html__( 'Grid Gap', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default' => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-fw-grid' => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gm-fw-grid-mobile' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Hover Overlay Style
	 */
	private function register_style_overlay_controls(): void {

		$this->start_controls_section(
			'style_overlay',
			[
				'label' => esc_html__( 'Hover Overlay', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_zoom_scale',
			[
				'label'   => esc_html__( 'Hover Zoom Scale', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 1, 'max' => 1.5, 'step' => 0.01 ],
				],
				'default' => [
					'size' => 1.03,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-fw-card:hover .gm-fw-card-img' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->add_control(
			'overlay_hover_color',
			[
				'label'     => esc_html__( 'Overlay Color (Hover)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.2)',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-card:hover .gm-fw-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration (ms)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 100, 'max' => 1000, 'step' => 50 ],
				],
				'default' => [
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-fw-card-img' => 'transition-duration: {{SIZE}}ms;',
					'{{WRAPPER}} .gm-fw-overlay' => 'transition-duration: {{SIZE}}ms;',
					'{{WRAPPER}} .gm-fw-overlay-content' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Labels Style
	 */
	private function register_style_labels_controls(): void {

		$this->start_controls_section(
			'style_labels',
			[
				'label' => esc_html__( 'Labels', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Overlay Labels
		$this->add_control(
			'overlay_labels_heading',
			[
				'label'     => esc_html__( 'Overlay Labels', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'show_overlay_labels' => 'yes' ],
			]
		);

		$this->add_control(
			'overlay_title_color',
			[
				'label'     => esc_html__( 'Overlay Title Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-overlay-title' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_overlay_labels' => 'yes' ],
			]
		);

		$this->add_control(
			'overlay_medium_color',
			[
				'label'     => esc_html__( 'Overlay Medium Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-overlay-medium' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_overlay_labels' => 'yes' ],
			]
		);

		// Below-Image Labels
		$this->add_control(
			'below_labels_heading',
			[
				'label'     => esc_html__( 'Below-Image Labels', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'show_labels_below' => 'yes' ],
			]
		);

		$this->add_control(
			'label_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-label-title' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_labels_below' => 'yes' ],
			]
		);

		$this->add_control(
			'label_medium_color',
			[
				'label'     => esc_html__( 'Medium Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-label-medium' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_labels_below' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: CTA Style
	 */
	private function register_style_cta_controls(): void {

		$this->start_controls_section(
			'style_cta',
			[
				'label'     => esc_html__( 'CTA Link', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'cta_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-cta a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cta_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-fw-cta a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_typography',
				'selector' => '{{WRAPPER}} .gm-fw-cta a',
			]
		);

		$this->add_responsive_control(
			'cta_margin_top',
			[
				'label'   => esc_html__( 'Top Margin', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 120 ],
				],
				'default' => [
					'size' => 56,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-fw-cta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Animation
	 */
	private function register_animation_controls(): void {

		$this->start_controls_section(
			'animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Enable Fade-Up Animation', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_threshold',
			[
				'label'   => esc_html__( 'Animation Threshold', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default' => [
					'size' => 0.15,
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get aspect ratio CSS class.
	 *
	 * @param string $ratio The aspect ratio value.
	 * @return string
	 */
	private function get_aspect_class( $ratio ): string {
		$map = [
			'4/5'   => 'gm-fw-card-image-wrap--4-5',
			'16/9'  => 'gm-fw-card-image-wrap--16-9',
			'1/1'   => 'gm-fw-card-image-wrap--1-1',
			'3/2'   => 'gm-fw-card-image-wrap--3-2',
			'16/10' => 'gm-fw-card-image-wrap--16-10',
			'21/9'  => 'gm-fw-card-image-wrap--21-9',
			'4/3'   => 'gm-fw-card-image-wrap--4-3',
		];
		return $map[ $ratio ] ?? 'gm-fw-card-image-wrap--4-5';
	}

	/**
	 * Render a single artwork card.
	 *
	 * @param array  $artwork The artwork data.
	 * @param string $aspect_class The aspect ratio class.
	 * @param bool   $show_overlay_labels Whether to show overlay labels.
	 * @param bool   $show_labels_below Whether to show labels below image.
	 */
	private function render_artwork_card( $artwork, $aspect_class, $show_overlay_labels, $show_labels_below ): void {
		$has_link = ! empty( $artwork['artwork_link']['url'] );
		$tag_open = $has_link ? '<a href="' . esc_url( $artwork['artwork_link']['url'] ) . '"' : '<div';
		$tag_close = $has_link ? '</a>' : '</div>';

		if ( $has_link && ! empty( $artwork['artwork_link']['is_external'] ) ) {
			$tag_open .= ' target="_blank"';
		}
		if ( $has_link && ! empty( $artwork['artwork_link']['nofollow'] ) ) {
			$tag_open .= ' rel="nofollow"';
		}
		$tag_open .= ' class="gm-fw-card">';
		?>
		<?php echo $tag_open; // phpcs:ignore ?>
			<div class="gm-fw-card-image-wrap <?php echo esc_attr( $aspect_class ); ?>">
				<?php if ( ! empty( $artwork['artwork_image']['url'] ) ) : ?>
					<img src="<?php echo esc_url( $artwork['artwork_image']['url'] ); ?>"
						 alt="<?php echo esc_attr( $artwork['artwork_title'] ); ?>"
						 class="gm-fw-card-img" />
				<?php endif; ?>

				<?php if ( $show_overlay_labels ) : ?>
					<div class="gm-fw-overlay">
						<div class="gm-fw-overlay-content">
							<p class="gm-fw-overlay-title"><?php echo esc_html( $artwork['artwork_title'] ); ?></p>
							<p class="gm-fw-overlay-medium"><?php echo esc_html( $artwork['artwork_medium'] ); ?></p>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $show_labels_below ) : ?>
				<div class="gm-fw-label">
					<p class="gm-fw-label-title"><?php echo esc_html( $artwork['artwork_title'] ); ?></p>
					<p class="gm-fw-label-medium"><?php echo esc_html( $artwork['artwork_medium'] ); ?></p>
				</div>
			<?php endif; ?>
		<?php echo $tag_close; // phpcs:ignore ?>
		<?php
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$artworks             = $settings['artworks'] ?? [];
		$show_overlay_labels  = 'yes' === $settings['show_overlay_labels'];
		$show_labels_below    = 'yes' === $settings['show_labels_below'];
		$heading_tag          = $settings['heading_tag'] ?? 'h2';

		// Animation
		$animation_class = '';
		$animation_attrs = '';
		if ( 'yes' === $settings['enable_fade_up'] ) {
			$animation_class = 'gm-fw-inner--hidden';
			$animation_attrs = sprintf(
				'data-anim-threshold="%s"',
				esc_attr( $settings['animation_threshold']['size'] ?? '0.15' )
			);
		}
		?>
		<section class="gm-fw-section">
			<div class="gm-fw-inner <?php echo esc_attr( $animation_class ); ?>" <?php echo $animation_attrs; // phpcs:ignore ?>>

				<!-- Section Heading -->
				<div class="gm-fw-heading">
					<?php if ( 'yes' === $settings['show_accent_bar'] ) : ?>
						<div class="gm-fw-accent-bar"></div>
					<?php endif; ?>
					<<?php echo esc_html( $heading_tag ); ?> class="gm-fw-heading-text">
						<?php echo esc_html( $settings['heading_text'] ); ?>
					</<?php echo esc_html( $heading_tag ); ?>>
				</div>

				<?php if ( count( $artworks ) >= 4 ) : ?>
					<!-- Desktop: Asymmetric Grid -->
					<div class="gm-fw-grid">
						<!-- Item 1: Tall (spans 2 rows) -->
						<div class="gm-fw-grid-item--tall">
							<?php $this->render_artwork_card( $artworks[0], $this->get_aspect_class( $artworks[0]['artwork_aspect_ratio'] ), $show_overlay_labels, $show_labels_below ); ?>
						</div>

						<!-- Item 2 -->
						<div>
							<?php $this->render_artwork_card( $artworks[1], $this->get_aspect_class( $artworks[1]['artwork_aspect_ratio'] ), $show_overlay_labels, $show_labels_below ); ?>
						</div>

						<!-- Item 3 -->
						<div>
							<?php $this->render_artwork_card( $artworks[2], $this->get_aspect_class( $artworks[2]['artwork_aspect_ratio'] ), $show_overlay_labels, $show_labels_below ); ?>
						</div>
					</div>

					<!-- Item 4: Full width -->
					<div class="gm-fw-full-width">
						<?php $this->render_artwork_card( $artworks[3], $this->get_aspect_class( $artworks[3]['artwork_aspect_ratio'] ), $show_overlay_labels, $show_labels_below ); ?>
					</div>

					<!-- Mobile: Single Column Stack -->
					<div class="gm-fw-grid-mobile">
						<?php foreach ( $artworks as $artwork ) : ?>
							<?php $this->render_artwork_card( $artwork, 'gm-fw-card-image-wrap--4-3', $show_overlay_labels, $show_labels_below ); ?>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<!-- Fallback for fewer than 4 artworks -->
					<div class="gm-fw-grid-mobile">
						<?php foreach ( $artworks as $artwork ) : ?>
							<?php $this->render_artwork_card( $artwork, $this->get_aspect_class( $artwork['artwork_aspect_ratio'] ), $show_overlay_labels, $show_labels_below ); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- CTA -->
				<?php if ( 'yes' === $settings['show_cta'] ) : ?>
					<?php
					$cta_url = $settings['cta_link']['url'] ?? '#';
					$cta_target = ! empty( $settings['cta_link']['is_external'] ) ? ' target="_blank"' : '';
					$cta_nofollow = ! empty( $settings['cta_link']['nofollow'] ) ? ' rel="nofollow"' : '';
					?>
					<div class="gm-fw-cta">
						<a href="<?php echo esc_url( $cta_url ); ?>"<?php echo $cta_target . $cta_nofollow; // phpcs:ignore ?>>
							<?php echo wp_kses_post( $settings['cta_text'] ); ?>
						</a>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * @since 1.0.0
	 */
	protected function content_template(): void {
		?>
		<#
		var headingTag = settings.heading_tag || 'h2';
		var animClass = ( 'yes' === settings.enable_fade_up ) ? 'gm-fw-inner--hidden' : '';
		#>

		<section class="gm-fw-section">
			<div class="gm-fw-inner {{ animClass }}">

				<div class="gm-fw-heading">
					<# if ( 'yes' === settings.show_accent_bar ) { #>
						<div class="gm-fw-accent-bar"></div>
					<# } #>
					<{{{ headingTag }}} class="gm-fw-heading-text">
						{{{ settings.heading_text }}}
					</{{{ headingTag }}}>
				</div>

				<div class="gm-fw-grid-mobile">
					<# _.each( settings.artworks, function( artwork ) { #>
						<div class="gm-fw-card">
							<div class="gm-fw-card-image-wrap gm-fw-card-image-wrap--4-3">
								<# if ( artwork.artwork_image.url ) { #>
									<img src="{{ artwork.artwork_image.url }}" alt="{{ artwork.artwork_title }}" class="gm-fw-card-img" />
								<# } #>
								<# if ( 'yes' === settings.show_overlay_labels ) { #>
									<div class="gm-fw-overlay">
										<div class="gm-fw-overlay-content">
											<p class="gm-fw-overlay-title">{{{ artwork.artwork_title }}}</p>
											<p class="gm-fw-overlay-medium">{{{ artwork.artwork_medium }}}</p>
										</div>
									</div>
								<# } #>
							</div>
							<# if ( 'yes' === settings.show_labels_below ) { #>
								<div class="gm-fw-label">
									<p class="gm-fw-label-title">{{{ artwork.artwork_title }}}</p>
									<p class="gm-fw-label-medium">{{{ artwork.artwork_medium }}}</p>
								</div>
							<# } #>
						</div>
					<# }); #>
				</div>

				<# if ( 'yes' === settings.show_cta ) { #>
					<div class="gm-fw-cta">
						<a href="{{ settings.cta_link.url }}">{{{ settings.cta_text }}}</a>
					</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}
