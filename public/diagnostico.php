<?php
// Arquivo de diagnóstico - DELETE APÓS RESOLVER O PROBLEMA!
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico do Servidor</h1>";

echo "<h2>1. Informações do PHP</h2>";
echo "<p>Versão PHP: " . phpversion() . "</p>";

echo "<h2>2. Verificação de Arquivos</h2>";

$files = [
    '../.env' => 'Arquivo .env',
    '../vendor/autoload.php' => 'Autoloader Composer',
    '../bootstrap/app.php' => 'Bootstrap Laravel',
    '../storage/framework/cache' => 'Diretório de Cache',
    '../storage/framework/sessions' => 'Diretório de Sessões',
    '../storage/framework/views' => 'Diretório de Views',
    '../storage/logs' => 'Diretório de Logs',
];

foreach ($files as $path => $name) {
    $exists = file_exists($path) ? '✅ Existe' : '❌ NÃO EXISTE';
    $writable = (file_exists($path) && is_writable($path)) ? ' (gravável)' : ' (não gravável)';
    echo "<p>{$name}: {$exists}{$writable}</p>";
}

echo "<h2>3. Permissões de Diretórios</h2>";
$dirs = ['../storage', '../storage/framework', '../storage/logs', '../bootstrap/cache'];
foreach ($dirs as $dir) {
    if (file_exists($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        echo "<p>{$dir}: {$perms}</p>";
    }
}

echo "<h2>4. Extensões PHP</h2>";
$required = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'curl'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext) ? '✅' : '❌';
    echo "<p>{$ext}: {$loaded}</p>";
}

echo "<h2>5. Variáveis de Ambiente</h2>";
echo "<p>DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";

echo "<hr><p style='color:red;'><strong>⚠️ DELETE ESTE ARQUIVO APÓS O DIAGNÓSTICO!</strong></p>";
