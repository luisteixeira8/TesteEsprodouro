// ───────────────────────────────────────────────────────────────
// CONFIGURAÇÃO DAS 6 CAMPANHAS
// ───────────────────────────────────────────────────────────────
const CAMPAIGNS = {
  'decoder': {
    num: '01 / 06',
    audience: 'jovem',
    audienceLabel: 'Jovem · 14-16 anos',
    title: 'Douro <em>Decoder</em>',
    short: 'Quiz identitário em 3 minutos',
    description: 'Em 7 perguntas, descobres que tipo de profissional vive dentro de ti — a partir das tuas respostas, não de catálogos.',
    narrative: [
      'Ninguém escolhe um curso porque viu uma brochura. Escolhe-se quando se reconhece — quando uma frase nos descreve com uma exatidão que não esperávamos.',
      'O Douro Decoder é um quiz curto, sem respostas certas, que devolve um perfil profissional escrito sobre ti. Demora menos do que ouvires uma música. Recebes o teu perfil completo no WhatsApp, com o caminho que pode ser teu — se quiseres.',
      'Não é teste de orientação. É um espelho.'
    ],
    meta: [
      { label: 'Duração', val: '3 minutos' },
      { label: 'Formato', val: 'WhatsApp' },
      { label: 'Resultado', val: '6 perfis possíveis' }
    ],
    formTitle: 'Começa o <em>quiz</em>',
    formSub: 'Recebes a primeira pergunta no WhatsApp em menos de 60 segundos.',
    role: 'jovem',
    cta: 'Receber a primeira pergunta',
    waMessages: [
      { delay: 0, text: 'Olá <strong>{nome}</strong>. Encontraste o Douro Decoder.' },
      { delay: 1.2, text: 'Em 3 minutos vou ajudar-te a descobrir que tipo de profissional vives dentro de ti — a partir das tuas respostas, não das nossas perguntas tradicionais. Vamos a isto?' },
      { delay: 2.4, text: 'Não há respostas certas. Há só a tua resposta. Pronto?' }
    ]
  },
  'sussurro': {
    num: '02 / 06',
    audience: 'jovem',
    audienceLabel: 'Jovem · 14-16 anos',
    title: 'Sussurro do <em>Douro</em>',
    short: 'Linha confidente sobre o teu futuro',
    description: 'Tens dúvidas sobre o teu futuro que não te apetece perguntar em frente da turma? Aqui podes perguntar sem te identificares.',
    narrative: [
      'Há perguntas que não fazemos em voz alta. Não por sermos tímidos — por sabermos que o sítio onde estamos não é o sítio certo para as fazer.',
      'O Sussurro do Douro é uma linha de WhatsApp onde podes perguntar qualquer coisa sobre o teu futuro profissional sem teres de te identificar. Responde-te uma pessoa real, em horário definido. Sem agenda comercial. Sem vergonha de não saber.',
      'Só perguntas. Eu respondo.'
    ],
    meta: [
      { label: 'Atendimento', val: '16h-19h · dias úteis' },
      { label: 'Resposta', val: 'Sob 2 horas' },
      { label: 'Identificação', val: 'Não obrigatória' }
    ],
    formTitle: 'Abre uma <em>conversa</em>',
    formSub: 'Não precisas de te identificar para enviar a primeira mensagem. Pedimos só o número para te respondermos.',
    role: 'jovem',
    cta: 'Iniciar conversa',
    waMessages: [
      { delay: 0, text: 'Olá. Encontraste o Sussurro do Douro.' },
      { delay: 1.2, text: 'Aqui podes perguntar qualquer coisa sobre o teu futuro profissional sem teres de te identificar. Não tens de dizer quem és.' },
      { delay: 2.4, text: 'O que te traz cá hoje?' }
    ]
  },
  'cromos': {
    num: '03 / 06',
    audience: 'jovem',
    audienceLabel: 'Jovem · 14-16 anos',
    title: 'Caça ao <em>Cromo</em> do Douro',
    short: '30 cromos. 8 semanas. 1 dia VIP.',
    description: 'Coleção digital de 30 cromos sobre o Douro — desbloqueias com desafios semanais. Coleção completa = dia VIP na ESPRODOURO.',
    narrative: [
      'Uma vinha que resiste há 100 anos. Uma profissão que ainda não tem nome. Um miradouro que ninguém te mostrou. Trinta cromos sobre o Douro que ninguém te contou.',
      'Cada cromo desbloqueia-se com um desafio semanal — uma foto, uma resposta, uma micro-curiosidade. Os 50 melhores classificados recebem um kit ESPRODOURO. Quem completar a coleção tem direito a um dia VIP — laboratórios, almoço gourmet, encontro com a Direção.',
      'Coleciona o Douro que te pertence.'
    ],
    meta: [
      { label: 'Duração', val: '8 semanas' },
      { label: 'Cromos', val: '30 raridades' },
      { label: 'Prémio máx.', val: 'Dia VIP' }
    ],
    formTitle: 'Começa a <em>coleção</em>',
    formSub: 'Recebes o primeiro cromo no WhatsApp imediatamente após a inscrição.',
    role: 'jovem',
    cta: 'Quero o primeiro cromo',
    waMessages: [
      { delay: 0, text: 'Olá <strong>{nome}</strong>. Bem-vindo(a) à Caça ao Cromo do Douro.' },
      { delay: 1.2, text: '🎴 Cromo 1 de 30 — <em>A Vinha que Resiste</em>. Sabias que há vinhas no Douro com mais de 100 anos a produzir?' },
      { delay: 2.4, text: 'O teu primeiro desafio chega amanhã às 18h. Se completares, desbloqueias o Cromo 2.' }
    ]
  },
  'sabias': {
    num: '04 / 06',
    audience: 'familia',
    audienceLabel: 'Encarregado de educação',
    title: 'Sabias <em>Que...</em>',
    short: 'Uma curiosidade por semana. 60 segundos de leitura.',
    description: 'Curiosidades semanais sobre educação, mercado de trabalho e neurodesenvolvimento adolescente. Sem spam. Sem venda. À quarta-feira às 21h.',
    narrative: [
      'Uma curiosidade por semana. Sessenta segundos de leitura. Sempre à quarta-feira, às 21h, depois do jantar.',
      'A rubrica "Sabias Que..." é uma série semanal de pequenos textos sobre educação, neurodesenvolvimento adolescente e mercado de trabalho regional. Pensada para encarregados de educação que querem perceber o que está em jogo sem terem de ler tratados.',
      'Não há agenda comercial. Para descontinuar, basta uma palavra.'
    ],
    meta: [
      { label: 'Frequência', val: 'Semanal · 4ª feira 21h' },
      { label: 'Duração', val: '60 segundos' },
      { label: 'Custo', val: 'Gratuito' }
    ],
    formTitle: 'Subscrever <em>"Sabias Que..."</em>',
    formSub: 'Receberá a primeira mensagem imediatamente. As semanais começam na próxima quarta-feira.',
    role: 'familia',
    cta: 'Subscrever',
    waMessages: [
      { delay: 0, text: 'Olá <strong>{nome}</strong>. Bem-vindo(a) ao "Sabias Que...".' },
      { delay: 1.2, text: 'À quarta-feira às 21h chega uma curiosidade de 60 segundos sobre educação, futuro profissional ou neurodesenvolvimento adolescente. Para descontinuar, escreva STOP.' },
      { delay: 2.4, text: 'Para começar: <em>sabia que a decisão pelo ensino profissional tem hoje 34% de taxa de progressão para o ensino superior — superior à de muitos cursos científico-humanísticos?</em>' }
    ]
  },
  'conversas': {
    num: '05 / 06',
    audience: 'familia',
    audienceLabel: 'Encarregado de educação',
    title: '5 Conversas <em>importantes</em>',
    short: 'Mini-curso parental em 5 dias',
    description: 'Cinco guiões para as cinco conversas que vai querer ter com o seu filho de 14 anos sobre o futuro. Uma por dia, no WhatsApp.',
    narrative: [
      'Há conversas que sabemos que devíamos ter com os filhos — sobre o futuro, sobre o que os assusta, sobre o que esperam de nós. Mas não sabemos por onde começar. Receamos errar. Adiamos.',
      'Este mini-curso entrega-lhe, em cinco dias, cinco guiões concretos para as cinco conversas mais importantes que pode ter com o seu filho de 14 anos sobre o futuro. Um guião por dia, no WhatsApp. Com perguntas a fazer, erros a evitar, respostas esperadas.',
      'Construído com base em metodologias de comunicação parental fundamentadas em evidência.'
    ],
    meta: [
      { label: 'Duração', val: '5 dias · 1 por dia' },
      { label: 'Tempo/dia', val: '5 minutos' },
      { label: 'Base', val: 'Evidência científica' }
    ],
    formTitle: 'Começar o <em>mini-curso</em>',
    formSub: 'O primeiro guião chega ao seu WhatsApp em menos de 60 segundos.',
    role: 'familia',
    cta: 'Receber o primeiro guião',
    waMessages: [
      { delay: 0, text: 'Olá <strong>{nome}</strong>. Bem-vindo(a) ao mini-curso.' },
      { delay: 1.2, text: 'Recebeu o primeiro dos 5 guiões. Cada dia, à mesma hora, chega o seguinte.' },
      { delay: 2.4, text: '📖 <strong>Dia 1 — "O que te assusta no futuro? E o que te entusiasma?"</strong> Este é o guião para abrir o canal emocional. Veja o documento completo no link [...]' }
    ]
  },
  'calendario': {
    num: '06 / 06',
    audience: 'familia',
    audienceLabel: 'Encarregado de educação',
    title: 'Calendário do <em>9.º ano</em>',
    short: 'Que decisões aí vêm. Mês a mês.',
    description: 'Receba todos os meses, em 1 mensagem, os 4 marcos importantes para a decisão escolar do seu filho. Sem spam. Para sempre prático.',
    narrative: [
      'O ano de decisão escolar do seu filho tem mais marcos do que à primeira vista parece. Prazos de candidatura. Bolsas de estudo. Open days. Momentos de reflexão recomendados pela investigação. É difícil ter tudo na cabeça.',
      'O Calendário do 9.º Ano é uma timeline mensal. Uma única mensagem de WhatsApp no início de cada mês, com os 4 marcos que importa conhecer nesse mês. Visual. Direta. Pronta para guardar.',
      'A informação certa, no momento certo. Sem mais nada.'
    ],
    meta: [
      { label: 'Frequência', val: 'Mensal' },
      { label: 'Formato', val: 'Imagem + texto' },
      { label: 'Custo', val: 'Gratuito' }
    ],
    formTitle: 'Subscrever o <em>calendário</em>',
    formSub: 'Recebe o calendário do mês atual imediatamente.',
    role: 'familia',
    cta: 'Subscrever',
    waMessages: [
      { delay: 0, text: 'Olá <strong>{nome}</strong>. Inscrição confirmada.' },
      { delay: 1.2, text: 'Receberá no início de cada mês os 4 marcos importantes desse mês para a decisão escolar do(a) seu/sua filho(a).' },
      { delay: 2.4, text: '📅 Para começar, aqui vai o <em>Calendário deste mês</em> com os 4 marcos que ainda pode aproveitar [imagem em anexo].' }
    ]
  }
};

