<?php
session_start();
include_once("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}


// Verifica se existe uma mensagem na sessão
if(isset($_SESSION['mensagem'])) {
    // Exibe o alerta com a mensagem
    echo "<script>alert('" . $_SESSION['mensagem'] . "');</script>";

    // Remove a mensagem da sessão para não exibi-la novamente
    unset($_SESSION['mensagem']);
}
// Configurações de paginação
$produtosPorPagina = 10;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * $produtosPorPagina;

// Consulta SQL com limitação de resultados
$consulta = "SELECT * FROM produtos LIMIT $offset, $produtosPorPagina";
$con = $database->executarConsulta($consulta) or die($database->conexao->error);


// Contagem total de produtos
$totalProdutos = $database->executarConsulta("SELECT COUNT(*) AS total FROM produtos")->fetch_assoc()['total'];

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
                                <a onclick="return confirm('Tem certeza que deseja excluir este produto?')" href="deletes/delete_produtos.php?id=<?php echo $dado['id']; ?>" title="Excluir">
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

    
    

</body>

</html>