<?php
include("class/database.php");

$hostname = "localhost";
$bancodedados = "dario";
$usuario = "root";
$senha = "";

$database = new Database($hostname, $bancodedados, $usuario, $senha);
$database->conectar(); // Estabelece a conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        if (!empty($id)) {
            $consulta = $database->conexao->prepare("DELETE FROM notas_fiscais WHERE id = ?");
            if ($consulta) {
                $consulta->bind_param("i", $id);
                $resultado = $consulta->execute();

                if ($resultado) {
                    echo "<script>alert('Nota fiscal excluída com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao excluir nota fiscal: " . $database->conexao->error . "');</script>";
                }

                $consulta->close();
            } else {
                echo "Erro ao preparar a consulta: " . $database->conexao->error;
            }
        } else {
            echo "<script>alert('Erro nos dados recebidos!');</script>";
        }
    }
}

// Redirecionamento para página anterior após exclusão
header("Location: lancar_nota.php");
$database->fecharConexao();
exit();
?>
