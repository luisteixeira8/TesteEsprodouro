<?php
/**
 * Form handler (shortcode + AJAX).
 *
 * @package Esprodouro_Inscricoes
 */

defined( 'ABSPATH' ) || exit;

class Esprodouro_Inscricoes_Form {

	const AJAX_ACTION   = 'esprodouro_inscricao_submit';
	const NONCE_ACTION  = 'esprodouro_inscricao_form';
	const SCRIPT_HANDLE = 'esprodouro-inscricoes-form';
	const STYLE_HANDLE  = 'esprodouro-inscricoes-form';

	public function __construct() {
		add_shortcode( 'esprodouro_inscricao', array( $this, 'render_shortcode' ) );
		add_action( 'wp_ajax_' . self::AJAX_ACTION, array( $this, 'handle_submission' ) );
		add_action( 'wp_ajax_nopriv_' . self::AJAX_ACTION, array( $this, 'handle_submission' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
	}

	public function register_assets() {
		wp_register_style(
			self::STYLE_HANDLE,
			ESPRODOURO_INSCRICOES_URL . 'assets/form.css',
			array(),
			ESPRODOURO_INSCRICOES_VERSION
		);
		wp_register_script(
			self::SCRIPT_HANDLE,
			ESPRODOURO_INSCRICOES_URL . 'assets/form.js',
			array(),
			ESPRODOURO_INSCRICOES_VERSION,
			true
		);
		wp_localize_script(
			self::SCRIPT_HANDLE,
			'esprodouroIns',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'i18n'    => array(
					'submitting'    => __( 'A registar…', 'esprodouro-inscricoes' ),
					'generic_error' => __( 'Não foi possível enviar. Tenta novamente.', 'esprodouro-inscricoes' ),
				),
			)
		);
	}

	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'titulo'    => __( 'Os teus dados', 'esprodouro-inscricoes' ),
				'subtitulo' => __( 'Usados apenas para entrega do brinde e contacto sobre a ESPRODOURO.', 'esprodouro-inscricoes' ),
				'cta'       => __( 'Receber o meu brinde →', 'esprodouro-inscricoes' ),
			),
			$atts,
			'esprodouro_inscricao'
		);

		wp_enqueue_style( self::STYLE_HANDLE );
		wp_enqueue_script( self::SCRIPT_HANDLE );

		$nonce  = wp_create_nonce( self::NONCE_ACTION );
		$origem = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

		ob_start();
		include ESPRODOURO_INSCRICOES_PATH . 'templates/form.php';
		return ob_get_clean();
	}

	public function handle_submission() {
		$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) {
			wp_send_json_error( array( 'message' => __( 'Pedido inválido. Recarrega a página e tenta novamente.', 'esprodouro-inscricoes' ) ), 403 );
		}

		// Honeypot.
		if ( ! empty( $_POST['website'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Pedido bloqueado.', 'esprodouro-inscricoes' ) ), 400 );
		}

		if ( $this->is_rate_limited() ) {
			wp_send_json_error( array( 'message' => __( 'Demasiadas tentativas. Tenta novamente daqui a alguns minutos.', 'esprodouro-inscricoes' ) ), 429 );
		}

		$nome         = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
		$email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$telefone     = $this->sanitize_phone( isset( $_POST['telefone'] ) ? wp_unslash( $_POST['telefone'] ) : '' );
		$enc_nome     = isset( $_POST['enc_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['enc_nome'] ) ) : '';
		$enc_telefone = $this->sanitize_phone( isset( $_POST['enc_telefone'] ) ? wp_unslash( $_POST['enc_telefone'] ) : '' );

		$consent_enc  = ! empty( $_POST['c_enc'] );
		$consent_rgpd = ! empty( $_POST['c_rgpd'] );
		$consent_news = ! empty( $_POST['c_news'] );

		if ( '' === $nome ) {
			wp_send_json_error( array( 'message' => __( 'O nome do aluno é obrigatório.', 'esprodouro-inscricoes' ) ), 400 );
		}
		if ( ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Introduz um email válido.', 'esprodouro-inscricoes' ) ), 400 );
		}
		if ( ! $this->is_valid_phone( $telefone ) ) {
			wp_send_json_error( array( 'message' => __( 'Número do aluno inválido (9 dígitos a começar por 9).', 'esprodouro-inscricoes' ) ), 400 );
		}
		if ( '' === $enc_nome ) {
			wp_send_json_error( array( 'message' => __( 'O nome do encarregado de educação é obrigatório.', 'esprodouro-inscricoes' ) ), 400 );
		}
		if ( ! $this->is_valid_phone( $enc_telefone ) ) {
			wp_send_json_error( array( 'message' => __( 'Número do encarregado inválido (9 dígitos a começar por 9).', 'esprodouro-inscricoes' ) ), 400 );
		}
		if ( ! $consent_enc ) {
			wp_send_json_error( array( 'message' => __( 'É necessária a autorização do encarregado de educação.', 'esprodouro-inscricoes' ) ), 400 );
		}
		if ( ! $consent_rgpd ) {
			wp_send_json_error( array( 'message' => __( 'É necessário aceitar o contacto por WhatsApp.', 'esprodouro-inscricoes' ) ), 400 );
		}

		$data = array(
			'nome'         => $nome,
			'email'        => $email,
			'telefone'     => $telefone,
			'enc_nome'     => $enc_nome,
			'enc_telefone' => $enc_telefone,
			'consent_enc'  => $consent_enc,
			'consent_rgpd' => $consent_rgpd,
			'consent_news' => $consent_news,
			'origem'       => isset( $_POST['origem'] ) ? esc_url_raw( wp_unslash( $_POST['origem'] ) ) : '',
			'ip_address'   => $this->get_ip(),
			'user_agent'   => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 255 ) : '',
		);

		/**
		 * Filter the form data before insertion.
		 *
		 * @param array $data Submission data.
		 */
		$data = apply_filters( 'esprodouro_inscricoes_pre_insert', $data );

		$id = Esprodouro_Inscricoes_Database::insert( $data );

		if ( ! $id ) {
			wp_send_json_error( array( 'message' => __( 'Não foi possível registar a inscrição. Tenta novamente.', 'esprodouro-inscricoes' ) ), 500 );
		}

		/**
		 * Fires after a successful submission.
		 *
		 * @param int   $id   Submission ID.
		 * @param array $data Submission data.
		 */
		do_action( 'esprodouro_inscricoes_after_insert', $id, $data );

		$this->maybe_notify_admin( $id, $data );

		wp_send_json_success( array(
			'id'         => $id,
			'first_name' => strtok( $nome, ' ' ),
			'message'    => __( 'Inscrição registada com sucesso.', 'esprodouro-inscricoes' ),
		) );
	}

	private function sanitize_phone( $phone ) {
		return preg_replace( '/[^0-9+]/', '', (string) $phone );
	}

	private function is_valid_phone( $phone ) {
		return (bool) preg_match( '/^(?:\+?351)?9\d{8}$/', $phone );
	}

	private function get_ip() {
		$candidates = array( 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' );
		foreach ( $candidates as $key ) {
			if ( ! empty( $_SERVER[ $key ] ) ) {
				$val   = sanitize_text_field( wp_unslash( $_SERVER[ $key ] ) );
				$first = trim( explode( ',', $val )[0] );
				if ( filter_var( $first, FILTER_VALIDATE_IP ) ) {
					return $first;
				}
			}
		}
		return '';
	}

	private function is_rate_limited() {
		$ip = $this->get_ip();
		if ( '' === $ip ) {
			return false;
		}
		$key   = 'esprodouro_ins_rl_' . md5( $ip );
		$count = (int) get_transient( $key );
		if ( $count >= 5 ) {
			return true;
		}
		set_transient( $key, $count + 1, 5 * MINUTE_IN_SECONDS );
		return false;
	}

	private function maybe_notify_admin( $id, $data ) {
		$opts = get_option( 'esprodouro_inscricoes_settings', array() );
		if ( empty( $opts['notify_email'] ) ) {
			return;
		}
		$to = sanitize_email( $opts['notify_email'] );
		if ( ! is_email( $to ) ) {
			return;
		}

		$subject = sprintf(
			/* translators: 1: ID, 2: name */
			__( '[ESPRODOURO] Nova inscrição #%1$d — %2$s', 'esprodouro-inscricoes' ),
			$id,
			$data['nome']
		);
		$admin_url = admin_url( 'admin.php?page=esprodouro-inscricoes&view=' . (int) $id );
		$body      = sprintf(
			"Nome: %s\nEmail: %s\nTelefone: %s\nEncarregado: %s\nContacto enc.: %s\n\nVer: %s",
			$data['nome'],
			$data['email'],
			$data['telefone'],
			$data['enc_nome'],
			$data['enc_telefone'],
			$admin_url
		);
		wp_mail( $to, $subject, $body );
	}
}
