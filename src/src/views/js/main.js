document.addEventListener("DOMContentLoaded", function () {
  const toggles = document.querySelectorAll("[data-toggle-password]");

  toggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const input = toggle.previousElementSibling;
      const isPassword = input.type === "password";

      input.type = isPassword ? "text" : "password";
      toggle.classList.toggle("fa-eye");
      toggle.classList.toggle("fa-eye-slash");
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  // Gerenciamento dos menus de chat
  const icons = document.querySelectorAll(".menu-icon");
  let activeMenu = null;
  let isEditing = false;

  icons.forEach((icon) => {
    icon.addEventListener("click", (e) => {
      e.stopPropagation();
      const parent = icon.closest(".chat-container");
      const menu = parent.querySelector(".menu-options");

      // Se estiver editando, não fecha o menu
      if (isEditing && menu === activeMenu) {
        return;
      }

      // Esconde todos os outros menus
      document.querySelectorAll(".menu-options").forEach((m) => {
        if (m !== menu) m.classList.add("hidden");
      });

      // Alterna o menu clicado
      menu.classList.toggle("hidden");
      activeMenu = menu.classList.contains("hidden") ? null : menu;
    });
  });

  // Gerenciamento do formulário de edição
  document.querySelectorAll(".menu-options form").forEach((form) => {
    const input = form.querySelector('input[type="text"]');
    
    if (input) {
      input.addEventListener("focus", () => {
        isEditing = true;
      });

      input.addEventListener("blur", () => {
        setTimeout(() => {
          isEditing = false;
        }, 200);
      });
    }
  });

  // Previne o fechamento do menu ao clicar dentro dele
  document.querySelectorAll(".menu-options").forEach((menu) => {
    menu.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  });

  // Fecha o menu se clicar fora (apenas se não estiver editando)
  document.addEventListener("click", () => {
    if (!isEditing) {
      document.querySelectorAll(".menu-options").forEach((m) => m.classList.add("hidden"));
      activeMenu = null;
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  // Gerenciamento do menu do usuário
  document.querySelectorAll(".menu-user").forEach((icon) => {
    icon.addEventListener("click", (e) => {
      e.stopPropagation();
      const menu = icon.closest("div").querySelector(".menu-options_user");

      // Fecha todos os menus abertos antes de abrir o atual
      document.querySelectorAll(".menu-options_user").forEach((m) => {
        if (m !== menu) m.classList.add("hidden");
      });

      menu.classList.toggle("hidden");
    });
  });

  // Fecha os menus do usuário se clicar fora
  document.addEventListener("click", () => {
    document.querySelectorAll(".menu-options_user").forEach((menu) => {
      menu.classList.add("hidden");
    });
  });

  // Gerenciamento das ações rápidas (mensagens pré-definidas)
  const quickActions = document.querySelectorAll(".quick-action");
  const messageInput = document.getElementById("mensagem");

  quickActions.forEach((button) => {
    button.addEventListener("click", () => {
      const action = button.getAttribute("data-action");
      const currentText = messageInput.value.trim();
      
      if (currentText) {
        switch (action) {
          case "melhorar":
            messageInput.value = `Por favor, melhore o seguinte texto: "${currentText}"`;
            break;
          case "simplificar":
            messageInput.value = `Por favor, simplifique o seguinte texto: "${currentText}"`;
            break;
          case "traduzir":
            messageInput.value = `Por favor, traduza o seguinte texto: "${currentText}"`;
            break;
        }
      } else {
        messageInput.placeholder = "Digite um texto primeiro...";
        setTimeout(() => {
          messageInput.placeholder = "Digite sua mensagem...";
        }, 2000);
      }
    });
  });
});
