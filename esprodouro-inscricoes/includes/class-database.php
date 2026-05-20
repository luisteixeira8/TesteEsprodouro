<?php
/**
 * Database layer.
 *
 * @package Esprodouro_Inscricoes
 */

defined( 'ABSPATH' ) || exit;

class Esprodouro_Inscricoes_Database {

	const TABLE             = 'esprodouro_inscricoes';
	const DB_VERSION        = '1.0.0';
	const DB_VERSION_OPTION = 'esprodouro_inscricoes_db_version';

	public static function table_name() {
		global $wpdb;
		return $wpdb->prefix . self::TABLE;
	}

	public static function install() {
		global $wpdb;
		$table           = self::table_name();
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			nome VARCHAR(150) NOT NULL,
			email VARCHAR(150) NOT NULL,
			telefone VARCHAR(40) NOT NULL,
			enc_nome VARCHAR(150) NOT NULL,
			enc_telefone VARCHAR(40) NOT NULL,
			consent_enc TINYINT(1) NOT NULL DEFAULT 0,
			consent_rgpd TINYINT(1) NOT NULL DEFAULT 0,
			consent_news TINYINT(1) NOT NULL DEFAULT 0,
			origem VARCHAR(255) DEFAULT NULL,
			ip_address VARCHAR(45) DEFAULT NULL,
			user_agent VARCHAR(255) DEFAULT NULL,
			status VARCHAR(20) NOT NULL DEFAULT 'novo',
			notas TEXT DEFAULT NULL,
			PRIMARY KEY  (id),
			KEY idx_created (created_at),
			KEY idx_email (email),
			KEY idx_status (status)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		update_option( self::DB_VERSION_OPTION, self::DB_VERSION );
	}

	public static function maybe_upgrade() {
		if ( get_option( self::DB_VERSION_OPTION ) !== self::DB_VERSION ) {
			self::install();
		}
	}

	public static function insert( $data ) {
		global $wpdb;
		$result = $wpdb->insert(
			self::table_name(),
			array(
				'created_at'   => current_time( 'mysql' ),
				'nome'         => $data['nome'],
				'email'        => $data['email'],
				'telefone'     => $data['telefone'],
				'enc_nome'     => $data['enc_nome'],
				'enc_telefone' => $data['enc_telefone'],
				'consent_enc'  => ! empty( $data['consent_enc'] ) ? 1 : 0,
				'consent_rgpd' => ! empty( $data['consent_rgpd'] ) ? 1 : 0,
				'consent_news' => ! empty( $data['consent_news'] ) ? 1 : 0,
				'origem'       => isset( $data['origem'] ) ? $data['origem'] : null,
				'ip_address'   => isset( $data['ip_address'] ) ? $data['ip_address'] : null,
				'user_agent'   => isset( $data['user_agent'] ) ? $data['user_agent'] : null,
			),
			array( '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s' )
		);
		return $result ? (int) $wpdb->insert_id : false;
	}

	public static function get( $id ) {
		global $wpdb;
		return $wpdb->get_row(
			$wpdb->prepare( 'SELECT * FROM ' . self::table_name() . ' WHERE id = %d', (int) $id )
		);
	}

	public static function delete( $id ) {
		global $wpdb;
		return $wpdb->delete( self::table_name(), array( 'id' => (int) $id ), array( '%d' ) );
	}

	public static function update_status( $id, $status ) {
		global $wpdb;
		return $wpdb->update(
			self::table_name(),
			array( 'status' => sanitize_text_field( $status ) ),
			array( 'id' => (int) $id ),
			array( '%s' ),
			array( '%d' )
		);
	}

	public static function query( $args = array() ) {
		global $wpdb;
		$defaults = array(
			'per_page' => 25,
			'page'     => 1,
			'orderby'  => 'created_at',
			'order'    => 'DESC',
			'search'   => '',
			'status'   => '',
		);
		$args  = wp_parse_args( $args, $defaults );
		$table = self::table_name();

		$where  = '1=1';
		$params = array();

		if ( '' !== $args['search'] ) {
			$like   = '%' . $wpdb->esc_like( $args['search'] ) . '%';
			$where .= ' AND ( nome LIKE %s OR email LIKE %s OR telefone LIKE %s OR enc_nome LIKE %s OR enc_telefone LIKE %s )';
			array_push( $params, $like, $like, $like, $like, $like );
		}
		if ( '' !== $args['status'] ) {
			$where   .= ' AND status = %s';
			$params[] = $args['status'];
		}

		$allowed_orderby = array( 'created_at', 'nome', 'email', 'status' );
		$orderby         = in_array( $args['orderby'], $allowed_orderby, true ) ? $args['orderby'] : 'created_at';
		$order           = strtoupper( $args['order'] ) === 'ASC' ? 'ASC' : 'DESC';

		$per_page = max( 1, (int) $args['per_page'] );
		$offset   = ( max( 1, (int) $args['page'] ) - 1 ) * $per_page;

		$count_sql = "SELECT COUNT(*) FROM $table WHERE $where";
		$rows_sql  = "SELECT * FROM $table WHERE $where ORDER BY $orderby $order LIMIT %d OFFSET %d";

		if ( ! empty( $params ) ) {
			$total = (int) $wpdb->get_var( $wpdb->prepare( $count_sql, $params ) );
			$rows  = $wpdb->get_results( $wpdb->prepare( $rows_sql, array_merge( $params, array( $per_page, $offset ) ) ) );
		} else {
			$total = (int) $wpdb->get_var( $count_sql );
			$rows  = $wpdb->get_results( $wpdb->prepare( $rows_sql, $per_page, $offset ) );
		}

		return array( 'rows' => $rows, 'total' => $total );
	}

	public static function get_all_for_export() {
		global $wpdb;
		return $wpdb->get_results( 'SELECT * FROM ' . self::table_name() . ' ORDER BY created_at DESC' );
	}
}
