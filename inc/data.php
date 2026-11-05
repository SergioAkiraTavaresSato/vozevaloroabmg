<?php
/**
 * Conteúdo da palestra: 15 IAs, 6 blocos da jornada do advogado e 30 usos com prompts.
 * Variáveis nos prompts: {{chave}} — o participante edita no celular antes de copiar.
 * Todos os dados de exemplo são FICTÍCIOS.
 */
declare(strict_types=1);

// Cláusula de segurança reaproveitada nos prompts que tocam fundamentação jurídica.
$R = "\n\nREGRAS: (1) Não invente leis, súmulas, temas ou julgados — se não tiver certeza da referência, escreva [VERIFICAR]. (2) Separe fatos de premissas que você assumiu. (3) Português jurídico claro, sem floreios.";

$IAS = [
    'chatgpt'    => ['nome' => 'ChatGPT',     'empresa' => 'OpenAI',    'url' => 'https://chatgpt.com/',                'q' => 'https://chatgpt.com/?q=%s',             'google' => true,  'cor' => '#10a37f', 'sigla' => 'GPT', 'forte' => 'Redação, triagem e estrutura de peças'],
    'gemini'     => ['nome' => 'Gemini',      'empresa' => 'Google',    'url' => 'https://gemini.google.com/app',       'q' => null,                                    'google' => true,  'cor' => '#4b8bf5', 'sigla' => 'Ge',  'forte' => 'Fotos de documentos, Gmail e Drive'],
    'claude'     => ['nome' => 'Claude',      'empresa' => 'Anthropic', 'url' => 'https://claude.ai/new',               'q' => 'https://claude.ai/new?q=%s',            'google' => true,  'cor' => '#d97757', 'sigla' => 'Cl',  'forte' => 'Revisão fina de contratos e peças longas'],
    'copilot'    => ['nome' => 'Copilot',     'empresa' => 'Microsoft', 'url' => 'https://copilot.microsoft.com/',      'q' => 'https://copilot.microsoft.com/?q=%s',   'google' => false, 'cor' => '#2f7fd6', 'sigla' => 'Co',  'forte' => 'Excel, Word, Outlook e atas', 'login' => 'Conta Microsoft ou sem login'],
    'perplexity' => ['nome' => 'Perplexity',  'empresa' => 'Perplexity','url' => 'https://www.perplexity.ai/',          'q' => 'https://www.perplexity.ai/search?q=%s', 'google' => true,  'cor' => '#20b8cd', 'sigla' => 'Px',  'forte' => 'Pesquisa com fontes citadas'],
    'grok'       => ['nome' => 'Grok',        'empresa' => 'xAI',       'url' => 'https://grok.com/',                   'q' => 'https://grok.com/?q=%s',                'google' => true,  'cor' => '#9aa4b2', 'sigla' => 'Gk',  'forte' => 'Debate, simulação e cenários'],
    'deepseek'   => ['nome' => 'DeepSeek',    'empresa' => 'DeepSeek',  'url' => 'https://chat.deepseek.com/',          'q' => null,                                    'google' => true,  'cor' => '#4d6bfe', 'sigla' => 'DS',  'forte' => 'Raciocínio passo a passo e cálculos'],
    'metaai'     => ['nome' => 'Meta AI',     'empresa' => 'Meta',      'url' => 'https://www.meta.ai/',                'q' => null,                                    'google' => false, 'cor' => '#0866ff', 'sigla' => 'MA',  'forte' => 'Dentro do WhatsApp (círculo azul)', 'login' => 'Já está no seu WhatsApp'],
    'notebooklm' => ['nome' => 'NotebookLM',  'empresa' => 'Google',    'url' => 'https://notebooklm.google.com/',      'q' => null,                                    'google' => true,  'cor' => '#c58af9', 'sigla' => 'NL',  'forte' => 'Conversar com os autos em PDF + áudio'],
    'lechat'     => ['nome' => 'Le Chat',     'empresa' => 'Mistral',   'url' => 'https://chat.mistral.ai/chat',        'q' => 'https://chat.mistral.ai/chat?q=%s',     'google' => true,  'cor' => '#fa520f', 'sigla' => 'LC',  'forte' => 'Rápido, europeu, foco em privacidade'],
    'qwen'       => ['nome' => 'Qwen',        'empresa' => 'Alibaba',   'url' => 'https://chat.qwen.ai/',               'q' => null,                                    'google' => true,  'cor' => '#7c5cff', 'sigla' => 'Qw',  'forte' => 'Tradução e tabelas comparativas'],
    'gamma'      => ['nome' => 'Gamma',       'empresa' => 'Gamma',     'url' => 'https://gamma.app/create',            'q' => null,                                    'google' => true,  'cor' => '#e45ce0', 'sigla' => 'Gm',  'forte' => 'Apresentações prontas em 1 minuto'],
    'napkin'     => ['nome' => 'Napkin',      'empresa' => 'Napkin AI', 'url' => 'https://app.napkin.ai/',              'q' => null,                                    'google' => true,  'cor' => '#f2b134', 'sigla' => 'Nk',  'forte' => 'Texto vira diagrama e linha do tempo'],
    'canva'      => ['nome' => 'Canva IA',    'empresa' => 'Canva',     'url' => 'https://www.canva.com/ai/',           'q' => null,                                    'google' => true,  'cor' => '#00c4cc', 'sigla' => 'Cv',  'forte' => 'Posts e materiais visuais'],
    'lovable'    => ['nome' => 'Lovable',     'empresa' => 'Lovable',   'url' => 'https://lovable.dev/',                'q' => 'https://lovable.dev/#prompt=%s',        'google' => true,  'cor' => '#ff5a7a', 'sigla' => 'Lv',  'forte' => 'Cria apps e sites só com texto'],
];

