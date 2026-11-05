<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/inc/data.php';
require __DIR__ . '/inc/layout.php';

$foto = asset_img(['palestrante.jpg', 'palestrante.png', 'palestrante.webp']);
$url  = site_url();

// Dados mínimos para o JavaScript (templates de prompt e links das IAs).
$js = [
    'site' => $url,
    'ias'  => array_map(fn($i) => ['nome' => $i['nome'], 'url' => $i['url'], 'q' => $i['q'], 'cor' => $i['cor']], $IAS),
    'usos' => array_column(array_map(fn($u) => ['id' => $u['id'], 'ia' => $u['ia'], 'alt' => $u['alt'], 'prompt' => $u['prompt'], 'titulo' => $u['titulo']], $USOS), null, 'id'),
];

vv_head('IA na Advocacia · Voz e Valor', PALESTRA_SUB . ' — ' . EVENTO_NOME . ', ' . EVENTO_LOCAL . '.', 'pg-home');
?>
<a class="skip" href="#usos">Pular para os 30 usos</a>

<header class="topbar" id="topo">
  <a href="#topo" class="topbar-brand" aria-label="Início"><?= vv_brand('brand-sm') ?></a>
  <nav class="topnav" aria-label="Seções">
    <a href="#ias">15 IAs</a><a href="#usos">30 usos</a><a href="#valor">Método</a><a href="#etica">Ética</a>
  </nav>
  <button class="icon-btn" id="btnBusca" aria-label="Buscar prompt"><?= icon('search') ?></button>
</header>

<main>
<!-- ═════════ HERO ═════════ -->
<section class="hero">
  <div class="hero-grid wrap">
    <div class="hero-txt">
      <div class="hero-oab"><?= vv_oab() ?><span class="slogan">UNIR <small>PARA</small><br>AVANÇAR<br><small>FORTE E PRESENTE</small></span></div>
      <?= vv_brand('brand-lg') ?>
      <ul class="hero-meta">
        <li><?= icon('cal', 'ic gold') ?><b>04</b> a <b>06</b> de novembro</li>
        <li><?= icon('pin', 'ic gold') ?>Poços de Caldas</li>
      </ul>
      <h1 class="hash"><span class="hash-sym" aria-hidden="true">#</span><span>Eu Uso<br><em>IA</em></span></h1>
      <p class="lead"><strong><?= e(PALESTRA_TITULO) ?></strong><br>30 usos reais do dia a dia da advocacia em 15 IAs. Toque, copie, cole — direto do seu celular, com a sua conta Google.</p>
      <div class="hero-cta">
        <a class="btn btn-gold" href="#comece"><?= icon('bolt') ?> Começar agora</a>
        <a class="btn btn-ghost" href="#usos">Ver os 30 usos</a>
      </div>
      <div class="progress-pill" id="progresso" hidden><span class="bar"><i></i></span><span class="txt"></span></div>
    </div>
    <figure class="hero-photo">
      <?php if ($foto): ?>
        <img src="<?= e($foto) ?>" alt="<?= e(PALESTRANTE) ?>" width="560" height="640" fetchpriority="high">
      <?php else: ?>
        <div class="photo-ph"><span>IA</span></div>
      <?php endif; ?>
      <figcaption><b><?= e(PALESTRANTE) ?></b><span>Palestrante · IA aplicada à advocacia</span></figcaption>
    </figure>
  </div>
  <?= vv_skyline() ?>
</section>

<!-- ═════════ 3 PASSOS ═════════ -->
<section class="sec" id="comece">
  <div class="wrap">
    <p class="eyebrow">Antes de tudo · 60 segundos</p>
    <h2 class="h2">Como usar no celular</h2>
    <ol class="steps">
      <li><span>1</span><div><b>Entre em uma IA</b><p>Toque em “Entrar” e use “Continuar com Google”. Não precisa criar senha nova.</p></div></li>
      <li><span>2</span><div><b>Escolha um uso e ajuste</b><p>Os campos já vêm com um caso fictício. Troque pelos seus dados — sempre anonimizados.</p></div></li>
      <li><span>3</span><div><b>Copiar &amp; abrir</b><p>O prompt é copiado e a IA abre. Se não aparecer escrito, toque e segure na caixa de texto → <b>Colar</b>.</p></div></li>
    </ol>
    <div class="quick">
      <?php foreach (['chatgpt', 'gemini', 'claude', 'notebooklm'] as $k): $i = $IAS[$k]; ?>
        <a class="quick-ia" href="<?= e($i['url']) ?>" target="_blank" rel="noopener" style="--c:<?= e($i['cor']) ?>">
          <span class="mono"><?= e($i['sigla']) ?></span><span><b><?= e($i['nome']) ?></b><small><?= icon('g', 'ic g') ?> Entrar com Google</small></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═════════ 15 IAs ═════════ -->
