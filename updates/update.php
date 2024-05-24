<?php
session_start(); // Inicia a sessão

include_once("../conexao.php");

$database = new Database("localhost", "dario", "root", ""); // Configurar com suas próprias credenciais

// Estabelece a conexão com o banco de dados
$database->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os dados do formulário foram enviados
    if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['valor'])) {
        // Obtém os dados do formulário
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $valor = $_POST['valor'];
        
        // Chama a função para atualizar o produto
        $resultado = atualizarProduto($id, $nome, $valor);
        
        if ($resultado) {
            // Definir mensagem de sucesso
            header("Location: ../index.php");
           echo $_SESSION['mensagem'] = "Produto atualizado com sucesso!";
        } else {
            // Definir mensagem de erro, se necessário
            $_SESSION['mensagem'] = "Erro ao atualizar o produto.";
        }
        
        // Redireciona de volta para a página de edição
        header("Location: ../produtos_cadastrados.php?id=$id");
        exit();
    } else {
        // Caso contrário, redireciona para a página inicial ou página de erro
        header("Location: ../index.php");
        exit();
    }
} else {
    // Se o método de solicitação não for POST, redireciona para a página inicial ou página de erro
    header("Location: ../index.php");
    exit();
}

// Função para atualizar produto
function atualizarProduto($id, $nome, $valor) {
    global $database;
    $sqlUpdate = "UPDATE produtos SET nome='$nome', valor='$valor' WHERE id=$id";
    $resultado = $database->conexao->query($sqlUpdate); // Executa a atualização

    return $resultado; // Retorna o resultado da atualização
}
?>
