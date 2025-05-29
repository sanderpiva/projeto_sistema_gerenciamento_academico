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

if (isset($_GET['id_professor']) && !empty($_GET['id_professor'])) {
    $idProfessorExcluir = $_GET['id_professor'];

    $stmt = $conexao->prepare("DELETE FROM professor WHERE id_professor = :id");
    $stmt->bindParam(':id', $idProfessorExcluir, PDO::PARAM_INT); // Assumindo que id_professor é um inteiro

    try {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                header("Location: consulta-professor.php?excluido=sucesso");
                exit;
            } else {
                header("Location: consulta-professor.php?excluido=nenhum");
                exit;
            }
        } else {
            header("Location: consulta-professor.php?excluido=erro");
            exit;
        }
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            header("Location: consulta-professor.php?excluido=dependencia");
            exit;
        } else {
            header("Location: consulta-professor.php?excluido=erro_sql&erro=" . urlencode($e->getMessage()));
            exit;
        }
    }
} else {
    header("Location: consulta-professor.php?excluido=id_invalido");
    exit;
}
?>