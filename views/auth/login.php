<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Entrar | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/login.css?v=<?php echo time(); ?>">
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
    <h2 class="titulo">🔑 Entrar</h2>

    <?php if (!empty($error)): ?>
      <p class="erro"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="/firehouse-php/public/auth/login" class="form-card">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" required>

      <label for="password">Senha</label>
      <input id="password" type="password" name="password" required>

      <button type="submit" class="btn">Entrar</button>
    </form>

    <p class="link-criar">
      Ainda não tem uma conta?
      <a href="/firehouse-php/public/auth/register">Criar conta</a>
    </p>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
