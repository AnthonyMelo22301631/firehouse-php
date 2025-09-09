<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Eventos | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS específico -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/all.css">
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
    <h2 class="titulo">📅 Todos os Eventos</h2>

    <?php if (empty($eventos)): ?>
      <p class="aviso">Nenhum evento foi criado ainda.</p>
    <?php else: ?>
      <div class="tabela-container">
        <table class="tabela-eventos">
          <thead>
            <tr>
              <th>Título</th>
              <th>Local</th>
              <th>Serviços</th>
              <th>Tipo</th>
              <th>Data</th>
              <th>Criador</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($eventos as $e): ?>
              <tr>
                <td><?= htmlspecialchars($e['titulo']) ?></td>
                <td><?= htmlspecialchars($e['local']) ?></td>
                <td><?= htmlspecialchars($e['servicos']) ?></td>
                <td><?= htmlspecialchars($e['tipo']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($e['data_evento'])) ?></td>
                <td><?= htmlspecialchars($e['criador'] ?? '—') ?></td>
                <td>
                  <a class="btn-ver" href="/firehouse-php/public/eventos/view?id=<?= (int)$e['id'] ?>">👀 Ver</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
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
