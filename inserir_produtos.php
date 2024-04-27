<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outra Aba - Confeitaria</title>
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
                        <li><a href="#">Lançar Produtos</a></li>
                        <li><a href="#">Financeiro</a></li>
                        <li><a href="#">Clientes Fiado</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="inserir-produtos">
        <h1>Inserir Produtos</h1>
        <form action="processar_insercao.php" method="post">
            <div class="form-group">
                <label for="nome_produto">Nome do Produto:</label>
                <input type="text" id="nome_produto" name="nome_produto" placeholder="Produto" required>
            </div>
            <div class="form-group">
                <label for="valor_produto">Valor do Produto:</label>
                <input type="text" id="valor_produto" name="valor_produto" placeholder="R$ " required>
            </div>
            
        </form>
        <button type="submit">Inserir Produto</button>
    </div>



</body>
</html>