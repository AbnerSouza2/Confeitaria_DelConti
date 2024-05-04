<?php
include("conexao.php");

$response = array();

// Se o formulário de filtro de data for enviado
// Se o formulário de filtro de data for enviado
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['data_inicio']) && isset($_GET['data_fim'])) {
    $data_inicio = $_GET['data_inicio'];
    $data_fim = $_GET['data_fim'];
    // Formatar as datas no formato adequado para consultas SQL
    $data_inicio_formatada = date('Y-m-d', strtotime($data_inicio));
    $data_fim_formatada = date('Y-m-d', strtotime($data_fim));

    // Adicionamos um dia à data final para garantir que todas as vendas do último dia sejam incluídas
    $data_fim_formatada = date('Y-m-d', strtotime($data_fim_formatada . ' +1 day'));

    // Consulta SQL para buscar as vendas dentro do intervalo de datas especificado
    $consultaVendas = "SELECT * FROM vendas 
                      WHERE DATE(data_hora) >= '$data_inicio_formatada' 
                      AND DATE(data_hora) < '$data_fim_formatada' 
                      ORDER BY data_hora DESC";
} else {
    // Consulta SQL para buscar as vendas apenas do dia atual
    $hoje = date('Y-m-d');
    $consultaVendas = "SELECT v.*, p.nome AS nome_produto 
                      FROM vendas v 
                      INNER JOIN produtos p ON v.id_produto = p.id 
                      WHERE DATE(v.data_hora) = '$hoje' 
                      ORDER BY v.data_hora DESC";
}

$resultadoVendas = $mysqli->query($consultaVendas) or die($mysqli->error);

// Calcular o lucro total de todas as vendas
$totalLucro = 0;
while ($venda = $resultadoVendas->fetch_assoc()) {
    $totalLucro += $venda['valor_total'];
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

        <table class="table-financeiro">
            <thead>
                <tr>
                    <th>Data e Hora</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Forma de Pagamento</th>
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
                        <td>R$ <?php echo number_format($venda['valor_total'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="4" align="right">Lucro Total:</td>
                    <td>R$ <?php echo number_format($totalLucro, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>