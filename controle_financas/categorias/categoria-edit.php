<?php
session_start();
require_once '../conexao.php';

if (!isset($_GET['id'])) {
    header('Location: categoria-create.php');
    exit();
} else {
// mysqli_real_escape_string($conn, $_GET['id'])
    $categoriaId = (int)$_GET['id'];
    $sql = "SELECT * FROM categoria WHERE id_categoria = $categoriaId";
    $result = mysqli_query($conn, $sql);

    if(!$result || mysqli_num_rows($result) == 0) {
        $_SESSION['message'] = "Categoria não encontrada.";
        $_SESSION['type'] = 'error';
        header('Location: categoria-create.php');
        exit();
    }
}

$categoria = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../css/categoria.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card bg-dark">
                    <div class="card-header text-white bg-dark"><h4 class="mt-3 mb-3 text-center">Editar Categoria</h4></div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="categoria-acoes.php" method="POST">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria'];?>">
                            <div class="mb-3">
                                <label for="nome_categoria">Nome da Categoria</label>
                                <input type="text" name="nome_categoria" id="nome_categoria" value="<?=$categoria['nome_categoria']?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="descricao_categoria">Descrição da Categoria</label>
                                <textarea type="text" name="descricao_categoria" id="descricao_categoria" class="form-control"><?=$categoria['descricao_categoria']?></textarea>
                            </div>
                            <div class="mb-3">
                                <a href="categoria-create.php" class="btn btn-outline-dark float-end">Voltar</a>
                                <button type="submit" class="btn btn-outline-dark">Salvar</button>
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