<section class="sec sec-alt" id="ias">
  <div class="wrap">
    <p class="eyebrow">O arsenal</p>
    <h2 class="h2">As 15 IAs da palestra</h2>
    <p class="sub">Toque no nome para ver os usos daquela IA. Todas têm plano gratuito.</p>
    <div class="ia-grid">
      <?php foreach ($IAS as $k => $i): $n = count($USOS_POR_IA[$k] ?? []); ?>
        <div class="ia-card" style="--c:<?= e($i['cor']) ?>">
          <button class="ia-filter" data-ia="<?= e($k) ?>" aria-label="Ver usos do <?= e($i['nome']) ?>">
            <span class="mono"><?= e($i['sigla']) ?></span>
            <span class="ia-info"><b><?= e($i['nome']) ?></b><small><?= e($i['empresa']) ?> · <?= $n ?> uso<?= $n > 1 ? 's' : '' ?></small></span>
          </button>
          <p class="ia-forte"><?= e($i['forte']) ?></p>
          <div class="ia-foot">
            <span class="login"><?= $i['google'] ? icon('g', 'ic g') . 'Google' : e($i['login'] ?? '') ?></span>
            <a href="<?= e($i['url']) ?>" target="_blank" rel="noopener" class="ia-open">Entrar <?= icon('open') ?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═════════ 30 USOS ═════════ -->
