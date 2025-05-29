<?php
    session_start(); 

    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'professor') {
        header("Location: ../index.php"); 
        exit();
    }

    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_unset();
        session_destroy();
        
        echo '<!DOCTYPE html>
              <html>
              <head>
                  <title>Saindo...</title>
                  <meta charset="utf=8">
                  <link rel="stylesheet" href="../css/style.css">
              </head>
              <body class="servicos_forms">
                  <div class="form_container">
                      <p>Você foi desconectado com sucesso!</p>
                      <p>Redirecionando para a HomePage...</p>
                  </div>
                  <script>
                      setTimeout(function() {
                          window.location.href = "../index.php";
                      }, 3000); // Redireciona após 3 segundos (3000 milissegundos)
                  </script>
              </body>
              </html>';
        exit(); 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Servicos</title>
    <meta charset="utf=8">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    </style>
</head>

<body class="servicos_forms">
    <div class="container">
        <div class="sections-wrapper">
            <section class="section">
                <h2>CADASTROS</h2>
                <div class="button-grid">
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-turma/form-turma.php'">Cadastrar Turma</button>
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-disciplina/form-disciplina.php'">Cadastrar Disciplina</button>
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-matricula/form-matricula.php'">Cadastrar Matricula</button>
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-conteudo/form-conteudo.php'">Cadastrar Conteudo</button>
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-prova/form-prova.php'">Cadastrar Prova</button>
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-questoes-prova/form-questoes-prova.php'">Cadastrar Questoes de prova</button>
                    <button onclick="window.location.href='../crud-bd/cadastros/cadastro-respostas/form-respostas.php'">Cadastrar Respostas</button>
                </div>
                
            </section>

            <section class="section">
                <h2>CONSULTAS</h2>
                <div class="button-grid">
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-turma/consulta-turma.php'">Consultar Turma</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-disciplina/consulta-disciplina.php'">Consultar Disciplina</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-matricula/consulta-matricula.php'">Consultar Matricula</button>     
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-conteudo/consulta-conteudo.php'">Consultar Conteudo</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-prova/consulta-prova.php'">Consultar Prova</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-questoes-prova/consulta-questoes-prova.php'">Consultar Questoes de prova</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-respostas/consulta-respostas.php'">Consultar Respostas</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-aluno/consulta-aluno.php'">Consultar Aluno</button>
                    <button onclick="window.location.href='../crud-bd/consultas/consulta-professor/consulta-professor.php'">Consultar Professor</button>
                    
                </div>
            </section>
        </div>
        <div class="home-link">
            <a href="?logout=true">Logout -> HomePage</a>
        </div>


    </div><hr><hr>

    <footer class="servicos">
        <p>Desenvolvido por Juliana e Sander</p>
    </footer>
</body>
</html>