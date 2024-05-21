<?php
include("conexao.php");

// Desabilitar a exibição de erros para que não interfiram na resposta JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Iniciar buffer de saída para capturar quaisquer mensagens de erro
ob_start();

// Detalhes da conexão ao banco de dados
$hostname = "localhost";
$bancodedados = "dario";
$usuario = "root";
$senha = "";

// Instanciar o objeto Database e conectar ao banco de dados
$database = new mysqli($hostname, $usuario, $senha, $bancodedados);

// Verificar a conexão
if ($database->connect_error) {
    die("Falha na conexão com o banco de dados: " . $database->connect_error);
}

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $forma_pagamento = $_POST['forma_pagamento'];
    $cliente_fiado = isset($_POST['cliente_fiado']) ? $_POST['cliente_fiado'] : null;

    // Validação dos campos
    if (empty($produto) || empty($quantidade) || empty($forma_pagamento)) {
        $response["message"] = "Preencha todos os campos obrigatórios.";
        echo json_encode($response);
        exit;
    }

    // Calcula o valor total da venda
    $consultaProduto = "SELECT nome, valor FROM produtos WHERE id = ?";
    $stmt = $database->prepare($consultaProduto);
    $stmt->bind_param("i", $produto);
    $stmt->execute();
    $resultadoProduto = $stmt->get_result();

    if (!$resultadoProduto) {
        $response["message"] = "Erro ao preparar consulta de produto: " . $database->error;
        error_log("Erro ao preparar consulta de produto: " . $database->error);
        echo json_encode($response);
        exit;
    }

    // Verifica se o produto foi encontrado
    if ($resultadoProduto->num_rows > 0) {
        $produtoDados = $resultadoProduto->fetch_assoc();
        $valor_un = $produtoDados['valor'];
        $nome_produto = $produtoDados['nome'];
        $valor_total = $valor_un * $quantidade;
    } else {
        $response["message"] = "Produto não encontrado.";
        error_log("Produto não encontrado com ID: $produto");
        echo json_encode($response);
        exit;
    }

    
    // Iniciar uma transação para garantir a consistência dos dados
    $database->begin_transaction();

    // Inserir a venda no banco de dados
    $consultaInserirVenda = "INSERT INTO vendas (id_produto, produto, quantidade, tipo_pagamento, valor_un, valor_total, data_hora, id_cliente_fiado) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $database->prepare($consultaInserirVenda);
    $stmt->bind_param("isssdsi", $produto, $nome_produto, $quantidade, $forma_pagamento, $valor_un, $valor_total, $cliente_fiado);
    $stmt->execute();

    if ($forma_pagamento === 'fiado') {
        // Consultar o saldo devedor atual do cliente fiado
        $consultaSaldoAtual = "SELECT saldo_devedor FROM clientes_fiados WHERE id = ?";
        $stmt = $database->prepare($consultaSaldoAtual);
        $stmt->bind_param("i", $cliente_fiado);
        $stmt->execute();
        $resultadoSaldoAtual = $stmt->get_result();
    
        if ($resultadoSaldoAtual->num_rows > 0) {
            $saldo_devedor_atual = $resultadoSaldoAtual->fetch_assoc()['saldo_devedor'];
        } else {
            $saldo_devedor_atual = 0;
        }
    
        // Calcular o novo saldo devedor do cliente fiado
        $novo_saldo_devedor = $saldo_devedor_atual + $valor_total;
    
        // Atualizar o saldo devedor do cliente fiado
        $atualizarSaldo = "UPDATE clientes_fiados SET saldo_devedor = ? WHERE id = ?";
        $stmt = $database->prepare($atualizarSaldo);
        $stmt->bind_param("di", $novo_saldo_devedor, $cliente_fiado);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            // Commit da transação
            $database->commit();
            $response["success"] = true;
            $response["message"] = "Venda registrada com sucesso.";
        } else {
            // Rollback em caso de erro na atualização do saldo
            $database->rollback();
            $response["message"] = "Erro ao atualizar o saldo devedor do cliente fiado.";
        }
    } else {
        // Se a forma de pagamento não envolver um cliente fiado, a venda é registrada sem atualizar o saldo devedor
        // Commit da transação
        $database->commit();
        $response["success"] = true;
        $response["message"] = "Venda registrada com sucesso.";
    }
    

    echo json_encode($response);
    exit;
}

// Capturar qualquer saída inesperada e adicionar ao JSON de resposta para debug
$output = ob_get_clean();
if (!empty($output)) {
    $response["output"] = $output;
    echo json_encode($response);
}
?>