// ───────────────────────────────────────────────────────────────
// ROUTING
// ───────────────────────────────────────────────────────────────
function navigate(path) {
  window.location.hash = '#' + path;
  window.scrollTo(0, 0);
}

function getRoute() {
  const h = window.location.hash.replace(/^#/, '') || '/';
  return h;
}

window.addEventListener('hashchange', render);
window.addEventListener('DOMContentLoaded', render);

function render() {
  const route = getRoute();
  const app = document.getElementById('app');

  if (route === '/' || route === '') {
    app.innerHTML = renderHub();
    return;
  }

  if (route === '/admin') {
    renderAdmin(app);
    return;
  }

  if (route.startsWith('/sucesso/')) {
    const parts = route.split('/');
    const campId = parts[2];
    const contactId = parts[3];
    renderSuccess(app, campId, contactId);
    return;
  }

  if (route.startsWith('/')) {
    const campId = route.slice(1);
    if (CAMPAIGNS[campId]) {
      app.innerHTML = renderCampaign(campId);
      attachFormHandler(campId);
      return;
    }
  }

  app.innerHTML = '<div style="padding:80px 24px;text-align:center;"><p>Página não encontrada.</p><a href="#/" onclick="navigate(\'/\');return false;">Voltar ao início</a></div>';
}

// ───────────────────────────────────────────────────────────────
// HUB / HOMEPAGE
// ───────────────────────────────────────────────────────────────
function renderHub() {
  const cards = Object.entries(CAMPAIGNS).map(([id, c]) => `
    <a href="#/${id}" onclick="navigate('/${id}'); return false;" class="camp-card" data-audience="${c.audience}">
      <div class="camp-card__num">${c.num}</div>
      <h3 class="camp-card__title">${c.title}</h3>
      <p class="camp-card__desc">${c.description}</p>
      <span class="camp-card__cta">${c.cta} →</span>
    </a>
  `).join('');

  return `
    <section class="hub-hero">
      <div class="hub-hero__kicker">Seis campanhas · Janela de captação maio-junho 2026</div>
      <h1>Não escolhemos uma escola.<br>Reconhecemos um <em>caminho</em>.</h1>
      <p class="hub-hero__lead">Seis formas distintas de iniciar uma conversa com a ESPRODOURO. Três para jovens em ano de decisão. Três para as suas famílias. Todas operam por WhatsApp — onde estão as conversas que importam.</p>
      <div class="hub-hero__divider">Escolhe a tua</div>
    </section>
    <section class="campaigns">${cards}</section>
  `;
}

// ───────────────────────────────────────────────────────────────
// CAMPAIGN PAGE
// ───────────────────────────────────────────────────────────────
function renderCampaign(id) {
  const c = CAMPAIGNS[id];
  const isYouth = c.role === 'jovem';

  const fields = isYouth ? `
    <div class="field">
      <label for="nome">Primeiro nome</label>
      <input type="text" id="nome" name="nome" required autocomplete="given-name" placeholder="Como te tratamos?">
    </div>
    <div class="field">
      <label for="telefone">Número de WhatsApp</label>
      <input type="tel" id="telefone" name="telefone" required autocomplete="tel" placeholder="9XX XXX XXX" inputmode="numeric" pattern="[0-9 +]{9,15}">
    </div>
    <div class="field">
      <label for="escola">Escola que frequentas</label>
      <input type="text" id="escola" name="escola" autocomplete="organization" placeholder="Nome da escola (opcional)">
    </div>
    <div class="field">
      <label>Ano que frequentas</label>
      <div class="field-radio">
        <div class="radio-pill"><input type="radio" id="y8" name="ano" value="8º ano"><label for="y8">8.º ano</label></div>
        <div class="radio-pill"><input type="radio" id="y9" name="ano" value="9º ano" checked><label for="y9">9.º ano</label></div>
        <div class="radio-pill"><input type="radio" id="y10" name="ano" value="10º ano"><label for="y10">10.º ano</label></div>
      </div>
    </div>
  ` : `
    <div class="field">
      <label for="nome">Como o(a) podemos tratar?</label>
      <input type="text" id="nome" name="nome" required autocomplete="name" placeholder="Nome próprio basta">
    </div>
    <div class="field">
      <label for="telefone">Número de WhatsApp</label>
      <input type="tel" id="telefone" name="telefone" required autocomplete="tel" placeholder="9XX XXX XXX" inputmode="numeric" pattern="[0-9 +]{9,15}">
    </div>
    <div class="field">
      <label for="filho_ano">Ano que o(a) seu/sua filho(a) frequenta</label>
      <select id="filho_ano" name="filho_ano">
        <option value="">Selecionar (opcional)</option>
        <option value="7º ano">7.º ano</option>
        <option value="8º ano">8.º ano</option>
        <option value="9º ano" selected>9.º ano</option>
        <option value="10º ano">10.º ano</option>
        <option value="Outro">Outro</option>
      </select>
    </div>
    <div class="field">
      <label for="zona">Zona / Concelho</label>
      <input type="text" id="zona" name="zona" placeholder="Por ex.: São João da Pesqueira (opcional)">
    </div>
  `;

  const consentExtras = isYouth ? `
    <div class="consent-row">
      <input type="checkbox" id="c-idade" name="c-idade" required>
      <label for="c-idade">Confirmo que tenho mais de 16 anos <strong>OU</strong> tenho autorização do meu encarregado de educação para participar nesta campanha.</label>
    </div>
  ` : '';

  return `
    <article class="campaign-page">
      <div class="campaign-narrative">
        <a href="#/" onclick="navigate('/'); return false;" class="back-link">← Voltar às campanhas</a>
        <div class="campaign-narrative__kicker">${c.num} · ${c.audienceLabel}</div>
        <h1>${c.title}</h1>
        <p class="campaign-narrative__sub">${c.short}</p>
        <div class="campaign-narrative__body">
          ${c.narrative.map(p => `<p>${p}</p>`).join('')}
        </div>
        <div class="campaign-narrative__meta">
          ${c.meta.map(m => `
            <div class="meta-item">
              <span class="meta-item__label">${m.label}</span>
              <span class="meta-item__val">${m.val}</span>
            </div>
          `).join('')}
        </div>
      </div>

      <div class="campaign-form">
        <h2 class="campaign-form__title">${c.formTitle}</h2>
        <p class="campaign-form__sub">${c.formSub}</p>
        <form id="campaign-form" data-campaign="${id}" novalidate>
          ${fields}
          <div class="consent-block">
            ${consentExtras}
            <div class="consent-row">
              <input type="checkbox" id="c-rgpd" name="c-rgpd" required>
              <label for="c-rgpd">Aceito que a ESPRODOURO me contacte por WhatsApp no âmbito desta campanha. Posso descontinuar a qualquer momento enviando STOP.</label>
            </div>
            <div class="consent-row">
              <input type="checkbox" id="c-news" name="c-news">
              <label for="c-news">(Opcional) Aceito receber outras comunicações relevantes da ESPRODOURO.</label>
            </div>
          </div>
          <div class="field-error hidden" id="form-error"></div>
          <button type="submit" class="submit-btn">${c.cta} →</button>
        </form>
      </div>
    </article>
  `;
}

// ───────────────────────────────────────────────────────────────
// FORM HANDLING + STORAGE
// ───────────────────────────────────────────────────────────────
function attachFormHandler(campId) {
  const form = document.getElementById('campaign-form');
  if (!form) return;
  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const errEl = document.getElementById('form-error');
    errEl.classList.add('hidden');
    errEl.textContent = '';

    const data = Object.fromEntries(new FormData(form).entries());
    
    // Phone validation: PT format
    const phone = (data.telefone || '').replace(/[\s+]/g, '');
    if (!/^9\d{8}$/.test(phone) && !/^\+?351?9\d{8}$/.test(phone)) {
      errEl.textContent = 'Por favor introduza um número de WhatsApp português válido (9 dígitos a começar por 9).';
      errEl.classList.remove('hidden');
      return;
    }

    // Required consent
    if (!data['c-rgpd']) {
      errEl.textContent = 'É necessário aceitar a comunicação por WhatsApp para prosseguir.';
      errEl.classList.remove('hidden');
      return;
    }
    if (CAMPAIGNS[campId].role === 'jovem' && !data['c-idade']) {
      errEl.textContent = 'É necessário confirmar a autorização de idade para prosseguir.';
      errEl.classList.remove('hidden');
      return;
    }

    const submitBtn = form.querySelector('.submit-btn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'A registar...';

    // Save to persistent storage
    const contactId = `${Date.now()}_${Math.random().toString(36).substr(2, 6)}`;
    const contact = {
      id: contactId,
      campaign: campId,
      campaignTitle: CAMPAIGNS[campId].title.replace(/<[^>]*>/g, ''),
      role: CAMPAIGNS[campId].role,
      nome: data.nome,
      telefone: phone.length === 9 ? '+351 ' + phone : phone,
      escola: data.escola || data.zona || '',
      ano: data.ano || data.filho_ano || '',
      consentNews: !!data['c-news'],
      timestamp: new Date().toISOString(),
      // ─── INTEGRAÇÃO WHATSAPP API ───
      // Aqui é onde o backend dispararia a chamada à API do BSP (Wati / 360dialog / Twilio)
      // Exemplo: await fetch('https://api.wati.io/v1/sendTemplate', { headers: { Authorization: 'Bearer ' + WATI_TOKEN }, body: JSON.stringify({ phone, template: 'decoder_welcome', params: [data.nome] }) })
      whatsappStatus: 'simulated_sent'
    };

    try {
      await window.storage.set(`contacts:${contactId}`, JSON.stringify(contact), true);
    } catch (err) {
      console.error('Storage error:', err);
    }

    navigate(`/sucesso/${campId}/${contactId}`);
  });
}

