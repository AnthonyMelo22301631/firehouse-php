<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($evento['titulo'] ?? 'Evento') ?> | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/view.css?v=<?= time(); ?>">
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo">
  <div class="container">
    <div class="card-evento">
      <h1 class="titulo">📅 <?= htmlspecialchars($evento['titulo'] ?? 'Sem título') ?></h1>

      <p class="info"><strong>🏷️ Tipo:</strong> <?= htmlspecialchars($evento['tipo'] ?? '—') ?></p>
      <p class="info"><strong>📍 Local:</strong> <?= htmlspecialchars($evento['local'] ?? '—') ?></p>
      <p class="info"><strong>🗓️ Data:</strong> <?= date('d/m/Y H:i', strtotime($evento['data_evento'] ?? 'now')) ?></p>
      <p class="info"><strong>👤 Criado por:</strong> <?= htmlspecialchars($evento['nome_criador'] ?? '—') ?></p>

      <?php if (!empty($evento['servicos'])): ?>
        <h3 class="subtitulo">🛠️ Serviços solicitados</h3>
        <p class="descricao"><?= htmlspecialchars($evento['servicos']) ?></p>
      <?php endif; ?>

      <?php if (!empty($evento['servicos_encontrados'])): ?>
        <h3 class="subtitulo">✅ Serviços vinculados</h3>
        <p class="descricao"><?= htmlspecialchars($evento['servicos_encontrados']) ?></p>
      <?php endif; ?>

      <hr>

      <h3 class="subtitulo">🧾 Descrição</h3>
      <p class="descricao"><?= nl2br(htmlspecialchars($evento['descricao'] ?? 'Sem descrição.')) ?></p>

      <hr>
      <p><strong>Status:</strong>
        <span class="status-evento status-<?= htmlspecialchars($evento['status_evento'] ?? 'desconhecido') ?>">
          <?= ucfirst(str_replace('_', ' ', htmlspecialchars($evento['status_evento'] ?? 'desconhecido'))) ?>
        </span>
      </p>

      <div class="botoes">
        <a href="/firehouse-php/public/eventos" class="btn-voltar">← Voltar</a>
      </div>
    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
