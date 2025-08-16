<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Avaliação Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Avaliação Escolar</a>
            <div class="navbar-nav">
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                    <a class="nav-link" href="admin.php">Admin</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
    <?php endif; ?>