<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Bem-vindo ao Sistema de Avaliação Escolar</h1>
    <img src="images/escola.jpg" alt="Imagem de escola" class="main-image">
    <p class="description">Este sistema permite calcular sua nota global anual desde o 6º ano do fundamental até o 3º ano do ensino médio, ajudando você a acompanhar seu desempenho escolar.</p>
    
    <div class="actions">
        <a href="cadastro.php" class="btn btn-primary">Cadastre-se para começar</a>
        
        <div class="admin-login">
            <h3>Acesso Administrador</h3>
            <form action="includes/auth.php" method="post">
                <input type="text" name="username" placeholder="Usuário" required>
                <input type="password" name="password" placeholder="Senha" required>
                <button type="submit" class="btn btn-secondary">Entrar</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>