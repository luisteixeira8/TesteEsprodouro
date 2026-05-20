<?php
/**
 * Form template. Rendered by Esprodouro_Inscricoes_Form::render_shortcode().
 *
 * @package Esprodouro_Inscricoes
 *
 * @var array  $atts   Shortcode attributes (titulo, subtitulo, cta).
 * @var string $nonce  Pre-generated nonce.
 * @var string $origem Origin URL.
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="espins espins-wrap">
	<h3 class="espins__title"><?php echo esc_html( $atts['titulo'] ); ?></h3>
	<p class="espins__sub"><?php echo esc_html( $atts['subtitulo'] ); ?></p>

	<form class="espins__form" novalidate>
		<input type="hidden" name="action" value="<?php echo esc_attr( Esprodouro_Inscricoes_Form::AJAX_ACTION ); ?>">
		<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( $nonce ); ?>">
		<input type="hidden" name="origem" value="<?php echo esc_attr( $origem ); ?>">

		<div class="espins-hp" aria-hidden="true">
			<label><?php esc_html_e( 'Não preencher', 'esprodouro-inscricoes' ); ?></label>
			<input type="text" name="website" tabindex="-1" autocomplete="off">
		</div>

		<div class="espins__fld">
			<label for="espins-nome"><?php esc_html_e( 'Nome do aluno', 'esprodouro-inscricoes' ); ?></label>
			<input type="text" id="espins-nome" name="nome" required placeholder="<?php esc_attr_e( 'Primeiro e último nome', 'esprodouro-inscricoes' ); ?>">
		</div>
		<div class="espins__fld">
			<label for="espins-email"><?php esc_html_e( 'Email', 'esprodouro-inscricoes' ); ?></label>
			<input type="email" id="espins-email" name="email" required placeholder="exemplo@email.com">
		</div>
		<div class="espins__fld">
			<label for="espins-tel"><?php esc_html_e( 'Telemóvel / WhatsApp do aluno', 'esprodouro-inscricoes' ); ?></label>
			<input type="tel" id="espins-tel" name="telefone" required placeholder="9XX XXX XXX" inputmode="numeric">
		</div>

		<div class="espins__div"><?php esc_html_e( 'Encarregado de educação', 'esprodouro-inscricoes' ); ?></div>

		<div class="espins__fld">
			<label for="espins-enc-nome"><?php esc_html_e( 'Nome do encarregado de educação', 'esprodouro-inscricoes' ); ?></label>
			<input type="text" id="espins-enc-nome" name="enc_nome" required placeholder="<?php esc_attr_e( 'Nome completo', 'esprodouro-inscricoes' ); ?>">
		</div>
		<div class="espins__fld">
			<label for="espins-enc-tel"><?php esc_html_e( 'Contacto do encarregado de educação', 'esprodouro-inscricoes' ); ?></label>
			<input type="tel" id="espins-enc-tel" name="enc_telefone" required placeholder="9XX XXX XXX" inputmode="numeric">
		</div>

		<div class="espins__consent">
			<label class="espins__crow">
				<input type="checkbox" name="c_enc" required>
				<span><?php esc_html_e( 'Confirmo que o encarregado de educação autoriza a recolha destes dados e o contacto por WhatsApp.', 'esprodouro-inscricoes' ); ?></span>
			</label>
			<label class="espins__crow">
				<input type="checkbox" name="c_rgpd" required>
				<span><?php esc_html_e( 'Aceito que a ESPRODOURO me contacte por WhatsApp. Posso descontinuar enviando STOP.', 'esprodouro-inscricoes' ); ?></span>
			</label>
			<label class="espins__crow">
				<input type="checkbox" name="c_news">
				<span><?php esc_html_e( '(Opcional) Aceito receber informações sobre cursos e novidades da ESPRODOURO.', 'esprodouro-inscricoes' ); ?></span>
			</label>
		</div>

		<div class="espins__err" role="alert"></div>
		<button type="submit" class="espins__btn"><?php echo esc_html( $atts['cta'] ); ?></button>
	</form>
</div>
