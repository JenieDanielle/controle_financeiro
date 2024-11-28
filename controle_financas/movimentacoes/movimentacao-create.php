<?php
session_start();
require_once '../conexao.php';



if (!isset($_GET['id_mes']) || empty($_GET['id_mes'])) {
    echo "Erro: ID do mês não foi fornecido!";
    exit;
}
$mesId = mysqli_real_escape_string($conn, $_GET['id_mes']);


/*--------------------*/

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
            <div class="col-md-6 col-lg-6">
                <div class="card bg-dark">
                    <div class="card-header text-white bg-dark">
                        <div class="mt-3 mb-3 text-center ">
                            <h3>
                                Cadastrar Movimentação
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card">
                        <div class="card-body">
                            <form action="movimentacao-acoes.php" method="POST">
                                <input type="hidden" name="id_mes" value="<?php echo $mesId; ?>">
                                <input type="hidden" name="acao" value="cadastrar">
                                
                                <div class="mt-4 mb-3">
                                    <label for="data_movimentacao">Data da transação</label>
                                    <input type="date" name="data_movimentacao" id="data_movimentacao" class="form-control">
                                </div>
                                <div class="input-group mb-3">
                                <span class="input-group-text">Valor R$</span>
                                <input type="number" name="valor_movimentacao" id="valor_movimentacao" class="form-control" step="0.01" aria-label="Text input with dropdown button">
                                <select class="form-select" name="tipo_movimentacao" id="tipo_movimentacao" aria-label="Default select example">
                                    <option selected>Tipo de movimentação</option>
                                    <option value="entrada">Entrada</option>
                                    <option value="saida">Saída</option>
                                </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_categoria">Categoria</label>
                                    <select class="form-select" name="id_categoria" id="id_categoria" aria-label="Default select example">
                                        <option selected>Selecione uma das categorias</option>
                                        <?php while ($categoria = $resultCategorias->fetch_assoc()): ?>
                                            <option value="<?php echo $categoria['id_categoria']; ?>">
                                                <?php echo $categoria['nome_categoria']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="descricao_movimentacao">Descrição</label>
                                    <textarea type="text" name="descricao_movimentacao" id="descricao_movimentacao" class="form-control"></textarea>
                                </div>
                                <a href="movimentacao.php?id_mes=<?php echo $mesId; ?>" class="btn btn-outline-dark float-end">Voltar</a>
                                <button type="submit" name="create_movimentacoes" class="btn btn-outline-dark">Salvar</button>
                            </form>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>