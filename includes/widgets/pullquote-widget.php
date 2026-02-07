<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * PullQuote Widget
 */
class PullQuote_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_pullquote';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Pull Quote', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-blockquote';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'quote', 'blockquote', 'testimonial' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-pullquote-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-pullquote-script' ];
	}

	protected function register_controls(): void {
		// Content Section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'quote_text',
			[
				'label'   => esc_html__( 'Quote', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Jedes Werk ist ein Dialog zwischen Farbe und Stille.',
				'rows'    => 4,
			]
		);

		$this->add_control(
			'show_quote_mark',
			[
				'label'        => esc_html__( 'Show Quote Mark', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'quote_mark',
			[
				'label'     => esc_html__( 'Quote Mark', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '"',
				'condition' => [ 'show_quote_mark' => 'yes' ],
			]
		);

		$this->add_control(
			'show_attribution',
			[
				'label'        => esc_html__( 'Show Attribution', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'attribution_text',
			[
				'label'     => esc_html__( 'Attribution', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '— Wolfgang Mueller',
				'condition' => [ 'show_attribution' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// Style Section
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
				'label'     => esc_html__( 'Background', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-pullquote' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .gm-pullquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Quote Mark Style
		$this->start_controls_section(
			'style_quote_mark',
			[
				'label'     => esc_html__( 'Quote Mark', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_quote_mark' => 'yes' ],
			]
		);

		$this->add_control(
			'quote_mark_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-pullquote__mark' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Quote Text Style
		$this->start_controls_section(
			'style_quote_text',
			[
				'label' => esc_html__( 'Quote Text', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_text_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F3F0',
				'selectors' => [
					'{{WRAPPER}} .gm-pullquote__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quote_typography',
				'selector' => '{{WRAPPER}} .gm-pullquote__text',
			]
		);

		$this->end_controls_section();

		// Animation
		$this->start_controls_section(
			'animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_animation',
			[
				'label'        => esc_html__( 'Enable Fade-Up', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings   = $this->get_settings_for_display();
		$anim_class = 'yes' === $settings['enable_animation'] ? 'gm-pullquote__inner--hidden' : '';
		?>
		<section class="gm-pullquote">
			<div class="gm-pullquote__inner <?php echo esc_attr( $anim_class ); ?>">
				<?php if ( 'yes' === $settings['show_quote_mark'] ) : ?>
					<span class="gm-pullquote__mark"><?php echo esc_html( $settings['quote_mark'] ); ?></span>
				<?php endif; ?>
				<blockquote class="gm-pullquote__text"><?php echo esc_html( $settings['quote_text'] ); ?></blockquote>
				<?php if ( 'yes' === $settings['show_attribution'] ) : ?>
					<p class="gm-pullquote__attribution"><?php echo esc_html( $settings['attribution_text'] ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var animClass = ( 'yes' === settings.enable_animation ) ? 'gm-pullquote__inner--hidden' : '';
		#>
		<section class="gm-pullquote">
			<div class="gm-pullquote__inner {{ animClass }}">
				<# if ( 'yes' === settings.show_quote_mark ) { #>
					<span class="gm-pullquote__mark">{{{ settings.quote_mark }}}</span>
				<# } #>
				<blockquote class="gm-pullquote__text">{{{ settings.quote_text }}}</blockquote>
				<# if ( 'yes' === settings.show_attribution ) { #>
					<p class="gm-pullquote__attribution">{{{ settings.attribution_text }}}</p>
				<# } #>
			</div>
		</section>
		<?php
	}
}
