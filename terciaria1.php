<?php 
include 'includes/header.php';
include 'includes/db_connect.php';

$email = $_GET['email'] ?? '';
$usuario = $pdo->prepare("SELECT nome, media_global FROM usuarios WHERE email = ?");
$usuario->execute([$email]);
$usuario = $usuario->fetch();

if (!$usuario) {
    header("Location: cadastro.php");
    exit();
}
?>

<div class="container">
    <h2>Resultado Final</h2>
    
    <div class="resultado-box">
        <h3>Olá, <?= htmlspecialchars($usuario['nome']) ?>!</h3>
        <p>Sua nota global final é: <strong><?= number_format($usuario['media_global'], 2) ?></strong></p>
        
        <?php if ($usuario['media_global'] >= 8.0): ?>
        <div class="alert alert-success">
            <h4>Parabéns!</h4>
            <p>Você atingiu um excelente desempenho com média acima de 80%. Isso demonstra um ótimo aproveitamento durante sua trajetória escolar.</p>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            <h4>Bom trabalho!</h4>
            <p>Sua média global está abaixo de 80%, mas isso não diminui seu esforço. Continue se dedicando para melhorar ainda mais seu desempenho.</p>
        </div>
        <?php endif; ?>
    </div>
    
    <a href="index.php" class="btn btn-primary">Voltar ao Início</a>
</div>

<?php include 'includes/footer.php'; ?>