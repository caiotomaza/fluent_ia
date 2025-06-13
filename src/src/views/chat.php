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
        // Verifica se foi enviado um chat para seleção
        if (isset($_POST['selecionar_chat_id'])) {
            $_SESSION['conversas_id'] = $_POST['selecionar_chat_id'];
        }

        // Lista todas as conversas
        $conversas = $conversasController->listarTodas();

        // Filtrar só as do usuário atual
        $conversasUsuario = array_filter($conversas, function($conversa) use ($user_id) {
            return $conversa->getUser_id() == $user_id;
        });

        if (empty($conversasUsuario)) {
            echo "<p class='text-gray-400'>Nenhuma conversa encontrada.</p>";
            return;
        }

        // Organiza mais recente embaixo
        $conversasUsuario = array_reverse($conversasUsuario);
        $index = count($conversasUsuario);

        foreach ($conversasUsuario as $conversa) {
            $idConversa = $conversa->getId();

            // Pega o nome do chat ou gera um nome padrão
            $nomeChat = $conversa->getNome();
            if (!$nomeChat) {
                $nomeChat = "Chat " . str_pad($index, 2, "0", STR_PAD_LEFT);
            }

            // Verifica se é o chat atualmente selecionado
            $selecionado = (isset($_SESSION['conversas_id']) && $_SESSION['conversas_id'] == $idConversa);

            $classeSelecionado = $selecionado ? 'bg-indigo-800' : 'bg-[#181879]';

            echo <<<HTML
            <div class="relative chat-container group">
                <div class="flex items-center w-full">
                    <form method="POST" style="margin:0; flex-grow: 1;">
                        <input type="hidden" name="selecionar_chat_id" value="{$idConversa}" />
                        <button type="submit" class="w-full {$classeSelecionado} py-3 rounded-md flex justify-between text-2xl items-center px-4 hover:brightness-110 transition duration-300">
                            <span class="truncate">{$nomeChat}</span>
                        </button>
                    </form>
                    <button class="menu-icon p-2 ml-2 hover:bg-indigo-700 rounded-full transition duration-300">
                        <img src="./asset/menu.png" alt="Menu" class="w-6 h-6" />
                    </button>
                </div>

                <div class="menu-options hidden fixed ml-2 border border-[#181879] rounded-xl p-2 border-indigo-900 space-y-4 w-44 z-50 bg-[#181879]/50 backdrop-blur-sm" style="left: 19rem; transform: translateY(-50%);">
                    <form method="POST" class="space-y-2" onclick="event.stopPropagation();">
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
                        <button type="submit" class="mt-2 bg-red-600 w-full flex items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl">
                            <i class="fa-solid fa-trash"></i>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
            HTML;

            $index--;
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

    // Salavar memssagen do usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])){
      $conversas_id = $_SESSION['conversas_id'];
      $remetente_id = $_SESSION['usuario_id'];
      $message = trim($_POST['mensagem']);
      $mensagensController->enviar($conversas_id, $remetente_id, $message);
    }

  function exibirMensagens($conversas_id, $mensagensController) {
      if (!$conversas_id) {
          echo "<p class='text-gray-400'>Nenhuma conversa selecionada.</p>";
          return;
      }

      // Busca mensagens da conversa atual
      $mensagens = $mensagensController->BuscarMenssagen($conversas_id);

      if (empty($mensagens)) {
          echo "<p class='text-gray-400'>Nenhuma mensagem nesta conversa.</p>";
          return;
      }

      // Exibir as mensagens em ordem (mais antigas primeiro)
      foreach ($mensagens as $mensagem) {
          $id = htmlspecialchars($mensagem->getRemetente_id());
          $texto = htmlspecialchars($mensagem->getMessage());
          $data = htmlspecialchars($mensagem->getData_hora());

          $userController = new UserController();
          $nomeRemetente = htmlspecialchars($userController->buscarNomePorId($id));

          // Se o nome for nulo ou vazio, define como "IA"
          if (empty($nomeRemetente)) {
              $nomeRemetente = "Fluent_IA";
              $messageClass = "bg-indigo-900"; // Cor para mensagens da IA
          } else {
              $nomeRemetente = htmlspecialchars($nomeRemetente);
              $messageClass = "bg-blue-700"; // Cor para mensagens do usuário
          }

          echo <<<HTML
          <div class="{$messageClass} text-white p-3 rounded-xl mb-2">
              <div class="flex justify-between text-sm text-gray-300 mb-1">
                  <span>{$nomeRemetente}</span>
                  <span>{$data}</span>
              </div>
              <div class="text-lg">{$texto}</div>
          </div>
          HTML;
      }
  }

  $_SESSION['metodo_ia'] = 1;

  //Função de selecionar o metodos da IA
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['melhorar'])) {
    $_SESSION['metodo_ia'] = 1;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simplificar'])) {
    $_SESSION['metodo_ia'] = 2;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['traduzir'])) {
    $_SESSION['metodo_ia'] = 3;
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
  <body class="bg-black text-white h-screen flex overflow-x-hidden">
    <aside class="w-80 p-8 flex flex-col justify-between border-r border-[#181879] relative">
      <!-- Seção de chats -->
      <div class="flex-1 flex flex-col min-h-0">
        <form method="POST" action="chat.php" class="mb-7">
          <button type="submit" name="novo_chat" class="w-full text-2xl bg-[#181879] hover:bg-indigo-800 py-5 rounded-md hover:brightness-110 transition duration-300">
            Novo chat
          </button>
        </form>

        <div class="flex-1 overflow-y-auto">
          <div class="space-y-4">
            <?php
              $user_id = $_SESSION['usuario_id'] ?? null;
              if ($user_id) {
                  listarChatsUsuario($user_id, $conversasController);
              } else {
                  echo "<p>Usuário não logado.</p>";
              }
            ?>
          </div>
        </div>
      </div>

      <!-- Seção do perfil (fixo na parte inferior) -->
      <div class="mt-auto pt-4 border-t border-[#181879]">
        <div id="profile-container" class="relative">
          <button id="profile-button" class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300">
            <span><?= htmlspecialchars($usuario->getNome()) ?></span>
            <img id="menu-trigger" class="menu-user cursor-pointer transition transform active:scale-95 hover:scale-110 duration-300" src="./asset/menu.png" alt="Menu"/>
          </button>

          <!-- Pop-up do perfil -->
          <div id="profile-menu" class="menu-options_user hidden fixed border border-[#181879] rounded-xl p-2 border-indigo-900 w-44 bg-[#181879] shadow-lg" style="z-index: 99999; bottom: 100%; margin-bottom: 8px;">
            <form method="POST" action="chat.php" name="excluir" class="mb-2">
              <input type="hidden" name="excluir" value="1" />
              <button type="submit" onclick="return confirm('Tem certeza que deseja excluir sua conta?')" class="bg-red-600 w-full flex items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl hover:bg-red-800">
                <i class="fa-solid fa-trash"></i>
                Excluir
              </button>
            </form>

            <form method="POST" action="chat.php" name="desconectar">
              <input type="hidden" name="desconectar" value="1" />
              <button type="submit" class="w-full flex bg-[#181879] items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl hover:bg-indigo-800">
                <i class="fa-solid fa-right-from-bracket"></i>
                Desconectar
              </button>
            </form>
          </div>
        </div>
      </div>
    </aside>

    <main class="flex-1 flex flex-col p-4 relative">
      <!-- Área de mensagens -->
      <div class="flex-1 overflow-y-auto flex flex-col gap-4 mb-4">
        <?php if (isset($_SESSION['conversas_id'])) { ?>
          <?php exibirMensagens($_SESSION['conversas_id'], $mensagensController);?>
        <?php } else { ?>
          <?php echo "<p class='text-center text-gray-400'>Nenhuma conversa selecionada.</p>"; ?>
        <?php } ?>
      </div>

      <!-- Área de mensagens pré-definidas -->
      <div class="flex gap-2 mb-4">
        <form method="POST" action="chat.php" name="melhorar">
          <button type="submit" name="melhorar" class="quick-action bg-[#181879] text-white px-4 py-2 rounded-lg hover:brightness-110 transition <?= $_SESSION['metodo_ia'] == 1 ? 'ring-2 ring-white bg-indigo-700' : '' ?>">
            <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>Melhorar
          </button>
        </form>
        <form method="POST" action="chat.php" name="simplificar">
          <button type="submit" name="simplificar" class="quick-action bg-[#181879] text-white px-4 py-2 rounded-lg hover:brightness-110 transition <?= $_SESSION['metodo_ia'] == 2 ? 'ring-2 ring-white bg-indigo-700' : '' ?>">
            <i class="fa-solid fa-scissors mr-2"></i>Simplificar
          </button>
        </form>
        <form method="POST" action="chat.php" name="traduzir">
          <button type="submit" name="traduzir" class="quick-action bg-[#181879] text-white px-4 py-2 rounded-lg hover:brightness-110 transition <?= $_SESSION['metodo_ia'] == 3 ? 'ring-2 ring-white bg-indigo-700' : '' ?>">
            <i class="fa-solid fa-language mr-2"></i>Traduzir
          </button>
        </form>
      </div>

      
      <!-- Formulário de envio -->
      <form class="flex items-center space-x-2" method="POST" action="index.php">
        <input type="hidden" name="conversas_id" value="<?= $conversaSelecionadaId ?>">
        <input
          type="text"
          name="mensagem"
          id="mensagem"
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
    </main>

    <script src="./js/main.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.getElementById('profile-button');
        const menuTrigger = document.getElementById('menu-trigger');
        const profileMenu = document.getElementById('profile-menu');
        let isMenuOpen = false;

        function positionMenu() {
          const triggerRect = menuTrigger.getBoundingClientRect();
          const menuWidth = profileMenu.offsetWidth;
          
          profileMenu.style.left = (triggerRect.right - menuWidth + 20) + 'px';
          profileMenu.style.bottom = (window.innerHeight - triggerRect.top + 8) + 'px';
        }

        function toggleMenu(event) {
          if (event) {
            event.stopPropagation();
            event.preventDefault();
          }

          isMenuOpen = !isMenuOpen;
          
          if (isMenuOpen) {
            profileMenu.classList.remove('hidden');
            requestAnimationFrame(positionMenu);
          } else {
            profileMenu.classList.add('hidden');
          }
        }

        // Previne o botão principal de submeter o formulário
        profileButton.addEventListener('click', function(e) {
          e.preventDefault();
        });

        // Toggle do menu ao clicar no ícone
        menuTrigger.addEventListener('click', toggleMenu);

        // Fecha o menu ao clicar fora
        document.addEventListener('click', function(e) {
          if (isMenuOpen && !menuTrigger.contains(e.target) && !profileMenu.contains(e.target)) {
            toggleMenu();
          }
        });

        // Reposiciona o menu ao redimensionar a janela
        window.addEventListener('resize', function() {
          if (isMenuOpen) {
            positionMenu();
          }
        });

        // Reposiciona o menu durante o scroll
        document.addEventListener('scroll', function() {
          if (isMenuOpen) {
            positionMenu();
          }
        }, true);

        // Adiciona o comportamento do menu de chat
        document.querySelectorAll('.chat-container').forEach(container => {
            const menuIcon = container.querySelector('.menu-icon');
            const menuOptions = container.querySelector('.menu-options');
            let isMenuOpen = false;

            menuIcon.addEventListener('click', (e) => {
                e.stopPropagation();
                
                // Fecha todos os outros menus primeiro
                document.querySelectorAll('.menu-options').forEach(menu => {
                    if (menu !== menuOptions) {
                        menu.classList.add('hidden');
                    }
                });

                isMenuOpen = !isMenuOpen;
                if (isMenuOpen) {
                    menuOptions.classList.remove('hidden');
                    
                    // Posiciona o menu
                    const rect = menuIcon.getBoundingClientRect();
                    menuOptions.style.top = `${rect.top}px`;
                    menuOptions.style.left = `${rect.right + 10}px`;
                } else {
                    menuOptions.classList.add('hidden');
                }
            });

            // Previne que o menu feche quando clicar dentro dele
            menuOptions?.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });

        // Fecha os menus ao clicar fora
        document.addEventListener('click', () => {
            document.querySelectorAll('.menu-options').forEach(menu => {
                menu.classList.add('hidden');
            });
        });
      });
    </script>
  </body>
</html>