<section class="sec" id="usos">
  <div class="wrap">
    <p class="eyebrow">A jornada do advogado</p>
    <h2 class="h2">30 usos para amanhã cedo</h2>

    <div class="filters" id="filtros">
      <label class="search"><?= icon('search') ?><input type="search" id="busca" placeholder="Buscar: contrato, prazo, WhatsApp…" autocomplete="off"></label>
      <div class="chips" role="toolbar" aria-label="Filtrar por etapa">
        <button class="chip on" data-bloco="">Todos</button>
        <button class="chip" data-bloco="aovivo"><?= icon('bolt') ?> Ao vivo</button>
        <button class="chip" data-bloco="fav"><?= icon('star') ?> Favoritos</button>
        <?php foreach ($BLOCOS as $bk => $b): ?>
          <button class="chip" data-bloco="<?= e($bk) ?>"><?= e($b['n']) ?> · <?= e(explode(' ', $b['nome'])[0]) ?></button>
        <?php endforeach; ?>
      </div>
      <div class="filter-ia" id="filtroIa" hidden><span></span><button class="chip on" id="limpaIa">× limpar</button></div>
    </div>

    <?php foreach ($BLOCOS as $bk => $b): ?>
      <div class="bloco" data-bloco-wrap="<?= e($bk) ?>">
        <h3 class="bloco-h"><span><?= e($b['n']) ?></span><?= e($b['nome']) ?></h3>
        <?php foreach ($USOS as $u): if ($u['bloco'] !== $bk) continue;
            $ia = $IAS[$u['ia']]; $nn = str_pad((string) $u['id'], 2, '0', STR_PAD_LEFT);
            $busca = mb_strtolower($u['titulo'] . ' ' . $u['porque'] . ' ' . $ia['nome'] . ' ' . $b['nome']); ?>
        <article class="uso" id="uso-<?= $nn ?>" data-id="<?= $u['id'] ?>" data-bloco="<?= e($bk) ?>" data-ia="<?= e($u['ia']) ?>" data-alt="<?= e(implode(' ', $u['alt'])) ?>" data-aovivo="<?= !empty($u['aovivo']) ? '1' : '0' ?>" data-busca="<?= e($busca) ?>" style="--c:<?= e($ia['cor']) ?>">
          <button class="uso-head" aria-expanded="false" aria-controls="uso-b-<?= $nn ?>">
            <span class="uso-n"><?= $nn ?></span>
            <span class="uso-t">
              <b><?= e($u['titulo']) ?></b>
              <span class="uso-meta">
                <span class="pill" style="--c:<?= e($ia['cor']) ?>"><?= e($ia['nome']) ?></span>
                <span class="tempo"><?= icon('clock') ?><?= e($u['tempo']) ?></span>
                <?php if (!empty($u['aovivo'])): ?><span class="live">AO VIVO</span><?php endif; ?>
                <span class="done-tag"><?= icon('check') ?>feito</span>
              </span>
            </span>
            <?= icon('chev', 'ic chev') ?>
          </button>
          <div class="uso-body" id="uso-b-<?= $nn ?>" hidden>
            <p class="porque"><?= e($u['porque']) ?></p>
            <?php if (!empty($u['dica'])): ?><p class="dica"><?= icon('bolt') ?><?= e($u['dica']) ?></p><?php endif; ?>
            <?php if (!empty($u['vars'])): ?>
              <div class="vars">
                <?php foreach ($u['vars'] as $vk => [$label, $def, $tipo]): ?>
                  <label class="var">
                    <span><?= e($label) ?></span>
                    <?php if ($tipo === 'textarea'): ?>
                      <textarea data-var="<?= e($vk) ?>" rows="3"><?= e($def) ?></textarea>
                    <?php else: ?>
                      <input type="text" data-var="<?= e($vk) ?>" value="<?= e($def) ?>">
                    <?php endif; ?>
                  </label>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <details class="preview">
              <summary>Ver prompt completo</summary>
              <pre class="prompt" tabindex="0"></pre>
            </details>
            <div class="acts">
              <a class="btn btn-ia" data-act="open" data-ia="<?= e($u['ia']) ?>" href="<?= e($ia['url']) ?>" target="_blank" rel="noopener"><?= icon('copy') ?> Copiar &amp; abrir no <?= e($ia['nome']) ?></a>
              <div class="acts-row">
                <button class="btn btn-sm" data-act="copy"><?= icon('copy') ?> Só copiar</button>
                <button class="btn btn-sm" data-act="share" aria-label="Compartilhar"><?= icon('share') ?></button>
                <button class="btn btn-sm fav" data-act="fav" aria-label="Favoritar" aria-pressed="false"><?= icon('star') ?></button>
              </div>
              <p class="alt">Também funciona em:
                <?php foreach ($u['alt'] as $a): ?>
                  <a data-act="open" data-ia="<?= e($a) ?>" href="<?= e($IAS[$a]['url']) ?>" target="_blank" rel="noopener" style="--c:<?= e($IAS[$a]['cor']) ?>"><?= e($IAS[$a]['nome']) ?></a>
                <?php endforeach; ?>
              </p>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
    <p class="vazio" id="vazio" hidden>Nenhum uso encontrado. Tente outra palavra.</p>
  </div>
</section>

