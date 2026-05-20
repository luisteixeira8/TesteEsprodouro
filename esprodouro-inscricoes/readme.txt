=== ESPRODOURO Inscrições ===
Contributors: esprodouro
Tags: lead capture, form, escola profissional, education, contacts
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Recolha e gestão de inscrições/leads do widget de captação da Escola Profissional do Alto Douro.

== Description ==

Plugin oficial da ESPRODOURO para recolha e gestão de inscrições.

Funcionalidades:

* Formulário pronto a usar via shortcode `[esprodouro_inscricao]`
* Tabela própria (`{prefixo}_esprodouro_inscricoes`) — não polui `wp_posts`
* Página de administração com filtros, pesquisa, paginação e detalhe
* Estados de gestão: Novo · Contactado · Inscrito · Descartado
* Exportação CSV com BOM UTF-8 (compatível com Excel)
* Notificações por email para cada nova submissão
* Honeypot + rate limiting (5 por IP / 5 min) + nonces — anti-spam
* Validação de número português (9 dígitos a começar por 9, com prefixo +351 opcional)
* Integração com ferramentas de privacidade do WordPress (RGPD): exportação e apagamento de dados pessoais por email

== Installation ==

1. Carrega a pasta `esprodouro-inscricoes` para `/wp-content/plugins/`.
2. Ativa o plugin no menu **Plugins** do WordPress.
3. Cola `[esprodouro_inscricao]` na página onde queres o formulário.
4. Em **Inscrições → Definições**, configura o email para notificações.

== Frequently Asked Questions ==

= Onde ficam guardados os dados? =

Numa tabela própria, `{prefixo}_esprodouro_inscricoes`, separada do core do WordPress.

= Como exporto as inscrições? =

Em **Inscrições**, clica em **Exportar CSV** no topo da página. Inclui todas as submissões em formato compatível com Excel.

= O plugin envia emails? =

Sim, se configurares um endereço em **Definições**. Cada nova inscrição dispara uma notificação para esse endereço.

= Como customizo o formulário? =

Atributos do shortcode: `[esprodouro_inscricao titulo="Os teus dados" subtitulo="..." cta="Enviar"]`. Para customizações mais profundas, usa o filtro `esprodouro_inscricoes_pre_insert` ou substitui o template em `templates/form.php`.

= O plugin é compatível com o RGPD? =

Sim. Regista hooks para exportação e apagamento de dados pessoais via **Ferramentas → Privacidade**. Também sugere conteúdo para a página de Política de Privacidade.

== Changelog ==

= 1.0.0 =
* Versão inicial: shortcode, AJAX handler, admin com filtros e exportação CSV, integração RGPD, notificações por email.
