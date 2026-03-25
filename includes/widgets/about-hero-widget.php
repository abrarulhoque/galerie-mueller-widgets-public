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
 * About Hero Widget
 *
 * Page hero section for the About page with background image, dark overlay,
 * accent line, subtitle, title, tagline, and breadcrumb navigation.
 *
 * @since 1.0.0
 */
class About_Hero_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_about_hero';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - About Hero', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-image-bold';
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
		return [ 'about', 'hero', 'über', 'künstler', 'banner', 'header', 'breadcrumb' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-about-hero-style' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_breadcrumb_content_controls();
		$this->register_overlay_content_controls();
		$this->register_style_section_controls();
		$this->register_style_overlay_controls();
		$this->register_style_content_layout_controls();
		$this->register_style_accent_line_controls();
		$this->register_style_subtitle_controls();
		$this->register_style_title_controls();
		$this->register_style_tagline_controls();
		$this->register_style_breadcrumb_controls();
		$this->register_style_bg_image_controls();
	}

	/**
	 * Content Tab: Inhalt Section
	 */
	private function register_content_controls(): void {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Inhalt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'   => esc_html__( 'Hintergrundbild', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'background_image_alt',
			[
				'label'   => esc_html__( 'Bild-Alternativtext', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Wolfgang Mueller Studio',
			]
		);

		$this->add_control(
			'subtitle_text',
			[
				'label'   => esc_html__( 'Untertitel', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'ÜBER DEN KÜNSTLER',
			]
		);

		$this->add_control(
			'subtitle_html_tag',
			[
				'label'   => esc_html__( 'Untertitel HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
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
			'title_text',
			[
				'label'   => esc_html__( 'Titel', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Wolfgang Mueller',
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'   => esc_html__( 'Titel HTML-Tag', 'galerie-mueller-widgets' ),
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
			'tagline_text',
			[
				'label'   => esc_html__( 'Untertitel-Zeile', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Maler · Zeichner · Künstler',
			]
		);

		$this->add_control(
			'tagline_html_tag',
			[
				'label'   => esc_html__( 'Untertitel-Zeile HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'p',
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
			'show_accent_line',
			[
				'label'        => esc_html__( 'Akzentlinie anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_breadcrumb',
			[
				'label'        => esc_html__( 'Breadcrumb anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Breadcrumb Section
	 */
	private function register_breadcrumb_content_controls(): void {

		$this->start_controls_section(
			'breadcrumb_section',
			[
				'label'     => esc_html__( 'Breadcrumb', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'breadcrumb_home_text',
			[
				'label'   => esc_html__( 'Startseite Text', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Startseite',
			]
		);

		$this->add_control(
			'breadcrumb_home_link',
			[
				'label'   => esc_html__( 'Startseite Link', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '/',
					'is_external' => false,
					'nofollow'    => false,
				],
				'show_external' => true,
			]
		);

		$this->add_control(
			'breadcrumb_current_text',
			[
				'label'   => esc_html__( 'Aktuelle Seite Text', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Über den Künstler',
			]
		);

		$this->add_control(
			'breadcrumb_separator',
			[
				'label'   => esc_html__( 'Trennzeichen', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '/',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Overlay Section
	 */
	private function register_overlay_content_controls(): void {

		$this->start_controls_section(
			'overlay_section',
			[
				'label' => esc_html__( 'Overlay', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_overlay',
			[
				'label'        => esc_html__( 'Overlay anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Bereich (Section) Controls
	 */
	private function register_style_section_controls(): void {

		$this->start_controls_section(
			'style_section_section',
			[
				'label' => esc_html__( 'Bereich', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_height',
			[
				'label'      => esc_html__( 'Höhe', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'vh', 'px' ],
				'range'      => [
					'vh' => [ 'min' => 20, 'max' => 100 ],
					'px' => [ 'min' => 200, 'max' => 1200 ],
				],
				'default' => [
					'size' => 50,
					'unit' => 'vh',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_overflow',
			[
				'label'   => esc_html__( 'Überlauf', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hidden',
				'options' => [
					'hidden'  => esc_html__( 'Versteckt', 'galerie-mueller-widgets' ),
					'visible' => esc_html__( 'Sichtbar', 'galerie-mueller-widgets' ),
					'auto'    => esc_html__( 'Auto', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero' => 'overflow: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Overlay Stil
	 */
	private function register_style_overlay_controls(): void {

		$this->start_controls_section(
			'style_overlay_section',
			[
				'label'     => esc_html__( 'Overlay Stil', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'   => esc_html__( 'Overlay-Farbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label'   => esc_html__( 'Overlay-Deckkraft', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default' => [
					'size' => 0.6,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__overlay' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Inhalt Layout
	 */
	private function register_style_content_layout_controls(): void {

		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__( 'Inhalt Layout', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 1400 ],
					'%'  => [ 'min' => 20, 'max' => 100 ],
				],
				'default' => [
					'size' => 896,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 16,
					'bottom'   => 0,
					'left'     => 16,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_margin_top',
			[
				'label'      => esc_html__( 'Oberer Abstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 200 ],
					'em' => [ 'min' => 0, 'max' => 12 ],
				],
				'default' => [
					'size' => 64,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Ausrichtung', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Links', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Mitte', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Rechts', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start;',
					'center' => 'text-align: center; align-items: center;',
					'right'  => 'text-align: right; align-items: flex-end;',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__content' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Akzentlinie Stil
	 */
	private function register_style_accent_line_controls(): void {

		$this->start_controls_section(
			'style_accent_line_section',
			[
				'label'     => esc_html__( 'Akzentlinie Stil', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_accent_line' => 'yes',
				],
			]
		);

		$this->add_control(
			'accent_line_width',
			[
				'label'      => esc_html__( 'Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 200 ],
				],
				'default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_height',
			[
				'label'      => esc_html__( 'Höhe', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10 ],
				],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_color',
			[
				'label'   => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__accent-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_line_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
					'em' => [ 'min' => 0, 'max' => 5 ],
				],
				'default' => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__accent-line' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Untertitel Stil
	 */
	private function register_style_subtitle_controls(): void {

		$this->start_controls_section(
			'style_subtitle_section',
			[
				'label' => esc_html__( 'Untertitel Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .gm-about-hero__subtitle',
				'fields_options' => [
					'font_family'    => [ 'default' => 'Inter' ],
					'font_size'      => [ 'default' => [ 'size' => 13, 'unit' => 'px' ] ],
					'font_weight'    => [ 'default' => '400' ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 3.25, 'unit' => 'px' ] ],
					'line_height'    => [ 'default' => [ 'size' => 1.5, 'unit' => 'em' ] ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'   => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.8)',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
					'em' => [ 'min' => 0, 'max' => 5 ],
				],
				'default' => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Titel Stil
	 */
	private function register_style_title_controls(): void {

		$this->start_controls_section(
			'style_title_section',
			[
				'label' => esc_html__( 'Titel Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gm-about-hero__title',
				'fields_options' => [
					'font_family' => [ 'default' => 'Playfair Display' ],
					'font_size'   => [
						'default'        => [ 'size' => 56, 'unit' => 'px' ],
						'tablet_default' => [ 'size' => 48, 'unit' => 'px' ],
						'mobile_default' => [ 'size' => 36, 'unit' => 'px' ],
					],
					'font_weight' => [ 'default' => '500' ],
					'line_height' => [ 'default' => [ 'size' => 1.1, 'unit' => 'em' ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'   => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
					'em' => [ 'min' => 0, 'max' => 5 ],
				],
				'default' => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .gm-about-hero__title',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Untertitel-Zeile Stil (Tagline)
	 */
	private function register_style_tagline_controls(): void {

		$this->start_controls_section(
			'style_tagline_section',
			[
				'label' => esc_html__( 'Untertitel-Zeile Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tagline_typography',
				'selector' => '{{WRAPPER}} .gm-about-hero__tagline',
				'fields_options' => [
					'font_family' => [ 'default' => 'Inter' ],
					'font_size'   => [ 'default' => [ 'size' => 15, 'unit' => 'px' ] ],
					'font_weight' => [ 'default' => '300' ],
					'line_height' => [ 'default' => [ 'size' => 1.5, 'unit' => 'em' ] ],
				],
			]
		);

		$this->add_control(
			'tagline_color',
			[
				'label'   => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.6)',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__tagline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tagline_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 120 ],
					'em' => [ 'min' => 0, 'max' => 8 ],
				],
				'default' => [
					'size' => 48,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__tagline' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Breadcrumb Stil
	 */
	private function register_style_breadcrumb_controls(): void {

		$this->start_controls_section(
			'style_breadcrumb_section',
			[
				'label'     => esc_html__( 'Breadcrumb Stil', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'breadcrumb_typography',
				'selector' => '{{WRAPPER}} .gm-about-hero__breadcrumb',
				'fields_options' => [
					'font_family'    => [ 'default' => 'Inter' ],
					'font_size'      => [ 'default' => [ 'size' => 12, 'unit' => 'px' ] ],
					'font_weight'    => [ 'default' => '400' ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.3, 'unit' => 'px' ] ],
					'line_height'    => [ 'default' => [ 'size' => 1.4, 'unit' => 'em' ] ],
				],
			]
		);

		$this->add_control(
			'breadcrumb_color',
			[
				'label'   => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.5)',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__breadcrumb' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_link_hover_color',
			[
				'label'   => esc_html__( 'Link Hover-Farbe', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__breadcrumb-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_link_transition',
			[
				'label'   => esc_html__( 'Transition Dauer', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 1000, 'step' => 50 ],
				],
				'default' => [
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__breadcrumb-link' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->add_control(
			'breadcrumb_separator_spacing',
			[
				'label'      => esc_html__( 'Trennzeichen Abstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 30 ],
				],
				'default' => [
					'size' => 8,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-about-hero__breadcrumb-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Hintergrundbild Stil
	 */
	private function register_style_bg_image_controls(): void {

		$this->start_controls_section(
			'style_bg_image_section',
			[
				'label' => esc_html__( 'Hintergrundbild Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_image_position',
			[
				'label'       => esc_html__( 'Bildposition', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'center 30%',
				'render_type' => 'template',
				'options'     => [
					'top left'      => esc_html__( 'Oben Links', 'galerie-mueller-widgets' ),
					'top center'    => esc_html__( 'Oben Mitte', 'galerie-mueller-widgets' ),
					'top right'     => esc_html__( 'Oben Rechts', 'galerie-mueller-widgets' ),
					'center left'   => esc_html__( 'Mitte Links', 'galerie-mueller-widgets' ),
					'center center' => esc_html__( 'Mitte Mitte', 'galerie-mueller-widgets' ),
					'center 30%'    => esc_html__( 'Mitte 30%', 'galerie-mueller-widgets' ),
					'center right'  => esc_html__( 'Mitte Rechts', 'galerie-mueller-widgets' ),
					'bottom left'   => esc_html__( 'Unten Links', 'galerie-mueller-widgets' ),
					'bottom center' => esc_html__( 'Unten Mitte', 'galerie-mueller-widgets' ),
					'bottom right'  => esc_html__( 'Unten Rechts', 'galerie-mueller-widgets' ),
				],
			]
		);

		$this->add_control(
			'bg_image_size',
			[
				'label'       => esc_html__( 'Bildgröße', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'cover',
				'render_type' => 'template',
				'options'     => [
					'cover'   => esc_html__( 'Abdecken', 'galerie-mueller-widgets' ),
					'contain' => esc_html__( 'Enthalten', 'galerie-mueller-widgets' ),
					'auto'    => esc_html__( 'Auto', 'galerie-mueller-widgets' ),
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

		// Inline editing attributes.
		$this->add_inline_editing_attributes( 'subtitle_text', 'none' );
		$this->add_inline_editing_attributes( 'title_text', 'none' );
		$this->add_inline_editing_attributes( 'tagline_text', 'none' );
		$this->add_inline_editing_attributes( 'breadcrumb_home_text', 'none' );
		$this->add_inline_editing_attributes( 'breadcrumb_current_text', 'none' );

		// Home link attributes.
		if ( ! empty( $settings['breadcrumb_home_link']['url'] ) ) {
			$this->add_link_attributes( 'home_link_attr', $settings['breadcrumb_home_link'] );
			$this->add_render_attribute( 'home_link_attr', 'class', 'gm-about-hero__breadcrumb-link' );
		}

		// HTML tags (sanitised).
		$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ];

		$subtitle_tag = $settings['subtitle_html_tag'] ?? 'h2';
		if ( ! in_array( $subtitle_tag, $allowed_tags, true ) ) {
			$subtitle_tag = 'h2';
		}

		$title_tag = $settings['title_html_tag'] ?? 'h1';
		if ( ! in_array( $title_tag, $allowed_tags, true ) ) {
			$title_tag = 'h1';
		}

		$tagline_tag = $settings['tagline_html_tag'] ?? 'p';
		if ( ! in_array( $tagline_tag, $allowed_tags, true ) ) {
			$tagline_tag = 'p';
		}

		// Background image.
		$bg_url      = $settings['background_image']['url'] ?? '';
		$bg_alt      = $settings['background_image_alt'] ?? '';
		$bg_position = $settings['bg_image_position'] ?? 'center 30%';
		$bg_size     = $settings['bg_image_size'] ?? 'cover';
		?>
		<section class="gm-about-hero">

			<!-- Background Image -->
			<div class="gm-about-hero__bg-wrapper">
				<?php if ( ! empty( $bg_url ) ) : ?>
					<img
						class="gm-about-hero__bg-image"
						src="<?php echo esc_url( $bg_url ); ?>"
						alt="<?php echo esc_attr( $bg_alt ); ?>"
						style="object-position: <?php echo esc_attr( $bg_position ); ?>; object-fit: <?php echo esc_attr( $bg_size ); ?>;"
						loading="eager"
					/>
				<?php endif; ?>

				<!-- Dark Overlay -->
				<?php if ( 'yes' === $settings['show_overlay'] ) : ?>
					<div class="gm-about-hero__overlay"></div>
				<?php endif; ?>
			</div>

			<!-- Content -->
			<div class="gm-about-hero__content">

				<!-- Accent Line -->
				<?php if ( 'yes' === $settings['show_accent_line'] ) : ?>
					<div class="gm-about-hero__accent-line"></div>
				<?php endif; ?>

				<!-- Subtitle -->
				<?php if ( ! empty( $settings['subtitle_text'] ) ) : ?>
					<<?php echo esc_html( $subtitle_tag ); ?> class="gm-about-hero__subtitle" <?php $this->print_render_attribute_string( 'subtitle_text' ); ?>>
						<?php echo esc_html( $settings['subtitle_text'] ); ?>
					</<?php echo esc_html( $subtitle_tag ); ?>>
				<?php endif; ?>

				<!-- Title -->
				<?php if ( ! empty( $settings['title_text'] ) ) : ?>
					<<?php echo esc_html( $title_tag ); ?> class="gm-about-hero__title" <?php $this->print_render_attribute_string( 'title_text' ); ?>>
						<?php echo esc_html( $settings['title_text'] ); ?>
					</<?php echo esc_html( $title_tag ); ?>>
				<?php endif; ?>

				<!-- Tagline -->
				<?php if ( ! empty( $settings['tagline_text'] ) ) : ?>
					<<?php echo esc_html( $tagline_tag ); ?> class="gm-about-hero__tagline" <?php $this->print_render_attribute_string( 'tagline_text' ); ?>>
						<?php echo esc_html( $settings['tagline_text'] ); ?>
					</<?php echo esc_html( $tagline_tag ); ?>>
				<?php endif; ?>

				<!-- Breadcrumb -->
				<?php if ( 'yes' === $settings['show_breadcrumb'] ) : ?>
					<nav class="gm-about-hero__breadcrumb">
						<?php if ( ! empty( $settings['breadcrumb_home_text'] ) && ! empty( $settings['breadcrumb_home_link']['url'] ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'home_link_attr' ); ?>
							   <?php $this->print_render_attribute_string( 'breadcrumb_home_text' ); ?>>
								<?php echo esc_html( $settings['breadcrumb_home_text'] ); ?>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $settings['breadcrumb_separator'] ) ) : ?>
							<span class="gm-about-hero__breadcrumb-separator"><?php echo esc_html( $settings['breadcrumb_separator'] ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $settings['breadcrumb_current_text'] ) ) : ?>
							<span class="gm-about-hero__breadcrumb-current" <?php $this->print_render_attribute_string( 'breadcrumb_current_text' ); ?>>
								<?php echo esc_html( $settings['breadcrumb_current_text'] ); ?>
							</span>
						<?php endif; ?>
					</nav>
				<?php endif; ?>

			</div>
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
		var subtitleTag = settings.subtitle_html_tag || 'h2';
		var titleTag    = settings.title_html_tag || 'h1';
		var taglineTag  = settings.tagline_html_tag || 'p';
		var bgUrl       = settings.background_image.url || '';
		var bgAlt       = settings.background_image_alt || '';
		var bgPosition  = settings.bg_image_position || 'center 30%';
		var bgSize      = settings.bg_image_size || 'cover';

		view.addInlineEditingAttributes( 'subtitle_text', 'none' );
		view.addInlineEditingAttributes( 'title_text', 'none' );
		view.addInlineEditingAttributes( 'tagline_text', 'none' );
		view.addInlineEditingAttributes( 'breadcrumb_home_text', 'none' );
		view.addInlineEditingAttributes( 'breadcrumb_current_text', 'none' );
		#>

		<section class="gm-about-hero">

			<!-- Background Image -->
			<div class="gm-about-hero__bg-wrapper">
				<# if ( bgUrl ) { #>
					<img
						class="gm-about-hero__bg-image"
						src="{{ bgUrl }}"
						alt="{{ bgAlt }}"
						style="object-position: {{ bgPosition }}; object-fit: {{ bgSize }};"
					/>
				<# } #>

				<!-- Dark Overlay -->
				<# if ( 'yes' === settings.show_overlay ) { #>
					<div class="gm-about-hero__overlay"></div>
				<# } #>
			</div>

			<!-- Content -->
			<div class="gm-about-hero__content">

				<!-- Accent Line -->
				<# if ( 'yes' === settings.show_accent_line ) { #>
					<div class="gm-about-hero__accent-line"></div>
				<# } #>

				<!-- Subtitle -->
				<# if ( settings.subtitle_text ) { #>
					<{{{ subtitleTag }}} class="gm-about-hero__subtitle" {{{ view.getRenderAttributeString( 'subtitle_text' ) }}}>
						{{{ settings.subtitle_text }}}
					</{{{ subtitleTag }}}>
				<# } #>

				<!-- Title -->
				<# if ( settings.title_text ) { #>
					<{{{ titleTag }}} class="gm-about-hero__title" {{{ view.getRenderAttributeString( 'title_text' ) }}}>
						{{{ settings.title_text }}}
					</{{{ titleTag }}}>
				<# } #>

				<!-- Tagline -->
				<# if ( settings.tagline_text ) { #>
					<{{{ taglineTag }}} class="gm-about-hero__tagline" {{{ view.getRenderAttributeString( 'tagline_text' ) }}}>
						{{{ settings.tagline_text }}}
					</{{{ taglineTag }}}>
				<# } #>

				<!-- Breadcrumb -->
				<# if ( 'yes' === settings.show_breadcrumb ) { #>
					<nav class="gm-about-hero__breadcrumb">
						<# if ( settings.breadcrumb_home_text && settings.breadcrumb_home_link.url ) { #>
							<a class="gm-about-hero__breadcrumb-link"
							   href="{{ settings.breadcrumb_home_link.url }}"
							   {{{ view.getRenderAttributeString( 'breadcrumb_home_text' ) }}}>
								{{{ settings.breadcrumb_home_text }}}
							</a>
						<# } #>

						<# if ( settings.breadcrumb_separator ) { #>
							<span class="gm-about-hero__breadcrumb-separator">{{{ settings.breadcrumb_separator }}}</span>
						<# } #>

						<# if ( settings.breadcrumb_current_text ) { #>
							<span class="gm-about-hero__breadcrumb-current" {{{ view.getRenderAttributeString( 'breadcrumb_current_text' ) }}}>
								{{{ settings.breadcrumb_current_text }}}
							</span>
						<# } #>
					</nav>
				<# } #>

			</div>
		</section>
		<?php
	}
}
