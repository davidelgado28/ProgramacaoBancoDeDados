<?php

$db_host = 'sql101.byetcluster.com';
$db_name = 'if0_42161499_socioTorcedor';
$db_user = 'if0_42161499';
$db_pass = '4zJ3LcH47jIf5cv'; 

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>