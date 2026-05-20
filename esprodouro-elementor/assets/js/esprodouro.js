(function () {
    'use strict';

    document.addEventListener('submit', function (e) {
        var form = e.target.closest('.espro-form');
        if (!form) return;
        e.preventDefault();
        handleSubmit(form);
    });

    function handleSubmit(form) {
        var errEl = form.querySelector('.espro-form__error');
        errEl.style.display = 'none';
        errEl.textContent = '';

        var data = new FormData(form);
        var nome = (data.get('nome') || '').trim();
        var tel = (data.get('telefone') || '').trim();
        var campaign = form.getAttribute('data-campaign');

        if (!nome) {
            showError(errEl, 'O nome é obrigatório.');
            return;
        }

        var phone = tel.replace(/[\s+]/g, '');
        if (!/^9\d{8}$/.test(phone) && !/^\+?351?9\d{8}$/.test(phone)) {
            showError(errEl, 'Número de WhatsApp inválido (9 dígitos a começar por 9).');
            return;
        }

        if (!form.querySelector('input[name="c_rgpd"]').checked) {
            showError(errEl, 'É necessário aceitar a comunicação por WhatsApp.');
            return;
        }

        var idadeBox = form.querySelector('input[name="c_idade"]');
        if (idadeBox && !idadeBox.checked) {
            showError(errEl, 'É necessário confirmar a autorização de idade.');
            return;
        }

        var btn = form.querySelector('.espro-btn');
        btn.disabled = true;
        btn.textContent = 'A registar...';

        var body = new URLSearchParams();
        body.append('action', 'espro_submit');
        body.append('nonce', espro.nonce);
        body.append('campaign', campaign);

        for (var pair of data.entries()) {
            body.append(pair[0], pair[1]);
        }

        fetch(espro.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: body.toString()
        })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (res.success) {
                renderSuccess(form, res.data);
            } else {
                btn.disabled = false;
                btn.innerHTML = data.get('cta') || 'Enviar &rarr;';
                showError(errEl, res.data.message || 'Erro ao registar.');
            }
        })
        .catch(function () {
            btn.disabled = false;
            btn.innerHTML = 'Enviar &rarr;';
            showError(errEl, 'Erro de ligação. Tente novamente.');
        });
    }

    function showError(el, msg) {
        el.textContent = msg;
        el.style.display = 'block';
    }

    function renderSuccess(form, info) {
        var wrapper = form.closest('.espro-campaign');
        if (!wrapper) return;

        var backUrl = form.getAttribute('data-back') || '';
        var nome = info.nome.split(' ')[0];
        var now = new Date();
        var time = pad(now.getHours()) + ':' + pad(now.getMinutes());

        var msgs = (info.wa_messages || []).map(function (text, i) {
            var rendered = text.replace('{nome}', escapeHtml(nome));
            return '<div class="espro-wa-msg" style="animation-delay:' + (i * 1.2) + 's;">'
                + rendered
                + '<span class="espro-wa-msg__time">' + time + '</span>'
                + '</div>';
        }).join('');

        var backLink = backUrl
            ? '<a href="' + escapeHtml(backUrl) + '" class="espro-success__home">&larr; Voltar ao início</a>'
            : '';

        wrapper.innerHTML =
            '<div class="espro-success">'
            + '<div class="espro-success__info">'
                + '<div class="espro-success__check">&#10003;</div>'
                + '<h2>Inscrição registada,<br>' + escapeHtml(nome) + '.</h2>'
                + '<p>A primeira mensagem está a ser enviada para o teu WhatsApp neste momento. Deve chegar em menos de 60 segundos.</p>'
                + '<p>Se não receberes nada nos próximos 5 minutos, verifica se o número está correto.</p>'
                + backLink
            + '</div>'
            + '<div class="espro-phone-side">'
                + '<div>'
                    + '<div class="espro-phone">'
                        + '<div class="espro-phone__screen">'
                            + '<div class="espro-wa-header">'
                                + '<div class="espro-wa-avatar">E</div>'
                                + '<div class="espro-wa-header__info">'
                                    + '<div class="espro-wa-header__name">ESPRODOURO</div>'
                                    + '<div class="espro-wa-header__status">online</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="espro-wa-body">'
                                + '<div class="espro-wa-typing"><span></span><span></span><span></span></div>'
                                + msgs
                            + '</div>'
                        + '</div>'
                    + '</div>'
                    + '<div class="espro-phone__caption">Pré-visualização · primeira mensagem automática</div>'
                + '</div>'
            + '</div>'
            + '</div>';

        wrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function pad(n) {
        return n < 10 ? '0' + n : '' + n;
    }

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(s));
        return d.innerHTML;
    }
})();
