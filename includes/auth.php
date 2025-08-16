<?php
session_start();

// Credenciais do admin (em produção, usar sistema seguro)
$admin_credentials = [
    'username' => 'admin',
    'password' => 'admin123'
];

// Verificar login
if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === $admin_credentials['username'] && 
        $_POST['password'] === $admin_credentials['password']) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Credenciais inválidas";
        header("Location: index.php");
        exit();
    }
}

// Verificar se está logado como admin
if (basename($_SERVER['PHP_SELF']) != 'index.php' && 
    isset($_SESSION['admin']) && !$_SESSION['admin']) {
    header("Location: index.php");
    exit();
}
?>