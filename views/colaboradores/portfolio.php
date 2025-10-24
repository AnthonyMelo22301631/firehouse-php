<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfólio | FireHouse</title>
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/colaboradores.css?v=<?php echo time(); ?>">
</head>
<body>
<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">📂 Portfólio de Serviços</h2>

    <div class="lista-servicos">
      <?php foreach ($servicos as $s): ?>
        <div class="card-servico">
          <h3><?= htmlspecialchars($s['nome']) ?></h3>
          <p><?= htmlspecialchars($s['descricao']) ?></p>
          <span class="preco">R$ <?= number_format($s['preco'], 2, ',', '.') ?></span>
          <span class="autor">Por: <?= htmlspecialchars($s['colaborador']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
