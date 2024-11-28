<?php
session_start();
require_once('../conexao.php');

$mes = [];

if (!isset($_GET['id'])) {
    header('Location: ../index.php');
} else {
    $mesId = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM mes WHERE id_mes = '{$mesId}'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) >0) {
        $mes = mysqli_fetch_array($query);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar - Mes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../css/mes.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card bg-dark">
                    <div class="card-header text-white bg-dark">
                        <div class="mt-3 mb-3 text-center">
                            <h4>
                                Editar mês
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card">
                        <div class="card-body">
                            <?php
                            if ($mes) : 
                            ?>
                            <form action="../meses/mes-acoes.php" method="POST">
                                <input type="hidden" name="mes_id" value="<?=$mes['id_mes']?>">
                                <div class="mb-3">
                                    <label for="nome_mes" class="form-label">Nome do Mês</label>
                                    <select name="nome_mes" id="nome_mes" class="form-control">
                                        <?php
                                        $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                                                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                                        foreach ($meses as $mes_nome) {
                                            $selected = $mes_nome === $mes['nome_mes'] ? 'selected' : '';
                                            echo "<option value=\"$mes_nome\" $selected>$mes_nome</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="ano_mes" class="form-label">Ano</label>
                                    <input type="text" name="ano_mes" id="ano_mes" class="form-control" value="<?php echo $mes['ano_mes']; ?>">
                                </div>
                                <div class=" mt-4 mb-3">
                                    <a href="../index.php" class="btn btn-outline-dark  float-end">Voltar</a>
                                    <button type="submit" name="edit_mes" class="btn btn-outline-dark">Salvar</button>
                                </div>
                            </form>
                        <?php
                        else:
                        ?>
                        <div class="alert alert-warning alert-dimissible fade show" role="alert">
                            Mês não encontrado
                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <?php
                        endif;
                        ?>
                        </div>
                </div> 
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>