<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}

$database = new Database("localhost", "dario", "root", ""); // Configurar com suas próprias credenciais

// Estabelece a conexão com o banco de dados
$database->conectar();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Buscar os dados do produto no banco de dados
    $sqlSelect = "SELECT * FROM produtos WHERE id=$id";
    $result = $database->conexao->query($sqlSelect); // Utiliza a conexão estabelecida pela classe Database
    
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
                    <li><a href="produtos_cadastrados.php">Produtos Cadastrados</a></li>
                    <li><a href="vendas.php">Vender Produto</a></li>
                    <li><a href="financeiro_php">Financeiro</a></li>
                    <li><a href="clientes_fiado.php">Clientes Fiado</a></li>
                    <li><a href="lancar_nota.php">Lançar Notas</a></li>
                    <li><a href="logout.php" class="fecharCaixa" ><img src="imgs/fecharCaixa.png" width="40px" alt="">Fechar Caixa</a></li>
                </ul>
            </nav>
        </div>
   <div class="container-edit">
    <form id="edit-form" action="update.php" method="post">
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