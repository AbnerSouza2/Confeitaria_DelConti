<?php
session_start();

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos de login e senha estão corretos
    if ($_POST["username"] == "teste" && $_POST["password"] == "123") {
        $_SESSION["logged_in"] = true;
        header("Location: inserir_produtos.php");
        exit();
    } else {
        $error = "";
    }
}

// Faz o logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
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
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form class="form-login" action="login.php" method="post" <?php echo $_SERVER["PHP_SELF"]; ?>>
        <h1 class="login-php">Login:</h1>
        <input type="text" name="username" placeholder="Usuário" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>
        <button class="button-login" type="submit">Entrar</button>
    </form>
</main>

<script>
    <?php if (isset($error)) { ?>
        alert("Login ou senha incorretos");
    <?php } ?>
</script>

</body>
</html>