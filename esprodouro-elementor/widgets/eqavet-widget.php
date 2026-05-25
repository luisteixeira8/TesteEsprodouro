<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Espro_Eqavet_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'espro-eqavet'; }
    public function get_title()      { return 'ESPRODOURO EQAVET'; }
    public function get_icon()       { return 'eicon-badge'; }
    public function get_categories() { return [ 'esprodouro' ]; }
    public function get_keywords()   { return [ 'esprodouro', 'eqavet', 'qualidade', 'selo' ]; }

    public function get_style_depends() { return [ 'espro-styles' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_eqavet', [
            'label' => 'EQAVET',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control( 'eqavet_logo', [
            'label'   => 'Logotipo EQAVET',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => '' ],
        ]);

        $this->add_control( 'selo_periodo', [
            'label'   => 'Periodo do selo',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '2023–2026',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $logo = $s['eqavet_logo']['url'] ?? '';
        $periodo = esc_html( $s['selo_periodo'] ?? '2023–2026' );
        ?>
        <div class="espro-eqavet">

            <!-- Cabeçalho com logo -->
            <div class="espro-eqavet__header">
                <?php if ( $logo ) : ?>
                    <img src="<?php echo esc_url( $logo ); ?>" alt="Selo EQAVET" class="espro-eqavet__logo">
                <?php else : ?>
                    <div class="espro-eqavet__logo-placeholder">EQAVET</div>
                <?php endif; ?>

                <div class="espro-eqavet__header-text">
                    <div class="espro-kicker">EQAVET</div>
                    <h2 class="espro-eqavet__title">A ESPRODOURO tem o selo <em>EQAVET</em></h2>
                    <p class="espro-eqavet__subtitle">Quadro de Referência Europeu de Garantia da Qualidade para a Educação e Formação Profissionais</p>
                </div>
            </div>

            <!-- Selo e período -->
            <div class="espro-eqavet__selo">
                <span class="espro-eqavet__selo-badge">SELO EQAVET <?php echo $periodo; ?></span>
            </div>

            <!-- Corpo -->
            <div class="espro-eqavet__body">

                <div class="espro-eqavet__section">
                    <h3>Relatórios e Avaliação</h3>
                    <p>Desde 1 de junho de 2020 que a ESPRODOURO, obteve o selo EQAVET, indicando que os seus processos e procedimentos estão alinhados com os requisitos do Quadro de Referência Europeu de Garantia da Qualidade para a Educação e Formação Profissionais.</p>
                </div>

                <div class="espro-eqavet__section">
                    <p>O Quadro de Referência Europeu de Garantia da Qualidade para a Educação e Formação Profissionais (Quadro EQAVET) foi concebido para melhorar o Ensino e Formação Profissional (EFP) no espaço europeu, colocando à disposição das autoridades e dos operadores ferramentas comuns para a gestão da qualidade, promovendo a confiança mútua, a mobilidade de trabalhadores e de formandos e a aprendizagem ao longo da vida.</p>
                </div>

                <div class="espro-eqavet__section">
                    <p>O EQAVET é um instrumento a adotar que permite documentar, desenvolver, monitorizar, avaliar e melhorar a eficiência da oferta de EFP e a qualidade das práticas de gestão, implicando processos sistemáticos e regulares, envolvendo mecanismos de avaliação interna e externa, relatórios de progresso, estabelecendo critérios de qualidade e descritores indicativos que suportam a monitorização e a produção de relatórios por parte dos sistemas e dos operadores de EFP, e evidenciando a importância dos indicadores de qualidade que suportam a avaliação, monitorização e garantia da qualidade dos sistemas e dos operadores de EFP.</p>
                </div>

                <div class="espro-eqavet__section">
                    <h3>Ciclo da Qualidade</h3>
                    <p>O ciclo da qualidade do EQAVET é implementado em quatro fases interligadas:</p>

                    <div class="espro-eqavet__fases">
                        <div class="espro-eqavet__fase">
                            <span class="espro-eqavet__fase-num">1</span>
                            <div>
                                <strong>Planear</strong>
                                <p>Definir metas e objetivos apropriados e mensuráveis.</p>
                            </div>
                        </div>
                        <div class="espro-eqavet__fase">
                            <span class="espro-eqavet__fase-num">2</span>
                            <div>
                                <strong>Implementar</strong>
                                <p>Estabelecer procedimentos que assegurem o cumprimento das metas e objetivos definidos.</p>
                            </div>
                        </div>
                        <div class="espro-eqavet__fase">
                            <span class="espro-eqavet__fase-num">3</span>
                            <div>
                                <strong>Apreciar e avaliar</strong>
                                <p>Desenvolver mecanismos de recolha e tratamento de dados que sustentem uma avaliação fundamentada dos resultados esperados.</p>
                            </div>
                        </div>
                        <div class="espro-eqavet__fase">
                            <span class="espro-eqavet__fase-num">4</span>
                            <div>
                                <strong>Ajustar</strong>
                                <p>Desenvolver procedimentos para atingir os resultados ainda não alcançados e/ou estabelecer novos objetivos em função das evidências geradas, de forma a garantir a introdução das melhorias necessárias.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="espro-eqavet__section">
                    <p>A Escola Profissional do Alto Douro está agora a implementar este sistema de qualidade, e apresentará nesta página toda a sua documentação.</p>
                </div>

                <div class="espro-eqavet__section espro-eqavet__footer-section">
                    <h3>Relatórios, Indicadores e Anexos</h3>
                    <p>Quadro de Referência Europeu de Garantia da Qualidade para a Educação e Formação Profissionais</p>
                </div>

            </div>
        </div>
        <?php
    }
}
