<?php
/**
 * Plugin Name: ESPRODOURO Captação
 * Description: Widgets Elementor para a plataforma de captação ESPRODOURO — campanhas WhatsApp
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Requires at least: 6.0
 * Author: ESPRODOURO
 * Text Domain: esprodouro
 * Elementor tested up to: 3.25
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ESPRO_VERSION', '1.0.0' );
define( 'ESPRO_PATH', plugin_dir_path( __FILE__ ) );
define( 'ESPRO_URL', plugin_dir_url( __FILE__ ) );

/* ── Dados das 6 campanhas ────────────────────────────────────── */

function espro_campaigns() {
    return [
        'decoder' => [
            'num'            => '01 / 06',
            'audience'       => 'jovem',
            'audience_label' => 'Jovem · 14–16 anos',
            'title'          => 'Douro <em>Decoder</em>',
            'title_plain'    => 'Douro Decoder',
            'short'          => 'Quiz identitário em 3 minutos',
            'description'    => 'Em 7 perguntas, descobres que tipo de profissional vive dentro de ti — a partir das tuas respostas, não de catálogos.',
            'narrative'      => [
                'Ninguém escolhe um curso porque viu uma brochura. Escolhe-se quando se reconhece — quando uma frase nos descreve com uma exatidão que não esperávamos.',
                'O Douro Decoder é um quiz curto, sem respostas certas, que devolve um perfil profissional escrito sobre ti. Demora menos do que ouvires uma música. Recebes o teu perfil completo no WhatsApp, com o caminho que pode ser teu — se quiseres.',
                'Não é teste de orientação. É um espelho.',
            ],
            'meta' => [
                [ 'label' => 'Duração',   'val' => '3 minutos' ],
                [ 'label' => 'Formato',   'val' => 'WhatsApp' ],
                [ 'label' => 'Resultado', 'val' => '6 perfis possíveis' ],
            ],
            'form_title' => 'Começa o <em>quiz</em>',
            'form_sub'   => 'Recebes a primeira pergunta no WhatsApp em menos de 60 segundos.',
            'role'        => 'jovem',
            'cta'         => 'Receber a primeira pergunta',
            'wa_messages' => [
                'Olá <strong>{nome}</strong>. Encontraste o Douro Decoder.',
                'Em 3 minutos vou ajudar-te a descobrir que tipo de profissional vives dentro de ti — a partir das tuas respostas, não das nossas perguntas tradicionais. Vamos a isto?',
                'Não há respostas certas. Há só a tua resposta. Pronto?',
            ],
        ],
        'sussurro' => [
            'num'            => '02 / 06',
            'audience'       => 'jovem',
            'audience_label' => 'Jovem · 14–16 anos',
            'title'          => 'Sussurro do <em>Douro</em>',
            'title_plain'    => 'Sussurro do Douro',
            'short'          => 'Linha confidente sobre o teu futuro',
            'description'    => 'Tens dúvidas sobre o teu futuro que não te apetece perguntar em frente da turma? Aqui podes perguntar sem te identificares.',
            'narrative'      => [
                'Há perguntas que não fazemos em voz alta. Não por sermos tímidos — por sabermos que o sítio onde estamos não é o sítio certo para as fazer.',
                'O Sussurro do Douro é uma linha de WhatsApp onde podes perguntar qualquer coisa sobre o teu futuro profissional sem teres de te identificar. Responde-te uma pessoa real, em horário definido. Sem agenda comercial. Sem vergonha de não saber.',
                'Só perguntas. Eu respondo.',
            ],
            'meta' => [
                [ 'label' => 'Atendimento',   'val' => '16h–19h · dias úteis' ],
                [ 'label' => 'Resposta',       'val' => 'Sob 2 horas' ],
                [ 'label' => 'Identificação',  'val' => 'Não obrigatória' ],
            ],
            'form_title' => 'Abre uma <em>conversa</em>',
            'form_sub'   => 'Não precisas de te identificar para enviar a primeira mensagem.',
            'role'        => 'jovem',
            'cta'         => 'Iniciar conversa',
            'wa_messages' => [
                'Olá. Encontraste o Sussurro do Douro.',
                'Aqui podes perguntar qualquer coisa sobre o teu futuro profissional sem teres de te identificar. Não tens de dizer quem és.',
                'O que te traz cá hoje?',
            ],
        ],
        'cromos' => [
            'num'            => '03 / 06',
            'audience'       => 'jovem',
            'audience_label' => 'Jovem · 14–16 anos',
            'title'          => 'Caça ao <em>Cromo</em> do Douro',
            'title_plain'    => 'Caça ao Cromo do Douro',
            'short'          => '30 cromos. 8 semanas. 1 dia VIP.',
            'description'    => 'Coleção digital de 30 cromos sobre o Douro — desbloqueias com desafios semanais. Coleção completa = dia VIP na ESPRODOURO.',
            'narrative'      => [
                'Uma vinha que resiste há 100 anos. Uma profissão que ainda não tem nome. Um miradouro que ninguém te mostrou. Trinta cromos sobre o Douro que ninguém te contou.',
                'Cada cromo desbloqueia-se com um desafio semanal — uma foto, uma resposta, uma micro-curiosidade. Os 50 melhores classificados recebem um kit ESPRODOURO. Quem completar a coleção tem direito a um dia VIP — laboratórios, almoço gourmet, encontro com a Direção.',
                'Coleciona o Douro que te pertence.',
            ],
            'meta' => [
                [ 'label' => 'Duração',     'val' => '8 semanas' ],
                [ 'label' => 'Cromos',      'val' => '30 raridades' ],
                [ 'label' => 'Prémio máx.', 'val' => 'Dia VIP' ],
            ],
            'form_title' => 'Começa a <em>coleção</em>',
            'form_sub'   => 'Recebes o primeiro cromo no WhatsApp imediatamente após a inscrição.',
            'role'        => 'jovem',
            'cta'         => 'Quero o primeiro cromo',
            'wa_messages' => [
                'Olá <strong>{nome}</strong>. Bem-vindo(a) à Caça ao Cromo do Douro.',
                'Cromo 1 de 30 — A Vinha que Resiste. Sabias que há vinhas no Douro com mais de 100 anos a produzir?',
                'O teu primeiro desafio chega amanhã às 18h. Se completares, desbloqueias o Cromo 2.',
            ],
        ],
        'sabias' => [
            'num'            => '04 / 06',
            'audience'       => 'familia',
            'audience_label' => 'Encarregado de educação',
            'title'          => 'Sabias <em>Que...</em>',
            'title_plain'    => 'Sabias Que...',
            'short'          => 'Uma curiosidade por semana. 60 segundos de leitura.',
            'description'    => 'Curiosidades semanais sobre educação, mercado de trabalho e neurodesenvolvimento adolescente. Sem spam. Sem venda.',
            'narrative'      => [
                'Uma curiosidade por semana. Sessenta segundos de leitura. Sempre à quarta-feira, às 21h, depois do jantar.',
                'A rubrica "Sabias Que..." é uma série semanal de pequenos textos sobre educação, neurodesenvolvimento adolescente e mercado de trabalho regional. Pensada para encarregados de educação que querem perceber o que está em jogo sem terem de ler tratados.',
                'Não há agenda comercial. Para descontinuar, basta uma palavra.',
            ],
            'meta' => [
                [ 'label' => 'Frequência', 'val' => 'Semanal · 4.ª feira 21h' ],
                [ 'label' => 'Duração',    'val' => '60 segundos' ],
                [ 'label' => 'Custo',      'val' => 'Gratuito' ],
            ],
            'form_title' => 'Subscrever <em>"Sabias Que..."</em>',
            'form_sub'   => 'Receberá a primeira mensagem imediatamente.',
            'role'        => 'familia',
            'cta'         => 'Subscrever',
            'wa_messages' => [
                'Olá <strong>{nome}</strong>. Bem-vindo(a) ao "Sabias Que...".',
                'À quarta-feira às 21h chega uma curiosidade de 60 segundos sobre educação, futuro profissional ou neurodesenvolvimento adolescente. Para descontinuar, escreva STOP.',
                'Para começar: sabia que a decisão pelo ensino profissional tem hoje 34% de taxa de progressão para o ensino superior — superior à de muitos cursos científico-humanísticos?',
            ],
        ],
        'conversas' => [
            'num'            => '05 / 06',
            'audience'       => 'familia',
            'audience_label' => 'Encarregado de educação',
            'title'          => '5 Conversas <em>importantes</em>',
            'title_plain'    => '5 Conversas importantes',
            'short'          => 'Mini-curso parental em 5 dias',
            'description'    => 'Cinco guiões para as cinco conversas que vai querer ter com o seu filho de 14 anos sobre o futuro.',
            'narrative'      => [
                'Há conversas que sabemos que devíamos ter com os filhos — sobre o futuro, sobre o que os assusta, sobre o que esperam de nós. Mas não sabemos por onde começar. Receamos errar. Adiamos.',
                'Este mini-curso entrega-lhe, em cinco dias, cinco guiões concretos para as cinco conversas mais importantes que pode ter com o seu filho de 14 anos sobre o futuro. Um guião por dia, no WhatsApp. Com perguntas a fazer, erros a evitar, respostas esperadas.',
                'Construído com base em metodologias de comunicação parental fundamentadas em evidência.',
            ],
            'meta' => [
                [ 'label' => 'Duração',   'val' => '5 dias · 1 por dia' ],
                [ 'label' => 'Tempo/dia', 'val' => '5 minutos' ],
                [ 'label' => 'Base',      'val' => 'Evidência científica' ],
            ],
            'form_title' => 'Começar o <em>mini-curso</em>',
            'form_sub'   => 'O primeiro guião chega ao seu WhatsApp em menos de 60 segundos.',
            'role'        => 'familia',
            'cta'         => 'Receber o primeiro guião',
            'wa_messages' => [
                'Olá <strong>{nome}</strong>. Bem-vindo(a) ao mini-curso.',
                'Recebeu o primeiro dos 5 guiões. Cada dia, à mesma hora, chega o seguinte.',
                'Dia 1 — "O que te assusta no futuro? E o que te entusiasma?" Este é o guião para abrir o canal emocional.',
            ],
        ],
        'calendario' => [
            'num'            => '06 / 06',
            'audience'       => 'familia',
            'audience_label' => 'Encarregado de educação',
            'title'          => 'Calendário do <em>9.º ano</em>',
            'title_plain'    => 'Calendário do 9.º ano',
            'short'          => 'Que decisões aí vêm. Mês a mês.',
            'description'    => 'Receba todos os meses os 4 marcos importantes para a decisão escolar do seu filho. Sem spam.',
            'narrative'      => [
                'O ano de decisão escolar do seu filho tem mais marcos do que à primeira vista parece. Prazos de candidatura. Bolsas de estudo. Open days. Momentos de reflexão recomendados pela investigação.',
                'O Calendário do 9.º Ano é uma timeline mensal. Uma única mensagem de WhatsApp no início de cada mês, com os 4 marcos que importa conhecer nesse mês. Visual. Direta. Pronta para guardar.',
                'A informação certa, no momento certo. Sem mais nada.',
            ],
            'meta' => [
                [ 'label' => 'Frequência', 'val' => 'Mensal' ],
                [ 'label' => 'Formato',    'val' => 'Imagem + texto' ],
                [ 'label' => 'Custo',      'val' => 'Gratuito' ],
            ],
            'form_title' => 'Subscrever o <em>calendário</em>',
            'form_sub'   => 'Recebe o calendário do mês atual imediatamente.',
            'role'        => 'familia',
            'cta'         => 'Subscrever',
            'wa_messages' => [
                'Olá <strong>{nome}</strong>. Inscrição confirmada.',
                'Receberá no início de cada mês os 4 marcos importantes desse mês para a decisão escolar do(a) seu/sua filho(a).',
                'Para começar, aqui vai o Calendário deste mês com os 4 marcos que ainda pode aproveitar.',
            ],
        ],
    ];
}

