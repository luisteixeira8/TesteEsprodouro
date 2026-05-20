<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Espro_Campaign_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'espro-campaign'; }
    public function get_title()      { return 'ESPRODOURO Campanha'; }
    public function get_icon()       { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'esprodouro' ]; }
    public function get_keywords()   { return [ 'esprodouro', 'campanha', 'formulário', 'whatsapp' ]; }

    public function get_style_depends()  { return [ 'espro-styles' ]; }
    public function get_script_depends() { return [ 'espro-scripts' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_campaign', [
            'label' => 'Campanha',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $campaigns = espro_campaigns();
        $options   = [];
        foreach ( $campaigns as $key => $c ) {
            $options[ $key ] = $c['title_plain'];
        }

        $this->add_control( 'campaign', [
            'label'   => 'Selecionar campanha',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'decoder',
            'options' => $options,
        ]);

        $this->add_control( 'back_url', [
            'label'       => 'Link "Voltar"',
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://…/campanhas',
            'default'     => [ 'url' => '' ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s         = $this->get_settings_for_display();
        $campaigns = espro_campaigns();
        $id        = $s['campaign'] ?? 'decoder';

        if ( ! isset( $campaigns[ $id ] ) ) {
            echo '<p>Campanha não encontrada.</p>';
            return;
        }

        $c        = $campaigns[ $id ];
        $is_youth = $c['role'] === 'jovem';
        $back_url = $s['back_url']['url'] ?? '';
        ?>
        <div class="espro-campaign" data-campaign="<?php echo esc_attr( $id ); ?>">

            <!-- Narrativa -->
            <div class="espro-narrative">
                <?php if ( $back_url ) : ?>
                    <a href="<?php echo esc_url( $back_url ); ?>" class="espro-back">&larr; Voltar às campanhas</a>
                <?php endif; ?>

                <div class="espro-kicker"><?php echo esc_html( $c['num'] . ' · ' . $c['audience_label'] ); ?></div>
                <h2 class="espro-narrative__title"><?php echo wp_kses( $c['title'], [ 'em' => [] ] ); ?></h2>
                <p class="espro-narrative__sub"><?php echo esc_html( $c['short'] ); ?></p>

                <div class="espro-narrative__body">
                    <?php foreach ( $c['narrative'] as $p ) : ?>
                        <p><?php echo esc_html( $p ); ?></p>
                    <?php endforeach; ?>
                </div>

                <div class="espro-meta">
                    <?php foreach ( $c['meta'] as $m ) : ?>
                        <div class="espro-meta__item">
                            <span class="espro-meta__label"><?php echo esc_html( $m['label'] ); ?></span>
                            <span class="espro-meta__val"><?php echo esc_html( $m['val'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Formulário -->
            <div class="espro-form-wrap">
                <h3 class="espro-form__title"><?php echo wp_kses( $c['form_title'], [ 'em' => [] ] ); ?></h3>
                <p class="espro-form__sub"><?php echo esc_html( $c['form_sub'] ); ?></p>

                <form class="espro-form" data-campaign="<?php echo esc_attr( $id ); ?>" data-back="<?php echo esc_url( $back_url ); ?>" novalidate>

                    <?php if ( $is_youth ) : ?>
                        <div class="espro-field">
                            <label for="espro-nome-<?php echo esc_attr( $id ); ?>">Primeiro nome</label>
                            <input type="text" id="espro-nome-<?php echo esc_attr( $id ); ?>" name="nome" required autocomplete="given-name" placeholder="Como te tratamos?">
                        </div>
                        <div class="espro-field">
                            <label for="espro-tel-<?php echo esc_attr( $id ); ?>">Número de WhatsApp</label>
                            <input type="tel" id="espro-tel-<?php echo esc_attr( $id ); ?>" name="telefone" required autocomplete="tel" placeholder="9XX XXX XXX" inputmode="numeric">
                        </div>
                        <div class="espro-field">
                            <label for="espro-escola-<?php echo esc_attr( $id ); ?>">Escola que frequentas</label>
                            <input type="text" id="espro-escola-<?php echo esc_attr( $id ); ?>" name="escola" autocomplete="organization" placeholder="Nome da escola (opcional)">
                        </div>
                        <div class="espro-field">
                            <label>Ano que frequentas</label>
                            <div class="espro-radio-group">
                                <label class="espro-radio"><input type="radio" name="ano" value="8º ano"><span>8.º ano</span></label>
                                <label class="espro-radio"><input type="radio" name="ano" value="9º ano" checked><span>9.º ano</span></label>
                                <label class="espro-radio"><input type="radio" name="ano" value="10º ano"><span>10.º ano</span></label>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="espro-field">
                            <label for="espro-nome-<?php echo esc_attr( $id ); ?>">Como o(a) podemos tratar?</label>
                            <input type="text" id="espro-nome-<?php echo esc_attr( $id ); ?>" name="nome" required autocomplete="name" placeholder="Nome próprio basta">
                        </div>
                        <div class="espro-field">
                            <label for="espro-tel-<?php echo esc_attr( $id ); ?>">Número de WhatsApp</label>
                            <input type="tel" id="espro-tel-<?php echo esc_attr( $id ); ?>" name="telefone" required autocomplete="tel" placeholder="9XX XXX XXX" inputmode="numeric">
                        </div>
                        <div class="espro-field">
                            <label for="espro-ano-<?php echo esc_attr( $id ); ?>">Ano que o(a) seu/sua filho(a) frequenta</label>
                            <select id="espro-ano-<?php echo esc_attr( $id ); ?>" name="filho_ano">
                                <option value="">Selecionar (opcional)</option>
                                <option value="7º ano">7.º ano</option>
                                <option value="8º ano">8.º ano</option>
                                <option value="9º ano" selected>9.º ano</option>
                                <option value="10º ano">10.º ano</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div class="espro-field">
                            <label for="espro-zona-<?php echo esc_attr( $id ); ?>">Zona / Concelho</label>
                            <input type="text" id="espro-zona-<?php echo esc_attr( $id ); ?>" name="zona" placeholder="Ex.: São João da Pesqueira (opcional)">
                        </div>
                    <?php endif; ?>

                    <div class="espro-consent">
                        <?php if ( $is_youth ) : ?>
                            <label class="espro-consent__row">
                                <input type="checkbox" name="c_idade" required>
                                <span>Confirmo que tenho mais de 16 anos <strong>OU</strong> tenho autorização do meu encarregado de educação.</span>
                            </label>
                        <?php endif; ?>

                        <label class="espro-consent__row">
                            <input type="checkbox" name="c_rgpd" required>
                            <span>Aceito que a ESPRODOURO me contacte por WhatsApp no âmbito desta campanha. Posso descontinuar a qualquer momento enviando STOP.</span>
                        </label>

                        <label class="espro-consent__row">
                            <input type="checkbox" name="c_news">
                            <span>(Opcional) Aceito receber outras comunicações relevantes da ESPRODOURO.</span>
                        </label>
                    </div>

                    <div class="espro-form__error" style="display:none;"></div>

                    <button type="submit" class="espro-btn"><?php echo esc_html( $c['cta'] ); ?> &rarr;</button>
                </form>
            </div>
        </div>
        <?php
    }
}
