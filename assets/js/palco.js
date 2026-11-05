/* Modo Palco — navegação por teclado/clicker, QR sob demanda e contadores ao vivo */
(() => {
  'use strict';
  const slides = [...document.querySelectorAll('.slide')];
  const pos = document.getElementById('pos');
  let cur = 0, typed = '', typedT;

  function qr(slide) {
    slide.querySelectorAll('[data-qr]').forEach(box => {
      if (box.dataset.done || !window.QRCode) return;
      new QRCode(box, { text: box.dataset.qr, width: 640, height: 640, colorDark: '#141a24', colorLight: '#efe5d3', correctLevel: QRCode.CorrectLevel.M });
      box.dataset.done = '1';
    });
  }

  function go(i) {
    cur = Math.max(0, Math.min(slides.length - 1, i));
    slides.forEach((s, k) => { s.hidden = k !== cur; });
    qr(slides[cur]);
    pos.textContent = `${cur + 1} / ${slides.length}`;
    history.replaceState(null, '', '#s=' + cur);
  }

  function goUso(n) {
    const k = slides.findIndex(s => s.dataset.uso === String(n));
    if (k >= 0) go(k);
  }

  document.addEventListener('keydown', e => {
    if (/^\d$/.test(e.key)) {
      typed += e.key; clearTimeout(typedT);
      typedT = setTimeout(() => { typed = ''; }, 1500);
      return;
    }
    if (e.key === 'Enter' && typed) { goUso(+typed); typed = ''; return; }
    if (['ArrowRight', 'PageDown', ' ', 'ArrowDown'].includes(e.key)) { e.preventDefault(); go(cur + 1); }
    if (['ArrowLeft', 'PageUp', 'ArrowUp'].includes(e.key)) { e.preventDefault(); go(cur - 1); }
    if (e.key === 'Home') go(0);
    if (e.key === 'End') go(slides.length - 1);
    if (e.key.toLowerCase() === 'f') document.fullscreenElement ? document.exitFullscreen() : document.documentElement.requestFullscreen().catch(() => {});
    if (e.key.toLowerCase() === 'b' || e.key === '.') { const b = document.getElementById('blackout'); b.hidden = !b.hidden; }
  });
  document.getElementById('pv').onclick = () => go(cur - 1);
  document.getElementById('nx').onclick = () => go(cur + 1);

  let x0 = null;
  addEventListener('touchstart', e => { x0 = e.touches[0].clientX; }, { passive: true });
  addEventListener('touchend', e => {
    if (x0 === null) return;
    const dx = e.changedTouches[0].clientX - x0;
    if (Math.abs(dx) > 50) go(cur + (dx < 0 ? 1 : -1));
    x0 = null;
  });

  async function stats() {
    try {
      const r = await fetch('api/stats.php', { cache: 'no-store' });
      const d = await r.json();
      document.querySelectorAll('[data-total]').forEach(el => { el.textContent = (d.total || 0).toLocaleString('pt-BR'); });
      document.querySelectorAll('[data-uso-count]').forEach(el => { el.textContent = ((d.usos || {})[el.dataset.usoCount] || 0).toLocaleString('pt-BR'); });
    } catch { /* offline: mantém o último valor */ }
  }

  function start() {
    const m = location.hash.match(/s=(\d+)/);
    go(m ? +m[1] : 0);
    stats();
    setInterval(stats, 5000);
  }
  addEventListener('hashchange', () => { const m = location.hash.match(/s=(\d+)/); if (m && +m[1] !== cur) go(+m[1]); });
  window.QRCode ? start() : addEventListener('load', start);
})();
