<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Espro_Hub_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'espro-hub'; }
    public function get_title()      { return 'ESPRODOURO Hub'; }
    public function get_icon()       { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'esprodouro' ]; }
    public function get_keywords()   { return [ 'esprodouro', 'campanhas', 'hub', 'grid' ]; }

    public function get_style_depends()  { return [ 'espro-styles' ]; }
    public function get_script_depends() { return []; }

    protected function register_controls() {

        /* ── Conteúdo ─────────────────────────────── */
        $this->start_controls_section( 'section_content', [
            'label' => 'Conteúdo',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control( 'kicker', [
            'label'   => 'Kicker',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Seis campanhas · Janela de captação maio–junho 2026',
        ]);

        $this->add_control( 'heading', [
            'label'   => 'Título',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Não escolhemos uma escola. Reconhecemos um <em>caminho</em>.',
        ]);

        $this->add_control( 'lead', [
            'label'   => 'Texto introdutório',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Seis formas distintas de iniciar uma conversa com a ESPRODOURO. Três para jovens em ano de decisão. Três para as suas famílias. Todas operam por WhatsApp — onde estão as conversas que importam.',
        ]);

        $this->end_controls_section();

        /* ── Links das campanhas ──────────────────── */
        $this->start_controls_section( 'section_links', [
            'label' => 'Links das campanhas',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $campaigns = espro_campaigns();
        foreach ( $campaigns as $key => $c ) {
            $this->add_control( 'url_' . $key, [
                'label'       => $c['title_plain'],
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://…',
                'default'     => [ 'url' => '' ],
            ]);
        }

        $this->end_controls_section();
    }

    protected function render() {
        $s         = $this->get_settings_for_display();
        $campaigns = espro_campaigns();
        ?>
        <div class="espro-hub">
            <div class="espro-hub__hero">
                <?php if ( ! empty( $s['kicker'] ) ) : ?>
                    <div class="espro-kicker"><?php echo esc_html( $s['kicker'] ); ?></div>
                <?php endif; ?>

                <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h2 class="espro-hub__title"><?php echo wp_kses( $s['heading'], [ 'em' => [], 'br' => [], 'strong' => [] ] ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $s['lead'] ) ) : ?>
                    <p class="espro-hub__lead"><?php echo esc_html( $s['lead'] ); ?></p>
                <?php endif; ?>
            </div>

            <div class="espro-cards">
                <?php foreach ( $campaigns as $key => $c ) :
                    $link = $s[ 'url_' . $key ]['url'] ?? '#';
                    $tag  = ! empty( $link ) && $link !== '#' ? 'a' : 'div';
                    $href = $tag === 'a' ? ' href="' . esc_url( $link ) . '"' : '';
                ?>
                    <<?php echo $tag . $href; ?> class="espro-card" data-audience="<?php echo esc_attr( $c['audience'] ); ?>">
                        <span class="espro-card__num"><?php echo esc_html( $c['num'] ); ?></span>
                        <h3 class="espro-card__title"><?php echo wp_kses( $c['title'], [ 'em' => [] ] ); ?></h3>
                        <p class="espro-card__desc"><?php echo esc_html( $c['description'] ); ?></p>
                        <span class="espro-card__cta"><?php echo esc_html( $c['cta'] ); ?> &rarr;</span>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
