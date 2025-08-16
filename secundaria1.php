<?php 
include 'includes/header.php';
include 'includes/db_connect.php';

$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notas = [
        '6ano' => $_POST['6ano'],
        '7ano' => $_POST['7ano'],
        '8ano' => $_POST['8ano'],
        '9ano' => $_POST['9ano'],
        '1medio' => $_POST['1medio'],
        '2medio' => $_POST['2medio'],
        '3medio' => $_POST['3medio']
    ];
    
    // Calcular média
    $soma = array_sum($notas);
    $quantidade = count(array_filter($notas, function($v) { return $v !== ''; }));
    $media_global = $quantidade > 0 ? $soma / $quantidade : 0;
    
    // Atualizar no banco de dados
    $stmt = $pdo->prepare("UPDATE usuarios SET notas_globais = ?, media_global = ? WHERE email = ?");
    $stmt->execute([json_encode($notas), $media_global, $email]);
    
    header("Location: terciaria1.php?email=" . urlencode($email));
    exit();
}
?>

<div class="container">
    <h2>Cadastro de Notas Globais Anuais</h2>
    <form method="post">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        
        <div class="form-group">
            <label for="6ano">6º Ano do Fundamental:</label>
            <input type="number" id="6ano" name="6ano" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="7ano">7º Ano do Fundamental:</label>
            <input type="number" id="7ano" name="7ano" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="8ano">8º Ano do Fundamental:</label>
            <input type="number" id="8ano" name="8ano" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="9ano">9º Ano do Fundamental:</label>
            <input type="number" id="9ano" name="9ano" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="1medio">1º Ano do Ensino Médio:</label>
            <input type="number" id="1medio" name="1medio" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="2medio">2º Ano do Ensino Médio:</label>
            <input type="number" id="2medio" name="2medio" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="3medio">3º Ano do Ensino Médio:</label>
            <input type="number" id="3medio" name="3medio" min="0" max="10" step="0.1" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Calcular Média Global</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>