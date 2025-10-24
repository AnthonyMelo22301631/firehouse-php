<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Evento | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/edit.css?v=<?= time(); ?>">
</head>

<body>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__ . '/../partials/header.php';

use App\Repositories\EventoRepository;
$repo = new EventoRepository();
$servicosVinculados = $repo->getServicosVinculados($evento['id']);
?>

<main class="conteudo">
  <section class="hero-create">
    <div class="hero-texto">
      <h1>Editar Evento</h1>
      <p>Atualize as informações e gerencie os serviços vinculados ao seu evento.</p>
    </div>
  </section>

  <section class="form-section">
    <div class="container">
      <form method="post" action="/firehouse-php/public/eventos/update" class="form-card">
        <input type="hidden" name="id" value="<?= htmlspecialchars($evento['id']) ?>">

        <h2>Detalhes do Evento</h2>

        <div class="form-group">
          <label for="titulo">Título</label>
          <input id="titulo" type="text" name="titulo" value="<?= htmlspecialchars($evento['titulo']) ?>" required>
        </div>

        <div class="form-group">
          <label for="tipo">Tipo</label>
          <input id="tipo" type="text" name="tipo" value="<?= htmlspecialchars($evento['tipo']) ?>" required>
        </div>

        <div class="form-group">
          <label for="local">Local</label>
          <input id="local" type="text" name="local" value="<?= htmlspecialchars($evento['local']) ?>" required>
        </div>

        <div class="form-row">
          <div class="form-group half">
            <label for="estado">Estado</label>
            <input id="estado" type="text" name="estado" value="<?= htmlspecialchars($evento['estado']) ?>" required>
          </div>
          <div class="form-group half">
            <label for="cidade">Cidade</label>
            <input id="cidade" type="text" name="cidade" value="<?= htmlspecialchars($evento['cidade']) ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label for="data_evento">Data e horário</label>
          <input id="data_evento" type="datetime-local" name="data_evento"
                 value="<?= date('Y-m-d\TH:i', strtotime($evento['data_evento'])) ?>" required>
        </div>

        <div class="form-group">
          <label>Serviços desejados</label>
          <div class="checkbox-group">
            <?php
            $selecionados = array_map('trim', explode(',', $evento['servicos'] ?? ''));
            $servicos = [
              "Buffet","Coquetel","Bar de Drinks","Churrasco","Food Truck",
              "DJ","Banda Ao Vivo","Animador","Cerimonialista","Apresentador",
              "Decoração","Iluminação","Som e Áudio","Palco","Tenda",
              "Fotógrafo","Filmagem","Cabine de Fotos","Drone",
              "Segurança","Transporte","Estacionamento","Banheiro Químico","Limpeza",
              "Brindes Personalizados","Decoração com Balões","Flores e Arranjos","Assessoria Completa","Locação de Espaço"
            ];
            foreach ($servicos as $s) {
              $checked = in_array($s, $selecionados) ? "checked" : "";
              echo "<label><input type='checkbox' name='servicos[]' value='$s' $checked> $s</label>";
            }
            ?>
          </div>
        </div>

        <!-- 🔹 Gerenciamento individual de vinculação -->
        <div class="form-group">
          <label style="margin-top:20px;">Gerenciamento dos serviços vinculados</label>
          <ul class="lista-servicos">
            <?php 
            $servicos = array_map('trim', explode(',', $evento['servicos'] ?? ''));
            if (!empty($servicos)):
              foreach ($servicos as $s):
                $isVinculado = in_array($s, $servicosVinculados);
            ?>
              <li style="margin-bottom:10px;">
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                  <span style="font-weight:600;min-width:120px;"><?= htmlspecialchars($s) ?></span>

                  <input type="text" 
                    class="codigo-input" 
                    placeholder="Código (Ex: SRV-123ABC)" 
                    data-servico="<?= htmlspecialchars($s) ?>" 
                    <?= $isVinculado ? 'disabled' : '' ?>
                    style="flex:1;min-width:180px;padding:6px 8px;border:1px solid #ccc;border-radius:6px;">

                  <?php if (!$isVinculado): ?>
                    <button type="button"
                            class="btn-vincular"
                            data-evento="<?= (int)$evento['id'] ?>"
                            data-servico="<?= htmlspecialchars($s) ?>"
                            style="background:#007bff;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">
                      🔗 Vincular
                    </button>
                  <?php endif; ?>

                  <span class="status-servico" style="margin-left:10px;<?= $isVinculado ? 'color:#16a34a;' : 'color:#555;' ?>">
                    <?= $isVinculado ? '✅ Vinculado' : '⏳ Pendente' ?>
                  </span>
                </div>
              </li>
            <?php 
              endforeach;
            else: ?>
              <li style="color:#666;">Nenhum serviço cadastrado.</li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- 🔹 Botões de controle -->
        <div style="margin-top:25px;">
          <button type="button" id="btnProsseguir" class="btn-prosseguir">
            🚀 Prosseguir evento
          </button>

          <button type="button" id="btnFinalizar" data-evento="<?= (int)$evento['id'] ?>" class="btn-finalizar" style="margin-left:10px;">
            🏁 Finalizar evento
          </button>
        </div>

        <div class="form-group" style="margin-top:25px;">
          <label for="descricao">Descrição</label>
          <textarea id="descricao" name="descricao" rows="5"><?= htmlspecialchars($evento['descricao']) ?></textarea>
        </div>

        <div class="botoes">
          <a href="/firehouse-php/public/meus-eventos" class="btn-cancelar">Cancelar</a>
          <button type="submit" class="btn-enviar">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<script>
