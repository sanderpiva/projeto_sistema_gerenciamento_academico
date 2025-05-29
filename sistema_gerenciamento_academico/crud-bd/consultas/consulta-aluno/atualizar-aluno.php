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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_aluno = $_POST['id_aluno'];
    $matricula = $_POST['matricula'];
    $nomeAluno = $_POST['nomeAluno'];
    $cpf = $_POST['cpf'];
    $emailAluno = $_POST['emailAluno'];
    $data_nascimento = $_POST['data_nascimento'];
    $enderecoAluno = $_POST['enderecoAluno'];
    $cidadeAluno = $_POST['cidadeAluno'];
    $telefoneAluno = $_POST['telefoneAluno'];
    $id_turma = $_POST['id_turma'];

    $stmt = $conexao->prepare("UPDATE aluno SET
        matricula = :matricula,
        nome = :nome,
        cpf = :cpf,
        email = :email,
        data_nascimento = :data_nascimento,
        endereco = :endereco,
        cidade = :cidade,
        telefone = :telefone,
        Turma_id_turma = :id_turma
        WHERE id_aluno = :id");

    $stmt->execute([
        ':matricula' => $matricula,
        ':nome' => $nomeAluno,
        ':cpf' => $cpf,
        ':email' => $emailAluno,
        ':data_nascimento' => $data_nascimento,
        ':endereco' => $enderecoAluno,
        ':cidade' => $cidadeAluno,
        ':telefone' => $telefoneAluno,
        ':id_turma' => $id_turma,
        ':id' => $id_aluno
    ]);

    header("Location: ../../consultas/consulta-aluno/consulta-aluno.php?atualizado=sucesso");
    exit;
}
?>
