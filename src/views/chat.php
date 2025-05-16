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

  //Botão de nova conversa
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_chat'])) {
        $user_id = $_SESSION['usuario_id'] ?? null;

        if ($user_id) {
            // Cria uma nova conversa para o usuário logado
            $sucesso = $conversasController->criar($user_id);

            if ($sucesso) {
                // Redireciona para a mesma página ou para a conversa criada, se quiser
                header("Location: chat.php");
                exit;
            } else {
                echo "Erro ao criar nova conversa.";
            }
        } else {
            // Usuário não logado, redirecionar para login
            header("Location: login.php");
            exit;
        }
    }

    /////////////////////////////////////////////////////////////////////// Exibir os chat do usuario.
    function listarChatsUsuario($user_id, $conversasController) {
    // Pega todas as conversas do usuário (se não houver método específico, pega todas e filtra)
    $conversas = $conversasController->listarTodas();

    // Filtrar só as conversas deste usuário
    $conversasUsuario = array_filter($conversas, function($conversa) use ($user_id) {
        return $conversa->getUser_id() == $user_id;
    });

    if (empty($conversasUsuario)) {
        echo "<p class='text-gray-400'>Nenhuma conversa encontrada.</p>";
        return;
    }

    $index = 1;

    foreach ($conversasUsuario as $conversa) {
        $idConversa = $conversa->getId();

        // Pega o nome do chat ou usa nome padrão se estiver vazio
        $nomeChat = $conversa->getNome();
        if (!$nomeChat) {
            $nomeChat = "Chat " . str_pad($index, 2, "0", STR_PAD_LEFT);
        }

        echo <<<HTML
      <button class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300" data-chat-id="{$idConversa}" >
        {$nomeChat}
        <img class="menu-icon cursor-pointer transition transform active:scale-95 hover:scale-110 duration-300" src="./asset/menu.png" alt="Menu" />
      </button>

      <div class="menu-options hidden absolute left-full top-20 ml-10 border border-[#181879] rounded-xl p-2 border border-indigo-900 space-y-2 w-44 z-10 bg-[#181879]/50 backdrop-blur-sm">

        <form method="POST" class="space-y-2">
          <input type="hidden" name="editar_chat_id" value="{$idConversa}" />
          <input
            type="text"
            name="novo_nome"
            placeholder="Novo nome"
            class="w-full px-2 py-1 rounded-md text-black"
            required
          />
          <button
            type="submit"
            class="w-full flex bg-[#181879] items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl"
          >
            <i class="fa-solid fa-pen"></i>
            Salvar
          </button>
        </form>

        <form method="POST" style="margin:0;" onsubmit="return confirm('Deseja realmente excluir este chat?');">
          <input type="hidden" name="excluir_chat_id" value="{$idConversa}" />
          <button type="submit" class="bg-[#181879] w-full flex items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl">
            <i class="fa-solid fa-trash"></i>
            Excluir
          </button>
        </form>
      </div>
      HTML;

        $index++;
     }
    }

    //Função de excluir o chat.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_chat_id'])) {
      $chat_id = (int) $_POST['excluir_chat_id'];
      $conversasController->deletar($chat_id);
      // Redireciona para evitar reenvio de formulário
      header("Location: chat.php");
      exit;
    }

    // Editar nome do chat
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_chat_id'], $_POST['novo_nome'])) {
        $id = (int) $_POST['editar_chat_id'];
        $novoNome = trim($_POST['novo_nome']);
        $conversasController->editarNome($id, $novoNome);
        header("Location: chat.php");
        exit;
    }

    // Excluir o usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
      $usuario = $userController->deletar($_SESSION['usuario_id']);
      session_destroy();
      header("Location: login.php");
      exit;
    }

    // Desconectar o usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['desconectar'])) {
      session_destroy();
      header("Location: login.php");
      exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="shortcut icon" href="./asset/favicon.ico" type="image/x-icon" />
  </head>
  <body class="bg-black text-white h-screen flex">
    <aside
      class="w-80 p-8 flex flex-col justify-between border-r border-[#181879]"
    >
      <div class="space-y-4 relative group"> <!--Botão para criar novo chat-->
        <form method="POST" action="chat.php" class="mb-7">
          <button type="submit" name="novo_chat" class="w-full text-2xl bg-[#181879] hover:bg-indigo-800 py-5 rounded-md hover:brightness-110 transition mb-7 duration-300">
            Novo chat
          </button>
        </form>

        <div class="space-y-4 relative group">  <!--Exibi os chat do usuario-->
          <?php
            $user_id = $_SESSION['usuario_id'] ?? null;
            if ($user_id) {
                listarChatsUsuario($user_id, $conversasController);
            } else {
                echo "<p>Usuário não logado.</p>";
            }
          ?>
        </div>

      <div class="mt-4 relative">
        <button class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300">
          <?= htmlspecialchars($usuario->getNome()) ?>
          <img class="menu-user cursor-pointer transition transform active:scale-95 hover:scale-110 duration-300" src="./asset/menu.png" alt=""/>
        </button>

        <div
          class="menu-options_user hidden absolute left-full bottom-0 ml-10 border border-[#181879] rounded-xl p-2 border-indigo-900 space-y-2 w-44 z-10 bg-[#181879]/50 backdrop-blur-sm"
        >
          <form method="POST" action="chat.php" name="excluir">
            <input type="hidden" name="excluir" value="1" />
            <button type="submit" class="bg-[#181879] w-full flex items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl">
              <i class="fa-solid fa-trash"></i>
              Excluir
            </button>
          </form>
          <form method="POST" action="chat.php" name="desconectar">
            <input type="hidden" name="desconectar" value="1" />
            <button type="submit" class="w-full flex bg-[#181879] items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl">
              <i class="fa-solid fa-right-from-bracket"></i>
              Desconectar
            </button>
          </form>
        </div>
      </div>
    </aside>

    <main class="flex-1 flex flex-col justify-end p-4">
      <div class="mt-auto"></div>

      <form class="flex items-center space-x-2 mt-4">
        <input
          type="text"
          placeholder="Digite sua mensagem..."
          class="flex-1 px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none"
        />
        <button
          type="submit"
          class="bg-[#181879] text-white p-3 rounded-lg hover:scale-105 transition"
        >
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </form>
    </main>

    <script src="./js/main.js"></script>
  </body>
</html>
