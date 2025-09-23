<?php
// optional secret kalau mau validasi
$secret = "token-rahasia";

$json = file_get_contents('php://input');
$payload = json_decode($json, true);

if (isset($payload['ref']) && $payload['ref'] === 'refs/heads/main') {
    shell_exec("cd /www/wwwroot/edipurwanto.com && git reset --hard HEAD && git pull origin main 2>&1");
}
?>
