<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meus Eventos | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS (com cache-buster) -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/my.css?v=3">
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
    <h2 class="titulo">🙋‍♂️ Meus Eventos</h2>

    <?php if (!empty($error)): ?>
      <p class="erro"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (empty($eventos)): ?>
      <p class="aviso">Você ainda não criou nenhum evento.</p>
      <p class="link-criar"><a href="/firehouse-php/public/eventos/create">➕ Criar novo evento</a></p>
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
              <th>Descrição</th>
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
                <td><?= htmlspecialchars($e['descricao']) ?></td>
                <td class="acoes">
                  <a class="btn editar" href="/firehouse-php/public/eventos/edit?id=<?= urlencode((int)$e['id']) ?>">✏️ Editar</a>
                  <a class="btn excluir" href="/firehouse-php/public/eventos/delete?id=<?= urlencode((int)$e['id']) ?>" onclick="return confirm('Tem certeza que deseja excluir este evento?')">🗑️ Excluir</a>
                  <a class="btn ver" href="/firehouse-php/public/eventos/view?id=<?= urlencode((int)$e['id']) ?>">👀 Ver</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="link-criar"><a href="/firehouse-php/public/eventos/create">➕ Criar outro evento</a></p>
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
