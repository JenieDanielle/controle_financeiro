<?php
session_start();
require_once('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {
        $data = mysqli_real_escape_string($conn, $_POST['data_movimentacao']);
        $tipo = mysqli_real_escape_string($conn, $_POST['tipo_movimentacao']);
        $descricao = mysqli_real_escape_string($conn, $_POST['descricao_movimentacao']);
        $valor = mysqli_real_escape_string($conn, $_POST['valor_movimentacao']);
        $categoria = (int)$_POST['id_categoria'];
        $mesId = (int)$_POST['id_mes'];

        $sql = "INSERT INTO movimentacao (data_movimentacao, tipo_movimentacao, descricao_movimentacao, valor_movimentacao, id_categoria, id_mes ) 
                VALUES ('$data', '$tipo', '$descricao', '$valor', '$categoria', '$mesId')";

        if ($conn->query($sql) === TRUE) {
            header('Location: movimentacao.php?id_mes=' . $mesId);
            exit;
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    }
} elseif ($_GET['acao'] === 'excluir') {
    $id = $_GET['id'];
    $mesId = $_GET['id_mes']; 

    $sql = "DELETE FROM movimentacao WHERE id_movimentacao = $id";
    if ($conn->query($sql)) {
        header('Location: movimentacao.php?id_mes=' . $mesId);
        exit;
    } else {
        echo "Erro ao excluir: " . $conn->error;
    }
}

if ($_POST['acao'] === 'edit') { 
    $idMovimentacao = mysqli_real_escape_string($conn, $_POST['id_movimentacao']);
    $mesId = mysqli_real_escape_string($conn, $_POST['id_mes']);
    $data = mysqli_real_escape_string($conn, $_POST['data_movimentacao']);
    $valor = mysqli_real_escape_string($conn, $_POST['valor_movimentacao']);
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo_movimentacao']);
    $categoria = mysqli_real_escape_string($conn, $_POST['id_categoria']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao_movimentacao']);

    $sqlUpdate = " UPDATE movimentacao SET data_movimentacao = '$data', valor_movimentacao = $valor, tipo_movimentacao = '$tipo',
        id_categoria = $categoria, descricao_movimentacao = '$descricao' WHERE id_movimentacao = $idMovimentacao";

    if ($conn->query($sqlUpdate)) {
        header("Location: movimentacao.php?id_mes=" . $mesId);
        exit;
    } else {
        echo "Erro ao atualizar movimentação: " . $conn->error;
    }
}
