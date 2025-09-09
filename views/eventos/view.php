<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detalhes do Evento | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/view.css">
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
    <h2 class="titulo">📌 Detalhes do Evento</h2>

    <section class="card">
      <table class="detalhes">
        <tr><th>Título</th><td><?= htmlspecialchars($evento['titulo']) ?></td></tr>
        <tr><th>Local</th><td><?= htmlspecialchars($evento['local']) ?></td></tr>
        <tr><th>Serviços</th><td><?= htmlspecialchars($evento['servicos']) ?></td></tr>
        <tr><th>Tipo</th><td><?= htmlspecialchars($evento['tipo']) ?></td></tr>
        <tr><th>Data</th><td><?= date('d/m/Y H:i', strtotime($evento['data_evento'])) ?></td></tr>
        <tr><th>Descrição</th><td><?= nl2br(htmlspecialchars($evento['descricao'])) ?></td></tr>
      </table>
    </section>

    <h3 class="subtitulo">💬 Comentários</h3>

    <form method="POST" action="/firehouse-php/public/comentarios/store" class="form-comentario">
      <input type="hidden" name="evento_id" value="<?= (int)$evento['id'] ?>">
      <textarea name="conteudo" required placeholder="Escreva um comentário..." rows="3"></textarea>
      <button type="submit" class="btn">Comentar</button>
    </form>

    <?php if (!empty($comentarios)): ?>
      <ul class="lista-comentarios">
        <?php foreach ($comentarios as $c): ?>
          <li class="comentario">
            <strong><?= htmlspecialchars($c['autor']) ?>:</strong>
            <p><?= nl2br(htmlspecialchars($c['conteudo'])) ?></p>
            <em><?= date('d/m/Y H:i', strtotime($c['criado_em'])) ?></em>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="aviso">Seja o primeiro a comentar!</p>
    <?php endif; ?>
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
