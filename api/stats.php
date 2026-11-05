<?php
/** Contadores para o telão (palco.php). */
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$file = __DIR__ . '/../storage/hits.json';
echo is_file($file) ? (file_get_contents($file) ?: '{}') : '{"total":0}';
