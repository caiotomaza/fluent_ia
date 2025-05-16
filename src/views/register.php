<?php
  require_once __DIR__ . '/../controllers/user_control.php';

  $mensagem = "";

  // Verifica se o formulário foi enviado
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nome = $_POST['nome'] ?? '';
      $email = $_POST['email'] ?? '';
      $senha = $_POST['senha'] ?? '';

      // Você pode adicionar validações aqui

      $userController = new UserController();
      $sucesso = $userController->criar($nome, $email, $senha);
      
      if ($sucesso) {
      session_start();

      // Buscar usuário recém-criado
      $usuario = $userController->buscarPorEmail($email);

      if ($usuario) {
          $_SESSION['usuario_id'] = $usuario->getId();
          $_SESSION['usuario_nome'] = $usuario->getNome();
          header("Location: chat.php");
          exit;
      } else {
          $mensagem = "Usuário criado, mas não foi possível iniciar a sessão.";
      }
  }
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="shortcut icon" href="./asset/favicon.ico" type="image/x-icon" />
</head>
<body class="bg-black h-screen flex items-center justify-center text-white">
  <div>
    <img src="./asset/logo.png" alt="Logo Fluent IA" />

    <?php if (!empty($mensagem)): ?>
      <p class="text-center mb-4 text-green-400"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form class="grid text-center" method="POST" action="">
      <input
        type="text"
        name="nome"
        placeholder="Nome"
        required
        class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
      />

      <input
        type="email"
        name="email"
        placeholder="E-mail"
        required
        class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
      />

      <div class="relative w-full">
        <input
          type="password"
          name="senha"
          placeholder="Senha"
          required
          class="w-full px-4 py-3 pr-12 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
          data-password
        />
        <i
          class="fa-solid fa-eye absolute right-4 top-3.5 text-gray-600 cursor-pointer active:scale-95 transition transform duration-300"
          data-toggle-password
        ></i>
      </div>

      <div class="flex justify-between mb-2">
        <button
          type="button"
          onclick="history.back()"
          class="bg-[#181879] text-white px-6 py-2 rounded-lg font-medium transition transform active:scale-95 hover:brightness-110 hover:scale-105 duration-300"
        >
          Voltar
        </button>

        <button
          type="submit"
          class="bg-[#181879] text-white px-6 py-2 rounded-lg font-medium transition transform active:scale-95 hover:brightness-110 hover:scale-105 duration-300"
        >
          Registra-se
        </button>
      </div>
    </form>
  </div>

  <script src="./js/main.js"></script>
</body>
</html>