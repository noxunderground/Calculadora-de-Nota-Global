<?php 
include 'includes/header.php';
include 'includes/db_connect.php';

$email = $_GET['email'] ?? '';
$anos = ['6ano', '7ano', '8ano', '9ano', '1medio', '2medio', '3medio'];
$notas_globais = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Processar dados do formulário
    $dados_anos = [];
    
    foreach ($anos as $ano) {
        if (isset($_POST[$ano])) {
            $disciplinas = $_POST[$ano]['disciplina'];
            $notas = $_POST[$ano]['nota'];
            $dados_ano = [];
            
            for ($i = 0; $i < count($disciplinas); $i++) {
                if (!empty($disciplinas[$i]) && !empty($notas[$i])) {
                    $dados_ano[] = [
                        'disciplina' => $disciplinas[$i],
                        'nota' => floatval($notas[$i])
                    ];
                }
            }
            
            // Calcular média do ano
            $soma = array_sum(array_column($dados_ano, 'nota'));
            $media_ano = count($dados_ano) > 0 ? $soma / count($dados_ano) : 0;
            
            $dados_anos[$ano] = [
                'disciplinas' => $dados_ano,
                'media_ano' => $media_ano
            ];
        }
    }
    
    // Calcular média global final
    $medias_anos = array_column($dados_anos, 'media_ano');
    $media_global = count($medias_anos) > 0 ? array_sum($medias_anos) / count($medias_anos) : 0;
    
    // Salvar no banco de dados
    $stmt = $pdo->prepare("UPDATE usuarios SET notas_disciplinas = ?, media_global = ? WHERE email = ?");
    $stmt->execute([json_encode($dados_anos), $media_global, $email]);
    
    header("Location: terciaria1.php?email=" . urlencode($email));
    exit();
}
?>

<div class="container">
    <h2>Cadastro de Notas por Disciplina</h2>
    <form method="post" id="formNotas">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        
        <?php foreach ($anos as $ano): ?>
        <div class="ano-container" id="<?= $ano ?>-container">
            <h3><?= str_replace(['ano', 'medio'], ['º Ano do Fundamental', 'º Ano do Ensino Médio'], $ano) ?></h3>
            
            <div class="disciplinas-container" id="<?= $ano ?>-disciplinas">
                <div class="disciplina-row">
                    <input type="text" name="<?= $ano ?>[disciplina][]" placeholder="Disciplina" class="form-control">
                    <input type="number" name="<?= $ano ?>[nota][]" min="0" max="10" step="0.1" placeholder="Nota" class="form-control">
                    <button type="button" class="btn btn-sm btn-danger remove-row">Remover</button>
                </div>
            </div>
            
            <button type="button" class="btn btn-sm btn-success add-disciplina" data-ano="<?= $ano ?>">Adicionar Disciplina</button>
        </div>
        <?php endforeach; ?>
        
        <button type="submit" class="btn btn-primary">Calcular Média Global</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar nova linha de disciplina
    document.querySelectorAll('.add-disciplina').forEach(btn => {
        btn.addEventListener('click', function() {
            const ano = this.getAttribute('data-ano');
            const container = document.getElementById(`${ano}-disciplinas`);
            
            const newRow = document.createElement('div');
            newRow.className = 'disciplina-row';
            newRow.innerHTML = `
                <input type="text" name="${ano}[disciplina][]" placeholder="Disciplina" class="form-control">
                <input type="number" name="${ano}[nota][]" min="0" max="10" step="0.1" placeholder="Nota" class="form-control">
                <button type="button" class="btn btn-sm btn-danger remove-row">Remover</button>
            `;
            
            container.appendChild(newRow);
            
            // Adicionar evento de remoção
            newRow.querySelector('.remove-row').addEventListener('click', function() {
                container.removeChild(newRow);
            });
        });
    });
    
    // Remover linha de disciplina
    document.querySelectorAll('.remove-row').forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentNode.parentNode.removeChild(this.parentNode);
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>