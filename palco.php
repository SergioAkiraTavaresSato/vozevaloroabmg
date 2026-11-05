<?php
/** Modo Palco — para o telão: QR Code gigante por uso, navegação por teclado/clicker e contador ao vivo. */
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/inc/data.php';
require __DIR__ . '/inc/layout.php';

$url = site_url();
vv_head('Palco · Voz e Valor', 'Modo apresentação da palestra.', 'pg-palco');

$slides = [];
$slides[] = ['tipo' => 'abertura'];
$slides[] = ['tipo' => 'login'];
$slides[] = ['tipo' => 'valor'];
foreach ($BLOCOS as $bk => $b) {
    $slides[] = ['tipo' => 'bloco', 'b' => $b, 'bk' => $bk];
    foreach ($USOS as $u) {
        if ($u['bloco'] === $bk) { $slides[] = ['tipo' => 'uso', 'u' => $u]; }
    }
}
$slides[] = ['tipo' => 'etica'];
$slides[] = ['tipo' => 'fim'];
?>
<div class="stage" id="stage">
<?php foreach ($slides as $i => $s): ?>
  <section class="slide s-<?= e($s['tipo']) ?>" data-i="<?= $i ?>" <?= isset($s['u']) ? 'data-uso="' . $s['u']['id'] . '"' : '' ?> hidden>
  <?php switch ($s['tipo']):
    case 'abertura': ?>
      <div class="s-split">
        <div>
          <div class="hero-oab"><?= vv_oab() ?></div>
          <?= vv_brand('brand-xl') ?>
          <h1 class="hash"><span class="hash-sym">#</span><span>Eu Uso<br><em>IA</em></span></h1>
          <p class="s-lead"><?= e(PALESTRA_TITULO) ?><br><small><?= e(PALESTRANTE) ?></small></p>
        </div>
        <div class="qr-col">
          <div class="qr-big" data-qr="<?= e($url) ?>/"></div>
          <p class="qr-cap">Aponte a câmera do celular</p>
          <p class="qr-url"><?= e(preg_replace('#^https?://#', '', $url)) ?></p>
          <p class="counter"><b data-total>0</b> prompts usados ao vivo</p>
        </div>
      </div>
    <?php break; case 'login': ?>
      <p class="eyebrow">Passo 1 · agora</p>
      <h2 class="s-h">Entre com sua conta Google</h2>
      <div class="s-ias">
        <?php foreach ($IAS as $k => $i): ?>
          <div class="s-ia" style="--c:<?= e($i['cor']) ?>"><span class="mono"><?= e($i['sigla']) ?></span><b><?= e($i['nome']) ?></b><?php if ($i['google']): ?><?= icon('g', 'ic g') ?><?php endif; ?></div>
        <?php endforeach; ?>
      </div>
      <p class="s-foot">Comece pelo <b>ChatGPT</b> e pelo <b>Gemini</b>. Com uma conta Google, você entra em 13 das 15.</p>
    <?php break; case 'valor': ?>
      <p class="eyebrow">O método</p>
      <h2 class="s-h">Dê <em>voz</em> ao prompt. Receba <em>valor</em>.</h2>
      <div class="s-valor">
        <?php foreach ([['V', 'Visão', 'Quem a IA deve ser'], ['A', 'Assunto', 'Contexto e fatos anonimizados'], ['L', 'Limites', 'O que não fazer · fontes · tom'], ['O', 'Objetivo', 'Entregável e formato'], ['R', 'Revisão', 'Autocrítica e perguntas']] as [$l, $n, $d]): ?>
          <div><span><?= $l ?></span><b><?= $n ?></b><small><?= $d ?></small></div>
        <?php endforeach; ?>
      </div>
    <?php break; case 'bloco': ?>
      <div class="s-bloco">
        <span class="bn"><?= e($s['b']['n']) ?></span>
        <h2 class="s-h"><?= e($s['b']['nome']) ?></h2>
        <p><?= count(array_filter($USOS, fn($u) => $u['bloco'] === $s['bk'])) ?> usos</p>
      </div>
    <?php break; case 'uso': $u = $s['u']; $ia = $IAS[$u['ia']]; $nn = str_pad((string) $u['id'], 2, '0', STR_PAD_LEFT); ?>
      <div class="s-split">
        <div class="s-uso" style="--c:<?= e($ia['cor']) ?>">
          <p class="eyebrow">Uso <?= $nn ?> de 30 · <?= e($BLOCOS[$u['bloco']]['nome']) ?></p>
          <div class="s-n"><?= $nn ?></div>
          <h2 class="s-h"><?= e($u['titulo']) ?></h2>
          <p class="s-meta"><span class="pill" style="--c:<?= e($ia['cor']) ?>"><?= e($ia['nome']) ?></span><span><?= icon('clock') ?> <?= e($u['tempo']) ?></span><?php if (!empty($u['aovivo'])): ?><span class="live">AO VIVO</span><?php endif; ?></p>
          <p class="s-porque"><?= e($u['porque']) ?></p>
        </div>
        <div class="qr-col">
          <div class="qr-big" data-qr="<?= e($url) ?>/#uso-<?= $nn ?>"></div>
          <p class="qr-cap">Escaneie e toque em <b>Copiar &amp; abrir</b></p>
          <p class="counter"><b data-uso-count="<?= $u['id'] ?>">0</b> colegas já usaram</p>
        </div>
      </div>
    <?php break; case 'etica': ?>
      <p class="eyebrow">Inegociável</p>
      <h2 class="s-h">As 7 regras de ouro</h2>
      <ol class="s-regras">
        <li>Sigilo primeiro: anonimize sempre</li><li>Confira toda citação na fonte oficial</li><li>A assinatura — e a responsabilidade — é sua</li><li>Desative o uso das conversas para treino</li><li>Política de IA e LGPD no escritório</li><li>Transparência com o cliente</li><li>Publicidade ética: Provimento 205/2021</li>
      </ol>
    <?php break; case 'fim': ?>
      <div class="s-split">
        <div>
          <h2 class="s-h big">A IA não substitui o advogado.<br><em>O advogado que usa IA substitui o que não usa.</em></h2>
          <p class="s-lead"><?= e(PALESTRANTE) ?><br><small><?= e(EVENTO_NOME) ?> · <?= e(EVENTO_LOCAL) ?></small></p>
        </div>
        <div class="qr-col">
          <div class="qr-big" data-qr="<?= e($url) ?>/"></div>
          <p class="qr-cap">Leve os 30 usos com você</p>
          <p class="counter"><b data-total>0</b> prompts usados hoje</p>
        </div>
      </div>
  <?php break; endswitch; ?>
  </section>
<?php endforeach; ?>
</div>

<nav class="palco-nav">
  <button id="pv" aria-label="Anterior">‹</button>
  <span id="pos">1 / <?= count($slides) ?></span>
  <button id="nx" aria-label="Próximo">›</button>
  <span class="kbd">← → navegar · F tela cheia · número + Enter vai ao uso · B tela preta</span>
</nav>
<div class="blackout" id="blackout" hidden></div>
<?= vv_skyline() ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<?php vv_foot(['assets/js/palco.js']); ?>
