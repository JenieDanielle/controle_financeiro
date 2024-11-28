<?php
session_start();
require_once '../conexao.php';

$sql = "SELECT * FROM categoria ORDER BY nome_categoria";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../css/categoria.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card bg-dark">
                    <div class="card-header text-white bg-dark">
                        <h4 class="mt-3 mb-3 text-center">
                            Adicionar Categoria
                        </h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="categoria-acoes.php" method="POST">
                            <input type="hidden" name="acao" value="cadastrar">
                            <div class="mb-3">
                                <label for="nome_categoria">Nome da Categoria</label>
                                <input type="text" name="nome_categoria" id="nome_categoria" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="descricao_categoria">Descrição da Categoria</label>
                                <textarea type="text" name="descricao_categoria" id="descricao_categoria" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Salvar</button>
                            <a href="../index.php" class="btn btn-outline-dark float-end">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card bg-dark mt-4">
                    <div class="card-header text-white bg-dark"><h5 class=" text-center">Categorias Cadastradas</h5></div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php if ($result->num_rows > 0): ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($categoria = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $categoria['nome_categoria']; ?></td>
                                            <td><?php echo $categoria['descricao_categoria']; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="categoria-edit.php?id=<?php echo $categoria['id_categoria']; ?>">Editar</a></li>
                                                        <li><a class="dropdown-item" href="categoria-acoes.php?acao=excluir&id=<?php echo $categoria['id_categoria'];?>" onclick="return confirm('Deseja excluir essa categoria?')">Excluir</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-center">Nenhuma categoria cadastrada.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>