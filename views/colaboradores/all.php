<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Colaboradores | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/all-colaboradores.css?v=<?= time(); ?>">
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
    <h2 class="titulo">
      <?= ($_SESSION['tipo'] ?? '') === 'colaborador' || ($_SESSION['tipo'] ?? '') === 'ambos' ? 'Meus Serviços' : 'Colaboradores' ?>
    </h2>

    <p class="descricao">
      <?= ($_SESSION['tipo'] ?? '') === 'colaborador' || ($_SESSION['tipo'] ?? '') === 'ambos'
        ? 'Gerencie seus serviços cadastrados e cancele quando desejar.'
        : 'Conheça os serviços oferecidos pelos colaboradores da FireHouse e encontre o ideal para o seu evento.' ?>
    </p>

    <!-- 🔹 FILTROS DE PESQUISA -->
    <form method="GET" action="/firehouse-php/public/colaboradores"
          style="display:flex; flex-wrap:wrap; gap:10px; margin:25px 0; background:#f8f8f8; padding:15px; border-radius:10px;">

      <input type="text" name="nome_servico" placeholder="Nome do serviço"
             value="<?= htmlspecialchars($filtros['nome_servico'] ?? '') ?>"
             style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:150px;">

      <input type="text" name="colaborador" placeholder="Nome do colaborador"
             value="<?= htmlspecialchars($filtros['colaborador'] ?? '') ?>"
             style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:150px;">

      <select name="status"
              style="padding:8px; border-radius:5px; border:1px solid #ccc; width:150px;">
        <option value="">Status</option>
        <option value="ativo" <?= ($filtros['status'] ?? '') === 'ativo' ? 'selected' : '' ?>>Ativo</option>
        <option value="inativo" <?= ($filtros['status'] ?? '') === 'inativo' ? 'selected' : '' ?>>Inativo</option>
      </select>

      <select name="ordenar"
              style="padding:8px; border-radius:5px; border:1px solid #ccc; width:180px;">
        <option value="">Ordenar por</option>
        <option value="nome_asc" <?= ($filtros['ordenar'] ?? '') === 'nome_asc' ? 'selected' : '' ?>>Nome A–Z</option>
        <option value="nome_desc" <?= ($filtros['ordenar'] ?? '') === 'nome_desc' ? 'selected' : '' ?>>Nome Z–A</option>
        <option value="data_desc" <?= ($filtros['ordenar'] ?? '') === 'data_desc' ? 'selected' : '' ?>>Mais recentes</option>
        <option value="data_asc" <?= ($filtros['ordenar'] ?? '') === 'data_asc' ? 'selected' : '' ?>>Mais antigos</option>
      </select>

      <button type="submit"
              style="background:#ff7a00; color:white; border:none; border-radius:6px; padding:8px 14px; cursor:pointer; font-weight:600;">
        🔍 Filtrar
      </button>

      <a href="/firehouse-php/public/colaboradores"
         style="color:#555; text-decoration:none; padding:8px 10px; font-weight:600;">Limpar</a>
    </form>

    <!-- 🔹 LISTAGEM DE SERVIÇOS -->
    <div class="servicos-lista">
      <?php if (empty($servicos)): ?>
        <p class="aviso">Nenhum serviço encontrado com os filtros aplicados.</p>
      <?php else: ?>
        <?php foreach ($servicos as $s): ?>
          <div class="servico-card">
            <div class="servico-header">
              <h3 class="servico-nome"><?= htmlspecialchars($s['nome']) ?></h3>
              <span class="servico-data">
                Publicado em: <?= !empty($s['created_at']) ? date('d/m/Y', strtotime($s['created_at'])) : '—' ?>
              </span>
            </div>

            <p class="servico-desc"><?= nl2br(htmlspecialchars($s['descricao'] ?? 'Sem descrição')) ?></p>
            <p class="servico-colab"><strong>👤 Colaborador:</strong> <?= htmlspecialchars($s['colaborador']) ?></p>

            <p class="servico-status">
              <strong>Status:</strong> 
              <span style="color: <?= ($s['status'] === 'ativo') ? '#16a34a' : '#f59e0b' ?>; font-weight:600;">
                <?= ucfirst($s['status'] ?? 'Desconhecido') ?>
              </span>
            </p>

            <div class="servico-footer" style="margin-top:15px; display:flex; gap:10px; flex-wrap:wrap;">
              <a class="btn-sec" href="/firehouse-php/public/colaboradores/view?id=<?= $s['id'] ?>">Ver detalhes</a>
              <a class="btn-portfolio" href="/firehouse-php/public/colaboradores/portfolio-public?id=<?= (int)$s['user_id'] ?>">Ver portfólio</a>

              <?php if (($_SESSION['tipo'] ?? '') === 'colaborador' || ($_SESSION['tipo'] ?? '') === 'ambos'): ?>
                <?php if (($s['status'] ?? '') !== 'inativo'): ?>
                  <button class="btn-cancelar" data-id="<?= $s['id'] ?>" style="background:#e63946; color:white; border:none; border-radius:6px; padding:8px 14px; cursor:pointer; font-weight:600;">
                    ❌ Cancelar Serviço
                  </button>
                <?php else: ?>
                  <span style="color:#e63946; font-weight:600;">(Cancelado)</span>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<!-- 🔹 Script para cancelar serviço -->
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
