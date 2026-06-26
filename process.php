<?php

require_once 'config.php';
session_start();

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $tipoPlano = $_POST['tipoPlano'] ?? 'basico';

    if (empty($nome) || empty($email) || empty($cpf) || empty($senha)) {
        header("Location: index.php?msg=campos_obrigatorios");
        exit; 
    }
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO socio (nome, email, cpf, telefone, senha, tipoPlano) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $cpf, $telefone, $senhaHash, $tipoPlano]);
        
        header("Location: index.php?msg=cadastro_sucesso");
        exit; 
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            header("Location: index.php?msg=erro_duplicado");
            exit; 
        } else {
            header("Location: index.php?msg=erro_geral");
            exit; 
        }
    }
}
if ($action === 'login') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM socio WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['idsocio'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['user_plano'] = $user['tipoPlano'];
            header("Location: dashboard.php");
            exit; 
        } else {
            header("Location: index.php?msg=login_invalido");
            exit; 
        }
    } catch (PDOException $e) {
        header("Location: index.php?msg=erro_geral");
        exit; 
    }
}
?>