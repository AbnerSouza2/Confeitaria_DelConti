<?php
include("conexao.php");

// Consulta SQL para buscar os produtos
$consultaProdutos = "SELECT id, nome, valor FROM produtos";
$resultadoProdutos = $mysqli->query($consultaProdutos) or die($mysqli->error);

// Consulta SQL para buscar os clientes fiados
$consultaClientesFiados = "SELECT id, nome FROM clientes_fiados";
$resultadoClientesFiados = $mysqli->query($consultaClientesFiados) or die($mysqli->error);

// Armazenar os resultados em uma matriz
$produtos = array();
while ($produto = $resultadoProdutos->fetch_assoc()) {
    $produtos[] = $produto;
}

// Armazenar os clientes fiados em uma matriz
$clientesFiados = array();
while ($cliente = $resultadoClientesFiados->fetch_assoc()) {
    $clientesFiados[] = $cliente;
}
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

                <label for="quantidade">Quantidade:</label>
                <select name="quantidade" id="quantidade">
                    <?php for ($i = 1; $i <= 50; $i++) : ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <label>Forma de pagamento:</label>
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

    <script>
    
    // Adiciona um ouvinte de evento para monitorar as mudanças na seleção de opções de pagamento
    var opcoesPagamento = document.querySelectorAll('input[name="forma_pagamento"]');
    opcoesPagamento.forEach(function(opcao) {
        opcao.addEventListener('change', function() {
            var valorRecebidoContainer = document.getElementById('valor-recebido-container');
            var trocoContainer = document.getElementById('troco-container');
            var clienteFiadoContainer = document.getElementById('cliente-fiado-container');

            if (this.value === 'dinheiro') {
                valorRecebidoContainer.style.display = 'block';
                trocoContainer.style.display = 'block';
                clienteFiadoContainer.style.display = 'none'; // Ocultar a seleção do cliente fiado quando não for 'Fiado'
            } else if (this.value === 'fiado') {
                valorRecebidoContainer.style.display = 'none';
                trocoContainer.style.display = 'none';
                clienteFiadoContainer.style.display = 'block'; // Exibir a seleção do cliente fiado apenas quando for 'Fiado'
            } else {
                valorRecebidoContainer.style.display = 'none';
                trocoContainer.style.display = 'none';
                clienteFiadoContainer.style.display = 'none'; // Ocultar a seleção do cliente fiado quando não for 'Fiado'
            }
        });
    });

    // Adiciona um ouvinte de evento para monitorar mudanças no valor recebido
    document.getElementById('valor_recebido').addEventListener('input', function() {
        // Obtém o valor do produto selecionado e a quantidade
        var precoProduto = parseFloat(document.getElementById('produto').selectedOptions[0].getAttribute('data-preco'));
        var quantidade = parseInt(document.getElementById('quantidade').value);

        // Calcula o valor total da venda
        var valorTotal = precoProduto * quantidade;

        // Obtém o valor recebido e converte para número
        var valorRecebido = parseFloat(this.value);

        // Calcula o troco
        var troco = valorRecebido - valorTotal;

        // Exibe o troco formatado com duas casas decimais
        document.getElementById('troco').textContent = troco.toFixed(2);
    });

    <!--Script de alerta da venda -->

    document.getElementById('btn-confirmar-venda').addEventListener('click', function(event) {
        event.preventDefault(); // Evita o envio do formulário por padrão

        var produto = document.getElementById('produto').value;
        var quantidade = document.getElementById('quantidade').value;
        var formaPagamento = document.querySelector('input[name="forma_pagamento"]:checked').value;
        var clienteFiado = document.getElementById('cliente_fiado').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'bd_vendas.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Exibe o alerta na mesma página
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            }
        };
        xhr.send('produto=' + produto + '&quantidade=' + quantidade + '&forma_pagamento=' + formaPagamento + '&cliente_fiado=' + clienteFiado);
    });

    </script>
</body>

</html>
