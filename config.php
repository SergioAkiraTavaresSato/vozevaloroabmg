<?php
/**
 * Voz e Valor · IA na Advocacia — configuração central
 * 19ª Conferência Mineira da Advocacia · Poços de Caldas · 04 a 06/11/2026
 * Compatível com PHP 8.x (roda também em 7.4).
 */
declare(strict_types=1);

// URL pública do site (usada nos QR Codes do telão). Deixe vazio para detectar automaticamente.
// Ex.: 'https://seudominio.com.br/vozevalor'
const SITE_URL_FIXA = '';

const PALESTRANTE      = 'Sérgio Akira Sato';
const PALESTRA_TITULO  = 'A Voz e o Valor do Advogado na Era da IA';
const PALESTRA_SUB     = '30 usos práticos · 15 IAs · direto do seu celular';
const EVENTO_NOME      = '19ª Conferência Mineira da Advocacia';
const EVENTO_DATA      = '04 a 06 de novembro de 2026';
const EVENTO_LOCAL     = 'Poços de Caldas · MG';
const ASSET_VERSION    = '2026.11.04';

// Chave opcional para proteger o roteiro do palestrante (roteiro.php?k=...). Vazio = aberto.
const ROTEIRO_KEY = '';

if (!function_exists('str_contains')) {
    function str_contains(string $h, string $n): bool { return $n === '' || strpos($h, $n) !== false; }
}

function site_url(): string
{
    if (SITE_URL_FIXA !== '') {
        return rtrim(SITE_URL_FIXA, '/');
    }
    $https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $dir    = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    return ($https ? 'https' : 'http') . '://' . $host . $dir;
}

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Retorna o caminho do primeiro arquivo existente em assets/img (logo, foto etc.) ou null. */
function asset_img(array $candidatos): ?string
{
    foreach ($candidatos as $c) {
        if (is_file(__DIR__ . '/assets/img/' . $c)) {
            return 'assets/img/' . $c . '?v=' . filemtime(__DIR__ . '/assets/img/' . $c);
        }
    }
    return null;
}

function security_headers(): void
{
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}
