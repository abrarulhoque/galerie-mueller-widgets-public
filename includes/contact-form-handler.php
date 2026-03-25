<?php
namespace Galerie_Mueller_Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the gm_submission Custom Post Type for contact form submissions.
 * Hooked to 'init'.
 */
function register_submission_cpt() {
	$labels = array(
		'name'               => 'Einreichungen',
		'singular_name'      => 'Einreichung',
		'menu_name'          => 'Einreichungen',
		'all_items'          => 'Alle Einreichungen',
		'view_item'          => 'Einreichung ansehen',
		'search_items'       => 'Einreichungen suchen',
		'not_found'          => 'Keine Einreichungen gefunden',
		'not_found_in_trash' => 'Keine Einreichungen im Papierkorb',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-email-alt',
		'capability_type'     => 'post',
		'capabilities'        => array(
			'create_posts' => 'do_not_allow',
		),
		'map_meta_cap'        => true,
		'hierarchical'        => false,
		'supports'            => array( 'title', 'editor' ),
		'has_archive'         => false,
		'rewrite'             => false,
		'query_var'           => false,
		'show_in_rest'        => false,
	);

	register_post_type( 'gm_submission', $args );
}
add_action( 'init', __NAMESPACE__ . '\register_submission_cpt' );

/**
 * Add custom columns to the gm_submission list table.
 */
function submission_columns( $columns ) {
	$new_columns = array(
		'cb'           => $columns['cb'],
		'title'        => 'Name / Betreff',
		'gm_email'     => 'E-Mail',
		'gm_subject'   => 'Betreff',
		'date'         => $columns['date'],
	);
	return $new_columns;
}
add_filter( 'manage_gm_submission_posts_columns', __NAMESPACE__ . '\submission_columns' );

/**
 * Populate custom columns with post meta.
 */
function submission_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'gm_email':
			$email = get_post_meta( $post_id, '_gm_email', true );
			echo esc_html( $email );
			if ( $email ) {
				echo ' <a href="mailto:' . esc_attr( $email ) . '">&#9993;</a>';
			}
			break;
		case 'gm_subject':
			echo esc_html( get_post_meta( $post_id, '_gm_subject', true ) );
			break;
	}
}
add_action( 'manage_gm_submission_posts_custom_column', __NAMESPACE__ . '\submission_column_content', 10, 2 );

/**
 * Make custom columns sortable.
 */
function submission_sortable_columns( $columns ) {
	$columns['gm_email']   = 'gm_email';
	$columns['gm_subject'] = 'gm_subject';
	return $columns;
}
add_filter( 'manage_edit-gm_submission_sortable_columns', __NAMESPACE__ . '\submission_sortable_columns' );

/**
 * Handle the AJAX form submission.
 * Registered for both logged-in and non-logged-in users.
 */