<!-- ═════════ MÉTODO V.A.L.O.R. ═════════ -->
<section class="sec sec-alt" id="valor">
  <div class="wrap">
    <p class="eyebrow">Leve para a vida</p>
    <h2 class="h2">Método <span class="gold-t">V·A·L·O·R</span> de prompt</h2>
    <p class="sub">Dê <b>voz</b> ao seu pedido e a IA devolve <b>valor</b>. Monte o seu prompt em 5 campos.</p>
    <div class="valor">
      <?php
      $valor = [
        ['V', 'Visão', 'Quem a IA deve ser', 'Atue como advogado trabalhista sênior, com 20 anos de prática em defesa de empresas.'],
        ['A', 'Assunto', 'Contexto e fatos (anonimizados)', 'Cliente: indústria de médio porte. Ex-empregado alega horas extras habituais de 2023 a 2025; havia controle de ponto eletrônico.'],
        ['L', 'Limites', 'O que não fazer, fontes, tom', 'Não invente jurisprudência; marque [VERIFICAR] quando houver dúvida. Linguagem objetiva.'],
        ['O', 'Objetivo', 'O entregável e o formato', 'Liste as 5 principais teses de defesa em tabela: tese | fundamento | prova necessária | risco.'],
        ['R', 'Revisão', 'Peça autocrítica e perguntas', 'Antes de responder, faça-me até 3 perguntas que melhorariam a resposta. Ao final, aponte as fragilidades.'],
      ];
      foreach ($valor as [$l, $n, $d, $ex]): ?>
        <label class="valor-f">
          <span class="valor-l"><?= $l ?></span>
          <span class="valor-t"><b><?= $n ?></b><small><?= $d ?></small></span>
          <textarea data-valor="<?= $l ?>" rows="2"><?= e($ex) ?></textarea>
        </label>
      <?php endforeach; ?>
      <div class="valor-out">
        <pre class="prompt" id="valorPrompt" tabindex="0"></pre>
        <div class="valor-acts">
          <select id="valorIa" aria-label="Escolha a IA">
            <?php foreach ($IAS as $k => $i): if (in_array($k, ['gamma', 'napkin', 'canva', 'lovable', 'notebooklm'], true)) continue; ?>
              <option value="<?= e($k) ?>"><?= e($i['nome']) ?></option>
            <?php endforeach; ?>
          </select>
          <a class="btn btn-gold" id="valorAbrir" data-act="open-valor" href="<?= e($IAS['chatgpt']['url']) ?>" target="_blank" rel="noopener"><?= icon('copy') ?> Copiar &amp; abrir</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═════════ ÉTICA ═════════ -->
<section class="sec" id="etica">
  <div class="wrap">
    <p class="eyebrow">Inegociável</p>
    <h2 class="h2">As 7 regras de ouro</h2>
    <div class="regras">
      <?php
      $regras = [
        ['Sigilo primeiro', 'Nunca cole nome, CPF, número do processo ou dado sensível do cliente. Substitua por “Cliente A”, “Empresa X”.'],
        ['Confira toda citação', 'IA pode “alucinar” julgados e artigos. Só cite o que você abriu na fonte oficial.'],
        ['A assinatura é sua', 'A responsabilidade técnica pela peça continua sendo do advogado. IA é estagiária brilhante, não sócia.'],
        ['Desative o treino', 'Nas configurações de cada IA, desligue o uso das conversas para treinamento (ex.: ChatGPT → Controles de dados).'],
        ['LGPD no escritório', 'Defina por escrito o que pode ir para IA, quem usa e em quais contas. Prefira planos empresariais para dados de clientes.'],
        ['Transparência', 'Combine com o cliente o uso de ferramentas tecnológicas no contrato de honorários.'],
        ['Publicidade ética', 'Conteúdo gerado por IA segue o Provimento 205/2021: informativo, sóbrio, sem promessa de resultado.'],
      ];
      foreach ($regras as $idx => [$t, $d]): ?>
        <div class="regra"><span><?= $idx + 1 ?></span><div><b><?= e($t) ?></b><p><?= e($d) ?></p></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
</main>

<footer class="foot">
  <div class="wrap foot-grid">
    <div>
      <?= vv_brand('brand-md') ?>
      <p class="foot-p"><b><?= e(PALESTRA_TITULO) ?></b><br><?= e(PALESTRANTE) ?> · <?= e(EVENTO_NOME) ?> · <?= e(EVENTO_LOCAL) ?></p>
      <div class="foot-acts">
        <button class="btn btn-gold" data-act="share-site"><?= icon('share') ?> Enviar para um colega</button>
        <button class="btn btn-ghost" id="btnInstalar" hidden>Instalar no celular</button>
      </div>
      <p class="foot-mini">Exemplos com dados fictícios. Os resultados de IA devem ser revisados por advogado. Marcas citadas pertencem aos seus titulares.</p>
    </div>
    <div class="foot-qr">
      <div id="qrSite" class="qr-box" data-url="<?= e($url) ?>/"></div>
      <small>Aponte a câmera e compartilhe</small>
    </div>
  </div>
</footer>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script id="vv-data" type="application/json"><?= json_encode($js, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<?php vv_foot(['assets/js/app.js']); ?>
