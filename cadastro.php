<?php 
include 'includes/header.php';
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    // Inserir no banco de dados
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $stmt->execute([$nome, $email]);
    
    // Redirecionar para a página correta
    $tipo_cadastro = $_POST['tipo_cadastro'];
    if ($tipo_cadastro == 'nota_global') {
        header("Location: secundaria1.php?email=" . urlencode($email));
    } else {
        header("Location: secundaria2.php?email=" . urlencode($email));
    }
    exit();
}
?>

<div class="container">
    <h2>Cadastro de Usuário</h2>
    <form method="post">
        <div class="form-group">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required class="form-control">
        </div>
        
        <div class="form-group">
            <p>Selecione o tipo de cadastro:</p>
            <div class="radio-options">
                <label>
                    <input type="radio" name="tipo_cadastro" value="nota_global" checked> 
                    Possuo apenas nota global anual
                </label>
                <label>
                    <input type="radio" name="tipo_cadastro" value="notas_disciplinas"> 
                    Possuo notas por disciplina
                </label>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Continuar</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>