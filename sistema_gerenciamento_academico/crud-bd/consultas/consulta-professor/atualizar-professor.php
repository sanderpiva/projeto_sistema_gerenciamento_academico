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



require_once '../conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_professor'])) {

    $id_professor = $_POST['id_professor'];
    $registroProfessor = $_POST['registroProfessor'];
    $nomeProfessor = $_POST['nomeProfessor'];
    $emailProfessor = $_POST['emailProfessor'];
    $enderecoProfessor = $_POST['enderecoProfessor'];
    $telefoneProfessor = $_POST['telefoneProfessor'];

    $stmt = $conexao->prepare("UPDATE professor SET
                                registroProfessor = :registro,
                                nome = :nome,
                                email = :email,
                                endereco = :endereco,
                                telefone = :telefone
                                WHERE id_professor = :id");

    $stmt->execute([
        ':registro' => $registroProfessor,
        ':nome' => $nomeProfessor,
        ':email' => $emailProfessor,
        ':endereco' => $enderecoProfessor,
        ':telefone' => $telefoneProfessor,
        ':id' => $id_professor
    ]);

    if ($stmt->rowCount() > 0) {
        $message = "Professor com id " . htmlspecialchars($id_professor) . " atualizado com sucesso!";
        header("Location: consulta-professor.php?message=" . urlencode($message));
        exit(); 
    } else {
        $error = "Erro ao atualizar professor.";
        //'../../cadastros/cadastro-professor/form-professor.php';
        $pathToForm = '../../../login/cadastro-professor.php';
        header("Location: " . $pathToForm . "?id_professor=" . urlencode($id_professor) . "&erros=" . urlencode($error));
        exit(); 
    }

} else {
    $error = "Requisição inválida para atualização de professor.";
    header("Location: consulta-professor.php?erros=" . urlencode($error));
    exit();
}
?>