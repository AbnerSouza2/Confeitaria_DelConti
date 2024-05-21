<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}

include_once("class/database.php");

// Criando uma nova instância da classe Database
$database = new Database("localhost", "dario", "root", "");
$database->conectar(); // Estabelece a conexão com o banco de dados

// Verifica se foi fornecido um ID de nota fiscal para exclusão
if (isset($_GET["id"])) {
    $id_nota = $_GET["id"];
    
    // Prepara e executa a consulta de exclusão
    $consultaExclusao = $database->conexao->prepare("DELETE FROM notas_fiscais WHERE id = ?");
    $consultaExclusao->bind_param("i", $id_nota);
    if ($consultaExclusao->execute()) {
        echo "<script>alert('Nota fiscal excluída com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir nota fiscal: " . $database->conexao->error . "');</script>";
    }
    
    // Redireciona de volta para a página de lançar nota após a exclusão
    header("Location: lancar_nota.php");
    exit();
} else {
    echo "<script>alert('ID de nota fiscal não fornecido!');</script>";
    header("Location: lancar_nota.php");
    exit();
}
?>
