<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se os campos necessários estão definidos
    if (isset($_POST["nome_produto"]) && isset($_POST["valor_produto"])) {
        // Conecta-se ao banco de dados
        $hostname = "localhost";
        $bancodedados = "dario";
        $usuario = "root";
        $senha = "";

        // Estabelece a conexão com o banco de dados
        $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

        // Verifica se houve erro na conexão
        if ($mysqli->connect_errno) {
            echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            exit();
        }

        // Escapa os valores para evitar injeção de SQL
        $nome_produto = $mysqli->real_escape_string($_POST["nome_produto"]);
        $valor_produto = $mysqli->real_escape_string($_POST["valor_produto"]);

        $valor_produto = str_replace(",", ".", $_POST["valor_produto"]);

        // Insere os dados na tabela "produtos"
        $sql = "INSERT INTO produtos (nome, valor) VALUES ('$nome_produto', '$valor_produto')";
        if ($mysqli->query($sql) === true) {
            echo "Produto inserido com sucesso!";
        } else {
            echo "Erro ao inserir produto: " . $mysqli->error;
        }

        // Fecha a conexão
        $mysqli->close();
    } else {
        echo "Todos os campos devem ser preenchidos!";
    }
}
?>