/* ── Ativação — criar tabela de contactos ─────────────────────── */

register_activation_hook( __FILE__, 'espro_activate' );
function espro_activate() {
    global $wpdb;
    $table   = $wpdb->prefix . 'espro_contacts';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        campaign varchar(50) NOT NULL,
        campaign_title varchar(200) NOT NULL,
        role varchar(20) NOT NULL,
        nome varchar(200) NOT NULL,
        telefone varchar(50) NOT NULL,
        escola varchar(200) DEFAULT '',
        ano varchar(50) DEFAULT '',
        consent_news tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}

/* ── Registar widgets no Elementor ────────────────────────────── */

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once ESPRO_PATH . 'widgets/hub-widget.php';
    require_once ESPRO_PATH . 'widgets/campaign-widget.php';
    $widgets_manager->register( new \Espro_Hub_Widget() );
    $widgets_manager->register( new \Espro_Campaign_Widget() );
});

add_action( 'elementor/elements/categories_registered', function( $manager ) {
    $manager->add_category( 'esprodouro', [
        'title' => 'ESPRODOURO',
        'icon'  => 'eicon-site-logo',
    ]);
});

/* ── Assets (registar — Elementor carrega só quando o widget está na página) */

add_action( 'wp_enqueue_scripts', function() {
    wp_register_style( 'espro-styles', ESPRO_URL . 'assets/css/esprodouro.css', [], ESPRO_VERSION );
    wp_register_script( 'espro-scripts', ESPRO_URL . 'assets/js/esprodouro.js', [], ESPRO_VERSION, true );
    wp_localize_script( 'espro-scripts', 'espro', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'espro_form' ),
    ]);
});

