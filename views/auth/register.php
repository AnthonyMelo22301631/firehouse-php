<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/register.css?v=<?php echo time(); ?>">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">📝 Criar Conta</h2>

    <?php if (!empty($error)): ?>
      <p class="erro"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="/firehouse-php/public/auth/register" class="form-card">
      <label for="nome">Nome completo</label>
      <input id="nome" type="text" name="nome" placeholder="Seu nome completo" required>

      <label for="estado">Estado</label>
      <select id="estado" name="estado" required>
        <option value="">Selecione o estado</option>
      </select>

      <label for="cidade">Cidade</label>
      <select id="cidade" name="cidade" required>
        <option value="">Selecione a cidade</option>
      </select>

      <label for="contato">Número de contato</label>
      <input id="contato" type="text" name="contato" placeholder="(99) 99999-9999" required>

      <label for="email">Email</label>
      <input id="email" type="email" name="email" placeholder="exemplo@email.com" required>

      <label for="password">Senha (mínimo 6 caracteres)</label>
      <input id="password" type="password" name="password" minlength="6" required>

      <button type="submit" class="btn">Cadastrar</button>
    </form>

    <p class="link-login">
      Já possui uma conta?
      <a href="/firehouse-php/public/auth/login">Entrar</a>
    </p>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

<!-- Script para carregar estados e cidades via API IBGE -->
<script>
  async function carregarEstados() {
    const estadoSelect = document.getElementById('estado');
    const resposta = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');
    const estados = await resposta.json();

    estados.forEach(uf => {
      const option = document.createElement('option');
      option.value = uf.id; // <-- agora guarda o ID correto do estado
      option.textContent = uf.nome;
      estadoSelect.appendChild(option);
    });
  }

  async function carregarCidades() {
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');
    cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';

    const ufId = estadoSelect.value;
    if (!ufId) return;

    const resposta = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${ufId}/municipios`);
    const cidades = await resposta.json();

    cidades.forEach(cidade => {
      const option = document.createElement('option');
      option.value = cidade.nome;
      option.textContent = cidade.nome;
      cidadeSelect.appendChild(option);
    });
  }

  document.getElementById('estado').addEventListener('change', carregarCidades);
  carregarEstados();
</script>

</body>
</html>
