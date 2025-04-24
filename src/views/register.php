<!-- Exemplo para index.html -->
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="shortcut icon" href="./asset/favicon.ico" type="image/x-icon" />
  </head>
  <body class="bg-black h-screen flex items-center justify-center text-white">
    <div>
      <img src="./asset/logo.png" alt="Logo Fluent IA" />

      <form class="grid text-center" action="">
        <input
          type="text"
          placeholder="Nome"
          class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
        />

        <input
          type="email"
          placeholder="E-mail"
          class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4"
        />

        <div class="relative w-full">
          <input
            type="password"
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
