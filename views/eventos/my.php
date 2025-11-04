<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meus Eventos | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/my.css?v=<?php echo time(); ?>">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo">
  <section class="hero-my">
    <div class="hero-texto">
      <h1>Meus Eventos</h1>
      <p>Gerencie todos os eventos que você criou na FireHouse. Edite, visualize ou exclua facilmente.</p>
    </div>
  </section>

  <section class="cards-section">
    <div class="container">
      <?php if (!empty($error)): ?>
        <p class="erro"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <?php if (empty($eventos)): ?>
        <p class="aviso">Você ainda não criou nenhum evento.</p>
        <p class="link-criar">
          <a href="/firehouse-php/public/eventos/create" class="btn-criar">➕ Criar novo evento</a>
        </p>
      <?php else: ?>
        <div class="grid-eventos">
          <?php foreach ($eventos as $e): ?>
            <div class="card-evento">
              <div class="card-header">
                <h3><?= htmlspecialchars($e['titulo']) ?></h3>
                <span class="tag-data"><?= date('d/m/Y', strtotime($e['data_evento'])) ?></span>
              </div>

              <div class="card-body">
                <p><strong>📍 Local:</strong> <?= htmlspecialchars($e['local']) ?></p>
                <p><strong>🏷️ Tipo:</strong> <?= htmlspecialchars($e['tipo']) ?></p>

                <?php if (!empty($e['servicos'])): ?>
                  <p><strong>🛠️ Serviços:</strong> <?= htmlspecialchars($e['servicos']) ?></p>
                <?php endif; ?>

                <?php
                $total = 0;
                $encontrados = 0;

                if (!empty($e['servicos'])) {
                  $listaServ = array_map('trim', explode(',', $e['servicos']));
                  $total = count($listaServ);
                }

                if (!empty($e['servicos_encontrados'])) {
                  $listaEncontrados = array_map('trim', explode(',', $e['servicos_encontrados']));
                  $encontrados = count($listaEncontrados);
                }
                ?>

                <p>
                  <strong>Status:</strong>
                  <span class="status-evento status-<?= htmlspecialchars($e['status_evento'] ?? 'desconhecido') ?>">
                    <?= ucfirst(str_replace('_', ' ', htmlspecialchars($e['status_evento'] ?? 'desconhecido'))) ?>
                  </span>
                </p>

                <?php if ($total > 0): ?>
                  <p style="margin-top:4px;">
                    <strong>Progresso dos serviços:</strong>
                    <?= $encontrados ?>/<?= $total ?> encontrados
                    <?= $encontrados === $total && $total > 0 ? '✅' : '⏳' ?>
                  </p>
                <?php endif; ?>
              </div>

              <div class="card-footer">
                <a class="btn ver" href="/firehouse-php/public/eventos/view?id=<?= (int)$e['id'] ?>">👀 Ver</a>
                <a class="btn editar" href="/firehouse-php/public/eventos/edit?id=<?= (int)$e['id'] ?>">✏️ Editar</a>
                <a class="btn excluir" href="/firehouse-php/public/eventos/delete?id=<?= (int)$e['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este evento?')">🗑️ Excluir</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <p class="link-criar">
          <a href="/firehouse-php/public/eventos/create" class="btn-criar">➕ Criar outro evento</a>
        </p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
