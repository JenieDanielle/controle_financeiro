<?php
session_start();
require_once '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Mês</title>
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
                        <div class=" mt-3 mb-3 text-center">
                            <h4>
                                Adicionar Mês
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card">
                        <div class="card-body">
                            <form action="mes-acoes.php" method="POST">
                                <div class="mb-3">
                                    <label for="txtnome_mes" class="form-label">Escolha o mês</label>
                                    <select class="form-select" id="txtnome_mes" name="txtnome_mes">
                                        <option value="Janeiro">Janeiro</option>
                                        <option value="Fevereiro">Fevereiro</option>
                                        <option value="Março">Março</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Maio">Maio</option>
                                        <option value="Junho">Junho</option>
                                        <option value="Julho">Julho</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Setembro">Setembro</option>
                                        <option value="Outubro">Outubro</option>
                                        <option value="Novembro">Novembro</option>
                                        <option value="Dezembro">Dezembro</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="txtano_mes" class="form-label">Ano</label>
                                    <input type="text" class="form-control" id="txtano_mes" name="txtano_mes">
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="../index.php" class="btn btn-outline-dark float-end">Voltar</a>
                                    <button type="submit" name="create-mes" class="btn btn-outline-dark">Salvar</button>
                                </div>
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



