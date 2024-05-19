<?php
include_once("class/database.php");

// Criando uma instância da classe Database
$database = new Database("localhost", "dario", "root", "");

// Verifica se o ID do cliente foi fornecido
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtém o ID do cliente
    $id_cliente = $_GET['id'];

    // Verifica se o cliente tem vendas relacionadas
    $consultaVendas = "SELECT COUNT(*) AS total_vendas FROM vendas WHERE id_cliente_fiado = ?";
    $resultadoVendas = $database->executarConsulta($consultaVendas, array($id_cliente));

    // Verifica se a consulta foi executada com sucesso
    if ($resultadoVendas) {
        $total_vendas = $resultadoVendas->fetch_assoc()['total_vendas'];

        if ($total_vendas > 0) {
            // Existem vendas relacionadas a este cliente, não é possível excluir
            $_SESSION['alerta'] = 'Este cliente possui vendas relacionadas. Não é possível excluí-lo.';
            header('Location: clientes_fiado.php');
            exit();
        } else {
            // Não há vendas relacionadas, é seguro excluir o cliente
            $consultaExcluirCliente = "DELETE FROM clientes_fiados WHERE id = ?";
            $stmt = $database->conexao->prepare($consultaExcluirCliente);
            
            // Verifica se a consulta foi preparada com sucesso
            if ($stmt) {
                // Liga o parâmetro à consulta e executa-a
                $stmt->bind_param("i", $id_cliente); // "i" indica que o parâmetro é um inteiro
                $resultado = $stmt->execute();
            
                // Verifica se a exclusão foi bem-sucedida
                if ($resultado) {
                    $_SESSION['sucesso'] = 'Cliente fiado excluído com sucesso!';
                } else {
                    $_SESSION['erro'] = 'Erro ao excluir cliente fiado: ' . $stmt->error;
                }
            
                // Fecha a consulta
                $stmt->close();
            } else {
                $_SESSION['erro'] = 'Erro ao preparar a consulta de exclusão: ' . $database->conexao->error;
            }
        }
    } else {
        $_SESSION['erro'] = 'Erro ao verificar vendas relacionadas: ' . $database->obterErro();
    }
} else {
    $_SESSION['erro'] = 'ID do cliente não fornecido!';
}

// Redireciona de volta para a página de clientes fiados
header('Location: clientes_fiado.php');

// Fecha a conexão com o banco de dados
$database->fecharConexao();
?>
