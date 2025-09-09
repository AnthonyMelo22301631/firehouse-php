<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Evento | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS (com cache-buster) -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/edit.css?v=3">
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
      <?php if (!empty($_SESSION['uid'])): ?>
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
    <h2 class="titulo">✏️ Editar Evento</h2>

    <form method="POST" action="/firehouse-php/public/eventos/update" class="form-card">
      <input type="hidden" name="id" value="<?= htmlspecialchars($evento['id']) ?>">

      <label for="titulo">Título</label>
      <input id="titulo" type="text" name="titulo" value="<?= htmlspecialchars($evento['titulo']) ?>" required>

      <label for="local">Local</label>
      <input id="local" type="text" name="local" value="<?= htmlspecialchars($evento['local']) ?>" required>

      <label for="servicos">Serviços</label>
      <input id="servicos" type="text" name="servicos" value="<?= htmlspecialchars($evento['servicos']) ?>">

      <label for="tipo">Tipo</label>
      <input id="tipo" type="text" name="tipo" value="<?= htmlspecialchars($evento['tipo']) ?>" required>

      <label for="data_evento">Data do Evento</label>
      <input id="data_evento" type="datetime-local" name="data_evento"
             value="<?= date('Y-m-d\TH:i', strtotime($evento['data_evento'])) ?>" required>

      <label for="descricao">Descrição</label>
      <textarea id="descricao" name="descricao" rows="5"><?= htmlspecialchars($evento['descricao']) ?></textarea>

      <div class="actions">
        <a class="btn-ghost" href="/firehouse-php/public/eventos/my">Cancelar</a>
        <button type="submit" class="btn">💾 Salvar Alterações</button>
      </div>
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