// ───────────────────────────────────────────────────────────────
// SUCCESS PAGE WITH WHATSAPP PREVIEW
// ───────────────────────────────────────────────────────────────
async function renderSuccess(app, campId, contactId) {
  const c = CAMPAIGNS[campId];
  if (!c) { app.innerHTML = '<p>Campanha não encontrada.</p>'; return; }

  let nome = 'Olá';
  try {
    const r = await window.storage.get(`contacts:${contactId}`);
    if (r) {
      const contact = JSON.parse(r.value);
      nome = contact.nome.split(' ')[0];
    }
  } catch(e) { /* ignore */ }

  const now = new Date();
  const time = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');

  const messages = c.waMessages.map((m, i) => {
    const text = m.text.replace('{nome}', nome);
    return `
      <div class="wa-msg" style="animation-delay:${m.delay}s;">
        ${text}
        <span class="wa-msg__time">${time}</span>
      </div>
    `;
  }).join('');

  app.innerHTML = `
    <section class="success-page">
      <div class="success-narrative">
        <div class="success-narrative__check">✓</div>
        <h1>Inscrição registada,<br>${nome}.</h1>
        <p>A primeira mensagem está a ser enviada para o teu WhatsApp neste momento. Deve chegar em menos de 60 segundos.</p>
        <p>Se não receberes nada nos próximos 5 minutos, verifica se o número está bem escrito ou contacta-nos pelo +351 _ _ _.</p>
        <a href="#/" onclick="navigate('/'); return false;" class="success-narrative__home">← Voltar ao início</a>
      </div>
      <div class="phone-side">
        <div>
          <div class="phone-mockup">
            <div class="phone-screen">
              <div class="wa-header">
                <div class="wa-header__avatar">E</div>
                <div class="wa-header__info">
                  <div class="wa-header__name">ESPRODOURO</div>
                  <div class="wa-header__status">online</div>
                </div>
              </div>
              <div class="wa-body">
                ${messages}
              </div>
            </div>
          </div>
          <div class="phone-caption">Pré-visualização · primeira mensagem automática</div>
        </div>
      </div>
    </section>
  `;
}

