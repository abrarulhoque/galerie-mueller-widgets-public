<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Biography Widget
 *
 * Centered section with accent line, heading, decorative quote mark,
 * italic quote text, WYSIWYG body text, and fade-up animation.
 *
 * @since 1.0.0
 */
class Biography_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_biography';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Biography', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-text';
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
		return [ 'biografie', 'biography', 'about', 'text', 'kuenstler', 'artist', 'zitat', 'quote' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-biography-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-biography-script' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_animation_controls();
		$this->register_style_section_controls();
		$this->register_style_container_controls();
		$this->register_style_heading_area_controls();
		$this->register_style_quote_controls();
		$this->register_style_quote_mark_controls();
		$this->register_style_body_text_controls();
		$this->register_style_alignment_controls();
	}

	/**
	 * Content Tab: Content Section
	 */
	private function register_content_controls(): void {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Inhalt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// #1 heading_text
		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Ueberschrift', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'BIOGRAFIE',
				'placeholder' => esc_html__( 'Abschnittstitel eingeben...', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		// #2 heading_tag
		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'HTML-Tag', 'galerie-mueller-widgets' ),
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
				],
			]
		);

		// #3 quote_text
		$this->add_control(
			'quote_text',
			[
				'label'       => esc_html__( 'Zitat-Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Die Kunst war für mich nie ein Beruf, sondern ein Lebensweg. Sie ist die ständige Suche nach dem Ausdruck dessen, was oft unsichtbar bleibt.',
				'placeholder' => esc_html__( 'Kuenstlerzitat eingeben...', 'galerie-mueller-widgets' ),
				'rows'        => 4,
				'separator'   => 'before',
			]
		);

		// #4 show_quote_mark
		$this->add_control(
			'show_quote_mark',
			[
				'label'        => esc_html__( 'Anfuehrungszeichen anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// #5 quote_mark_character
		$this->add_control(
			'quote_mark_character',
			[
				'label'     => esc_html__( 'Anfuehrungszeichen', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => "\u{201C}",
				'condition' => [
					'show_quote_mark' => 'yes',
				],
			]
		);

		// #6 body_text
		$this->add_control(
			'body_text',
			[
				'label'   => esc_html__( 'Biografietext', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '<p>Wolfgang Mueller, geboren 1948 in Heidelberg, entdeckte seine Leidenschaft für die bildende Kunst bereits in jungen Jahren. Was als kindliche Neugier begann, wurde zu einem lebenslangen Weg der kreativen Entfaltung. Ausgebildet in einer Zeit des künstlerischen Umbruchs, eignete er sich in den 1970er Jahren an der Akademie der Bildenden Künste ein tiefgreifendes Verständnis für Komposition, Farbtheorie und die Wirkung von Licht an.</p><p>Im Laufe der Jahrzehnte entwickelte Mueller einen unverwechselbaren Stil, der sich nicht leicht in vorgefertigte Schubladen einordnen lässt. Seine Werke – ob großformatige Ölgemälde, feine Graphitzeichnungen oder spontane Skizzen – zeichnen sich durch eine bemerkenswerte emotionale Dichte aus. Er arbeitet vorzugsweise in Zyklen, wobei er ein Motiv oder eine Stimmung wiederholt aus verschiedenen Perspektiven und in wechselnden Abstraktionsgraden umkreist.</p><p>Heute lebt und arbeitet Wolfgang Mueller zurückgezogen in seinem Atelier. Für ihn ist der Schaffensprozess ein intimer Dialog zwischen Künstler und Leinwand. Die Natur, architektonische Strukturen und vor allem das feine Spiel von Licht und Schatten in alltäglichen Situationen dienen ihm dabei als unerschöpfliche Inspirationsquellen.</p>',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Animation Section
	 */
	private function register_animation_controls(): void {

		$this->start_controls_section(
			'animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// #7 enable_fade_up
		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Fade-Up Animation', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'An', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Aus', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// #8 animation_duration
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

		// #9 animation_offset
		$this->add_control(
			'animation_offset',
			[
				'label'      => esc_html__( 'Versatz (Y)', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
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

		// #10 animation_threshold
		$this->add_control(
			'animation_threshold',
			[
				'label'   => esc_html__( 'Sichtbarkeitsschwelle', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
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
	 * Style Tab: Section Style
	 */
	private function register_style_section_controls(): void {

		$this->start_controls_section(
			'section_style_section',
			[
				'label' => esc_html__( 'Abschnitt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// #11 section_bg_color
		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-biography' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #12 section_padding
		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => '128',
					'right'    => '0',
					'bottom'   => '128',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'mobile_default' => [
					'top'      => '80',
					'right'    => '0',
					'bottom'   => '80',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Container Style
	 */
	private function register_style_container_controls(): void {

		$this->start_controls_section(
			'container_style_section',
			[
				'label' => esc_html__( 'Container', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// #13 container_max_width
		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 400,
						'max' => 1200,
					],
					'%'  => [
						'min' => 50,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 720,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #14 container_padding
		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Container-Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => '0',
					'right'    => '24',
					'bottom'   => '0',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Heading Area Style
	 */
	private function register_style_heading_area_controls(): void {

		$this->start_controls_section(
			'heading_area_style_section',
			[
				'label' => esc_html__( 'Ueberschriftsbereich', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// #15 accent_line_width
		$this->add_control(
			'accent_line_width',
			[
				'label'      => esc_html__( 'Linienbreite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #16 accent_line_height
		$this->add_control(
			'accent_line_height',
			[
				'label'      => esc_html__( 'Linienhoehe', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #17 accent_line_color
		$this->add_control(
			'accent_line_color',
			[
				'label'     => esc_html__( 'Linienfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__accent-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		// #18 accent_line_spacing
		$this->add_control(
			'accent_line_spacing',
			[
				'label'      => esc_html__( 'Abstand Linie-Ueberschrift', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .gm-biography__accent-line' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		// #19 heading_typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-biography__heading',
				'fields_options' => [
					'font_family' => [
						'default' => 'Inter',
					],
					'font_size' => [
						'default' => [
							'size' => 13,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'letter_spacing' => [
						'default' => [
							'size' => 0.25,
							'unit' => 'em',
						],
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
				],
			]
		);

		// #20 heading_color
		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__heading' => 'color: {{VALUE}};',
				],
			]
		);

		// #21 heading_area_bottom_spacing
		$this->add_control(
			'heading_area_bottom_spacing',
			[
				'label'      => esc_html__( 'Abstand nach Ueberschrift', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'default'    => [
					'size' => 64,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__heading-area' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Quote Style
	 */
	private function register_style_quote_controls(): void {

		$this->start_controls_section(
			'quote_style_section',
			[
				'label' => esc_html__( 'Zitat-Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// #22 quote_typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quote_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-biography__quote',
				'fields_options' => [
					'font_family' => [
						'default' => 'Playfair Display',
					],
					'font_size' => [
						'default' => [
							'size' => 30,
							'unit' => 'px',
						],
						'mobile_default' => [
							'size' => 26,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_style' => [
						'default' => 'italic',
					],
					'line_height' => [
						'default' => [
							'size' => 1.375,
							'unit' => 'em',
						],
					],
				],
			]
		);

		// #23 quote_color
		$this->add_control(
			'quote_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__quote' => 'color: {{VALUE}};',
				],
			]
		);

		// #24 quote_padding_left
		$this->add_responsive_control(
			'quote_padding_left',
			[
				'label'      => esc_html__( 'Einrueckung links', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__quote' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #25 quote_bottom_spacing
		$this->add_control(
			'quote_bottom_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 120,
					],
				],
				'default'    => [
					'size' => 48,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__quote' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Quote Mark Style
	 */
	private function register_style_quote_mark_controls(): void {

		$this->start_controls_section(
			'quote_mark_style_section',
			[
				'label'     => esc_html__( 'Anfuehrungszeichen-Stil', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_quote_mark' => 'yes',
				],
			]
		);

		// #26 quote_mark_size
		$this->add_responsive_control(
			'quote_mark_size',
			[
				'label'      => esc_html__( 'Groesse', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 16,
						'max' => 120,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__quote-mark' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #27 quote_mark_color
		$this->add_control(
			'quote_mark_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__quote-mark' => 'color: {{VALUE}};',
				],
			]
		);

		// #28 quote_mark_opacity
		$this->add_control(
			'quote_mark_opacity',
			[
				'label'   => esc_html__( 'Deckkraft', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.5,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-biography__quote-mark' => 'opacity: {{SIZE}};',
				],
			]
		);

		// #29 quote_mark_top_offset
		$this->add_control(
			'quote_mark_top_offset',
			[
				'label'      => esc_html__( 'Versatz oben', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => -50,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => -8,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__quote-mark' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #30 quote_mark_font_family
		$this->add_control(
			'quote_mark_font_family',
			[
				'label'     => esc_html__( 'Schriftart', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__quote-mark' => 'font-family: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Body Text Style
	 */
	private function register_style_body_text_controls(): void {

		$this->start_controls_section(
			'body_text_style_section',
			[
				'label' => esc_html__( 'Fliesstext-Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// #31 body_typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'body_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-biography__body',
				'fields_options' => [
					'font_family' => [
						'default' => 'Inter',
					],
					'font_size' => [
						'default' => [
							'size' => 17,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '300',
					],
					'line_height' => [
						'default' => [
							'size' => 1.8,
							'unit' => 'em',
						],
					],
				],
			]
		);

		// #32 body_color
		$this->add_control(
			'body_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__body' => 'color: {{VALUE}};',
				],
			]
		);

		// #33 body_paragraph_spacing
		$this->add_responsive_control(
			'body_paragraph_spacing',
			[
				'label'      => esc_html__( 'Absatzabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} .gm-biography__body p:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// #34 body_line_height
		$this->add_responsive_control(
			'body_line_height',
			[
				'label'      => esc_html__( 'Zeilenhoehe', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'em', 'px' ],
				'range'      => [
					'em' => [
						'min'  => 1,
						'max'  => 3,
						'step' => 0.1,
					],
					'px' => [
						'min' => 16,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 1.8,
					'unit' => 'em',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-biography__body' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Alignment Style
	 */
	private function register_style_alignment_controls(): void {

		$this->start_controls_section(
			'content_alignment_style_section',
			[
				'label' => esc_html__( 'Ausrichtung', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// #35 content_alignment
		$this->add_responsive_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Textausrichtung', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Links', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Zentriert', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Rechts', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__content' => 'text-align: {{VALUE}};',
				],
			]
		);

		// #36 heading_alignment
		$this->add_responsive_control(
			'heading_alignment',
			[
				'label'   => esc_html__( 'Ueberschrift-Ausrichtung', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Links', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Zentriert', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Rechts', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-biography__heading-area' => 'align-items: {{VALUE}};',
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

		$enable_animation = 'yes' === $settings['enable_fade_up'];
		$show_quote_mark  = 'yes' === $settings['show_quote_mark'];
		$heading_tag      = $settings['heading_tag'];

		// Inner wrapper classes
		$inner_classes = 'gm-biography__inner';
		if ( $enable_animation ) {
			$inner_classes .= ' gm-biography__inner--hidden';
		}

		// Render attributes
		$this->add_render_attribute( 'wrapper', 'class', 'gm-biography' );
		$this->add_render_attribute( 'inner', [
			'class'          => $inner_classes,
			'data-animation' => $enable_animation ? 'true' : 'false',
			'data-threshold' => esc_attr( $settings['animation_threshold']['size'] ?? 0.15 ),
			'data-duration'  => esc_attr( ( $settings['animation_duration']['size'] ?? 600 ) . 'ms' ),
			'data-offset'    => esc_attr( ( $settings['animation_offset']['size'] ?? 20 ) . 'px' ),
		] );
		$this->add_render_attribute( 'heading_area', 'class', 'gm-biography__heading-area' );
		$this->add_render_attribute( 'accent_line', 'class', 'gm-biography__accent-line' );
		$this->add_render_attribute( 'heading', 'class', 'gm-biography__heading' );
		$this->add_render_attribute( 'content', 'class', 'gm-biography__content' );
		$this->add_render_attribute( 'quote', 'class', 'gm-biography__quote' );
		$this->add_render_attribute( 'quote_mark', 'class', 'gm-biography__quote-mark' );
		$this->add_render_attribute( 'body', 'class', 'gm-biography__body' );

		// Inline editing attributes
		$this->add_inline_editing_attributes( 'heading_text', 'none' );
		$this->add_inline_editing_attributes( 'quote_text', 'basic' );
		$this->add_inline_editing_attributes( 'body_text', 'advanced' );
		?>
		<section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'inner' ); ?>>

				<!-- Heading Area -->
				<div <?php $this->print_render_attribute_string( 'heading_area' ); ?>>
					<div <?php $this->print_render_attribute_string( 'accent_line' ); ?>></div>
					<<?php echo esc_html( $heading_tag ); ?> <?php $this->print_render_attribute_string( 'heading' ); ?>>
						<?php echo esc_html( $settings['heading_text'] ); ?>
					</<?php echo esc_html( $heading_tag ); ?>>
				</div>

				<!-- Content Area -->
				<div <?php $this->print_render_attribute_string( 'content' ); ?>>

					<!-- Quote -->
					<p <?php $this->print_render_attribute_string( 'quote' ); ?>>
						<?php if ( $show_quote_mark ) : ?>
							<span <?php $this->print_render_attribute_string( 'quote_mark' ); ?>>
								<?php echo esc_html( $settings['quote_mark_character'] ); ?>
							</span>
						<?php endif; ?>
						<?php echo wp_kses_post( $settings['quote_text'] ); ?>
					</p>

					<!-- Body Text -->
					<div <?php $this->print_render_attribute_string( 'body' ); ?>>
						<?php echo wp_kses_post( $settings['body_text'] ); ?>
					</div>

				</div>

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
		var showQuoteMark   = 'yes' === settings.show_quote_mark;
		var headingTag      = settings.heading_tag || 'h2';
		var enableAnimation = 'yes' === settings.enable_fade_up;

		var innerClass = 'gm-biography__inner';
		if ( enableAnimation ) {
			innerClass += ' gm-biography__inner--hidden';
		}

		view.addRenderAttribute( 'wrapper', 'class', 'gm-biography' );
		view.addRenderAttribute( 'inner', {
			'class':          innerClass,
			'data-animation': enableAnimation ? 'true' : 'false',
			'data-threshold': settings.animation_threshold.size || 0.15,
			'data-duration':  ( settings.animation_duration.size || 600 ) + 'ms',
			'data-offset':    ( settings.animation_offset.size || 20 ) + 'px'
		} );
		view.addRenderAttribute( 'heading_area', 'class', 'gm-biography__heading-area' );
		view.addRenderAttribute( 'accent_line', 'class', 'gm-biography__accent-line' );
		view.addRenderAttribute( 'heading', 'class', 'gm-biography__heading' );
		view.addRenderAttribute( 'content', 'class', 'gm-biography__content' );
		view.addRenderAttribute( 'quote', 'class', 'gm-biography__quote' );
		view.addRenderAttribute( 'quote_mark', 'class', 'gm-biography__quote-mark' );
		view.addRenderAttribute( 'body', 'class', 'gm-biography__body' );

		view.addInlineEditingAttributes( 'heading_text', 'none' );
		view.addInlineEditingAttributes( 'quote_text', 'basic' );
		view.addInlineEditingAttributes( 'body_text', 'advanced' );
		#>
		<section {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<div {{{ view.getRenderAttributeString( 'inner' ) }}}>

				<!-- Heading Area -->
				<div {{{ view.getRenderAttributeString( 'heading_area' ) }}}>
					<div {{{ view.getRenderAttributeString( 'accent_line' ) }}}></div>
					<{{{ headingTag }}} {{{ view.getRenderAttributeString( 'heading' ) }}}>
						{{{ settings.heading_text }}}
					</{{{ headingTag }}}>
				</div>

				<!-- Content Area -->
				<div {{{ view.getRenderAttributeString( 'content' ) }}}>

					<!-- Quote -->
					<p {{{ view.getRenderAttributeString( 'quote' ) }}}>
						<# if ( showQuoteMark ) { #>
							<span {{{ view.getRenderAttributeString( 'quote_mark' ) }}}>
								{{{ settings.quote_mark_character }}}
							</span>
						<# } #>
						{{{ settings.quote_text }}}
					</p>

					<!-- Body Text -->
					<div {{{ view.getRenderAttributeString( 'body' ) }}}>
						{{{ settings.body_text }}}
					</div>

				</div>

			</div>
		</section>
		<?php
	}
}
