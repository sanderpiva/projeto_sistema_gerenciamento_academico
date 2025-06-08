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


require_once '../conexao.php'; // Inclui o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_turma'])) {

    $id_turma = $_POST['id_turma'];
    $codigoTurma = $_POST['codigoTurma'];
    $nomeTurma = $_POST['nomeTurma'];

    $stmt = $conexao->prepare("UPDATE turma SET
                                codigoTurma = :codigoTurma,
                                nomeTurma = :nomeTurma
                                WHERE id_turma = :id_turma");

    $stmt->execute([
        ':codigoTurma' => $codigoTurma,
        ':nomeTurma' => $nomeTurma,
        ':id_turma' => $id_turma
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Turma com código " . htmlspecialchars($codigoTurma) . " atualizada com sucesso!";
        header("Location: consulta-turma.php?message=" . urlencode($message));
        exit(); 
    } else {
        
        $errorInfo = $stmt->errorInfo();
        $error = "Erro ao atualizar turma: " . (isset($errorInfo[2]) ? $errorInfo[2] : 'Erro desconhecido');

        $pathToForm = '../../cadastros/cadastro-turma/form-turma.php';

        header("Location: " . $pathToForm . "?id_turma=" . urlencode($_POST['id_turma']) . "&erros=" . urlencode($error));
        exit(); 
    }

} else {
    
    $error = "Requisição inválida para atualização de turma.";
    
    header("Location: consulta-turma.php?erros=" . urlencode($error));
    exit();
}
?>