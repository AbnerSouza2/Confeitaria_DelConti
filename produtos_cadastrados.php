<?php
include("conexao.php");

// Configurações de paginação
$produtosPorPagina = 10;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $produtosPorPagina;

// Consulta SQL com limitação de resultados
$consulta = "SELECT * FROM produtos LIMIT $offset, $produtosPorPagina";
$con = $mysqli->query($consulta) or die($mysqli->error);

// Contagem total de produtos
$totalProdutos = $mysqli->query("SELECT COUNT(*) AS total FROM produtos")->fetch_assoc()['total'];
$totalPaginas = ceil($totalProdutos / $produtosPorPagina);

// Função para gerar links de paginação
function paginaLink($pagina) {
    return "?pagina=$pagina";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Cadastrados - Confeitaria</title>
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

    <div class="container-cadastrados">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <h1>Produtos Cadastrados</h1>
                    <tr>
                        
                        <th class="th-produto">Produto</th>
                        <th>Valor</th>
                        <th class="editar-produto">Editar</th>
                    </tr>
                    <?php while ($dado = $con->fetch_array()) { ?>
                        <tr>
                            <td><?php echo $dado["nome"]; ?></td>
                            <td>R$ <?php echo $dado["valor"]; ?></td>
                            <td class="editar">
                                <a class="btn btn-sm btn-primary botao-edit" href="edit.php?id=<?php echo $dado['id']; ?>" title="Editar">
                                    <img src="imgs/iconeEditar.png" width="25px" alt="Editar">
                                </a>
                                <a onclick="return confirm('Tem certeza que deseja excluir este produto?')" href="delete.php?id=<?php echo $dado['id']; ?>" title="Excluir">
                                    <img src="imgs/iconeDelete.png" width="25px" alt="Excluir">
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </thead>
                <tbody>

            </table>
            <br>

            <!-- Paginação -->
            <div class="pagination">
             <?php if ($paginaAtual > 1 ) : ?>
                <a href="<?php echo paginaLink($paginaAtual - 1); ?>">Anterior</a>
             <?php endif; ?>
        
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <a href="<?php echo paginaLink($i); ?>" <?php if ($paginaAtual == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($paginaAtual < $totalPaginas) : ?>
                <a href="<?php echo paginaLink($paginaAtual + 1); ?>">Próxima</a>
            <?php endif; ?>
        </div>
            </div>
        </div>

    <!-- Adicione controles de navegação para paginação usando a função paginaLink() -->
    

</body>

</html>