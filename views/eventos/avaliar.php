<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliar Serviço | FireHouse</title>
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/avaliar.css?v=<?php echo time(); ?>">
</head>
<body>

<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo" style="padding:30px; max-width:700px; margin:auto;">
  <h2 style="text-align:center;">Avaliar Serviço</h2>

  <div style="background:#f8f8f8; padding:15px; border-radius:8px; margin-top:20px;">
    <p><strong>Evento:</strong> <?= htmlspecialchars($evento['titulo']) ?></p>
    <p><strong>Serviço:</strong> <?= htmlspecialchars($servico['nome']) ?></p>
    <p><strong>Colaborador:</strong> <?= htmlspecialchars($servico['nome_colaborador']) ?></p>
  </div>
  <form id="formAvaliacao" style="margin-top:20px;">
    <input type="hidden" name="evento_id" value="<?= $evento['id'] ?>">
    <input type="hidden" name="servico_id" value="<?= $servico['id'] ?>">
<input type="hidden" name="colaborador_id" value="<?= $colaborador_id ?? '' ?>">
    <label>Nota (1 a 5):</label>
    <input type="number" name="nota" min="1" max="5" required style="width:70px; margin-bottom:10px;">

    <label>Comentário:</label>
    <textarea name="comentario" placeholder="Escreva um comentário opcional..." 
              style="width:100%; height:100px; margin-bottom:15px;"></textarea>

    <button type="submit" 
            style="background:#28a745; color:#fff; border:none; padding:10px 18px; border-radius:6px; cursor:pointer;">
      Enviar Avaliação
    </button>

    <span id="statusMsg" style="margin-left:10px;"></span>
  </form>
</main>

<script>
const BASE_URL = '<?php echo '/firehouse-php/public'; ?>';

document.getElementById("formAvaliacao").addEventListener("submit", async (e) => {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const status = document.getElementById("statusMsg");

  status.innerHTML = "⏳ Enviando...";

  try {
    const response = await fetch(BASE_URL + "/eventos/salvarAvaliacao", {
      method: "POST",
      body: formData
    });
    
    if (!response.ok) {
        throw new Error(`Erro de rede ou servidor: Status ${response.status}`);
    }

    const data = await response.json();

    if (data.success) {
      status.innerHTML = "✅ Avaliação salva com sucesso!";
      setTimeout(() => {
window.location.href = BASE_URL + "/colaboradores/portfolio?colaborador_id=" + formData.get("colaborador_id");
      }, 1500);
    } else {
      status.innerHTML = "❌ " + (data.error || "Erro ao salvar.");
    }
  } catch (err) {
    console.error("Erro:", err);
    // Mensagem de erro mais clara, se necessário
    status.innerHTML = "❌ Erro de conexão com o servidor. (Verifique console para detalhes)";
  }
});
</script>

</body>
</html>