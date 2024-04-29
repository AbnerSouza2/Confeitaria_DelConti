<?php

include("conexao.php");

$consulta = "select * from produtos";
$con = $mysqli->query($consulta) or die($mysqli->error);

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
                    <li><a href="#">Produtos Cadastrados</a></li>
                    <li><a href="#">Lançar Produtos</a></li>
                    <li><a href="#">Financeiro</a></li>
                    <li><a href="#">Clientes Fiado</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container-cadastrados">
        <div class="table-responsive">
            <table class="table">
                <h1>Produtos Cadastrados</h1>
                <thead>
                    <tr>
                        <th class="th-produto">Produto</th>
                        <th>Valor</th>
                        <th>Editar</th>
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
                    <?php if (!empty($produtos)): ?>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?php echo $produto['nome']; ?></td>
                                <td>R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>