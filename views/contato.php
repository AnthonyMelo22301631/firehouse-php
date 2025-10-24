<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contato | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS exclusivo da página Contato -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/contato.css?v=<?= time(); ?>">
</head>

<body>
  <?php require __DIR__ . '/partials/header.php'; ?>

  <main class="contato-container">
    <!-- Seção Hero -->
    <section class="hero-contato">
      <div class="texto-hero">
        <h1>Entre em Contato</h1>
        <p>Tem dúvidas, sugestões ou quer saber mais sobre nossos serviços? Fale conosco!</p>
      </div>
    </section>

    <!-- Formulário -->
    <section class="contato-form-section">
      <div class="form-wrapper">
        <h2>Envie sua mensagem</h2>
        <form method="POST" action="/firehouse-php/public/contato/enviar">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
          </div>

          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
          </div>

          <div class="form-group">
            <label for="mensagem">Mensagem</label>
            <textarea id="mensagem" name="mensagem" rows="5" placeholder="Digite sua mensagem..." required></textarea>
          </div>

          <button type="submit" class="btn-enviar">Enviar Mensagem</button>
        </form>
      </div>

      <!-- Informações de contato -->
      <div class="info-contato">
        <h3>📍 Onde estamos</h3>
        <p>Belo Horizonte, MG — Brasil</p>

        <h3>📧 E-mail</h3>
        <p>contato@firehouse.com.br</p>

        <h3>📞 Telefone</h3>
        <p>(31) 99999-9999</p>
      </div>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
