<?php
include("conexao.php");

if (!empty($_POST['id']) && !empty($_POST['nome']) && !empty($_POST['valor'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    
    // Substitua a vírgula por ponto no valor
    $valor = str_replace(',', '.', $_POST['valor']);
    
    // Atualizar o produto no banco de dados
    $sqlUpdate = "UPDATE produtos SET nome='$nome', valor='$valor' WHERE id=$id";
    if ($mysqli->query($sqlUpdate) === TRUE) {
        header('Location: inserir_produtos.php');
    } else {
        echo "Erro ao atualizar produto: " . $mysqli->error;
    }
} else {
    echo "Todos os campos devem ser preenchidos.";
}
?>