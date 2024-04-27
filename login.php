<?php
// Verifica se o formulário foi enviado e se a ação é "abrir_caixa"
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "abrir_caixa") {
    // Aqui você pode adicionar a lógica de autenticação
    // Por exemplo, verificar se o nome de usuário e senha são válidos

    // Redireciona para a página após o login ser bem-sucedido
    header("Location: pagina_de_boas_vindas.php");
    exit; // Certifique-se de sair após o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Confeitaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<div class="l-logo-img">
        <img src="imgs/Logo_semFundo.png" width="400px" alt="Logo da Confeitaria">
</div>


    <main>
        <form class="form-login" action="login.php" method="post">
            <h1 class="login-php">Login:</h1>
            <input type="text" name="username" placeholder="Usuário" required><br>
            <input type="password" name="password" placeholder="Senha" required><br>
            <button class="button-login" type="submit">Entrar</button>
        </form>
    </main>

</body>
</html>