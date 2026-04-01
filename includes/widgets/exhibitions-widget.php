<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Exhibitions Widget
 *
 * Exhibition cards (2-col grid), detail modal with image gallery,
 * keyboard nav, dot indicators, fade-up animation.
 *
 * @since 1.4.0
 */
class Exhibitions_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.4.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_exhibitions';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.4.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Ausstellungen', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.4.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-posts-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.4.0
	 * @return array
	 */
	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.4.0
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'exhibitions', 'ausstellungen', 'gallery', 'modal', 'grid', 'cards' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.4.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-exhibitions-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.4.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-exhibitions-script' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.4.0
	 */
	protected function register_controls(): void {

		/* ==================================================================
		 * TAB_CONTENT
		 * ================================================================== */

		/* ------------------------------------------------------------------
		 * Section 1.1: Inhalt (Content)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Inhalt', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// #1 heading_text
		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Überschrift', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Bisherige Ausstellungen',
				'placeholder' => esc_html__( 'Abschnittstitel eingeben...', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		// #2 heading_tag
		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
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
				],
			]
		);

		// #3 description_text
		$this->add_control(
			'description_text',
			[
				'label'       => esc_html__( 'Beschreibung', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => 'Ein Überblick über ausgewählte Einzel- und Gruppenausstellungen von Wolfgang Mueller — von den Anfängen bis heute.',
				'rows'        => 3,
				'placeholder' => esc_html__( 'Beschreibungstext eingeben...', 'galerie-mueller-widgets' ),
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 1.2: Ausstellungen (Exhibitions Repeater)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'exhibitions_section',
			[
				'label' => esc_html__( 'Ausstellungen', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// #4 exhibitions repeater
		$repeater = new \Elementor\Repeater();

		// #5 exhibition_title
		$repeater->add_control(
			'exhibition_title',
			[
				'label'       => esc_html__( 'Titel', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Ausstellungstitel',
				'placeholder' => esc_html__( 'Ausstellungstitel eingeben...', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		// #6 exhibition_year
		$repeater->add_control(
			'exhibition_year',
			[
				'label'       => esc_html__( 'Jahr', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '2020',
				'placeholder' => esc_html__( 'z.B. 2020', 'galerie-mueller-widgets' ),
			]
		);

		// #7 exhibition_location
		$repeater->add_control(
			'exhibition_location',
			[
				'label'       => esc_html__( 'Ort', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'Galerie am Markt, Darmstadt',
				'placeholder' => esc_html__( 'Ort der Ausstellung...', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		// #8 exhibition_description
		$repeater->add_control(
			'exhibition_description',
			[
				'label'       => esc_html__( 'Beschreibung', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => '',
				'rows'        => 4,
				'placeholder' => esc_html__( 'Beschreibung der Ausstellung...', 'galerie-mueller-widgets' ),
			]
		);

		// #9 exhibition_images
		$repeater->add_control(
			'exhibition_images',
			[
				'label'   => esc_html__( 'Bilder', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'exhibitions',
			[
				'label'       => esc_html__( 'Ausstellungen', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'exhibition_title'       => 'Zwischenräume',
						'exhibition_year'        => '2020',
						'exhibition_location'    => 'Galerie am Markt, Darmstadt',
						'exhibition_description' => 'Eine Einzelausstellung, die sich mit den Räumen zwischen den Dingen beschäftigt — den stillen Momenten, die oft übersehen werden.',
					],
					[
						'exhibition_title'       => 'Farblandschaften',
						'exhibition_year'        => '2018',
						'exhibition_location'    => 'Kunstverein Heidelberg',
						'exhibition_description' => 'Gruppenausstellung mit Fokus auf abstrakte Landschaftsmalerei und die emotionale Kraft der Farbe.',
					],
					[
						'exhibition_title'       => 'Linien und Licht',
						'exhibition_year'        => '2015',
						'exhibition_location'    => 'Stadtgalerie Mannheim',
						'exhibition_description' => 'Zeichnungen und Skizzen, die das Spiel von Licht und Schatten in alltäglichen Szenen einfangen.',
					],
					[
						'exhibition_title'       => 'Erste Spuren',
						'exhibition_year'        => '2012',
						'exhibition_location'    => 'Kulturzentrum Frankfurt',
						'exhibition_description' => 'Die erste öffentliche Ausstellung — eine Sammlung früher Arbeiten, die den Grundstein für das spätere Schaffen legten.',
					],
				],
				'title_field' => '{{{ exhibition_title }}} — {{{ exhibition_year }}}',
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 1.3: Animation
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// #10 enable_fade_up
		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Fade-Up Animation', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'An', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Aus', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// #11 animation_duration
		$this->add_control(
			'animation_duration',
			[
				'label'     => esc_html__( 'Animationsdauer (ms)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
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

		// #12 animation_offset
		$this->add_control(
			'animation_offset',
			[
				'label'      => esc_html__( 'Versatz (Y)', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 20,
					'unit' => 'px',
				],
				'condition'  => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		// #13 animation_threshold
		$this->add_control(
			'animation_threshold',
			[
				'label'     => esc_html__( 'Sichtbarkeitsschwelle', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default'   => [
					'size' => 0.15,
					'unit' => 'px',
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		/* ==================================================================
		 * TAB_STYLE
		 * ================================================================== */

		/* ------------------------------------------------------------------
		 * Section 2.1: Abschnitt (Section)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'section_style_section',
			[
				'label' => esc_html__( 'Abschnitt', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #14 section_bg_color
		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #15 section_padding
		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => '96',
					'right'    => '24',
					'bottom'   => '96',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'mobile_default' => [
					'top'      => '64',
					'right'    => '24',
					'bottom'   => '64',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 2.2: Container
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'container_style_section',
			[
				'label' => esc_html__( 'Container', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #16 container_max_width
		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 600,
						'max' => 1400,
					],
				],
				'default'    => [
					'size' => 1152,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 2.3: Einleitung (Intro)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'intro_style_section',
			[
				'label' => esc_html__( 'Einleitung', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #17 intro_max_width
		$this->add_responsive_control(
			'intro_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite Einleitung', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 300,
						'max' => 1200,
					],
				],
				'default'    => [
					'size' => 672,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__intro' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #18 intro_bottom_spacing
		$this->add_control(
			'intro_bottom_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default'    => [
					'size' => 56,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__intro' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #19 accent_line_width
		$this->add_control(
			'accent_line_width',
			[
				'label'      => esc_html__( 'Linienbreite', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 2,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #20 accent_line_height
		$this->add_control(
			'accent_line_height',
			[
				'label'      => esc_html__( 'Linienhöhe', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 80,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #21 accent_line_color
		$this->add_control(
			'accent_line_color',
			[
				'label'     => esc_html__( 'Linienfarbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__accent-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #22 heading_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Überschrift Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__heading',
			]
		);

		// #23 heading_color
		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Überschrift Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__heading' => 'color: {{VALUE}};',
				],
			]
		);

		// #24 heading_bottom_spacing
		$this->add_control(
			'heading_bottom_spacing',
			[
				'label'      => esc_html__( 'Abstand Überschrift-Beschreibung', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__intro-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #25 description_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Beschreibung Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__description',
			]
		);

		// #26 description_color
		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Beschreibung Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 2.4: Raster (Grid)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'grid_style_section',
			[
				'label' => esc_html__( 'Raster', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #27 grid_columns
		$this->add_responsive_control(
			'grid_columns',
			[
				'label'     => esc_html__( 'Spalten', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '2',
				'mobile_default' => '1',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		// #28 grid_gap
		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Abstand', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 2.5: Karten (Cards)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'card_style_section',
			[
				'label' => esc_html__( 'Karten', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #29 card_image_aspect
		$this->add_control(
			'card_image_aspect',
			[
				'label'     => esc_html__( 'Seitenverhältnis', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 40,
						'max'  => 150,
						'step' => 1,
					],
				],
				'default'   => [
					'size' => 75,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card-image-wrap' => 'padding-bottom: {{SIZE}}%;',
				],
			]
		);

		// #30 card_image_hover_scale
		$this->add_control(
			'card_image_hover_scale',
			[
				'label'     => esc_html__( 'Hover-Zoom', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 1.3,
						'step' => 0.01,
					],
				],
				'default'   => [
					'size' => 1.03,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card:hover .gm-exhibitions__card-image' => 'transform: scale({{SIZE}});',
				],
			]
		);

		// #31 card_overlay_hover_color
		$this->add_control(
			'card_overlay_hover_color',
			[
				'label'     => esc_html__( 'Overlay Hover-Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.2)',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card:hover .gm-exhibitions__card-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #32 card_text_padding_top
		$this->add_control(
			'card_text_padding_top',
			[
				'label'      => esc_html__( 'Textabstand oben', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__card-text' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #33 card_title_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'label'    => esc_html__( 'Titel Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__card-title',
			]
		);

		// #34 card_title_color
		$this->add_control(
			'card_title_color',
			[
				'label'     => esc_html__( 'Titel Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card-title' => 'color: {{VALUE}};',
				],
			]
		);

		// #35 card_title_hover_color
		$this->add_control(
			'card_title_hover_color',
			[
				'label'     => esc_html__( 'Titel Hover-Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card:hover .gm-exhibitions__card-title' => 'color: {{VALUE}};',
				],
			]
		);

		// #36 card_year_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'card_year_typography',
				'label'    => esc_html__( 'Jahr Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__card-year',
			]
		);

		// #37 card_year_color
		$this->add_control(
			'card_year_color',
			[
				'label'     => esc_html__( 'Jahr Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card-year' => 'color: {{VALUE}};',
				],
			]
		);

		// #38 card_location_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'card_location_typography',
				'label'    => esc_html__( 'Ort Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__card-location',
			]
		);

		// #39 card_location_color
		$this->add_control(
			'card_location_color',
			[
				'label'     => esc_html__( 'Ort Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__card-location' => 'color: {{VALUE}};',
				],
			]
		);

		// #40 card_location_top_spacing
		$this->add_control(
			'card_location_top_spacing',
			[
				'label'      => esc_html__( 'Ort Abstand oben', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'size' => 6,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__card-location' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 2.6: Detail-Ansicht (Modal)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'modal_style_section',
			[
				'label' => esc_html__( 'Detail-Ansicht', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #41 modal_backdrop_color
		$this->add_control(
			'modal_backdrop_color',
			[
				'label'     => esc_html__( 'Hintergrund-Overlay', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-backdrop' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #42 modal_backdrop_blur
		$this->add_control(
			'modal_backdrop_blur',
			[
				'label'      => esc_html__( 'Hintergrund-Unschärfe', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'default'    => [
					'size' => 4,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__modal-backdrop' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		// #43 modal_max_width
		$this->add_responsive_control(
			'modal_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 400,
						'max' => 1400,
					],
				],
				'default'    => [
					'size' => 896,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__modal-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #44 modal_bg_color
		$this->add_control(
			'modal_bg_color',
			[
				'label'     => esc_html__( 'Modal Hintergrund', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #45 modal_image_aspect
		$this->add_control(
			'modal_image_aspect',
			[
				'label'     => esc_html__( 'Bild-Seitenverhältnis', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 40,
						'max'  => 100,
						'step' => 0.5,
					],
				],
				'default'   => [
					'size' => 62.5,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-gallery' => 'padding-bottom: {{SIZE}}%;',
				],
			]
		);

		// #46 modal_nav_bg_color
		$this->add_control(
			'modal_nav_bg_color',
			[
				'label'     => esc_html__( 'Pfeil Hintergrund', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.4)',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-prev, {{WRAPPER}} .gm-exhibitions__modal-next' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #47 modal_nav_hover_bg_color
		$this->add_control(
			'modal_nav_hover_bg_color',
			[
				'label'     => esc_html__( 'Pfeil Hover-Hintergrund', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.6)',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-prev:hover, {{WRAPPER}} .gm-exhibitions__modal-next:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gm-exhibitions__modal-prev:focus, {{WRAPPER}} .gm-exhibitions__modal-next:focus' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .gm-exhibitions__modal-prev:active, {{WRAPPER}} .gm-exhibitions__modal-next:active' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #48 modal_nav_color
		$this->add_control(
			'modal_nav_color',
			[
				'label'     => esc_html__( 'Pfeil Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-prev svg, {{WRAPPER}} .gm-exhibitions__modal-next svg' => 'color: {{VALUE}};',
				],
			]
		);

		// #49 modal_nav_size
		$this->add_control(
			'modal_nav_size',
			[
				'label'      => esc_html__( 'Pfeil Größe', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 24,
						'max' => 64,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__modal-prev, {{WRAPPER}} .gm-exhibitions__modal-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #50 modal_dot_size
		$this->add_control(
			'modal_dot_size',
			[
				'label'      => esc_html__( 'Punkt Größe', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 4,
						'max' => 16,
					],
				],
				'default'    => [
					'size' => 6,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__modal-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #51 modal_dot_color
		$this->add_control(
			'modal_dot_color',
			[
				'label'     => esc_html__( 'Punkt Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.4)',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #52 modal_dot_active_color
		$this->add_control(
			'modal_dot_active_color',
			[
				'label'     => esc_html__( 'Punkt aktiv Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-dot--active' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #53 modal_close_color
		$this->add_control(
			'modal_close_color',
			[
				'label'     => esc_html__( 'Schließen Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-close svg' => 'color: {{VALUE}};',
				],
			]
		);

		// #54 modal_close_hover_color
		$this->add_control(
			'modal_close_hover_color',
			[
				'label'     => esc_html__( 'Schließen Hover-Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-close:hover svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------------
		 * Section 2.7: Detail-Informationen (Modal Info)
		 * ------------------------------------------------------------------ */
		$this->start_controls_section(
			'modal_info_style_section',
			[
				'label' => esc_html__( 'Detail-Informationen', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// #55 modal_info_padding
		$this->add_responsive_control(
			'modal_info_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '40',
					'right'    => '48',
					'bottom'   => '40',
					'left'     => '48',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'mobile_default' => [
					'top'      => '32',
					'right'    => '32',
					'bottom'   => '32',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__modal-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// #56 modal_title_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'modal_title_typography',
				'label'    => esc_html__( 'Titel Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__modal-title',
			]
		);

		// #57 modal_title_color
		$this->add_control(
			'modal_title_color',
			[
				'label'     => esc_html__( 'Titel Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-title' => 'color: {{VALUE}};',
				],
			]
		);

		// #58 modal_year_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'modal_year_typography',
				'label'    => esc_html__( 'Jahr Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__modal-year',
			]
		);

		// #59 modal_year_color
		$this->add_control(
			'modal_year_color',
			[
				'label'     => esc_html__( 'Jahr Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-year' => 'color: {{VALUE}};',
				],
			]
		);

		// #60 modal_location_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'modal_location_typography',
				'label'    => esc_html__( 'Ort Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__modal-location',
			]
		);

		// #61 modal_location_color
		$this->add_control(
			'modal_location_color',
			[
				'label'     => esc_html__( 'Ort Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-location' => 'color: {{VALUE}};',
				],
			]
		);

		// #62 modal_location_spacing
		$this->add_control(
			'modal_location_spacing',
			[
				'label'      => esc_html__( 'Ort Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .gm-exhibitions__modal-location' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #63 modal_divider_width
		$this->add_control(
			'modal_divider_width',
			[
				'label'      => esc_html__( 'Trennlinie Breite', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-exhibitions__modal-divider' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #64 modal_divider_color
		$this->add_control(
			'modal_divider_color',
			[
				'label'     => esc_html__( 'Trennlinie Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#E0DCD7',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-divider' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #65 modal_divider_spacing
		$this->add_control(
			'modal_divider_spacing',
			[
				'label'      => esc_html__( 'Trennlinie Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .gm-exhibitions__modal-divider' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #66 modal_description_typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'modal_description_typography',
				'label'    => esc_html__( 'Beschreibung Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-exhibitions__modal-description',
			]
		);

		// #67 modal_description_color
		$this->add_control(
			'modal_description_color',
			[
				'label'     => esc_html__( 'Beschreibung Farbe', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-exhibitions__modal-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.4.0
	 */
	protected function render() {
		$settings    = $this->get_settings_for_display();
		$exhibitions = $settings['exhibitions'] ?? [];
		$tag         = $settings['heading_tag'] ?? 'h2';
		$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span' ];
		if ( ! in_array( $tag, $allowed_tags, true ) ) {
			$tag = 'h2';
		}

		$fade_up   = $settings['enable_fade_up'] === 'yes' ? 'yes' : 'no';
		$threshold = $settings['animation_threshold']['size'] ?? 0.15;
		$duration  = $settings['animation_duration']['size'] ?? 600;
		$offset    = $settings['animation_offset']['size'] ?? 20;
		?>
		<div class="gm-exhibitions"
		     data-fade-up="<?php echo esc_attr( $fade_up ); ?>"
		     data-fade-threshold="<?php echo esc_attr( $threshold ); ?>"
		     style="--gm-fade-duration:<?php echo esc_attr( $duration ); ?>ms;--gm-fade-offset:<?php echo esc_attr( $offset ); ?>px;">

			<div class="gm-exhibitions__inner">

				<!-- Section Intro -->
				<div class="gm-exhibitions__intro">
					<div class="gm-exhibitions__intro-heading">
						<div class="gm-exhibitions__accent-line"></div>
						<<?php echo esc_html( $tag ); ?> class="gm-exhibitions__heading">
							<?php echo esc_html( $settings['heading_text'] ?? '' ); ?>
						</<?php echo esc_html( $tag ); ?>>
					</div>
					<?php if ( ! empty( $settings['description_text'] ) ) : ?>
						<p class="gm-exhibitions__description">
							<?php echo esc_html( $settings['description_text'] ); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- Exhibition Grid -->
				<div class="gm-exhibitions__grid">
					<?php foreach ( $exhibitions as $index => $item ) :
						$images = [];
						if ( ! empty( $item['exhibition_images'] ) ) {
							foreach ( $item['exhibition_images'] as $img ) {
								$images[] = $img['url'] ?? '';
							}
						}
						$thumb = ! empty( $images[0] ) ? $images[0] : '';
					?>
						<button class="gm-exhibitions__card"
						        data-index="<?php echo esc_attr( $index ); ?>"
						        data-title="<?php echo esc_attr( $item['exhibition_title'] ?? '' ); ?>"
						        data-year="<?php echo esc_attr( $item['exhibition_year'] ?? '' ); ?>"
						        data-location="<?php echo esc_attr( $item['exhibition_location'] ?? '' ); ?>"
						        data-description="<?php echo esc_attr( $item['exhibition_description'] ?? '' ); ?>"
						        data-images="<?php echo esc_attr( wp_json_encode( $images ) ); ?>">
							<div class="gm-exhibitions__card-image-wrap">
								<?php if ( $thumb ) : ?>
									<img class="gm-exhibitions__card-image"
									     src="<?php echo esc_url( $thumb ); ?>"
									     alt="<?php echo esc_attr( $item['exhibition_title'] ?? '' ); ?>"
									     loading="lazy" />
								<?php endif; ?>
								<div class="gm-exhibitions__card-overlay"></div>
							</div>
							<div class="gm-exhibitions__card-text">
								<div class="gm-exhibitions__card-title-row">
									<h3 class="gm-exhibitions__card-title">
										<?php echo esc_html( $item['exhibition_title'] ?? '' ); ?>
									</h3>
									<span class="gm-exhibitions__card-year">
										<?php echo esc_html( $item['exhibition_year'] ?? '' ); ?>
									</span>
								</div>
								<p class="gm-exhibitions__card-location">
									<?php echo esc_html( $item['exhibition_location'] ?? '' ); ?>
								</p>
							</div>
						</button>
					<?php endforeach; ?>
				</div>

			</div>

			<!-- Detail Modal (hidden by default) -->
			<div class="gm-exhibitions__modal" style="display:none;">
				<div class="gm-exhibitions__modal-backdrop"></div>
				<div class="gm-exhibitions__modal-content">

					<button class="gm-exhibitions__modal-close" aria-label="Schließen">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<path d="M18 6L6 18M6 6l12 12"/>
						</svg>
					</button>

					<div class="gm-exhibitions__modal-gallery">
						<img class="gm-exhibitions__modal-image" src="" alt="" />
						<button class="gm-exhibitions__modal-prev" aria-label="Vorheriges Bild" style="display:none;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
								<path d="M15 18l-6-6 6-6"/>
							</svg>
						</button>
						<button class="gm-exhibitions__modal-next" aria-label="Nächstes Bild" style="display:none;">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
								<path d="M9 18l6-6-6-6"/>
							</svg>
						</button>
						<div class="gm-exhibitions__modal-dots" style="display:none;"></div>
					</div>

					<div class="gm-exhibitions__modal-info">
						<div class="gm-exhibitions__modal-title-row">
							<h2 class="gm-exhibitions__modal-title"></h2>
							<span class="gm-exhibitions__modal-year"></span>
						</div>
						<p class="gm-exhibitions__modal-location"></p>
						<div class="gm-exhibitions__modal-divider"></div>
						<p class="gm-exhibitions__modal-description"></p>
					</div>

				</div>
			</div>

		</div>
		<?php
	}
}
