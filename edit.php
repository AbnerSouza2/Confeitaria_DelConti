<?php
include("conexao.php");

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Buscar os dados do produto no banco de dados
    $sqlSelect = "SELECT * FROM produtos WHERE id=$id";
    $result = $mysqli->query($sqlSelect);
    
    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit; // Encerra o script se o produto não for encontrado
    }
} else {
    echo "ID do produto não especificado.";
    exit; // Encerra o script se o ID do produto não for fornecido na URL
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Cadastrados - Confeitaria</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="menusDel">
    <div class="top-inserir">
        <div class="menu-php">
            <div class="inserir-logo-img">
                <img src="imgs/Logo_semFundo.png" width="150px" alt="Logo da Confeitaria">
            </div>
            <nav class="nav-inserir-produtos">
                <ul>
                    <li><a href="inserir_produtos.php">Inserir Produtos</a></li>
                    <li><a href="#">Produtos Cadastrados</a></li>
                    <li><a href="#">Lançar Produtos</a></li>
                    <li><a href="#">Financeiro</a></li>
                    <li><a href="#">Clientes Fiado</a></li>
                </ul>
            </nav>
        </div>
   <div class="container-edit">
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
        <h1 class="edit-title">Editar Produto</h1>
        <label for="nome" class="edit-label">Nome do Produto:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $produto['nome']; ?>" class="edit-input">
        <label for="valor" class="edit-label">Valor do Produto:</label>
        <input type="text" name="valor" id="valor" value="<?php echo $produto['valor']; ?>" class="edit-input">
        <button type="submit" class="edit-button">Salvar Alterações</button>
    </form>
</div>

    <script>
        // Substitui vírgulas por pontos antes de enviar o formulário
        document.getElementById('edit-form').addEventListener('submit', function(event) {
            var valorInput = document.getElementById('valor');
            valorInput.value = valorInput.value.replace(',', '.');
        });
    </script>
    
</body>
</html>