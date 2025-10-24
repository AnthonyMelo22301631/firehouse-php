<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Colaboradores | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/all-colaboradores.css?v=<?php echo time(); ?>">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">🤝 Colaboradores</h2>
    <p class="descricao">Conheça os serviços oferecidos pelos colaboradores da FireHouse e encontre o ideal para o seu evento.</p>

   

    <div class="servicos-lista">
      <?php if (empty($servicos)): ?>
        <p class="aviso">Nenhum serviço cadastrado ainda.</p>
      <?php else: ?>
        <?php foreach ($servicos as $s): ?>
          <div class="servico-card">
            <div class="servico-header">
              <h3 class="servico-nome"><?= htmlspecialchars($s['nome']) ?></h3>
              <span class="servico-data">
                Publicado em: <?= date('d/m/Y', strtotime($s['created_at'] ?? 'now')) ?>
              </span>
            </div>

            <p class="servico-desc"><?= nl2br(htmlspecialchars($s['descricao'])) ?></p>
            <p class="servico-colab"><strong>Colaborador:</strong> <?= htmlspecialchars($s['colaborador']) ?></p>

            <a class="btn-sec" href="/firehouse-php/public/colaboradores/view?id=<?= $s['id'] ?>">Ver detalhes</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