// ───────────────────────────────────────────────────────────────
// ADMIN DASHBOARD
// ───────────────────────────────────────────────────────────────
let adminFilter = 'all';

async function renderAdmin(app) {
  app.innerHTML = `
    <section class="admin">
      <div class="admin__header">
        <h1>Painel <em>Admin</em></h1>
        <div class="admin__actions">
          <button class="btn-action btn-action--ghost" onclick="exportCSV()">Exportar CSV</button>
          <button class="btn-action" onclick="confirmReset()">Limpar dados</button>
        </div>
      </div>
      <div id="admin-content"><p style="color:var(--mist);font-family:var(--mono);font-size:11px;letter-spacing:0.15em;">A carregar...</p></div>
    </section>
  `;

  await renderAdminContent();
}

async function renderAdminContent() {
  const content = document.getElementById('admin-content');
  if (!content) return;

  let contacts = [];
  try {
    const list = await window.storage.list('contacts:', true);
    if (list && list.keys) {
      for (const k of list.keys) {
        try {
          const r = await window.storage.get(k, true);
          if (r) contacts.push(JSON.parse(r.value));
        } catch(e) {}
      }
    }
  } catch(e) { console.error(e); }

  contacts.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

  // METRICS
  const total = contacts.length;
  const youth = contacts.filter(c => c.role === 'jovem').length;
  const family = contacts.filter(c => c.role === 'familia').length;
  const last7 = contacts.filter(c => (Date.now() - new Date(c.timestamp).getTime()) < 7 * 24 * 60 * 60 * 1000).length;

  const byCampaign = {};
  Object.keys(CAMPAIGNS).forEach(k => byCampaign[k] = 0);
  contacts.forEach(c => { byCampaign[c.campaign] = (byCampaign[c.campaign] || 0) + 1; });

  // FILTER
  const filtered = adminFilter === 'all' ? contacts : contacts.filter(c => c.campaign === adminFilter);

  const filterPills = `
    <button class="filter-pill ${adminFilter==='all'?'active':''}" onclick="setFilter('all')">Todas (${total})</button>
    ${Object.entries(CAMPAIGNS).map(([id, c]) => `
      <button class="filter-pill ${adminFilter===id?'active':''}" onclick="setFilter('${id}')">${c.title.replace(/<[^>]*>/g,'')} (${byCampaign[id]||0})</button>
    `).join('')}
  `;

  const tableHtml = filtered.length === 0 ? `
    <div class="contacts-table">
      <div class="empty-state">
        <div class="empty-state__icon">∅</div>
        <p>Ainda não há contactos registados nesta secção. Os contactos capturados pelas landing pages aparecem aqui em tempo real.</p>
      </div>
    </div>
  ` : `
    <div class="contacts-table">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>WhatsApp</th>
            <th>Campanha</th>
            <th>Papel</th>
            <th>Escola / Zona</th>
            <th>Ano</th>
            <th>Quando</th>
          </tr>
        </thead>
        <tbody>
          ${filtered.map(c => `
            <tr>
              <td>${escapeHtml(c.nome)}</td>
              <td class="col-phone">${escapeHtml(c.telefone)}</td>
              <td><span class="col-tag" style="color:${CAMPAIGNS[c.campaign]?.audience==='jovem'?'var(--terracotta)':'var(--vineyard)'}">${escapeHtml(c.campaignTitle)}</span></td>
              <td><span class="col-tag">${c.role==='jovem'?'Jovem':'Família'}</span></td>
              <td>${escapeHtml(c.escola || '—')}</td>
              <td>${escapeHtml(c.ano || '—')}</td>
              <td>${formatDate(c.timestamp)}</td>
            </tr>
          `).join('')}
        </tbody>
      </table>
    </div>
  `;

  content.innerHTML = `
    <div class="metrics">
      <div class="metric">
        <div class="metric__label">Total contactos</div>
        <div class="metric__value">${total}</div>
      </div>
      <div class="metric">
        <div class="metric__label">Jovens captados</div>
        <div class="metric__value"><em>${youth}</em></div>
      </div>
      <div class="metric">
        <div class="metric__label">Famílias captadas</div>
        <div class="metric__value"><em>${family}</em></div>
      </div>
      <div class="metric">
        <div class="metric__label">Últimos 7 dias</div>
        <div class="metric__value">${last7}</div>
      </div>
    </div>
    <div class="filter-bar">${filterPills}</div>
    ${tableHtml}
  `;
}

