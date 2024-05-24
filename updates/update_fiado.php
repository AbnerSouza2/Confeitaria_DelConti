<?php
include_once("../conexao.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // Redireciona para a página de login
    header("Location: ../login.php");
    exit();
}

$database = new Database("localhost", "dario", "root", ""); // Configurar com suas próprias credenciais
$database->conectar(); // Estabelece a conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['telefone'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $saldo_devedor = str_replace(',', '.', $_POST['saldo_devedor']); // Converte vírgulas para pontos

        // Atualizar os dados do cliente fiado no banco de dados
        $sqlUpdate = "UPDATE clientes_fiados SET nome=?, telefone=?, saldo_devedor=? WHERE id=?";
        $stmt = $database->conexao->prepare($sqlUpdate);
        $stmt->bind_param("ssdi", $nome, $telefone, $saldo_devedor, $id);

        if ($stmt->execute()) {
            // Atualizar o saldo devedor do cliente fiado no banco de dados
            $sqlUpdateSaldo = "UPDATE clientes_fiados SET saldo_devedor=? WHERE id=?";
            $stmtSaldo = $database->conexao->prepare($sqlUpdateSaldo);
            $stmtSaldo->bind_param("di", $saldo_devedor, $id);
            $stmtSaldo->execute();

            // Buscar novamente os dados do cliente fiado atualizados
            $sqlSelect = "SELECT * FROM clientes_fiados WHERE id=?";
            $stmtSelect = $database->conexao->prepare($sqlSelect);
            $stmtSelect->bind_param("i", $id);
            $stmtSelect->execute();
            $resultSelect = $stmtSelect->get_result();

            if ($resultSelect->num_rows > 0) {
                $cliente = $resultSelect->fetch_assoc();
                

            } else {
                echo "Erro ao buscar os dados atualizados do cliente fiado.";
                exit;
            }

            // Redirecionar o usuário para a página clientes_fiado.php
            header("Location: ../clientes_fiado.php");
            exit;
        } else {
            echo "Erro ao atualizar os dados do cliente fiado.";
        }
    } else {
        echo "Todos os campos devem ser preenchidos.";
    }
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados do cliente fiado no banco de dados
    $sqlSelect = "SELECT * FROM clientes_fiados WHERE id=?";
    $stmt = $database->conexao->prepare($sqlSelect);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    } else {
        echo "Cliente não encontrado.";
        exit; // Encerra o script se o cliente não for encontrado
    }
} else {
    echo "ID do cliente não especificado.";
    exit; // Encerra o script se o ID do cliente não for fornecido na URL
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Fiados - Confeitaria</title>
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
                    <li><a href="financeiro.php">Financeiro</a></li>
                    <li><a href="clientes_fiados.php">Clientes Fiado</a></li>
                    <li><a href="lancar_nota.php">Lançar Notas</a></li>
                    <li><a href="logout.php">Fechar Caixa</a></li>
                </ul>
            </nav>
        </div>
        <div class="container-edit">
            <form id="edit-form" action="update_fiado.php" method="post">
                <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                <h1 class="edit-title">Editar Cliente Fiado</h1>
                <label for="nome" class="edit-label">Nome do Cliente:</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" class="edit-input">
                <label for="telefone" class="edit-label">Telefone do Cliente:</label>
                <input type="tel" name="telefone" id="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>" class="edit-input">
                <label for="saldo_devedor" class="edit-label">Saldo Devedor:</label>
                <input type="text" name="saldo_devedor" id="saldo_devedor" value="<?php echo htmlspecialchars($cliente['saldo_devedor']); ?>" class="edit-input">
                <button type="submit" class="edit-button">Salvar Alterações</button>
            </form>
        </div>
    </div>
    <script>
        // Substitui vírgulas por pontos antes de enviar o formulário
        document.getElementById('edit-form').addEventListener('submit', function(event) {
            var saldoInput = document.getElementById('saldo_devedor');
            saldoInput.value = saldoInput.value.replace(',', '.');
        });
    </script>
</body>
</html>
