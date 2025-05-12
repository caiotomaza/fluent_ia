<?php
  require_once __DIR__ . '/../controllers/user_control.php';

  $erro = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'] ?? '';
      $senha = $_POST['senha'] ?? '';

      $userController = new UserController();
      $usuarios = $userController->listarTodos();

      foreach ($usuarios as $usuario) {
          if ($usuario->getEmail() === $email && $usuario->getSenha() === $senha) {
              // Login bem-sucedido
              session_start();
              $_SESSION['usuario_id'] = $usuario->getId();
              $_SESSION['usuario_nome'] = $usuario->getNome();
              header("Location: chat.php"); // redireciona para o painel
              exit;
          }
      }

      $erro = "E-mail ou senha inválidos.";
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="shortcut icon" href="./asset/favicon.ico" type="image/x-icon" />
</head>
<body class="bg-black h-screen flex items-center justify-center text-white">
  <div>
    <img src="./asset/logo.png" alt="Logo Fluent IA" />

    <?php if ($erro): ?>
      <p class="text-red-500 text-center mb-4"><?= $erro ?></p>
    <?php endif; ?>

    <form class="grid text-center" method="POST" action="">
      <input
        type="email"
        name="email"
        required
        placeholder="E-mail"
        class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
      />

      <div class="relative w-full">
        <input
          type="password"
          name="senha"
          required
          placeholder="Senha"
          class="w-full px-4 py-3 pr-12 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
          data-password
        />
        <i
          class="fa-solid fa-eye absolute right-4 top-3.5 text-gray-600 cursor-pointer active:scale-95 transition transform duration-300"
          data-toggle-password
        ></i>
      </div>

      <div class="flex justify-between mb-2">
        <a href="./register.php" class="bg-[#181879] text-white px-6 py-2 rounded-lg font-medium transition transform active:scale-95 hover:brightness-110 hover:scale-105 duration-300">
          Registra-se
        </a>

        <button
          type="submit"
          class="bg-[#181879] text-white px-6 py-2 rounded-lg font-medium transition transform active:scale-95 hover:brightness-110 hover:scale-105 duration-300"
        >
          Entrar
        </button>
      </div>
      <a href="./forgotPassword.php" class="hover:underline transition-all transform duration-300 hover:scale-105 font-medium">
        Esqueci a senha
      </a>
    </form>
  </div>

  <script src="./js/main.js"></script>
</body>
</html>