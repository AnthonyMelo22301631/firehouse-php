<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS único da Home -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/home.css">
</head>
<body>
<header class="navbar">
  <div class="navbar-container">
    <!-- LOGO -->
    <div class="logo">
      <a href="/firehouse-php/public/">🔥 FireHouse</a>
    </div>

    <!-- LINKS PRINCIPAIS -->
    <nav class="nav-links">
      <a href="/firehouse-php/public/colaboradores">Colaboradores</a>
      <a href="/firehouse-php/public/eventos/create">Criar Evento</a>
      <a href="/firehouse-php/public/eventos">Eventos</a>
    </nav>

   <!-- AÇÕES -->
  <div class="nav-actions">
  <?php if (!empty($_SESSION['user_id'])): ?>
    <a href="/firehouse-php/public/meus-eventos">Meus Eventos</a>
    <a href="/firehouse-php/public/auth/perfil">Perfil</a>
    <a href="/firehouse-php/public/auth/logout">Sair</a>
  <?php else: ?>
    <a href="/firehouse-php/public/auth/login">Entrar</a>
    <a href="/firehouse-php/public/auth/register">Cadastrar</a>
  <?php endif; ?>
</div>
  </div>
</header>

<main class="conteudo">
  <!-- HERO COM VÍDEO -->
  <div class="hero-container">
    <div class="video-background">
      <video autoplay muted loop playsinline>
        <source src="/firehouse-php/public/assets/videos/oi.mp4" type="video/mp4">
      </video>
    </div>

    <div class="overlay">
      <h1 class="display-4">
        A DIFERENÇA ENTRE UM<br>EVENTO COMUM E UM<br>INESQUECÍVEL COMEÇA AQUI.
      </h1>
    </div>

    <div class="btn-container">
      <a href="/firehouse-php/public/eventos/create" class="btn-principal">CRIAR EVENTO ➜</a>
    </div>
  </div>

  <!-- SERVIÇOS -->
  <section class="servicos" id="servicos">
    <div class="grid-servicos">
      <div class="card"><div class="icon">💍</div><h3>CASAMENTOS</h3><p>Do altar à última dança — cuidamos de cada detalhe...</p></div>
      <div class="card"><div class="icon">🎂</div><h3>ANIVERSÁRIOS</h3><p>Festa boa começa com planejamento e termina com sorrisos...</p></div>
      <div class="card"><div class="icon">🥂</div><h3>EVENTOS</h3><p>Corporativos, temáticos ou comemorativos...</p></div>
      <div class="card"><div class="icon">🎓</div><h3>FORMATURAS</h3><p>Cada conquista merece ser vivida...</p></div>
      <div class="card"><div class="icon">👶</div><h3>CHÁS DE REVELAÇÃO</h3><p>Não é só sobre azul ou rosa...</p></div>
      <div class="card"><div class="icon">✝️</div><h3>BATIZADOS</h3><p>Celebrar o início de uma nova vida...</p></div>
      <div class="card"><div class="icon">🏆</div><h3>PREMIAÇÕES</h3><p>Reconhecer conquistas com estilo e emoção...</p></div>
      <div class="card"><div class="icon">🎤</div><h3>SHOWS & PALESTRAS</h3><p>Do palco à plateia, cuidamos de cada detalhe...</p></div>
    </div>
    <p class="nota-final">ISSO É SÓ UMA AMOSTRA. O QUE A FIREHOUSE ENTREGA VAI MUITO ALÉM.</p>
  </section>

  <!-- O QUE OFERECEMOS -->
  <section class="oferecemos">
    <div class="oferecemos-container">
      <div class="oferecemos-texto">
        <h2>O QUE OFERECEMOS?</h2>
        <p>Serviços de alta qualidade, feitos especialmente para você!</p>
        <a href="#servicos" class="btn-veja">VEJA O QUE PODEMOS FAZER POR VOCÊ →</a>
      </div>
      <div class="oferecemos-lista">
        <div><h3>PROFISSIONAIS ESPECIALIZADOS</h3><p>Conectamos você aos profissionais ideais...</p></div>
        <div><h3>CONVITES</h3><p>Seja digital ou impresso, designers especializados...</p></div>
        <div><h3>ILUMINAÇÃO E CENOGRAFIA</h3><p>Ambientes que impressionam, parceiros que dominam luz e cenário...</p></div>
        <div><h3>DECORAÇÃO</h3><p>Transformamos ideias em cenários reais...</p></div>
      </div>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="footer-container">
    <p>© 2025 <span class="marca">🔥 FireHouse</span> — Todos os direitos reservados</p>
    <p class="creditos">Desenvolvido com ❤ para o projeto escolar</p>
  </div>
</footer>
</body>
</html>
