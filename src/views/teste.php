<?php
  require_once __DIR__ . '/../controllers/user_control.php';
  require_once __DIR__ . '/../controllers/mensagens_control.php';
  require_once __DIR__ . '/../controllers/conversas_control.php';

  session_start();
  // Verifica se o usuário está logado

  if (!isset($_SESSION['usuario_id'])) {
      header('Location: login.php');
      exit();
  }

  $userController = new UserController();
  $conversasController = new ConversasController();
  $mensagensController = new MensagensController();

  // Busca o usuário logado
  $usuario = $userController->buscarPorId($_SESSION['usuario_id']);

  // Busca todas as conversas
  $conversas = $conversasController->listarTodas();

  // Conversa atual
  $conversaSelecionadaId = $_GET['id'] ?? null;
  $mensagens = $conversaSelecionadaId ? $mensagensController->buscarPorConversa($conversaSelecionadaId) : [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/150b5c1df7.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gradient-to-r from-[#6a11cb] to-[#2575fc] text-white">
  <main class="min-h-screen flex">
    <!-- Lado esquerdo -->
    <aside class="w-1/4 bg-[#0f0f4b] p-4 flex flex-col gap-4">
      <h2 class="text-2xl font-bold">Olá, <?= htmlspecialchars($usuario->getNome()) ?></h2>

      <!-- Lista de conversas -->
      <div class="flex flex-col gap-2">
        <?php foreach ($conversas as $conversa): ?>
          <button
            class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-lg items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300 <?= $conversa->getId() == $conversaSelecionadaId ? 'border border-white' : '' ?>"
            onclick="window.location.href='chat.php?id=<?= $conversa->getId() ?>'"
          >
            Chat <?= $conversa->getId() ?>
            <img class="menu-icon w-5" src="./asset/menu.png" alt="Menu" />
          </button>
        <?php endforeach; ?>
      </div>
    </aside>

    <!-- Lado direito -->
    <section class="w-3/4 flex flex-col p-4">
      <header class="flex justify-between items-center border-b border-white pb-2 mb-4">
        <h1 class="text-3xl font-semibold">Chat <?= $conversaSelecionadaId ?? 'Selecionado' ?></h1>
      </header>

      <!-- Mensagens -->
      <div class="flex-1 overflow-y-auto flex flex-col gap-2 mb-4">
        <?php if (empty($mensagens)): ?>
          <p class="text-center text-gray-300">Nenhuma mensagem ainda.</p>
        <?php else: ?>
          <?php foreach ($mensagens as $mensagem): ?>
            <div class="bg-[#181879] p-3 rounded-md">
              <p><strong>Usuário <?= $mensagem->getRemetente_id() ?>:</strong> <?= htmlspecialchars($mensagem->getConteudo()) ?></p>
              <span class="text-sm text-gray-400"><?= $mensagem->getData_hora() ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Formulário de envio -->
      <?php if ($conversaSelecionadaId): ?>
        <form action="enviar_mensagem.php" method="POST" class="flex items-center space-x-2">
          <input type="hidden" name="conversas_id" value="<?= $conversaSelecionadaId ?>">
          <input
            type="text"
            name="mensagem"
            placeholder="Digite sua mensagem..."
            class="flex-1 px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none"
            required
          />
          <button
            type="submit"
            class="bg-[#181879] text-white p-3 rounded-lg hover:scale-105 transition"
          >
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>