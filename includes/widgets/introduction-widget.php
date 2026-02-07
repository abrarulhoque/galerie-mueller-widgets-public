<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Introduction Widget
 *
 * Centered section with accent line, label, quote block, body text, and CTA link.
 * Includes scroll-triggered fade-up animation.
 *
 * @since 1.0.0
 */
class Introduction_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_introduction';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Introduction', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-blockquote';
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
		return [ 'introduction', 'quote', 'about', 'gallery', 'galerie', 'blockquote' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-introduction-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-introduction-script' ];
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
		$this->register_style_accent_line_controls();
		$this->register_style_label_controls();
		$this->register_style_quote_controls();
		$this->register_style_body_controls();
		$this->register_style_cta_controls();
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
			'show_accent_line',
			[
				'label'        => esc_html__( 'Show Accent Line', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_label',
			[
				'label'        => esc_html__( 'Show Label', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'label_text',
			[
				'label'       => esc_html__( 'Label Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Über die Galerie',
				'placeholder' => esc_html__( 'Enter label text', 'galerie-mueller-widgets' ),
				'label_block' => true,
				'condition'   => [
					'show_label' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_quote_marks',
			[
				'label'        => esc_html__( 'Show Quote Marks', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'quote_text',
			[
				'label'       => esc_html__( 'Quote Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Kunst ist nicht, was du siehst, sondern was du andere sehen lässt.',
				'placeholder' => esc_html__( 'Enter quote text', 'galerie-mueller-widgets' ),
				'rows'        => 3,
			]
		);

		$this->add_control(
			'body_text',
			[
				'label'       => esc_html__( 'Body Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Die Galerie Mueller präsentiert die Werke von Wolfgang Mueller — Malerei, Zeichnung und Skizzen, die zwischen Abstraktion und figurativer Ausdruckskraft einen ganz eigenen Dialog eröffnen.',
				'placeholder' => esc_html__( 'Enter body text', 'galerie-mueller-widgets' ),
				'rows'        => 4,
			]
		);

		$this->add_control(
			'show_cta',
			[
				'label'        => esc_html__( 'Show CTA Link', 'galerie-mueller-widgets' ),
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
				'default'     => 'Mehr erfahren →',
				'placeholder' => esc_html__( 'Enter CTA text', 'galerie-mueller-widgets' ),
				'condition'   => [
					'show_cta' => 'yes',
				],
			]
		);

		$this->add_control(
			'cta_link',
			[
				'label'       => esc_html__( 'CTA Link', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'url'         => '/ueber-den-kuenstler',
					'is_external' => false,
					'nofollow'    => false,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'galerie-mueller-widgets' ),
				'condition'   => [
					'show_cta' => 'yes',
				],
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'section',
				'options' => [
					'section' => 'section',
					'div'     => 'div',
					'article' => 'article',
				],
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
			'animation_duration',
			[
				'label'   => esc_html__( 'Animation Duration (ms)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 100, 'max' => 2000, 'step' => 50 ],
				],
				'default' => [
					'size' => 600,
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_delay',
			[
				'label'   => esc_html__( 'Animation Delay (ms)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 2000, 'step' => 50 ],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_distance',
			[
				'label'   => esc_html__( 'Animation Distance (px)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
				],
				'default' => [
					'size' => 20,
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
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
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .gm-intro' => 'background-color: {{VALUE}};',
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
					'top'      => 80,
					'right'    => 24,
					'bottom'   => 80,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-intro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'px' => [ 'min' => 200, 'max' => 1200 ],
					'%'  => [ 'min' => 20, 'max' => 100 ],
				],
				'default'    => [
					'size' => 720,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-intro__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'galerie-mueller-widgets' ),
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__inner' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Accent Line Style
	 */
	private function register_style_accent_line_controls(): void {

		$this->start_controls_section(
			'style_accent_line',
			[
				'label'     => esc_html__( 'Accent Line', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_accent_line' => 'yes',
				],
			]
		);

		$this->add_control(
			'accent_line_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__accent-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_line_width',
			[
				'label'   => esc_html__( 'Width', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 10, 'max' => 200 ],
				],
				'default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_height',
			[
				'label'   => esc_html__( 'Height', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 1, 'max' => 10 ],
				],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'accent_line_spacing',
			[
				'label'   => esc_html__( 'Bottom Spacing', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__accent-line' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Label Style
	 */
	private function register_style_label_controls(): void {

		$this->start_controls_section(
			'style_label',
			[
				'label'     => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_label' => 'yes',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .gm-intro__label',
			]
		);

		$this->add_responsive_control(
			'label_spacing',
			[
				'label'   => esc_html__( 'Bottom Spacing', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
			'style_quote',
			[
				'label' => esc_html__( 'Quote', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__quote-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quote_typography',
				'selector' => '{{WRAPPER}} .gm-intro__quote-text',
			]
		);

		$this->add_control(
			'quote_mark_heading',
			[
				'label'     => esc_html__( 'Quote Marks', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_quote_marks' => 'yes',
				],
			]
		);

		$this->add_control(
			'quote_mark_color',
			[
				'label'     => esc_html__( 'Quote Mark Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__quote-mark' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_quote_marks' => 'yes',
				],
			]
		);

		$this->add_control(
			'quote_mark_size',
			[
				'label'   => esc_html__( 'Quote Mark Size', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 12, 'max' => 60 ],
				],
				'default' => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__quote-mark' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_quote_marks' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'quote_spacing',
			[
				'label'     => esc_html__( 'Bottom Spacing', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__quote' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Body Text Style
	 */
	private function register_style_body_controls(): void {

		$this->start_controls_section(
			'style_body',
			[
				'label' => esc_html__( 'Body Text', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'body_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__body' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'body_typography',
				'selector' => '{{WRAPPER}} .gm-intro__body',
			]
		);

		$this->add_responsive_control(
			'body_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 1000 ],
					'%'  => [ 'min' => 20, 'max' => 100 ],
				],
				'default'    => [
					'size' => 600,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-intro__body' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'body_spacing',
			[
				'label'   => esc_html__( 'Bottom Spacing', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-intro__body' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
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
				'condition' => [
					'show_cta' => 'yes',
				],
			]
		);

		$this->add_control(
			'cta_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-intro__cta' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .gm-intro__cta:hover, {{WRAPPER}} .gm-intro__cta:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cta_typography',
				'selector' => '{{WRAPPER}} .gm-intro__cta',
			]
		);

		$this->add_control(
			'cta_transition_duration',
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
					'{{WRAPPER}} .gm-intro__cta' => 'transition-duration: {{SIZE}}ms;',
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

		// Build animation classes and data attributes
		$animation_class = '';
		$animation_style = '';
		$data_attrs      = '';

		if ( 'yes' === $settings['enable_fade_up'] ) {
			$animation_class = 'gm-intro__inner--hidden';
			$data_attrs      = sprintf(
				'data-anim-threshold="%s"',
				esc_attr( $settings['animation_threshold']['size'] ?? '0.15' )
			);
			$animation_style = sprintf(
				'--gm-anim-duration: %sms; --gm-anim-delay: %sms; --gm-anim-distance: %spx;',
				esc_attr( $settings['animation_duration']['size'] ?? 600 ),
				esc_attr( $settings['animation_delay']['size'] ?? 0 ),
				esc_attr( $settings['animation_distance']['size'] ?? 20 )
			);
		}

		$tag = $settings['html_tag'] ?? 'section';
		?>
		<<?php echo esc_html( $tag ); ?> class="gm-intro">
			<div class="gm-intro__inner <?php echo esc_attr( $animation_class ); ?>"
				 <?php echo $data_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				 <?php if ( $animation_style ) : ?>
					 style="<?php echo esc_attr( $animation_style ); ?>"
				 <?php endif; ?>
			>

				<?php if ( 'yes' === $settings['show_accent_line'] ) : ?>
					<div class="gm-intro__accent-line"></div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_label'] ) : ?>
					<p class="gm-intro__label">
						<?php echo esc_html( $settings['label_text'] ); ?>
					</p>
				<?php endif; ?>

				<blockquote class="gm-intro__quote">
					<?php if ( 'yes' === $settings['show_quote_marks'] ) : ?>
						<span class="gm-intro__quote-mark">&ldquo;</span>
					<?php endif; ?>

					<p class="gm-intro__quote-text">
						<?php echo esc_html( $settings['quote_text'] ); ?>
					</p>

					<?php if ( 'yes' === $settings['show_quote_marks'] ) : ?>
						<span class="gm-intro__quote-mark">&rdquo;</span>
					<?php endif; ?>
				</blockquote>

				<p class="gm-intro__body">
					<?php echo esc_html( $settings['body_text'] ); ?>
				</p>

				<?php if ( 'yes' === $settings['show_cta'] ) : ?>
					<?php
					$cta_url = $settings['cta_link']['url'] ?? '#';
					$this->add_render_attribute( 'cta_link_attr', 'href', esc_url( $cta_url ) );
					$this->add_render_attribute( 'cta_link_attr', 'class', 'gm-intro__cta' );
					if ( ! empty( $settings['cta_link']['is_external'] ) ) {
						$this->add_render_attribute( 'cta_link_attr', 'target', '_blank' );
					}
					if ( ! empty( $settings['cta_link']['nofollow'] ) ) {
						$this->add_render_attribute( 'cta_link_attr', 'rel', 'nofollow' );
					}
					?>
					<a <?php $this->print_render_attribute_string( 'cta_link_attr' ); ?>>
						<?php echo wp_kses_post( $settings['cta_text'] ); ?>
					</a>
				<?php endif; ?>

			</div>
		</<?php echo esc_html( $tag ); ?>>
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
		var animClass = ( 'yes' === settings.enable_fade_up ) ? 'gm-intro__inner--hidden' : '';
		var tag = settings.html_tag || 'section';
		#>

		<{{{ tag }}} class="gm-intro">
			<div class="gm-intro__inner {{ animClass }}">

				<# if ( 'yes' === settings.show_accent_line ) { #>
					<div class="gm-intro__accent-line"></div>
				<# } #>

				<# if ( 'yes' === settings.show_label ) { #>
					<p class="gm-intro__label">
						{{{ settings.label_text }}}
					</p>
				<# } #>

				<blockquote class="gm-intro__quote">
					<# if ( 'yes' === settings.show_quote_marks ) { #>
						<span class="gm-intro__quote-mark">&ldquo;</span>
					<# } #>

					<p class="gm-intro__quote-text">
						{{{ settings.quote_text }}}
					</p>

					<# if ( 'yes' === settings.show_quote_marks ) { #>
						<span class="gm-intro__quote-mark">&rdquo;</span>
					<# } #>
				</blockquote>

				<p class="gm-intro__body">
					{{{ settings.body_text }}}
				</p>

				<# if ( 'yes' === settings.show_cta ) { #>
					<a href="{{ settings.cta_link.url }}" class="gm-intro__cta">
						{{{ settings.cta_text }}}
					</a>
				<# } #>

			</div>
		</{{{ tag }}}>
		<?php
	}
}
