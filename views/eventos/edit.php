<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Evento | FireHouse</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/edit.css?v=<?php echo time(); ?>">
</head>

<body>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo" style="padding: 20px;">
  <div class="container" style="max-width: 850px; margin:auto;">
    <h1 style="text-align:center; font-weight:700;">Editar Evento</h1>

    <form id="formEditarEvento" method="POST" action="/firehouse-php/public/eventos/update" style="margin-top:25px;">
      <input type="hidden" name="id" value="<?= htmlspecialchars($evento['id']) ?>">
      <input type="hidden" name="evento_id" value="<?= htmlspecialchars($evento['id']) ?>">

      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" required value="<?= htmlspecialchars($evento['titulo'] ?? '') ?>" class="form-control" style="width:100%; margin-bottom:10px;">

      <label for="tipo">Tipo:</label>
      <input type="text" name="tipo" id="tipo" value="<?= htmlspecialchars($evento['tipo'] ?? '') ?>" class="form-control" style="width:100%; margin-bottom:10px;">

      <label for="local">Local:</label>
      <input type="text" name="local" id="local" value="<?= htmlspecialchars($evento['local'] ?? '') ?>" class="form-control" style="width:100%; margin-bottom:10px;">

      <label for="cidade">Cidade:</label>
      <input type="text" name="cidade" id="cidade" value="<?= htmlspecialchars($evento['cidade'] ?? '') ?>" class="form-control" style="width:100%; margin-bottom:10px;">

      <label for="estado">Estado:</label>
      <input type="text" name="estado" id="estado" value="<?= htmlspecialchars($evento['estado'] ?? '') ?>" class="form-control" style="width:100%; margin-bottom:10px;">

      <h3 style="margin-top:25px;">Gerenciamento dos serviços vinculados</h3>

      <?php
$servicosSelecionados = $evento['servicos_array'] ?? [];
if (empty($servicosSelecionados)) {
    echo "<p style='color:#777;'>Nenhum serviço foi selecionado ao criar o evento.</p>";
} else {
    foreach ($servicosSelecionados as $servicoNome):
        $jaVinculado = false;
        if (!empty($evento['servicos_vinculados'])) {
            foreach ($evento['servicos_vinculados'] as $s) {
                // ✅ Marca como vinculado apenas se o serviço pertencer a este evento
                if (
                    (int)$s['evento_id'] === (int)$evento['id'] &&
                    strcasecmp($s['nome'], $servicoNome) === 0
                ) {
                    $jaVinculado = true;
                    break;
                }
            }
        }
?>
      <div class="servico-container" style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
        <label style="width:140px; font-weight:600;"><?= htmlspecialchars($servicoNome) ?></label>

        <?php if ($jaVinculado): ?>
          <input type="text" value="Serviço já vinculado" disabled style="flex:1; background:#e8ffe8; border:1px solid #28a745; padding:6px;">
          <button type="button" disabled style="background:#28a745; color:#fff; border:none; padding:6px 12px; border-radius:5px;">✅ Vinculado</button>
        <?php else: ?>
          <input type="text" name="codigo_servico" placeholder="Código (Ex: SRV-123ABC)" class="form-control" style="flex:1;">
          <button type="button" class="btn-vincular" style="background:#007bff; color:#fff; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;">🔗 Vincular</button>
          <span class="status-vinculo" style="margin-left:10px;">⏳ Pendente</span>
        <?php endif; ?>
      </div>
      <?php endforeach; } ?>

      <div style="margin-top:25px; display:flex; flex-direction:column; gap:10px;">
        
        <button type="button" onclick="finalizarEvento()" style="background:#333; color:#fff; border:none; padding:10px; border-radius:6px; cursor:pointer;">⏹ Finalizar evento</button>
      </div>
    </form>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const botoesVincular = document.querySelectorAll(".btn-vincular");

  botoesVincular.forEach(botao => {
    botao.addEventListener("click", async () => {
      const container = botao.closest(".servico-container");
      const input = container.querySelector("input[name='codigo_servico']");
      const status = container.querySelector(".status-vinculo");
      const codigo = input.value.trim();
      const eventoId = document.querySelector("input[name='evento_id']").value;

      if (!codigo) {
        alert("Digite o código do serviço (ex: SRV-123ABC).");
        return;
      }

      botao.disabled = true;
      botao.innerHTML = "🔄 Vinculando...";
      status.innerHTML = "⏳ Pendente";

      try {
        const formData = new FormData();
        formData.append("evento_id", eventoId);
        formData.append("codigo_servico", codigo);

        const response = await fetch("/firehouse-php/public/eventos/vincularPorCodigo", {
          method: "POST",
          body: formData
        });

        let data;
        try {
          data = await response.json();
        } catch (jsonError) {
          console.error("⚠️ Erro ao interpretar JSON:", jsonError);
          alert("Erro inesperado na resposta do servidor.");
          botao.disabled = false;
          botao.innerHTML = "🔗 Vincular";
          status.innerHTML = "❌ Erro inesperado";
          return;
        }

        if (data.success) {
          botao.innerHTML = "✅ Vinculado";
          botao.style.backgroundColor = "#28a745";
          status.innerHTML = "🟢 Confirmado";
          input.disabled = true;
          console.log("✅ Serviço vinculado com sucesso!");
          setTimeout(() => window.location.reload(), 800);
        } else {
          botao.disabled = false;
          botao.innerHTML = "🔗 Vincular";
          status.innerHTML = "❌ " + (data.error || "Erro ao vincular serviço");
          alert(data.error || "Erro ao vincular serviço.");
        }
      } catch (err) {
        console.error("🚨 Erro na conexão ou requisição:", err);
        botao.disabled = false;
        botao.innerHTML = "🔗 Vincular";
        status.innerHTML = "❌ Erro de conexão";
        alert("Erro ao conectar ao servidor.");
      }
    });
  });
});
</script>
<script>
async function finalizarEvento() {
  const eventoId = document.querySelector("input[name='evento_id']").value;

  if (!confirm("Tem certeza que deseja finalizar este evento?")) return;

  const formData = new FormData();
  formData.append("evento_id", eventoId);

  try {
    const response = await fetch("/firehouse-php/public//eventos/finalizar", {
      method: "POST",
      body: formData
    });
    const data = await response.json();

    if (data.success) {
      if (data.redirect) {
        window.location.href = data.redirect; // ✅ vai para feedback
      } else {
        alert("Evento finalizado com sucesso!");
        location.reload();
      }
    } else {
      alert(data.error || "Erro ao finalizar evento.");
    }
  } catch (err) {
    console.error(err);
    alert("Erro na requisição.");
  }
}
</script>


</body>
</html>
