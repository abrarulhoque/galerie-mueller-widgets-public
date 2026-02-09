<?php
/**
 * Gallery Header Widget.
 *
 * Elementor widget that displays a dark header section with title and breadcrumb navigation.
 *
 * @since 1.0.0
 */

namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Gallery_Header_Widget class.
 */
class Gallery_Header_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'gm_gallery_header';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Gallery Header', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-header';
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
		return [ 'gallery', 'header', 'breadcrumb', 'navigation', 'galerie', 'titel' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'gm-gallery-header-style' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// =============================================
		// CONTENT TAB
		// =============================================

		// Content Section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'page_title',
			[
				'label'   => esc_html__( 'Page Title', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'GALERIE',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => [
					'h1'  => 'H1',
					'h2'  => 'H2',
					'h3'  => 'H3',
					'h4'  => 'H4',
					'h5'  => 'H5',
					'h6'  => 'H6',
					'div' => 'div',
					'p'   => 'p',
				],
			]
		);

		$this->add_control(
			'show_breadcrumb',
			[
				'label'        => esc_html__( 'Show Breadcrumb', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'home_text',
			[
				'label'     => esc_html__( 'Home Link Text', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => 'Startseite',
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'home_link',
			[
				'label'       => esc_html__( 'Home Link', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'default'     => [
					'url'         => '/',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'   => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'separator_text',
			[
				'label'     => esc_html__( 'Separator', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => '/',
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'current_text',
			[
				'label'     => esc_html__( 'Current Page Text', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => 'Galerie',
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'container_tag',
			[
				'label'   => esc_html__( 'Container HTML Tag', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'section',
				'options' => [
					'section' => 'section',
					'div'     => 'div',
					'header'  => 'header',
					'article' => 'article',
				],
			]
		);

		$this->end_controls_section();

		// =============================================
		// STYLE TAB
		// =============================================

		// Section Style
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Section', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Padding', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => 128,
					'right'    => 24,
					'bottom'   => 40,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Container Max Width', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'default'    => [
					'size' => 1280,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-header__container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Title Style
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
					'{{WRAPPER}} .gm-gallery-header__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .gm-gallery-header__title',
				'fields_options' => [
					'font_family' => [
						'default' => 'Playfair Display',
					],
					'font_size'   => [
						'default' => [
							'size' => 40,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'size' => 1.2,
							'unit' => 'em',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		// Breadcrumb Style
		$this->start_controls_section(
			'breadcrumb_style',
			[
				'label'     => esc_html__( 'Breadcrumb', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'breadcrumb_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-header__breadcrumb' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'breadcrumb_typography',
				'selector'       => '{{WRAPPER}} .gm-gallery-header__breadcrumb',
				'fields_options' => [
					'font_family' => [
						'default' => 'Inter',
					],
					'font_size'   => [
						'default' => [
							'size' => 12,
							'unit' => 'px',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
				],
			]
		);

		$this->end_controls_section();

		// Links Style
		$this->start_controls_section(
			'links_style',
			[
				'label'     => esc_html__( 'Links', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => esc_html__( 'Link Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-header__link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-header__link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'current_color',
			[
				'label'     => esc_html__( 'Current Page Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F5F3F0',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-header__current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label'     => esc_html__( 'Separator Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery-header__separator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'separator_spacing',
			[
				'label'      => esc_html__( 'Separator Spacing', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'size' => 8,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery-header__separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$container_tag = $settings['container_tag'] ?? 'section';
		$title_tag     = $settings['title_tag'] ?? 'h1';

		// Validate tags
		$allowed_container_tags = [ 'section', 'div', 'header', 'article' ];
		$allowed_title_tags     = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'p' ];

		if ( ! in_array( $container_tag, $allowed_container_tags, true ) ) {
			$container_tag = 'section';
		}
		if ( ! in_array( $title_tag, $allowed_title_tags, true ) ) {
			$title_tag = 'h1';
		}

		// Set up home link attributes
		if ( ! empty( $settings['home_link']['url'] ) ) {
			$this->add_link_attributes( 'home_link_attr', $settings['home_link'] );
			$this->add_render_attribute( 'home_link_attr', 'class', 'gm-gallery-header__link' );
		}
		?>
		<<?php echo esc_html( $container_tag ); ?> class="gm-gallery-header">
			<div class="gm-gallery-header__container">
				<div class="gm-gallery-header__flex">

					<<?php echo esc_html( $title_tag ); ?> class="gm-gallery-header__title">
						<?php echo esc_html( $settings['page_title'] ); ?>
					</<?php echo esc_html( $title_tag ); ?>>

					<?php if ( 'yes' === $settings['show_breadcrumb'] ) : ?>
						<nav class="gm-gallery-header__breadcrumb">
							<?php if ( ! empty( $settings['home_text'] ) && ! empty( $settings['home_link']['url'] ) ) : ?>
								<a <?php $this->print_render_attribute_string( 'home_link_attr' ); ?>>
									<?php echo esc_html( $settings['home_text'] ); ?>
								</a>
							<?php endif; ?>

							<?php if ( ! empty( $settings['separator_text'] ) ) : ?>
								<span class="gm-gallery-header__separator"><?php echo esc_html( $settings['separator_text'] ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $settings['current_text'] ) ) : ?>
								<span class="gm-gallery-header__current">
									<?php echo esc_html( $settings['current_text'] ); ?>
								</span>
							<?php endif; ?>
						</nav>
					<?php endif; ?>

				</div>
			</div>
		</<?php echo esc_html( $container_tag ); ?>>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<#
		var containerTag = settings.container_tag || 'section';
		var titleTag = settings.title_tag || 'h1';
		#>

		<{{{ containerTag }}} class="gm-gallery-header">
			<div class="gm-gallery-header__container">
				<div class="gm-gallery-header__flex">

					<{{{ titleTag }}} class="gm-gallery-header__title">
						{{{ settings.page_title }}}
					</{{{ titleTag }}}>

					<# if ( 'yes' === settings.show_breadcrumb ) { #>
						<nav class="gm-gallery-header__breadcrumb">
							<# if ( settings.home_text && settings.home_link.url ) { #>
								<a class="gm-gallery-header__link" href="{{ settings.home_link.url }}">
									{{{ settings.home_text }}}
								</a>
							<# } #>

							<# if ( settings.separator_text ) { #>
								<span class="gm-gallery-header__separator">{{{ settings.separator_text }}}</span>
							<# } #>

							<# if ( settings.current_text ) { #>
								<span class="gm-gallery-header__current">
									{{{ settings.current_text }}}
								</span>
							<# } #>
						</nav>
					<# } #>

				</div>
			</div>
		</{{{ containerTag }}}>
		<?php
	}
}
