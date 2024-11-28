<?php
session_start();
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {
        $nome = $_POST['nome_categoria'];
        $descricao = $_POST['descricao_categoria'];

        $sql = "INSERT INTO categoria (nome_categoria, descricao_categoria) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nome, $descricao);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Categoria cadastrada!";
            $_SESSION['type'] = 'success';
        } else {
            $_SESSION['message'] = "Erro ao cadastrar categoria";
            $_SESSION['type'] = 'error';
        }

        $stmt->close();
        header('Location: categoria-create.php');
        exit;
    }
}

if (isset ($_GET['acao']) && $_GET['acao'] === 'excluir') {
    $id = $_GET['id'];

    $sql = "DELETE FROM categoria WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Categoria {$nome} excluída com sucesso!";
        $_SESSION['type'] = 'success';
    } else {
        $_SESSION['message'] = "Erro ao excluir categoria {$nome}";
        $_SESSION['type'] = 'error';
    }

    $stmt->close();
    header('Location: categoria-create.php');
    exit;
}

if ($acao === 'editar') {
    $id = (int)$_POST['id_categoria'];
    $nome = mysqli_real_escape_string($conn, $_POST['nome_categoria']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao_categoria']);

    $sql = "UPDATE categoria SET nome_categoria = '$nome', descricao_categoria = '$descricao' WHERE id_categoria = $id";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Categoria {$nome} atualizada com sucesso!";
        $_SESSION['type'] = 'success';
    } else {
        $_SESSION['message'] = "Não foi possível atualizar a categoria.";
        $_SESSION['type'] = "error";
    }

    header("Location: categoria-create.php");
    exit;
}

?>