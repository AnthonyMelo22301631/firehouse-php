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
          <div class="card-servico" id="servico-<?= $s['id'] ?>">
            <h3><?= htmlspecialchars($s['nome']) ?></h3>
            <p><?= nl2br(htmlspecialchars($s['descricao'])) ?></p>
            <p><strong>Status:</strong> <?= ucfirst($s['status']) ?></p>

            <div class="acoes">
              <button class="btn-cancelar" onclick="cancelarServico(<?= $s['id'] ?>)">❌ Cancelar Serviço</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<script>
async function cancelarServico(id) {
  if (!confirm("Tem certeza que deseja cancelar este serviço?")) return;

  const formData = new FormData();
  formData.append('id', id);

  const resp = await fetch('/firehouse-php/public/colaboradores/cancelar-servico', {
    method: 'POST',
    body: formData
  });

  const data = await resp.json();
  if (data.success) {
    document.getElementById('servico-' + id).remove();
    alert('Serviço cancelado com sucesso!');
  } else {
    alert('Erro ao cancelar o serviço.');
  }
}
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
