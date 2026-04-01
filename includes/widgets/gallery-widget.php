<?php
namespace Galerie_Mueller_Widgets\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Gallery Widget
 *
 * Unified gallery widget combining category tabs, artwork grid,
 * and lightbox into a single Elementor widget. Tab filtering,
 * lightbox navigation, keyboard nav, and fade-up animation all
 * handled via vanilla JS.
 *
 * @since 1.0.0
 */
class Gallery_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_name(): string {
		return 'gm_gallery';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Galerie', 'galerie-mueller-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'gallery', 'galerie', 'grid', 'lightbox', 'artworks', 'filter', 'tabs' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_style_depends(): array {
		return [ 'gm-gallery-style' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_script_depends(): array {
		return [ 'gm-gallery-script' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 1.0.0
	 */
	protected function register_controls(): void {

		/* ==================================================================
		 * TAB_CONTENT
		 * ================================================================== */

		// --- Section 1: Filterkategorien ---
		$this->start_controls_section(
			'content_filters_section',
			[
				'label' => esc_html__( 'Filterkategorien', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_filters',
			[
				'label'        => esc_html__( 'Filter anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'all_tab_label',
			[
				'label'       => esc_html__( '"Alle"-Tab Bezeichnung', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ALLE', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. ALLE', 'galerie-mueller' ),
				'label_block' => true,
				'condition'   => [ 'show_filters' => 'yes' ],
			]
		);

		$filter_repeater = new \Elementor\Repeater();

		$filter_repeater->add_control(
			'filter_label',
			[
				'label'       => esc_html__( 'Bezeichnung', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Kategorie', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. MALEREI', 'galerie-mueller' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$filter_repeater->add_control(
			'filter_slug',
			[
				'label'       => esc_html__( 'Slug (URL-Kennung)', 'galerie-mueller' ),
				'description' => esc_html__( 'Muss mit der Kategorie der Kunstwerke übereinstimmen', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'kategorie', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. malerei', 'galerie-mueller' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'filters',
			[
				'label'       => esc_html__( 'Filterkategorien', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $filter_repeater->get_controls(),
				'default'     => [
					[
						'filter_label' => esc_html__( 'LANDSCHAFTEN', 'galerie-mueller' ),
						'filter_slug'  => 'landschaften',
					],
					[
						'filter_label' => esc_html__( 'PORTRÄTS', 'galerie-mueller' ),
						'filter_slug'  => 'portraets',
					],
					[
						'filter_label' => esc_html__( 'STILLLEBEN', 'galerie-mueller' ),
						'filter_slug'  => 'stillleben',
					],
					[
						'filter_label' => esc_html__( 'ABSTRAKT', 'galerie-mueller' ),
						'filter_slug'  => 'abstrakt',
					],
					[
						'filter_label' => esc_html__( 'ARCHITEKTUR', 'galerie-mueller' ),
						'filter_slug'  => 'architektur',
					],
					[
						'filter_label' => esc_html__( 'NATUR', 'galerie-mueller' ),
						'filter_slug'  => 'natur',
					],
					[
						'filter_label' => esc_html__( 'FIGÜRLICH', 'galerie-mueller' ),
						'filter_slug'  => 'figuerlich',
					],
					[
						'filter_label' => esc_html__( 'STADTANSICHTEN', 'galerie-mueller' ),
						'filter_slug'  => 'stadtansichten',
					],
					[
						'filter_label' => esc_html__( 'MARITIM', 'galerie-mueller' ),
						'filter_slug'  => 'maritim',
					],
					[
						'filter_label' => esc_html__( 'EXPRESSIV', 'galerie-mueller' ),
						'filter_slug'  => 'expressiv',
					],
				],
				'title_field' => '{{{ filter_label }}}',
				'condition'   => [ 'show_filters' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// --- Section 2: Kunstwerke (Repeater) ---
		$this->start_controls_section(
			'content_artworks_section',
			[
				'label' => esc_html__( 'Kunstwerke', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$artwork_repeater = new \Elementor\Repeater();

		$artwork_repeater->add_control(
			'artwork_image',
			[
				'label'   => esc_html__( 'Bild', 'galerie-mueller' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [ 'active' => true ],
			]
		);

		$artwork_repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'    => 'artwork_image_size',
				'default' => 'large',
				'exclude' => [ 'custom' ],
			]
		);

		$artwork_repeater->add_control(
			'artwork_title',
			[
				'label'       => esc_html__( 'Titel', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Kunstwerk Titel', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. Komposition in Blau', 'galerie-mueller' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$artwork_repeater->add_control(
			'artwork_medium',
			[
				'label'       => esc_html__( 'Technik', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Öl auf Leinwand', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. Öl auf Leinwand', 'galerie-mueller' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$artwork_repeater->add_control(
			'artwork_year',
			[
				'label'   => esc_html__( 'Jahr', 'galerie-mueller' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 2024,
				'min'     => 1900,
				'max'     => 2100,
				'step'    => 1,
				'dynamic' => [ 'active' => true ],
			]
		);

		$artwork_repeater->add_control(
			'artwork_dimensions',
			[
				'label'       => esc_html__( 'Maße', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'z.B. 80 x 60 cm', 'galerie-mueller' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$artwork_repeater->add_control(
			'artwork_category',
			[
				'label'       => esc_html__( 'Kategorie-Slug', 'galerie-mueller' ),
				'description' => esc_html__( 'Muss exakt mit dem Slug einer Filterkategorie übereinstimmen', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'landschaften',
				'placeholder' => esc_html__( 'z.B. landschaften', 'galerie-mueller' ),
				'label_block' => false,
			]
		);

		$this->add_control(
			'artworks',
			[
				'label'       => esc_html__( 'Kunstwerke', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $artwork_repeater->get_controls(),
				'default'     => [
					[
						'artwork_title'      => esc_html__( 'Komposition in Blau', 'galerie-mueller' ),
						'artwork_medium'     => esc_html__( 'Öl auf Leinwand', 'galerie-mueller' ),
						'artwork_year'       => 2023,
						'artwork_dimensions' => '80 x 60 cm',
						'artwork_category'   => 'landschaften',
					],
					[
						'artwork_title'      => esc_html__( 'Stadtskizze III', 'galerie-mueller' ),
						'artwork_medium'     => esc_html__( 'Bleistift auf Papier', 'galerie-mueller' ),
						'artwork_year'       => 2022,
						'artwork_dimensions' => '30 x 40 cm',
						'artwork_category'   => 'stadtansichten',
					],
					[
						'artwork_title'      => esc_html__( 'Tagesnotiz 47', 'galerie-mueller' ),
						'artwork_medium'     => esc_html__( 'Kohle auf Papier', 'galerie-mueller' ),
						'artwork_year'       => 2024,
						'artwork_dimensions' => '21 x 15 cm',
						'artwork_category'   => 'abstrakt',
					],
				],
				'title_field' => '{{{ artwork_title }}} ({{{ artwork_category }}})',
			]
		);

		$this->end_controls_section();

		// --- Section 3: Rasterlayout ---
		$this->start_controls_section(
			'content_layout_section',
			[
				'label' => esc_html__( 'Rasterlayout', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'grid_columns',
			[
				'label'          => esc_html__( 'Spaltenanzahl', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .gm-gallery__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'card_aspect_ratio',
			[
				'label'     => esc_html__( 'Seitenverhältnis', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'4/5'    => '4:5 (Hochformat)',
					'1/1'    => '1:1 (Quadrat)',
					'3/2'    => '3:2 (Querformat)',
					'16/9'   => '16:9 (Breitbild)',
					'3/4'    => '3:4 (Hochformat schmal)',
					'custom' => 'Benutzerdefiniert',
				],
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-image-wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_custom_aspect_w',
			[
				'label'     => esc_html__( 'Breite (benutzerdefiniert)', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 100,
				'condition' => [ 'card_aspect_ratio' => 'custom' ],
			]
		);

		$this->add_control(
			'card_custom_aspect_h',
			[
				'label'     => esc_html__( 'Höhe (benutzerdefiniert)', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 1,
				'max'       => 100,
				'condition' => [ 'card_aspect_ratio' => 'custom' ],
			]
		);

		$this->add_control(
			'show_hover_overlay',
			[
				'label'        => esc_html__( 'Hover-Overlay anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'hover_overlay_text',
			[
				'label'       => esc_html__( 'Overlay-Text', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Werk ansehen', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. Werk ansehen', 'galerie-mueller' ),
				'label_block' => true,
				'condition'   => [ 'show_hover_overlay' => 'yes' ],
			]
		);

		$this->add_control(
			'show_dimensions',
			[
				'label'        => esc_html__( 'Maße anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'empty_message',
			[
				'label'       => esc_html__( 'Leer-Nachricht', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Noch keine Werke in dieser Kategorie.', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'Nachricht bei leerer Kategorie', 'galerie-mueller' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// --- Section 4: Lightbox ---
		$this->start_controls_section(
			'content_lightbox_section',
			[
				'label' => esc_html__( 'Lightbox', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label'        => esc_html__( 'Lightbox aktivieren', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'lightbox_cta_text',
			[
				'label'       => esc_html__( 'CTA-Text', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Anfrage stellen', 'galerie-mueller' ),
				'placeholder' => esc_html__( 'z.B. Anfrage stellen', 'galerie-mueller' ),
				'label_block' => true,
				'condition'   => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'lightbox_cta_url',
			[
				'label'         => esc_html__( 'CTA-Link', 'galerie-mueller' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'default'       => [
					'url'         => '/kontakt',
					'is_external' => false,
					'nofollow'    => false,
				],
				'placeholder'   => esc_html__( '/kontakt', 'galerie-mueller' ),
				'show_external' => true,
				'condition'     => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'enable_url_params',
			[
				'label'        => esc_html__( 'Werk-Parameter anhängen', 'galerie-mueller' ),
				'description'  => esc_html__( 'Fügt ?werk=Titel an die CTA-URL an', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'show_lightbox_nav',
			[
				'label'        => esc_html__( 'Navigation anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'prev_text',
			[
				'label'       => esc_html__( '"Vorheriges"-Text', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( "\u{2190} Vorheriges", 'galerie-mueller' ),
				'label_block' => false,
				'condition'   => [
					'enable_lightbox'  => 'yes',
					'show_lightbox_nav' => 'yes',
				],
			]
		);

		$this->add_control(
			'next_text',
			[
				'label'       => esc_html__( "N\u{00E4}chstes \u{2192}", 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( "N\u{00E4}chstes \u{2192}", 'galerie-mueller' ),
				'label_block' => false,
				'condition'   => [
					'enable_lightbox'  => 'yes',
					'show_lightbox_nav' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_keyboard_nav',
			[
				'label'        => esc_html__( 'Tastaturnavigation', 'galerie-mueller' ),
				'description'  => esc_html__( 'Pfeiltasten und Escape in der Lightbox', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'enable_click_outside_close',
			[
				'label'        => esc_html__( 'Klick außerhalb schließt', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'show_lightbox_dimensions',
			[
				'label'        => esc_html__( 'Maße in Lightbox anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'show_lightbox_divider',
			[
				'label'        => esc_html__( 'Trennlinie anzeigen', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// --- Section 5: Animation ---
		$this->start_controls_section(
			'content_animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Eingangsanimation', 'galerie-mueller' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label'     => esc_html__( 'Animationsdauer', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 100,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 600,
				],
				'condition' => [ 'enable_fade_up' => 'yes' ],
			]
		);

		$this->add_control(
			'animation_distance',
			[
				'label'      => esc_html__( 'Versatz (translateY)', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'condition'  => [ 'enable_fade_up' => 'yes' ],
			]
		);

		$this->add_control(
			'stagger_delay',
			[
				'label'       => esc_html__( 'Staffelung pro Spalte', 'galerie-mueller' ),
				'description' => esc_html__( 'Verzögerung zwischen Karten je Spalte (ms)', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 10,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 100,
				],
				'condition'   => [ 'enable_fade_up' => 'yes' ],
			]
		);

		$this->add_control(
			'animation_threshold',
			[
				'label'       => esc_html__( 'Sichtbarkeits-Schwelle', 'galerie-mueller' ),
				'description' => esc_html__( 'Anteil des Elements, der sichtbar sein muss (0 = sofort, 1 = vollständig)', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default'     => [
					'size' => 0.15,
				],
				'condition'   => [ 'enable_fade_up' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==================================================================
		 * TAB_STYLE
		 * ================================================================== */

		// --- Section 6: Filter-Tabs ---
		$this->start_controls_section(
			'style_tabs_section',
			[
				'label'     => esc_html__( 'Filter-Tabs', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_filters' => 'yes' ],
			]
		);

		$this->add_control(
			'tabs_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__tabs' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => 40,
					'right'    => 0,
					'bottom'   => 40,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_max_width',
			[
				'label'      => esc_html__( 'Container Max-Breite', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1600, 'step' => 10 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1152 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__tabs-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => 0, 'right' => 24, 'bottom' => 0, 'left' => 24,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__tabs-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_typography',
				'selector' => '{{WRAPPER}} .gm-gallery__tab',
			]
		);

		$this->add_responsive_control(
			'tab_gap',
			[
				'label'      => esc_html__( 'Tab-Abstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80, 'step' => 2 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__tabs-nav' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label'     => esc_html__( 'Aktive Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__tab--active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_inactive_color',
			[
				'label'     => esc_html__( 'Inaktive Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__tab' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_hover_color',
			[
				'label'     => esc_html__( 'Hover-Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__tab:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_underline_height',
			[
				'label'      => esc_html__( 'Unterstrich Höhe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 8, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__tab--active::after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_underline_color',
			[
				'label'     => esc_html__( 'Unterstrich Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__tab--active::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_padding_bottom',
			[
				'label'      => esc_html__( 'Tab Innenabstand unten', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__tab' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 7: Raster ---
		$this->start_controls_section(
			'style_grid_section',
			[
				'label' => esc_html__( 'Raster', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'grid_section_padding',
			[
				'label'      => esc_html__( 'Bereich Innenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top' => 0, 'right' => 0, 'bottom' => 40, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__grid-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_container_max_width',
			[
				'label'      => esc_html__( 'Container Max-Breite', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1600, 'step' => 10 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1152 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__grid-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => 0, 'right' => 24, 'bottom' => 0, 'left' => 24,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__grid-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_column_gap',
			[
				'label'      => esc_html__( 'Spaltenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80, 'step' => 2 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_row_gap',
			[
				'label'      => esc_html__( 'Zeilenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120, 'step' => 2 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 40 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'empty_typography',
				'label'    => esc_html__( 'Leer-Nachricht Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__empty',
			]
		);

		$this->add_control(
			'empty_color',
			[
				'label'     => esc_html__( 'Leer-Nachricht Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__empty' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 8: Karten ---
		$this->start_controls_section(
			'style_card_section',
			[
				'label' => esc_html__( 'Karten', 'galerie-mueller' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_image_bg_color',
			[
				'label'     => esc_html__( 'Bild-Platzhalter Hintergrund', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-image-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_image_border_radius',
			[
				'label'      => esc_html__( 'Bild Rahmenradius', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0,
					'unit' => 'px', 'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__card-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_hover_scale',
			[
				'label'     => esc_html__( 'Hover Skalierung', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 1, 'max' => 1.5, 'step' => 0.01 ] ],
				'default'   => [ 'size' => 1.03 ],
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-inner:hover .gm-gallery__card-image' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->add_control(
			'card_overlay_bg_color',
			[
				'label'     => esc_html__( 'Overlay Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.2)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-inner:hover .gm-gallery__card-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_hover_overlay' => 'yes' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'card_overlay_text_typography',
				'label'     => esc_html__( 'Overlay-Text Typografie', 'galerie-mueller' ),
				'selector'  => '{{WRAPPER}} .gm-gallery__card-overlay-text',
				'condition' => [ 'show_hover_overlay' => 'yes' ],
			]
		);

		$this->add_control(
			'card_overlay_text_color',
			[
				'label'     => esc_html__( 'Overlay-Text Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-overlay-text' => 'color: {{VALUE}};',
				],
				'condition' => [ 'show_hover_overlay' => 'yes' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'label'    => esc_html__( 'Titel Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__card-title',
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label'     => esc_html__( 'Titel Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_title_margin_top',
			[
				'label'      => esc_html__( 'Titel Abstand oben', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__card-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'card_meta_typography',
				'label'    => esc_html__( 'Meta Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__card-meta',
			]
		);

		$this->add_control(
			'card_meta_color',
			[
				'label'     => esc_html__( 'Meta Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_meta_margin_top',
			[
				'label'      => esc_html__( 'Meta Abstand oben', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__card-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'card_dimensions_typography',
				'label'    => esc_html__( 'Maße Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__card-dimensions',
			]
		);

		$this->add_control(
			'card_dimensions_color',
			[
				'label'     => esc_html__( 'Maße Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(107,107,107,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__card-dimensions' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_dimensions_margin_top',
			[
				'label'      => esc_html__( 'Maße Abstand oben', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 20, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__card-dimensions' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 9: Lightbox Overlay ---
		$this->start_controls_section(
			'style_lightbox_overlay_section',
			[
				'label'     => esc_html__( 'Lightbox Overlay', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'lightbox_overlay_bg_color',
			[
				'label'     => esc_html__( 'Overlay Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.8)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_backdrop_blur',
			[
				'label'      => esc_html__( 'Hintergrund-Unschärfe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-overlay' => '-webkit-backdrop-filter: blur({{SIZE}}{{UNIT}}); backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'lightbox_close_color',
			[
				'label'     => esc_html__( 'Schließen-Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-close' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_close_hover_color',
			[
				'label'     => esc_html__( 'Schließen Hover-Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-close:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_close_size',
			[
				'label'      => esc_html__( 'Schließen-Größe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 48, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_close_top',
			[
				'label'      => esc_html__( 'Schließen Position oben', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-close' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_close_right',
			[
				'label'      => esc_html__( 'Schließen Position rechts', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-close' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 10: Lightbox Modal ---
		$this->start_controls_section(
			'style_lightbox_modal_section',
			[
				'label'     => esc_html__( 'Lightbox Modal', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_control(
			'lightbox_modal_bg_color',
			[
				'label'     => esc_html__( 'Modal Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-modal' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_modal_border_radius',
			[
				'label'      => esc_html__( 'Modal Rahmenradius', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-modal' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_modal_max_width',
			[
				'label'      => esc_html__( 'Modal Max-Breite', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600, 'step' => 10 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1024 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-modal' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lightbox_wrapper_padding',
			[
				'label'          => esc_html__( 'Wrapper Padding', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', 'em' ],
				'default'        => [
					'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32,
					'unit' => 'px', 'isLinked' => true,
				],
				'tablet_default' => [
					'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24,
					'unit' => 'px', 'isLinked' => true,
				],
				'mobile_default' => [
					'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16,
					'unit' => 'px', 'isLinked' => true,
				],
				'selectors'      => [
					'{{WRAPPER}} .gm-gallery__lightbox-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_image_area_bg',
			[
				'label'     => esc_html__( 'Bildbereich Hintergrund', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-image-area' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'lightbox_image_area_min_height',
			[
				'label'          => esc_html__( 'Bildbereich Min-Höhe', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'vh' ],
				'range'          => [
					'px' => [ 'min' => 100, 'max' => 800, 'step' => 10 ],
					'vh' => [ 'min' => 10, 'max' => 80, 'step' => 1 ],
				],
				'default'        => [ 'unit' => 'px', 'size' => 500 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 300 ],
				'selectors'      => [
					'{{WRAPPER}} .gm-gallery__lightbox-image-area' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_grid_columns',
			[
				'label'       => esc_html__( 'Spalten-Verhältnis', 'galerie-mueller' ),
				'description' => esc_html__( 'CSS grid-template-columns Wert (Desktop)', 'galerie-mueller' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '1.5fr 1fr',
				'placeholder' => '1.5fr 1fr',
				'label_block' => true,
				'selectors'   => [
					'{{WRAPPER}} .gm-gallery__lightbox-grid' => 'grid-template-columns: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 11: Lightbox Info ---
		$this->start_controls_section(
			'style_lightbox_info_section',
			[
				'label'     => esc_html__( 'Lightbox Info', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'lightbox_info_padding',
			[
				'label'          => esc_html__( 'Info-Bereich Padding', 'galerie-mueller' ),
				'type'           => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', 'em' ],
				'default'        => [
					'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32,
					'unit' => 'px', 'isLinked' => true,
				],
				'mobile_default' => [
					'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24,
					'unit' => 'px', 'isLinked' => true,
				],
				'selectors'      => [
					'{{WRAPPER}} .gm-gallery__lightbox-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'lightbox_title_typography',
				'label'    => esc_html__( 'Titel Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__lightbox-title',
			]
		);

		$this->add_control(
			'lightbox_title_color',
			[
				'label'     => esc_html__( 'Titel Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#F5F3F0',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_title_spacing',
			[
				'label'      => esc_html__( 'Titel Abstand unten', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'lightbox_medium_typography',
				'label'    => esc_html__( 'Technik Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__lightbox-medium',
			]
		);

		$this->add_control(
			'lightbox_medium_color',
			[
				'label'     => esc_html__( 'Technik Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-medium' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'lightbox_year_typography',
				'label'    => esc_html__( 'Jahr Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__lightbox-year',
			]
		);

		$this->add_control(
			'lightbox_year_color',
			[
				'label'     => esc_html__( 'Jahr Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-year' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'lightbox_dimensions_typography',
				'label'    => esc_html__( 'Maße Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__lightbox-dimensions',
			]
		);

		$this->add_control(
			'lightbox_dimensions_color',
			[
				'label'     => esc_html__( 'Maße Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.5)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-dimensions' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_dimensions_spacing',
			[
				'label'      => esc_html__( 'Maße Abstand oben', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-dimensions' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_divider_color',
			[
				'label'     => esc_html__( 'Trennlinie Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.1)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-divider' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_divider_height',
			[
				'label'      => esc_html__( 'Trennlinie Höhe', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 5, 'step' => 1 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-divider' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_divider_margin',
			[
				'label'      => esc_html__( 'Trennlinie Abstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => 24, 'right' => 0, 'bottom' => 24, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 12: Lightbox CTA-Button ---
		$this->start_controls_section(
			'style_lightbox_cta_section',
			[
				'label'     => esc_html__( 'Lightbox CTA-Button', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_lightbox' => 'yes' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'lightbox_cta_typography',
				'label'    => esc_html__( 'CTA Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__lightbox-cta',
			]
		);

		$this->start_controls_tabs( 'lightbox_cta_style_tabs' );

		// --- Normal Tab ---
		$this->start_controls_tab(
			'lightbox_cta_normal_tab',
			[ 'label' => esc_html__( 'Normal', 'galerie-mueller' ) ]
		);

		$this->add_control(
			'lightbox_cta_text_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-cta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_cta_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// --- Hover Tab ---
		$this->start_controls_tab(
			'lightbox_cta_hover_tab',
			[ 'label' => esc_html__( 'Hover', 'galerie-mueller' ) ]
		);

		$this->add_control(
			'lightbox_cta_text_color_hover',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-cta:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_cta_bg_color_hover',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-cta:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_cta_border_color_hover',
			[
				'label'     => esc_html__( 'Rahmenfarbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.2)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-cta:hover' => 'outline: 1px solid {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'lightbox_cta_padding',
			[
				'label'      => esc_html__( 'CTA Innenabstand', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top' => 16, 'right' => 40, 'bottom' => 16, 'left' => 40,
					'unit' => 'px', 'isLinked' => false,
				],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// --- Section 13: Lightbox Navigation ---
		$this->start_controls_section(
			'style_lightbox_nav_section',
			[
				'label'     => esc_html__( 'Lightbox Navigation', 'galerie-mueller' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_lightbox'  => 'yes',
					'show_lightbox_nav' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'lightbox_nav_typography',
				'label'    => esc_html__( 'Nav Typografie', 'galerie-mueller' ),
				'selector' => '{{WRAPPER}} .gm-gallery__lightbox-prev, {{WRAPPER}} .gm-gallery__lightbox-next',
			]
		);

		$this->add_control(
			'lightbox_nav_color',
			[
				'label'     => esc_html__( 'Nav Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.4)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-prev, {{WRAPPER}} .gm-gallery__lightbox-next' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_nav_hover_color',
			[
				'label'     => esc_html__( 'Nav Hover-Farbe', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.6)',
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-prev:hover, {{WRAPPER}} .gm-gallery__lightbox-next:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_nav_disabled_opacity',
			[
				'label'     => esc_html__( 'Deaktiviert Deckkraft', 'galerie-mueller' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
				'default'   => [ 'size' => 0.3 ],
				'selectors' => [
					'{{WRAPPER}} .gm-gallery__lightbox-prev:disabled, {{WRAPPER}} .gm-gallery__lightbox-next:disabled' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'lightbox_nav_margin_top',
			[
				'label'      => esc_html__( 'Nav Abstand oben', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60, 'step' => 2 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-nav' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lightbox_nav_gap',
			[
				'label'      => esc_html__( 'Nav Abstand zwischen', 'galerie-mueller' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40, 'step' => 2 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .gm-gallery__lightbox-nav' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0.0
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// --- Gather filters ---
		$show_filters   = $settings['show_filters'] === 'yes';
		$all_tab_label  = $settings['all_tab_label'];
		$filters        = $settings['filters'] ?? [];

		// --- Gather artworks ---
		$artworks = $settings['artworks'] ?? [];

		// --- Layout settings ---
		$show_hover_overlay = $settings['show_hover_overlay'] === 'yes';
		$hover_overlay_text = $settings['hover_overlay_text'] ?? 'Werk ansehen';
		$show_dimensions    = $settings['show_dimensions'] === 'yes';
		$empty_message      = $settings['empty_message'] ?? '';
		$card_aspect_ratio  = $settings['card_aspect_ratio'] ?? '4/5';
		$custom_w           = $settings['card_custom_aspect_w'] ?? 4;
		$custom_h           = $settings['card_custom_aspect_h'] ?? 5;

		// --- Lightbox settings ---
		$enable_lightbox       = $settings['enable_lightbox'] === 'yes';
		$lightbox_cta_text     = $settings['lightbox_cta_text'] ?? 'Anfrage stellen';
		$lightbox_cta_url      = $settings['lightbox_cta_url']['url'] ?? '/kontakt';
		$cta_is_external       = ! empty( $settings['lightbox_cta_url']['is_external'] );
		$cta_nofollow          = ! empty( $settings['lightbox_cta_url']['nofollow'] );
		$enable_url_params     = $settings['enable_url_params'] === 'yes';
		$show_lightbox_nav     = $settings['show_lightbox_nav'] === 'yes';
		$prev_text             = $settings['prev_text'] ?? "\u{2190} Vorheriges";
		$next_text             = $settings['next_text'] ?? "N\u{00E4}chstes \u{2192}";
		$enable_keyboard_nav   = $settings['enable_keyboard_nav'] === 'yes';
		$enable_click_outside  = $settings['enable_click_outside_close'] === 'yes';
		$show_lb_dimensions    = $settings['show_lightbox_dimensions'] === 'yes';
		$show_lb_divider       = $settings['show_lightbox_divider'] === 'yes';

		// --- Animation settings ---
		$enable_fade_up     = $settings['enable_fade_up'] === 'yes';
		$anim_duration      = $settings['animation_duration']['size'] ?? 600;
		$anim_distance      = $settings['animation_distance']['size'] ?? 20;
		$stagger_delay      = $settings['stagger_delay']['size'] ?? 100;
		$anim_threshold     = $settings['animation_threshold']['size'] ?? 0.15;
		$grid_columns       = $settings['grid_columns'] ?? 3;

		// Compute aspect ratio for custom
		if ( $card_aspect_ratio === 'custom' ) {
			$aspect_value = intval( $custom_w ) . ' / ' . intval( $custom_h );
		} else {
			$aspect_value = str_replace( '/', ' / ', $card_aspect_ratio );
		}

		// X icon SVG
		$x_icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

		?>
		<div class="gm-gallery"
			 data-lightbox="<?php echo $enable_lightbox ? 'yes' : 'no'; ?>"
			 data-url-params="<?php echo $enable_url_params ? 'yes' : 'no'; ?>"
			 data-keyboard-nav="<?php echo $enable_keyboard_nav ? 'yes' : 'no'; ?>"
			 data-click-outside-close="<?php echo $enable_click_outside ? 'yes' : 'no'; ?>"
			 data-fade-up="<?php echo $enable_fade_up ? 'yes' : 'no'; ?>"
			 data-anim-duration="<?php echo esc_attr( $anim_duration ); ?>"
			 data-anim-distance="<?php echo esc_attr( $anim_distance ); ?>"
			 data-stagger-delay="<?php echo esc_attr( $stagger_delay ); ?>"
			 data-anim-threshold="<?php echo esc_attr( $anim_threshold ); ?>"
			 data-cta-url="<?php echo esc_attr( $lightbox_cta_url ); ?>"
			 data-grid-columns="<?php echo esc_attr( $grid_columns ); ?>">

			<?php // ==================== FILTER TABS ==================== ?>
			<?php if ( $show_filters ) : ?>
			<div class="gm-gallery__tabs">
				<div class="gm-gallery__tabs-container">
					<nav class="gm-gallery__tabs-nav">
						<button class="gm-gallery__tab gm-gallery__tab--active" data-filter="" type="button">
							<?php echo esc_html( $all_tab_label ); ?>
						</button>
						<?php foreach ( $filters as $filter ) :
							$label = $filter['filter_label'] ?? '';
							$slug  = $filter['filter_slug'] ?? '';
						?>
						<button class="gm-gallery__tab" data-filter="<?php echo esc_attr( $slug ); ?>" type="button">
							<?php echo esc_html( $label ); ?>
						</button>
						<?php endforeach; ?>
					</nav>
				</div>
			</div>
			<?php endif; ?>

			<?php // ==================== ARTWORK GRID ==================== ?>
			<div class="gm-gallery__grid-section">
				<div class="gm-gallery__grid-container">
					<?php if ( ! empty( $artworks ) ) : ?>
					<div class="gm-gallery__grid">
						<?php foreach ( $artworks as $index => $artwork ) :
							$title      = $artwork['artwork_title'] ?? '';
							$medium     = $artwork['artwork_medium'] ?? '';
							$year       = $artwork['artwork_year'] ?? '';
							$dimensions = $artwork['artwork_dimensions'] ?? '';
							$category   = $artwork['artwork_category'] ?? '';
							$image_id   = $artwork['artwork_image']['id'] ?? '';
							$image_url  = '';

							if ( $image_id ) {
								$image_size = $artwork['artwork_image_size_size'] ?? 'large';
								$image_data = wp_get_attachment_image_src( $image_id, $image_size );
								if ( $image_data ) {
									$image_url = $image_data[0];
								}
							} elseif ( ! empty( $artwork['artwork_image']['url'] ) ) {
								$image_url = $artwork['artwork_image']['url'];
							}

							// Full-size image for lightbox
							$image_full_url = '';
							if ( $image_id ) {
								$image_full_data = wp_get_attachment_image_src( $image_id, 'full' );
								if ( $image_full_data ) {
									$image_full_url = $image_full_data[0];
								}
							}
							if ( ! $image_full_url ) {
								$image_full_url = $image_url;
							}

							$meta_text = '';
							if ( $medium && $year ) {
								$meta_text = $medium . ', ' . $year;
							} elseif ( $medium ) {
								$meta_text = $medium;
							} elseif ( $year ) {
								$meta_text = (string) $year;
							}
						?>
						<div class="gm-gallery__card"
							 data-category="<?php echo esc_attr( $category ); ?>"
							 data-index="<?php echo esc_attr( $index ); ?>"
							 data-title="<?php echo esc_attr( $title ); ?>"
							 data-medium="<?php echo esc_attr( $medium ); ?>"
							 data-year="<?php echo esc_attr( $year ); ?>"
							 data-dimensions="<?php echo esc_attr( $dimensions ); ?>"
							 data-image="<?php echo esc_url( $image_full_url ); ?>">
							<div class="gm-gallery__card-inner">
								<div class="gm-gallery__card-image-wrap"<?php if ( $card_aspect_ratio === 'custom' ) : ?> style="aspect-ratio: <?php echo esc_attr( $aspect_value ); ?>;"<?php endif; ?>>
									<?php if ( $image_url ) : ?>
									<img class="gm-gallery__card-image"
										 src="<?php echo esc_url( $image_url ); ?>"
										 alt="<?php echo esc_attr( $title ); ?>"
										 loading="lazy" />
									<?php endif; ?>
									<?php if ( $show_hover_overlay ) : ?>
									<div class="gm-gallery__card-overlay">
										<span class="gm-gallery__card-overlay-text"><?php echo esc_html( $hover_overlay_text ); ?></span>
									</div>
									<?php endif; ?>
								</div>
								<h3 class="gm-gallery__card-title"><?php echo esc_html( $title ); ?></h3>
								<?php if ( $meta_text ) : ?>
								<p class="gm-gallery__card-meta"><?php echo esc_html( $meta_text ); ?></p>
								<?php endif; ?>
								<?php if ( $show_dimensions && $dimensions ) : ?>
								<p class="gm-gallery__card-dimensions"><?php echo esc_html( $dimensions ); ?></p>
								<?php endif; ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
					<p class="gm-gallery__empty"><?php echo esc_html( $empty_message ); ?></p>
				</div>
			</div>

			<?php // ==================== LIGHTBOX ==================== ?>
			<?php if ( $enable_lightbox ) : ?>
			<div class="gm-gallery__lightbox" aria-hidden="true">
				<div class="gm-gallery__lightbox-overlay">
					<button class="gm-gallery__lightbox-close" aria-label="<?php esc_attr_e( 'Schlie&szlig;en', 'galerie-mueller' ); ?>" type="button">
						<?php echo $x_icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG ?>
					</button>
					<div class="gm-gallery__lightbox-wrapper">
						<div class="gm-gallery__lightbox-modal">
							<div class="gm-gallery__lightbox-grid">
								<div class="gm-gallery__lightbox-image-area">
									<img class="gm-gallery__lightbox-image" src="" alt="" />
								</div>
								<div class="gm-gallery__lightbox-info">
									<h2 class="gm-gallery__lightbox-title"></h2>
									<p class="gm-gallery__lightbox-medium"></p>
									<p class="gm-gallery__lightbox-year"></p>
									<?php if ( $show_lb_dimensions ) : ?>
									<p class="gm-gallery__lightbox-dimensions"></p>
									<?php endif; ?>
									<?php if ( $show_lb_divider ) : ?>
									<div class="gm-gallery__lightbox-divider"></div>
									<?php endif; ?>
									<a class="gm-gallery__lightbox-cta"
									   href="<?php echo esc_url( $lightbox_cta_url ); ?>"
									   <?php echo $cta_is_external ? 'target="_blank"' : ''; ?>
									   <?php echo $cta_nofollow ? 'rel="nofollow"' : ''; ?>>
										<?php echo esc_html( $lightbox_cta_text ); ?>
									</a>
									<?php if ( $show_lightbox_nav ) : ?>
									<div class="gm-gallery__lightbox-nav">
										<button class="gm-gallery__lightbox-prev" type="button" disabled>
											<?php echo esc_html( $prev_text ); ?>
										</button>
										<button class="gm-gallery__lightbox-next" type="button" disabled>
											<?php echo esc_html( $next_text ); ?>
										</button>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>

		</div>
		<?php
	}
}
