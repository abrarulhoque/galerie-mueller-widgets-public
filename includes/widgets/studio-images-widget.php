<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Studio Images Widget
 *
 * 2-image asymmetric grid with hover zoom, captions, and fade-up animation.
 *
 * @since 1.0.0
 */
class Studio_Images_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_studio_images';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Studio Images', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-image-box';
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
		return [ 'studio', 'atelier', 'bilder', 'images', 'gallery', 'grid' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-studio-images-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-studio-images-script' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {
		$this->register_content_images_controls();
		$this->register_content_captions_controls();
		$this->register_content_animation_controls();
		$this->register_style_section_controls();
		$this->register_style_container_controls();
		$this->register_style_grid_controls();
		$this->register_style_image_1_controls();
		$this->register_style_image_2_controls();
		$this->register_style_hover_controls();
		$this->register_style_captions_controls();
	}

	/**
	 * Content Tab: Bilder (Images)
	 */
	private function register_content_images_controls(): void {

		$this->start_controls_section(
			'images_section',
			[
				'label' => esc_html__( 'Bilder', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Control 1: image_1
		$this->add_control(
			'image_1',
			[
				'label'   => esc_html__( 'Bild 1 (Querformat)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);

		// Control 2: image_1_alt
		$this->add_control(
			'image_1_alt',
			[
				'label'       => esc_html__( 'Bild 1 Alternativtext', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Atelier Ansicht',
				'label_block' => true,
			]
		);

		// Control 3: image_2
		$this->add_control(
			'image_2',
			[
				'label'   => esc_html__( 'Bild 2 (Hochformat)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);

		// Control 4: image_2_alt
		$this->add_control(
			'image_2_alt',
			[
				'label'       => esc_html__( 'Bild 2 Alternativtext', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Detail aus dem Atelier',
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Bildunterschriften (Captions)
	 */
	private function register_content_captions_controls(): void {

		$this->start_controls_section(
			'captions_section',
			[
				'label' => esc_html__( 'Bildunterschriften', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Control 5: caption_1_text
		$this->add_control(
			'caption_1_text',
			[
				'label'       => esc_html__( 'Bildunterschrift 1', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Der Arbeitsplatz in natürlichem Licht',
				'label_block' => true,
			]
		);

		// Control 6: caption_2_text
		$this->add_control(
			'caption_2_text',
			[
				'label'       => esc_html__( 'Bildunterschrift 2', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Das Werkzeug und die Hände',
				'label_block' => true,
			]
		);

		// Control 7: show_captions
		$this->add_control(
			'show_captions',
			[
				'label'        => esc_html__( 'Bildunterschriften anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// Control 8: show_caption_2_mobile
		$this->add_control(
			'show_caption_2_mobile',
			[
				'label'        => esc_html__( '2. Bildunterschrift auf Mobil anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'show_captions' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Animation
	 */
	private function register_content_animation_controls(): void {

		$this->start_controls_section(
			'animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Control 9: enable_fade_up
		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Einblend-Animation aktivieren', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// Control 10: animation_duration
		$this->add_control(
			'animation_duration',
			[
				'label'     => esc_html__( 'Animationsdauer', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 100,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default'   => [
					'size' => 600,
					'unit' => 'px',
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		// Control 11: animation_delay
		$this->add_control(
			'animation_delay',
			[
				'label'     => esc_html__( 'Verzögerung', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default'   => [
					'size' => 0,
					'unit' => 'px',
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		// Control 12: animation_distance
		$this->add_control(
			'animation_distance',
			[
				'label'     => esc_html__( 'Animationsweg', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 20,
					'unit' => 'px',
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		// Control 13: animation_threshold
		$this->add_control(
			'animation_threshold',
			[
				'label'     => esc_html__( 'Sichtbarkeitsschwelle', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default'   => [
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
	 * Style Tab: Abschnitt (Section)
	 */
	private function register_style_section_controls(): void {

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Abschnitt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Control 14: section_bg_color
		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Controls 15-17: section_padding (responsive with tablet/mobile defaults)
		$this->add_responsive_control(
			'section_padding',
			[
				'label'          => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', 'em', 'rem', '%' ],
				'default'        => [
					'top'      => 80,
					'right'    => 0,
					'bottom'   => 80,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'tablet_default' => [
					'top'    => 80,
					'right'  => 0,
					'bottom' => 80,
					'left'   => 0,
					'unit'   => 'px',
				],
				'mobile_default' => [
					'top'    => 80,
					'right'  => 0,
					'bottom' => 80,
					'left'   => 0,
					'unit'   => 'px',
				],
				'selectors'      => [
					'{{WRAPPER}} .gm-studio-images' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Container
	 */
	private function register_style_container_controls(): void {

		$this->start_controls_section(
			'container_style',
			[
				'label' => esc_html__( 'Container', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Control 18: container_max_width
		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 600,
						'max' => 1600,
					],
					'%' => [
						'min' => 50,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 1152,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-studio-images__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Control 19: container_padding
		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 24,
					'bottom'   => 0,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-studio-images__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Raster (Grid)
	 */
	private function register_style_grid_controls(): void {

		$this->start_controls_section(
			'grid_style',
			[
				'label' => esc_html__( 'Raster', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Control 20: grid_columns_ratio
		$this->add_control(
			'grid_columns_ratio',
			[
				'label'       => esc_html__( 'Spaltenverhältnis (Desktop)', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1.5fr 1fr',
				'description' => esc_html__( 'z.B. "1.5fr 1fr" oder "1fr 1fr"', 'galerie-mueller-widgets' ),
				'label_block' => true,
				'selectors'   => [
					'{{WRAPPER}} .gm-studio-images__grid' => 'grid-template-columns: {{VALUE}};',
				],
			]
		);

		// Control 21: grid_columns_tablet
		$this->add_control(
			'grid_columns_tablet',
			[
				'label'       => esc_html__( 'Spaltenverhältnis (Tablet)', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1fr 1fr',
				'description' => esc_html__( 'z.B. "1fr 1fr"', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		// Control 22: grid_columns_mobile
		$this->add_control(
			'grid_columns_mobile',
			[
				'label'       => esc_html__( 'Spaltenverhältnis (Mobil)', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1fr',
				'description' => esc_html__( 'z.B. "1fr"', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		// Controls 23-24: grid_gap (responsive with mobile default)
		$this->add_responsive_control(
			'grid_gap',
			[
				'label'          => esc_html__( 'Abstand', 'galerie-mueller-widgets' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'em' ],
				'range'          => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
					'em' => [
						'min'  => 0,
						'max'  => 4,
						'step' => 0.1,
					],
				],
				'default'        => [
					'size' => 24,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors'      => [
					'{{WRAPPER}} .gm-studio-images__grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Control 25: grid_alignment
		$this->add_control(
			'grid_alignment',
			[
				'label'     => esc_html__( 'Vertikale Ausrichtung', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Oben', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Mitte', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Unten', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'stretch' => [
						'title' => esc_html__( 'Strecken', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-v-align-stretch',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__grid' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Bild 1 Stil (Image 1 Style)
	 */
	private function register_style_image_1_controls(): void {

		$this->start_controls_section(
			'image_1_style',
			[
				'label' => esc_html__( 'Bild 1 Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Control 26: image_1_aspect_ratio
		$this->add_control(
			'image_1_aspect_ratio',
			[
				'label'     => esc_html__( 'Seitenverhältnis', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3/2',
				'options'   => [
					'auto' => esc_html__( 'Automatisch', 'galerie-mueller-widgets' ),
					'1/1'  => '1:1 (Quadrat)',
					'3/2'  => '3:2 (Querformat)',
					'4/3'  => '4:3',
					'16/9' => '16:9',
					'2/3'  => '2:3 (Hochformat)',
					'3/4'  => '3:4',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__figure--1' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		// Control 27: image_1_border_radius
		$this->add_control(
			'image_1_border_radius',
			[
				'label'      => esc_html__( 'Eckenradius', 'galerie-mueller-widgets' ),
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
					'{{WRAPPER}} .gm-studio-images__figure--1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Control 28: image_1_overflow
		$this->add_control(
			'image_1_overflow',
			[
				'label'     => esc_html__( 'Überlauf', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hidden',
				'options'   => [
					'hidden'  => esc_html__( 'Versteckt', 'galerie-mueller-widgets' ),
					'visible' => esc_html__( 'Sichtbar', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__figure--1' => 'overflow: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Bild 2 Stil (Image 2 Style)
	 */
	private function register_style_image_2_controls(): void {

		$this->start_controls_section(
			'image_2_style',
			[
				'label' => esc_html__( 'Bild 2 Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Control 29: image_2_aspect_ratio
		$this->add_control(
			'image_2_aspect_ratio',
			[
				'label'     => esc_html__( 'Seitenverhältnis', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3/4',
				'options'   => [
					'auto' => esc_html__( 'Automatisch', 'galerie-mueller-widgets' ),
					'1/1'  => '1:1 (Quadrat)',
					'3/2'  => '3:2 (Querformat)',
					'4/3'  => '4:3',
					'16/9' => '16:9',
					'2/3'  => '2:3 (Hochformat)',
					'3/4'  => '3:4',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__figure--2' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		// Control 30: image_2_border_radius
		$this->add_control(
			'image_2_border_radius',
			[
				'label'      => esc_html__( 'Eckenradius', 'galerie-mueller-widgets' ),
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
					'{{WRAPPER}} .gm-studio-images__figure--2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Control 31: image_2_overflow
		$this->add_control(
			'image_2_overflow',
			[
				'label'     => esc_html__( 'Überlauf', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hidden',
				'options'   => [
					'hidden'  => esc_html__( 'Versteckt', 'galerie-mueller-widgets' ),
					'visible' => esc_html__( 'Sichtbar', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__figure--2' => 'overflow: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Hover-Effekt (Hover Effect)
	 */
	private function register_style_hover_controls(): void {

		$this->start_controls_section(
			'hover_style',
			[
				'label' => esc_html__( 'Hover-Effekt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Control 32: enable_hover_zoom
		$this->add_control(
			'enable_hover_zoom',
			[
				'label'        => esc_html__( 'Hover-Zoom aktivieren', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// Control 33: hover_scale
		$this->add_control(
			'hover_scale',
			[
				'label'     => esc_html__( 'Zoom-Stärke', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 1.3,
						'step' => 0.01,
					],
				],
				'default'   => [
					'size' => 1.03,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__figure:hover .gm-studio-images__img' => 'transform: scale({{SIZE}});',
				],
				'condition' => [
					'enable_hover_zoom' => 'yes',
				],
			]
		);

		// Control 34: hover_transition_duration
		$this->add_control(
			'hover_transition_duration',
			[
				'label'     => esc_html__( 'Übergangsdauer', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default'   => [
					'size' => 700,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__img' => 'transition-duration: {{SIZE}}ms;',
				],
				'condition' => [
					'enable_hover_zoom' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Bildunterschriften Stil (Captions Style)
	 */
	private function register_style_captions_controls(): void {

		$this->start_controls_section(
			'captions_style',
			[
				'label'     => esc_html__( 'Bildunterschriften Stil', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_captions' => 'yes',
				],
			]
		);

		// Control 35: captions_typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'captions_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-studio-images__caption',
			]
		);

		// Control 36: captions_color
		$this->add_control(
			'captions_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__caption' => 'color: {{VALUE}};',
				],
			]
		);

		// Control 37: captions_top_spacing
		$this->add_responsive_control(
			'captions_top_spacing',
			[
				'label'      => esc_html__( 'Oberer Abstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-studio-images__captions' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Control 38: captions_padding
		$this->add_control(
			'captions_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 0,
					'right'    => 8,
					'bottom'   => 0,
					'left'     => 8,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-studio-images__captions' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Control 39: captions_alignment
		$this->add_control(
			'captions_alignment',
			[
				'label'     => esc_html__( 'Ausrichtung', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Links', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Mitte', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-center',
					],
					'space-between' => [
						'title' => esc_html__( 'Verteilt', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-stretch',
					],
					'flex-end' => [
						'title' => esc_html__( 'Rechts', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'space-between',
				'selectors' => [
					'{{WRAPPER}} .gm-studio-images__captions' => 'justify-content: {{VALUE}};',
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

		// --- Animation setup ---
		$enable_animation = 'yes' === $settings['enable_fade_up'];
		$inner_class = 'gm-studio-images__inner';
		if ( $enable_animation ) {
			$inner_class .= ' gm-studio-images__inner--hidden';
		}

		$this->add_render_attribute( 'inner', 'class', $inner_class );

		if ( $enable_animation ) {
			$this->add_render_attribute( 'inner', [
				'data-animation-duration'  => $settings['animation_duration']['size'] ?? 600,
				'data-animation-delay'     => $settings['animation_delay']['size'] ?? 0,
				'data-animation-distance'  => $settings['animation_distance']['size'] ?? 20,
				'data-animation-threshold' => $settings['animation_threshold']['size'] ?? 0.15,
			] );
		}

		// --- Hover setup ---
		$enable_hover = 'yes' === $settings['enable_hover_zoom'];
		$figure_class = 'gm-studio-images__figure';
		if ( ! $enable_hover ) {
			$figure_class .= ' gm-studio-images__figure--no-hover';
		}

		// --- Image 1 ---
		$image_1_url = '';
		if ( ! empty( $settings['image_1']['url'] ) ) {
			$image_1_url = $settings['image_1']['url'];
		}
		$image_1_alt = ! empty( $settings['image_1_alt'] ) ? $settings['image_1_alt'] : '';

		// --- Image 2 ---
		$image_2_url = '';
		if ( ! empty( $settings['image_2']['url'] ) ) {
			$image_2_url = $settings['image_2']['url'];
		}
		$image_2_alt = ! empty( $settings['image_2_alt'] ) ? $settings['image_2_alt'] : '';

		// --- Caption 2 mobile visibility ---
		$caption_2_class = 'gm-studio-images__caption gm-studio-images__caption--2';
		if ( 'yes' === $settings['show_caption_2_mobile'] ) {
			$caption_2_class .= ' gm-studio-images__caption--mobile-visible';
		}

		// --- Grid column ratios (custom selectors via data attributes) ---
		$grid_columns_desktop = ! empty( $settings['grid_columns_ratio'] ) ? $settings['grid_columns_ratio'] : '1.5fr 1fr';
		$grid_columns_tablet  = ! empty( $settings['grid_columns_tablet'] ) ? $settings['grid_columns_tablet'] : '1fr 1fr';
		$grid_columns_mobile  = ! empty( $settings['grid_columns_mobile'] ) ? $settings['grid_columns_mobile'] : '1fr';

		$this->add_render_attribute( 'grid', [
			'class' => 'gm-studio-images__grid',
			'data-columns-desktop' => esc_attr( $grid_columns_desktop ),
			'data-columns-tablet'  => esc_attr( $grid_columns_tablet ),
			'data-columns-mobile'  => esc_attr( $grid_columns_mobile ),
		] );

		?>
		<section class="gm-studio-images">
			<div <?php $this->print_render_attribute_string( 'inner' ); ?>>

				<div <?php $this->print_render_attribute_string( 'grid' ); ?>>

					<?php if ( $image_1_url ) : ?>
						<div class="<?php echo esc_attr( $figure_class . ' gm-studio-images__figure--1' ); ?>">
							<img
								class="gm-studio-images__img gm-studio-images__img--1"
								src="<?php echo esc_url( $image_1_url ); ?>"
								alt="<?php echo esc_attr( $image_1_alt ); ?>"
								loading="lazy"
							/>
						</div>
					<?php endif; ?>

					<?php if ( $image_2_url ) : ?>
						<div class="<?php echo esc_attr( $figure_class . ' gm-studio-images__figure--2' ); ?>">
							<img
								class="gm-studio-images__img gm-studio-images__img--2"
								src="<?php echo esc_url( $image_2_url ); ?>"
								alt="<?php echo esc_attr( $image_2_alt ); ?>"
								loading="lazy"
							/>
						</div>
					<?php endif; ?>

				</div>

				<?php if ( 'yes' === $settings['show_captions'] ) : ?>
					<div class="gm-studio-images__captions">

						<?php if ( ! empty( $settings['caption_1_text'] ) ) : ?>
							<span class="gm-studio-images__caption gm-studio-images__caption--1">
								<?php echo esc_html( $settings['caption_1_text'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $settings['caption_2_text'] ) ) : ?>
							<span class="<?php echo esc_attr( $caption_2_class ); ?>">
								<?php echo esc_html( $settings['caption_2_text'] ); ?>
							</span>
						<?php endif; ?>

					</div>
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
		var innerClass = 'gm-studio-images__inner';
		if ( 'yes' === settings.enable_fade_up ) {
			innerClass += ' gm-studio-images__inner--hidden';
		}

		var figureClass = 'gm-studio-images__figure';
		if ( 'yes' !== settings.enable_hover_zoom ) {
			figureClass += ' gm-studio-images__figure--no-hover';
		}

		var caption2Class = 'gm-studio-images__caption gm-studio-images__caption--2';
		if ( 'yes' === settings.show_caption_2_mobile ) {
			caption2Class += ' gm-studio-images__caption--mobile-visible';
		}
		#>
		<section class="gm-studio-images">
			<div class="{{ innerClass }}">

				<div class="gm-studio-images__grid">

					<# if ( settings.image_1.url ) { #>
						<div class="{{ figureClass }} gm-studio-images__figure--1">
							<img
								class="gm-studio-images__img gm-studio-images__img--1"
								src="{{ settings.image_1.url }}"
								alt="{{ settings.image_1_alt }}"
							/>
						</div>
					<# } #>

					<# if ( settings.image_2.url ) { #>
						<div class="{{ figureClass }} gm-studio-images__figure--2">
							<img
								class="gm-studio-images__img gm-studio-images__img--2"
								src="{{ settings.image_2.url }}"
								alt="{{ settings.image_2_alt }}"
							/>
						</div>
					<# } #>

				</div>

				<# if ( 'yes' === settings.show_captions ) { #>
					<div class="gm-studio-images__captions">

						<# if ( settings.caption_1_text ) { #>
							<span class="gm-studio-images__caption gm-studio-images__caption--1">
								{{{ settings.caption_1_text }}}
							</span>
						<# } #>

						<# if ( settings.caption_2_text ) { #>
							<span class="{{ caption2Class }}">
								{{{ settings.caption_2_text }}}
							</span>
						<# } #>

					</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}
