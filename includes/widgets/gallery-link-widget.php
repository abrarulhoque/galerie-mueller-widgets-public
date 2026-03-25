<?php
namespace Galerie_Mueller_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gallery Link CTA Widget
 *
 * Simple CTA section linking to the gallery page with accent line,
 * descriptive text, and arrow link.
 *
 * @since 1.2.0
 */
class Gallery_Link_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_gallery_link';
	}

	public function get_title(): string {
		return esc_html__( 'Gallery Link CTA', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-external-link-square';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'gallery', 'galerie', 'link', 'cta', 'werke', 'navigation' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-gallery-link-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-gallery-link-script' ];
	}

	protected function register_controls(): void {

		/* =================================================================
		   TAB_CONTENT
		   ================================================================= */

		// ---- Section: Inhalt (Content) ----
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Inhalt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Moechten Sie die Werke von Wolfgang Mueller ansehen?', 'galerie-mueller-widgets' ),
				'placeholder' => esc_html__( 'Text eingeben...', 'galerie-mueller-widgets' ),
				'rows'        => 3,
			]
		);

		$this->add_control(
			'link_text',
			[
				'label'       => esc_html__( 'Link-Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Zur Galerie', 'galerie-mueller-widgets' ),
				'placeholder' => esc_html__( 'z. B. Zur Galerie', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_url',
			[
				'label'       => esc_html__( 'Link-URL', 'galerie-mueller-widgets' ),
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
			'show_arrow',
			[
				'label'        => esc_html__( 'Pfeil anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// ---- Section: Animation ----
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

		/* =================================================================
		   TAB_STYLE
		   ================================================================= */

		// ---- Section Style: Abschnitt (Section) ----
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
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-link' => 'background-color: {{VALUE}};',
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
					'top'      => 80,
					'right'    => 0,
					'bottom'   => 80,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
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
					'{{WRAPPER}} .gm-gallery-link__inner' => 'max-width: {{SIZE}}{{UNIT}};',
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
				'selectors'            => [
					'{{WRAPPER}} .gm-gallery-link__inner' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// ---- Section Style: Akzentlinie (Accent Line) ----
		$this->start_controls_section(
			'accent_line_style_section',
			[
				'label'     => esc_html__( 'Akzentlinie', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_accent_line' => 'yes',
				],
			]
		);

		$this->add_control(
			'accent_line_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-link__accent-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_line_width',
			[
				'label'      => esc_html__( 'Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
					'em' => [
						'min' => 1,
						'max' => 12,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-link__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_height',
			[
				'label'      => esc_html__( 'Hoehe', 'galerie-mueller-widgets' ),
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
					'{{WRAPPER}} .gm-gallery-link__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_bottom_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
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
					'{{WRAPPER}} .gm-gallery-link__accent-line' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ---- Section Style: Text-Stil (Text Style) ----
		$this->start_controls_section(
			'text_style_section',
			[
				'label' => esc_html__( 'Text-Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-link__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-gallery-link__text',
			]
		);

		$this->add_control(
			'text_bottom_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-link__text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_alignment',
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
					'{{WRAPPER}} .gm-gallery-link__text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ---- Section Style: Link-Stil (Link Style) ----
		$this->start_controls_section(
			'link_style_section',
			[
				'label' => esc_html__( 'Link-Stil', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-gallery-link__link',
			]
		);

		$this->add_control(
			'link_letter_spacing',
			[
				'label'      => esc_html__( 'Buchstabenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 5,
						'step' => 0.05,
					],
					'em' => [
						'min'  => 0,
						'max'  => 0.5,
						'step' => 0.005,
					],
				],
				'default'    => [
					'size' => 0.35,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-link__link' => 'letter-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Normal / Hover Tabs
		$this->start_controls_tabs( 'link_style_tabs' );

		// -- Normal Tab --
		$this->start_controls_tab(
			'link_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-link__link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// -- Hover Tab --
		$this->start_controls_tab(
			'link_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'link_color_hover',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-link__link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// After tabs
		$this->add_control(
			'link_hover_transition',
			[
				'label'     => esc_html__( 'Transition-Dauer', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'default'   => [
					'size' => 300,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-link__link' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->add_control(
			'arrow_spacing',
			[
				'label'      => esc_html__( 'Pfeil-Abstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
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
				'condition'  => [
					'show_arrow' => 'yes',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-link__arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$enable_animation  = 'yes' === $settings['enable_fade_up'];
		$show_accent_line  = 'yes' === $settings['show_accent_line'];
		$show_arrow        = 'yes' === $settings['show_arrow'];

		// Inner wrapper classes
		$inner_classes = 'gm-gallery-link__inner';
		if ( $enable_animation ) {
			$inner_classes .= ' gm-gallery-link__inner--hidden';
		}

		// Render attributes
		$this->add_render_attribute( 'wrapper', 'class', 'gm-gallery-link' );
		$this->add_render_attribute( 'inner', [
			'class'          => $inner_classes,
			'data-animation' => $enable_animation ? 'true' : 'false',
			'data-threshold' => $settings['animation_threshold']['size'] ?? 0.15,
			'data-duration'  => ( $settings['animation_duration']['size'] ?? 600 ) . 'ms',
			'data-offset'    => ( $settings['animation_offset']['size'] ?? 20 ) . 'px',
		] );
		$this->add_render_attribute( 'text', 'class', 'gm-gallery-link__text' );

		// Link render attributes
		$this->add_render_attribute( 'link', 'class', 'gm-gallery-link__link' );
		if ( ! empty( $settings['link_url']['url'] ) ) {
			$this->add_link_attributes( 'link', $settings['link_url'] );
		}

		// Inline editing attributes
		$this->add_inline_editing_attributes( 'text', 'basic' );
		$this->add_inline_editing_attributes( 'link_text', 'none' );
		?>
		<section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'inner' ); ?>>

				<?php if ( $show_accent_line ) : ?>
					<div class="gm-gallery-link__accent-line"></div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['text'] ) ) : ?>
					<p <?php $this->print_render_attribute_string( 'text' ); ?>>
						<?php echo wp_kses_post( $settings['text'] ); ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['link_text'] ) ) : ?>
					<a <?php $this->print_render_attribute_string( 'link' ); ?>>
						<span class="gm-gallery-link__link-text"><?php echo esc_html( $settings['link_text'] ); ?></span>
						<?php if ( $show_arrow ) : ?>
							<span class="gm-gallery-link__arrow">&rarr;</span>
						<?php endif; ?>
					</a>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var enableAnimation = 'yes' === settings.enable_fade_up;
		var showAccentLine  = 'yes' === settings.show_accent_line;
		var showArrow       = 'yes' === settings.show_arrow;

		var innerClass = 'gm-gallery-link__inner';
		if ( enableAnimation ) {
			innerClass += ' gm-gallery-link__inner--hidden';
		}

		view.addRenderAttribute( 'wrapper', 'class', 'gm-gallery-link' );
		view.addRenderAttribute( 'inner', {
			'class':          innerClass,
			'data-animation': enableAnimation ? 'true' : 'false',
			'data-threshold': settings.animation_threshold.size || 0.15,
			'data-duration':  ( settings.animation_duration.size || 600 ) + 'ms',
			'data-offset':    ( settings.animation_offset.size || 20 ) + 'px',
		} );
		view.addRenderAttribute( 'text', 'class', 'gm-gallery-link__text' );
		view.addRenderAttribute( 'link', 'class', 'gm-gallery-link__link' );

		if ( settings.link_url && settings.link_url.url ) {
			view.addRenderAttribute( 'link', 'href', settings.link_url.url );
		}

		view.addInlineEditingAttributes( 'text', 'basic' );
		view.addInlineEditingAttributes( 'link_text', 'none' );
		#>
		<section {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<div {{{ view.getRenderAttributeString( 'inner' ) }}}>

				<# if ( showAccentLine ) { #>
					<div class="gm-gallery-link__accent-line"></div>
				<# } #>

				<# if ( settings.text ) { #>
					<p {{{ view.getRenderAttributeString( 'text' ) }}}>
						{{{ settings.text }}}
					</p>
				<# } #>

				<# if ( settings.link_text ) { #>
					<a {{{ view.getRenderAttributeString( 'link' ) }}}>
						<span class="gm-gallery-link__link-text">{{{ settings.link_text }}}</span>
						<# if ( showArrow ) { #>
							<span class="gm-gallery-link__arrow">&rarr;</span>
						<# } #>
					</a>
				<# } #>

			</div>
		</section>
		<?php
	}
}
