<?php
include("conexao.php");

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos nome e telefone foram enviados
    if (isset($_POST["nome"]) && isset($_POST["telefone"])) {
        // Obtém os dados do formulário
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];

        // Validação simples dos dados
        if (!empty($nome) && !empty($telefone)) {
            // Insere os dados no banco de dados
            $consulta = $mysqli->prepare("INSERT INTO clientes_fiados (nome, telefone) VALUES (?, ?)");

            // Verifica se a consulta foi preparada com sucesso
            if ($consulta) {
                // Liga os parâmetros à consulta e executa-a
                $consulta->bind_param("ss", $nome, $telefone);
                $resultado = $consulta->execute();

                if ($resultado) {
                    echo "<script>alert('Cliente fiado adicionado com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao adicionar cliente fiado: " . $mysqli->error . "');</script>";
                }

                // Fecha a consulta
                $consulta->close();
            } else {
                echo "Erro ao preparar a consulta: " . $mysqli->error;
            }
        } else {
            echo "<script>alert('Por favor, preencha todos os campos!');</script>";
        }
    } else {
        echo "<script>alert('Erro nos dados recebidos!');</script>";
    }
}

// Função para gerar links de paginação
function paginaLink($pagina) {
    return "?pagina=$pagina";
}

// Definir variáveis de paginação
$clientesPorPagina = 10;
$sqlTotalClientes = "SELECT COUNT(*) AS total FROM clientes_fiados";
$resultTotalClientes = $mysqli->query($sqlTotalClientes);
$totalClientes = $resultTotalClientes->fetch_assoc()['total'];
$totalPaginas = ceil($totalClientes / $clientesPorPagina);
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Fiados - Confeitaria</title>
    <link rel="stylesheet" href="style.css">
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
            <form id="form-cliente-fiado" action="clientes_fiado.php" method="post">
                <input type="text" id="nome" name="nome" placeholder="Nome do Cliente" required>
                <input type="tel" id="telefone" name="telefone" placeholder="Telefone do Cliente" pattern="[0-9]{10,11}" required>
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
                        <th style="color: orange;">Saldo Devedor</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Lista de clientes fiados -->
                    <?php
                    $offset = ($paginaAtual - 1) * $clientesPorPagina;

                    // Consulta SQL para obter os clientes da página atual
                    $sqlClientes = "SELECT * FROM clientes_fiados LIMIT $clientesPorPagina OFFSET $offset";
                    $resultClientes = $mysqli->query($sqlClientes);

                    while ($cliente = $resultClientes->fetch_assoc()) {
                        // Consulta SQL para calcular o saldo devedor do cliente atual
                        $id_cliente = $cliente['id'];
                        $sqlSaldoDevedor = "SELECT IFNULL(SUM(valor_total), 0) AS saldo_devedor FROM vendas WHERE id_cliente_fiado = $id_cliente";
                        $resultSaldoDevedor = $mysqli->query($sqlSaldoDevedor);
                        $saldo_devedor = $resultSaldoDevedor->fetch_assoc()['saldo_devedor'];

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($cliente['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['telefone']) . "</td>";
                        // Exibe o saldo devedor
                        echo "<td style='color: orange;'>R$ " . number_format($saldo_devedor, 2, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination">
        <?php if ($paginaAtual > 1) : ?>
            <a href="<?php echo paginaLink($paginaAtual - 1); ?>">Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
            <a href="<?php echo paginaLink($i); ?>" <?php if ($paginaAtual == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($paginaAtual < $totalPaginas) : ?>
            <a href="<?php echo paginaLink($paginaAtual + 1); ?>">Próxima</a>
        <?php endif; ?>
    </div>
</body>

</html>