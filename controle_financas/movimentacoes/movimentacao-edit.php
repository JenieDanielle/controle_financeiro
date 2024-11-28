<?php
session_start();
require_once '../conexao.php';

// Verifica se o ID da movimentação foi enviado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Erro: ID da movimentação não foi informado!";
    exit;
}

$idMovimentacao = $_GET['id'];

// Busca a movimentação no banco de dados
$sqlMovimentacao = "SELECT * FROM movimentacao WHERE id_movimentacao = $idMovimentacao";
$resultMovimentacao = $conn->query($sqlMovimentacao);

if ($resultMovimentacao->num_rows == 0) {
    echo "Erro: Movimentação não encontrada!";
    exit;
}

$movimentacao = $resultMovimentacao->fetch_assoc();

// Busca as categorias no banco de dados
$sqlCategorias = "SELECT * FROM categoria";
$resultCategorias = $conn->query($sqlCategorias);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Movimentação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../css/movimentacao.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark">
                <div class="card-header text-white bg-dark">
                    <div class=" mt-3 mb-3 text-center">
                        <h3>
                            Editar movimentação
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-body">
                        <form action="movimentacao-acoes.php" method="POST">
                           
                            <input type="hidden" name="id_movimentacao" value="<?php echo $movimentacao['id_movimentacao']; ?>">
                            <input type="hidden" name="id_mes" value="<?php echo $movimentacao['id_mes']; ?>">
                            <input type="hidden" name="acao" value="edit">

                            <div class="mt-4 mb-3">
                                <label for="data_movimentacao" class="form-label">Data da Transação</label>
                                <input type="date" name="data_movimentacao" id="data_movimentacao" class="form-control" 
                                value="<?php echo $movimentacao['data_movimentacao']; ?>">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">Valor R$</span>
                                <input type="number" name="valor_movimentacao" id="valor_movimentacao" class="form-control" step="0.01" value="<?php echo $movimentacao['valor_movimentacao']; ?>" aria-label="Text input with dropdown button">
                                <select class="form-select" name="tipo_movimentacao" id="tipo_movimentacao" aria-label="Default select example">
                                    <option selected>Tipo de movimentação</option>
                                    <option value="entrada" <?php echo $movimentacao['tipo_movimentacao'] == 'entrada' ? 'selected' : ''; ?>>Entrada</option>
                                    <option value="saida" <?php echo $movimentacao['tipo_movimentacao'] == 'saida' ? 'selected' : ''; ?>>Saída</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="id_categoria" class="form-label">Categoria</label>
                                <select name="id_categoria" id="id_categoria" class="form-select">
                                    <option value="">Selecione uma categoria</option>
                                    <?php while ($categoria = $resultCategorias->fetch_assoc()): ?>
                                        <option value="<?php echo $categoria['id_categoria']; ?>"
                                            <?php echo $movimentacao['id_categoria'] == $categoria['id_categoria'] ? 'selected' : ''; ?>>
                                            <?php echo $categoria['nome_categoria']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descricao_movimentacao" class="form-label">Descrição</label>
                                <textarea name="descricao_movimentacao" id="descricao_movimentacao" class="form-control" rows="3"><?php echo $movimentacao['descricao_movimentacao']; ?></textarea>
                            </div>

                            <div class=" mt-4 mb-3">
                             <a href="movimentacao.php?id_mes=<?php echo $movimentacao['id_mes']; ?>" class="btn btn-outline-dark">Voltar</a>
                                <button type="submit" class="btn btn-outline-dark float-end">Salvar</button>
                            </div>
                        </form>
                    </div>
            </div> 
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
