<?php
/** Registra cópias/aberturas de cada uso (contador anônimo, sem dados pessoais). */
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { http_response_code(405); exit('{}'); }
$in = json_decode((string) file_get_contents('php://input', false, null, 0, 512), true);
$u  = (int) ($in['u'] ?? -1);
$a  = (string) ($in['a'] ?? '');
$ia = preg_replace('/[^a-z]/', '', (string) ($in['ia'] ?? ''));
if ($u < 0 || $u > 30 || !in_array($a, ['open', 'copy', 'valor'], true) || strlen($ia) > 12) { http_response_code(400); exit('{}'); }

$file = __DIR__ . '/../storage/hits.json';
$fp = @fopen($file, 'c+');
if (!$fp) { exit('{"ok":false}'); }
flock($fp, LOCK_EX);
$raw  = stream_get_contents($fp);
$data = $raw ? (json_decode($raw, true) ?: []) : [];
$data['total']        = ($data['total'] ?? 0) + 1;
$data['usos'][$u]     = ($data['usos'][$u] ?? 0) + 1;
if ($ia !== '') { $data['ias'][$ia] = ($data['ias'][$ia] ?? 0) + 1; }
$data['t'] = time();
ftruncate($fp, 0); rewind($fp);
fwrite($fp, json_encode($data));
fflush($fp); flock($fp, LOCK_UN); fclose($fp);
echo '{"ok":true}';
