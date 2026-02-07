<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

/**
 * Categories Widget
 *
 * Grid of category cards with images and hover effects.
 *
 * @since 1.0.0
 */
class Categories_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_categories';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Categories', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-gallery-grid';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'categories', 'grid', 'gallery', 'werkbereiche' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-categories-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-categories-script' ];
	}

	protected function register_controls(): void {
		$this->register_content_heading_controls();
		$this->register_content_items_controls();
		$this->register_style_section_controls();
		$this->register_style_heading_controls();
		$this->register_style_card_controls();
		$this->register_animation_controls();
	}

	private function register_content_heading_controls(): void {
		$this->start_controls_section(
			'content_heading',
			[
				'label' => esc_html__( 'Heading', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'   => esc_html__( 'Heading', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Werkbereiche',
			]
		);

		$this->add_control(
			'show_accent_bar',
			[
				'label'        => esc_html__( 'Show Accent Bar', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function register_content_items_controls(): void {
		$this->start_controls_section(
			'content_items',
			[
				'label' => esc_html__( 'Category Items', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'category_title',
			[
				'label'       => esc_html__( 'Title', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Malerei',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'category_description',
			[
				'label'   => esc_html__( 'Description', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '12 Werke',
			]
		);

		$repeater->add_control(
			'category_image',
			[
				'label'   => esc_html__( 'Image', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'category_link',
			[
				'label'   => esc_html__( 'Link', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::URL,
				'default' => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'categories',
			[
				'label'   => esc_html__( 'Categories', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[ 'category_title' => 'Malerei', 'category_description' => '12 Werke' ],
					[ 'category_title' => 'Zeichnung', 'category_description' => '8 Werke' ],
					[ 'category_title' => 'Skizzen', 'category_description' => '15 Werke' ],
				],
				'title_field' => '{{{ category_title }}}',
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
				'selectors' => [
					'{{WRAPPER}} .gm-categories' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .gm-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_columns',
			[
				'label'   => esc_html__( 'Columns', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-categories__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
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
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-categories__heading-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_bar_color',
			[
				'label'     => esc_html__( 'Accent Bar Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-categories__accent-bar' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_accent_bar' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_card_controls(): void {
		$this->start_controls_section(
			'style_card',
			[
				'label' => esc_html__( 'Card', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-categories__card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-categories__card-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_scale',
			[
				'label'   => esc_html__( 'Hover Zoom', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 1, 'max' => 1.3, 'step' => 0.01 ] ],
				'default' => [ 'size' => 1.03 ],
				'selectors' => [
					'{{WRAPPER}} .gm-categories__card-link:hover .gm-categories__image-wrapper img' => 'transform: scale({{SIZE}});',
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

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings   = $this->get_settings_for_display();
		$categories = $settings['categories'] ?? [];
		$anim_class = 'yes' === $settings['enable_animation'] ? 'gm-categories__container--hidden' : '';
		?>
		<section class="gm-categories">
			<div class="gm-categories__container <?php echo esc_attr( $anim_class ); ?>">

				<div class="gm-categories__heading">
					<?php if ( 'yes' === $settings['show_accent_bar'] ) : ?>
						<div class="gm-categories__accent-bar"></div>
					<?php endif; ?>
					<h2 class="gm-categories__heading-text"><?php echo esc_html( $settings['heading_text'] ); ?></h2>
				</div>

				<div class="gm-categories__grid">
					<?php foreach ( $categories as $item ) : ?>
						<a href="<?php echo esc_url( $item['category_link']['url'] ?? '#' ); ?>" class="gm-categories__card-link">
							<div class="gm-categories__card">
								<div class="gm-categories__image-wrapper">
									<?php if ( ! empty( $item['category_image']['url'] ) ) : ?>
										<img src="<?php echo esc_url( $item['category_image']['url'] ); ?>"
											 alt="<?php echo esc_attr( $item['category_title'] ); ?>" />
									<?php endif; ?>
								</div>
								<div class="gm-categories__card-content">
									<h3 class="gm-categories__card-title"><?php echo esc_html( $item['category_title'] ); ?></h3>
									<p class="gm-categories__card-description"><?php echo esc_html( $item['category_description'] ); ?></p>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
				</div>

			</div>
		</section>
		<?php
	}

	protected function content_template(): void {
		?>
		<#
		var animClass = ( 'yes' === settings.enable_animation ) ? 'gm-categories__container--hidden' : '';
		#>
		<section class="gm-categories">
			<div class="gm-categories__container {{ animClass }}">
				<div class="gm-categories__heading">
					<# if ( 'yes' === settings.show_accent_bar ) { #>
						<div class="gm-categories__accent-bar"></div>
					<# } #>
					<h2 class="gm-categories__heading-text">{{{ settings.heading_text }}}</h2>
				</div>
				<div class="gm-categories__grid">
					<# _.each( settings.categories, function( item ) { #>
						<a href="{{ item.category_link.url }}" class="gm-categories__card-link">
							<div class="gm-categories__card">
								<div class="gm-categories__image-wrapper">
									<# if ( item.category_image.url ) { #>
										<img src="{{ item.category_image.url }}" alt="{{ item.category_title }}" />
									<# } #>
								</div>
								<div class="gm-categories__card-content">
									<h3 class="gm-categories__card-title">{{{ item.category_title }}}</h3>
									<p class="gm-categories__card-description">{{{ item.category_description }}}</p>
								</div>
							</div>
						</a>
					<# }); #>
				</div>
			</div>
		</section>
		<?php
	}
}
