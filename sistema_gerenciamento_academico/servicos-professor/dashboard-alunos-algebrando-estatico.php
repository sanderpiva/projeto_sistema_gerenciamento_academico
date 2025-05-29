<?php
session_start();

// Verifica se o usuário está logado e se é um aluno
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'aluno') {
    header("Location: ../index.php"); 
    exit();
}

// Verifica se o logout foi solicitado
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão
    
    echo '<!DOCTYPE html>
          <html>
          <head>
              <title>Saindo...</title>
              <meta charset="utf-8">
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
    exit(); // Garante que nenhum outro conteúdo da página seja renderizado
}

// Função para resetar os status da sessão
function resetStatus() {
    $_SESSION['pa_status'] = 0;
    $_SESSION['pg_status'] = 0;
    $_SESSION['porcentagem_status'] = 0;
    $_SESSION['proporcao_status'] = 0;
}

// INICIALIZAÇÃO DOS STATUS DA SESSÃO SE ELES NÃO EXISTIREM
// Isso garante que as variáveis existam antes de serem lidas, evitando o erro "Undefined index".
if (!isset($_SESSION['pa_status'])) {
    $_SESSION['pa_status'] = 0;
}
if (!isset($_SESSION['pg_status'])) {
    $_SESSION['pg_status'] = 0;
}
if (!isset($_SESSION['porcentagem_status'])) {
    $_SESSION['porcentagem_status'] = 0;
}
if (!isset($_SESSION['proporcao_status'])) {
    $_SESSION['proporcao_status'] = 0;
}

// Se o botão "Fazer Prova" for clicado e todas as atividades forem concluídas
if (isset($_POST['fazer_prova'])) {
    if ($_SESSION['pa_status'] == 1 && $_SESSION['pg_status'] == 1 &&
        $_SESSION['porcentagem_status'] == 1 && $_SESSION['proporcao_status'] == 1) {
        
        resetStatus(); // Zera os status antes de redirecionar para a prova
        header("Location: ../matematica-estatica/prova.php");
        exit();
    }
}

// A parte de resetar os status da sessão ao clicar no botão "Voltar Home Page" será tratada pelo logout via GET
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pagina Web - Atividades/Provas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
    <h1> Atividades/Provas - Algebrando </h1><br>
    <div id="cards-container">
        <div class="card">
            <a href="../matematica-estatica/pa.php">
                <img src="../img/i_pa.png" alt="img1">
            </a>
            <?php
                // Agora, $_SESSION['pa_status'] sempre existirá
                echo $_SESSION['pa_status'] == 1 ? '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">' : "Não visto";
            ?>
        </div>
        <div class="card">
            <a href="../matematica-estatica/pg.php">
                <img src="../img/i_pg.png" alt="img1">
            </a>
            <?php
                echo $_SESSION['pg_status'] == 1 ? '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">' : "Não visto";
            ?>
        </div>
        <div class="card">
            <a href="../matematica-estatica/porcentagem.php">
                <img src="../img/i_porcentagem.png" alt="img1">
            </a>
            <?php
                echo $_SESSION['porcentagem_status'] == 1 ? '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">' : "Não visto";
            ?>
        </div>
        <div class="card">
            <a href="../matematica-estatica/proporcao.php">
                <img src="../img/i_proporcao.png" alt="img1">
            </a>
            <?php
                echo $_SESSION['proporcao_status'] == 1 ? '<img class="check" src="../img/checked1.png" alt="Imagem Status 1">' : "Não visto";
            ?>
        </div>
    </div><br><br><br>

    <div class="btn_prova">
        <?php
            // Agora, estas variáveis sempre terão um valor (0 ou 1)
            if ($_SESSION['pa_status'] == 1 && $_SESSION['pg_status'] == 1 &&
                $_SESSION['porcentagem_status'] == 1 && $_SESSION['proporcao_status'] == 1) {
                // Ao invés de chamar resetStatus() aqui, vamos fazer o botão da prova ser um POST
                // para que a lógica de reset aconteça *antes* do redirecionamento
                echo '<form method="post"><button type="submit" name="fazer_prova" class="btn_prova">Fazer Prova</button></form>';
            } else {
                echo '<button class="btn_prova" onclick="mostrarMensagem()">Fazer Prova</button>';
                echo '<p id="mensagem-erro" style="color: red; display: none;">Você não fez todas as tarefas!</p>';
            }
        ?>
    </div>

    <div class="btn_home">
        <a href="?logout=true" class="btn_home">Logout -> HomePage</a>
    </div>

    <script>
        function mostrarMensagem() {
            document.getElementById('mensagem-erro').style.display = 'block';
        }
    </script>
</body><br><br><br><br><br><br><br><br><br><br><br><br>

<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>
</html>