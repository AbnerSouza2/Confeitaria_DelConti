<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}

// Inicializa o array de resposta
$response = array();

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se os campos necessários estão definidos
    if (isset($_POST["nome_produto"]) && isset($_POST["valor_produto"])) {
        // Inclui a classe Database
        include("class/Database.php");

        // Configurações de conexão
        $hostname = "localhost";
        $bancodedados = "dario";
        $usuario = "root";
        $senha = "";

        // Cria uma nova instância da classe Database
        $database = new Database($hostname, $bancodedados, $usuario, $senha);
        $database->conectar();

        // Escapa os valores para evitar injeção de SQL
        $nome_produto = $database->conexao->real_escape_string($_POST["nome_produto"]);
        $valor_produto = $database->conexao->real_escape_string($_POST["valor_produto"]);
        $valor_produto = str_replace(",", ".", $_POST["valor_produto"]);

        // Insere os dados na tabela "produtos"
        $sql = "INSERT INTO produtos (nome, valor) VALUES ('$nome_produto', '$valor_produto')";
        if ($database->conexao->query($sql) === true) {
            $response['success'] = true;
            $response['message'] = "Produto inserido com sucesso!";
        } else {
            $response['success'] = false;
            $response['message'] = "Erro ao inserir produto: " . $database->conexao->error;
        }

        // Fecha a conexão
        $database->fecharConexao();
    } else {
        $response['success'] = false;
        $response['message'] = "Todos os campos devem ser preenchidos!";
    }

    // Retorna a resposta como JSON
    echo json_encode($response);
}
?>
