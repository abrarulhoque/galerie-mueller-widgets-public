<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Contact CTA Widget
 */
class Contact_CTA_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_contact_cta';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Contact CTA', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-envelope';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'contact', 'cta', 'call to action', 'button' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-contact-cta-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-contact-cta-script' ];
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
			'show_accent_line',
			[
				'label'        => esc_html__( 'Show Accent Line', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
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
				'label'     => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Kontakt',
				'condition' => [ 'show_label' => 'yes' ],
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'       => esc_html__( 'Heading', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Interesse an einem Werk?',
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label'   => esc_html__( 'Description', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Kontaktieren Sie uns für Preise, Verfügbarkeit oder um einen Besuchstermin im Atelier zu vereinbaren.',
				'rows'    => 3,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Anfrage senden',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'   => esc_html__( 'Button Link', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '/kontakt' ],
			]
		);

		$this->add_control(
			'show_footer',
			[
				'label'        => esc_html__( 'Show Footer', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'footer_text',
			[
				'label'     => esc_html__( 'Footer Text', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Antwort innerhalb von 24 Stunden',
				'condition' => [ 'show_footer' => 'yes' ],
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
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Button Style
		$this->start_controls_section(
			'style_button',
			[
				'label' => esc_html__( 'Button', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-cta__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg',
			[
				'label'     => esc_html__( 'Hover Background', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-cta__button:hover' => 'background-color: {{VALUE}};',
				],
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
		$anim_class = 'yes' === $settings['enable_animation'] ? 'gm-contact-cta__inner--hidden' : '';
		?>
		<section class="gm-contact-cta">
			<div class="gm-contact-cta__inner <?php echo esc_attr( $anim_class ); ?>">
				<?php if ( 'yes' === $settings['show_accent_line'] ) : ?>
					<div class="gm-contact-cta__accent-line"></div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_label'] ) : ?>
					<p class="gm-contact-cta__label"><?php echo esc_html( $settings['label_text'] ); ?></p>
				<?php endif; ?>

				<h2 class="gm-contact-cta__heading"><?php echo esc_html( $settings['heading_text'] ); ?></h2>
				<p class="gm-contact-cta__description"><?php echo esc_html( $settings['description_text'] ); ?></p>

				<a href="<?php echo esc_url( $settings['button_link']['url'] ?? '#' ); ?>" class="gm-contact-cta__button">
					<?php echo esc_html( $settings['button_text'] ); ?>
				</a>

				<?php if ( 'yes' === $settings['show_footer'] ) : ?>
					<p class="gm-contact-cta__footer"><?php echo esc_html( $settings['footer_text'] ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var animClass = ( 'yes' === settings.enable_animation ) ? 'gm-contact-cta__inner--hidden' : '';
		#>
		<section class="gm-contact-cta">
			<div class="gm-contact-cta__inner {{ animClass }}">
				<# if ( 'yes' === settings.show_accent_line ) { #>
					<div class="gm-contact-cta__accent-line"></div>
				<# } #>
				<# if ( 'yes' === settings.show_label ) { #>
					<p class="gm-contact-cta__label">{{{ settings.label_text }}}</p>
				<# } #>
				<h2 class="gm-contact-cta__heading">{{{ settings.heading_text }}}</h2>
				<p class="gm-contact-cta__description">{{{ settings.description_text }}}</p>
				<a href="{{ settings.button_link.url }}" class="gm-contact-cta__button">{{{ settings.button_text }}}</a>
				<# if ( 'yes' === settings.show_footer ) { #>
					<p class="gm-contact-cta__footer">{{{ settings.footer_text }}}</p>
				<# } #>
			</div>
		</section>
		<?php
	}
}
