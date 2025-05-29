<?php
    session_start(); // Inicia a sessão

    // Verifica se o usuário está logado e se é um professor
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['tipo_usuario'] !== 'professor') {
        header("Location: ../index.php"); // Redireciona para a página inicial/login
        exit();
    }

    // Verifica se o logout foi solicitado
    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_unset(); // Remove todas as variáveis de sessão
        session_destroy(); // Destrói a sessão

        // HTML e JavaScript para exibir a mensagem de logout e redirecionar
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
                      }, 3000); // Redireciona após 3 segundos
                  </script>
              </body>
              </html>';
        exit(); // Garante que nenhum outro conteúdo seja renderizado
    }
?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <title>Mostrar Tabela com Registros de Prova</title>
  </head>
  <body>

    <div class="table_container">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Q1</th>
            <th>Q2</th>
            <th>Q3</th>
            <th>Q4</th>
            <th>Média</th>
            <th>Turma</th>
          </tr>
        </thead>
        <tbody>
        <?php
        // Inclui o arquivo de conexão PDO.
        // Certifique-se de que o caminho está correto para o seu arquivo conexaoDados.php
        require_once "../servicos-professor/conexaoDados.php"; // Ajuste este caminho se necessário

        try {
            // Prepara a consulta SQL para selecionar todos os registros da tabeladados
            $sql = "SELECT * FROM tabeladados";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();

            // Recupera todos os resultados
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Conta o número de registros
            $num_registros = count($registros);

            echo "<caption>Registros encontrados: " . $num_registros . "</caption>";

            // Itera sobre os resultados e exibe cada linha na tabela
            if ($num_registros > 0) {
                foreach ($registros as $reg) {
                    echo "<tr>";
                    // htmlspecialchars para evitar ataques XSS ao exibir dados do DB
                    echo "<td>" . htmlspecialchars($reg['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q1']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q2']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q3']) . "</td>";
                    echo "<td>" . htmlspecialchars($reg['q4']) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($reg['nota'], 1)) . "</td>"; // Formata a média para 1 casa decimal
                    echo "<td>" . htmlspecialchars($reg['turma']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Nenhum registro encontrado.</td></tr>";
            }

        } catch (PDOException $e) {
            // Em caso de erro na conexão ou consulta
            echo "<tr><td colspan='8' style='color:red;'>Erro ao carregar dados: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

    <br><br><br>
    <a href="?logout=true"><em>Logout -> HomePage</em></a>

  </body>
</html>