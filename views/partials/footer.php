<!-- Importa o CSS do footer -->
<link rel="stylesheet" href="/firehouse-php/public/assets/css/footer.css?v=<?php echo time(); ?>">

<footer class="footer">
  <div class="footer-container">

    <!-- LOGO -->
    <div class="footer-logo">
      <img src="/firehouse-php/public/assets/imagens/LOGO_FIREHOUSE_3.png" alt="FireHouse Logo">
      <span class="footer-logo-text">FireHouse</span>
    </div>

    <!-- LINKS -->
    <nav class="footer-links">
      <a href="/firehouse-php/public/">Home</a>
      <a href="/firehouse-php/public/eventos">Eventos</a>
      <a href="/firehouse-php/public/colaboradores">Colaboradores</a>
      <a href="/firehouse-php/public/sobrenos">Sobre Nós</a>
      <a href="/firehouse-php/public/faq">FAQ</a>
      <a href="/firehouse-php/public/contato">Contato</a>

      <!-- ✅ Novo link inserido -->
      <a href="/firehouse-php/public/auth/termos">Termos de Consentimento</a>
    </nav>

    <!-- REDES SOCIAIS -->
    <div class="footer-social">
      <!-- Instagram -->
      <a href="#" aria-label="Instagram" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 24 24" width="28" height="28">
          <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2ZM12 7a5 5 0 1 0 0 10a5 5 0 0 0 0-10Zm6.5-.75a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5ZM12 9a3 3 0 1 1 0 6a3 3 0 0 1 0-6Z"/>
        </svg>
      </a>

      <!-- Facebook -->
      <a href="#" aria-label="Facebook" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 24 24" width="28" height="28">
          <path d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-2.9h2v-2.2c0-2 1.2-3.2 3-3.2c.9 0 1.8.1 2 .1v2.3h-1.1c-1 0-1.3.6-1.3 1.2v1.8h2.6l-.4 2.9h-2.2v7A10 10 0 0 0 22 12Z"/>
        </svg>
      </a>

      <!-- Email -->
      <a href="mailto:contato@firehouse.com" aria-label="Email" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 24 24" width="28" height="28">
          <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm0 2v.01L12 13l8-6.99V6H4zm16 12V8l-8 6-8-6v10h16z"/>
        </svg>
      </a>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© <?php echo date('Y'); ?> FireHouse. Todos os direitos reservados.</p>
  </div>
</footer>
