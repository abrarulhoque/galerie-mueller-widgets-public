<?php
namespace Galerie_Mueller_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class View_Works_CTA_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_view_works_cta';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - View Works CTA', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-call-to-action';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'cta', 'galerie', 'werke', 'button', 'call to action', 'view works' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-view-works-cta-style', 'gm-google-fonts' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-view-works-cta-script' ];
	}

	public function has_widget_inner_wrapper(): bool {
		return false;
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	protected function register_controls(): void {

		/* ==========================================================================
		   TAB_CONTENT
		   ========================================================================== */

		// -- Content Section -------------------------------------------------------
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Inhalt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Ueberschrift', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => "Entdecken Sie die Werke von\nWolfgang Mueller",
				'placeholder' => esc_html__( 'Ueberschrift eingeben...', 'galerie-mueller-widgets' ),
				'rows'        => 3,
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'  => 'H1',
					'h2'  => 'H2',
					'h3'  => 'H3',
					'h4'  => 'H4',
					'h5'  => 'H5',
					'h6'  => 'H6',
					'p'   => 'p',
					'div' => 'div',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button-Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Zur Galerie', 'galerie-mueller-widgets' ),
				'placeholder' => esc_html__( 'z. B. Zur Galerie', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button-Link', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'url'         => '/galerie',
					'is_external' => false,
					'nofollow'    => false,
				],
				'options'     => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'        => esc_html__( 'Button anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// -- Animation Section -----------------------------------------------------
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
				'label'        => esc_html__( 'Fade-Up Animation', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'An', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Aus', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

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

		$this->add_control(
			'animation_offset',
			[
				'label'     => esc_html__( 'Versatz (Y)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
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

		/* ==========================================================================
		   TAB_STYLE
		   ========================================================================== */

		// -- Section Style ---------------------------------------------------------
		$this->start_controls_section(
			'section_style_section',
			[
				'label' => esc_html__( 'Abschnitt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
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
				'selectors'  => [
					'{{WRAPPER}} .gm-view-works-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Ausrichtung', 'galerie-mueller-widgets' ),
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
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start;',
					'center' => 'text-align: center; align-items: center;',
					'right'  => 'text-align: right; align-items: flex-end;',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__inner' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// -- Container Style -------------------------------------------------------
		$this->start_controls_section(
			'container_style_section',
			[
				'label' => esc_html__( 'Container', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Maximale Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 300,
						'max' => 1200,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 672,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-view-works-cta__inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Container-Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
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
					'{{WRAPPER}} .gm-view-works-cta__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// -- Heading Style ---------------------------------------------------------
		$this->start_controls_section(
			'heading_style_section',
			[
				'label' => esc_html__( 'Ueberschrift', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F3F0',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-view-works-cta__heading',
			]
		);

		$this->add_control(
			'heading_spacing',
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
					'{{WRAPPER}} .gm-view-works-cta__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_text_align',
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// -- Button Style ----------------------------------------------------------
		$this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__( 'Button', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-view-works-cta__button',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => 14,
					'right'    => 32,
					'bottom'   => 14,
					'left'     => 32,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Eckenradius', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// -- Button Normal / Hover Tabs --------------------------------------------
		$this->start_controls_tabs( 'button_style_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.9)',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_type',
			[
				'label'     => esc_html__( 'Rahmentyp', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => [
					'none'   => esc_html__( 'Kein', 'galerie-mueller-widgets' ),
					'solid'  => esc_html__( 'Durchgezogen', 'galerie-mueller-widgets' ),
					'dashed' => esc_html__( 'Gestrichelt', 'galerie-mueller-widgets' ),
					'dotted' => esc_html__( 'Gepunktet', 'galerie-mueller-widgets' ),
					'double' => esc_html__( 'Doppelt', 'galerie-mueller-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'      => esc_html__( 'Rahmenbreite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => 1,
					'right'    => 1,
					'bottom'   => 1,
					'left'     => 1,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_border_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Rahmenfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.4)',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label'     => esc_html__( 'Rahmenfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// After tabs close
		$this->add_control(
			'button_hover_transition',
			[
				'label'     => esc_html__( 'Uebergangsdauer', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'default'   => [
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-view-works-cta__button' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$enable_animation = 'yes' === $settings['enable_fade_up'];
		$show_button      = 'yes' === $settings['show_button'];
		$heading_tag      = $settings['heading_tag'];

		// Sanitize heading tag
		$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div' ];
		if ( ! in_array( $heading_tag, $allowed_tags, true ) ) {
			$heading_tag = 'h2';
		}

		// Inner wrapper classes
		$inner_classes = 'gm-view-works-cta__inner';
		if ( $enable_animation ) {
			$inner_classes .= ' gm-view-works-cta__inner--hidden';
		}

		// Render attributes
		$this->add_render_attribute( 'wrapper', 'class', 'gm-view-works-cta' );
		$this->add_render_attribute( 'inner', [
			'class'          => $inner_classes,
			'data-animation' => $enable_animation ? 'true' : 'false',
			'data-threshold' => $settings['animation_threshold']['size'] ?? 0.15,
			'data-duration'  => ( $settings['animation_duration']['size'] ?? 600 ) . 'ms',
			'data-offset'    => ( $settings['animation_offset']['size'] ?? 20 ) . 'px',
		] );
		$this->add_render_attribute( 'heading', 'class', 'gm-view-works-cta__heading' );
		$this->add_render_attribute( 'button', 'class', 'gm-view-works-cta__button' );

		// Inline editing attributes
		$this->add_inline_editing_attributes( 'heading_text', 'advanced' );
		$this->add_inline_editing_attributes( 'button_text', 'none' );

		// Button link attributes
		if ( $show_button && ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_link'] );
		}

		// Convert newlines to <br> in heading text
		$heading_html = nl2br( esc_html( $settings['heading_text'] ) );
		?>
		<section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'inner' ); ?>>

				<<?php echo esc_html( $heading_tag ); ?> <?php $this->print_render_attribute_string( 'heading' ); ?>>
					<?php echo $heading_html; ?>
				</<?php echo esc_html( $heading_tag ); ?>>

				<?php if ( $show_button ) : ?>
					<a <?php $this->print_render_attribute_string( 'button' ); ?>>
						<?php echo esc_html( $settings['button_text'] ); ?>
					</a>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var showButton      = 'yes' === settings.show_button;
		var headingTag      = settings.heading_tag || 'h2';
		var enableAnimation = 'yes' === settings.enable_fade_up;

		var innerClass = 'gm-view-works-cta__inner';
		if ( enableAnimation ) {
			innerClass += ' gm-view-works-cta__inner--hidden';
		}

		// Convert newlines to <br>
		var headingHtml = settings.heading_text.replace( /\n/g, '<br>' );

		view.addRenderAttribute( 'wrapper', 'class', 'gm-view-works-cta' );
		view.addRenderAttribute( 'inner', {
			'class':          innerClass,
			'data-animation': enableAnimation ? 'true' : 'false',
			'data-threshold': settings.animation_threshold.size || 0.15,
			'data-duration':  ( settings.animation_duration.size || 600 ) + 'ms',
			'data-offset':    ( settings.animation_offset.size || 20 ) + 'px',
		} );
		view.addRenderAttribute( 'heading', 'class', 'gm-view-works-cta__heading' );
		view.addRenderAttribute( 'button', 'class', 'gm-view-works-cta__button' );

		view.addInlineEditingAttributes( 'heading_text', 'advanced' );
		view.addInlineEditingAttributes( 'button_text', 'none' );

		var buttonUrl = settings.button_link.url || '#';
		var target    = settings.button_link.is_external ? ' target="_blank"' : '';
		var nofollow  = settings.button_link.nofollow ? ' rel="nofollow"' : '';
		#>
		<section {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<div {{{ view.getRenderAttributeString( 'inner' ) }}}>

				<{{{ headingTag }}} {{{ view.getRenderAttributeString( 'heading' ) }}}>
					{{{ headingHtml }}}
				</{{{ headingTag }}}>

				<# if ( showButton ) { #>
					<a href="{{ buttonUrl }}"{{{ target }}}{{{ nofollow }}} {{{ view.getRenderAttributeString( 'button' ) }}}>
						{{{ settings.button_text }}}
					</a>
				<# } #>

			</div>
		</section>
		<?php
	}
}
