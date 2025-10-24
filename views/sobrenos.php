<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sobre Nós | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS exclusivo da página Sobre Nós -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/sobrenos.css?v=<?php echo time(); ?>">
</head>

<body>
  <?php require __DIR__ . '/partials/header.php'; ?>

  <main class="sobre-container">
    <!-- Seção Hero -->
    <section class="hero-sobre">
      <div class="texto-hero">
        <h1>Conheça a <span>FireHouse</span></h1>
        <p>A plataforma que transforma a organização de eventos em algo simples, criativo e inesquecível.</p>
        <a href="/firehouse-php/public/eventos" class="btn-laranja">Ver Eventos</a>
      </div>
    </section>

    <!-- Seção Sobre -->
    <section class="sobre-detalhes">
      <div class="container-sobre">
        <h2>Sobre Nós</h2>
        <p>
          A <strong>FireHouse</strong> nasceu com o propósito de aproximar pessoas e experiências.
          Criamos uma plataforma completa para conectar clientes e colaboradores do ramo de eventos — 
          tornando cada celebração mais prática, organizada e cheia de personalidade.
        </p>
        <p>
          Combinamos <strong>tecnologia, design e criatividade</strong> para facilitar todas as etapas: 
          do planejamento à execução. Cada evento é tratado como uma história única — e nós ajudamos você a contá-la.
        </p>
      </div>
    </section>

    <!-- Seção Missão, Visão, Valores -->
    <section class="mvv">
      <h2>Nossos Pilares</h2>
      <div class="cards-mvv">
        <div class="card-mvv">
          <h3>🎯 Missão</h3>
          <p>Facilitar a organização de eventos, conectando pessoas, ideias e talentos em um só lugar.</p>
        </div>
        <div class="card-mvv">
          <h3>👁️ Visão</h3>
          <p>Ser referência nacional em inovação e tecnologia aplicada ao setor de eventos.</p>
        </div>
        <div class="card-mvv">
          <h3>🔥 Valores</h3>
          <ul>
            <li>Transparência e confiança</li>
            <li>Inovação constante</li>
            <li>Experiências únicas</li>
            <li>Trabalho em equipe</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Seção Equipe -->
    <section class="equipe-sobre">
      <div class="container-equipe">
        <h2>Nosso Time</h2>
        <p class="intro-equipe">
          A FireHouse é construída por pessoas apaixonadas por inovação, design e eventos.
        </p>
        <div class="grid-equipe">
          <div class="membro">
            <img src="/firehouse-php/public/assets/img/team1.jpg" alt="Equipe FireHouse">
            <h3>Equipe de Desenvolvimento</h3>
            <p>Criamos soluções inteligentes que tornam a experiência do usuário fluida e eficiente.</p>
          </div>
          <div class="membro">
            <img src="/firehouse-php/public/assets/img/team2.jpg" alt="Equipe Criativa">
            <h3>Equipe Criativa</h3>
            <p>Transformamos ideias em experiências visuais e eventos incríveis.</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
