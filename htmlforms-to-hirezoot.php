<?php
/**
 * Integração HTML Forms → WP Job Openings (HireZoot)
 *
 * Cria automaticamente um job posting com estado "pending"
 * quando um empregador submete o formulário de vaga.
 *
 * Usar em: Code Snippets ou functions.php de child theme.
 */

// ============================================================
// CONFIGURAÇÃO — editar conforme necessário
// ============================================================

// Slug do formulário no HTML Forms
define( 'ESPRO_HF_FORM_SLUG', 'jobposting' );

// Campos obrigatórios — se algum faltar, a submissão é ignorada
define( 'ESPRO_REQUIRED_FIELDS', array( 'job_title', 'company', 'hr_email', 'job_description', 'consent_terms' ) );

// Mapeamento: campo do formulário → meta key gravada no post
// Ajustar os valores (lado direito) se o HireZoot usar keys diferentes
$espro_meta_map = array(
	'company'         => '_awsm_job_company',
	'hr_email'        => '_awsm_job_hr_email',
	'job_expiry'      => '_awsm_job_expiry',
	'job_location'    => '_awsm_job_location',
	'employment_type' => '_awsm_job_employment_type',
	'salary_range'    => '_awsm_job_salary_range',
	'responsibilities'=> '_awsm_job_responsibilities',
	'requirements'    => '_awsm_job_requirements',
	'benefits'        => '_awsm_job_benefits',
	'application_url' => '_awsm_job_application_url',
	'contact_name'    => '_awsm_job_contact_name',
);

// ============================================================
// LÓGICA — não é necessário editar abaixo desta linha
// ============================================================

add_action( 'hf_form_success', 'espro_create_job_from_form', 10, 2 );

function espro_create_job_from_form( $submission, $form ) {

	// Verificar se é o formulário correto (por slug)
	if ( $form->slug !== ESPRO_HF_FORM_SLUG ) {
		return;
	}

	$data = $submission->data;

	// Validar campos obrigatórios
	foreach ( ESPRO_REQUIRED_FIELDS as $field ) {
		if ( empty( $data[ $field ] ) ) {
			return;
		}
	}

	// Validar consentimento
	if ( empty( $data['consent_terms'] ) ) {
		return;
	}

	// Validar email
	$hr_email = sanitize_email( $data['hr_email'] );
	if ( ! is_email( $hr_email ) ) {
		return;
	}

	// Sanitizar campos de texto
	$job_title   = sanitize_text_field( $data['job_title'] );
	$company     = sanitize_text_field( $data['company'] );
	$job_expiry  = sanitize_text_field( $data['job_expiry'] ?? '' );
	$location    = sanitize_text_field( $data['job_location'] ?? '' );
	$emp_type    = sanitize_text_field( $data['employment_type'] ?? '' );
	$salary      = sanitize_text_field( $data['salary_range'] ?? '' );
	$app_url     = esc_url_raw( $data['application_url'] ?? '' );
	$contact     = sanitize_text_field( $data['contact_name'] ?? '' );

	// Campos ricos — permitir HTML seguro
	$description     = wp_kses_post( $data['job_description'] ?? '' );
	$responsibilities = wp_kses_post( $data['responsibilities'] ?? '' );
	$requirements    = wp_kses_post( $data['requirements'] ?? '' );
	$benefits        = wp_kses_post( $data['benefits'] ?? '' );

	// Construir conteúdo do post
	$content_parts = array();
	if ( $description )      $content_parts[] = $description;
	if ( $responsibilities ) $content_parts[] = "<h3>Responsabilidades</h3>\n" . $responsibilities;
	if ( $requirements )     $content_parts[] = "<h3>Requisitos</h3>\n" . $requirements;
	if ( $benefits )         $content_parts[] = "<h3>Benefícios</h3>\n" . $benefits;

	$post_content = implode( "\n\n", $content_parts );

	// Criar o job posting
	$post_id = wp_insert_post( array(
		'post_type'    => 'awsm_job_openings',
		'post_status'  => 'pending',
		'post_title'   => $job_title,
		'post_content' => $post_content,
	), true );

	if ( is_wp_error( $post_id ) ) {
		error_log( '[ESPRO] Falha ao criar vaga: ' . $post_id->get_error_message() );
		return;
	}

	// Gravar metadados via mapeamento configurável
	global $espro_meta_map;

	$sanitized_values = array(
		'company'          => $company,
		'hr_email'         => $hr_email,
		'job_expiry'       => $job_expiry,
		'job_location'     => $location,
		'employment_type'  => $emp_type,
		'salary_range'     => $salary,
		'responsibilities' => $responsibilities,
		'requirements'     => $requirements,
		'benefits'         => $benefits,
		'application_url'  => $app_url,
		'contact_name'     => $contact,
	);

	foreach ( $espro_meta_map as $field_name => $meta_key ) {
		if ( isset( $sanitized_values[ $field_name ] ) && $sanitized_values[ $field_name ] !== '' ) {
			update_post_meta( $post_id, $meta_key, $sanitized_values[ $field_name ] );
		}
	}

	// Notificar admin por email
	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf( '[Vaga pendente] %s — %s', $job_title, $company );
	$edit_link   = admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	$body = sprintf(
		"Nova vaga submetida para revisão.\n\n" .
		"Título: %s\nEmpresa: %s\nContacto: %s (%s)\nLocalização: %s\n\n" .
		"Rever e aprovar:\n%s",
		$job_title,
		$company,
		$contact,
		$hr_email,
		$location,
		$edit_link
	);

	wp_mail( $admin_email, $subject, $body );
}
