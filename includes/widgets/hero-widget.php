<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

/**
 * Hero Widget
 *
 * Full-viewport hero section with background image, dark overlay,
 * title, subtitle, CTA button, and animated scroll indicator.
 *
 * @since 1.0.0
 */
class Hero_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_hero';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Hero', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-banner';
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
		return [ 'hero', 'banner', 'fullscreen', 'gallery', 'galerie' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-hero-style' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_style_layout_controls();
		$this->register_style_overlay_controls();
		$this->register_style_subtitle_controls();
		$this->register_style_title_controls();
		$this->register_style_button_controls();
		$this->register_style_scroll_indicator_controls();
		$this->register_style_background_controls();
	}

	/**
	 * Content Tab: Content Section
	 */
	private function register_content_controls(): void {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle_text',
			[
				'label'       => esc_html__( 'Subtitle Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Malerei · Zeichnung · Skizzen',
				'placeholder' => esc_html__( 'Enter subtitle text', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Wolfgang Mueller',
				'placeholder' => esc_html__( 'Enter title text', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'p'    => 'p',
					'span' => 'span',
					'div'  => 'div',
				],
			]
		);

		$this->add_control(
			'cta_text',
			[
				'label'       => esc_html__( 'Button Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Werke entdecken',
				'placeholder' => esc_html__( 'Enter button text', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'cta_link',
			[
				'label'       => esc_html__( 'Button Link', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'url'         => '/galerie',
					'is_external' => false,
					'nofollow'    => false,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'      => esc_html__( 'Background Image', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::MEDIA,
				'default'    => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'media_types' => [ 'image' ],
			]
		);

		$this->add_control(
			'background_image_alt',
			[
				'label'       => esc_html__( 'Image Alt Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Galerie Mueller Innenraum',
				'placeholder' => esc_html__( 'Describe the image', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_scroll_indicator',
			[
				'label'        => esc_html__( 'Show Scroll Indicator', 'galerie-mueller-widgets' ),
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
	 * Style Tab: Layout Section
	 */
	private function register_style_layout_controls(): void {

		$this->start_controls_section(
			'style_layout_section',
			[
				'label' => esc_html__( 'Layout', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_min_height',
			[
				'label'      => esc_html__( 'Minimum Height', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'vh', 'px', 'em' ],
				'range'      => [
					'vh' => [ 'min' => 10, 'max' => 100 ],
					'px' => [ 'min' => 200, 'max' => 1200 ],
					'em' => [ 'min' => 10, 'max' => 80 ],
				],
				'default'    => [
					'size' => 100,
					'unit' => 'vh',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Content Alignment', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_items_alignment',
			[
				'label'   => esc_html__( 'Items Alignment', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__content' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_vertical_position',
			[
				'label'   => esc_html__( 'Vertical Position', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-hero' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'      => esc_html__( 'Content Max Width', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => 20, 'max' => 100 ],
					'px' => [ 'min' => 200, 'max' => 1200 ],
				],
				'default'    => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Section Padding', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 24,
					'bottom'   => 0,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Overlay Section
	 */
	private function register_style_overlay_controls(): void {

		$this->start_controls_section(
			'style_overlay_section',
			[
				'label' => esc_html__( 'Overlay', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label'   => esc_html__( 'Overlay Opacity', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.4,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__overlay' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Subtitle Style Section
	 */
	private function register_style_subtitle_controls(): void {

		$this->start_controls_section(
			'style_subtitle_section',
			[
				'label' => esc_html__( 'Subtitle', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .gm-hero__subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_letter_spacing',
			[
				'label'      => esc_html__( 'Letter Spacing', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'em', 'px' ],
				'range'      => [
					'em' => [ 'min' => 0, 'max' => 1, 'step' => 0.01 ],
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [
					'size' => 0.4,
					'unit' => 'em',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__subtitle' => 'letter-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'subtitle_text_transform',
			[
				'label'     => esc_html__( 'Text Transform', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'uppercase',
				'options'   => [
					'none'       => esc_html__( 'None', 'galerie-mueller-widgets' ),
					'uppercase'  => esc_html__( 'Uppercase', 'galerie-mueller-widgets' ),
					'lowercase'  => esc_html__( 'Lowercase', 'galerie-mueller-widgets' ),
					'capitalize' => esc_html__( 'Capitalize', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__subtitle' => 'text-transform: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Margin', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Title Style Section
	 */
	private function register_style_title_controls(): void {

		$this->start_controls_section(
			'style_title_section',
			[
				'label' => esc_html__( 'Title', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gm-hero__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .gm-hero__title',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Button Style Section (with Normal/Hover tabs)
	 */
	private function register_style_button_controls(): void {

		$this->start_controls_section(
			'style_button_section',
			[
				'label' => esc_html__( 'Button', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Normal / Hover tabs.
		$this->start_controls_tabs( 'button_style_tabs' );

		// --- Normal Tab ---
		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// --- Hover Tab ---
		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta:hover, {{WRAPPER}} .gm-hero__cta:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta:hover, {{WRAPPER}} .gm-hero__cta:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta:hover, {{WRAPPER}} .gm-hero__cta:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// --- Shared controls (outside tabs) ---

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'selector'  => '{{WRAPPER}} .gm-hero__cta',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'   => esc_html__( 'Border Width', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 10 ],
				],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 12,
					'right'    => 32,
					'bottom'   => 12,
					'left'     => 32,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => esc_html__( 'Margin', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 16,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-hero__cta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_transition_duration',
			[
				'label'   => esc_html__( 'Transition Duration (ms)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 1000, 'step' => 50 ],
				],
				'default' => [
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__cta' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Scroll Indicator Section
	 */
	private function register_style_scroll_indicator_controls(): void {

		$this->start_controls_section(
			'style_scroll_indicator_section',
			[
				'label'     => esc_html__( 'Scroll Indicator', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_scroll_indicator' => 'yes',
				],
			]
		);

		$this->add_control(
			'scroll_indicator_color',
			[
				'label'     => esc_html__( 'Icon Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.6)',
				'selectors' => [
					'{{WRAPPER}} .gm-hero__scroll-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_indicator_size',
			[
				'label'   => esc_html__( 'Icon Size', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 10, 'max' => 60 ],
				],
				'default' => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__scroll-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_indicator_bottom_offset',
			[
				'label'   => esc_html__( 'Bottom Offset', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__scroll-indicator' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scroll_indicator_animation_speed',
			[
				'label'   => esc_html__( 'Animation Speed (s)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
				],
				'default' => [
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__scroll-icon' => 'animation-duration: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Background Image Section
	 */
	private function register_style_background_controls(): void {

		$this->start_controls_section(
			'style_background_section',
			[
				'label' => esc_html__( 'Background Image', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_image_position',
			[
				'label'   => esc_html__( 'Image Position', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'top left'      => esc_html__( 'Top Left', 'galerie-mueller-widgets' ),
					'top center'    => esc_html__( 'Top Center', 'galerie-mueller-widgets' ),
					'top right'     => esc_html__( 'Top Right', 'galerie-mueller-widgets' ),
					'center left'   => esc_html__( 'Center Left', 'galerie-mueller-widgets' ),
					'center center' => esc_html__( 'Center Center', 'galerie-mueller-widgets' ),
					'center right'  => esc_html__( 'Center Right', 'galerie-mueller-widgets' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'galerie-mueller-widgets' ),
					'bottom center' => esc_html__( 'Bottom Center', 'galerie-mueller-widgets' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__bg-image' => 'object-position: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_image_size',
			[
				'label'   => esc_html__( 'Image Size', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'   => esc_html__( 'Cover', 'galerie-mueller-widgets' ),
					'contain' => esc_html__( 'Contain', 'galerie-mueller-widgets' ),
					'auto'    => esc_html__( 'Auto', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-hero__bg-image' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// CTA link attributes.
		if ( ! empty( $settings['cta_link']['url'] ) ) {
			$this->add_link_attributes( 'cta_link', $settings['cta_link'] );
		}

		// Title HTML tag.
		$title_tag = ! empty( $settings['title_html_tag'] ) ? $settings['title_html_tag'] : 'h1';
		$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ];
		if ( ! in_array( $title_tag, $allowed_tags, true ) ) {
			$title_tag = 'h1';
		}

		// Background image.
		$bg_url = ! empty( $settings['background_image']['url'] ) ? $settings['background_image']['url'] : '';
		$bg_alt = ! empty( $settings['background_image_alt'] ) ? $settings['background_image_alt'] : '';
		?>

		<section class="gm-hero">
			<?php if ( ! empty( $bg_url ) ) : ?>
				<img
					src="<?php echo esc_url( $bg_url ); ?>"
					alt="<?php echo esc_attr( $bg_alt ); ?>"
					class="gm-hero__bg-image"
					loading="eager"
				/>
			<?php endif; ?>

			<div class="gm-hero__overlay"></div>

			<div class="gm-hero__content">
				<?php if ( ! empty( $settings['subtitle_text'] ) ) : ?>
					<p class="gm-hero__subtitle">
						<?php echo esc_html( $settings['subtitle_text'] ); ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['title_text'] ) ) : ?>
					<<?php echo esc_attr( $title_tag ); ?> class="gm-hero__title">
						<?php echo esc_html( $settings['title_text'] ); ?>
					</<?php echo esc_attr( $title_tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $settings['cta_text'] ) ) : ?>
					<a class="gm-hero__cta" <?php $this->print_render_attribute_string( 'cta_link' ); ?>>
						<?php echo esc_html( $settings['cta_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' === $settings['show_scroll_indicator'] ) : ?>
				<div class="gm-hero__scroll-indicator">
					<svg class="gm-hero__scroll-icon" xmlns="http://www.w3.org/2000/svg"
						 viewBox="0 0 24 24" fill="none" stroke="currentColor"
						 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="m6 9 6 6 6-6"/>
					</svg>
				</div>
			<?php endif; ?>
		</section>

		<?php
	}

	/**
	 * Render widget output in the editor (JS template).
	 *
	 * @since 1.0.0
	 */
	protected function content_template(): void {
		?>
		<#
		var titleTag = settings.title_html_tag || 'h1';
		var allowedTags = ['h1','h2','h3','h4','h5','h6','p','span','div'];
		if ( allowedTags.indexOf( titleTag ) === -1 ) {
			titleTag = 'h1';
		}

		var bgUrl = '';
		if ( settings.background_image && settings.background_image.url ) {
			bgUrl = settings.background_image.url;
		}
		var bgAlt = settings.background_image_alt || '';
		#>

		<section class="gm-hero">
			<# if ( bgUrl ) { #>
				<img
					src="{{ bgUrl }}"
					alt="{{ bgAlt }}"
					class="gm-hero__bg-image"
				/>
			<# } #>

			<div class="gm-hero__overlay"></div>

			<div class="gm-hero__content">
				<# if ( settings.subtitle_text ) { #>
					<p class="gm-hero__subtitle">{{{ settings.subtitle_text }}}</p>
				<# } #>

				<# if ( settings.title_text ) { #>
					<{{{ titleTag }}} class="gm-hero__title">{{{ settings.title_text }}}</{{{ titleTag }}}>
				<# } #>

				<# if ( settings.cta_text ) { #>
					<#
					var ctaUrl = '#';
					var target = '';
					var nofollow = '';
					if ( settings.cta_link && settings.cta_link.url ) {
						ctaUrl = settings.cta_link.url;
					}
					if ( settings.cta_link && settings.cta_link.is_external ) {
						target = ' target="_blank"';
					}
					if ( settings.cta_link && settings.cta_link.nofollow ) {
						nofollow = ' rel="nofollow"';
					}
					#>
					<a class="gm-hero__cta" href="{{ ctaUrl }}"{{{ target }}}{{{ nofollow }}}>{{{ settings.cta_text }}}</a>
				<# } #>
			</div>

			<# if ( 'yes' === settings.show_scroll_indicator ) { #>
				<div class="gm-hero__scroll-indicator">
					<svg class="gm-hero__scroll-icon" xmlns="http://www.w3.org/2000/svg"
						 viewBox="0 0 24 24" fill="none" stroke="currentColor"
						 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="m6 9 6 6 6-6"/>
					</svg>
				</div>
			<# } #>
		</section>
		<?php
	}
}
