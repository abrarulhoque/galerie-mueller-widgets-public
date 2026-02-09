<?php
/**
 * Category Tabs Widget.
 *
 * Elementor widget that displays category filter tabs for the gallery.
 *
 * @since 1.0.0
 */

namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Category_Tabs_Widget class.
 */
class Category_Tabs_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'gm_category_tabs';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Category Tabs', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-tabs';
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
		return [ 'category', 'tabs', 'navigation', 'filter', 'gallery', 'galerie' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends(): array {
		return [ 'gm-category-tabs-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends(): array {
		return [ 'gm-category-tabs-script' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// =============================================
		// CONTENT TAB
		// =============================================

		// Tabs Content Section
		$this->start_controls_section(
			'tabs_content_section',
			[
				'label' => esc_html__( 'Tabs Content', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_label',
			[
				'label'       => esc_html__( 'Tab Label', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Category', 'galerie-mueller-widgets' ),
				'placeholder' => esc_html__( 'Enter tab label', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_value',
			[
				'label'       => esc_html__( 'URL Parameter Value', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. malerei', 'galerie-mueller-widgets' ),
				'description' => esc_html__( 'Leave empty for "All" tab', 'galerie-mueller-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_url',
			[
				'label'       => esc_html__( 'Custom URL (Optional)', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'default'     => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'description' => esc_html__( 'Override auto-generated URL', 'galerie-mueller-widgets' ),
			]
		);

		$repeater->add_control(
			'tab_icon',
			[
				'label'   => esc_html__( 'Icon', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => '',
					'library' => '',
				],
			]
		);

		$this->add_control(
			'category_tabs',
			[
				'label'       => esc_html__( 'Category Tabs', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'tab_label' => 'ALLE',
						'tab_value' => '',
						'tab_url'   => [ 'url' => '' ],
						'tab_icon'  => [ 'value' => '' ],
					],
					[
						'tab_label' => 'MALEREI',
						'tab_value' => 'malerei',
						'tab_url'   => [ 'url' => '' ],
						'tab_icon'  => [ 'value' => '' ],
					],
					[
						'tab_label' => 'ZEICHNUNG',
						'tab_value' => 'zeichnung',
						'tab_url'   => [ 'url' => '' ],
						'tab_icon'  => [ 'value' => '' ],
					],
					[
						'tab_label' => 'SKIZZEN',
						'tab_value' => 'skizzen',
						'tab_url'   => [ 'url' => '' ],
						'tab_icon'  => [ 'value' => '' ],
					],
				],
				'title_field' => '{{{ tab_label }}}',
			]
		);

		$this->add_control(
			'base_url',
			[
				'label'       => esc_html__( 'Base Gallery URL', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'default'     => [
					'url'         => '/galerie',
					'is_external' => false,
					'nofollow'    => false,
				],
				'options'     => [ 'url' ],
				'description' => esc_html__( 'The base URL for the gallery page', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'url_parameter_name',
			[
				'label'       => esc_html__( 'URL Parameter Name', 'galerie-mueller-widgets' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'kategorie',
				'description' => esc_html__( 'Name of the URL parameter for category filtering', 'galerie-mueller-widgets' ),
			]
		);

		$this->end_controls_section();

		// Layout Section
		$this->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__( 'Layout', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'tabs_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
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
				'default' => 'center',
			]
		);

		$this->add_responsive_control(
			'tabs_gap',
			[
				'label'      => esc_html__( 'Gap Between Tabs', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
					'{{WRAPPER}} .gm-category-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_as_buttons',
			[
				'label'        => esc_html__( 'Show as Buttons', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'galerie-mueller-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => esc_html__( 'Before Text', 'galerie-mueller-widgets' ),
					'after'  => esc_html__( 'After Text', 'galerie-mueller-widgets' ),
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
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs' => 'background-color: {{VALUE}};',
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
					'top'      => 40,
					'right'    => 0,
					'bottom'   => 40,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-category-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gm-category-tabs__container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Tab Style
		$this->start_controls_section(
			'tab_style',
			[
				'label' => esc_html__( 'Tab', 'galerie-mueller-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'tab_typography',
				'selector'       => '{{WRAPPER}} .gm-category-tabs__tab',
				'fields_options' => [
					'font_family'    => [
						'default' => 'Inter',
					],
					'font_size'      => [
						'default' => [
							'size' => 13,
							'unit' => 'px',
						],
					],
					'font_weight'    => [
						'default' => '400',
					],
					'text_transform' => [
						'default' => 'uppercase',
					],
					'letter_spacing' => [
						'default' => [
							'size' => 0.2,
							'unit' => 'em',
						],
					],
				],
			]
		);

		$this->add_control(
			'tab_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_text_color_hover',
			[
				'label'     => esc_html__( 'Text Hover Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_text_color_active',
			[
				'label'     => esc_html__( 'Active Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab--active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Active Indicator Style
		$this->start_controls_section(
			'active_indicator_style',
			[
				'label'     => esc_html__( 'Active Indicator', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_as_buttons!' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_active_indicator',
			[
				'label'        => esc_html__( 'Show Indicator', 'galerie-mueller-widgets' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'No', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'indicator_color',
			[
				'label'     => esc_html__( 'Indicator Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab--active::after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_active_indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'indicator_height',
			[
				'label'      => esc_html__( 'Indicator Height', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 2,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-category-tabs__tab--active::after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_active_indicator' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Button Style
		$this->start_controls_section(
			'button_style',
			[
				'label'     => esc_html__( 'Button Style', 'galerie-mueller-widgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_as_buttons' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 12,
					'right'    => 24,
					'bottom'   => 12,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-category-tabs__tab--button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'galerie-mueller-widgets' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 4,
					'right'    => 4,
					'bottom'   => 4,
					'left'     => 4,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-category-tabs__tab--button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab--button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label'     => esc_html__( 'Hover Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab--button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_active',
			[
				'label'     => esc_html__( 'Active Background Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab--button.gm-category-tabs__tab--active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color_active',
			[
				'label'     => esc_html__( 'Active Text Color', 'galerie-mueller-widgets' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-category-tabs__tab--button.gm-category-tabs__tab--active' => 'color: {{VALUE}};',
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

		$base_url   = $settings['base_url']['url'] ?? '/galerie';
		$param_name = $settings['url_parameter_name'] ?? 'kategorie';

		// Build wrapper attributes
		$this->add_render_attribute( 'wrapper', [
			'class'           => 'gm-category-tabs',
			'data-base-url'   => esc_attr( $base_url ),
			'data-param-name' => esc_attr( $param_name ),
		] );

		// Navigation classes
		$nav_classes   = [ 'gm-category-tabs__nav' ];
		$alignment     = $settings['tabs_alignment'] ?? 'center';
		$nav_classes[] = 'gm-category-tabs__nav--' . $alignment;

		$this->add_render_attribute( 'nav', [
			'class'      => implode( ' ', $nav_classes ),
			'role'       => 'tablist',
			'aria-label' => esc_attr__( 'Category filters', 'galerie-mueller-widgets' ),
		] );

		// Get current category from URL for active state
		$current_category = isset( $_GET[ $param_name ] ) ? sanitize_text_field( wp_unslash( $_GET[ $param_name ] ) ) : null;
		?>
		<section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="gm-category-tabs__container">
				<nav <?php $this->print_render_attribute_string( 'nav' ); ?>>
					<?php foreach ( $settings['category_tabs'] as $index => $tab ) : ?>
						<?php
						$tab_value = $tab['tab_value'] ?? '';
						$is_active = ( $tab_value === $current_category ) || ( empty( $tab_value ) && empty( $current_category ) );

						// Build tab classes
						$tab_classes = [ 'gm-category-tabs__tab' ];
						if ( 'yes' === $settings['show_as_buttons'] ) {
							$tab_classes[] = 'gm-category-tabs__tab--button';
						}
						if ( $is_active ) {
							$tab_classes[] = 'gm-category-tabs__tab--active';
						}

						// Build URL
						if ( ! empty( $tab['tab_url']['url'] ) ) {
							$tab_href = $tab['tab_url']['url'];
						} else {
							$tab_href = empty( $tab_value ) ? $base_url : $base_url . '?' . $param_name . '=' . rawurlencode( $tab_value );
						}

						// Tab attributes
						$tab_key = 'tab_' . $index;
						$this->add_render_attribute( $tab_key, [
							'class'          => implode( ' ', $tab_classes ),
							'href'           => esc_url( $tab_href ),
							'data-tab-value' => esc_attr( $tab_value ),
							'role'           => 'tab',
							'aria-current'   => $is_active ? 'page' : 'false',
							'tabindex'       => '0',
						], null, true );

						if ( ! empty( $tab['tab_url']['url'] ) ) {
							$this->add_render_attribute( $tab_key, 'data-custom-url', esc_attr( $tab['tab_url']['url'] ) );
						}

						$icon_position = $settings['icon_position'] ?? 'before';
						?>
						<a <?php $this->print_render_attribute_string( $tab_key ); ?>>
							<?php if ( ! empty( $tab['tab_icon']['value'] ) && 'before' === $icon_position ) : ?>
								<span class="gm-category-tabs__icon gm-category-tabs__icon--before">
									<?php \Elementor\Icons_Manager::render_icon( $tab['tab_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<span class="gm-category-tabs__tab-text">
								<?php echo esc_html( $tab['tab_label'] ); ?>
							</span>

							<?php if ( ! empty( $tab['tab_icon']['value'] ) && 'after' === $icon_position ) : ?>
								<span class="gm-category-tabs__icon gm-category-tabs__icon--after">
									<?php \Elementor\Icons_Manager::render_icon( $tab['tab_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</nav>
			</div>
		</section>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<#
		var baseUrl = settings.base_url.url || '/galerie';
		var paramName = settings.url_parameter_name || 'kategorie';

		var navClasses = 'gm-category-tabs__nav';
		var alignment = settings.tabs_alignment || 'center';
		navClasses += ' gm-category-tabs__nav--' + alignment;

		var iconPosition = settings.icon_position || 'before';
		#>
		<section class="gm-category-tabs" data-base-url="{{ baseUrl }}" data-param-name="{{ paramName }}">
			<div class="gm-category-tabs__container">
				<nav class="{{ navClasses }}" role="tablist" aria-label="Category filters">
					<# _.each(settings.category_tabs, function(tab, index) {
						var tabValue = tab.tab_value || '';
						var isActive = index === 0;

						var tabClasses = 'gm-category-tabs__tab';
						if ('yes' === settings.show_as_buttons) {
							tabClasses += ' gm-category-tabs__tab--button';
						}
						if (isActive) {
							tabClasses += ' gm-category-tabs__tab--active';
						}

						var tabHref = '#';
						if (tab.tab_url && tab.tab_url.url) {
							tabHref = tab.tab_url.url;
						} else {
							tabHref = tabValue ? baseUrl + '?' + paramName + '=' + encodeURIComponent(tabValue) : baseUrl;
						}
					#>
						<a class="{{ tabClasses }}"
						   href="{{ tabHref }}"
						   data-tab-value="{{ tabValue }}"
						   role="tab"
						   aria-current="{{ isActive ? 'page' : 'false' }}"
						   tabindex="0">

							<# if (tab.tab_icon && tab.tab_icon.value && 'before' === iconPosition) {
								var iconHTML = elementor.helpers.renderIcon(view, tab.tab_icon, { 'aria-hidden': 'true' }, 'i', 'object');
							#>
								<span class="gm-category-tabs__icon gm-category-tabs__icon--before">
									{{{ iconHTML.value }}}
								</span>
							<# } #>

							<span class="gm-category-tabs__tab-text">
								{{{ tab.tab_label }}}
							</span>

							<# if (tab.tab_icon && tab.tab_icon.value && 'after' === iconPosition) {
								var iconHTMLAfter = elementor.helpers.renderIcon(view, tab.tab_icon, { 'aria-hidden': 'true' }, 'i', 'object');
							#>
								<span class="gm-category-tabs__icon gm-category-tabs__icon--after">
									{{{ iconHTMLAfter.value }}}
								</span>
							<# } #>
						</a>
					<# }); #>
				</nav>
			</div>
		</section>
		<?php
	}
}
