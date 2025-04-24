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
  const icons = document.querySelectorAll(".menu-icon");

  icons.forEach((icon) => {
    icon.addEventListener("click", (e) => {
      e.stopPropagation(); // Evita conflitos
      const parent = icon.closest(".group");
      const menu = parent.querySelector(".menu-options");

      // Esconde todos os outros
      document.querySelectorAll(".menu-options").forEach((m) => {
        if (m !== menu) m.classList.add("hidden");
      });

      // Alterna o menu clicado
      menu.classList.toggle("hidden");
    });
  });

  // Fecha o menu se clicar fora
  document.addEventListener("click", () => {
    document
      .querySelectorAll(".menu-options")
      .forEach((m) => m.classList.add("hidden"));
  });
});

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".menu-user").forEach((icon) => {
    icon.addEventListener("click", (e) => {
      e.stopPropagation(); // Impede propagação para não fechar imediatamente
      const menu = icon.closest("div").querySelector(".menu-options_user");

      // Fecha todos os menus abertos antes de abrir o atual
      document.querySelectorAll(".menu-options_user").forEach((m) => {
        if (m !== menu) m.classList.add("hidden");
      });

      // Alterna a visibilidade do menu clicado
      menu.classList.toggle("hidden");
    });
  });

  // Fecha os menus se clicar fora
  document.addEventListener("click", () => {
    document.querySelectorAll(".menu-options_user").forEach((menu) => {
      menu.classList.add("hidden");
    });
  });
});
