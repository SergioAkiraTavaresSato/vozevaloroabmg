<?php
/** Roteiro estratégico do palestrante (não linkado no site do participante). */
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/inc/data.php';
require __DIR__ . '/inc/layout.php';

if (ROTEIRO_KEY !== '' && ($_GET['k'] ?? '') !== ROTEIRO_KEY) {
    http_response_code(403);
    exit('Acesso restrito.');
}
header('X-Robots-Tag: noindex, nofollow');
$aovivo = array_values(array_filter($USOS, fn($u) => !empty($u['aovivo'])));
vv_head('Roteiro · Voz e Valor', 'Estratégia e roteiro da palestra.', 'pg-roteiro');
?>
<header class="topbar">
  <a href="./" class="topbar-brand"><?= vv_brand('brand-sm') ?></a>
  <nav class="topnav"><a href="palco.php" target="_blank">Abrir palco</a><a href="./" target="_blank">Site do público</a><a href="#" onclick="print();return false">Imprimir</a></nav>
</header>
<main class="wrap">
  <p class="eyebrow">Roteiro do palestrante · confidencial</p>
  <h1 class="h2"><?= e(PALESTRA_TITULO) ?></h1>
  <p class="sub"><?= e(EVENTO_NOME) ?> · <?= e(EVENTO_LOCAL) ?> · 500 advogados · formato 50 min (ajustes para 40 e 60 min ao final)</p>

  <section class="rt-sec">
    <h2>1. A grande ideia</h2>
    <p>O tema do evento é <b>Voz e Valor</b>. A palestra amarra tudo a ele:</p>
    <ul>
      <li><b>VOZ</b> — a IA devolve ao advogado o tempo de ouvir o cliente, pensar a tese e falar melhor (sustentação, negociação, comunicação).</li>
      <li><b>VALOR</b> — quem entrega mais rápido e melhor passa a cobrar pelo resultado do trabalho, não pelas horas de digitação.</li>
    </ul>
    <p class="rt-fala">“A IA não vai substituir o advogado. Mas o advogado que usa IA vai substituir o que não usa — e hoje, nesta sala, ninguém sai daqui sem usar.”</p>
    <h3>Promessa da palestra (diga nos primeiros 60 segundos)</h3>
    <p>“Em 50 minutos vocês vão rodar, no próprio celular, prompts que economizam horas na semana que vem — e vão levar 30 deles prontos.”</p>
  </section>

  <section class="rt-sec">
    <h2>2. Quem está na plateia</h2>
    <div class="rt-grid">
      <div class="rt-card"><b>Perfil dominante</b><p>Advogados de escritórios pequenos e médios do interior de MG, generalistas, muito contencioso cível, trabalhista, família e consumidor.</p></div>
      <div class="rt-card"><b>Medos</b><p>Ser substituído, cometer infração ética, vazar dado de cliente, citar jurisprudência inventada.</p></div>
      <div class="rt-card"><b>Desejos</b><p>Ganhar tempo, cobrar melhor, atender mais sem contratar, parecer moderno para o cliente.</p></div>
      <div class="rt-card"><b>Nível técnico</b><p>Misto: ~30% já usam ChatGPT, ~50% testaram uma vez, ~20% nunca usaram. Tudo deve funcionar sem instalar nada.</p></div>
    </div>
    <p>Estratégia: <b>mostrar casos do dia a dia, não tecnologia</b>. Cada demonstração começa por uma dor (“quem aqui já recebeu 7 áudios de um cliente?”) e termina em minutos economizados.</p>
  </section>

  <section class="rt-sec">
    <h2>3. Linha do tempo (50 min)</h2>
    <div class="rt-scroll"><table class="rt-tl">
      <thead><tr><th>Min</th><th>Bloco</th><th>O que acontece</th><th>Telão (palco.php)</th></tr></thead>
      <tbody>
        <tr><td>0–3</td><td>Abertura</td><td>Promessa + pergunta de mão: “quem usou IA no trabalho esta semana?”. Peça para todos apontarem a câmera para o QR. Conte até 30 em voz alta.</td><td>Slide 1 · QR do site + contador ao vivo</td></tr>
        <tr><td>3–6</td><td>Passo 1</td><td>Todos entram no ChatGPT ou Gemini com “Continuar com Google”. Enquanto isso, conte a história de um caso real seu (anonimizado).</td><td>Slide 2 · 15 IAs</td></tr>
        <tr><td>6–9</td><td>Método V·A·L·O·R</td><td>Explique o método em 5 letras com um exemplo ruim × bom. É a única “teoria” da palestra.</td><td>Slide 3</td></tr>
        <tr><td>9–15</td><td>I · Atender</td><td><b>AO VIVO uso 01</b> (áudio do WhatsApp → ficha do caso). Plateia roda junto. Cite 02–05 rapidamente.</td><td>Uso 01 · QR do uso</td></tr>
        <tr><td>15–22</td><td>II · Pesquisar</td><td><b>AO VIVO uso 06</b> (Perplexity com fontes) e <b>uso 08</b> (NotebookLM com autos). Gancho ético: “alucinação” — abra o link da fonte na frente de todos.</td><td>Usos 06 e 08</td></tr>
        <tr><td>22–30</td><td>III · Redigir</td><td><b>AO VIVO uso 11</b> (esqueleto da inicial) e, em seguida, <b>uso 12</b> (o juiz cético) usando a própria saída do 11. É o momento “uau” intelectual.</td><td>Usos 11 e 12</td></tr>
        <tr><td>30–35</td><td>IV · Contratos</td><td><b>AO VIVO uso 16</b> (semáforo de riscos) com um contrato de 2 páginas pronto no seu notebook.</td><td>Uso 16</td></tr>
        <tr><td>35–41</td><td>V · Audiência</td><td><b>AO VIVO uso 21</b>: convide um voluntário da plateia para responder ao “desembargador IA” no microfone. Depois mostre o <b>uso 25</b> (Napkin) em 30 segundos.</td><td>Usos 21 e 25</td></tr>
        <tr><td>41–46</td><td>VI · Escritório</td><td><b>AO VIVO uso 27</b> (Gamma gera proposta) e o grand finale <b>uso 30</b> (Lovable cria um app). Deixe o app sendo gerado enquanto fala das regras de ouro.</td><td>Usos 27 e 30</td></tr>
        <tr><td>46–49</td><td>Ética</td><td>7 regras de ouro. Mostre o contador: “vocês já rodaram X prompts nesta sala”.</td><td>Ética · contador</td></tr>
        <tr><td>49–50</td><td>Fecho</td><td>Frase final, convite para tirar foto do QR e postar com <b>#EuUsoIA</b> + <b>#EuVou</b> marcando o evento.</td><td>Slide final · QR</td></tr>
      </tbody>
    </table></div>
  </section>

  <section class="rt-sec">
    <h2>4. Os <?= count($aovivo) ?> momentos ao vivo</h2>
    <div class="rt-grid">
      <?php foreach ($aovivo as $u): ?>
        <div class="rt-card"><b><?= str_pad((string) $u['id'], 2, '0', STR_PAD_LEFT) ?> · <?= e($u['titulo']) ?></b><p><?= e($IAS[$u['ia']]['nome']) ?> · <?= e($u['tempo']) ?></p></div>
      <?php endforeach; ?>
    </div>
    <h3>Regra de ouro da demonstração</h3>
    <ul>
      <li>Rode cada demo <b>uma vez antes</b> no dia, na mesma conta, e guarde um print da resposta (plano B).</li>
      <li>Espelhe o <b>celular</b> no telão (scrcpy, AirPlay ou cabo) nas demos 01 e 21 — mostra que funciona no aparelho de todo mundo.</li>
      <li>Enquanto a IA responde, <b>fale</b>: conte a dor, a economia de tempo, o cuidado ético. Nunca fique em silêncio esperando a tela.</li>
      <li>Para digitar o número do uso no palco: tecle o número + Enter (ex.: <b>1 6 Enter</b>).</li>
    </ul>
  </section>

  <section class="rt-sec">
    <h2>5. Engajamento de 500 pessoas</h2>
    <ul>
      <li><b>Contador ao vivo no telão</b>: cada “Copiar &amp; abrir” no celular soma no slide. Provoque: “vamos chegar a mil prompts antes do intervalo?”.</li>
      <li><b>Mãos para cima</b> a cada bloco: “quem conseguiu? mostra o celular para o colega do lado”.</li>
      <li><b>Voluntário no microfone</b> no simulador de sustentação (uso 21) — gera risada e memória.</li>
      <li><b>Duplas</b>: quem não tem conta faz junto com o vizinho.</li>
      <li><b>Mineiridade</b>: use casos de Poços de Caldas (padarias, locação comercial, turismo, termas) — os prompts já vêm com exemplos locais.</li>
    </ul>
  </section>

  <section class="rt-sec">
    <h2>6. Perguntas difíceis (e respostas curtas)</h2>
    <div class="rt-grid">
      <div class="rt-card"><b>“Posso colar dados do meu cliente?”</b><p>Não em contas pessoais gratuitas. Anonimize sempre; para dados reais, use planos empresariais com contrato e treino desativado.</p></div>
      <div class="rt-card"><b>“A OAB permite?”</b><p>Sim, desde que preservados sigilo, responsabilidade técnica e as regras de publicidade. O Conselho Federal já publicou recomendações sobre IA generativa na advocacia — cite a versão vigente.</p></div>
      <div class="rt-card"><b>“Qual é a melhor IA?”</b><p>A que você usa todo dia. Comece por uma (ChatGPT ou Gemini) e use as outras para tarefas específicas: Perplexity para fontes, NotebookLM para autos, Claude para revisão.</p></div>
      <div class="rt-card"><b>“Vale pagar?”</b><p>Se economizar 2 horas no mês, o plano já se pagou. Teste 30 dias no gratuito com estes 30 usos e decida com números.</p></div>
      <div class="rt-card"><b>“E se a IA errar?”</b><p>Ela vai errar. Por isso o método V·A·L·O·R manda a IA dizer [VERIFICAR] e você confere na fonte. O erro é do advogado que não revisa.</p></div>
      <div class="rt-card"><b>“Vou perder clientes?”</b><p>Vai perder quem não entregar mais rápido. O cliente não paga digitação; paga estratégia, segurança e atenção.</p></div>
    </div>
  </section>

  <section class="rt-sec">
    <h2>7. Checklist técnico (véspera e 1 h antes)</h2>
    <ul>
      <li>Publicar o site em <b>HTTPS</b> com domínio curto (a cópia automática no celular exige HTTPS). Ajustar <code>SITE_URL_FIXA</code> em <code>config.php</code>.</li>
      <li>Colocar em <code>assets/img/</code>: <code>logo-vozevalor.png</code>, <code>logo-oab.png</code>, <code>palestrante.jpg</code> e <code>post-evento.jpg</code> (prévia no WhatsApp). O site usa automaticamente.</li>
      <li>Testar o QR do <b>fundo do auditório</b>: no palco o QR ocupa ~1/3 da tela.</li>
      <li>Liberar escrita na pasta <code>storage/</code> (contador ao vivo).</li>
      <li>Notebook: logado em ChatGPT, Gemini, Claude, Perplexity, NotebookLM (com um PDF fictício de autos já carregado), Gamma, Napkin e Lovable.</li>
      <li>Roteador 4G próprio para o notebook; Wi-Fi do evento só para o público.</li>
      <li>Zerar o contador antes de começar: apagar o conteúdo de <code>storage/hits.json</code> (deixar <code>{"total":0}</code>).</li>
      <li>Palco: abrir <code>palco.php</code>, apertar <b>F</b> (tela cheia). Clicker funciona (PageUp/PageDown).</li>
    </ul>
  </section>

  <section class="rt-sec">
    <h2>8. Variações de tempo</h2>
    <ul>
      <li><b>40 min</b>: corte os usos 08, 16 e 27 ao vivo (apenas cite). Mantenha 01, 06, 11→12, 21 e 30.</li>
      <li><b>60 min</b>: inclua o uso 09 (podcast dos autos — toque 30 s do áudio gerado) e 5 min de perguntas.</li>
    </ul>
  </section>
</main>
<?php vv_foot(); ?>
