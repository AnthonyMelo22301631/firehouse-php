<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Evento | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS específico -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/create.css">
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
  <div class="container">
    <h2 class="titulo">➕ Criar Evento</h2>

    <form method="post" action="/firehouse-php/public/eventos/store" class="form-card">
      <label for="titulo">Título do evento</label>
      <input id="titulo" type="text" name="titulo" required>

      <label for="local">Local</label>
      <select id="local" name="local" required>
        <option value="">-- Selecione --</option>
        <option>Salão de Festa</option>
        <option>Hotel</option>
        <option>Apartamento</option>
        <option>Outro</option>
      </select>

      <label>Serviços</label>
      <div class="checkbox-group">
        <label><input type="checkbox" name="servicos[]" value="Buffet"> Buffet</label>
        <label><input type="checkbox" name="servicos[]" value="DJ"> DJ</label>
        <label><input type="checkbox" name="servicos[]" value="Animador"> Animador</label>
        <label><input type="checkbox" name="servicos[]" value="Decoração"> Decoração</label>
      </div>

      <label for="tipo">Tipo de evento</label>
      <select id="tipo" name="tipo" required>
        <option value="">-- Selecione --</option>
        <option>Aniversário</option>
        <option>Casamento</option>
        <option>Colaborativo</option>
        <option>Formatura</option>
      </select>

      <label for="data_evento">Data e horário</label>
      <input id="data_evento" type="datetime-local" name="data_evento" required>

      <label for="descricao">Descrição</label>
      <textarea id="descricao" name="descricao" rows="5"></textarea>

      <button type="submit" class="btn">Criar Evento</button>
    </form>
  </div>
</main>

<footer class="footer">
  <div class="footer-container">
    <p>© <?= date('Y') ?> <span class="marca">🔥 FireHouse</span> — Todos os direitos reservados</p>
    <p class="creditos">Desenvolvido com ❤ para o projeto escolar</p>
  </div>
</footer>
</body>
</html>
