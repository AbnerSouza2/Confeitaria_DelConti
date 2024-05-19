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

$response = array();

// Defina as datas inicial e final para o dia atual
$data_inicio = date('Y-m-d');
$data_fim = date('Y-m-d', strtotime('+1 day'));

// Consulta SQL para buscar as vendas do dia atual
$consultaVendas = "SELECT * FROM vendas 
                  WHERE DATE(data_hora) >= '$data_inicio' 
                  AND DATE(data_hora) < '$data_fim' 
                  ORDER BY data_hora DESC";

// Executa a consulta
$resultadoVendas = $database->conexao->query($consultaVendas) or die($database->conexao->error);

// Calcula o lucro total de todas as vendas
$totalLucro = 0;
if ($resultadoVendas && $resultadoVendas->num_rows > 0) {
    while ($venda = $resultadoVendas->fetch_assoc()) {
        $totalLucro += $venda['valor_total'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeiro - Confeitaria</title>
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
                    <li><a href="clientes_fiado.php">Clientes Fiado</a></li>
                    <li><a href="lancar_nota.php">Lançar Notas</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container-financeiro">
        <h1>Relatório Financeiro</h1>

        <!-- Formulário de filtro de data -->
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="data_inicio">Data inicial:</label>
            <input type="date" id="data_inicio" name="data_inicio">
            <label for="data_fim">Data final:</label>
            <input type="date" id="data_fim" name="data_fim">
            <button type="submit" style="padding: 5px 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Filtrar</button>
        </form>
        <br>

        <!-- Tabela de vendas -->
        <?php if ($resultadoVendas) : ?>
            <table class="table-financeiro">
                <thead>
                    <tr>
                        <th>Data e Hora</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Forma de Pagamento</th>
                        <th>Valor_Und</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultadoVendas->data_seek(0); // Voltar ao início do resultado
                    while ($venda = $resultadoVendas->fetch_assoc()) :
                    ?>
                        <tr>
                            <td><?php echo $venda['data_hora']; ?></td>
                            <td><?php echo $venda['produto']; ?></td>
                            <td><?php echo $venda['quantidade']; ?></td>
                            <td><?php echo $venda['tipo_pagamento']; ?></td>
                            <td><?php echo $venda['valor_un']; ?></td>
                            <td>R$ <?php echo number_format($venda['valor_total'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr class="lucroTotal">
                        <td colspan="5" align="right">Lucro Total:</td>
                        <td>R$ <?php echo number_format($totalLucro, 2, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>