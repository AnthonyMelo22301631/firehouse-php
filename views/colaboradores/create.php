<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar Serviço | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/header.css">
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/create-colaboradores.css?v=<?= time(); ?>">
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../partials/header.php';
?>

<main class="conteudo">
  <div class="container">
    <h2 class="titulo">Cadastrar Novo Serviço</h2>
    <p class="descricao">Selecione o tipo de serviço que você oferece e descreva brevemente o que faz.</p>

    <form method="POST" action="/firehouse-php/public/colaboradores/store" class="form-servico">

      <!-- ✅ Campo: Tipo de Serviço (com todas as opções do cliente) -->
      <label for="tipo">Tipo de Serviço</label>
      <select id="tipo" name="nome" required>
        <option value="">Selecione um tipo de serviço</option>

        <!-- Alimentação e Bebidas -->
        <option value="Buffet">Buffet</option>
        <option value="Coquetel">Coquetel</option>
        <option value="Bar de Drinks">Bar de Drinks</option>
        <option value="Churrasco">Churrasco</option>
        <option value="Food Truck">Food Truck</option>

        <!-- Música e Entretenimento -->
        <option value="DJ">DJ</option>
        <option value="Banda Ao Vivo">Banda Ao Vivo</option>
        <option value="Animador">Animador</option>
        <option value="Cerimonialista">Cerimonialista</option>
        <option value="Apresentador">Apresentador</option>

        <!-- Estrutura e Iluminação -->
        <option value="Decoração">Decoração</option>
        <option value="Iluminação">Iluminação</option>
        <option value="Som e Áudio">Som e Áudio</option>
        <option value="Palco">Palco</option>
        <option value="Tenda">Tenda</option>

        <!-- Fotografia e Vídeo -->
        <option value="Fotógrafo">Fotógrafo</option>
        <option value="Filmagem">Filmagem</option>
        <option value="Cabine de Fotos">Cabine de Fotos</option>
        <option value="Drone">Drone</option>

        <!-- Logística e Conforto -->
        <option value="Segurança">Segurança</option>
        <option value="Transporte">Transporte</option>
        <option value="Estacionamento">Estacionamento</option>
        <option value="Banheiro Químico">Banheiro Químico</option>
        <option value="Limpeza">Limpeza</option>

        <!-- Extras -->
        <option value="Brindes Personalizados">Brindes Personalizados</option>
        <option value="Decoração com Balões">Decoração com Balões</option>
        <option value="Flores e Arranjos">Flores e Arranjos</option>
        <option value="Assessoria Completa">Assessoria Completa</option>
        <option value="Locação de Espaço">Locação de Espaço</option>
      </select>

      <!-- Campo: Descrição -->
      <label for="descricao" style="margin-top:20px;">Descrição</label>
      <textarea id="descricao" name="descricao" rows="4" required placeholder="Descreva brevemente o serviço que você oferece."></textarea>

      <!-- Botão -->
      <button type="submit" class="btn-principal">Salvar Serviço</button>
    </form>
  </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
