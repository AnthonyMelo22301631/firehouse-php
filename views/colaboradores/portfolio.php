<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfólio | FireHouse</title>
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/portfolio.css?v=<?php echo time(); ?>">
</head>
<body>
<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">Portfólio de Serviços Realizados</h2>

    <div class="lista-servicos">
      <?php if (!empty($eventos)): ?>
        <?php foreach ($eventos as $evento): ?>
          <div class="card-servico">
            <h3><?= htmlspecialchars($evento['nome_evento']) ?></h3>
            <p class="descricao-evento">
              <?= htmlspecialchars($evento['descricao_evento'] ?? 'Sem descrição adicional.') ?>
            </p>

            <?php if (!empty($evento['avaliacoes'])): ?>
              <div class="avaliacoes">
                <h4>Avaliações do Cliente</h4>
                <?php foreach ($evento['avaliacoes'] as $avaliacao): ?>
                  <div class="avaliacao">
                    <p class="comentario">“<?= htmlspecialchars($avaliacao['comentario']) ?>”</p>
                    <span class="nota">⭐ <?= htmlspecialchars($avaliacao['nota']) ?>/5</span>
                    <span class="cliente">— <?= htmlspecialchars($avaliacao['cliente']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <p class="sem-avaliacao">Ainda não há avaliações para este evento.</p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="sem-eventos">Nenhum evento finalizado encontrado.</p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
