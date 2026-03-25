<?php
namespace Galerie_Mueller_Widgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contact Form Widget
 *
 * Full contact form with AJAX submission, honeypot spam protection,
 * success/error states, contact info sidebar, and responsive layout.
 *
 * @since 1.2.0
 */
class Contact_Form_Widget extends Widget_Base {

	public function get_name(): string {
		return 'gm_contact_form';
	}

	public function get_title(): string {
		return esc_html__( 'Galerie Mueller - Kontaktformular', 'galerie-mueller-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-form-horizontal';
	}

	public function get_categories(): array {
		return [ 'galerie-mueller' ];
	}

	public function get_keywords(): array {
		return [ 'contact', 'kontakt', 'form', 'formular', 'email', 'galerie' ];
	}

	public function get_style_depends(): array {
		return [ 'gm-contact-form-style' ];
	}

	public function get_script_depends(): array {
		return [ 'gm-contact-form-script' ];
	}

	protected function register_controls(): void {
		$this->register_content_form_section();
		$this->register_content_fields_section();
		$this->register_content_button_section();
		$this->register_content_info_section();
		$this->register_content_email_section();
		$this->register_content_success_section();
		$this->register_content_error_section();
		$this->register_content_spam_section();
		$this->register_content_animation_section();
		$this->register_style_section();
		$this->register_style_layout_section();
		$this->register_style_form_heading_section();
		$this->register_style_label_section();
		$this->register_style_input_section();
		$this->register_style_button_section();
		$this->register_style_info_section();
		$this->register_style_icon_section();
		$this->register_style_email_link_section();
		$this->register_style_address_section();
		$this->register_style_divider_section();
		$this->register_style_success_section();
		$this->register_style_error_section();
	}

	/* =================================================================
	   TAB_CONTENT
	   ================================================================= */

	private function register_content_form_section(): void {
		$this->start_controls_section(
			'content_form_section',
			[
				'label' => esc_html__( 'Formular-Inhalt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'form_heading_text',
			[
				'label'       => esc_html__( 'Formular-Überschrift', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'SCHREIBEN SIE UNS',
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_form_accent_line',
			[
				'label'        => esc_html__( 'Akzentlinie anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'form_heading_tag',
			[
				'label'   => esc_html__( 'Überschrift HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'p'    => 'p',
					'span' => 'span',
					'div'  => 'div',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_content_fields_section(): void {
		$this->start_controls_section(
			'content_fields_section',
			[
				'label' => esc_html__( 'Formularfelder', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Name field
		$this->add_control(
			'show_name_field',
			[
				'label'        => esc_html__( 'Name-Feld anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'name_label',
			[
				'label'     => esc_html__( 'Name Label', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Name',
				'condition' => [ 'show_name_field' => 'yes' ],
			]
		);

		$this->add_control(
			'name_placeholder',
			[
				'label'     => esc_html__( 'Name Placeholder', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Ihr Name',
				'condition' => [ 'show_name_field' => 'yes' ],
			]
		);

		$this->add_control(
			'name_required',
			[
				'label'        => esc_html__( 'Name erforderlich', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_name_field' => 'yes' ],
			]
		);

		// Email field
		$this->add_control(
			'show_email_field',
			[
				'label'        => esc_html__( 'E-Mail-Feld anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'email_label',
			[
				'label'     => esc_html__( 'E-Mail Label', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'E-Mail',
				'condition' => [ 'show_email_field' => 'yes' ],
			]
		);

		$this->add_control(
			'email_placeholder',
			[
				'label'     => esc_html__( 'E-Mail Placeholder', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Ihre E-Mail-Adresse',
				'condition' => [ 'show_email_field' => 'yes' ],
			]
		);

		$this->add_control(
			'email_required',
			[
				'label'        => esc_html__( 'E-Mail erforderlich', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_email_field' => 'yes' ],
			]
		);

		// Subject field
		$this->add_control(
			'show_subject_field',
			[
				'label'        => esc_html__( 'Betreff-Feld anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'subject_label',
			[
				'label'     => esc_html__( 'Betreff Label', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Betreff',
				'condition' => [ 'show_subject_field' => 'yes' ],
			]
		);

		$this->add_control(
			'subject_options',
			[
				'label'     => esc_html__( 'Betreff-Optionen', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => "Allgemeine Anfrage\nAnfrage zu einem Werk",
				'condition' => [ 'show_subject_field' => 'yes' ],
			]
		);

		// Message field
		$this->add_control(
			'show_message_field',
			[
				'label'        => esc_html__( 'Nachricht-Feld anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'message_label',
			[
				'label'     => esc_html__( 'Nachricht Label', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Nachricht',
				'condition' => [ 'show_message_field' => 'yes' ],
			]
		);

		$this->add_control(
			'message_placeholder',
			[
				'label'     => esc_html__( 'Nachricht Placeholder', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Ihre Nachricht an uns...',
				'condition' => [ 'show_message_field' => 'yes' ],
			]
		);

		$this->add_control(
			'message_required',
			[
				'label'        => esc_html__( 'Nachricht erforderlich', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_message_field' => 'yes' ],
			]
		);

		$this->add_control(
			'message_rows',
			[
				'label'     => esc_html__( 'Textarea-Zeilen', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 2,
				'max'       => 20,
				'condition' => [ 'show_message_field' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_content_button_section(): void {
		$this->start_controls_section(
			'content_button_section',
			[
				'label' => esc_html__( 'Absenden-Button', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button-Text', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Nachricht senden',
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_loading_text',
			[
				'label'       => esc_html__( 'Ladetext', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Wird gesendet...',
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_align',
			[
				'label'   => esc_html__( 'Button-Ausrichtung', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Links', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Zentriert', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Rechts', 'galerie-mueller-widgets' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->end_controls_section();
	}

	private function register_content_info_section(): void {
		$this->start_controls_section(
			'content_info_section',
			[
				'label' => esc_html__( 'Kontaktdaten', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'info_heading_text',
			[
				'label'       => esc_html__( 'Info-Überschrift', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'KONTAKTDATEN',
				'label_block' => true,
			]
		);

		$this->add_control(
			'info_heading_tag',
			[
				'label'   => esc_html__( 'Info Überschrift HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'p'    => 'p',
					'span' => 'span',
					'div'  => 'div',
				],
			]
		);

		$this->add_control(
			'show_email_info',
			[
				'label'        => esc_html__( 'E-Mail anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'info_email',
			[
				'label'     => esc_html__( 'E-Mail-Adresse', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'info@galerie-mueller.de',
				'condition' => [ 'show_email_info' => 'yes' ],
			]
		);

		$this->add_control(
			'show_address_info',
			[
				'label'        => esc_html__( 'Adresse anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'info_address',
			[
				'label'     => esc_html__( 'Adresse', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => "Galerie Mueller\nMusterstraße 1\n64283 Darmstadt",
				'rows'      => 4,
				'condition' => [ 'show_address_info' => 'yes' ],
			]
		);

		$this->add_control(
			'show_info_divider',
			[
				'label'        => esc_html__( 'Trennlinie anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function register_content_email_section(): void {
		$this->start_controls_section(
			'content_email_section',
			[
				'label' => esc_html__( 'E-Mail-Einstellungen', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'recipient_email',
			[
				'label'       => esc_html__( 'Empfänger E-Mail', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'description' => esc_html__( 'Leer lassen für Admin-E-Mail', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'email_subject_prefix',
			[
				'label'       => esc_html__( 'Betreff-Präfix', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Galerie Mueller Kontakt:',
				'label_block' => true,
			]
		);

		$this->add_control(
			'from_name',
			[
				'label'       => esc_html__( 'Absendername', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Galerie Mueller Website',
				'label_block' => true,
			]
		);

		$this->add_control(
			'enable_reply_to',
			[
				'label'        => esc_html__( 'Reply-To aktivieren', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'save_submissions',
			[
				'label'        => esc_html__( 'Einreichungen speichern', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function register_content_success_section(): void {
		$this->start_controls_section(
			'content_success_section',
			[
				'label' => esc_html__( 'Erfolgsmeldung', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'success_heading',
			[
				'label'       => esc_html__( 'Erfolg-Überschrift', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Vielen Dank für Ihre Nachricht.',
				'label_block' => true,
			]
		);

		$this->add_control(
			'success_heading_tag',
			[
				'label'   => esc_html__( 'Erfolg Überschrift HTML-Tag', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'p'    => 'p',
					'span' => 'span',
					'div'  => 'div',
				],
			]
		);

		$this->add_control(
			'success_subtext',
			[
				'label'   => esc_html__( 'Erfolg-Untertext', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Wir werden uns in Kürze bei Ihnen melden.',
				'rows'    => 3,
			]
		);

		$this->add_control(
			'show_success_checkmark',
			[
				'label'        => esc_html__( 'Häkchen anzeigen', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function register_content_error_section(): void {
		$this->start_controls_section(
			'content_error_section',
			[
				'label' => esc_html__( 'Fehlermeldungen', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'error_general',
			[
				'label'       => esc_html__( 'Allgemeiner Fehler', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
				'label_block' => true,
			]
		);

		$this->add_control(
			'error_required',
			[
				'label'       => esc_html__( 'Pflichtfeld-Fehler', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Bitte füllen Sie dieses Feld aus.',
				'label_block' => true,
			]
		);

		$this->add_control(
			'error_email_invalid',
			[
				'label'       => esc_html__( 'Ungültige E-Mail', 'galerie-mueller-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	private function register_content_spam_section(): void {
		$this->start_controls_section(
			'content_spam_section',
			[
				'label' => esc_html__( 'Spam-Schutz', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_honeypot',
			[
				'label'        => esc_html__( 'Honeypot aktivieren', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'honeypot_field_name',
			[
				'label'     => esc_html__( 'Honeypot-Feldname', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'fax',
				'condition' => [ 'enable_honeypot' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	private function register_content_animation_section(): void {
		$this->start_controls_section(
			'content_animation_section',
			[
				'label' => esc_html__( 'Animation', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_fade_up',
			[
				'label'        => esc_html__( 'Eingangsanimation', 'galerie-mueller-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Ja', 'galerie-mueller-widgets' ),
				'label_off'    => esc_html__( 'Nein', 'galerie-mueller-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label'     => esc_html__( 'Animationsdauer', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 100,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default'   => [
					'size' => 700,
					'unit' => 'px',
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_distance',
			[
				'label'      => esc_html__( 'Animationsversatz', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'size' => 20,
					'unit' => 'px',
				],
				'condition'  => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_threshold',
			[
				'label'   => esc_html__( 'Sichtbarkeitsschwelle', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.15,
				],
				'condition' => [
					'enable_fade_up' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/* =================================================================
	   TAB_STYLE
	   ================================================================= */

	private function register_style_section(): void {
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Abschnitt', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FAFAFA',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Section Padding', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default'    => [
					'top'      => 96,
					'right'    => 0,
					'bottom'   => 96,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_layout_section(): void {
		$this->start_controls_section(
			'style_layout_section',
			[
				'label' => esc_html__( 'Layout', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_max_width',
			[
				'label'      => esc_html__( 'Container Max-Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 600,
						'max' => 1400,
					],
					'%'  => [
						'min' => 50,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 1152,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 24,
					'bottom'   => 0,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'columns_gap',
			[
				'label'      => esc_html__( 'Spaltenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 120,
					],
				],
				'default'    => [
					'size' => 60,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__layout' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_column_width',
			[
				'label'      => esc_html__( 'Formular-Spaltenbreite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 40,
						'max' => 80,
					],
				],
				'default'    => [
					'size' => 60,
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__form-col' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'info_column_width',
			[
				'label'      => esc_html__( 'Info-Spaltenbreite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__info-col' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_column_padding_left',
			[
				'label'      => esc_html__( 'Info-Spalte Padding links', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__info-col' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_form_heading_section(): void {
		$this->start_controls_section(
			'style_form_heading_section',
			[
				'label' => esc_html__( 'Formular-Überschrift', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_heading_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__form-heading',
			]
		);

		$this->add_control(
			'form_heading_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__form-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_heading_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__form-heading-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_width',
			[
				'label'      => esc_html__( 'Akzentlinie Breite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'default'    => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__accent-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_height',
			[
				'label'      => esc_html__( 'Akzentlinie Höhe', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__accent-line' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accent_line_color',
			[
				'label'     => esc_html__( 'Akzentlinie Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__accent-line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_line_gap',
			[
				'label'      => esc_html__( 'Akzentlinie Abstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__form-heading-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_label_section(): void {
		$this->start_controls_section(
			'style_label_section',
			[
				'label' => esc_html__( 'Labels', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__label',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_spacing',
			[
				'label'      => esc_html__( 'Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
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
					'{{WRAPPER}} .gm-contact-form__label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_input_section(): void {
		$input_selector = '{{WRAPPER}} .gm-contact-form__input, {{WRAPPER}} .gm-contact-form__select, {{WRAPPER}} .gm-contact-form__textarea';

		$this->start_controls_section(
			'style_input_section',
			[
				'label' => esc_html__( 'Eingabefelder', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => $input_selector,
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					$input_selector => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					$input_selector => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label'     => esc_html__( 'Rahmenfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E0DCD7',
				'selectors' => [
					$input_selector => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_width',
			[
				'label'      => esc_html__( 'Rahmenbreite', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default'    => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors'  => [
					$input_selector => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label'      => esc_html__( 'Rahmenradius', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					$input_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 14,
					'right'    => 14,
					'bottom'   => 14,
					'left'     => 14,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					$input_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Platzhalterfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(107, 107, 107, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__input::placeholder, {{WRAPPER}} .gm-contact-form__textarea::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$focus_selector = '{{WRAPPER}} .gm-contact-form__input:focus, {{WRAPPER}} .gm-contact-form__select:focus, {{WRAPPER}} .gm-contact-form__textarea:focus';

		$this->add_control(
			'input_focus_border_color',
			[
				'label'     => esc_html__( 'Fokus Rahmenfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					$focus_selector => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_focus_ring_color',
			[
				'label'     => esc_html__( 'Fokus Ring-Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(140, 122, 91, 0.3)',
				'selectors' => [
					$focus_selector => 'box-shadow: 0 0 0 1px {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_gap',
			[
				'label'      => esc_html__( 'Feldabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__fields' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_button_section(): void {
		$this->start_controls_section(
			'style_button_section',
			[
				'label' => esc_html__( 'Button', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__submit',
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__submit',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'galerie-mueller-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__( 'Textfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label'     => esc_html__( 'Hintergrundfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__submit:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// After tabs
		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Innenabstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => 14,
					'right'    => 36,
					'bottom'   => 14,
					'left'     => 36,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Rahmenradius', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 0,
					'right'    => 0,
					'bottom'   => 0,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'label'    => esc_html__( 'Rahmen', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__submit',
			]
		);

		$this->add_control(
			'button_margin_top',
			[
				'label'      => esc_html__( 'Abstand oben', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 16,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__submit' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_transition_duration',
			[
				'label'   => esc_html__( 'Transition-Dauer', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 50,
					],
				],
				'default' => [
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__submit' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->add_control(
			'button_disabled_opacity',
			[
				'label'   => esc_html__( 'Deaktiviert Deckkraft', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.6,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__submit:disabled' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_info_section(): void {
		$this->start_controls_section(
			'style_info_section',
			[
				'label' => esc_html__( 'Info-Spalte', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_heading_typography',
				'label'    => esc_html__( 'Überschrift Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__info-heading',
			]
		);

		$this->add_control(
			'info_heading_color',
			[
				'label'     => esc_html__( 'Überschrift Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__info-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_heading_spacing',
			[
				'label'      => esc_html__( 'Überschrift Abstand unten', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 80,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__info-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'info_items_gap',
			[
				'label'      => esc_html__( 'Elemente Abstand', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__info-items' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_icon_section(): void {
		$this->start_controls_section(
			'style_icon_section',
			[
				'label' => esc_html__( 'Symbole', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Symbolgröße', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 40,
					],
				],
				'default'    => [
					'size' => 18,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Symbolfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_scale',
			[
				'label'   => esc_html__( 'Hover Skalierung', 'galerie-mueller-widgets' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 1,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1.1,
				],
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__info-email:hover .gm-contact-form__icon' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_email_link_section(): void {
		$this->start_controls_section(
			'style_email_link_section',
			[
				'label' => esc_html__( 'E-Mail Link', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'email_link_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__info-email-link',
			]
		);

		$this->add_control(
			'email_link_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__info-email-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'email_link_hover_color',
			[
				'label'     => esc_html__( 'Hover Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__info-email-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_address_section(): void {
		$this->start_controls_section(
			'style_address_section',
			[
				'label' => esc_html__( 'Adresse', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__info-address-text',
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__info-address-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_divider_section(): void {
		$this->start_controls_section(
			'style_divider_section',
			[
				'label' => esc_html__( 'Trennlinie', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Trennlinienfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(224, 220, 215, 0.3)',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__info-divider' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_height',
			[
				'label'      => esc_html__( 'Trennlinien Höhe', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 5,
					],
				],
				'default'    => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__info-divider' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_success_section(): void {
		$this->start_controls_section(
			'style_success_section',
			[
				'label' => esc_html__( 'Erfolgsstatus', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'success_circle_size',
			[
				'label'      => esc_html__( 'Kreisgröße', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 32,
						'max' => 128,
					],
				],
				'default'    => [
					'size' => 64,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__success-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'success_circle_bg',
			[
				'label'     => esc_html__( 'Kreis Hintergrund', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F0EEEB',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__success-circle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'success_checkmark_size',
			[
				'label'      => esc_html__( 'Häkchengröße', 'galerie-mueller-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 16,
						'max' => 64,
					],
				],
				'default'    => [
					'size' => 32,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .gm-contact-form__success-checkmark' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'success_checkmark_color',
			[
				'label'     => esc_html__( 'Häkchenfarbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8C7A5B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__success-checkmark' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'success_heading_typography',
				'label'    => esc_html__( 'Überschrift Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__success-heading',
			]
		);

		$this->add_control(
			'success_heading_color',
			[
				'label'     => esc_html__( 'Überschrift Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1A1A1A',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__success-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'success_subtext_typography',
				'label'    => esc_html__( 'Untertext Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__success-subtext',
			]
		);

		$this->add_control(
			'success_subtext_color',
			[
				'label'     => esc_html__( 'Untertext Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6B6B',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__success-subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_error_section(): void {
		$this->start_controls_section(
			'style_error_section',
			[
				'label' => esc_html__( 'Fehlerstatus', 'galerie-mueller-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'error_text_color',
			[
				'label'     => esc_html__( 'Fehlertext Farbe', 'galerie-mueller-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#EF4444',
				'selectors' => [
					'{{WRAPPER}} .gm-contact-form__error' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'error_typography',
				'label'    => esc_html__( 'Fehlertext Typografie', 'galerie-mueller-widgets' ),
				'selector' => '{{WRAPPER}} .gm-contact-form__error',
			]
		);

		$this->end_controls_section();
	}

	/* =================================================================
	   RENDER
	   ================================================================= */

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();

		// Animation data attributes
		$fade_up = $settings['enable_fade_up'] === 'yes';
		$container_class = 'gm-contact-form__container';
		if ( $fade_up ) {
			$container_class .= ' gm-contact-form__container--hidden';
		}

		// Parse subject options (one per line)
		$subject_lines = array_filter( array_map( 'trim', explode( "\n", $settings['subject_options'] ) ) );

		// Parse address (preserve line breaks)
		$address_html = nl2br( esc_html( $settings['info_address'] ) );

		// Nonce for AJAX
		$nonce = wp_create_nonce( 'gm_contact_form_nonce' );
		$ajax_url = admin_url( 'admin-ajax.php' );

		// Heading tags
		$form_heading_tag = \Elementor\Utils::validate_html_tag( $settings['form_heading_tag'] );
		$info_heading_tag = \Elementor\Utils::validate_html_tag( $settings['info_heading_tag'] );
		$success_heading_tag = \Elementor\Utils::validate_html_tag( $settings['success_heading_tag'] );

		// Honeypot
		$honeypot_enabled = $settings['enable_honeypot'] === 'yes';
		$honeypot_name = ! empty( $settings['honeypot_field_name'] ) ? esc_attr( $settings['honeypot_field_name'] ) : 'fax';

		// Button alignment
		$button_align = ! empty( $settings['button_align'] ) ? $settings['button_align'] : 'left';

		// Error message
		$error_message = esc_attr( $settings['error_general'] );
		?>

		<section class="gm-contact-form">
			<div
				class="<?php echo esc_attr( $container_class ); ?>"
				<?php if ( $fade_up ) : ?>
					data-fade-up="true"
					data-threshold="<?php echo esc_attr( $settings['animation_threshold']['size'] ?? '0.15' ); ?>"
					data-duration="<?php echo esc_attr( $settings['animation_duration']['size'] ?? '700' ); ?>"
					data-distance="<?php echo esc_attr( $settings['animation_distance']['size'] ?? '20' ); ?>"
				<?php endif; ?>
			>
				<div class="gm-contact-form__layout">

					<!-- ===== Mobile Info (visible below lg) ===== -->
					<div class="gm-contact-form__info-mobile">
						<<?php echo esc_html( $info_heading_tag ); ?> class="gm-contact-form__info-heading">
							<?php echo esc_html( $settings['info_heading_text'] ); ?>
						</<?php echo esc_html( $info_heading_tag ); ?>>

						<div class="gm-contact-form__info-items">
							<?php if ( $settings['show_email_info'] === 'yes' ) : ?>
								<div class="gm-contact-form__info-email">
									<svg class="gm-contact-form__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<rect width="20" height="16" x="2" y="4" rx="2"/>
										<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
									</svg>
									<a href="mailto:<?php echo esc_attr( $settings['info_email'] ); ?>" class="gm-contact-form__info-email-link">
										<?php echo esc_html( $settings['info_email'] ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php if ( $settings['show_address_info'] === 'yes' ) : ?>
								<div class="gm-contact-form__info-address">
									<svg class="gm-contact-form__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/>
										<circle cx="12" cy="10" r="3"/>
									</svg>
									<div class="gm-contact-form__info-address-text">
										<?php echo $address_html; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- ===== Form Column ===== -->
					<div class="gm-contact-form__form-col">

						<!-- Form Heading -->
						<div class="gm-contact-form__form-heading-row">
							<?php if ( $settings['show_form_accent_line'] === 'yes' ) : ?>
								<div class="gm-contact-form__accent-line"></div>
							<?php endif; ?>
							<<?php echo esc_html( $form_heading_tag ); ?> class="gm-contact-form__form-heading">
								<?php echo esc_html( $settings['form_heading_text'] ); ?>
							</<?php echo esc_html( $form_heading_tag ); ?>>
						</div>

						<!-- Success State -->
						<div class="gm-contact-form__success">
							<?php if ( $settings['show_success_checkmark'] === 'yes' ) : ?>
								<div class="gm-contact-form__success-circle-wrap">
									<div class="gm-contact-form__success-circle">
										<svg class="gm-contact-form__success-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
											<path d="M5 13l4 4L19 7"/>
										</svg>
									</div>
								</div>
							<?php endif; ?>
							<<?php echo esc_html( $success_heading_tag ); ?> class="gm-contact-form__success-heading">
								<?php echo esc_html( $settings['success_heading'] ); ?>
							</<?php echo esc_html( $success_heading_tag ); ?>>
							<p class="gm-contact-form__success-subtext">
								<?php echo esc_html( $settings['success_subtext'] ); ?>
							</p>
						</div>

						<!-- Form -->
						<form
							class="gm-contact-form__form gm-contact-form__fields"
							data-ajax-url="<?php echo esc_url( $ajax_url ); ?>"
							data-nonce="<?php echo esc_attr( $nonce ); ?>"
							data-widget-id="<?php echo esc_attr( $widget_id ); ?>"
							data-error-message="<?php echo $error_message; ?>"
							<?php if ( $honeypot_enabled ) : ?>
								data-honeypot="<?php echo $honeypot_name; ?>"
							<?php endif; ?>
							novalidate
						>

							<?php // Honeypot field ?>
							<?php if ( $honeypot_enabled ) : ?>
								<input
									type="text"
									name="<?php echo $honeypot_name; ?>"
									class="gm-contact-form__honeypot"
									tabindex="-1"
									autocomplete="off"
									aria-hidden="true"
								/>
							<?php endif; ?>

							<?php // Name field ?>
							<?php if ( $settings['show_name_field'] === 'yes' ) : ?>
								<div class="gm-contact-form__field-group">
									<label for="gm-cf-name-<?php echo esc_attr( $widget_id ); ?>" class="gm-contact-form__label">
										<?php echo esc_html( $settings['name_label'] ); ?>
									</label>
									<input
										type="text"
										id="gm-cf-name-<?php echo esc_attr( $widget_id ); ?>"
										name="gm_name"
										class="gm-contact-form__input"
										placeholder="<?php echo esc_attr( $settings['name_placeholder'] ); ?>"
										<?php echo $settings['name_required'] === 'yes' ? 'required' : ''; ?>
									/>
								</div>
							<?php endif; ?>

							<?php // Email field ?>
							<?php if ( $settings['show_email_field'] === 'yes' ) : ?>
								<div class="gm-contact-form__field-group">
									<label for="gm-cf-email-<?php echo esc_attr( $widget_id ); ?>" class="gm-contact-form__label">
										<?php echo esc_html( $settings['email_label'] ); ?>
									</label>
									<input
										type="email"
										id="gm-cf-email-<?php echo esc_attr( $widget_id ); ?>"
										name="gm_email"
										class="gm-contact-form__input"
										placeholder="<?php echo esc_attr( $settings['email_placeholder'] ); ?>"
										<?php echo $settings['email_required'] === 'yes' ? 'required' : ''; ?>
									/>
								</div>
							<?php endif; ?>

							<?php // Subject field ?>
							<?php if ( $settings['show_subject_field'] === 'yes' ) : ?>
								<div class="gm-contact-form__field-group">
									<label for="gm-cf-subject-<?php echo esc_attr( $widget_id ); ?>" class="gm-contact-form__label">
										<?php echo esc_html( $settings['subject_label'] ); ?>
									</label>
									<select
										id="gm-cf-subject-<?php echo esc_attr( $widget_id ); ?>"
										name="gm_subject"
										class="gm-contact-form__select"
									>
										<?php foreach ( $subject_lines as $option ) : ?>
											<option value="<?php echo esc_attr( $option ); ?>">
												<?php echo esc_html( $option ); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							<?php endif; ?>

							<?php // Message field ?>
							<?php if ( $settings['show_message_field'] === 'yes' ) : ?>
								<div class="gm-contact-form__field-group">
									<label for="gm-cf-message-<?php echo esc_attr( $widget_id ); ?>" class="gm-contact-form__label">
										<?php echo esc_html( $settings['message_label'] ); ?>
									</label>
									<textarea
										id="gm-cf-message-<?php echo esc_attr( $widget_id ); ?>"
										name="gm_message"
										class="gm-contact-form__textarea"
										rows="<?php echo esc_attr( $settings['message_rows'] ); ?>"
										placeholder="<?php echo esc_attr( $settings['message_placeholder'] ); ?>"
										<?php echo $settings['message_required'] === 'yes' ? 'required' : ''; ?>
									></textarea>
								</div>
							<?php endif; ?>

							<?php // Error display ?>
							<div class="gm-contact-form__error" style="display: none;"></div>

							<?php // Submit button ?>
							<div class="gm-contact-form__button-wrap gm-contact-form__button-wrap--<?php echo esc_attr( $button_align ); ?>">
								<button
									type="submit"
									class="gm-contact-form__submit"
									data-loading-text="<?php echo esc_attr( $settings['button_loading_text'] ); ?>"
									data-original-text="<?php echo esc_attr( $settings['button_text'] ); ?>"
								>
									<?php echo esc_html( $settings['button_text'] ); ?>
								</button>
							</div>

						</form>
					</div>

					<!-- ===== Desktop Info Column (visible at lg+) ===== -->
					<div class="gm-contact-form__info-col">
						<<?php echo esc_html( $info_heading_tag ); ?> class="gm-contact-form__info-heading">
							<?php echo esc_html( $settings['info_heading_text'] ); ?>
						</<?php echo esc_html( $info_heading_tag ); ?>>

						<div class="gm-contact-form__info-items">
							<?php if ( $settings['show_email_info'] === 'yes' ) : ?>
								<div class="gm-contact-form__info-email">
									<svg class="gm-contact-form__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<rect width="20" height="16" x="2" y="4" rx="2"/>
										<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
									</svg>
									<a href="mailto:<?php echo esc_attr( $settings['info_email'] ); ?>" class="gm-contact-form__info-email-link">
										<?php echo esc_html( $settings['info_email'] ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php if ( $settings['show_info_divider'] === 'yes' && $settings['show_email_info'] === 'yes' && $settings['show_address_info'] === 'yes' ) : ?>
								<div class="gm-contact-form__info-divider"></div>
							<?php endif; ?>

							<?php if ( $settings['show_address_info'] === 'yes' ) : ?>
								<div class="gm-contact-form__info-address">
									<svg class="gm-contact-form__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/>
										<circle cx="12" cy="10" r="3"/>
									</svg>
									<div class="gm-contact-form__info-address-text">
										<?php echo $address_html; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</div>
		</section>

		<?php
	}
}
