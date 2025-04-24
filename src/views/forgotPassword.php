<!-- Exemplo para index.html -->
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
  </head>
  <body class="bg-black h-screen flex items-center justify-center text-white">
    <div>
      <img src="../img/logo.png" alt="Logo Fluent IA" />

      <form action="">
        <input
          type="email"
          placeholder="E-mail"
          class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <div class="flex justify-between mt-6">
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
            Enviar
          </button>
        </div>
      </form>
    </div>

    <script src="js/main.js"></script>
  </body>
</html>
