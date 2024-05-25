<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}

// Configuração da conexão
$hostname = "localhost";
$bancodedados = "dario";
$usuario = "root";
$senha = "";



// Cria uma instância da classe Database e conecta
$database = new Database($hostname, $bancodedados, $usuario, $senha);
$database->conectar(); // Estabelece a conexão com o banco de dados

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
            $consulta = $database->conexao->prepare("INSERT INTO clientes_fiados (nome, telefone) VALUES (?, ?)");

            // Verifica se a consulta foi preparada com sucesso
            if ($consulta) {
                // Liga os parâmetros à consulta e executa-a
                $consulta->bind_param("ss", $nome, $telefone);
                $resultado = $consulta->execute();

                if ($resultado) {
                    $_SESSION['sucesso'] = 'Cliente fiado adicionado com sucesso!';
                    header("Location: {$_SERVER['PHP_SELF']}");
                } else {
                    echo "<script>alert('Erro ao adicionar cliente fiado: " . $database->conexao->error . "');</script>";
                }

                // Fecha a consulta
                $consulta->close();
            } else {
                echo "Erro ao preparar a consulta: " . $database->conexao->error;
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
$clientesPorPagina = 10; // Alterado para 10 clientes por página
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $clientesPorPagina;

// Consulta SQL para obter os clientes fiados com seus saldos devedores
$sqlClientes = "SELECT id, nome, telefone, saldo_devedor
                FROM clientes_fiados";


$resultClientes = $database->conexao->query($sqlClientes);
$totalClientes = $resultClientes->num_rows;


$totalPaginas = ceil($totalClientes / $clientesPorPagina);


$sqlClientesPaginacao = $sqlClientes . " LIMIT $clientesPorPagina OFFSET $offset";
$resultClientesPaginacao = $database->conexao->query($sqlClientesPaginacao);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Fiados - Confeitaria</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body class="menusDel">
    <div class="top-inserir">
        <div class="menu-php">
            <div class="inserir-logo-img">
                <img src="imgs/Logo_semFundo.png" width="150px" alt="Logo da Confeitaria">
            </div>
            <nav class="nav-inserir-produtos">
                <ul>
                <li><a href="inserir_produtos.php"><img src="features/inserirprodutos.png" width="25px" srcset="">Inserir Produtos</a></li>
                    <li><a href="produtos_cadastrados.php"><img src="features/produtoCadastrado.png" width="25px" srcset="">Produtos Cadastrados</a></li>
                    <li><a href="vendas.php"><img src="features/vendas.png" width="25px" srcset="">Vender Produto</a></li>
                    <li><a href="financeiro.php"><img src="features/financeiro.png" width="25px" srcset="">Financeiro</a></li>
                    <li><a href="clientes_fiado.php"><img src="features/clienteFiado.png" width="25px" srcset="">Clientes Fiado</a></li>
                    <li><a href="lancar_nota.php"><img src="features/notasFiscais.png" width="25px" srcset="">Lançar Notas</a></li>
                    <li><a href="logout.php" class="fecharCaixa" ><img src="imgs/fecharCaixa.png" width="40px" alt="">Fechar Caixa</a></li>

                </ul>
            </nav>
        </div>
    </div>

    <div class="container-fiados">
        <div class="form-container">
            <h1>Clientes Fiados</h1>

            <form id="form-cliente-fiado" action="clientes_fiado.php" method="post">
                <input type="text" id="nome" name="nome" placeholder="Nome do Cliente" required>
                <input type="tel" id="telefone" name="telefone" placeholder="Telefone do Cliente" pattern="[0-9]{10,11}" required>
                <button type="submit">Adicionar Cliente</button>
            </form>
            
        </div>

       

        <div class="table-responsive">
            <table class="table">             
                <thead>      
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th style="color: orange;">Saldo Devedor</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Lista de clientes fiados -->
                    <?php
                  
                    while ($cliente = $resultClientesPaginacao->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($cliente['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($cliente['telefone']) . "</td>";
                        echo "<td style='color: orange;'>R$ " . number_format($cliente['saldo_devedor'], 2, ',', '.') . "</td>";
                        echo '<td class="editar">
                            <a class="btn btn-sm btn-primary botao-edit" href="editFiado.php?id=' . $cliente['id'] . '" title="Editar">
                                <img src="imgs/iconeEditar.png" width="25px" alt="Editar">
                            </a>
                            <a onclick="return confirm(\'Tem certeza que deseja excluir este cliente?\')" href="deletes/delete_fiado.php?id=' . $cliente['id'] . '" title="Excluir">
                                <img src="imgs/iconeDelete.png" width="25px" alt="Excluir">
                            </a>
                            </td>';
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

<?php
$database->fecharConexao();
?>
