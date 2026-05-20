<?php
/**
 * Admin pages.
 *
 * @package Esprodouro_Inscricoes
 */

defined( 'ABSPATH' ) || exit;

class Esprodouro_Inscricoes_Admin {

	const CAPABILITY    = 'manage_options';
	const PAGE_SLUG     = 'esprodouro-inscricoes';
	const SETTINGS_SLUG = 'esprodouro-inscricoes-settings';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_post_esprodouro_inscricoes_export', array( $this, 'export_csv' ) );
		add_action( 'admin_post_esprodouro_inscricoes_delete', array( $this, 'delete_submission' ) );
		add_action( 'admin_post_esprodouro_inscricoes_status', array( $this, 'update_status' ) );
	}

	public function enqueue_assets( $hook ) {
		if ( false === strpos( $hook, self::PAGE_SLUG ) ) {
			return;
		}
		wp_enqueue_style(
			'esprodouro-inscricoes-admin',
			ESPRODOURO_INSCRICOES_URL . 'assets/admin.css',
			array(),
			ESPRODOURO_INSCRICOES_VERSION
		);
	}

	public function register_menu() {
		add_menu_page(
			__( 'ESPRODOURO Inscrições', 'esprodouro-inscricoes' ),
			__( 'Inscrições', 'esprodouro-inscricoes' ),
			self::CAPABILITY,
			self::PAGE_SLUG,
			array( $this, 'render_page' ),
			'dashicons-list-view',
			30
		);
		add_submenu_page(
			self::PAGE_SLUG,
			__( 'Inscrições', 'esprodouro-inscricoes' ),
			__( 'Todas', 'esprodouro-inscricoes' ),
			self::CAPABILITY,
			self::PAGE_SLUG,
			array( $this, 'render_page' )
		);
		add_submenu_page(
			self::PAGE_SLUG,
			__( 'Definições', 'esprodouro-inscricoes' ),
			__( 'Definições', 'esprodouro-inscricoes' ),
			self::CAPABILITY,
			self::SETTINGS_SLUG,
			array( $this, 'render_settings' )
		);
	}

	public function register_settings() {
		register_setting(
			'esprodouro_inscricoes_settings_group',
			'esprodouro_inscricoes_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
				'default'           => array( 'notify_email' => '' ),
			)
		);
	}

	public function sanitize_settings( $input ) {
		$out                 = array();
		$out['notify_email'] = isset( $input['notify_email'] ) ? sanitize_email( $input['notify_email'] ) : '';
		return $out;
	}

	public function render_page() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'Sem permissões.', 'esprodouro-inscricoes' ) );
		}

		$view_id = isset( $_GET['view'] ) ? (int) $_GET['view'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( $view_id ) {
			$this->render_detail( $view_id );
			return;
		}

		$search = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$page   = isset( $_GET['paged'] ) ? max( 1, (int) $_GET['paged'] ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$result = Esprodouro_Inscricoes_Database::query( array(
			'per_page' => 25,
			'page'     => $page,
			'search'   => $search,
			'status'   => $status,
		) );

		$rows  = $result['rows'];
		$total = $result['total'];
		$pages = max( 1, (int) ceil( $total / 25 ) );

		?>
		<div class="wrap esprodouro-inscricoes">
			<h1 class="wp-heading-inline">
				<?php esc_html_e( 'Inscrições ESPRODOURO', 'esprodouro-inscricoes' ); ?>
				<span class="title-count"><?php echo (int) $total; ?></span>
			</h1>
			<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=esprodouro_inscricoes_export' ), 'esprodouro_inscricoes_export' ) ); ?>" class="page-title-action">
				<?php esc_html_e( 'Exportar CSV', 'esprodouro-inscricoes' ); ?>
			</a>
			<hr class="wp-header-end">

			<?php if ( isset( $_GET['deleted'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Inscrição eliminada.', 'esprodouro-inscricoes' ); ?></p></div>
			<?php endif; ?>

			<form method="get" class="esprodouro-filters">
				<input type="hidden" name="page" value="<?php echo esc_attr( self::PAGE_SLUG ); ?>">
				<select name="status">
					<option value=""><?php esc_html_e( 'Todos os estados', 'esprodouro-inscricoes' ); ?></option>
					<?php foreach ( $this->statuses() as $key => $label ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="search" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Procurar nome, email, telefone…', 'esprodouro-inscricoes' ); ?>">
				<button type="submit" class="button"><?php esc_html_e( 'Filtrar', 'esprodouro-inscricoes' ); ?></button>
				<?php if ( $search || $status ) : ?>
					<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=' . self::PAGE_SLUG ) ); ?>"><?php esc_html_e( 'Limpar', 'esprodouro-inscricoes' ); ?></a>
				<?php endif; ?>
			</form>

			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Data', 'esprodouro-inscricoes' ); ?></th>
						<th><?php esc_html_e( 'Nome', 'esprodouro-inscricoes' ); ?></th>
						<th><?php esc_html_e( 'Email', 'esprodouro-inscricoes' ); ?></th>
						<th><?php esc_html_e( 'Telefone', 'esprodouro-inscricoes' ); ?></th>
						<th><?php esc_html_e( 'Encarregado', 'esprodouro-inscricoes' ); ?></th>
						<th><?php esc_html_e( 'Estado', 'esprodouro-inscricoes' ); ?></th>
						<th><?php esc_html_e( 'Ações', 'esprodouro-inscricoes' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $rows ) ) : ?>
						<tr><td colspan="7"><?php esc_html_e( 'Sem inscrições.', 'esprodouro-inscricoes' ); ?></td></tr>
					<?php else : ?>
						<?php foreach ( $rows as $row ) :
							$view_url = admin_url( 'admin.php?page=' . self::PAGE_SLUG . '&view=' . (int) $row->id );
							?>
							<tr>
								<td><?php echo esc_html( mysql2date( 'd/m/Y H:i', $row->created_at ) ); ?></td>
								<td><strong><a href="<?php echo esc_url( $view_url ); ?>"><?php echo esc_html( $row->nome ); ?></a></strong></td>
								<td><a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a></td>
								<td><?php echo esc_html( $row->telefone ); ?></td>
								<td><?php echo esc_html( $row->enc_nome ); ?></td>
								<td><span class="esprodouro-status esprodouro-status--<?php echo esc_attr( $row->status ); ?>"><?php echo esc_html( $this->status_label( $row->status ) ); ?></span></td>
								<td><a class="button button-small" href="<?php echo esc_url( $view_url ); ?>"><?php esc_html_e( 'Ver', 'esprodouro-inscricoes' ); ?></a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>

			<?php if ( $pages > 1 ) : ?>
				<div class="tablenav bottom">
					<div class="tablenav-pages">
						<?php
						echo wp_kses_post( paginate_links( array(
							'base'      => add_query_arg( 'paged', '%#%' ),
							'format'    => '',
							'current'   => $page,
							'total'     => $pages,
							'prev_text' => '‹',
							'next_text' => '›',
						) ) );
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	private function render_detail( $id ) {
		$row = Esprodouro_Inscricoes_Database::get( $id );
		if ( ! $row ) {
			wp_die( esc_html__( 'Inscrição não encontrada.', 'esprodouro-inscricoes' ) );
		}
		?>
		<div class="wrap esprodouro-inscricoes">
			<h1 class="wp-heading-inline">
				<?php echo esc_html( sprintf( /* translators: %d: ID */ __( 'Inscrição #%d', 'esprodouro-inscricoes' ), (int) $row->id ) ); ?>
			</h1>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=' . self::PAGE_SLUG ) ); ?>" class="page-title-action"><?php esc_html_e( '← Todas', 'esprodouro-inscricoes' ); ?></a>
			<hr class="wp-header-end">

			<?php if ( isset( $_GET['updated'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Estado atualizado.', 'esprodouro-inscricoes' ); ?></p></div>
			<?php endif; ?>

			<div class="esprodouro-detail">
				<table class="form-table">
					<tr><th><?php esc_html_e( 'Data', 'esprodouro-inscricoes' ); ?></th><td><?php echo esc_html( mysql2date( 'd/m/Y H:i', $row->created_at ) ); ?></td></tr>
					<tr><th><?php esc_html_e( 'Nome do aluno', 'esprodouro-inscricoes' ); ?></th><td><?php echo esc_html( $row->nome ); ?></td></tr>
					<tr><th><?php esc_html_e( 'Email', 'esprodouro-inscricoes' ); ?></th><td><a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a></td></tr>
					<tr><th><?php esc_html_e( 'Telefone', 'esprodouro-inscricoes' ); ?></th><td><a href="tel:<?php echo esc_attr( $row->telefone ); ?>"><?php echo esc_html( $row->telefone ); ?></a></td></tr>
					<tr><th><?php esc_html_e( 'Nome do encarregado', 'esprodouro-inscricoes' ); ?></th><td><?php echo esc_html( $row->enc_nome ); ?></td></tr>
					<tr><th><?php esc_html_e( 'Contacto do encarregado', 'esprodouro-inscricoes' ); ?></th><td><a href="tel:<?php echo esc_attr( $row->enc_telefone ); ?>"><?php echo esc_html( $row->enc_telefone ); ?></a></td></tr>
					<tr><th><?php esc_html_e( 'Consentimentos', 'esprodouro-inscricoes' ); ?></th><td>
						<?php echo $row->consent_enc  ? '✔ ' : '✘ '; ?><?php esc_html_e( 'Encarregado de educação', 'esprodouro-inscricoes' ); ?><br>
						<?php echo $row->consent_rgpd ? '✔ ' : '✘ '; ?><?php esc_html_e( 'Contacto WhatsApp', 'esprodouro-inscricoes' ); ?><br>
						<?php echo $row->consent_news ? '✔ ' : '✘ '; ?><?php esc_html_e( 'Newsletter', 'esprodouro-inscricoes' ); ?>
					</td></tr>
					<tr><th><?php esc_html_e( 'Origem', 'esprodouro-inscricoes' ); ?></th><td><?php echo $row->origem ? '<a href="' . esc_url( $row->origem ) . '" target="_blank" rel="noopener">' . esc_html( $row->origem ) . '</a>' : '—'; ?></td></tr>
					<tr><th><?php esc_html_e( 'IP', 'esprodouro-inscricoes' ); ?></th><td><?php echo esc_html( $row->ip_address ? $row->ip_address : '—' ); ?></td></tr>
					<tr><th><?php esc_html_e( 'User agent', 'esprodouro-inscricoes' ); ?></th><td><code><?php echo esc_html( $row->user_agent ? $row->user_agent : '—' ); ?></code></td></tr>
				</table>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="esprodouro-action-form">
					<?php wp_nonce_field( 'esprodouro_inscricoes_status_' . $row->id ); ?>
					<input type="hidden" name="action" value="esprodouro_inscricoes_status">
					<input type="hidden" name="id" value="<?php echo (int) $row->id; ?>">
					<select name="status">
						<?php foreach ( $this->statuses() as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $row->status, $key ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<button type="submit" class="button button-primary"><?php esc_html_e( 'Atualizar estado', 'esprodouro-inscricoes' ); ?></button>
				</form>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="esprodouro-action-form" onsubmit="return confirm('<?php echo esc_js( __( 'Eliminar esta inscrição? Esta ação é irreversível.', 'esprodouro-inscricoes' ) ); ?>');">
					<?php wp_nonce_field( 'esprodouro_inscricoes_delete_' . $row->id ); ?>
					<input type="hidden" name="action" value="esprodouro_inscricoes_delete">
					<input type="hidden" name="id" value="<?php echo (int) $row->id; ?>">
					<button type="submit" class="button button-link-delete"><?php esc_html_e( 'Eliminar', 'esprodouro-inscricoes' ); ?></button>
				</form>
			</div>
		</div>
		<?php
	}

	public function render_settings() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'Sem permissões.', 'esprodouro-inscricoes' ) );
		}
		$opts         = get_option( 'esprodouro_inscricoes_settings', array() );
		$notify_email = isset( $opts['notify_email'] ) ? $opts['notify_email'] : '';
		?>
		<div class="wrap esprodouro-inscricoes">
			<h1><?php esc_html_e( 'Definições — ESPRODOURO Inscrições', 'esprodouro-inscricoes' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'esprodouro_inscricoes_settings_group' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="esprodouro-notify-email"><?php esc_html_e( 'Notificar por email', 'esprodouro-inscricoes' ); ?></label></th>
						<td>
							<input type="email" id="esprodouro-notify-email" name="esprodouro_inscricoes_settings[notify_email]" value="<?php echo esc_attr( $notify_email ); ?>" class="regular-text">
							<p class="description"><?php esc_html_e( 'Endereço que recebe notificações de novas inscrições. Deixar em branco para desativar.', 'esprodouro-inscricoes' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Shortcode', 'esprodouro-inscricoes' ); ?></th>
						<td><code>[esprodouro_inscricao]</code><p class="description"><?php esc_html_e( 'Atributos opcionais: titulo, subtitulo, cta.', 'esprodouro-inscricoes' ); ?></p></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	public function export_csv() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'Sem permissões.', 'esprodouro-inscricoes' ) );
		}
		check_admin_referer( 'esprodouro_inscricoes_export' );

		$rows = Esprodouro_Inscricoes_Database::get_all_for_export();

		$filename = 'esprodouro-inscricoes-' . gmdate( 'Y-m-d-Hi' ) . '.csv';
		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . $filename );

		$out = fopen( 'php://output', 'w' );
		fwrite( $out, "\xEF\xBB\xBF" ); // UTF-8 BOM for Excel compatibility.
		fputcsv( $out, array( 'ID', 'Data', 'Nome', 'Email', 'Telefone', 'Encarregado', 'Tel. encarregado', 'Consent. enc.', 'Consent. RGPD', 'Newsletter', 'Origem', 'IP', 'Estado' ) );
		foreach ( $rows as $r ) {
			fputcsv( $out, array(
				$r->id,
				$r->created_at,
				$r->nome,
				$r->email,
				$r->telefone,
				$r->enc_nome,
				$r->enc_telefone,
				$r->consent_enc ? 'sim' : 'não',
				$r->consent_rgpd ? 'sim' : 'não',
				$r->consent_news ? 'sim' : 'não',
				$r->origem,
				$r->ip_address,
				$r->status,
			) );
		}
		fclose( $out );
		exit;
	}

	public function delete_submission() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'Sem permissões.', 'esprodouro-inscricoes' ) );
		}
		$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		check_admin_referer( 'esprodouro_inscricoes_delete_' . $id );

		Esprodouro_Inscricoes_Database::delete( $id );
		wp_safe_redirect( add_query_arg(
			array( 'page' => self::PAGE_SLUG, 'deleted' => 1 ),
			admin_url( 'admin.php' )
		) );
		exit;
	}

	public function update_status() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'Sem permissões.', 'esprodouro-inscricoes' ) );
		}
		$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		check_admin_referer( 'esprodouro_inscricoes_status_' . $id );

		$status = isset( $_POST['status'] ) ? sanitize_text_field( wp_unslash( $_POST['status'] ) ) : 'novo';
		if ( ! array_key_exists( $status, $this->statuses() ) ) {
			$status = 'novo';
		}
		Esprodouro_Inscricoes_Database::update_status( $id, $status );

		wp_safe_redirect( add_query_arg(
			array( 'page' => self::PAGE_SLUG, 'view' => $id, 'updated' => 1 ),
			admin_url( 'admin.php' )
		) );
		exit;
	}

	private function statuses() {
		return array(
			'novo'       => __( 'Novo', 'esprodouro-inscricoes' ),
			'contactado' => __( 'Contactado', 'esprodouro-inscricoes' ),
			'inscrito'   => __( 'Inscrito', 'esprodouro-inscricoes' ),
			'descartado' => __( 'Descartado', 'esprodouro-inscricoes' ),
		);
	}

	private function status_label( $status ) {
		$s = $this->statuses();
		return isset( $s[ $status ] ) ? $s[ $status ] : $status;
	}
}