$BLOCOS = [
    'atender'   => ['n' => 'I',   'nome' => 'Atender e entender o cliente',  'icone' => 'chat'],
    'pesquisar' => ['n' => 'II',  'nome' => 'Pesquisar e fundamentar',       'icone' => 'search'],
    'redigir'   => ['n' => 'III', 'nome' => 'Redigir e revisar peças',       'icone' => 'pen'],
    'contratos' => ['n' => 'IV',  'nome' => 'Contratos e consultivo',        'icone' => 'doc'],
    'audiencia' => ['n' => 'V',   'nome' => 'Audiência e estratégia',        'icone' => 'scale'],
    'escritorio'=> ['n' => 'VI',  'nome' => 'Escritório, gestão e marketing ético', 'icone' => 'spark'],
];

$USOS = [
// ───────────── I · ATENDER ─────────────
[
 'id' => 1, 'bloco' => 'atender', 'ia' => 'chatgpt', 'alt' => ['claude', 'gemini'], 'tempo' => '40 min → 3 min', 'aovivo' => true,
 'titulo' => 'Do áudio do WhatsApp à ficha do caso',
 'porque' => 'O cliente manda 7 áudios desorganizados. A IA devolve fatos, cronologia, documentos faltantes e as perguntas que você ainda precisa fazer.',
 'vars' => [
   'relato' => ['Relato do cliente (cole a transcrição do áudio)', "Doutor, comprei uma geladeira na loja X em março, parcelei em 10x no cartão. Ela parou de funcionar em junho, levei na assistência três vezes e nada. A loja disse que não é problema deles. Agora em setembro meu nome apareceu no Serasa por uma parcela que eu nem reconheço, de outra compra. Tô desesperada porque preciso de crédito pra reforma da casa.", 'textarea'],
 ],
 'prompt' => "Atue como advogado sênior fazendo a triagem de um novo atendimento.\n\nRELATO DO CLIENTE (dados anonimizados):\n\"\"\"{{relato}}\"\"\"\n\nEntregue, em tópicos:\n1. Resumo do caso em 3 linhas.\n2. Linha do tempo com datas (marque [DATA A CONFIRMAR] quando faltar).\n3. Áreas do direito e possíveis pretensões.\n4. Prazos de prescrição/decadência a checar com urgência.\n5. Checklist de documentos e provas a pedir ao cliente.\n6. 10 perguntas objetivas que ainda preciso fazer, em ordem de prioridade.\n7. Riscos e pontos fracos da versão do cliente.\n8. Mensagem curta e acolhedora para eu enviar ao cliente pedindo os documentos." . $R,
],
[
 'id' => 2, 'bloco' => 'atender', 'ia' => 'gemini', 'alt' => ['chatgpt', 'claude'], 'tempo' => '20 min → 2 min',
 'titulo' => 'Fotografe o documento e entenda em segundos',
 'porque' => 'No app do Gemini, toque no + e tire uma foto da notificação, contrato ou intimação que o cliente trouxe. A IA lê a imagem.',
 'dica' => 'No celular: abra o Gemini → ícone + → Câmera → fotografe → cole este prompt.',
 'vars' => [
   'tipo' => ['Que documento é?', 'notificação extrajudicial de cobrança', 'text'],
 ],
 'prompt' => "Analise a imagem anexa: é um(a) {{tipo}} que meu cliente recebeu.\n\n1. Transcreva os trechos essenciais (partes, valores, datas, prazos, exigências).\n2. Explique em linguagem simples o que o documento pede e quais as consequências de ignorá-lo.\n3. Destaque PRAZOS com a data-limite calculada (indique se corridos ou úteis e a premissa usada).\n4. Aponte possíveis irregularidades ou abusividades.\n5. Sugira 3 caminhos de resposta, com prós e contras.\nSe algum trecho estiver ilegível, diga exatamente qual." . $R,
],
[
 'id' => 3, 'bloco' => 'atender', 'ia' => 'gemini', 'alt' => ['chatgpt', 'copilot'], 'tempo' => '15 min → 1 min',
 'titulo' => 'Traduzir o juridiquês para o cliente',
 'porque' => 'Cliente que entende o processo liga menos, confia mais e indica o escritório. Transforme a decisão em explicação humana.',
 'vars' => [
   'decisao' => ['Cole o trecho da decisão/despacho', 'Vistos. Indefiro, por ora, a tutela de urgência, ante a ausência de demonstração do periculum in mora, nos termos do art. 300 do CPC. Cite-se a parte ré para, querendo, apresentar contestação no prazo legal. Designe-se audiência de conciliação.', 'textarea'],
   'cliente' => ['Perfil do cliente', 'aposentada, 68 anos, ansiosa com o processo', 'text'],
 ],
 'prompt' => "Explique a decisão judicial abaixo para meu cliente ({{cliente}}).\n\nDECISÃO:\n\"\"\"{{decisao}}\"\"\"\n\nFormato: mensagem de WhatsApp, até 120 palavras, tom calmo e profissional, sem latim e sem termos técnicos (se usar algum, explique entre parênteses). Estrutura: (1) o que o juiz decidiu, (2) o que isso significa na prática, (3) próximo passo e prazo aproximado, (4) o que o cliente precisa fazer agora — se nada, diga que não precisa fazer nada. Não prometa resultado. Assine como \"Equipe do escritório\".",
],
[
 'id' => 4, 'bloco' => 'atender', 'ia' => 'metaai', 'alt' => ['chatgpt', 'gemini'], 'tempo' => '30 min → 2 min',
 'titulo' => 'Kit de mensagens de WhatsApp do escritório',
 'porque' => 'Respostas padronizadas, elegantes e rápidas para as situações que se repetem todo dia. Use a Meta AI direto no WhatsApp.',
 'dica' => 'No WhatsApp: toque no círculo azul/roxo (Meta AI) e cole o prompt.',
 'vars' => [
   'area' => ['Área de atuação', 'direito de família e sucessões', 'text'],
 ],
 'prompt' => "Crie um kit de 8 mensagens-modelo de WhatsApp para um escritório de advocacia de {{area}}. Tom: cordial, profissional, sem emojis em excesso, máximo 60 palavras cada, com [CAMPOS] para personalizar.\n\n1. Boas-vindas após o primeiro contato.\n2. Pedido de documentos com lista em tópicos.\n3. Lembrete de audiência 48h antes (endereço/link, horário, documentos, traje).\n4. Atualização de andamento sem novidades (\"o processo segue em tramitação\").\n5. Resposta a quem pede \"só uma consultinha rápida\" por mensagem, convidando para consulta formal.\n6. Lembrete gentil de honorários em atraso.\n7. Fora do horário de atendimento.\n8. Pedido de avaliação/feedback ao final do caso, sem oferecer vantagem.\nRespeite o Código de Ética e Disciplina da OAB: sem promessa de resultado e sem captação indevida.",
],
[
 'id' => 5, 'bloco' => 'atender', 'ia' => 'metaai', 'alt' => ['chatgpt', 'claude'], 'tempo' => 'evita 1 dor de cabeça',
 'titulo' => 'A resposta difícil: cliente bravo ou cobrando',
 'porque' => 'Quando a emoção está alta, a IA ajuda a responder com firmeza, empatia e segurança jurídica — sem criar prova contra você.',
 'vars' => [
   'mensagem' => ['Mensagem que o cliente enviou', 'Doutor, já faz 8 meses e nada! Paguei adiantado e ninguém me dá notícia. Vou na OAB reclamar!', 'textarea'],
   'contexto' => ['O que realmente aconteceu', 'processo aguarda sentença desde junho; enviei atualização em agosto; vara com acúmulo de serviço', 'textarea'],
 ],
 'prompt' => "Sou advogado e recebi esta mensagem de um cliente:\n\"\"\"{{mensagem}}\"\"\"\n\nContexto real: {{contexto}}.\n\nEscreva 2 versões de resposta (uma curta para WhatsApp e outra mais completa para e-mail). Requisitos: reconhecer a frustração sem admitir falha inexistente, explicar objetivamente o andamento, propor um próximo passo concreto (ex.: reunião ou relatório) e manter a relação. Evite frases que possam ser usadas como confissão de culpa. Depois, liste 3 erros comuns que eu deveria evitar nessa resposta.",
],
// ───────────── II · PESQUISAR ─────────────
[
 'id' => 6, 'bloco' => 'pesquisar', 'ia' => 'perplexity', 'alt' => ['gemini', 'chatgpt'], 'tempo' => '2 h → 10 min', 'aovivo' => true,
 'titulo' => 'Pesquisa de jurisprudência com fontes clicáveis',
 'porque' => 'O Perplexity mostra de onde tirou cada informação. Você confere na fonte oficial antes de citar — nunca cite sem abrir o link.',
 'vars' => [
   'tema' => ['Tema da pesquisa', 'dano moral por negativação indevida quando o consumidor já possui outras inscrições', 'text'],
   'tribunal' => ['Tribunais de interesse', 'STJ e TJMG', 'text'],
 ],
 'prompt' => "Pesquise o entendimento atual de {{tribunal}} sobre: {{tema}}.\n\nEntregue:\n1. Tese predominante em 3 linhas.\n2. Súmulas, temas repetitivos ou precedentes qualificados aplicáveis, com número e link da fonte oficial.\n3. 3 a 5 julgados recentes (tribunal, número, data, relator) com link.\n4. Exceções e distinções (distinguishing) que podem ajudar ou atrapalhar.\n5. Divergências entre tribunais, se houver.\nUse preferencialmente sites oficiais (stj.jus.br, tjmg.jus.br, planalto.gov.br). Se não encontrar fonte, escreva [SEM FONTE] em vez de supor.",
],
[
 'id' => 7, 'bloco' => 'pesquisar', 'ia' => 'perplexity', 'alt' => ['gemini', 'grok'], 'tempo' => '1 h → 5 min',
 'titulo' => 'O que mudou na lei? Radar legislativo',
 'porque' => 'Para não ser pego de surpresa por alteração recente — e para virar conteúdo para clientes.',
 'vars' => [
   'assunto' => ['Lei ou assunto', 'reforma tributária do consumo (IBS/CBS) e impactos para pequenas empresas de serviços', 'text'],
 ],
 'prompt' => "Faça um radar legislativo sobre: {{assunto}}.\n\n1. Principais normas vigentes e as alterações mais recentes, com data e link para o texto oficial.\n2. O que muda na prática, em linguagem de cliente empresarial.\n3. Cronograma de transição/vigência em tabela.\n4. 5 oportunidades de atuação para um advogado (consultivo e contencioso).\n5. Pontos ainda indefinidos ou pendentes de regulamentação.\nCite as fontes e destaque qualquer informação que possa estar desatualizada.",
],
[
 'id' => 8, 'bloco' => 'pesquisar', 'ia' => 'notebooklm', 'alt' => ['gemini', 'claude'], 'tempo' => '3 h → 15 min', 'aovivo' => true,
 'titulo' => 'Converse com os autos: resumo com páginas',
 'porque' => 'Suba o PDF do processo no NotebookLM. Ele responde SÓ com base no documento e mostra a citação de onde tirou cada frase.',
 'dica' => 'NotebookLM → Novo notebook → Adicionar fonte → PDF dos autos (anonimizado) → cole o prompt no chat.',
 'vars' => [
   'papel' => ['Você representa', 'o réu', 'text'],
 ],
 'prompt' => "Com base EXCLUSIVAMENTE nas fontes deste notebook (autos do processo), sendo que represento {{papel}}:\n\n1. Resumo do processo em 10 linhas.\n2. Tabela: data | evento processual | folha/página | relevância.\n3. Pedidos da parte autora e fundamentos de cada um.\n4. Provas já produzidas e por quem.\n5. Pontos contraditórios ou frágeis na narrativa da parte contrária, citando as páginas.\n6. Prazos e próximos atos previsíveis.\n7. Perguntas que os autos não respondem.\nSempre indique a passagem da fonte que sustenta cada afirmação.",
],
[
 'id' => 9, 'bloco' => 'pesquisar', 'ia' => 'notebooklm', 'alt' => ['gemini'], 'tempo' => 'ganhe o trânsito',
 'titulo' => 'O processo vira podcast para ouvir no carro',
 'porque' => 'O "Resumo em Áudio" do NotebookLM cria uma conversa de 2 vozes sobre o caso. Você chega ao fórum preparado.',
 'dica' => 'No notebook do caso: Estúdio → Resumo em áudio → Personalizar → cole as instruções → Gerar. Escolha português.',
 'vars' => [
   'foco' => ['Foco da audiência', 'audiência de instrução da semana que vem: testemunhas e pontos controvertidos', 'text'],
 ],
 'prompt' => "Instruções para o resumo em áudio: fale em português do Brasil, para um advogado que vai participar de {{foco}}. Explique o caso de forma objetiva, destaque os pontos controvertidos, as provas de cada lado, as contradições encontradas nos autos e 5 perguntas estratégicas a fazer. Duração ideal: 8 a 10 minutos. Termine com os 3 pontos que não podem ser esquecidos.",
],
[
 'id' => 10, 'bloco' => 'pesquisar', 'ia' => 'deepseek', 'alt' => ['chatgpt', 'claude'], 'tempo' => '30 min → 3 min',
 'titulo' => 'Prescrição e decadência: linha do tempo de risco',
 'porque' => 'Modelos de raciocínio (DeepThink) mostram o passo a passo do cálculo — você confere cada premissa.',
 'dica' => 'No DeepSeek, ative o botão "DeepThink" antes de enviar.',
 'vars' => [
   'fatos' => ['Fatos com datas', 'Acidente de trânsito em 15/03/2023 com danos materiais e lesão leve; seguradora negou cobertura em 10/07/2023; cliente quer processar o causador e a seguradora.', 'textarea'],
 ],
 'prompt' => "Analise prescrição e decadência para o caso a seguir, raciocinando passo a passo.\n\nFATOS: {{fatos}}\n\nPara cada pretensão possível (e contra cada parte):\n1. Fundamento legal do prazo (artigo e lei).\n2. Termo inicial e justificativa (actio nata, ciência do dano etc.).\n3. Causas de interrupção ou suspensão a investigar.\n4. Data-limite estimada.\n5. Nível de risco: ALTO / MÉDIO / BAIXO.\nApresente a conclusão em tabela e liste as premissas que, se mudarem, alteram o resultado. Hoje é " . date('d/m/Y') . "." . $R,
],
// ───────────── III · REDIGIR ─────────────
[
 'id' => 11, 'bloco' => 'redigir', 'ia' => 'chatgpt', 'alt' => ['claude', 'lechat'], 'tempo' => '3 h → 30 min', 'aovivo' => true,
 'titulo' => 'Esqueleto de petição inicial',
 'porque' => 'Você não terceiriza a tese — terceiriza a página em branco. Estrutura completa, pronta para você lapidar.',
 'vars' => [
   'acao' => ['Tipo de ação', 'ação declaratória de inexigibilidade de débito c/c indenização por danos morais', 'text'],
   'juizo' => ['Juízo', 'Juizado Especial Cível da Comarca de Poços de Caldas/MG', 'text'],
   'fatos' => ['Fatos principais', 'Autora teve o nome negativado por dívida de R$ 1.280,00 que desconhece, referente a contrato que nunca firmou. Não possui outras restrições. Descobriu ao tentar financiamento, que foi negado.', 'textarea'],
 ],
 'prompt' => "Atue como advogado contencioso experiente. Redija a ESTRUTURA COMPLETA de uma {{acao}} perante o {{juizo}}.\n\nFATOS: {{fatos}}\n\nInclua: endereçamento; qualificação com [CAMPOS]; síntese fática persuasiva e cronológica; preliminares cabíveis; fundamentos jurídicos em tópicos com os dispositivos legais pertinentes; pedido de tutela de urgência (se cabível) com probabilidade do direito e perigo de dano; pedidos numerados, certos e determinados; valor da causa com memória de cálculo; provas; requerimentos finais.\n\nNa jurisprudência, escreva apenas [INSERIR PRECEDENTE VERIFICADO SOBRE X] — eu vou pesquisar. Ao final, liste os documentos que devem acompanhar a inicial." . $R,
],
[
 'id' => 12, 'bloco' => 'redigir', 'ia' => 'claude', 'alt' => ['chatgpt', 'gemini'], 'tempo' => 'a melhor 2ª opinião', 'aovivo' => true,
 'titulo' => 'O juiz cético: teste de estresse da sua peça',
 'porque' => 'Antes de protocolar, peça para a IA ler como o juiz mais exigente e o advogado adversário mais preparado.',
 'vars' => [
   'peca' => ['Cole sua peça ou os argumentos principais', 'Argumento 1: a negativação foi indevida porque a autora nunca contratou. Argumento 2: dano moral in re ipsa. Argumento 3: pedido de R$ 20.000,00 de indenização.', 'textarea'],
 ],
 'prompt' => "Leia a peça abaixo em 3 papéis sucessivos:\n\nA) JUIZ CÉTICO: quais pontos não me convencem? O que falta provar? O que eu indeferiria e por quê?\nB) ADVOGADO DA PARTE CONTRÁRIA: quais as 5 melhores teses de defesa contra esta peça?\nC) REVISOR SÊNIOR: reescreva os 3 parágrafos mais fracos, deixando-os mais objetivos e persuasivos.\n\nTermine com uma nota de 0 a 10 de robustez e um checklist do que corrigir antes de protocolar.\n\nPEÇA:\n\"\"\"{{peca}}\"\"\"" . $R,
],
[
 'id' => 13, 'bloco' => 'redigir', 'ia' => 'lechat', 'alt' => ['chatgpt', 'claude'], 'tempo' => '1 h → 5 min',
 'titulo' => 'Notificação extrajudicial que resolve',
 'porque' => 'Uma boa notificação evita o processo — ou já constitui o devedor em mora e vira prova.',
 'vars' => [
   'situacao' => ['Situação', 'Locatário comercial com 3 aluguéis atrasados (agosto a outubro/2026), total R$ 9.600,00, contrato com multa de 10% e juros de 1% ao mês.', 'textarea'],
   'prazo' => ['Prazo para cumprimento', '10 dias', 'text'],
 ],
 'prompt' => "Redija uma notificação extrajudicial formal, firme e respeitosa, para a seguinte situação: {{situacao}}\n\nRequisitos: identificação de notificante e notificado com [CAMPOS]; exposição objetiva dos fatos; fundamento contratual e legal; valor atualizado com memória de cálculo simplificada; prazo de {{prazo}} para cumprimento; consequências do não cumprimento; canais para pagamento/contato; local, data e assinatura. Não use tom intimidatório nem ameaças desproporcionais. Depois, sugira o melhor meio de envio para servir como prova." . $R,
],
[
 'id' => 14, 'bloco' => 'redigir', 'ia' => 'lechat', 'alt' => ['claude', 'chatgpt'], 'tempo' => '4 h → 40 min',
 'titulo' => 'Parecer jurídico estruturado',
 'porque' => 'Para o consultivo: consulta → parecer com ementa, análise e conclusão em formato profissional.',
 'vars' => [
   'consulta' => ['Consulta do cliente', 'Uma clínica médica quer saber se pode exigir que pacientes enviem foto do documento de identidade pelo WhatsApp para agendar consultas, e como armazenar esses dados.', 'textarea'],
 ],
 'prompt' => "Elabore um parecer jurídico sobre a consulta abaixo.\n\nCONSULTA: {{consulta}}\n\nEstrutura: EMENTA (5 linhas); I. Relatório; II. Questões jurídicas formuladas; III. Fundamentação, tópico a tópico, com dispositivos legais e regulatórios aplicáveis; IV. Riscos (tabela: risco | probabilidade | impacto | mitigação); V. Conclusão e recomendações práticas numeradas; VI. Limitações do parecer. Linguagem técnica, mas compreensível para o empresário." . $R,
],
[
 'id' => 15, 'bloco' => 'redigir', 'ia' => 'claude', 'alt' => ['chatgpt', 'gemini'], 'tempo' => '1 h → 10 min',
 'titulo' => 'Lapidar o texto: claro, curto e persuasivo',
 'porque' => 'Juízes leem centenas de páginas por dia. Texto enxuto é estratégia. Mantém o conteúdo, melhora a forma.',
 'vars' => [
   'texto' => ['Cole o trecho a melhorar', 'Que, outrossim, cumpre salientar que a parte requerida, data maxima venia, não logrou êxito em demonstrar, de forma cabal e inequívoca, a existência de relação jurídica entre as partes, ônus que lhe competia, razão pela qual imperiosa se faz a procedência dos pedidos.', 'textarea'],
 ],
 'prompt' => "Reescreva o trecho jurídico abaixo seguindo os princípios de linguagem simples (Pacto Nacional pela Linguagem Simples do Judiciário):\n- frases curtas, ordem direta, voz ativa;\n- sem latinismos e sem expressões vazias (\"outrossim\", \"data venia\", \"cumpre salientar\");\n- manter TODO o conteúdo jurídico e a força argumentativa.\n\nEntregue: (1) versão reescrita; (2) versão ainda mais curta para o tópico-síntese; (3) tabela antes/depois das 5 mudanças principais.\n\nTRECHO:\n\"\"\"{{texto}}\"\"\"",
],
// ───────────── IV · CONTRATOS ─────────────
[
 'id' => 16, 'bloco' => 'contratos', 'ia' => 'claude', 'alt' => ['chatgpt', 'gemini'], 'tempo' => '2 h → 15 min', 'aovivo' => true,
 'titulo' => 'Revisão de contrato com semáforo de riscos',
 'porque' => 'Cole o contrato (ou anexe o PDF) e receba a matriz de risco cláusula a cláusula, com redação alternativa.',
 'vars' => [
   'lado' => ['Você representa', 'o contratante (pequena empresa que está contratando um software)', 'text'],
   'contrato' => ['Cole o contrato ou escreva "anexo"', 'anexo', 'textarea'],
 ],
 'prompt' => "Revise o contrato abaixo (ou o arquivo anexo) representando {{lado}}.\n\nEntregue uma TABELA com: nº da cláusula | resumo | risco (🔴 alto / 🟡 médio / 🟢 baixo) | por que é um risco para meu cliente | redação alternativa sugerida.\n\nDepois:\n1. Cláusulas que FALTAM (ex.: LGPD, SLA, limitação de responsabilidade, foro, rescisão, reajuste).\n2. Top 5 pontos para negociar, em ordem de prioridade.\n3. E-mail curto para a outra parte propondo os ajustes, em tom colaborativo.\n\nCONTRATO:\n\"\"\"{{contrato}}\"\"\"" . $R,
],
[
 'id' => 17, 'bloco' => 'contratos', 'ia' => 'qwen', 'alt' => ['claude', 'chatgpt'], 'tempo' => '3 h → 20 min',
 'titulo' => 'Tradução jurídica de cláusulas (EN ⇄ PT)',
 'porque' => 'Termos como "consideration", "indemnify" e "best efforts" não se traduzem literalmente. A IA traduz e explica.',
 'vars' => [
   'clausula' => ['Cole a cláusula em inglês', 'The Supplier shall indemnify and hold harmless the Customer from and against any and all losses, damages and liabilities arising out of any breach of this Agreement, provided that the Supplier\'s aggregate liability shall not exceed the fees paid in the twelve (12) months preceding the claim.', 'textarea'],
 ],
 'prompt' => "Traduza a cláusula contratual abaixo para o português jurídico brasileiro.\n\nEntregue:\n1. Tradução fiel.\n2. Tabela de termos sensíveis: termo em inglês | tradução adotada | por que não traduzir literalmente | instituto equivalente no direito brasileiro.\n3. Pontos em que a cláusula pode ter efeito diferente sob a lei brasileira.\n4. Sugestão de redação bilíngue (coluna EN | coluna PT).\n\nCLÁUSULA:\n\"\"\"{{clausula}}\"\"\"" . $R,
],
[
 'id' => 18, 'bloco' => 'contratos', 'ia' => 'qwen', 'alt' => ['chatgpt', 'copilot'], 'tempo' => '1 h → 5 min',
 'titulo' => 'Quadro comparativo de propostas ou minutas',
 'porque' => 'Duas versões do contrato? Três propostas de fornecedor? A IA compara lado a lado e mostra o que mudou.',
 'vars' => [
   'v1' => ['Versão / proposta A', 'Prazo 24 meses; multa rescisória de 3 mensalidades; reajuste IGP-M; foro de São Paulo.', 'textarea'],
   'v2' => ['Versão / proposta B', 'Prazo 12 meses com renovação automática; multa de 50% do saldo; reajuste IPCA; foro de Poços de Caldas.', 'textarea'],
 ],
 'prompt' => "Compare as duas versões abaixo em uma TABELA: item | versão A | versão B | qual é mais favorável ao meu cliente e por quê.\n\nDepois: (1) as 3 diferenças de maior impacto financeiro; (2) riscos ocultos em cada versão; (3) proposta de versão C equilibrada para negociação.\n\nVERSÃO A:\n{{v1}}\n\nVERSÃO B:\n{{v2}}",
],
[
 'id' => 19, 'bloco' => 'contratos', 'ia' => 'chatgpt', 'alt' => ['claude', 'lechat'], 'tempo' => '2 h → 20 min',
 'titulo' => 'Contrato de honorários sob medida',
 'porque' => 'O documento mais importante do escritório — e o mais esquecido. Claro, completo e alinhado ao Código de Ética.',
 'vars' => [
   'servico' => ['Serviço contratado', 'ação trabalhista de rescisão indireta em 1º e 2º graus', 'text'],
   'modelo' => ['Forma de cobrança', 'entrada de R$ 1.500,00 + 30% do proveito econômico ao final', 'text'],
 ],
 'prompt' => "Redija um contrato de prestação de serviços advocatícios e honorários para: {{servico}}. Forma de remuneração: {{modelo}}.\n\nInclua cláusulas sobre: objeto delimitado (o que está e o que NÃO está incluído); honorários contratuais e sucumbenciais; despesas e custas; forma e prazo de pagamento; rescisão e revogação do mandato; obrigações do cliente (documentos, informações verdadeiras, atualização de contato); comunicação e canais oficiais; LGPD e sigilo; foro. Observe o Estatuto da Advocacia e o Código de Ética e Disciplina da OAB e a tabela de honorários da OAB/MG como referência mínima. Use [CAMPOS] para dados das partes." . $R,
],
[
 'id' => 20, 'bloco' => 'contratos', 'ia' => 'copilot', 'alt' => ['chatgpt', 'gemini'], 'tempo' => '1 dia → 30 min',
 'titulo' => 'Checklist LGPD para o escritório',
 'porque' => 'Escritório trata dados sensíveis todos os dias. Um plano de adequação prático, sem jargão de consultoria.',
 'vars' => [
   'porte' => ['Porte e estrutura', 'escritório com 3 advogados, 1 secretária, atendimento por WhatsApp, arquivos no Google Drive', 'text'],
 ],
 'prompt' => "Crie um plano de adequação à LGPD (Lei 13.709/2018) para um escritório de advocacia: {{porte}}.\n\nEntregue:\n1. Checklist em tabela: ação | prioridade (alta/média/baixa) | responsável | prazo sugerido.\n2. Mapa simples dos dados tratados (clientes, partes contrárias, testemunhas, colaboradores) e a base legal de cada um.\n3. Regras de uso de IA generativa no escritório (o que pode e o que não pode ser colado em uma IA).\n4. Modelo de aviso de privacidade curto para o site e para o WhatsApp.\n5. Roteiro de resposta a um incidente de vazamento." . $R,
],
// ───────────── V · AUDIÊNCIA E ESTRATÉGIA ─────────────
[
 'id' => 21, 'bloco' => 'audiencia', 'ia' => 'grok', 'alt' => ['chatgpt', 'claude'], 'tempo' => 'chegue 10x mais preparado', 'aovivo' => true,
 'titulo' => 'Simulador de audiência e sustentação oral',
 'porque' => 'A IA faz o papel do juiz/desembargador e te bombardeia com as perguntas difíceis. Treine antes de subir à tribuna.',
 'vars' => [
   'caso' => ['Resumo do caso e sua tese', 'Apelação: defendo que a cláusula de fidelidade de 36 meses em contrato de internet empresarial é abusiva e que a multa deve ser proporcional ao tempo restante.', 'textarea'],
 ],
 'prompt' => "Vamos simular uma sustentação oral. Você é um desembargador experiente, exigente e cordial. Meu caso e minha tese: {{caso}}\n\nRegras do jogo:\n1. Faça UMA pergunta difícil por vez e espere minha resposta.\n2. Após cada resposta, dê uma nota de 0 a 10 e diga como eu poderia ter respondido melhor, em até 3 linhas.\n3. Varie entre perguntas sobre fatos, provas, precedentes e consequências práticas da decisão.\n4. Após 5 perguntas, faça um balanço final e me dê um roteiro de sustentação de 10 minutos.\n\nComece agora com a primeira pergunta.",
],
[
 'id' => 22, 'bloco' => 'audiencia', 'ia' => 'chatgpt', 'alt' => ['claude', 'gemini'], 'tempo' => '2 h → 15 min',
 'titulo' => 'Roteiro de perguntas para testemunhas',
 'porque' => 'Perguntas abertas para a sua, perguntas fechadas para a da parte contrária. Estratégia de prova em minutos.',
 'vars' => [
   'pontos' => ['Pontos controvertidos', 'Se havia jornada extraordinária habitual; se o reclamante exercia cargo de confiança; se havia controle de ponto.', 'textarea'],
   'testemunhas' => ['Testemunhas', 'Testemunha A: ex-colega do reclamante (minha). Testemunha B: supervisora atual da empresa (parte contrária).', 'textarea'],
 ],
 'prompt' => "Prepare um roteiro de inquirição para audiência de instrução.\n\nPONTOS CONTROVERTIDOS: {{pontos}}\nTESTEMUNHAS: {{testemunhas}}\n\nPara cada testemunha:\n1. Objetivo da oitiva.\n2. 8 a 12 perguntas em ordem estratégica (abertas para a minha; fechadas e de checagem de contradição para a da parte contrária).\n3. Perguntas que NÃO devo fazer e por quê.\n4. Possíveis contraditas e fundamentos.\n5. Pontos para registrar em ata.\nEvite perguntas indutivas para a minha testemunha.",
],
[
 'id' => 23, 'bloco' => 'audiencia', 'ia' => 'grok', 'alt' => ['claude', 'deepseek'], 'tempo' => 'decisão melhor informada',
 'titulo' => 'Mesa de negociação: vale a pena o acordo?',
 'porque' => 'Cenários, riscos e números para conversar com o cliente com transparência antes da audiência de conciliação.',
 'vars' => [
   'caso' => ['Caso e proposta recebida', 'Pedido de R$ 45.000,00 em ação de indenização; a ré ofereceu R$ 12.000,00 à vista; processo tem 2 anos; prova pericial pendente.', 'textarea'],
 ],
 'prompt' => "Ajude-me a avaliar uma proposta de acordo. Caso: {{caso}}\n\n1. Monte 3 cenários (otimista, provável, pessimista) com valor estimado, tempo até o recebimento e custos (honorários periciais, recursos, correção).\n2. Calcule o valor presente aproximado de cada cenário e explique as premissas.\n3. Defina BATNA, preço de reserva e uma contraproposta fundamentada.\n4. Sugira 3 argumentos para a mesa de negociação e 3 concessões possíveis que não sejam em dinheiro.\n5. Escreva um resumo em linguagem simples para eu apresentar ao cliente — a decisão é dele.\nDeixe claro que são estimativas.",
],
[
 'id' => 24, 'bloco' => 'audiencia', 'ia' => 'deepseek', 'alt' => ['chatgpt', 'copilot'], 'tempo' => '1 h → 5 min',
 'titulo' => 'Memória de cálculo para conferência',
 'porque' => 'Verbas rescisórias, correção, juros: a IA mostra cada passo para você conferir — nunca para substituir o cálculo oficial.',
 'dica' => 'Ative o "DeepThink" e confira os índices oficiais do período antes de usar.',
 'vars' => [
   'dados' => ['Dados do cálculo', 'Salário R$ 3.200,00; admissão 02/05/2022; dispensa sem justa causa em 30/09/2026 com aviso prévio indenizado; 1 período de férias vencido não gozado; saldo de 30 dias de salário.', 'textarea'],
 ],
 'prompt' => "Elabore uma MEMÓRIA DE CÁLCULO estimativa, passo a passo, para conferência, com os dados: {{dados}}\n\n1. Liste cada verba devida e o fundamento legal.\n2. Mostre a fórmula e o cálculo de cada uma (ex.: aviso prévio proporcional, 13º proporcional, férias + 1/3, FGTS + multa).\n3. Tabela final: verba | base | quantidade | valor.\n4. Indique o que depende de índice oficial (correção/juros) e não estime índices — deixe [ÍNDICE OFICIAL].\n5. Aponte as premissas e possíveis divergências de interpretação.\nRaciocine com cuidado e revise as contas antes de responder." . $R,
],
[
 'id' => 25, 'bloco' => 'audiencia', 'ia' => 'napkin', 'alt' => ['gamma', 'canva'], 'tempo' => 'visual que convence', 'aovivo' => true,
 'titulo' => 'Linha do tempo visual dos fatos',
 'porque' => 'Cole a cronologia no Napkin e ele gera o diagrama. Perfeito para memoriais, audiências e para o cliente entender.',
 'dica' => 'Napkin → Novo → cole o texto → selecione o texto → clique no raio ⚡ → escolha o visual.',
 'vars' => [
   'cronologia' => ['Cronologia (uma linha por evento)', "Mar/2026 – Compra da geladeira em 10x\nJun/2026 – Produto apresenta defeito\nJun a Ago/2026 – 3 idas à assistência técnica sem solução\nAgo/2026 – Loja nega responsabilidade\nSet/2026 – Negativação indevida no Serasa\nOut/2026 – Financiamento da reforma negado", 'textarea'],
 ],
 'prompt' => "Linha do tempo do caso — falhas sucessivas do fornecedor e danos ao consumidor\n\n{{cronologia}}\n\nResultado: cada etapa agravou o dano; o fornecedor teve 3 oportunidades de resolver e não resolveu.",
],
// ───────────── VI · ESCRITÓRIO ─────────────
[
 'id' => 26, 'bloco' => 'escritorio', 'ia' => 'copilot', 'alt' => ['chatgpt', 'gemini'], 'tempo' => '1 dia → 20 min',
 'titulo' => 'Planilha de controle de prazos e honorários',
 'porque' => 'O Copilot entende Excel: estrutura, fórmulas, formatação condicional e alertas de prazo vencendo.',
 'vars' => [
   'colunas' => ['O que quer controlar', 'processos, cliente, prazo fatal, responsável, status, honorários a receber', 'text'],
 ],
 'prompt' => "Crie uma planilha de Excel para controlar {{colunas}} em um escritório de advocacia.\n\nEntregue:\n1. Estrutura das abas e das colunas (nome, tipo de dado, exemplo).\n2. Fórmulas prontas para: dias restantes até o prazo (DIATRABALHOTOTAL considerando feriados de uma aba \"Feriados\"), status automático (\"VENCE HOJE\", \"ESTA SEMANA\", \"OK\") e total de honorários a receber por mês.\n3. Regras de formatação condicional (vermelho, amarelo, verde).\n4. Um painel-resumo com 4 indicadores.\n5. 5 linhas de exemplo com dados fictícios em formato de tabela para eu colar.\nLembre que a contagem oficial de prazos deve ser conferida no sistema do tribunal.",
],
[
 'id' => 27, 'bloco' => 'escritorio', 'ia' => 'gamma', 'alt' => ['canva', 'napkin'], 'tempo' => '4 h → 5 min', 'aovivo' => true,
 'titulo' => 'Apresentação de proposta para cliente empresarial',
 'porque' => 'Proposta bonita fecha contrato. O Gamma gera os slides completos a partir deste texto.',
 'dica' => 'Gamma → Criar → Gerar → Apresentação → cole o prompt → escolha um tema escuro e elegante.',
 'vars' => [
   'cliente' => ['Cliente e necessidade', 'rede de 4 padarias em Poços de Caldas que precisa de assessoria trabalhista preventiva e redução de passivo', 'text'],
   'escritorio' => ['Seu escritório', 'Escritório [NOME] Advocacia, 12 anos de atuação em direito do trabalho empresarial', 'text'],
 ],
 'prompt' => "Crie uma apresentação de 8 slides de proposta de serviços jurídicos para: {{cliente}}. Proponente: {{escritorio}}.\n\nSlides: 1) Capa; 2) O desafio do cliente (riscos trabalhistas típicos do setor); 3) Nossa abordagem em 3 etapas (diagnóstico, adequação, acompanhamento); 4) Entregáveis concretos; 5) Cronograma de 90 dias; 6) Indicadores de sucesso; 7) Equipe e diferenciais; 8) Próximos passos.\nTom: sóbrio, técnico e confiável. Respeite o Provimento 205/2021 do CFOAB: sem promessa de resultado, sem comparação com outros escritórios e sem divulgação de valores nos slides.",
],
[
 'id' => 28, 'bloco' => 'escritorio', 'ia' => 'gamma', 'alt' => ['canva', 'chatgpt'], 'tempo' => '1 dia → 10 min',
 'titulo' => 'Palestra/treinamento para o cliente (in company)',
 'porque' => 'Treinar a equipe do cliente gera valor, previne litígios e fideliza. O material sai pronto.',
 'vars' => [
   'tema' => ['Tema do treinamento', 'assédio moral e sexual no ambiente de trabalho: prevenção e canal de denúncias', 'text'],
   'publico' => ['Público', 'gestores e líderes de equipe de uma indústria', 'text'],
 ],
 'prompt' => "Crie uma apresentação de treinamento de 10 slides sobre {{tema}} para {{publico}}.\n\nInclua: objetivos; conceitos com exemplos do dia a dia; o que diz a legislação brasileira (em linguagem simples); 3 estudos de caso curtos para discussão; o que fazer e o que não fazer (tabela); papel do gestor; como funciona o canal de denúncias; quiz de 5 perguntas; mensagem final. Linguagem acessível, sem juridiquês, visual limpo.",
],
[
 'id' => 29, 'bloco' => 'escritorio', 'ia' => 'canva', 'alt' => ['chatgpt', 'gamma'], 'tempo' => '2 h → 10 min',
 'titulo' => 'Carrossel informativo dentro do Provimento 205',
 'porque' => 'Marketing jurídico é informar, não vender. Conteúdo educativo, sóbrio e ético que gera autoridade.',
 'dica' => 'Canva → Canva IA / Magic Design → cole o prompt. Ou gere o texto no ChatGPT e monte no Canva.',
 'vars' => [
   'tema' => ['Tema do post', '5 direitos do consumidor que quase ninguém conhece', 'text'],
 ],
 'prompt' => "Crie um carrossel de Instagram com 7 telas sobre: \"{{tema}}\".\n\nTela 1: título forte e curto. Telas 2 a 6: um ponto por tela, até 25 palavras, linguagem simples, com base legal citada de forma discreta. Tela 7: \"Ficou com dúvida? Procure um advogado de sua confiança.\" + nome do escritório e nº de inscrição na OAB.\nEstilo visual: sóbrio e elegante, azul-marinho, creme e dourado, tipografia serifada nos títulos.\nRegras (Provimento 205/2021 CFOAB): caráter informativo, sem promessa de resultado, sem preços, sem sensacionalismo, sem chamadas como \"ligue já\".",
],
[
 'id' => 30, 'bloco' => 'escritorio', 'ia' => 'lovable', 'alt' => ['chatgpt', 'claude'], 'tempo' => 'um app em 3 minutos', 'aovivo' => true,
 'titulo' => 'Crie o app do seu escritório só com texto',
 'porque' => 'Momento uau: sem programar, a IA cria um aplicativo web funcional — aqui, um assistente de prazos e checklist de documentos.',
 'dica' => 'Lovable: entre com Google, cole o prompt e veja o app nascer. Plano gratuito tem créditos diários.',
 'vars' => [
   'nome' => ['Nome do escritório', 'Silva & Andrade Advocacia', 'text'],
 ],
 'prompt' => "Crie um aplicativo web responsivo, elegante e em português chamado \"Painel do Advogado — {{nome}}\", com visual sóbrio (azul-marinho, creme e dourado, títulos em fonte serifada).\n\nFuncionalidades:\n1. Calculadora de prazos processuais: informo data de início e quantidade de dias; o app conta em dias úteis (excluindo sábados, domingos e uma lista editável de feriados) e mostra a data final, com aviso \"confira no sistema do tribunal\".\n2. Checklist de documentos por tipo de ação (trabalhista, consumidor, família, previdenciário), com caixas de marcar e botão para copiar a lista e enviar ao cliente pelo WhatsApp.\n3. Lista de prazos cadastrados com destaque em vermelho para os que vencem em até 3 dias, salvos no navegador.\n4. Rodapé com aviso: \"Ferramenta de apoio. Não substitui a conferência do advogado.\"\nNão use nenhum dado real de clientes.",
],
];

// Índice rápido por IA (para os cards das IAs e filtros).
$USOS_POR_IA = [];
foreach ($USOS as $u) {
    $USOS_POR_IA[$u['ia']][] = $u['id'];
}
