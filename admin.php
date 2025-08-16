<?php 
include 'includes/header.php';
include 'includes/auth.php';
include 'includes/db_connect.php';

// Verificar se o usuário é admin
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit();
}

// Obter todos os usuários ordenados por média global
$usuarios = $pdo->query("SELECT nome, email, media_global FROM usuarios WHERE media_global IS NOT NULL ORDER BY media_global DESC")->fetchAll();
?>

<div class="container">
    <h2>Painel de Administração</h2>
    <p class="admin-info">Aqui você pode visualizar o ranking de todos os usuários cadastrados.</p>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Posição</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Nota Global Final</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $index => $usuario): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= number_format($usuario['media_global'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <a href="index.php" class="btn btn-primary">Voltar ao Início</a>
    <a href="includes/logout.php" class="btn btn-danger">Sair</a>
</div>

<?php include 'includes/footer.php'; ?>