<?php
/**
 * RGPD / Privacy integration.
 *
 * @package Esprodouro_Inscricoes
 */

defined( 'ABSPATH' ) || exit;

class Esprodouro_Inscricoes_Privacy {

	public function __construct() {
		add_filter( 'wp_privacy_personal_data_exporters', array( $this, 'register_exporter' ) );
		add_filter( 'wp_privacy_personal_data_erasers', array( $this, 'register_eraser' ) );
		add_action( 'admin_init', array( $this, 'add_policy_content' ) );
	}

	public function register_exporter( $exporters ) {
		$exporters['esprodouro-inscricoes'] = array(
			'exporter_friendly_name' => __( 'ESPRODOURO Inscrições', 'esprodouro-inscricoes' ),
			'callback'               => array( $this, 'export' ),
		);
		return $exporters;
	}

	public function register_eraser( $erasers ) {
		$erasers['esprodouro-inscricoes'] = array(
			'eraser_friendly_name' => __( 'ESPRODOURO Inscrições', 'esprodouro-inscricoes' ),
			'callback'             => array( $this, 'erase' ),
		);
		return $erasers;
	}

	public function export( $email_address, $page = 1 ) {
		global $wpdb;
		$table = Esprodouro_Inscricoes_Database::table_name();
		$rows  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table WHERE email = %s", $email_address ) );

		$data_to_export = array();
		foreach ( $rows as $r ) {
			$data_to_export[] = array(
				'group_id'    => 'esprodouro-inscricoes',
				'group_label' => __( 'Inscrições ESPRODOURO', 'esprodouro-inscricoes' ),
				'item_id'     => 'inscricao-' . $r->id,
				'data'        => array(
					array( 'name' => __( 'Data', 'esprodouro-inscricoes' ),             'value' => $r->created_at ),
					array( 'name' => __( 'Nome', 'esprodouro-inscricoes' ),             'value' => $r->nome ),
					array( 'name' => __( 'Email', 'esprodouro-inscricoes' ),            'value' => $r->email ),
					array( 'name' => __( 'Telefone', 'esprodouro-inscricoes' ),         'value' => $r->telefone ),
					array( 'name' => __( 'Encarregado', 'esprodouro-inscricoes' ),      'value' => $r->enc_nome ),
					array( 'name' => __( 'Tel. encarregado', 'esprodouro-inscricoes' ), 'value' => $r->enc_telefone ),
					array( 'name' => __( 'IP', 'esprodouro-inscricoes' ),               'value' => $r->ip_address ),
				),
			);
		}
		return array( 'data' => $data_to_export, 'done' => true );
	}

	public function erase( $email_address, $page = 1 ) {
		global $wpdb;
		$table   = Esprodouro_Inscricoes_Database::table_name();
		$deleted = $wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE email = %s", $email_address ) );
		return array(
			'items_removed'  => (int) $deleted,
			'items_retained' => 0,
			'messages'       => array(),
			'done'           => true,
		);
	}

	public function add_policy_content() {
		if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
			return;
		}
		$content = wp_kses_post(
			__( '<p>O plugin <strong>ESPRODOURO Inscrições</strong> armazena os dados submetidos no formulário de inscrição: nome, email, telefone do aluno, nome e telefone do encarregado de educação, registos de consentimento, endereço IP e user agent. Estes dados são utilizados exclusivamente para fins de contacto sobre a oferta educativa da ESPRODOURO. Para exportar ou apagar os teus dados, contacta-nos em geral@esprodouro.com.</p>', 'esprodouro-inscricoes' )
		);
		wp_add_privacy_policy_content( __( 'ESPRODOURO Inscrições', 'esprodouro-inscricoes' ), $content );
	}
}
