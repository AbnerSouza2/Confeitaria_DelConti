<?php
include("conexao.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['produto']; // Usaremos o ID do produto
    $quantidade = $_POST['quantidade'];
    $tipo_pagamento = $_POST['forma_pagamento'];
    $cliente_fiado_id = $_POST['cliente_fiado']; // ID do cliente fiado
    
    // Buscar o nome, valor unitário e data_hora do produto
    $consultaProduto = "SELECT nome, valor FROM produtos WHERE id = $id_produto";
    $resultadoProduto = $mysqli->query($consultaProduto);

    // Verifica se a consulta ao produto foi realizada com sucesso
    if (!$resultadoProduto) {
        $response['success'] = false;
        $response['message'] = 'Erro ao buscar o produto: ' . $mysqli->error;
        echo json_encode($response);
        exit; // Encerra o script
    }

    // Obtém os dados do produto
    $produto = $resultadoProduto->fetch_assoc();
    $nome_produto = $produto['nome'];
    $valor_un = $produto['valor'];
    
    // Calcular o valor total da venda
    $valor_total = $valor_un * $quantidade;

    // Inserir a venda no banco de dados, incluindo a data e hora
    $inserirVenda = "INSERT INTO vendas (id_produto, produto, quantidade, tipo_pagamento, valor_un, valor_total, data_hora, id_cliente_fiado) VALUES ('$id_produto', '$nome_produto', '$quantidade', '$tipo_pagamento', '$valor_un', '$valor_total', NOW(), '$cliente_fiado_id')";
    
    if ($mysqli->query($inserirVenda) === TRUE) {
        // Venda registrada com sucesso
        $response['success'] = true;
        $response['message'] = 'Venda realizada com sucesso!';

        // Se a forma de pagamento for "fiado", atualiza o saldo devedor do cliente fiado
        if ($tipo_pagamento === 'fiado') {
            // Consulta SQL para buscar o saldo devedor atual do cliente fiado
            $consultaSaldoDevedor = "SELECT saldo_devedor FROM clientes_fiados WHERE id = $cliente_fiado_id";
            $resultadoSaldoDevedor = $mysqli->query($consultaSaldoDevedor);

            // Verifica se a consulta do saldo devedor foi realizada com sucesso
            if (!$resultadoSaldoDevedor) {
                $response['success'] = false;
                $response['message'] = 'Erro ao buscar o saldo devedor do cliente fiado: ' . $mysqli->error;
                echo json_encode($response);
                exit; // Encerra o script
            }

            // Obtém o saldo devedor atual do cliente fiado
            $saldo_devedor_atual = $resultadoSaldoDevedor->fetch_assoc()['saldo_devedor'];

            // Atualiza o saldo devedor do cliente fiado com o valor da venda
            $novo_saldo_devedor = $saldo_devedor_atual + $valor_total;
            $atualizarSaldoDevedor = "UPDATE clientes_fiados SET saldo_devedor = $novo_saldo_devedor WHERE id = $cliente_fiado_id";

            if ($mysqli->query($atualizarSaldoDevedor) === TRUE) {
                // Saldo devedor atualizado com sucesso
                $response['saldo_devedor'] = $novo_saldo_devedor;
            } else {
                // Erro ao atualizar o saldo devedor
                $response['success'] = false;
                $response['message'] = 'Erro ao atualizar saldo devedor do cliente fiado: ' . $mysqli->error;
            }
        }
    } else {
        // Erro ao registrar a venda
        $response['success'] = false;
        $response['message'] = 'Erro ao registrar venda: ' . $mysqli->error;
    }
}

echo json_encode($response);
?>
