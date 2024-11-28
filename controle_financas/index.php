<?php
session_start();
require_once 'conexao.php';

function buscarMeses($conn) {
    $sql = "SELECT * FROM mes ORDER BY ano_mes,
            FIELD(nome_mes,'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro')";
    return $conn->query($sql);
}

function calcularSaldo($conn, $id_mes) {
    $sql = "SELECT
                COALESCE(SUM(CASE WHEN tipo_movimentacao = 'entrada' THEN valor_movimentacao ELSE 0 END), 0) AS total_entradas,
                COALESCE(SUM(CASE WHEN tipo_movimentacao = 'saida' THEN valor_movimentacao ELSE 0 END), 0) AS total_saidas
            FROM movimentacao
            WHERE id_mes = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mes);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return [
        'total_entradas' => $result['total_entradas'],
        'total_saidas' => $result['total_saidas'],
        'saldo' => $result['total_entradas'] - $result['total_saidas']
    ];
}

function calcularTotal($conn){
    $sql = "SELECT
        COALESCE(SUM(CASE WHEN tipo_movimentacao = 'entrada' THEN valor_movimentacao ELSE 0 END), 0) AS total_entradas,
        COALESCE(SUM(CASE WHEN tipo_movimentacao = 'saida' THEN valor_movimentacao ELSE 0 END), 0) AS total_saidas
    FROM movimentacao";

    $result = $conn->query($sql)->fetch_assoc();
    return [
        'entradas' => $result['total_entradas'],
        'saidas' => $result['total_saidas'],
        'saldo' => $result['total_entradas'] - $result['total_saidas']
    ];
}

$meses = buscarMeses($conn);
$total = calcularTotal($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Finanças</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.css" rel="stylesheet">

</head>
<body>
    <div class="header">
        <h1 class="text-center mb-4">Controle de Finanças  <i class="bi bi-cash-coin"></i></h1> 
    </div>
    <div class="container">
        <div class="top-section text-center">
            <div class="row main-cards">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title">Meses</h5>
                            <a href="meses/mes-create.php" class="btn btn-primary">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title">Categorias</h5>
                            <a href="categorias/categoria-create.php" class="btn btn-primary">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total</h5>
                            <p>R$ <?php echo number_format($total['saldo'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if ($meses->num_rows > 0): ?>
                    <?php while ($mes = $meses->fetch_assoc()): 
                        $saldo = calcularSaldo($conn, $mes['id_mes']);
                        $cor_saldo = $saldo['saldo'] > 0 ? 'bg-success' : ($saldo['saldo'] < 0 ? 'bg-danger' : 'bg-warning');
                    ?>
                </div>
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-lg">
                            <div class="card-header text-center h-100">
                                <h5 class="card-title"><?php echo $mes['nome_mes'] . ' ' . $mes['ano_mes']; ?></h5>
                                <form action="meses/mes-acoes.php" method="POST" class="d-inline">
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Ações
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" name="edit_mes" href="meses/mes-edit.php?id=<?=$mes['id_mes']?>">Editar</a></li>
                                            <li><button class="dropdown-item" onclick="return confirm('Tem certeza que deseja excluir?')" name="delete_mes" type="submit" value="<?=$mes['id_mes']?>">
                                                Deletar
                                            </button></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                            <div class="card <?php echo $cor_saldo; ?> text-white">
                                <div class="card-body">
                                    <p>Total de Entradas: R$<?php echo number_format($saldo['total_entradas'], 2, ',', '.')?></p>
                                    <p>Total de Saídas: R$<?php echo number_format($saldo['total_saidas'], 2, ',', '.')?></p>
                                    <p><strong>Saldo final: <span class="fs-5 fw-bold">R$<?php echo number_format($saldo['saldo'], 2, ',', '.')?></strong></p>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="movimentacoes/movimentacao.php?id_mes=<?php echo $mes['id_mes'];?>" class="btn btn-outline-light">Adicionar</a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile;?>
                        <?php else: ?>
                        <p class="text-center">Nenhum mês cadastrado ainda.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

