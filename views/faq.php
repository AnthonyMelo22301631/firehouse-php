<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perguntas Frequentes | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS exclusivo da página FAQ -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/faq.css?v=<?php echo time(); ?>">
</head>

<body>
  <?php require __DIR__ . '/partials/header.php'; ?>

  <main class="faq-container">
    <!-- Seção Hero -->
    <section class="hero-faq">
      <div class="texto-hero">
        <h1>Dúvidas? <span>Nós te ajudamos!</span></h1>
        <p>Encontre aqui as respostas para as perguntas mais comuns sobre a FireHouse e nossos serviços.</p>
      </div>
    </section>

    <!-- Seção Perguntas Frequentes -->
    <section class="faq-lista">
      <div class="container-faq">
        <h2>Perguntas Frequentes</h2>
        <div class="faq-item">
          <h3>💡 O que é a FireHouse?</h3>
          <p>A FireHouse é uma plataforma de organização de eventos que conecta clientes e colaboradores, permitindo que você planeje, gerencie e realize eventos com praticidade e eficiência.</p>
        </div>

        <div class="faq-item">
          <h3>🧾 Preciso pagar para me cadastrar?</h3>
          <p>O cadastro é gratuito! Você pode se cadastrar como cliente para organizar eventos ou como colaborador para oferecer seus serviços.</p>
        </div>

        <div class="faq-item">
          <h3>🧑‍💻 Quem pode se tornar colaborador?</h3>
          <p>Qualquer profissional que ofereça serviços relacionados a eventos — como decoração, som, buffet ou fotografia — pode se cadastrar como colaborador e disponibilizar seus serviços.</p>
        </div>

        <div class="faq-item">
          <h3>📅 Como funciona o agendamento de um evento?</h3>
          <p>O cliente escolhe os serviços desejados, define as datas e informações principais. O colaborador é notificado e ambos podem gerenciar os detalhes pela plataforma.</p>
        </div>

        <div class="faq-item">
          <h3>🔐 Meus dados estão seguros?</h3>
          <p>Sim! A FireHouse segue padrões de segurança e criptografia para garantir a proteção dos dados de todos os usuários.</p>
        </div>

        <div class="faq-item">
          <h3>🧡 Posso editar ou cancelar um evento?</h3>
          <p>Sim, eventos podem ser editados ou cancelados diretamente pelo painel do cliente, com total transparência e praticidade.</p>
        </div>
      </div>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
