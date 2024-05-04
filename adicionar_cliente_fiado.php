<?php
// Inicializa um array para armazenar a resposta
$response = array();

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];

    // Inclui o arquivo de conexão com o banco de dados
    include("conexao.php");

    // Prepara a consulta SQL para inserir os dados na tabela
    $consulta = $mysqli->prepare("INSERT INTO clientes_fiados (nome, telefone) VALUES (?, ?)");

    // Verifica se a consulta foi preparada com sucesso
    if ($consulta) {
        // Liga os parâmetros à consulta e executa-a
        $consulta->bind_param("ss", $nome, $telefone);
        $resultado = $consulta->execute();

        // Verifica se a operação foi bem-sucedida
        if ($resultado) {
            $response['success'] = true;
            $response['message'] = "Cliente fiado adicionado com sucesso!";
        } else {
            $response['success'] = false;
            $response['message'] = "Erro ao adicionar cliente fiado: " . $mysqli->error;
        }

        // Fecha a consulta
        $consulta->close();
    } else {
        $response['success'] = false;
        $response['message'] = "Erro ao preparar a consulta: " . $mysqli->error;
    }

    // Fecha a conexão com o banco de dados
    $mysqli->close();
} else {
    $response['success'] = false;
    $response['message'] = "Método inválido de requisição!";
}

// Retorna a resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>