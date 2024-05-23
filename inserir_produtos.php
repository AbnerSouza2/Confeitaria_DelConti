<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir produto</title>
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

    <div class="inserir-produtos">
        <h1>Adicionar Produto</h1>

                    <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('inserir-produto-form').addEventListener('submit', function(event) {
                    event.preventDefault(); // Evita o envio do formulário por padrão

                    var nomeProduto = document.getElementById('nome_produto').value;
                    var valorProduto = document.getElementById('valor_produto').value;

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'bd_produtos.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            alert(response.message);
                        } else {
                            alert('Erro ao inserir o produto.');
                        }
                    };
                    xhr.send('nome_produto=' + encodeURIComponent(nomeProduto) + '&valor_produto=' + encodeURIComponent(valorProduto));
                });
            });
            </script>


<form id="inserir-produto-form" action="bd_produtos.php" method="post">
    <div class="form-group-inserir">
        <label for="nome_produto">Nome do Produto:</label>
        <input type="text" id="nome_produto" name="nome_produto" placeholder="Produto" required>
    </div>
    <div class="form-group-inserir">
        <label for="valor_produto">Valor do Produto:</label>
        <input type="number" id="valor_produto" name="valor_produto" placeholder="R$ " step="0.01" required>
    </div>
    <br>
    <button class="button-inserir-produto button-inserir" type="submit">Adicionar Produto</button>
</form>
    </div>

</body>
</html>
