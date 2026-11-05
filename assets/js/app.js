/* Voz e Valor · IA na Advocacia — interações do participante */
(() => {
  'use strict';
  const $ = (s, el = document) => el.querySelector(s);
  const $$ = (s, el = document) => [...el.querySelectorAll(s)];
  const DATA = JSON.parse($('#vv-data').textContent);
  const MAX_URL = 3800;          // limite seguro para prompt na URL (deep link)
  const store = {
    get(k, d) { try { return JSON.parse(localStorage.getItem('vv:' + k)) ?? d; } catch { return d; } },
    set(k, v) { try { localStorage.setItem('vv:' + k, JSON.stringify(v)); } catch { /* modo privado */ } },
  };
  let favs = new Set(store.get('favs', []));
  let feitos = new Set(store.get('feitos', []));

  /* ── Toast ── */
  const toastEl = $('#toast');
  let toastT;
  function toast(html, ms = 3800) {
    toastEl.innerHTML = html;
    toastEl.classList.add('show');
    clearTimeout(toastT);
    toastT = setTimeout(() => toastEl.classList.remove('show'), ms);
  }

  /* ── Cópia síncrona (funciona no iOS dentro do toque) + API moderna ── */
  function copy(text) {
    let ok = false;
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.setAttribute('readonly', '');
    ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;font-size:16px';
    document.body.appendChild(ta);
    ta.select();
    ta.setSelectionRange(0, text.length);
    try { ok = document.execCommand('copy'); } catch { ok = false; }
    ta.remove();
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text).catch(() => {});
      ok = true;
    }
    return ok;
  }

  function hit(u, a, ia) {
    try {
      const body = JSON.stringify({ u, a, ia });
      if (navigator.sendBeacon) navigator.sendBeacon('api/hit.php', new Blob([body], { type: 'application/json' }));
    } catch { /* estatística é opcional */ }
  }

  function linkFor(iaKey, text) {
    const ia = DATA.ias[iaKey];
    if (ia.q) {
      const u = ia.q.replace('%s', encodeURIComponent(text));
      if (u.length <= MAX_URL) return u;
    }
    return ia.url;
  }

  /* ── Preenchimento dos prompts ── */
  function fill(art) {
    const uso = DATA.usos[art.dataset.id];
    const vals = {};
    $$('[data-var]', art).forEach(el => { vals[el.dataset.var] = el.value.trim(); });
    const text = uso.prompt.replace(/\{\{(\w+)\}\}/g, (_, k) => vals[k] || `[${k.toUpperCase()}]`);
    art._text = text;
    const pre = $('.prompt', art);
    if (pre) {
      const esc = s => s.replace(/[&<>]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c]));
      pre.innerHTML = esc(uso.prompt).replace(/\{\{(\w+)\}\}/g, (_, k) => `<mark>${esc(vals[k] || '[' + k.toUpperCase() + ']')}</mark>`);
    }
    $$('a[data-act="open"]', art).forEach(a => { a.href = linkFor(a.dataset.ia, text); });
    return text;
  }

  function toggle(art, force) {
    const head = $('.uso-head', art), body = $('.uso-body', art);
    const open = force ?? body.hidden;
    body.hidden = !open;
    art.classList.toggle('open', open);
    head.setAttribute('aria-expanded', String(open));
    if (open) fill(art);
  }

  function marcarFeito(art) {
    const id = art.dataset.id;
    feitos.add(id);
    store.set('feitos', [...feitos]);
    art.classList.add('done');
    progresso();
  }

  function progresso() {
    const el = $('#progresso');
    if (!el || !feitos.size) return;
    el.hidden = false;
    $('.bar i', el).style.width = (feitos.size / 30 * 100) + '%';
    $('.txt', el).textContent = `Você já usou ${feitos.size} de 30`;
  }

  /* ── Eventos dos cards ── */
  $$('.uso').forEach(art => {
    if (favs.has(art.dataset.id)) $('[data-act="fav"]', art).setAttribute('aria-pressed', 'true');
    if (feitos.has(art.dataset.id)) art.classList.add('done');
    $('.uso-head', art).addEventListener('click', () => toggle(art));
    $$('[data-var]', art).forEach(el => el.addEventListener('input', () => fill(art)));
  });

  document.addEventListener('click', ev => {
    const el = ev.target.closest('[data-act]');
    if (!el) return;
    const art = el.closest('.uso');
    const act = el.dataset.act;

    if (act === 'open' && art) {
      const text = fill(art);            // garante o texto e o href atualizados
      copy(text);
      const ia = DATA.ias[el.dataset.ia];
      const pre = el.href !== ia.url;
      toast(`<b>Prompt copiado ✓</b>${pre ? `Abrindo o ${ia.nome} com o texto. Confira e envie.` : `No ${ia.nome}, toque e segure na caixa de texto → <u>Colar</u>.`}`, 5200);
      marcarFeito(art);
      hit(+art.dataset.id, 'open', el.dataset.ia);
      return;                            // deixa o link abrir normalmente (nova aba/app)
    }
    if (act === 'copy' && art) {
      copy(fill(art));
      toast('<b>Prompt copiado ✓</b>Cole na IA de sua preferência.');
      marcarFeito(art);
      hit(+art.dataset.id, 'copy', art.dataset.ia);
    }
    if (act === 'fav' && art) {
      const id = art.dataset.id;
      favs.has(id) ? favs.delete(id) : favs.add(id);
      store.set('favs', [...favs]);
      el.setAttribute('aria-pressed', String(favs.has(id)));
      toast(favs.has(id) ? '<b>Salvo nos favoritos ★</b>Filtre por “Favoritos” para achar depois.' : 'Removido dos favoritos.');
    }
    if (act === 'share' && art) {
      const url = `${DATA.site}/#${art.id}`;
      share(DATA.usos[art.dataset.id].titulo, url);
    }
    if (act === 'share-site') share('30 usos de IA para advogados · Voz e Valor', DATA.site + '/');
    if (act === 'open-valor') {
      copy(valorText());
      toast(`<b>Prompt V·A·L·O·R copiado ✓</b>Cole na IA se ele não aparecer escrito.`, 5000);
      hit(0, 'valor', $('#valorIa').value);
    }
  });

  function share(title, url) {
    if (navigator.share) {
      navigator.share({ title, text: title, url }).catch(() => {});
    } else {
      copy(url);
      toast('<b>Link copiado ✓</b>Envie para um colega no WhatsApp.');
    }
  }

  /* ── Filtros e busca ── */
  const state = { bloco: '', ia: '', q: '' };
  const norm = s => s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();

  function aplicar() {
    const q = norm(state.q);
    let vis = 0;
    $$('.uso').forEach(art => {
      const d = art.dataset;
      let ok = true;
      if (state.bloco === 'aovivo') ok = d.aovivo === '1';
      else if (state.bloco === 'fav') ok = favs.has(d.id);
      else if (state.bloco) ok = d.bloco === state.bloco;
      if (ok && state.ia) ok = d.ia === state.ia || d.alt.split(' ').includes(state.ia);
      if (ok && q) ok = norm(d.busca).includes(q);
      art.hidden = !ok;
      if (ok) vis++;
    });
    $$('.bloco').forEach(b => { b.hidden = !$$('.uso:not([hidden])', b).length; });
    $('#vazio').hidden = vis > 0;
    const fi = $('#filtroIa');
    fi.hidden = !state.ia;
    if (state.ia) $('span', fi).innerHTML = `Usos com <b>${DATA.ias[state.ia].nome}</b> (${vis})`;
  }

  $$('.chip[data-bloco]').forEach(c => c.addEventListener('click', () => {
    $$('.chip[data-bloco]').forEach(x => x.classList.toggle('on', x === c));
    state.bloco = c.dataset.bloco;
    aplicar();
  }));
  $('#busca').addEventListener('input', e => { state.q = e.target.value; aplicar(); });
  $('#btnBusca').addEventListener('click', () => {
    $('#usos').scrollIntoView({ behavior: 'smooth' });
    setTimeout(() => $('#busca').focus({ preventScroll: true }), 350);
  });
  $$('.ia-filter').forEach(b => b.addEventListener('click', () => {
    state.ia = b.dataset.ia;
    aplicar();
    $('#usos').scrollIntoView({ behavior: 'smooth' });
  }));
  $('#limpaIa').addEventListener('click', () => { state.ia = ''; aplicar(); });

  /* ── Abrir uso pelo link (#uso-07), vindo do QR do telão ── */
  function abrirHash() {
    const m = location.hash.match(/^#uso-(\d{2})$/);
    if (!m) return;
    const art = document.getElementById('uso-' + m[1]);
    if (!art) return;
    state.bloco = ''; state.ia = ''; state.q = '';
    aplicar();
    toggle(art, true);
    setTimeout(() => art.scrollIntoView({ behavior: 'smooth', block: 'start' }), 60);
  }
  addEventListener('hashchange', abrirHash);
  abrirHash();
  progresso();

  /* ── Método V·A·L·O·R ── */
  const nomes = { V: 'VISÃO (seu papel)', A: 'ASSUNTO (contexto)', L: 'LIMITES', O: 'OBJETIVO (entrega e formato)', R: 'REVISÃO' };
  function valorText() {
    return $$('[data-valor]').map(t => t.value.trim() ? `${nomes[t.dataset.valor]}:\n${t.value.trim()}` : '').filter(Boolean).join('\n\n');
  }
  function valorRender() {
    const t = valorText();
    $('#valorPrompt').textContent = t;
    $('#valorAbrir').href = linkFor($('#valorIa').value, t);
  }
  $$('[data-valor]').forEach(t => t.addEventListener('input', valorRender));
  $('#valorIa').addEventListener('change', valorRender);
  valorRender();

  /* ── QR do site (rodapé) ── */
  function qr() {
    const box = $('#qrSite');
    if (!box || !window.QRCode) return;
    new QRCode(box, { text: box.dataset.url, width: 360, height: 360, colorDark: '#1b2330', colorLight: '#efe5d3', correctLevel: QRCode.CorrectLevel.M });
  }
  window.QRCode ? qr() : addEventListener('load', qr);

  /* ── Instalar como app (PWA) ── */
  let deferred;
  addEventListener('beforeinstallprompt', e => { e.preventDefault(); deferred = e; $('#btnInstalar').hidden = false; });
  $('#btnInstalar').addEventListener('click', () => { deferred && deferred.prompt(); });
})();
