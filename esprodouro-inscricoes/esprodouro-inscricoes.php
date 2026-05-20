<?php
/**
 * Plugin Name:       ESPRODOURO Inscrições
 * Plugin URI:        https://esprodouro.com/
 * Description:       Recolha e gestão de inscrições e contactos do widget de captação da ESPRODOURO. Disponibiliza o shortcode <code>[esprodouro_inscricao]</code> e uma página de administração para consultar e exportar submissões.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            ESPRODOURO
 * Author URI:        https://esprodouro.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       esprodouro-inscricoes
 * Domain Path:       /languages
 *
 * @package Esprodouro_Inscricoes
 */

defined( 'ABSPATH' ) || exit;

define( 'ESPRODOURO_INSCRICOES_VERSION', '1.0.0' );
define( 'ESPRODOURO_INSCRICOES_FILE', __FILE__ );
define( 'ESPRODOURO_INSCRICOES_PATH', plugin_dir_path( __FILE__ ) );
define( 'ESPRODOURO_INSCRICOES_URL', plugin_dir_url( __FILE__ ) );

require_once ESPRODOURO_INSCRICOES_PATH . 'includes/class-database.php';
require_once ESPRODOURO_INSCRICOES_PATH . 'includes/class-form.php';
require_once ESPRODOURO_INSCRICOES_PATH . 'includes/class-privacy.php';
if ( is_admin() ) {
	require_once ESPRODOURO_INSCRICOES_PATH . 'includes/class-admin.php';
}

register_activation_hook( __FILE__, array( 'Esprodouro_Inscricoes_Database', 'install' ) );

add_action( 'plugins_loaded', 'esprodouro_inscricoes_init' );
function esprodouro_inscricoes_init() {
	load_plugin_textdomain(
		'esprodouro-inscricoes',
		false,
		dirname( plugin_basename( ESPRODOURO_INSCRICOES_FILE ) ) . '/languages'
	);

	Esprodouro_Inscricoes_Database::maybe_upgrade();
	new Esprodouro_Inscricoes_Form();
	new Esprodouro_Inscricoes_Privacy();

	if ( is_admin() ) {
		new Esprodouro_Inscricoes_Admin();
	}
}
