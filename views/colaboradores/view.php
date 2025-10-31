<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($servico['nome'] ?? 'Serviço') ?> | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/view.css">
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo">
  <div class="container">
    <div class="card-evento">
      <h1 class="titulo">💼 <?= htmlspecialchars($servico['nome'] ?? 'Serviço sem nome') ?></h1>

      <p class="info"><strong>👤 Prestador:</strong> <?= htmlspecialchars($colaborador->nome ?? 'Não informado') ?></p>

      <p class="info">
        <strong>📍 Localização:</strong>
        <?= htmlspecialchars($colaborador->cidade ?? 'Não informado') ?>
        <?= !empty($colaborador->estado) ? ' / ' . htmlspecialchars($colaborador->estado) : '' ?>
      </p>

      <p class="info">
        <strong>📞 Contato:</strong>
        <?php if (!empty($colaborador->contato)): ?>
          <a href="https://wa.me/55<?= preg_replace('/\D/', '', $colaborador->contato) ?>" target="_blank">
            <?= htmlspecialchars($colaborador->contato) ?>
          </a>
        <?php else: ?>
          Não informado
        <?php endif; ?>
      </p>

      <hr>

      <h3 class="subtitulo">🧾 Descrição do Serviço</h3>
      <p class="descricao"><?= nl2br(htmlspecialchars($servico['descricao'] ?? 'Sem descrição disponível.')) ?></p>

      <?php if (!empty($colaborador->experiencia)): ?>
        <h3 class="subtitulo">📚 Experiência</h3>
        <p class="descricao"><?= nl2br(htmlspecialchars($colaborador->experiencia)) ?></p>
      <?php endif; ?>

      <hr>

      <h3 class="subtitulo">🔑 Código do Serviço</h3>
      <p class="codigo-servico" style="font-size:1.2em; background:#f3f3f3; padding:10px; border-radius:6px; display:inline-block;">
        <?= htmlspecialchars($servico['codigo_servico'] ?? 'Não gerado') ?>
        <button onclick="copiarCodigo()" style="margin-left:10px; background:#007bff; color:#fff; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">
          Copiar
        </button>
      </p>

      <script>
      function copiarCodigo() {
        const texto = "<?= htmlspecialchars($servico['codigo_servico'] ?? '') ?>";
        navigator.clipboard.writeText(texto).then(() => alert("Código copiado: " + texto));
      }
      </script>

      <div class="botoes" style="margin-top:20px; display:flex; flex-wrap:wrap; gap:10px;">
        <a href="/firehouse-php/public/colaboradores" class="btn-voltar" style="background:#ddd; color:#000; text-decoration:none; padding:8px 16px; border-radius:6px;">
          ← Voltar
        </a>

        <?php 
          $idPerfil = (int)($servico['user_id'] ?? 0);
          if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] !== $idPerfil && $idPerfil > 0): 
        ?>
          <a href="/firehouse-php/public/auth/perfil?id=<?= $idPerfil ?>" class="btn-contato" style="background:#007bff; color:#fff; text-decoration:none; padding:8px 16px; border-radius:6px;">
            💬 Entrar em contato
          </a>
        <?php endif; ?>

        <?php if (!empty($idPerfil)): ?>
          <a href="/firehouse-php/public/colaboradores/portfolio-public?id=<?= $idPerfil ?>" 
             class="btn-portfolio"
             style="background:#ff7a00; color:#fff; text-decoration:none; padding:8px 16px; border-radius:6px; font-weight:600;">
            📂 Ver portfólio do colaborador
          </a>
        <?php endif; ?>
      </div>

    </div>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
