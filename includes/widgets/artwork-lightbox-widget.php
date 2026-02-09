<?php
/**
 * Artwork Lightbox Widget.
 *
 * Elementor widget that displays a full-screen artwork lightbox with details.
 *
 * @since 1.0.0
 */

namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Artwork_Lightbox_Widget class.
 */
class Artwork_Lightbox_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'gm_artwork_lightbox';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Artwork Lightbox', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-lightbox';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'lightbox', 'modal', 'artwork', 'gallery', 'image' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'gm-artwork-lightbox-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends(): array {
		return [ 'gm-artwork-lightbox-script' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// =============================================
		// CONTENT TAB - Content Section
		// =============================================
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'close_button_text',
			[
				'label'   => esc_html__( 'Close Button Label', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Schließen', 'galerie-mueller-widgets' ),
				'description' => esc_html__( 'Screen reader text for close button', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'cta_button_text',
			[
				'label'   => esc_html__( 'CTA Button Text', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Anfrage stellen', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'cta_button_url',
			[
				'label'   => esc_html__( 'CTA Button URL', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '/kontakt',
				],
			]
		);

		$this->add_control(
			'enable_url_params',
			[
				'label'        => esc_html__( 'Append Artwork to URL', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Appends ?werk={{title}} to the CTA URL', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'prev_button_text',
			[
				'label'   => esc_html__( 'Previous Button Text', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '← Vorheriges', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'next_button_text',
			[
				'label'   => esc_html__( 'Next Button Text', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Nächstes →', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'        => esc_html__( 'Show Navigation', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_dimensions',
			[
				'label'        => esc_html__( 'Show Dimensions', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label'        => esc_html__( 'Show Divider', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Hide', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// =============================================
		// CONTENT TAB - Behavior Section
		// =============================================
		$this->start_controls_section(
			'behavior_section',
			[
				'label' => esc_html__( 'Behavior', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_entrance_animation',
			[
				'label'        => esc_html__( 'Enable Entrance Animation', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label'     => esc_html__( 'Animation Duration (ms)', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 100, 'max' => 800, 'step' => 50 ],
				],
				'default'   => [ 'size' => 300 ],
				'condition' => [ 'enable_entrance_animation' => 'yes' ],
			]
		);

		$this->add_control(
			'enable_keyboard_nav',
			[
				'label'        => esc_html__( 'Enable Keyboard Navigation', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Use arrow keys to navigate between artworks', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'enable_click_outside',
			[
				'label'        => esc_html__( 'Close on Click Outside', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Overlay
		// =============================================
		$this->start_controls_section(
			'overlay_style',
			[
				'label' => esc_html__( 'Overlay', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.8)',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_backdrop_blur',
			[
				'label'      => esc_html__( 'Backdrop Blur', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-lightbox__overlay' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Modal
		// =============================================
		$this->start_controls_section(
			'modal_style',
			[
				'label' => esc_html__( 'Modal', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'modal_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'modal_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 600, 'max' => 1400, 'step' => 10 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1024 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-lightbox__content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'modal_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 8,
					'right'    => 8,
					'bottom'   => 8,
					'left'     => 8,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-lightbox__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'modal_box_shadow',
				'selector' => '{{WRAPPER}} .gm-lightbox__content',
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Close Button
		// =============================================
		$this->start_controls_section(
			'close_button_style',
			[
				'label' => esc_html__( 'Close Button', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'close_button_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__close' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__close:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'close_button_size',
			[
				'label'      => esc_html__( 'Size', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 16, 'max' => 48, 'step' => 2 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-lightbox__close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Title
		// =============================================
		$this->start_controls_section(
			'title_style',
			[
				'label' => esc_html__( 'Title', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F5F3F0',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gm-lightbox__title',
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Details
		// =============================================
		$this->start_controls_section(
			'details_style',
			[
				'label' => esc_html__( 'Details', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'details_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__details' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'details_typography',
				'selector' => '{{WRAPPER}} .gm-lightbox__details',
			]
		);

		$this->add_control(
			'dimensions_color',
			[
				'label'     => esc_html__( 'Dimensions Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.5)',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__dimensions' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_dimensions' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - CTA Button
		// =============================================
		$this->start_controls_section(
			'cta_button_style',
			[
				'label' => esc_html__( 'CTA Button', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'cta_button_tabs' );

		$this->start_controls_tab(
			'cta_button_normal_tab',
			[ 'label' => esc_html__( 'Normal', 'galerie-mueller-widgets' ) ]
		);

		$this->add_control(
			'cta_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__cta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cta_button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cta_button_hover_tab',
			[ 'label' => esc_html__( 'Hover', 'galerie-mueller-widgets' ) ]
		);

		$this->add_control(
			'cta_button_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__cta:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cta_button_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#7A6A4F',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__cta:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'cta_button_typography',
				'selector'  => '{{WRAPPER}} .gm-lightbox__cta',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'cta_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 16,
					'right'    => 40,
					'bottom'   => 16,
					'left'     => 40,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-lightbox__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB - Navigation
		// =============================================
		$this->start_controls_section(
			'navigation_style',
			[
				'label'     => esc_html__( 'Navigation', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_navigation' => 'yes' ],
			]
		);

		$this->add_control(
			'nav_buttons_color',
			[
				'label'     => esc_html__( 'Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.4)',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__nav-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_buttons_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.6)',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__nav-button:hover:not(:disabled)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_buttons_disabled_color',
			[
				'label'     => esc_html__( 'Disabled Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.3)',
				'selectors' => [
					'{{WRAPPER}} .gm-lightbox__nav-button:disabled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'nav_buttons_typography',
				'selector' => '{{WRAPPER}} .gm-lightbox__nav-button',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Build data attributes for JavaScript
		$data_settings = [
			'enable_click_outside'     => $settings['enable_click_outside'],
			'enable_keyboard_nav'      => $settings['enable_keyboard_nav'],
			'animation_duration'       => $settings['animation_duration']['size'] ?? 300,
			'cta_button_url'           => $settings['cta_button_url']['url'] ?? '/kontakt',
			'enable_url_params'        => $settings['enable_url_params'],
			'show_navigation'          => $settings['show_navigation'],
			'show_dimensions'          => $settings['show_dimensions'],
			'enable_entrance_animation' => $settings['enable_entrance_animation'],
		];

		$this->add_render_attribute( 'overlay', [
			'class'         => 'gm-lightbox__overlay gm-lightbox__overlay--hidden',
			'data-settings' => wp_json_encode( $data_settings ),
			'aria-hidden'   => 'true',
			'role'          => 'dialog',
			'aria-modal'    => 'true',
			'aria-label'    => esc_attr__( 'Artwork Details', 'galerie-mueller-widgets' ),
		] );

		// CTA link attributes
		if ( ! empty( $settings['cta_button_url']['url'] ) ) {
			$this->add_link_attributes( 'cta_link', $settings['cta_button_url'] );
		}
		$this->add_render_attribute( 'cta_link', 'class', 'gm-lightbox__cta' );
		?>

		<div <?php $this->print_render_attribute_string( 'overlay' ); ?>>
			<button class="gm-lightbox__close" aria-label="<?php echo esc_attr( $settings['close_button_text'] ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

			<div class="gm-lightbox__content">
				<div class="gm-lightbox__image-container">
					<img class="gm-lightbox__image" src="" alt="" width="800" height="1000" />
				</div>

				<div class="gm-lightbox__info-panel">
					<h2 class="gm-lightbox__title"></h2>
					<p class="gm-lightbox__details gm-lightbox__details--medium"></p>
					<p class="gm-lightbox__details gm-lightbox__details--year"></p>

					<?php if ( 'yes' === $settings['show_dimensions'] ) : ?>
						<p class="gm-lightbox__dimensions"></p>
					<?php endif; ?>

					<?php if ( 'yes' === $settings['show_divider'] ) : ?>
						<div class="gm-lightbox__divider"></div>
					<?php endif; ?>

					<a <?php $this->print_render_attribute_string( 'cta_link' ); ?>>
						<?php echo esc_html( $settings['cta_button_text'] ); ?>
					</a>

					<?php if ( 'yes' === $settings['show_navigation'] ) : ?>
						<div class="gm-lightbox__navigation">
							<button class="gm-lightbox__nav-button gm-lightbox__nav-button--prev">
								<?php echo esc_html( $settings['prev_button_text'] ); ?>
							</button>
							<button class="gm-lightbox__nav-button gm-lightbox__nav-button--next">
								<?php echo esc_html( $settings['next_button_text'] ); ?>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<#
		var dataSettings = {
			enable_click_outside: settings.enable_click_outside,
			enable_keyboard_nav: settings.enable_keyboard_nav,
			animation_duration: settings.animation_duration.size || 300,
			cta_button_url: settings.cta_button_url.url || '/kontakt',
			enable_url_params: settings.enable_url_params,
			show_navigation: settings.show_navigation,
			show_dimensions: settings.show_dimensions,
			enable_entrance_animation: settings.enable_entrance_animation
		};
		#>

		<div class="gm-lightbox__overlay gm-lightbox__overlay--hidden"
		     data-settings="{{ JSON.stringify(dataSettings) }}"
		     aria-hidden="true"
		     role="dialog"
		     aria-modal="true">

			<button class="gm-lightbox__close" aria-label="{{ settings.close_button_text }}">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

			<div class="gm-lightbox__content">
				<div class="gm-lightbox__image-container">
					<img class="gm-lightbox__image" src="" alt="" width="800" height="1000" />
				</div>

				<div class="gm-lightbox__info-panel">
					<h2 class="gm-lightbox__title">Artwork Title</h2>
					<p class="gm-lightbox__details gm-lightbox__details--medium">Medium placeholder</p>
					<p class="gm-lightbox__details gm-lightbox__details--year">Year placeholder</p>

					<# if ( 'yes' === settings.show_dimensions ) { #>
						<p class="gm-lightbox__dimensions">Dimensions placeholder</p>
					<# } #>

					<# if ( 'yes' === settings.show_divider ) { #>
						<div class="gm-lightbox__divider"></div>
					<# } #>

					<a class="gm-lightbox__cta" href="{{ settings.cta_button_url.url }}">
						{{ settings.cta_button_text }}
					</a>

					<# if ( 'yes' === settings.show_navigation ) { #>
						<div class="gm-lightbox__navigation">
							<button class="gm-lightbox__nav-button gm-lightbox__nav-button--prev">
								{{ settings.prev_button_text }}
							</button>
							<button class="gm-lightbox__nav-button gm-lightbox__nav-button--next">
								{{ settings.next_button_text }}
							</button>
						</div>
					<# } #>
				</div>
			</div>
		</div>
		<?php
	}
}
