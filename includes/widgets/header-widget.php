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
 * Header Widget - Sticky navigation with mobile menu
 */
class Header_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_header';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Header', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-header';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'header', 'navigation', 'menu', 'sticky', 'nav' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-header-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-header-script' ];
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

		// Content: Left Navigation
		$this->start_controls_section(
			'nav_left_section',
			[
				'label' => esc_html__( 'Left Navigation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_left = new Repeater();
		$repeater_left->add_control(
			'link_label',
			[
				'label'   => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Link',
			]
		);
		$repeater_left->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'URL', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'nav_links_left',
			[
				'label'   => esc_html__( 'Links', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater_left->get_controls(),
				'default' => [
					[ 'link_label' => 'Startseite', 'link_url' => [ 'url' => '/' ] ],
					[ 'link_label' => 'Über den Künstler', 'link_url' => [ 'url' => '/ueber-den-kuenstler' ] ],
				],
				'title_field' => '{{{ link_label }}}',
			]
		);

		$this->end_controls_section();

		// Content: Right Navigation
		$this->start_controls_section(
			'nav_right_section',
			[
				'label' => esc_html__( 'Right Navigation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_right = new Repeater();
		$repeater_right->add_control(
			'link_label',
			[
				'label'   => esc_html__( 'Label', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Link',
			]
		);
		$repeater_right->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'URL', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'nav_links_right',
			[
				'label'   => esc_html__( 'Links', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater_right->get_controls(),
				'default' => [
					[ 'link_label' => 'Galerie', 'link_url' => [ 'url' => '/galerie' ] ],
					[ 'link_label' => 'Kontakt', 'link_url' => [ 'url' => '/kontakt' ] ],
				],
				'title_field' => '{{{ link_label }}}',
			]
		);

		$this->end_controls_section();

		// Content: Behavior
		$this->start_controls_section(
			'behavior_section',
			[
				'label' => esc_html__( 'Behavior', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'scroll_threshold',
			[
				'label'   => esc_html__( 'Scroll Threshold (px)', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 40,
				'min'     => 0,
				'max'     => 500,
			]
		);

		$this->end_controls_section();

		// Style: Header
		$this->start_controls_section(
			'style_header',
			[
				'label' => esc_html__( 'Header', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'header_bg_scrolled',
			[
				'label'     => esc_html__( 'Background (Scrolled)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(250,250,250,0.95)',
				'selectors' => [
					'{{WRAPPER}} .gm-header.is-scrolled' => 'background-color: {{VALUE}};',
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
			'logo_color_normal',
			[
				'label'     => esc_html__( 'Color (Initial)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-header__logo' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'logo_color_scrolled',
			[
				'label'     => esc_html__( 'Color (Scrolled)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-header.is-scrolled .gm-header__logo' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style: Links
		$this->start_controls_section(
			'style_links',
			[
				'label' => esc_html__( 'Navigation Links', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'link_color_normal',
			[
				'label'     => esc_html__( 'Color (Initial)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-header__link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color_scrolled',
			[
				'label'     => esc_html__( 'Color (Scrolled)', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-header.is-scrolled .gm-header__link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-header__link-underline' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings   = $this->get_settings_for_display();
		$links_left = $settings['nav_links_left'] ?? [];
		$links_right = $settings['nav_links_right'] ?? [];
		$threshold  = $settings['scroll_threshold'] ?? 40;
		?>
		<header class="gm-header" data-scroll-threshold="<?php echo esc_attr( $threshold ); ?>">
			<nav class="gm-header__nav">

				<!-- Left Nav -->
				<ul class="gm-header__nav-left">
					<?php foreach ( $links_left as $item ) : ?>
						<li>
							<a href="<?php echo esc_url( $item['link_url']['url'] ?? '#' ); ?>" class="gm-header__link">
								<?php echo esc_html( $item['link_label'] ); ?>
								<span class="gm-header__link-underline"></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<!-- Logo -->
				<a href="<?php echo esc_url( $settings['logo_link']['url'] ?? '/' ); ?>" class="gm-header__logo">
					<?php echo esc_html( $settings['logo_text'] ); ?>
				</a>

				<!-- Right Nav -->
				<ul class="gm-header__nav-right">
					<?php foreach ( $links_right as $item ) : ?>
						<li>
							<a href="<?php echo esc_url( $item['link_url']['url'] ?? '#' ); ?>" class="gm-header__link">
								<?php echo esc_html( $item['link_label'] ); ?>
								<span class="gm-header__link-underline"></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<!-- Hamburger -->
				<button class="gm-header__hamburger" aria-label="<?php esc_attr_e( 'Toggle Menu', 'galerie-mueller-widgets' ); ?>">
					<span class="gm-header__hamburger-line gm-header__hamburger-line--top"></span>
					<span class="gm-header__hamburger-line gm-header__hamburger-line--bottom"></span>
				</button>

				<!-- Mobile Overlay -->
				<div class="gm-header__mobile-overlay">
					<ul class="gm-header__mobile-links">
						<?php foreach ( array_merge( $links_left, $links_right ) as $item ) : ?>
							<li>
								<a href="<?php echo esc_url( $item['link_url']['url'] ?? '#' ); ?>" class="gm-header__mobile-link">
									<?php echo esc_html( $item['link_label'] ); ?>
									<span class="gm-header__link-underline"></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

			</nav>
		</header>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var linksLeft = settings.nav_links_left || [];
		var linksRight = settings.nav_links_right || [];
		var allLinks = linksLeft.concat(linksRight);
		#>
		<header class="gm-header" data-scroll-threshold="{{ settings.scroll_threshold }}">
			<nav class="gm-header__nav">
				<ul class="gm-header__nav-left">
					<# _.each( linksLeft, function( item ) { #>
						<li>
							<a href="{{ item.link_url.url }}" class="gm-header__link">
								{{{ item.link_label }}}
								<span class="gm-header__link-underline"></span>
							</a>
						</li>
					<# }); #>
				</ul>
				<a href="{{ settings.logo_link.url }}" class="gm-header__logo">{{{ settings.logo_text }}}</a>
				<ul class="gm-header__nav-right">
					<# _.each( linksRight, function( item ) { #>
						<li>
							<a href="{{ item.link_url.url }}" class="gm-header__link">
								{{{ item.link_label }}}
								<span class="gm-header__link-underline"></span>
							</a>
						</li>
					<# }); #>
				</ul>
				<button class="gm-header__hamburger">
					<span class="gm-header__hamburger-line gm-header__hamburger-line--top"></span>
					<span class="gm-header__hamburger-line gm-header__hamburger-line--bottom"></span>
				</button>
				<div class="gm-header__mobile-overlay">
					<ul class="gm-header__mobile-links">
						<# _.each( allLinks, function( item ) { #>
							<li>
								<a href="{{ item.link_url.url }}" class="gm-header__mobile-link">
									{{{ item.link_label }}}
									<span class="gm-header__link-underline"></span>
								</a>
							</li>
						<# }); #>
					</ul>
				</div>
			</nav>
		</header>
		<?php
	}
}
