<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliação do Evento | FireHouse</title>
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?= time(); ?>">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fb;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 720px;
      margin: 50px auto;
      background: white;
      border-radius: 14px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      padding: 30px;
    }
    h1 {
      font-size: 22px;
      text-align: center;
      margin-bottom: 20px;
    }
    .colaborador-card {
      border: 1px solid #eee;
      padding: 16px;
      border-radius: 8px;
      margin-bottom: 20px;
      background: #fafafa;
    }
    .colaborador-card h3 {
      margin: 0 0 10px;
    }
    .estrelas {
      display: flex;
      gap: 4px;
      cursor: pointer;
    }
    .estrela {
      font-size: 22px;
      color: #ccc;
      transition: color 0.2s;
    }
    .estrela.ativa {
      color: #FFD700;
    }
    textarea {
      width: 100%;
      border-radius: 8px;
      border: 1px solid #ddd;
      padding: 10px;
      resize: vertical;
      font-family: 'Poppins', sans-serif;
      margin-top: 10px;
    }
    .btn-enviar {
      display: block;
      width: 100%;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-enviar:hover {
      background: #0056d2;
    }
  </style>
</head>
<body>

<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="container">
  <h1>📝 Avalie os Colaboradores deste Evento</h1>
  <p style="text-align:center; color:#555;">Sua opinião ajuda outros clientes e melhora o portfólio dos colaboradores.</p>
  <hr style="margin:20px 0;">

  <form id="formFeedback" method="POST" action="/firehouse-php/public/eventos/salvarFeedback">
    <input type="hidden" name="evento_id" value="<?= (int)$evento['id'] ?>">

    <?php if (!empty($colaboradores)): ?>
      <?php foreach ($colaboradores as $c): ?>
        <div class="colaborador-card">
          <h3><?= htmlspecialchars($c['nome']) ?> — <small><?= htmlspecialchars($c['servico_nome'] ?? '') ?></small></h3>

          <div class="estrelas" data-colaborador="<?= $c['id'] ?>">
            <?php for ($i=1; $i<=5; $i++): ?>
              <span class="estrela" data-valor="<?= $i ?>">★</span>
            <?php endfor; ?>
          </div>

          <input type="hidden" name="avaliacoes[<?= $c['id'] ?>][nota]" value="0">
          <textarea name="avaliacoes[<?= $c['id'] ?>][comentario]" rows="3" placeholder="Deixe um comentário sobre este colaborador (opcional)..."></textarea>
        </div>
      <?php endforeach; ?>

      <button type="submit" class="btn-enviar">Enviar Avaliações</button>
    <?php else: ?>
      <p>❌ Nenhum colaborador vinculado a este evento.</p>
    <?php endif; ?>
  </form>
</div>

<script>
  // Sistema de estrelas interativo
  document.querySelectorAll('.estrelas').forEach(estrelas => {
    const inputHidden = estrelas.parentElement.querySelector('input[type="hidden"]');
    estrelas.querySelectorAll('.estrela').forEach(estrela => {
      estrela.addEventListener('click', () => {
        const valor = parseInt(estrela.dataset.valor);
        inputHidden.value = valor;

        estrelas.querySelectorAll('.estrela').forEach(e => {
          e.classList.toggle('ativa', parseInt(e.dataset.valor) <= valor);
        });
      });
    });
  });
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
