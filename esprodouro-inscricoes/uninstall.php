<?php
/**
 * Uninstall handler — apaga a tabela e as opções do plugin.
 *
 * @package Esprodouro_Inscricoes
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb;

$table = $wpdb->prefix . 'esprodouro_inscricoes';
$wpdb->query( "DROP TABLE IF EXISTS `$table`" );

delete_option( 'esprodouro_inscricoes_db_version' );
delete_option( 'esprodouro_inscricoes_settings' );
