<?php
declare(strict_types=1);

/** Versão do arquivo estático pela data de modificação (invalida cache do navegador e do service worker). */
function vv_ver(string $rel): string
{
    $f = __DIR__ . '/../' . $rel;
    return is_file($f) ? (string) filemtime($f) : ASSET_VERSION;
}

function vv_head(string $titulo, string $descricao, string $bodyClass = ''): void
{
    security_headers();
    ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($titulo) ?></title>
<meta name="description" content="<?= e($descricao) ?>">
<meta name="theme-color" content="#1b2330">
<meta property="og:title" content="<?= e($titulo) ?>">
<meta property="og:description" content="<?= e($descricao) ?>">
<meta property="og:type" content="website">
<?php if ($og = asset_img(['post-evento.jpg', 'post-evento.png', 'og.jpg'])): ?>
<meta property="og:image" content="<?= e(site_url() . '/' . strtok($og, '?')) ?>">
<?php endif; ?>
<link rel="manifest" href="manifest.webmanifest">
<link rel="icon" href="assets/img/icon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="assets/img/icon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap">
<link rel="stylesheet" href="assets/css/app.css?v=<?= e(vv_ver('assets/css/app.css')) ?>">
</head>
<body class="<?= e($bodyClass) ?>">
<?php
    vv_icons();
}

/** Marca "Voz e Valor": usa a imagem oficial se existir em assets/img, senão recria em tipografia. */
function vv_brand(string $class = ''): string
{
    $img = asset_img(['logo-vozevalor.png', 'logo-vozevalor.svg', 'logo-vozevalor.webp']);
    if ($img) {
        return '<img class="brand-img ' . e($class) . '" src="' . e($img) . '" alt="Voz e Valor — 19ª Conferência Mineira da Advocacia">';
    }
    return '<span class="brand ' . e($class) . '" aria-label="Voz e Valor">'
        . '<span class="brand-word">Voz<i>e</i>Valor</span>'
        . '<span class="brand-sub"><b>19<sup>ª</sup></b><span>CONFERÊNCIA MINEIRA<br>DA ADVOCACIA <em>2026</em></span></span>'
        . '</span>';
}

function vv_oab(): string
{
    $img = asset_img(['logo-oab.png', 'logo-oab.svg', 'logo-oab.webp']);
    return $img ? '<img class="oab-img" src="' . e($img) . '" alt="OAB Minas Gerais">' : '<span class="oab-txt">OAB · MINAS GERAIS</span>';
}

function icon(string $id, string $class = 'ic'): string
{
    return '<svg class="' . e($class) . '" aria-hidden="true"><use href="#i-' . e($id) . '"/></svg>';
}

function vv_icons(): void
{
    ?>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="i-copy" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 9h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H11a2 2 0 0 1-2-2V9Zm-4 6H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v1"/></symbol>
  <symbol id="i-open" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></symbol>
  <symbol id="i-star" viewBox="0 0 24 24"><path fill="currentColor" d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9L12 3Z"/></symbol>
  <symbol id="i-share" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 3v13M7 8l5-5 5 5M5 14v5a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-5"/></symbol>
  <symbol id="i-search" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Zm10 3-5-5"/></symbol>
  <symbol id="i-check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="m5 12 5 5 9-10"/></symbol>
  <symbol id="i-chev" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></symbol>
  <symbol id="i-cal" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" d="M4 6h16v14H4zM4 10h16M8 3v4M16 3v4M8 14h2M12 14h2M16 14h0M8 17h2M12 17h2"/></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/></symbol>
  <symbol id="i-bolt" viewBox="0 0 24 24"><path fill="currentColor" d="M13 2 4 14h7l-1 8 9-12h-7l1-8Z"/></symbol>
  <symbol id="i-shield" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3Z"/></symbol>
  <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M12 7v5l3 2"/></symbol>
  <symbol id="i-qr" viewBox="0 0 24 24"><path fill="currentColor" d="M3 3h8v8H3V3Zm2 2v4h4V5H5Zm8-2h8v8h-8V3Zm2 2v4h4V5h-4ZM3 13h8v8H3v-8Zm2 2v4h4v-4H5Zm8-2h2v2h-2v-2Zm4 0h4v2h-4v-2Zm-4 4h2v4h-2v-4Zm4 0h2v2h-2v-2Zm2 2h2v2h-2v-2Z"/></symbol>
  <symbol id="i-g" viewBox="0 0 24 24"><path fill="#4285F4" d="M21.6 12.2c0-.7-.1-1.4-.2-2H12v3.8h5.4a4.6 4.6 0 0 1-2 3v2.5h3.2c1.9-1.7 3-4.3 3-7.3Z"/><path fill="#34A853" d="M12 22c2.7 0 5-.9 6.6-2.4l-3.2-2.5c-.9.6-2 1-3.4 1-2.6 0-4.8-1.8-5.6-4.1H3.1v2.6A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.4 14c-.2-.6-.3-1.3-.3-2s.1-1.4.3-2V7.4H3.1a10 10 0 0 0 0 9.2L6.4 14Z"/><path fill="#EA4335" d="M12 5.9c1.5 0 2.8.5 3.8 1.5l2.9-2.9A10 10 0 0 0 3.1 7.4L6.4 10c.8-2.4 3-4.1 5.6-4.1Z"/></symbol>
</svg>
<?php
}

