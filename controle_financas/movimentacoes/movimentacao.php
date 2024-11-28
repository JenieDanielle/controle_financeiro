<?php
session_start();
require_once '../conexao.php';



if (!isset($_GET['id_mes']) || empty($_GET['id_mes'])) {
    echo "Erro: ID do mês não foi fornecido!";
    exit;
}
$mesId = mysqli_real_escape_string($conn, $_GET['id_mes']);

// Buscar categorias para o select
$sqlCategorias = "SELECT id_categoria, nome_categoria FROM categoria";
$resultCategorias = $conn->query($sqlCategorias);

// Buscar movimentações para listar
$sqlMovimentacoes = "
    SELECT m.*, c.nome_categoria 
    FROM movimentacao m
    JOIN categoria c ON m.id_categoria = c.id_categoria
    WHERE m.id_mes = $mesId
    ORDER BY m.data_movimentacao DESC";
$resultMovimentacoes = $conn->query($sqlMovimentacoes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../css/movimentacao.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-10">
                <div  class="card mt-4 bg-dark">
                    <div class="mt-3 mb-3 card-header text-center text-white bg-dark">
                        <h4>Movimentações Cadastradas do mês <?php echo $mesId; ?>
                        <a href="../movimentacoes/movimentacao-create.php?id_mes=<?php echo $mesId; ?>" class=" btn btn-outline-light float-end">
                            <i class="bi bi-plus-lg"></i> Adicionar
                        </a>
                        </h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php if ($resultMovimentacoes->num_rows > 0): ?>
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Valor</th>
                                        <th>Tipo de Movimentação</th>
                                        <th>Categoria</th>
                                        <th>Descrição</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($movimentacao = $resultMovimentacoes->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $movimentacao['data_movimentacao'];?></td>
                                            <td>
                                                <span class="badge <?php echo $movimentacao['tipo_movimentacao'] === 'entrada' ? 'bg-success' : 'bg-danger'; ?>">
                                                    R$ <?php echo number_format($movimentacao['valor_movimentacao'], 2, ',', '.'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $movimentacao['tipo_movimentacao'] === 'entrada' ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo ucfirst($movimentacao['tipo_movimentacao']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $movimentacao['nome_categoria']; ?></td>
                                            <td><?php echo $movimentacao['descricao_movimentacao']; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                         <i class="bi bi-gear"></i> Ações
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="movimentacao-edit.php?id=<?php echo $movimentacao['id_movimentacao']; ?>">Editar</i></a></li>
                                                        <li><a href="movimentacao-acoes.php?acao=excluir&id=<?php echo $movimentacao['id_movimentacao']; ?>&id_mes=<?php echo $movimentacao['id_mes']; ?>" type="submit" class="dropdown-item" onclick="return confirm('Deseja excluir essa movimentação?')">Excluir </a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                </tbody>
                            </table>
                            <div class="mb-3">
                                    <a href="../index.php" class="btn btn-outline-dark float-end">Voltar</a>   
                            </div>
                        <?php else: ?>
                            <p class="text-center">Nenhuma movimentação cadastrada.</p>
                            <div class="mb-3">
                                        <a href="../index.php" class="btn btn-outline-dark float-end">Voltar</a>   
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>