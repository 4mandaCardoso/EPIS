<?php
// ARQUIVO TEMPORARIO DE DIAGNOSTICO - APAGAR DEPOIS DO TESTE
header('Content-Type: text/plain; charset=utf-8');

$ca = getenv('DB_SSL_CA');
echo "DB_SSL_CA definido: ", $ca ? "sim ($ca)" : "NAO", "\n";
$existe = $ca && file_exists($ca);
echo "arquivo existe: ", var_export($existe, true), "\n";
echo "arquivo legivel pelo PHP: ", var_export($ca && is_readable($ca), true), "\n";
echo "tamanho: ", $existe ? filesize($ca) : 0, " bytes\n";
if ($ca && is_readable($ca)) {
    $c = file_get_contents($ca);
    echo "tem BEGIN CERTIFICATE: ", var_export(strpos($c, '-----BEGIN CERTIFICATE-----') !== false, true), "\n";
    echo "tem END CERTIFICATE: ", var_export(strpos($c, '-----END CERTIFICATE-----') !== false, true), "\n";
    echo "quantidade de certificados: ", substr_count($c, 'BEGIN CERTIFICATE'), "\n";
}
echo "\n";
foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'] as $v) {
    $x = getenv($v);
    echo "$v: ", $x === false ? 'NAO DEFINIDA' : 'definida (' . strlen($x) . ' caracteres)', "\n";
}
echo "extensao pdo_mysql: ", var_export(extension_loaded('pdo_mysql'), true), "\n";
echo "PHP: ", PHP_VERSION, " | OpenSSL: ", OPENSSL_VERSION_TEXT, "\n\n";

$host = getenv('DB_HOST'); $port = getenv('DB_PORT'); $db = getenv('DB_NAME');
$user = getenv('DB_USER'); $pass = getenv('DB_PASSWORD');

$testes = [
    '1) com CA e verificacao completa' => [PDO::MYSQL_ATTR_SSL_CA => $ca, PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true],
    '2) com CA, sem verificar nome do servidor' => [PDO::MYSQL_ATTR_SSL_CA => $ca, PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false],
];
foreach ($testes as $nome => $opt) {
    try {
        $opt[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $opt[PDO::ATTR_TIMEOUT] = 10;
        $p = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, $opt);
        $n = $p->query('SELECT COUNT(*) FROM usuario')->fetchColumn();
        echo "$nome: OK (usuarios na tabela: $n)\n";
    } catch (Throwable $e) {
        echo "$nome: FALHOU -> ", $e->getMessage(), "\n";
    }
}
