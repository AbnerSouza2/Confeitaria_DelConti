<?php
// delete.php
require 'conexao.php';

// Verifica se o ID do produto foi enviado através da URL
if (!empty($_GET['id'])) {
    // Obtém o ID do produto da URL
    $id = $_GET['id'];

    // Consulta SQL para verificar se o produto existe no banco de dados
    $sqlSelect = "SELECT * FROM produtos WHERE id=$id";
    $result = $database->executarConsulta($sqlSelect);
    
    // Verifica se o produto foi encontrado
    if ($result->num_rows > 0) {
        // Consulta SQL para excluir o produto do banco de dados
        $sqlDelete = "DELETE FROM produtos WHERE id=$id";
        $resultDelete = $database->executarConsulta($sqlDelete);
        
        // Verifica se a exclusão foi bem-sucedida
        if ($resultDelete) {
            echo "Produto excluído com sucesso!";
        } else {
            echo "Erro ao excluir produto: " . $database->conexao->error;
        }
    } else {
        echo "Produto não encontrado.";
    }
}

// Redireciona de volta para a página principal
header('Location: produtos_cadastrados.php');
?>