function handle_contact_submit() {
	// 1. Verify nonce
	if ( ! isset( $_POST['_nonce'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'gm_contact_form_nonce' ) ) {
		wp_send_json_error( array(
			'message' => 'Sicherheitsüberprüfung fehlgeschlagen. Bitte laden Sie die Seite neu.',
		), 403 );
	}

	// 2. Honeypot check (server-side)
	$honeypot_fields = array( 'fax', 'phone2', 'website_url' );
	foreach ( $honeypot_fields as $field ) {
		if ( ! empty( $_POST[ $field ] ) ) {
			// Bot detected: return fake success
			wp_send_json_success( array(
				'message' => 'Nachricht gesendet.',
			) );
		}
	}

	// 3. Sanitize and validate inputs
	$name    = isset( $_POST['gm_name'] )    ? sanitize_text_field( wp_unslash( $_POST['gm_name'] ) )    : '';
	$email   = isset( $_POST['gm_email'] )   ? sanitize_email( wp_unslash( $_POST['gm_email'] ) )        : '';
	$subject = isset( $_POST['gm_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['gm_subject'] ) ) : '';
	$message = isset( $_POST['gm_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['gm_message'] ) ) : '';

	// Required field validation
	$errors = array();

	if ( empty( $name ) ) {
		$errors[] = 'Name ist erforderlich.';
	}

	if ( empty( $email ) || ! is_email( $email ) ) {
		$errors[] = 'Eine gültige E-Mail-Adresse ist erforderlich.';
	}

	if ( empty( $message ) ) {
		$errors[] = 'Nachricht ist erforderlich.';
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error( array(
			'message' => implode( ' ', $errors ),
		), 400 );
	}

	// 4. Get widget-specific settings from stored option
	$widget_id   = isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';
	$widget_data = get_option( 'gm_contact_form_settings_' . $widget_id, array() );

	$recipient    = ! empty( $widget_data['recipient_email'] ) ? $widget_data['recipient_email'] : get_option( 'admin_email' );
	$prefix       = ! empty( $widget_data['email_subject_prefix'] ) ? $widget_data['email_subject_prefix'] : 'Galerie Mueller Kontakt:';
	$from_name    = ! empty( $widget_data['from_name'] ) ? $widget_data['from_name'] : 'Galerie Mueller Website';
	$reply_to     = ! empty( $widget_data['enable_reply_to'] ) && $widget_data['enable_reply_to'] === 'yes';
	$save_to_cpt  = ! empty( $widget_data['save_submissions'] ) ? $widget_data['save_submissions'] === 'yes' : true;

	// 5. Build email
	$email_subject = trim( $prefix . ' ' . $subject );

	$email_body = sprintf(
		'<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
		<h2 style="color: #8C7A5B; border-bottom: 1px solid #E0DCD7; padding-bottom: 10px;">Neue Kontaktanfrage</h2>
		<table style="width: 100%%; border-collapse: collapse;">
			<tr>
				<td style="padding: 8px 0; font-weight: bold; width: 120px; vertical-align: top;">Name:</td>
				<td style="padding: 8px 0;">%s</td>
			</tr>
			<tr>
				<td style="padding: 8px 0; font-weight: bold; vertical-align: top;">E-Mail:</td>
				<td style="padding: 8px 0;"><a href="mailto:%s">%s</a></td>
			</tr>
			<tr>
				<td style="padding: 8px 0; font-weight: bold; vertical-align: top;">Betreff:</td>
				<td style="padding: 8px 0;">%s</td>
			</tr>
			<tr>
				<td style="padding: 8px 0; font-weight: bold; vertical-align: top;">Nachricht:</td>
				<td style="padding: 8px 0;">%s</td>
			</tr>
		</table>
		<hr style="border: none; border-top: 1px solid #E0DCD7; margin: 20px 0;">
		<p style="font-size: 12px; color: #6B6B6B;">Diese Nachricht wurde über das Kontaktformular auf galerie-mueller.de gesendet.</p>
		</body></html>',
		esc_html( $name ),
		esc_attr( $email ),
		esc_html( $email ),
		esc_html( $subject ),
		nl2br( esc_html( $message ) )
	);

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . $from_name . ' <' . get_option( 'admin_email' ) . '>',
	);

	if ( $reply_to && ! empty( $email ) ) {
		$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
	}

	// 6. Send email
	$sent = wp_mail( $recipient, $email_subject, $email_body, $headers );

	if ( ! $sent ) {
		wp_send_json_error( array(
			'message' => 'E-Mail konnte nicht gesendet werden. Bitte versuchen Sie es erneut.',
		), 500 );
	}

	// 7. Save to CPT (if enabled)
	if ( $save_to_cpt ) {
		$post_data = array(
			'post_title'   => wp_strip_all_tags( $name . ' - ' . $subject ),
			'post_content' => $message,
			'post_status'  => 'publish',
			'post_type'    => 'gm_submission',
		);

		$post_id = wp_insert_post( $post_data );

		if ( ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_gm_name', $name );
			update_post_meta( $post_id, '_gm_email', $email );
			update_post_meta( $post_id, '_gm_subject', $subject );
			update_post_meta( $post_id, '_gm_widget_id', $widget_id );
			update_post_meta( $post_id, '_gm_ip', sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ) );
			update_post_meta( $post_id, '_gm_user_agent', sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ?? '' ) );
		}
	}

	// 8. Return success
	wp_send_json_success( array(
		'message' => 'Nachricht erfolgreich gesendet.',
	) );
}
add_action( 'wp_ajax_gm_contact_submit', __NAMESPACE__ . '\handle_contact_submit' );
add_action( 'wp_ajax_nopriv_gm_contact_submit', __NAMESPACE__ . '\handle_contact_submit' );
