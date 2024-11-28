<?php
session_start();
require_once('../conexao.php');

if (isset($_POST['create-mes'])) {
    $nome_mes = trim($_POST['txtnome_mes']);
    $ano_mes = trim($_POST['txtano_mes']);

    $sql = "INSERT INTO mes (nome_mes, ano_mes) VALUES ('$nome_mes', '$ano_mes')";

    mysqli_query($conn, $sql);
    
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['delete_mes'])){
    $mesId = mysqli_real_escape_string($conn, $_POST['delete_mes']);
    $sql = "DELETE FROM mes WHERE id_mes = '$mesId'";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['message'] = "Mês com ID {$mesId} excluido com sucesso!";
        $_SESSION['type'] = 'success';
    } else {
        $_SESSION['message'] = "Ops! Não foi possível excluir o mês";
        $_SESSION['type'] = 'error';
    }

    header('Location: ../index.php');
    exit;
}

if (isset($_POST['edit_mes'])) {
    $mesId = mysqli_real_escape_string($conn, $_POST['mes_id']); 
    $nome = mysqli_real_escape_string($conn, $_POST['nome_mes']);
    $ano = intval($_POST['ano_mes']);

    $sql = "UPDATE mes SET nome_mes = '{$nome}', ano_mes = '{$ano}' WHERE id_mes = '{$mesId}'";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['message'] = "Mês {$mesId} atualizado com sucesso!";
        $_SESSION['type'] = 'success'; 
    } else {
        $_SESSION['message'] = "Não foi possível atualizar o mês {$mesId}.";
        $_SESSION['type'] = 'error';
    }

    header("Location: ../index.php");   
    exit;
}
?>