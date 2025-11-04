<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Meus Serviços | FireHouse</title>
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/servicos.css?v=<?php echo time(); ?>">
</head>
<body>

<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">Meus Serviços</h2>

    <?php if (empty($servicos)): ?>
      <p class="aviso">Você ainda não cadastrou nenhum serviço.</p>
    <?php else: ?>
      <div class="lista-servicos">
        <?php foreach ($servicos as $s): ?>
          <div class="card-servico">
            <h3><?= htmlspecialchars($s['nome']) ?></h3>
            <p><?= nl2br(htmlspecialchars($s['descricao'] ?? 'Sem descrição')) ?></p>

            <div class="status">
              <strong>Status:</strong>
              <span class="<?= ($s['status'] ?? '') === 'inativo' ? 'inativo' : 'ativo' ?>">
                <?= ucfirst($s['status'] ?? 'Ativo') ?>
              </span>
            </div>

            <div class="botoes">
              <a href="/firehouse-php/public/colaboradores/view?id=<?= $s['id'] ?>" class="btn-ver">Ver detalhes</a>

              <?php if (($s['status'] ?? '') !== 'inativo'): ?>
                <button class="btn-cancelar" data-id="<?= $s['id'] ?>">❌ Cancelar Serviço</button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<script>
document.querySelectorAll('.btn-cancelar').forEach(btn => {
  btn.addEventListener('click', async () => {
    if (!confirm('Tem certeza que deseja cancelar este serviço?')) return;

    const formData = new FormData();
    formData.append('servico_id', btn.dataset.id);

    const response = await fetch('/firehouse-php/public/colaboradores/cancelar', {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (data.success) {
      alert('✅ Serviço cancelado com sucesso!');
      location.reload();
    } else {
      alert('❌ Erro: ' + (data.error || 'Não foi possível cancelar o serviço.'));
    }
  });
});
</script>

</body>
</html>
