<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

/**
 * About Artist Widget
 *
 * Two-column layout with artist portrait and biography.
 *
 * @since 1.0.0
 */
class About_Artist_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_about_artist';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - About Artist', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-person';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'artist', 'about', 'biography', 'profile', 'kuenstler' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-about-artist-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-about-artist-script' ];
	}

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_layout_controls();
		$this->register_style_section_controls();
		$this->register_style_label_controls();
		$this->register_style_heading_controls();
		$this->register_style_bio_controls();
		$this->register_style_cta_controls();
		$this->register_animation_controls();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_label',
			[
				'label'        => esc_html__( 'Show Label', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'label_text',
			[
				'label'       => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Der Künstler',
				'condition'   => [ 'show_label' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Heading', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Wolfgang Mueller',
				'label_block' => true,
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'bio_text',
			[
				'label'   => esc_html__( 'Biography', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '<p>Wolfgang Mueller arbeitet seit über vier Jahrzehnten an der Schnittstelle von Malerei, Zeichnung und Skizze. Seine Werke bewegen sich zwischen Abstraktion und figurativer Darstellung.</p><p>In seinem Atelier entstehen Arbeiten, die von der Stille und Konzentration des kreativen Prozesses geprägt sind — jedes Werk ein leiser Dialog zwischen Farbe, Linie und Fläche.</p>',
			]
		);

		$this->add_control(
			'artist_image',
			[
				'label'   => esc_html__( 'Artist Portrait', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'show_cta',
			[
				'label'        => esc_html__( 'Show CTA', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'cta_text',
			[
				'label'     => esc_html__( 'CTA Text', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Biografie lesen →',
				'condition' => [ 'show_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'cta_link',
			[
				'label'     => esc_html__( 'CTA Link', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::URL,
				'default'   => [ 'url' => '/ueber-den-kuenstler' ],
				'condition' => [ 'show_cta' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_layout_controls(): void {
		$this->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__( 'Layout', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'     => esc_html__( 'Column Gap', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default'   => [ 'size' => 64, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .gm-about-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

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
				'label'     => esc_html__( 'Background', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-about-section' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .gm-about-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_label_controls(): void {
		$this->start_controls_section(
			'style_label',
			[
				'label'     => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_label' => 'yes' ],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-about-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .gm-about-label',
			]
		);

		$this->end_controls_section();
	}

	private function register_style_heading_controls(): void {
		$this->start_controls_section(
			'style_heading',
			[
				'label' => esc_html__( 'Heading', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-about-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .gm-about-heading',
			]
		);

		$this->end_controls_section();
	}

	private function register_style_bio_controls(): void {
		$this->start_controls_section(
			'style_bio',
			[
				'label' => esc_html__( 'Biography', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bio_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-about-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'bio_typography',
				'selector' => '{{WRAPPER}} .gm-about-bio',
			]
		);

		$this->end_controls_section();
	}

	private function register_style_cta_controls(): void {
		$this->start_controls_section(
			'style_cta',
			[
				'label'     => esc_html__( 'CTA', 'galerie-mueller-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'cta_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-about-cta' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .gm-about-cta:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_animation_controls(): void {
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

		$this->add_control(
			'animation_threshold',
			[
				'label'     => esc_html__( 'Threshold', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
				'default'   => [ 'size' => 0.15 ],
				'condition' => [ 'enable_animation' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings    = $this->get_settings_for_display();
		$heading_tag = $settings['heading_tag'] ?? 'h2';
		$anim_class  = 'yes' === $settings['enable_animation'] ? 'gm-about-grid--hidden' : '';
		$threshold   = $settings['animation_threshold']['size'] ?? 0.15;
		?>
		<section class="gm-about-section">
			<div class="gm-about-grid <?php echo esc_attr( $anim_class ); ?>"
				 data-anim-threshold="<?php echo esc_attr( $threshold ); ?>">

				<div class="gm-about-text">
					<?php if ( 'yes' === $settings['show_label'] ) : ?>
						<p class="gm-about-label"><?php echo esc_html( $settings['label_text'] ); ?></p>
					<?php endif; ?>

					<<?php echo esc_html( $heading_tag ); ?> class="gm-about-heading">
						<?php echo esc_html( $settings['heading_text'] ); ?>
					</<?php echo esc_html( $heading_tag ); ?>>

					<div class="gm-about-bio">
						<?php echo wp_kses_post( $settings['bio_text'] ); ?>
					</div>

					<?php if ( 'yes' === $settings['show_cta'] ) : ?>
						<a href="<?php echo esc_url( $settings['cta_link']['url'] ?? '#' ); ?>" class="gm-about-cta">
							<?php echo wp_kses_post( $settings['cta_text'] ); ?>
						</a>
					<?php endif; ?>
				</div>

				<div class="gm-about-portrait">
					<div class="gm-about-image">
						<?php if ( ! empty( $settings['artist_image']['url'] ) ) : ?>
							<img src="<?php echo esc_url( $settings['artist_image']['url'] ); ?>"
								 alt="<?php echo esc_attr( $settings['heading_text'] ); ?>" />
						<?php endif; ?>
					</div>
				</div>

			</div>
		</section>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var headingTag = settings.heading_tag || 'h2';
		var animClass = ( 'yes' === settings.enable_animation ) ? 'gm-about-grid--hidden' : '';
		#>
		<section class="gm-about-section">
			<div class="gm-about-grid {{ animClass }}">
				<div class="gm-about-text">
					<# if ( 'yes' === settings.show_label ) { #>
						<p class="gm-about-label">{{{ settings.label_text }}}</p>
					<# } #>
					<{{{ headingTag }}} class="gm-about-heading">{{{ settings.heading_text }}}</{{{ headingTag }}}>
					<div class="gm-about-bio">{{{ settings.bio_text }}}</div>
					<# if ( 'yes' === settings.show_cta ) { #>
						<a href="{{ settings.cta_link.url }}" class="gm-about-cta">{{{ settings.cta_text }}}</a>
					<# } #>
				</div>
				<div class="gm-about-portrait">
					<div class="gm-about-image">
						<# if ( settings.artist_image.url ) { #>
							<img src="{{ settings.artist_image.url }}" alt="{{ settings.heading_text }}" />
						<# } #>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