document.querySelectorAll('.btn-vincular').forEach(btn => {
  btn.addEventListener('click', async () => {
    const servico = btn.dataset.servico;
    const evento = btn.dataset.evento;
    const input = document.querySelector(`.codigo-input[data-servico="${servico}"]`);
    const codigo = input?.value.trim();

    if (!codigo) {
      alert(`Digite o código do serviço: ${servico}`);
      return;
    }

    btn.disabled = true;
    btn.textContent = '🔄 Vinculando...';

    const resp = await fetch('/firehouse-php/public/eventos/vincularPorCodigo', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `evento_id=${evento}&codigo_servico=${encodeURIComponent(codigo)}`
    });

    const data = await resp.json();
    if (data.success) {
      input.disabled = true;
      const status = btn.parentElement.querySelector('.status-servico');
      status.textContent = '✅ Vinculado';
      status.style.color = '#16a34a';
      btn.remove();
    } else {
      alert(data.error || 'Erro ao vincular serviço');
      btn.disabled = false;
      btn.textContent = '🔗 Vincular';
    }
  });
});

document.getElementById('btnProsseguir').addEventListener('click', async () => {
  const eventoId = document.querySelector('input[name="id"]').value;
  const ok = confirm("Deseja prosseguir com o evento? Isso o colocará como 'Em andamento'.");
  if (!ok) return;

  const resp = await fetch('/firehouse-php/public/eventos/atualizar-status', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `evento_id=${encodeURIComponent(eventoId)}&status_evento=em_andamento`
  });
  const data = await resp.json();
  if (data.success) {
    alert('Evento marcado como Em andamento! 🚀');
    location.reload();
  } else {
    alert('Erro ao atualizar o status.');
  }
});

document.getElementById('btnFinalizar').addEventListener('click', async () => {
  const eventoId = document.querySelector('input[name="id"]').value;
  const ok = confirm("Tem certeza que deseja finalizar o evento?");
  if (!ok) return;

  const resp = await fetch('/firehouse-php/public/eventos/atualizar-status', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `evento_id=${encodeURIComponent(eventoId)}&status_evento=finalizado`
  });
  const data = await resp.json();
  if (data.success) {
    alert('✅ Evento finalizado com sucesso! Agora você será redirecionado para avaliar os colaboradores.');
    window.location.href = `/firehouse-php/public/eventos/feedback?id=${encodeURIComponent(eventoId)}`;
  } else {
    alert('Erro ao finalizar o evento.');
  }
});
</script>
</body>
</html>
