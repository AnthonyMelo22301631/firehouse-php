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


      <!-- 🔹 SEÇÃO DE SERVIÇOS -->
      <h3 style="margin-top:25px;">Gerenciamento de Serviços</h3>

      <div class="servico-container" style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
        <select name="servico_id" class="form-control servico-select" style="flex:1;">
          <option value="">Selecione um serviço disponível</option>
          <?php foreach ($servicosDisponiveis as $s): ?>
            <option value="<?= $s['id'] ?>">
              <?= htmlspecialchars($s['nome']) ?> — <?= htmlspecialchars($s['colaborador']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <button type="button" id="btnVincular" style="background:#007bff; color:#fff; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;">
          🔗 Vincular
        </button>
        <span id="statusVinculo" style="margin-left:10px;">⏳ Aguardando ação</span>
      </div>

     <h4 style="margin-top:20px;">Serviços vinculados:</h4>

<?php if (!empty($evento['servicos_vinculados'])): ?>
  <ul style="list-style:disc; margin-left:20px;">
    <?php foreach ($evento['servicos_vinculados'] as $v): ?>
      <li>
        <?= htmlspecialchars($v['nome']) ?> — <?= htmlspecialchars($v['colaborador'] ?? '') ?>

        <?php if ($evento['status_evento'] === 'finalizado'): ?>
          <a href="/firehouse-php/public/eventos/avaliar?evento_id=<?= $evento['id'] ?>&servico_id=<?= $v['id'] ?>" 
             style="margin-left:10px; background:#28a745; color:#fff; border:none; padding:5px 10px; border-radius:4px; text-decoration:none;">
             ⭐ Avaliar
          </a>
        <?php else: ?>
          <span style="color:#777; margin-left:10px;">(aguardando finalização do evento)</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p style="color:#777;">Nenhum serviço vinculado ainda.</p>
<?php endif; ?>


      <!-- 🔹 BOTÃO FINALIZAR -->
      <div style="margin-top:25px; display:flex; flex-direction:column; gap:10px;">
        <?php if ($evento['status_evento'] !== 'finalizado'): ?>
          <button type="button" onclick="finalizarEvento()" style="background:#333; color:#fff; border:none; padding:10px; border-radius:6px; cursor:pointer;">⏹ Finalizar evento</button>
        <?php else: ?>
          <p style="color:#28a745; font-weight:600;">✅ Este evento foi finalizado.</p>
        <?php endif; ?>
      </div>
    </form>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<!-- 🔹 SCRIPT PRINCIPAL -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btnVincular = document.getElementById("btnVincular");
  const select = document.querySelector(".servico-select");
  const status = document.getElementById("statusVinculo");
  const eventoId = document.querySelector("input[name='evento_id']").value;

  // ✅ Vincular Serviço
  if (btnVincular) {
    btnVincular.addEventListener("click", async () => {
      const servicoId = select.value;
      if (!servicoId) {
        alert("Selecione um serviço para vincular.");
        return;
      }

      btnVincular.disabled = true;
      btnVincular.innerHTML = "🔄 Vinculando...";
      status.innerHTML = "⏳ Processando...";

      const formData = new FormData();
      formData.append("evento_id", eventoId);
      formData.append("servico_id", servicoId);

      try {
        const response = await fetch("/firehouse-php/public/eventos/vincularServico", {
          method: "POST",
          body: formData
        });

        const data = await response.json();
        if (data.success) {
          status.innerHTML = "✅ Serviço vinculado com sucesso!";
          btnVincular.innerHTML = "✅ Vinculado";
          btnVincular.style.backgroundColor = "#28a745";
          setTimeout(() => window.location.reload(), 1500);
        } else {
          btnVincular.disabled = false;
          btnVincular.innerHTML = "🔗 Vincular";
          status.innerHTML = "❌ " + (data.error || "Erro ao vincular serviço");
        }
      } catch (err) {
        console.error("Erro:", err);
        alert("Erro ao conectar ao servidor.");
        btnVincular.disabled = false;
        btnVincular.innerHTML = "🔗 Vincular";
      }
    });
  }

  // ✅ Finalizar evento
  window.finalizarEvento = async function() {
    if (!confirm("Tem certeza que deseja finalizar este evento?")) return;

    const formData = new FormData();
    formData.append("evento_id", eventoId);

    try {
      const response = await fetch("/firehouse-php/public/eventos/finalizar", {
        method: "POST",
        body: formData
      });
      const data = await response.json();

      if (data.success) {
        alert("Evento finalizado com sucesso!");
        location.reload();
      } else {
        alert(data.error || "Erro ao finalizar evento.");
      }
    } catch (err) {
      console.error(err);
      alert("Erro ao finalizar evento.");
    }
  };

  // ✅ Avaliar serviço
  document.querySelectorAll(".btn-avaliar").forEach(btn => {
    btn.addEventListener("click", () => {
      const servicoId = btn.dataset.servico;
      document.getElementById("avaliar-" + servicoId).style.display = "block";
    });
  });

  document.querySelectorAll(".btn-enviar-avaliacao").forEach(btn => {
    btn.addEventListener("click", async () => {
      const servicoId = btn.dataset.servico;
      const container = document.getElementById("avaliar-" + servicoId);
      const nota = container.querySelector(".nota").value;
      const comentario = container.querySelector(".comentario").value.trim();

      if (!nota || nota < 1 || nota > 5) {
        alert("A nota deve ser entre 1 e 5.");
        return;
      }

      const formData = new FormData();
      formData.append("evento_id", eventoId);
      formData.append("servico_id", servicoId);
      formData.append("nota", nota);
      formData.append("comentario", comentario);

      try {
        const response = await fetch("/firehouse-php/public/eventos/salvarAvaliacao", {
          method: "POST",
          body: formData
        });

        const data = await response.json();
        if (data.success) {
          alert("Avaliação enviada com sucesso!");
          location.reload();
        } else {
          alert(data.error || "Erro ao salvar avaliação.");
        }
      } catch (err) {
        console.error(err);
        alert("Erro ao enviar avaliação.");
      }
    });
  });
});
</script>
</body>
</html>