/* ── AJAX — submissão de formulário ───────────────────────────── */

add_action( 'wp_ajax_espro_submit', 'espro_handle_submit' );
add_action( 'wp_ajax_nopriv_espro_submit', 'espro_handle_submit' );

function espro_handle_submit() {
    check_ajax_referer( 'espro_form', 'nonce' );

    $campaigns = espro_campaigns();
    $campaign  = sanitize_text_field( wp_unslash( $_POST['campaign'] ?? '' ) );

    if ( ! isset( $campaigns[ $campaign ] ) ) {
        wp_send_json_error( [ 'message' => 'Campanha inválida.' ] );
    }

    $c    = $campaigns[ $campaign ];
    $nome = sanitize_text_field( wp_unslash( $_POST['nome'] ?? '' ) );
    $tel  = sanitize_text_field( wp_unslash( $_POST['telefone'] ?? '' ) );

    if ( empty( $nome ) ) {
        wp_send_json_error( [ 'message' => 'O nome é obrigatório.' ] );
    }

    $phone = preg_replace( '/[\s+]/', '', $tel );
    if ( ! preg_match( '/^9\d{8}$/', $phone ) && ! preg_match( '/^\+?351?9\d{8}$/', $phone ) ) {
        wp_send_json_error( [ 'message' => 'Número de WhatsApp português inválido (9 dígitos a começar por 9).' ] );
    }

    if ( strlen( $phone ) === 9 ) {
        $tel = '+351 ' . $phone;
    }

    global $wpdb;
    $wpdb->insert(
        $wpdb->prefix . 'espro_contacts',
        [
            'campaign'       => $campaign,
            'campaign_title' => $c['title_plain'],
            'role'           => $c['role'],
            'nome'           => $nome,
            'telefone'       => $tel,
            'escola'         => sanitize_text_field( wp_unslash( $_POST['escola'] ?? $_POST['zona'] ?? '' ) ),
            'ano'            => sanitize_text_field( wp_unslash( $_POST['ano'] ?? $_POST['filho_ano'] ?? '' ) ),
            'consent_news'   => ! empty( $_POST['c_news'] ) ? 1 : 0,
        ],
        [ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d' ]
    );

    wp_send_json_success( [
        'nome'        => $nome,
        'campaign'    => $campaign,
        'title_plain' => $c['title_plain'],
        'wa_messages' => $c['wa_messages'],
    ]);
}

/* ── Painel admin — contactos ─────────────────────────────────── */

add_action( 'admin_menu', function() {
    add_menu_page(
        'ESPRODOURO Contactos',
        'ESPRODOURO',
        'manage_options',
        'esprodouro',
        'espro_admin_page',
        'dashicons-phone',
        30
    );
});

add_action( 'admin_post_espro_export_csv', 'espro_export_csv' );
add_action( 'admin_post_espro_delete_all', 'espro_delete_all' );

function espro_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    global $wpdb;
    $table     = $wpdb->prefix . 'espro_contacts';
    $campaigns = espro_campaigns();
    $filter    = sanitize_text_field( $_GET['campaign'] ?? '' );

    if ( $filter && isset( $campaigns[ $filter ] ) ) {
        $contacts = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM $table WHERE campaign = %s ORDER BY created_at DESC", $filter
        ) );
    } else {
        $filter   = '';
        $contacts = $wpdb->get_results( "SELECT * FROM $table ORDER BY created_at DESC" );
    }

    $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table" );
    ?>
    <div class="wrap">
        <h1 style="margin-bottom:20px;">ESPRODOURO — Contactos <span style="color:#999;font-weight:300;">(<?php echo $total; ?>)</span></h1>

        <div style="margin-bottom:20px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <a href="<?php echo admin_url( 'admin.php?page=esprodouro' ); ?>"
               class="button <?php echo $filter === '' ? 'button-primary' : ''; ?>">Todas (<?php echo $total; ?>)</a>
            <?php foreach ( $campaigns as $key => $c ) :
                $cnt = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table WHERE campaign = %s", $key ) );
            ?>
                <a href="<?php echo admin_url( 'admin.php?page=esprodouro&campaign=' . $key ); ?>"
                   class="button <?php echo $filter === $key ? 'button-primary' : ''; ?>"><?php echo esc_html( $c['title_plain'] ); ?> (<?php echo $cnt; ?>)</a>
            <?php endforeach; ?>

            <span style="flex:1;"></span>
            <a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=espro_export_csv' ), 'espro_export' ); ?>"
               class="button">Exportar CSV</a>
            <a href="<?php echo wp_nonce_url( admin_url( 'admin-post.php?action=espro_delete_all' ), 'espro_delete' ); ?>"
               class="button" style="color:#b32d2e;"
               onclick="return confirm('Eliminar TODOS os contactos? Esta ação é irreversível.');">Limpar tudo</a>
        </div>

        <?php if ( empty( $contacts ) ) : ?>
            <div style="text-align:center;padding:60px 20px;color:#999;">
                <p style="font-size:48px;line-height:1;">&#8709;</p>
                <p>Ainda não há contactos<?php echo $filter ? ' nesta campanha' : ''; ?>.</p>
            </div>
        <?php else : ?>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>WhatsApp</th>
                        <th>Campanha</th>
                        <th>Papel</th>
                        <th>Escola / Zona</th>
                        <th>Ano</th>
                        <th>Newsletter</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ( $contacts as $row ) : ?>
                    <tr>
                        <td><?php echo esc_html( $row->nome ); ?></td>
                        <td><code><?php echo esc_html( $row->telefone ); ?></code></td>
                        <td><?php echo esc_html( $row->campaign_title ); ?></td>
                        <td><?php echo $row->role === 'jovem' ? 'Jovem' : 'Família'; ?></td>
                        <td><?php echo esc_html( $row->escola ?: '—' ); ?></td>
                        <td><?php echo esc_html( $row->ano ?: '—' ); ?></td>
                        <td><?php echo $row->consent_news ? 'Sim' : 'Não'; ?></td>
                        <td><?php echo esc_html( wp_date( 'd/m/Y H:i', strtotime( $row->created_at ) ) ); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

function espro_export_csv() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Sem permissão.' );
    check_admin_referer( 'espro_export' );

    global $wpdb;
    $contacts = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}espro_contacts ORDER BY created_at DESC" );

    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=esprodouro_contactos_' . wp_date( 'Y-m-d' ) . '.csv' );

    $out = fopen( 'php://output', 'w' );
    fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
    fputcsv( $out, [ 'Nome', 'WhatsApp', 'Campanha', 'Papel', 'Escola/Zona', 'Ano', 'Newsletter', 'Data' ] );

    foreach ( $contacts as $row ) {
        fputcsv( $out, [
            $row->nome,
            $row->telefone,
            $row->campaign_title,
            $row->role === 'jovem' ? 'Jovem' : 'Família',
            $row->escola,
            $row->ano,
            $row->consent_news ? 'Sim' : 'Não',
            $row->created_at,
        ] );
    }

    fclose( $out );
    exit;
}

function espro_delete_all() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Sem permissão.' );
    check_admin_referer( 'espro_delete' );

    global $wpdb;
    $wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}espro_contacts" );

    wp_safe_redirect( admin_url( 'admin.php?page=esprodouro' ) );
    exit;
}
