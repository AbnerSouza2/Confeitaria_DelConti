<?php
include("conexao.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['produto']; // Usaremos o ID do produto
    $quantidade = $_POST['quantidade'];
    $tipo_pagamento = $_POST['forma_pagamento'];
    
    // Buscar o nome, valor unitário e data_hora do produto
    $consultaProduto = "SELECT nome, valor FROM produtos WHERE id = $id_produto";
    $resultadoProduto = $mysqli->query($consultaProduto);
    $produto = $resultadoProduto->fetch_assoc();
    $nome_produto = $produto['nome'];
    $valor_un = $produto['valor'];
    
    // Calcular o valor total da venda
    $valor_total = $valor_un * $quantidade;

    // Inserir a venda no banco de dados, incluindo a data e hora
    $inserirVenda = "INSERT INTO vendas (id_produto, produto, quantidade, tipo_pagamento, valor_un, valor_total, data_hora) VALUES ('$id_produto', '$nome_produto', '$quantidade', '$tipo_pagamento', '$valor_un', '$valor_total', NOW())";
    
    if ($mysqli->query($inserirVenda) === TRUE) {
        // Venda registrada com sucesso
        $response['success'] = true;
        $response['message'] = 'Venda realizada com sucesso!';
    } else {
        // Erro ao registrar a venda
        $response['success'] = false;
        $response['message'] = 'Erro ao registrar venda: ' . $mysqli->error;
    }
}

echo json_encode($response);
?>