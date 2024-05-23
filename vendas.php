<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}



// Verifique se os detalhes do banco de dados estão corretos
$hostname = "localhost";
$bancodedados = "dario";
$usuario = "root";
$senha = "";

function fetchData($database, $query) {
    $result = $database->executarConsulta($query);
    if (!$result) {
        die("Erro ao buscar dados do banco de dados: " . $database->obterErro());
    }
    return $result;
}

// Crie uma instância da classe Database com os detalhes corretos do banco de dados
$database = new Database($hostname, $bancodedados, $usuario, $senha);
$database->conectar();

// Consulta SQL para buscar os produtos
$produtos = fetchData($database, "SELECT id, nome, valor FROM produtos");

// Consulta SQL para buscar os clientes fiados
$clientesFiados = fetchData($database, "SELECT id, nome FROM clientes_fiados");

function resultToArray($result) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Converta os resultados das consultas em arrays associativos
$produtosArray = resultToArray($produtos);
$clientesFiadosArray = resultToArray($clientesFiados);


?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançar Vendas - Confeitaria</title>
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
                    <li><a href="logout.php" class="fecharCaixa" ><img src="imgs/fecharCaixa.png" width="40px" alt="">Fechar Caixa</a></li>
                </ul>
            </nav>
        </div>
    </div>

  
    <div class="container-lancar-vendas">
        <h1>Lançar Vendas</h1>

        <div class="form-venda">
            <form action="bd_vendas.php" method="post"> <!-- Formulário de venda -->
                <label for="produto">Selecione o produto:</label>
                <select name="produto" id="produto">
                    <option value="">Selecione um produto</option>
                    <?php foreach ($produtos as $produto) : ?>
                        <option value="<?= $produto['id'] ?>" data-preco="<?= $produto['valor'] ?>">
                            <?= $produto['nome'] ?> - R$ <?= $produto['valor'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br><br>
                <label for="quantidade">Quantidade:</label>
                <select name="quantidade" id="quantidade">
                    <?php for ($i = 1; $i <= 50; $i++) : ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <br><br>
                <label>Forma de pagamento:</label>
                <br><br>
                <div class="pagamento-options">
                    <input type="radio" id="pix" name="forma_pagamento" value="pix">
                    <label for="pix">PIX</label>

                    <input type="radio" id="cartao" name="forma_pagamento" value="cartao">
                    <label for="cartao">Cartão</label>

                    <input type="radio" id="dinheiro" name="forma_pagamento" value="dinheiro">
                    <label for="dinheiro">Dinheiro</label>

                    <input type="radio" id="fiado" name="forma_pagamento" value="fiado">
                    <label for="fiado">Fiado</label>
                </div>

                <div id="valor-recebido-container" style="display: none;">
                    <label for="valor_recebido">Valor Recebido:</label>
                   <span>R$ <input type="number" id="valor_recebido" name="valor_recebido"> </span> 
                </div>
                 <br>
                <div id="troco-container" style="display: none;">
                    <label for="troco">Troco:</label>
                   R$ <span id="troco"></span>
                </div>
                <br>
                <!-- Adiciona seleção de cliente fiado -->
                <div id="cliente-fiado-container" style="display: none;">
                    <label for="cliente_fiado">Selecione o cliente fiado:</label>
                    <select name="cliente_fiado" id="cliente_fiado">
                        <option value="">Selecione um cliente fiado</option>
                        <?php foreach ($clientesFiados as $clienteFiado) : ?>
                            <option value="<?= $clienteFiado['id'] ?>">
                                <?= $clienteFiado['nome'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn-confirmar-venda" type="submit" id="btn-confirmar-venda">Confirmar Venda</button>
            </form>
        </div>
    </div>

    <script src="vendas.js"></script>
</body>
</html>
