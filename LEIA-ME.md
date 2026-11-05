# Voz e Valor · IA na Advocacia

Site da palestra na 19ª Conferência Mineira da Advocacia (Poços de Caldas, 04–06/11/2026).

| Página | Para quem | O que faz |
|---|---|---|
| `index.php` | Participantes (celular) | 15 IAs, 30 usos com campos editáveis, Copiar & abrir, método V·A·L·O·R, 7 regras de ouro |
| `palco.php` | Telão | QR Code gigante por uso, contador ao vivo. ← → navega, F tela cheia, número+Enter vai ao uso, B tela preta |
| `roteiro.php` | Palestrante | Estratégia, cronograma de 50 min, demos ao vivo, perguntas difíceis, checklist técnico |

## Publicar
1. Envie a pasta para um servidor PHP 8 com **HTTPS** (a cópia automática no celular exige HTTPS).
2. Em `config.php`, defina `SITE_URL_FIXA` com a URL pública (é ela que vai nos QR Codes).
3. Dê permissão de escrita em `storage/` (contador do telão).
4. Coloque o logo, a foto e a arte oficial em `assets/img/` (veja `assets/img/LEIA-ME.txt`).
5. Antes de começar, zere `storage/hits.json` para `{"total":0}`.

Conteúdo dos usos e das IAs: `inc/data.php`.
