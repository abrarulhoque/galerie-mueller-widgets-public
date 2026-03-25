<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Timeline Widget
 *
 * Vertical timeline section displaying career milestones with
 * accent line heading, year/title/detail items, connecting line,
 * hover dot, horizontal separator lines, and fade-up animation.
 *
 * @since 1.0.0
 */
class Timeline_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_timeline';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Timeline', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-time-line';
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
		return [ 'timeline', 'stationen', 'milestones', 'chronik', 'history' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-timeline-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-timeline-script' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {

		/* ==================================================================
		 * TAB_CONTENT
		 * ================================================================== */

		// --- Section 1: Bereich-Ueberschrift ---
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Bereich-Überschrift', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Überschrift', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'STATIONEN', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. STATIONEN', 'galerie-mueller' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'HTML-Tag', 'galerie-mueller' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'SPAN',
					'p'    => 'P',
					'div'  => 'DIV',
				],
			]
		);

		$this->add_control(
			'show_accent_line',
			[
				'label'        => esc_html__( 'Akzentlinie anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// --- Section 2: Stationen (Repeater) ---
		$this->start_controls_section(
			'section_milestones',
			[
				'label' => esc_html__( 'Stationen', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'milestone_year',
			[
				'label'       => esc_html__( 'Jahreszahl', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '2020', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. 2020', 'galerie-mueller' ),
				'label_block' => false,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'milestone_title',
			[
				'label'       => esc_html__( 'Titel', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ausstellungstitel', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. Einzelausstellung', 'galerie-mueller' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'milestone_detail',
			[
				'label'       => esc_html__( 'Detail', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ort oder Beschreibung', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. Galerie am Markt, Darmstadt', 'galerie-mueller' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'milestones',
			[
				'label'   => esc_html__( 'Stationen', 'galerie-mueller' ),
				'type'    => \Elementor\Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'milestone_year'   => '2020',
						'milestone_title'  => esc_html__( 'Einzelausstellung „Zwischenräume"', 'galerie-mueller' ),
						'milestone_detail' => esc_html__( 'Galerie am Markt, Darmstadt', 'galerie-mueller' ),
					],
					[
						'milestone_year'   => '2017',
						'milestone_title'  => esc_html__( 'Gruppenausstellung „Linien und Flächen"', 'galerie-mueller' ),
						'milestone_detail' => esc_html__( 'Kunstverein Heidelberg', 'galerie-mueller' ),
					],
					[
						'milestone_year'   => '2010',
						'milestone_title'  => esc_html__( 'Beginn der Skizzenserie', 'galerie-mueller' ),
						'milestone_detail' => esc_html__( '„Tagesnotizen"', 'galerie-mueller' ),
					],
					[
						'milestone_year'   => '1985',
						'milestone_title'  => esc_html__( 'Erste Ausstellung', 'galerie-mueller' ),
						'milestone_detail' => esc_html__( 'Kunsthalle Frankfurt', 'galerie-mueller' ),
					],
					[
						'milestone_year'   => '1975',
						'milestone_title'  => esc_html__( 'Studium der Freien Kunst', 'galerie-mueller' ),
						'milestone_detail' => esc_html__( 'Akademie der Bildenden Künste', 'galerie-mueller' ),
					],
				],
				'title_field' => '{{{ milestone_year }}} — {{{ milestone_title }}}',
			]
		);

		$this->end_controls_section();

		// --- Section 3: Timeline-Funktionen ---
		$this->start_controls_section(
			'section_features',
			[
				'label' => esc_html__( 'Timeline-Funktionen', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_connecting_line',
			[
				'label'        => esc_html__( 'Verbindungslinie anzeigen', 'galerie-mueller' ),
				'description'  => esc_html__( 'Vertikale Linie zwischen Einträgen (nur Desktop)', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_hover_dot',
			[
				'label'        => esc_html__( 'Hover-Punkt anzeigen', 'galerie-mueller' ),
				'description'  => esc_html__( 'Bronze-Punkt neben Jahreszahl bei Hover (nur Desktop)', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_horizontal_lines',
			[
				'label'        => esc_html__( 'Horizontale Linien anzeigen', 'galerie-mueller' ),
				'description'  => esc_html__( 'Trennlinie pro Eintrag (nur Desktop)', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// --- Section 4: Animation ---
		$this->start_controls_section(
			'section_animation',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_animation',
			[
				'label'        => esc_html__( 'Eingangsanimation', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label'     => esc_html__( 'Animationsdauer (ms)', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 100,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 700,
				],
				'condition' => [ 'enable_animation' => 'yes' ],
			]
		);

		$this->add_control(
			'animation_offset',
			[
				'label'      => esc_html__( 'Versatz (translateY)', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 24,
				],
				'condition'  => [ 'enable_animation' => 'yes' ],
			]
		);

		$this->add_control(
			'animation_threshold',
			[
				'label'       => esc_html__( 'Sichtbarkeits-Schwelle', 'galerie-mueller' ),
				'description' => esc_html__( 'Anteil des Elements, der sichtbar sein muss (0 = sofort, 1 = vollständig)', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default'     => [
					'size' => 0.15,
				],
				'condition'   => [ 'enable_animation' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==================================================================
		 * TAB_STYLE
		 * ================================================================== */

		// --- Section 5: Bereich ---
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Bereich', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'          => esc_html__( 'Innenabstand', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', 'em', 'rem', '%' ],
				'default'        => [
					'top'      => 96,
					'right'    => 0,
					'bottom'   => 96,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'tablet_default' => [
					'top'      => 128,
					'right'    => 0,
					'bottom'   => 128,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'mobile_default' => [
					'top'      => 96,
					'right'    => 0,
					'bottom'   => 96,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'      => [
					'{{WRAPPER}} .gm-timeline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 6: Container ---
		$this->start_controls_section(
			'style_container',
			[
				'label' => esc_html__( 'Container', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1400, 'step' => 10 ],
					'%'  => [ 'min' => 20,  'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 800 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Seitenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => 0,
					'right'    => 24,
					'bottom'   => 0,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 7: Ueberschrift-Bereich ---
		$this->start_controls_section(
			'style_heading_area',
			[
				'label' => esc_html__( 'Überschrift-Bereich', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'accent_line_width',
			[
				'label'      => esc_html__( 'Linienbreite', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 10, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_accent_line' => 'yes' ],
			]
		);

		$this->add_control(
			'accent_line_height',
			[
				'label'      => esc_html__( 'Linienhöhe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 120, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_accent_line' => 'yes' ],
			]
		);

		$this->add_control(
			'accent_line_color',
			[
				'label'     => esc_html__( 'Linienfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__accent-line' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_accent_line' => 'yes' ],
			]
		);

		$this->add_control(
			'accent_line_spacing',
			[
				'label'      => esc_html__( 'Linienabstand unten', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__accent-line' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_accent_line' => 'yes' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-timeline__heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_text_transform',
			[
				'label'     => esc_html__( 'Textumwandlung', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'uppercase',
				'options'   => [
					'none'       => esc_html__( 'Keine', 'galerie-mueller' ),
					'uppercase'  => esc_html__( 'Großbuchstaben', 'galerie-mueller' ),
					'lowercase'  => esc_html__( 'Kleinbuchstaben', 'galerie-mueller' ),
					'capitalize' => esc_html__( 'Wortanfang groß', 'galerie-mueller' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__heading' => 'text-transform: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_letter_spacing',
			[
				'label'      => esc_html__( 'Zeichenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'em', 'px' ],
				'range'      => [
					'em' => [ 'min' => 0, 'max' => 1, 'step' => 0.01 ],
					'px' => [ 'min' => 0, 'max' => 20, 'step' => 0.5 ],
				],
				'default'    => [ 'unit' => 'em', 'size' => 0.25 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__heading' => 'letter-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_area_spacing',
			[
				'label'          => esc_html__( 'Abstand nach Überschrift', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'em' ],
				'range'          => [ 'px' => [ 'min' => 0, 'max' => 200, 'step' => 4 ] ],
				'default'        => [ 'unit' => 'px', 'size' => 96 ],
				'tablet_default' => [ 'unit' => 'px', 'size' => 96 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'      => [
					'{{WRAPPER}} .gm-timeline__heading-area' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 8: Eintraege ---
		$this->start_controls_section(
			'style_items',
			[
				'label' => esc_html__( 'Einträge', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_gap',
			[
				'label'          => esc_html__( 'Abstand zwischen Einträgen', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'em' ],
				'range'          => [ 'px' => [ 'min' => 0, 'max' => 120, 'step' => 4 ] ],
				'default'        => [ 'unit' => 'px', 'size' => 64 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'      => [
					'{{WRAPPER}} .gm-timeline__items' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 9: Jahreszahl ---
		$this->start_controls_section(
			'style_year',
			[
				'label' => esc_html__( 'Jahreszahl', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'year_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-timeline__year',
			]
		);

		$this->add_control(
			'year_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__year' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'year_column_width',
			[
				'label'       => esc_html__( 'Spaltenbreite (Desktop)', 'galerie-mueller' ),
				'description' => esc_html__( 'Breite der Jahreszahl-Spalte auf Desktop', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [ 'px' => [ 'min' => 60, 'max' => 250, 'step' => 5 ] ],
				'default'     => [ 'unit' => 'px', 'size' => 120 ],
				'selectors'   => [
					'{{WRAPPER}} .gm-timeline__year-col' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 10: Titel ---
		$this->start_controls_section(
			'style_title',
			[
				'label' => esc_html__( 'Titel', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-timeline__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 11: Detail ---
		$this->start_controls_section(
			'style_detail',
			[
				'label' => esc_html__( 'Detail', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'detail_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-timeline__detail',
			]
		);

		$this->add_control(
			'detail_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__detail' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 12: Verbindungslinie ---
		$this->start_controls_section(
			'style_connecting_line',
			[
				'label'     => esc_html__( 'Verbindungslinie', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_connecting_line' => 'yes' ],
			]
		);

		$this->add_control(
			'connecting_line_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(224, 220, 215, 0.4)',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__connecting-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'connecting_line_width',
			[
				'label'      => esc_html__( 'Breite', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 5, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__connecting-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'connecting_line_left',
			[
				'label'      => esc_html__( 'Position links', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 250, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 86 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__connecting-line' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 13: Horizontale Linie ---
		$this->start_controls_section(
			'style_horizontal_line',
			[
				'label'     => esc_html__( 'Horizontale Linie', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_horizontal_lines' => 'yes' ],
			]
		);

		$this->add_control(
			'h_line_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(224, 220, 215, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__h-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'h_line_height',
			[
				'label'      => esc_html__( 'Höhe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 5, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__h-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 14: Hover-Punkt ---
		$this->start_controls_section(
			'style_hover_dot',
			[
				'label'     => esc_html__( 'Hover-Punkt', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hover_dot' => 'yes' ],
			]
		);

		$this->add_control(
			'dot_size',
			[
				'label'      => esc_html__( 'Größe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 20, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-timeline__dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dot_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-timeline__dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_position_right',
			[
				'label'       => esc_html__( 'Position rechts', 'galerie-mueller' ),
				'description' => esc_html__( 'Abstand vom rechten Rand der Jahreszahl-Spalte', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [ 'px' => [ 'min' => 0, 'max' => 80, 'step' => 1 ] ],
				'default'     => [ 'unit' => 'px', 'size' => 33 ],
				'selectors'   => [
					'{{WRAPPER}} .gm-timeline__dot' => 'margin-right: {{SIZE}}{{UNIT}};',
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

		// Animation data attributes
		$inner_class = 'gm-timeline__inner';
		$inner_attrs = '';

		if ( 'yes' === $settings['enable_animation'] ) {
			$inner_class .= ' gm-timeline__inner--hidden';
			$duration  = ! empty( $settings['animation_duration']['size'] ) ? intval( $settings['animation_duration']['size'] ) : 700;
			$offset    = ! empty( $settings['animation_offset']['size'] ) ? intval( $settings['animation_offset']['size'] ) : 24;
			$threshold = isset( $settings['animation_threshold']['size'] ) ? floatval( $settings['animation_threshold']['size'] ) : 0.15;

			$inner_attrs = sprintf(
				' data-animation-duration="%d" data-animation-offset="%d" data-animation-threshold="%s"',
				$duration,
				$offset,
				esc_attr( $threshold )
			);
		}

		$milestones  = $settings['milestones'];
		$heading_tag = ! empty( $settings['heading_tag'] ) ? $settings['heading_tag'] : 'h2';
		?>
		<section class="gm-timeline">
			<div class="<?php echo esc_attr( $inner_class ); ?>"<?php echo $inner_attrs; ?>>

				<?php if ( ! empty( $settings['heading_text'] ) ) : ?>
					<!-- Heading Area -->
					<div class="gm-timeline__heading-area">
						<?php if ( 'yes' === $settings['show_accent_line'] ) : ?>
							<div class="gm-timeline__accent-line"></div>
						<?php endif; ?>
						<<?php echo esc_attr( $heading_tag ); ?> class="gm-timeline__heading">
							<?php echo esc_html( $settings['heading_text'] ); ?>
						</<?php echo esc_attr( $heading_tag ); ?>>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $milestones ) ) : ?>
					<!-- Timeline -->
					<div class="gm-timeline__wrapper">

						<?php if ( 'yes' === $settings['show_connecting_line'] ) : ?>
							<div class="gm-timeline__connecting-line"></div>
						<?php endif; ?>

						<div class="gm-timeline__items">
							<?php foreach ( $milestones as $index => $item ) : ?>
								<div class="gm-timeline__item">

									<!-- Year Column -->
									<div class="gm-timeline__year-col">
										<div class="gm-timeline__year-inner">
											<?php if ( ! empty( $item['milestone_year'] ) ) : ?>
												<span class="gm-timeline__year">
													<?php echo esc_html( $item['milestone_year'] ); ?>
												</span>
											<?php endif; ?>

											<?php if ( 'yes' === $settings['show_hover_dot'] ) : ?>
												<div class="gm-timeline__dot"></div>
											<?php endif; ?>
										</div>
									</div>

									<!-- Content Column -->
									<div class="gm-timeline__content-col">
										<?php if ( 'yes' === $settings['show_horizontal_lines'] ) : ?>
											<div class="gm-timeline__h-line"></div>
										<?php endif; ?>

										<div class="gm-timeline__content-inner">
											<?php if ( ! empty( $item['milestone_title'] ) ) : ?>
												<h3 class="gm-timeline__title">
													<?php echo esc_html( $item['milestone_title'] ); ?>
												</h3>
											<?php endif; ?>

											<?php if ( ! empty( $item['milestone_detail'] ) ) : ?>
												<p class="gm-timeline__detail">
													<?php echo esc_html( $item['milestone_detail'] ); ?>
												</p>
											<?php endif; ?>
										</div>
									</div>

								</div>
							<?php endforeach; ?>
						</div>

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
		var headingTag = settings.heading_tag || 'h2';
		var innerClass = 'gm-timeline__inner';
		var innerAttrs = '';

		if ( 'yes' === settings.enable_animation ) {
			innerClass += ' gm-timeline__inner--hidden';
			var duration  = settings.animation_duration ? settings.animation_duration.size : 700;
			var offset    = settings.animation_offset ? settings.animation_offset.size : 24;
			var threshold = settings.animation_threshold ? settings.animation_threshold.size : 0.15;
			innerAttrs = ' data-animation-duration="' + duration + '" data-animation-offset="' + offset + '" data-animation-threshold="' + threshold + '"';
		}
		#>
		<section class="gm-timeline">
			<div class="{{ innerClass }}"{{{ innerAttrs }}}>

				<# if ( settings.heading_text ) { #>
					<div class="gm-timeline__heading-area">
						<# if ( 'yes' === settings.show_accent_line ) { #>
							<div class="gm-timeline__accent-line"></div>
						<# } #>
						<{{ headingTag }} class="gm-timeline__heading">
							{{{ settings.heading_text }}}
						</{{ headingTag }}>
					</div>
				<# } #>

				<# if ( settings.milestones && settings.milestones.length ) { #>
					<div class="gm-timeline__wrapper">

						<# if ( 'yes' === settings.show_connecting_line ) { #>
							<div class="gm-timeline__connecting-line"></div>
						<# } #>

						<div class="gm-timeline__items">
							<# _.each( settings.milestones, function( item, index ) { #>
								<div class="gm-timeline__item">

									<div class="gm-timeline__year-col">
										<div class="gm-timeline__year-inner">
											<# if ( item.milestone_year ) { #>
												<span class="gm-timeline__year">{{{ item.milestone_year }}}</span>
											<# } #>
											<# if ( 'yes' === settings.show_hover_dot ) { #>
												<div class="gm-timeline__dot"></div>
											<# } #>
										</div>
									</div>

									<div class="gm-timeline__content-col">
										<# if ( 'yes' === settings.show_horizontal_lines ) { #>
											<div class="gm-timeline__h-line"></div>
										<# } #>
										<div class="gm-timeline__content-inner">
											<# if ( item.milestone_title ) { #>
												<h3 class="gm-timeline__title">{{{ item.milestone_title }}}</h3>
											<# } #>
											<# if ( item.milestone_detail ) { #>
												<p class="gm-timeline__detail">{{{ item.milestone_detail }}}</p>
											<# } #>
										</div>
									</div>

								</div>
							<# }); #>
						</div>

					</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}
