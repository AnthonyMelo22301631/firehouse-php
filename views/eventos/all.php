<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Eventos | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/all.css?v=<?= time(); ?>">
</head>

<body>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">📅 Explore os Eventos Publicados</h2>
    <p class="subtitulo">Confira eventos criados pela comunidade FireHouse.</p>

    <?php if (empty($eventos)): ?>
      <p class="aviso">Nenhum evento disponível no momento.</p>
    <?php else: ?>
      <div class="grid-eventos">
        <?php foreach ($eventos as $e): ?>
          <div class="card-evento">
            
            <div class="card-header">
              <h3><?= htmlspecialchars($e['titulo']) ?></h3>
              <span class="tag-data">
                <?= date('d/m/Y', strtotime($e['data_evento'] ?? 'now')) ?>
              </span>
            </div>

            <div class="card-body">
              <?php if (!empty($e['cidade']) && !empty($e['estado'])): ?>
                <p><strong>📍 Local:</strong> <?= htmlspecialchars($e['cidade']) ?>/<?= htmlspecialchars($e['estado']) ?></p>
              <?php elseif (!empty($e['local'])): ?>
                <p><strong>📍 Local:</strong> <?= htmlspecialchars($e['local']) ?></p>
              <?php endif; ?>

              <p><strong>👤 Criado por:</strong> <?= htmlspecialchars($e['criador'] ?? '—') ?></p>

              <p><strong>🗓️ Publicado em:</strong> 
                <?= isset($e['data_criacao']) ? date('d/m/Y', strtotime($e['data_criacao'])) : '—' ?>
              </p>

              <p>
                <strong>Status:</strong>
                <span class="status-evento status-<?= htmlspecialchars($e['status_evento'] ?? 'desconhecido') ?>">
                  <?= ucfirst(str_replace('_', ' ', htmlspecialchars($e['status_evento'] ?? 'desconhecido'))) ?>
                </span>
              </p>
            </div>

            <div class="card-footer">
              <a class="btn-ver" href="/firehouse-php/public/eventos/view?id=<?= (int)$e['id'] ?>">Ver Detalhes</a>
              
              <?php if (!empty($_SESSION['tipo']) && 
                        in_array($_SESSION['tipo'], ['colaborador', 'ambos'])): ?>
                <a class="btn-candidatar" href="/firehouse-php/public/eventos/candidatar?id=<?= (int)$e['id'] ?>">
                  Candidatar-se
                </a>
              <?php endif; ?>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
