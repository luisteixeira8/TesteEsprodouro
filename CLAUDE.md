# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Visão geral

Diretório de trabalho com várias materializações paralelas da plataforma de captação **ESPRODOURO** — seis campanhas de inscrição via WhatsApp (3 para jovens 14-16, 3 para encarregados de educação). O conteúdo das campanhas é o mesmo em todas as versões; muda apenas o ambiente de entrega.

Não é um repositório git. Não tem build system, package.json nem testes. Edições são diretas aos ficheiros; "executar" significa abrir o HTML no browser ou instalar os plugins no WordPress.

Língua: tudo em português de Portugal (pt-PT). Manter o tom e ortografia existentes em qualquer texto novo.

## Estrutura — três alvos de entrega independentes

Estes três blocos não dependem uns dos outros. Quando alterares uma campanha, considera se a mesma alteração precisa de ser propagada às outras materializações.

### 1. SPA estático (raiz)
- `index.html` + `app.js` + `style.css` — protótipo single-page com hash routing (`#/`, `#/<campanha>`, `#/sucesso/...`, `#/admin`).
- Definição das 6 campanhas no objeto `CAMPAIGNS` em `app.js` (topo do ficheiro).
- Persistência via `window.storage` (API de storage do artifact host — `storage.set/get/list`). Não é localStorage nem backend real.
- Páginas standalone: `historia.html`, `missao-visao-valores.html`, `esprodouro-widget.html`.
- `fix.js`, `split.js` — utilitários soltos.

### 2. Plugin Elementor (`esprodouro-elementor/`)
- WordPress plugin que regista widgets Elementor para renderizar as campanhas dentro de páginas Elementor.
- Bootstrap: `esprodouro-elementor.php` (define `espro_campaigns()` com os dados das 6 campanhas — espelho do `CAMPAIGNS` do `app.js`).
- Widgets em `widgets/campaign-widget.php` e `widgets/hub-widget.php`.
- Assets próprios em `assets/css/esprodouro.css` e `assets/js/esprodouro.js`.

### 3. Plugin de inscrições (`esprodouro-inscricoes/`)
- WordPress plugin separado que faz a recolha real dos contactos (shortcode `[esprodouro_inscricao]` + painel admin).
- Entry point: `esprodouro-inscricoes.php` carrega quatro classes de `includes/`:
  - `class-database.php` — instalação/upgrade da tabela custom (`register_activation_hook` chama `::install`; `::maybe_upgrade` em `plugins_loaded`).
  - `class-form.php` — shortcode e submissão.
  - `class-privacy.php` — integrações RGPD do WordPress.
  - `class-admin.php` — só carregado em `is_admin()`.
- Template do formulário: `templates/form.php`. Assets: `assets/form.css`, `assets/form.js`, `assets/admin.css`.
- `esprodouro-inscricoes.zip` é o artefacto de distribuição (mantê-lo sincronizado se distribuíres).

## Propagação de alterações entre alvos

Os dados das campanhas estão duplicados — `CAMPAIGNS` em `app.js` e `espro_campaigns()` em `esprodouro-elementor.php`. Qualquer mudança de copy, CTA, narrativa, `waMessages`/`wa_messages` ou metadados de campanha tem de ser feita nos dois sítios para os ambientes ficarem coerentes. O plugin de inscrições não duplica este conteúdo — só recolhe submissões.

## Convenções relevantes

- Validação de telefone PT: formato `9XXXXXXXX` (9 dígitos a começar por 9) ou prefixo `+351`. Já implementado em `app.js`; replicar se adicionares pontos de submissão.
- Consentimento RGPD obrigatório (`c-rgpd`); campanhas com `role: 'jovem'` exigem também confirmação de idade (`c-idade`).
- Texto com `<em>...</em>` em títulos é intencional (itálico tipográfico via Fraunces) — não remover.
