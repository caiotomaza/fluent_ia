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
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
  </head>
  <body class="bg-black text-white h-screen flex">
    <aside
      class="w-80 p-8 flex flex-col justify-between border-r border-[#181879]"
    >
      <div class="space-y-4 relative group">
        <button
          class="w-full text-2xl bg-[#181879] hover:bg-indigo-800 py-5 rounded-md hover:brightness-110 transition mb-7 duration-300"
        >
          Novo chat
        </button>

        <!-- 
          Aqui temos a estrutura de três chats. 
          Por enquanto só o Chat 01 tem o menu de opções (Editar nome / Excluir), 
          pois como ainda está tudo estático, só estilizei para idealizar como ficará. 

          Quando for deixar dinâmico, cada chat vai precisar ter seu próprio menu 
          para abrir as opções individualmente (tipo um dropdown por chat).
        -->

        <button
          class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl flex items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300"
        >
          Chat 01
          <img
            class="menu-icon cursor-pointer transition transform active:scale-95 hover:scale-110 duration-300"
            src="../img/menu.png"
            alt="Menu"
          />
        </button>

        <div
          class="menu-options hidden absolute left-full top-20 ml-10 border border-[#181879] rounded-xl p-2 border border-indigo-900 space-y-2 w-44 z-10 bg-[#181879]/50 backdrop-blur-sm"
        >
          <button
            class="w-full flex bg-[#181879] items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl"
          >
            <i class="fa-solid fa-pen"></i>
            Editar nome
          </button>
          <button
            class="bg-[#181879] w-full flex items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl"
          >
            <i class="fa-solid fa-trash"></i>
            Excluir
          </button>
        </div>

        <button
          class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl flex items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300"
        >
          Chat 02
          <img
            class="transition transform active:scale-95 hover:scale-110 duration-300"
            src="../img/menu.png"
            alt=""
          />
        </button>
        <button
          class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl flex items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300"
        >
          Chat 03
          <img
            class="transition transform active:scale-95 hover:scale-110 duration-300"
            src="../img/menu.png"
            alt=""
          />
        </button>
      </div>

      <!-- 
        Menu de usuário já estilizado com Tailwind, com opções de "Excluir" e "Desconectar". 
        Por enquanto é só visual, ainda não tem nenhuma função ligada nesses botões.

        Quando for integrar com o back-end, vai precisar adicionar os eventos JS pra chamar 
        as funções certas (tipo deslogar o usuário ou excluir a conta).
      -->

      <div class="mt-4 relative">
        <button
          class="w-full bg-[#181879] py-3 rounded-md flex justify-between text-2xl flex items-center px-4 hover:brightness-110 transition hover:bg-indigo-800 duration-300"
        >
          Nome do usuário
          <img
            class="menu-user cursor-pointer transition transform active:scale-95 hover:scale-110 duration-300"
            src="../img/menu.png"
            alt=""
          />
        </button>

        <div
          class="menu-options_user hidden absolute left-full bottom-0 ml-10 border border-[#181879] rounded-xl p-2 border border-indigo-900 space-y-2 w-44 z-10 bg-[#181879]/50 backdrop-blur-sm"
        >
          <button
            class="bg-[#181879] w-full flex items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl"
          >
            <i class="fa-solid fa-trash"></i>
            Excluir
          </button>
          <button
            class="w-full flex bg-[#181879] items-center gap-2 text-white hover:brightness-110 px-4 py-2 rounded-xl"
          >
            <i class="fa-solid fa-right-from-bracket"></i>
            desconectar
          </button>
        </div>
      </div>
    </aside>

    <main class="flex-1 flex flex-col justify-end p-4">
      <!-- Aqui iriam as mensagens do chat no futuro -->
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

    <script src="../js/main.js"></script>
  </body>
</html>
