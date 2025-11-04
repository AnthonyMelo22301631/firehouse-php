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
    <h2 class="titulo">Explore os Eventos Publicados</h2>
    <p class="subtitulo">Confira eventos criados pela comunidade FireHouse.</p>

    <!-- 🔹 FILTROS DE PESQUISA -->
    <form method="GET" action="/firehouse-php/public/eventos" 
          style="display:flex; flex-wrap:wrap; gap:10px; margin:25px 0; background:#f8f8f8; padding:15px; border-radius:10px;">
      
      <input type="text" name="tipo" placeholder="Tipo do evento" 
             value="<?= htmlspecialchars($filtros['tipo'] ?? '') ?>"
             style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:150px;">

      <input type="text" name="cidade" placeholder="Cidade"
             value="<?= htmlspecialchars($filtros['cidade'] ?? '') ?>"
             style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:150px;">

      <select name="estado"
              style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:120px;">
        <option value="">Estado</option>
        <?php foreach (['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf): ?>
          <option value="<?= $uf ?>" <?= ($filtros['estado'] ?? '') === $uf ? 'selected' : '' ?>><?= $uf ?></option>
        <?php endforeach; ?>
      </select>

      <select name="status_evento"
              style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:150px;">
        <option value="">Status</option>
        <option value="aberto" <?= ($filtros['status_evento'] ?? '') === 'aberto' ? 'selected' : '' ?>>Aberto</option>
        <option value="em_andamento" <?= ($filtros['status_evento'] ?? '') === 'em_andamento' ? 'selected' : '' ?>>Em andamento</option>
        <option value="finalizado" <?= ($filtros['status_evento'] ?? '') === 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
      </select>

      <input type="date" name="data_min" 
             value="<?= htmlspecialchars($filtros['data_min'] ?? '') ?>"
             style="padding:8px; border-radius:5px; border:1px solid #ccc; flex:1; min-width:160px;">

      <button type="submit" 
              style="background:#007bff; color:white; border:none; border-radius:5px; padding:8px 14px; cursor:pointer;">
        🔍 Filtrar
      </button>

      <a href="/firehouse-php/public/eventos"
         style="color:#555; text-decoration:none; padding:8px 10px;">Limpar</a>
    </form>

    <!-- 🔹 LISTAGEM DE EVENTOS -->
    <?php if (empty($eventos)): ?>
      <p class="aviso">Nenhum evento encontrado com os filtros aplicados.</p>
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

              <p>
                <strong>Status:</strong>
                <span class="status-evento status-<?= htmlspecialchars($e['status_evento'] ?? 'desconhecido') ?>">
                  <?= ucfirst(str_replace('_', ' ', htmlspecialchars($e['status_evento'] ?? 'desconhecido'))) ?>
                </span>

                <?php if (!empty($e['servicos_encontrados'])): ?>
                  <span style="color:#16a34a;font-weight:600;margin-left:6px;">✅ Serviços vinculados</span>
                <?php else: ?>
                  <span style="color:#f59e0b;margin-left:6px;">⏳ Aguardando vínculos</span>
                <?php endif; ?>
              </p>
            </div>

            <div class="card-footer">
              <a class="btn-ver" href="/firehouse-php/public/eventos/view?id=<?= (int)$e['id'] ?>">Ver Detalhes</a>
              
              <?php if (!empty($_SESSION['tipo']) && in_array($_SESSION['tipo'], ['colaborador', 'ambos'])): ?>
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