function vv_foot(array $scripts = []): void
{
    foreach ($scripts as $s) {
        echo '<script src="' . e($s) . '?v=' . e(vv_ver($s)) . '" defer></script>' . "\n";
    }
    ?>
<script>if('serviceWorker' in navigator){addEventListener('load',()=>navigator.serviceWorker.register('sw.js').catch(()=>{}));}</script>
</body>
</html>
<?php
}

/** Ilustração do skyline de Poços de Caldas (montanhas + fachada histórica), em linha e sépia. */
function vv_skyline(): string
{
    return <<<'SVG'
<svg class="skyline" viewBox="0 0 1200 260" preserveAspectRatio="xMidYMax slice" aria-hidden="true">
  <defs>
    <linearGradient id="mt" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#8f8273"/><stop offset="1" stop-color="#5e5650"/></linearGradient>
    <linearGradient id="fa" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#efe5d3"/><stop offset="1" stop-color="#d8c9b0"/></linearGradient>
    <linearGradient id="rf" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#9a6a52"/><stop offset="1" stop-color="#6f4a3a"/></linearGradient>
  </defs>
  <path d="M0 170 L120 120 L210 140 L330 70 L430 120 L520 95 L640 150 L760 110 L880 140 L1000 85 L1110 130 L1200 110 V260 H0Z" fill="url(#mt)" opacity=".55"/>
  <path d="M0 190 L160 150 L300 175 L420 135 L600 185 L780 150 L960 180 L1200 150 V260 H0Z" fill="#7a6e63" opacity=".45"/>
  <g>
    <path d="M60 205 L360 205 L410 175 L790 175 L840 205 L1140 205 L1140 260 L60 260Z" fill="url(#rf)"/>
    <path d="M420 175 L600 108 L780 175Z" fill="url(#fa)" stroke="#bfae92" stroke-width="2"/>
    <path d="M455 170 L600 118 L745 170" fill="none" stroke="#b49f80" stroke-width="2"/>
    <rect x="60" y="212" width="1080" height="48" fill="url(#fa)"/>
    <rect x="410" y="175" width="380" height="85" fill="url(#fa)"/>
    <g fill="#3b3a3a" opacity=".85">
      <path d="M455 260v-48a12 12 0 0 1 24 0v48Z"/><path d="M515 260v-48a12 12 0 0 1 24 0v48Z"/><path d="M588 260v-52a12 12 0 0 1 24 0v52Z"/><path d="M661 260v-48a12 12 0 0 1 24 0v48Z"/><path d="M721 260v-48a12 12 0 0 1 24 0v48Z"/>
      <rect x="95" y="226" width="20" height="34" rx="9"/><rect x="155" y="226" width="20" height="34" rx="9"/><rect x="215" y="226" width="20" height="34" rx="9"/><rect x="275" y="226" width="20" height="34" rx="9"/><rect x="335" y="226" width="20" height="34" rx="9"/>
      <rect x="845" y="226" width="20" height="34" rx="9"/><rect x="905" y="226" width="20" height="34" rx="9"/><rect x="965" y="226" width="20" height="34" rx="9"/><rect x="1025" y="226" width="20" height="34" rx="9"/><rect x="1085" y="226" width="20" height="34" rx="9"/>
    </g>
    <g stroke="#a8977c" stroke-width="2" fill="none"><path d="M60 212H1140M410 190H790"/></g>
  </g>
</svg>
SVG;
}
