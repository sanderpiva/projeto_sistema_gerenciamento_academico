<?php

session_start();

// Verifica se o usuário está logado e é professor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'professor') {
    header("Location: ../../../index.php");
    exit();
}

// Verifica se o logout foi solicitado
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_unset();
    session_destroy();
    header("Location: ../../../index.php");
    exit();
}


require_once "../conexao.php";

if (isset($_GET['id_resposta']) && !empty($_GET['id_resposta'])) {
    $idRespostaExcluir = $_GET['id_resposta'];

    $stmt = $conexao->prepare("DELETE FROM respostas WHERE id_respostas = :id");
    $stmt->bindParam(':id', $idRespostaExcluir, PDO::PARAM_INT); // Assumindo que id_respostas é um inteiro

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-respostas.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-respostas.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-respostas.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-respostas.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-respostas.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-respostas.php?excluido=id_invalido");
    exit;
}
?>