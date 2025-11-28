<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sobre Nós | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/sobrenos.css?v=<?php echo time(); ?>">
</head>

<body>

  <?php require __DIR__ . '/partials/header.php'; ?>

  <main class="sobre-container">

    <!-- HERO -->
    <section class="hero-sobre">
      <div class="texto-hero">
        <h1>Conheça a <span>FireHouse</span></h1>
        <p>A plataforma criada para transformar a organização de eventos em algo simples, visual e inesquecível.</p>
        <a href="/firehouse-php/public/eventos" class="btn-laranja">Ver Eventos</a>
      </div>
    </section>

    <!-- SOBRE -->
    <section class="sobre-detalhes">
      <div class="container-sobre">
        <h2>Sobre Nós</h2>
        <p>
          A <strong>FireHouse</strong> nasceu com o propósito de aproximar pessoas, serviços e experiências.
          Desenvolvemos uma plataforma moderna que conecta clientes e colaboradores do ramo de eventos,
          tornando cada celebração mais prática, segura e organizada.
        </p>
        <p>
          Combinamos <strong>tecnologia, design e criatividade</strong> para facilitar todas as etapas: do planejamento
          à execução. Cada evento é único — e nós ajudamos você a contar essa história.
        </p>
      </div>
    </section>

    <!-- MVV -->
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

    <!-- EQUIPE / INTEGRANTES -->
    <section class="integrantes-sobre">
      <div class="container-integrantes">
        <h2>Nosso Time</h2>

        <p class="texto-equipe">
          Somos estudantes do <strong>COTEMIG</strong> e desenvolvemos o projeto FireHouse durante o
          <strong>3º ano do curso técnico de Desenvolvimento de Sistemas</strong>.  
          A plataforma foi criada como um projeto completo de software, integrando programação,
          design, banco de dados, boas práticas e aplicação real.
        </p>

        <ul class="lista-integrantes">
          <li>DANIEL RAMOS NADALIN VAZ DA COSTA</li>
          <li>JOÃO PEDRO DE FREITAS CARVALHO</li>
          <li>GABRIEL CÉDRIC CARVALHO DAMÁZIO</li>
          <li>PEDRO SCARABELLI DO NASCIMENTO</li>
          <li>ANTHONY MARCELO MENDOZA DE MELO</li>
        </ul>
      </div>
    </section>

  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>

</body>
</html>
