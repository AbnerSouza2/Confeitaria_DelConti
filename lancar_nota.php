<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}


// Criando uma nova instância da classe Database
$database = new Database("localhost", "dario", "root", "");
$database->conectar(); // Estabelece a conexão com o banco de dados

$response = array();

// Verifica se os dados foram enviados via POST para adicionar uma nova nota fiscal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos Empresa e valor da nota foram enviados
    if (isset($_POST["empresa"]) && isset($_POST["valor_nota"])) {
        // Obtém os dados do formulário
        $empresa = $_POST["empresa"];
        $valor_nota = $_POST["valor_nota"];

        // Validação simples dos dados
        if (!empty($empresa) && !empty($valor_nota)) {
            // Insere os dados no banco de dados
            $sql = "INSERT INTO notas_fiscais (empresa, valor_nota, data_hora) VALUES (?, ?, NOW())";
            $consulta = $database->conexao->prepare($sql);

            // Verifica se a consulta foi preparada com sucesso
            if ($consulta) {
                // Liga os parâmetros à consulta e executa-a
                $consulta->bind_param("sd", $empresa, $valor_nota);
                $resultado = $consulta->execute();
                if ($resultado) {
                    echo "<script>alert('Nota fiscal adicionada com sucesso!');</script>";
                    header("Location: lancar_nota.php"); // Redireciona para a página de lançar nota novamente
                    exit(); // Encerra o script para garantir que o redirecionamento seja efetuado
                } else {
                    echo "<script>alert('Erro ao adicionar nota fiscal: " . $database->conexao->error . "');</script>";
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

// Consulta SQL para buscar as notas fiscais apenas do dia atual
$consultaNotas = "SELECT * FROM notas_fiscais WHERE DATE(data_hora) = CURDATE()";

// Se a data de início e a data de fim forem fornecidas, a consulta será ajustada para o período especificado
if(isset($_GET['data_inicio_lancamento']) && isset($_GET['data_fim_lancamento'])) {
    $data_inicio = $_GET['data_inicio_lancamento'];
    $data_fim = $_GET['data_fim_lancamento'];
    $consultaNotas = "SELECT * FROM notas_fiscais 
                      WHERE DATE(data_hora) >= '$data_inicio' 
                      AND DATE(data_hora) <= '$data_fim'";
}

// Adiciona a cláusula ORDER BY para ordenar as notas fiscais de forma decrescente pela data e hora
$consultaNotas .= " ORDER BY data_hora DESC";

// Executa a consulta
$resultadoNotas = $database->conexao->query($consultaNotas) or die($database->conexao->error);

// Calcula o total das notas fiscais
$totalNotas = 0;
if ($resultadoNotas && $resultadoNotas->num_rows > 0) {
    while ($nota = $resultadoNotas->fetch_assoc()) {
        $totalNotas += $nota['valor_nota'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas Fiscais</title>
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

    <div class="container-notas">
       

        <!-- Formulário de adição de nota fiscal -->
        <div class="form-container">
             <h1>Notas Fiscais</h1>
            <form id="form-nota-fiscal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" id="empresa" name="empresa" placeholder="Empresa" required>
                <input type="number" id="valor_nota" name="valor_nota" placeholder="Valor da Nota" step="0.01" required>
                <button type="submit">Adicionar Nota Fiscal</button>
            </form>
        </div>

        <!-- Formulário de filtro de data -->
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="data_inicio_lancamento">Data inicial:</label>
            <input type="date" id="data_inicio_lancamento" name="data_inicio_lancamento" value="<?php echo $data_inicio; ?>">
            <label for="data_fim_lancamento">Data final:</label>
            <input type="date" id="data_fim_lancamento" name="data_fim_lancamento" value="<?php echo $data_fim; ?>">
            <button type="submit" style="padding: 5px 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Filtrar</button>
        </form>

        <br>

        <!-- Tabela de notas fiscais -->
        <?php if ($resultadoNotas) : ?>
            <table class="table-financeiro">
                <thead>
                    <tr>
                        <th>Data e Hora</th>
                        <th>Empresa</th>
                        <th>Valor da Nota</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultadoNotas->data_seek(0); // Voltar ao início do resultado
                    while ($nota = $resultadoNotas->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?php echo $nota['data_hora']; ?></td>
                            <td><?php echo $nota['empresa']; ?></td>
                            <td>R$ <?php echo number_format($nota['valor_nota'], 2, ',', '.'); ?></td>
                            <td class="editar">
                                <a onclick="return confirm('Tem certeza que deseja excluir esta nota fiscal?')" href="deletes/delete_notas.php?id=<?php echo $nota['id']; ?>" title="Excluir">
                                    <img src="imgs/iconeDelete.png" width="25px" alt="Excluir">
                                </a>
                            </td>

                            
                        </tr>
                    <?php endwhile; ?>
                    <tr class="totalNotas">
                        <td colspan="3" align="right">Total das Notas:</td>
                        <td>R$ <?php echo number_format($totalNotas, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>
