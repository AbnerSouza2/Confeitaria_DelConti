<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outra Aba - Confeitaria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


        <div class="top-inserir">
            <div class="menu-php">
                <div class="inserir-logo-img">
                    <img src="imgs/Logo_semFundo.png" width="150px" alt="Logo da Confeitaria">
                </div>
                <nav>
                    <ul>
                        <li><a href="#">Inserir Produtos</a></li>
                        <li><a href="#">Produtos Cadastrados</a></li>
                        <li><a href="#">Lançar Produtos</a></li>
                        <li><a href="#">Financeiro</a></li>
                        <li><a href="#">Clientes Fiado</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="inserir-produtos">
        <h2>Inserir Produtos</h2>
        <form action="processar_insercao.php" method="post">
            <div class="form-group">
                <label for="nome_produto">Nome do Produto:</label>
                <input type="text" id="nome_produto" name="nome_produto" required>
            </div>
            <div class="form-group">
                <label for="valor_produto">Valor do Produto:</label>
                <input type="text" id="valor_produto" name="valor_produto" required>
            </div>
            <button type="submit">Inserir Produto</button>
        </form>
    </div>



</body>
</html>