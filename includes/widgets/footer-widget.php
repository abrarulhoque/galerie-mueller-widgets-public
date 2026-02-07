<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

/**
 * Footer Widget - Logo, nav links, copyright
 */
class Footer_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_footer';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Footer', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-footer';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'footer', 'legal', 'copyright', 'impressum' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-footer-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-footer-script' ];
	}

	protected function register_controls(): void {
		// Content: Logo
		$this->start_controls_section(
			'logo_section',
			[
				'label' => esc_html__( 'Logo', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'logo_text',
			[
				'label'   => esc_html__( 'Logo Text', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Galerie Mueller',
			]
		);

		$this->add_control(
			'logo_link',
			[
				'label'   => esc_html__( 'Logo Link', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '/' ],
			]
		);

		$this->end_controls_section();

		// Content: Footer Links
		$this->start_controls_section(
			'links_section',
			[
				'label' => esc_html__( 'Footer Links', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'link_label',
			[
				'label'   => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Link',
			]
		);
		$repeater->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'URL', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'footer_links',
			[
				'label'   => esc_html__( 'Links', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[ 'link_label' => 'Impressum', 'link_url' => [ 'url' => '/impressum' ] ],
					[ 'link_label' => 'Datenschutzerklärung', 'link_url' => [ 'url' => '/datenschutz' ] ],
				],
				'title_field'   => '{{{ link_label }}}',
				'prevent_empty' => false,
			]
		);

		$this->add_control(
			'link_separator',
			[
				'label'   => esc_html__( 'Separator', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '·',
			]
		);

		$this->end_controls_section();

		// Content: Copyright
		$this->start_controls_section(
			'copyright_section',
			[
				'label' => esc_html__( 'Copyright', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_copyright',
			[
				'label'        => esc_html__( 'Show Copyright', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'copyright_text',
			[
				'label'     => esc_html__( 'Copyright Text', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Galerie Mueller. Alle Rechte vorbehalten.',
				'condition' => [ 'show_copyright' => 'yes' ],
			]
		);

		$this->add_control(
			'show_year',
			[
				'label'        => esc_html__( 'Show Dynamic Year', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition'    => [ 'show_copyright' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// Style: Footer
		$this->start_controls_section(
			'style_footer',
			[
				'label' => esc_html__( 'Footer', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'footer_bg_color',
			[
				'label'     => esc_html__( 'Background', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-footer' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style: Logo
		$this->start_controls_section(
			'style_logo',
			[
				'label' => esc_html__( 'Logo', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'logo_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F3F0',
				'selectors' => [
					'{{WRAPPER}} .gm-footer-logo a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'logo_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-footer-logo a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style: Links
		$this->start_controls_section(
			'style_links',
			[
				'label' => esc_html__( 'Links', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'links_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-footer-nav a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'links_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-footer-nav a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$links    = $settings['footer_links'] ?? [];
		$sep      = $settings['link_separator'] ?? '·';
		?>
		<footer class="gm-footer">
			<div class="gm-footer-inner">

				<!-- Logo -->
				<div class="gm-footer-logo">
					<a href="<?php echo esc_url( $settings['logo_link']['url'] ?? '/' ); ?>">
						<?php echo esc_html( $settings['logo_text'] ); ?>
					</a>
				</div>

				<!-- Links -->
				<?php if ( ! empty( $links ) ) : ?>
					<nav class="gm-footer-nav">
						<?php foreach ( $links as $index => $item ) : ?>
							<?php if ( $index > 0 ) : ?>
								<span class="gm-separator"><?php echo esc_html( $sep ); ?></span>
							<?php endif; ?>
							<a href="<?php echo esc_url( $item['link_url']['url'] ?? '#' ); ?>">
								<?php echo esc_html( $item['link_label'] ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>

				<!-- Copyright -->
				<?php if ( 'yes' === $settings['show_copyright'] ) : ?>
					<p class="gm-footer-copyright">
						<?php if ( 'yes' === $settings['show_year'] ) : ?>
							&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
						<?php endif; ?>
						<?php echo esc_html( $settings['copyright_text'] ); ?>
					</p>
				<?php endif; ?>

			</div>
		</footer>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var links = settings.footer_links || [];
		var sep = settings.link_separator || '·';
		var year = new Date().getFullYear();
		#>
		<footer class="gm-footer">
			<div class="gm-footer-inner">
				<div class="gm-footer-logo">
					<a href="{{ settings.logo_link.url }}">{{{ settings.logo_text }}}</a>
				</div>
				<# if ( links.length ) { #>
					<nav class="gm-footer-nav">
						<# _.each( links, function( item, index ) { #>
							<# if ( index > 0 ) { #>
								<span class="gm-separator">{{{ sep }}}</span>
							<# } #>
							<a href="{{ item.link_url.url }}">{{{ item.link_label }}}</a>
						<# }); #>
					</nav>
				<# } #>
				<# if ( 'yes' === settings.show_copyright ) { #>
					<p class="gm-footer-copyright">
						<# if ( 'yes' === settings.show_year ) { #>
							&copy; {{ year }}
						<# } #>
						{{{ settings.copyright_text }}}
					</p>
				<# } #>
			</div>
		</footer>
		<?php
	}
}
