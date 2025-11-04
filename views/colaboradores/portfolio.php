<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfólio | FireHouse</title>
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/portfolio.css?v=<?php echo rand(1000,9999); ?>">
</head>
<body>

<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">Portfólio de Serviços Realizados</h2>

    <?php if (!empty($colaborador)): ?>
      <h3 class="subtitulo">de <?= htmlspecialchars($colaborador['nome']) ?></h3>
    <?php endif; ?>

    <?php if (!empty($portfolio)): ?>
      <div class="lista-servicos">
        <?php foreach ($portfolio as $item): ?>
          <div class="card-servico">
            <h3><?= htmlspecialchars($item['servico_nome'] ?? 'Serviço não informado') ?></h3>

            <p><strong>Evento:</strong> <?= htmlspecialchars($item['evento_nome'] ?? 'Evento não encontrado') ?></p>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($item['cliente_nome'] ?? '—') ?></p>
            <p><strong>Nota:</strong> <?= htmlspecialchars($item['nota'] ?? '—') ?>/5</p>
            <p><strong>Comentário:</strong> <?= nl2br(htmlspecialchars($item['comentario'] ?? 'Sem comentário')) ?></p>

            <small>
              <em>Registrado em: 
                <?= !empty($item['data_insercao']) ? date('d/m/Y H:i', strtotime($item['data_insercao'])) : '—' ?>
              </em>
            </small>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="sem-eventos">Nenhum serviço avaliado ainda.</p>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
