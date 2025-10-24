<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Meu Perfil | FireHouse</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/perfil.css?v=<?php echo time(); ?>">
</head>
<body>
  <?php
$estadosBrasil = [
  "12" => "Acre",
  "27" => "Alagoas",
  "13" => "Amazonas",
  "16" => "Amapá",
  "29" => "Bahia",
  "23" => "Ceará",
  "53" => "Distrito Federal",
  "32" => "Espírito Santo",
  "52" => "Goiás",
  "21" => "Maranhão",
  "31" => "Minas Gerais",
  "50" => "Mato Grosso do Sul",
  "51" => "Mato Grosso",
  "15" => "Pará",
  "25" => "Paraíba",
  "26" => "Pernambuco",
  "22" => "Piauí",
  "41" => "Paraná",
  "33" => "Rio de Janeiro",
  "24" => "Rio Grande do Norte",
  "43" => "Rio Grande do Sul",
  "11" => "Rondônia",
  "14" => "Roraima",
  "42" => "Santa Catarina",
  "35" => "São Paulo",
  "28" => "Sergipe",
  "17" => "Tocantins"
];
?>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php require __DIR__ . '/../partials/header.php'; ?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">
      <?= $isOwner ? '🙍 Meu Perfil' : '👤 Perfil do Usuário' ?>
    </h2>

    <section class="card perfil">
      <div class="avatar" aria-hidden="true">
        <?php
          $nome = $user->nome ?? $user->name ?? '';
          $ini  = function_exists('mb_substr') ? mb_substr($nome, 0, 1, 'UTF-8') : substr($nome, 0, 1);
          echo htmlspecialchars(mb_strtoupper($ini, 'UTF-8'));
        ?>
      </div>

      <div class="info">
        <div class="linha">
          <span class="label">Nome:</span>
          <span class="valor"><?= htmlspecialchars($user->nome ?? $user->name) ?></span>
        </div>

        <div class="linha">
          <span class="label">Email:</span>
          <span class="valor"><?= htmlspecialchars($user->email) ?></span>
        </div>

        <?php if (!empty($user->estado)): ?>
          <div class="linha">
            <span class="label">Estado:</span>
    <span class="valor">
  <?= htmlspecialchars($estadosBrasil[$user->estado] ?? $user->estado) ?>
</span>
          </div>
        <?php endif; ?>

        <?php if (!empty($user->cidade)): ?>
          <div class="linha">
            <span class="label">Cidade:</span>
            <span class="valor"><?= htmlspecialchars($user->cidade) ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($user->contato)): ?>
          <div class="linha">
            <span class="label">Contato:</span>
            <a class="valor" href="https://wa.me/55<?= preg_replace('/\D/', '', $user->contato) ?>" target="_blank">
              <?= htmlspecialchars($user->contato) ?>
            </a>
          </div>
        <?php endif; ?>

        <div class="linha">
          <span class="label">Tipo de conta:</span>
          <span class="valor">
            <?= ($_SESSION['is_colaborador'] ?? false) ? 'Colaborador' : 'Cliente' ?>
          </span>
        </div>
      </div>

      <?php if ($isOwner): ?>
        <div class="acoes">
          <a class="btn secundario" href="/firehouse-php/public/eventos/my">Meus eventos</a>
          <a class="btn primario" href="/firehouse-php/public/eventos/create">Criar evento</a>

          <?php if (empty($_SESSION['is_colaborador'])): ?>
            <form method="POST" action="/firehouse-php/public/colaboradores/ativar" style="display:inline;">
              <button type="submit" class="btn secundario">Tornar-se colaborador</button>
            </form>
          <?php else: ?>
            <form method="POST" action="/firehouse-php/public/colaboradores/sair" style="display:inline;">
              <button type="submit" class="btn danger">Sair do modo colaborador</button>
            </form>
          <?php endif; ?>

          <a class="btn danger" href="/firehouse-php/public/auth/logout">🚪 Sair</a>
        </div>
      <?php endif; ?>
    </section>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
