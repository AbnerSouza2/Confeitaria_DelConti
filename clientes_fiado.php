<?php
include("conexao.php");

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];

    // Insere os dados no banco de dados
    include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

    // Prepara a consulta SQL para inserir os dados na tabela
    $consulta = $mysqli->prepare("INSERT INTO clientes_fiados (nome, telefone) VALUES (?, ?)");

    // Verifica se a consulta foi preparada com sucesso
    if ($consulta) {
        // Liga os parâmetros à consulta e executa-a
        $consulta->bind_param("ss", $nome, $telefone);
        $resultado = $consulta->execute();

        // Fecha a consulta
        $consulta->close();
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }

    // Fecha a conexão com o banco de dados
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Fiados - Confeitaria</title>
    <link rel="stylesheet" href="style.css">
  
    <!-- Coloque o código JavaScript aqui -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('form-cliente-fiado').addEventListener('submit', function(event) {
                event.preventDefault(); // Evita o envio do formulário por padrão

                var formData = new FormData(this); // Obtém os dados do formulário

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'adicionar_cliente_fiado.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(response.message);
                            // Limpa os campos do formulário após o sucesso
                            document.getElementById('nome').value = '';
                            document.getElementById('telefone').value = '';
                        } else {
                            alert(response.message);
                        }
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</head>

<body class="menusDel">
    <div class="top-inserir">
        <div class="menu-php">
            <div class="inserir-logo-img">
                <img src="imgs/Logo_semFundo.png" width="150px" alt="Logo da Confeitaria">
            </div>
            <nav class="nav-inserir-produtos">
                <ul>
                    <li><a href="inserir_produtos.php">Inserir Produtos</a></li>
                    <li><a href="produtos_cadastrados.php">Produtos Cadastrados</a></li>
                    <li><a href="vendas.php">Vender Produto</a></li>
                    <li><a href="financeiro.php">Financeiro</a></li>
                    <li><a href="clientes_fiados.php">Clientes Fiado</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container-cadastrados">
        <div class="form-container">
            <h1>Adicionar Cliente</h1>
            <form id="form-cliente-fiado" action="adicionar_cliente_fiado.php" method="post">
                <input type="text" id="nome" name="nome" placeholder="Nome do Cliente" required>
                <input type="text" id="telefone" name="telefone" placeholder="Telefone do Cliente" required>
                <button type="submit">Adicionar Cliente</button>
            </form>
        </div>

        <h2>Clientes Fiados</h2>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Lista de clientes fiados -->
                    <?php
                    $consultaClientes = "SELECT * FROM clientes_fiados";
                    $resultadoClientes = $mysqli->query($consultaClientes) or die($mysqli->error);
                    ?>
                    <?php while ($cliente = $resultadoClientes->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $cliente['nome']; ?></td>
                            <td><?php echo $cliente['telefone']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>


