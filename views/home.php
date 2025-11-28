<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home | FireHouse</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/home.css?v=<?php echo time(); ?>">
</head>
<body>

<?php require __DIR__ . '/partials/header.php'; ?>

<main class="conteudo">

<!-- HERO -->
<div class="hero-container">
  <div class="video-background">
    <video autoplay muted loop playsinline>
      <source src="/firehouse-php/public/assets/videos/cedric.mp4" type="video/mp4">
    </video>
  </div>

  <div class="overlay">
    <h1 class="display-4">
      A DIFERENÇA ENTRE UM<br>EVENTO COMUM E UM<br>INESQUECÍVEL COMEÇA AQUI.
    </h1>

    <a href="/firehouse-php/public/eventos/create" class="btn-principal">CRIAR EVENTO ➜</a>
  </div>
</div>
  <!-- SERVIÇOS -->
  <section class="servicos" id="servicos">
    <h2 class="titulo-servicos">Nossos Serviços</h2>

    <div class="grid-servicos">
      <div class="card">
        <i class="bi bi-heart-fill icon"></i>
        <h3>Casamentos</h3>
        <p>Planejamento e execução do seu grande dia com perfeição.</p>
      </div>

      <div class="card">
        <i class="bi bi-cake-fill icon"></i>
        <h3>Aniversários</h3>
        <p>Festas personalizadas com muita energia e alegria.</p>
      </div>

      <div class="card">
        <i class="bi bi-building-fill icon"></i>
        <h3>Eventos Corporativos</h3>
        <p>Organização completa para empresas e instituições.</p>
      </div>

      <div class="card">
        <i class="bi bi-mic-fill icon"></i>
        <h3>Shows e Palestras</h3>
        <p>Estrutura profissional para apresentações e conferências.</p>
      </div>

      <div class="card">
        <i class="bi bi-trophy-fill icon"></i>
        <h3>Premiações</h3>
        <p>Momentos de reconhecimento inesquecíveis.</p>
      </div>

      <div class="card">
        <i class="bi bi-stars icon"></i>
        <h3>Formaturas</h3>
        <p>Comemore suas conquistas com estilo e emoção.</p>
      </div>
    </div>

    <p class="nota-final">Transformamos qualquer ocasião em um evento memorável.</p>
  </section>

  <!-- SEÇÃO DE DESTAQUES -->
  <section class="destaques">
    <div class="destaque-card fade-up esquerda" style="transition-delay:0.1s;">
      <img src="/firehouse-php/public/assets/imagens/evento1.jpg" alt="Evento Esquerda">
      <div class="texto">
        <h4>Eventos memoráveis</h4>
        <p>Planejados nos mínimos detalhes para encantar.</p>
      </div>
    </div>

    <div class="destaque-card centro fade-up" style="transition-delay:0.2s;">
      <img src="/firehouse-php/public/assets/imagens/LOGO_FIREHOUSE_3.png" alt="FireHouse Logo" class="logo-centro"/>
      <div class="texto">
        <h4>FireHouse</h4>
        <p>Onde cada evento ganha vida.</p>
      </div>
    </div>

    <div class="destaque-card fade-up direita" style="transition-delay:0.3s;">
      <img src="/firehouse-php/public/assets/imagens/evento2.jpg" alt="Evento Direita">
      <div class="texto">
        <h4>Conecte e celebre</h4>
        <p>Unimos pessoas e experiências inesquecíveis.</p>
      </div>
    </div>
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
        <div><h3>PROFISSIONAIS ESPECIALIZADOS</h3><p>Conectamos você aos profissionais ideais para o sucesso do seu evento.</p></div>
        <div><h3>CONVITES</h3><p>Seja digital ou impresso, nossos designers criam convites marcantes.</p></div>
        <div><h3>ILUMINAÇÃO E CENOGRAFIA</h3><p>Ambientes que impressionam com luz e cenários impecáveis.</p></div>
        <div><h3>DECORAÇÃO</h3><p>Transformamos ideias em cenários reais e memoráveis.</p></div>
      </div>
    </div>
  </section>

  <!-- FEEDBACK -->
  <section class="feedback">
    <h2>O que dizem sobre a FireHouse</h2>
    <div class="feedback-container">
      <div class="feedback-card">
        <img src="/firehouse-php/public/assets/imagens/mauro.png" alt="Cliente 1">
        <p>“A FireHouse superou todas as nossas expectativas! Evento impecável.”</p>
      </div>
      <div class="feedback-card">
        <img src="/firehouse-php/public/assets/imagens/kanye.png" alt="Cliente 2">
        <p>“Equipe muito atenciosa e profissional. Tornaram nosso sonho realidade.”</p>
      </div>
      <div class="feedback-card">
        <img src="/firehouse-php/public/assets/imagens/danielmc.png" alt="Cliente 3">
        <p>“Cada detalhe foi pensado com carinho. Recomendo de olhos fechados!”</p>
      </div>
    </div>
  </section>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<script>
document.addEventListener("DOMContentLoaded", () => {
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  fadeElements.forEach(el => observer.observe(el));
});
</script>

</body>
</html>