function setFilter(f) {
  adminFilter = f;
  renderAdminContent();
}

async function confirmReset() {
  if (!confirm('Tem a certeza que pretende eliminar TODOS os contactos? Esta ação é irreversível.')) return;
  try {
    const list = await window.storage.list('contacts:', true);
    if (list && list.keys) {
      for (const k of list.keys) {
        await window.storage.delete(k, true);
      }
    }
  } catch(e) { console.error(e); }
  renderAdminContent();
}

async function exportCSV() {
  let contacts = [];
  try {
    const list = await window.storage.list('contacts:', true);
    if (list && list.keys) {
      for (const k of list.keys) {
        try {
          const r = await window.storage.get(k, true);
          if (r) contacts.push(JSON.parse(r.value));
        } catch(e) {}
      }
    }
  } catch(e) {}

  if (contacts.length === 0) { alert('Não há contactos para exportar.'); return; }

  const headers = ['Nome', 'WhatsApp', 'Campanha', 'Papel', 'Escola/Zona', 'Ano', 'Aceita newsletters', 'Data/Hora'];
  const rows = contacts.map(c => [
    c.nome, c.telefone, c.campaignTitle, c.role,
    c.escola || '', c.ano || '',
    c.consentNews ? 'Sim' : 'Não',
    c.timestamp
  ]);

  const csv = [headers, ...rows].map(row =>
    row.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(',')
  ).join('\n');

  const bom = '\uFEFF';
  const blob = new Blob([bom + csv], { type: 'text/csv;charset=utf-8' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `esprodouro_contactos_${new Date().toISOString().slice(0,10)}.csv`;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
}

function formatDate(iso) {
  const d = new Date(iso);
  const now = new Date();
  const diffMs = now - d;
  const diffMin = Math.floor(diffMs / 60000);
  if (diffMin < 1) return 'agora mesmo';
  if (diffMin < 60) return `há ${diffMin} min`;
  if (diffMin < 1440) return `há ${Math.floor(diffMin/60)} h`;
  const dd = d.getDate().toString().padStart(2,'0');
  const mm = (d.getMonth()+1).toString().padStart(2,'0');
  const hh = d.getHours().toString().padStart(2,'0');
  const min = d.getMinutes().toString().padStart(2,'0');
  return `${dd}/${mm} ${hh}:${min}`;
}

function escapeHtml(s) {
  return String(s == null ? '' : s)
    .replace(/&/g,'&amp;')
    .replace(/</g,'&lt;')
    .replace(/>/g,'&gt;')
    .replace(/"/g,'&quot;');
}