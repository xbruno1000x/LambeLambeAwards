<?php
require_once '../Model/Admin.php';
require_once '../DAO/AdminDAO.php';
require_once '../DAO/ConnectionFactory.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conecta ao banco de dados
    $pdo = ConnectionFactory::getConnection();
    $adminDAO = new AdminDAO($pdo);

    // Verifica se o administrador existe
    $admin = $adminDAO->getAdminByUsername($username);

    // Verifica se a senha está correta
    if ($admin && $password == $admin->getPassword()) {
        // Login bem-sucedido
        $_SESSION['admin_id'] = $admin->getId();
        $_SESSION['admin_username'] = $admin->getUsername();
        header("Location: ../View/dashboard.php");  // Redireciona para o painel após login
        exit();
    } else {
        // Login falhou, redireciona de volta com um erro
        $_SESSION['error'] = "Usuário ou senha inválidos!";
        header("Location: ../View/login.php");  // Redireciona para o formulário
        exit();
    }
}