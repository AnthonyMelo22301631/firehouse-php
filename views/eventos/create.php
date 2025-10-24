<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Evento | FireHouse</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="/firehouse-php/public/assets/css/create.css?v=<?php echo time(); ?>">
</head>

<body>
  <?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  require __DIR__ . '/../partials/header.php';
  ?>

  <main class="conteudo">
    <section class="hero-create">
      <div class="hero-texto">
        <h1>Crie Seu Evento</h1>
        <p>Compartilhe sua ideia e permita que colaboradores se conectem ao seu projeto.</p>
      </div>
    </section>

    <section class="form-section">
      <div class="container">
        <form method="post" action="/firehouse-php/public/eventos/store" class="form-card">
          <h2>Detalhes do Evento</h2>

          <div class="form-group">
            <label for="titulo">Título do evento</label>
            <input id="titulo" type="text" name="titulo" placeholder="Ex: Festa de casamento ao ar livre" required>
          </div>

          <!-- Tipos de Evento -->
          <div class="form-group">
            <label for="tipo">Tipo de evento</label>
            <select id="tipo" name="tipo" required>
              <option value="">-- Selecione o tipo de evento --</option>

              <optgroup label="🎉 Festas e Comemorações">
                <option value="Aniversário">Aniversário</option>
                <option value="Casamento">Casamento</option>
                <option value="Chá de Bebê">Chá de Bebê</option>
                <option value="Chá de Panela">Chá de Panela</option>
                <option value="Festa de 15 Anos">Festa de 15 Anos</option>
                <option value="Formatura">Formatura</option>
                <option value="Festa Infantil">Festa Infantil</option>
                <option value="Festa Junina">Festa Junina</option>
                <option value="Bodas">Bodas</option>
                <option value="Festa Temática">Festa Temática</option>
                <option value="Réveillon">Réveillon</option>
                <option value="Natal">Natal</option>
                <option value="Halloween">Halloween</option>
              </optgroup>

              <optgroup label="🏢 Corporativos e Empresariais">
                <option value="Confraternização Empresarial">Confraternização Empresarial</option>
                <option value="Lançamento de Produto">Lançamento de Produto</option>
                <option value="Feira de Negócios">Feira de Negócios</option>
                <option value="Workshop">Workshop</option>
                <option value="Treinamento">Treinamento</option>
                <option value="Seminário">Seminário</option>
                <option value="Congresso">Congresso</option>
                <option value="Palestra">Palestra</option>
                <option value="Reunião Corporativa">Reunião Corporativa</option>
                <option value="Team Building">Team Building</option>
                <option value="Evento de Networking">Evento de Networking</option>
              </optgroup>

              <optgroup label="🎭 Culturais e Artísticos">
                <option value="Show Musical">Show Musical</option>
                <option value="Festival">Festival</option>
                <option value="Exposição">Exposição</option>
                <option value="Teatro">Teatro</option>
                <option value="Cinema">Sessão de Cinema</option>
                <option value="Feira de Arte">Feira de Arte</option>
                <option value="Feira Literária">Feira Literária</option>
                <option value="Encontro Cultural">Encontro Cultural</option>
              </optgroup>

              <optgroup label="🏫 Acadêmicos e Educacionais">
                <option value="Formatura Escolar">Formatura Escolar</option>
                <option value="Feira de Ciências">Feira de Ciências</option>
                <option value="Simpósio">Simpósio</option>
                <option value="Semana Acadêmica">Semana Acadêmica</option>
                <option value="Apresentação de TCC">Apresentação de TCC</option>
                <option value="Palestra Educacional">Palestra Educacional</option>
              </optgroup>

              <optgroup label="🙏 Religiosos e Comunitários">
                <option value="Batizado">Batizado</option>
                <option value="Primeira Comunhão">Primeira Comunhão</option>
                <option value="Culto">Culto</option>
                <option value="Missa">Missa</option>
                <option value="Casamento Religioso">Casamento Religioso</option>
                <option value="Evento Beneficente">Evento Beneficente</option>
                <option value="Encontro de Jovens">Encontro de Jovens</option>
              </optgroup>

              <optgroup label="⚽ Esportivos">
                <option value="Campeonato">Campeonato</option>
                <option value="Corrida de Rua">Corrida de Rua</option>
                <option value="Aulão Fitness">Aulão Fitness</option>
                <option value="Evento de Artes Marciais">Evento de Artes Marciais</option>
                <option value="Competição">Competição</option>
              </optgroup>

              <optgroup label="💼 Outros">
                <option value="Encontro Familiar">Encontro Familiar</option>
                <option value="Evento Social">Evento Social</option>
                <option value="Evento Privado">Evento Privado</option>
                <option value="Outro">Outro</option>
              </optgroup>
            </select>
          </div>

        <div class="form-group">
  <label for="local">Tipo de local</label>
  <select id="local" name="local" required>
    <option value="">-- Selecione o local do evento --</option>

    <optgroup label="🏠 Espaços Tradicionais">
      <option value="Salão de Festas">Salão de Festas</option>
      <option value="Buffet">Buffet</option>
      <option value="Hotel">Hotel</option>
      <option value="Sítio">Sítio</option>
      <option value="Fazenda">Fazenda</option>
      <option value="Clube">Clube</option>
      <option value="Casa de Eventos">Casa de Eventos</option>
    </optgroup>

    <optgroup label="🏢 Corporativos e Urbanos">
      <option value="Auditório">Auditório</option>
      <option value="Centro de Convenções">Centro de Convenções</option>
      <option value="Espaço Coworking">Espaço Coworking</option>
      <option value="Sala de Reunião">Sala de Reunião</option>
      <option value="Restaurante">Restaurante</option>
      <option value="Bar ou Pub">Bar ou Pub</option>
      <option value="Shopping">Shopping</option>
    </optgroup>

    <optgroup label="🌿 Ao Ar Livre">
      <option value="Praia">Praia</option>
      <option value="Parque">Parque</option>
      <option value="Jardim">Jardim</option>
      <option value="Chácara">Chácara</option>
      <option value="Campo">Campo</option>
      <option value="Lago ou Represa">Lago ou Represa</option>
      <option value="Montanha">Montanha</option>
    </optgroup>

    <optgroup label="🎭 Culturais e Públicos">
      <option value="Teatro">Teatro</option>
      <option value="Cinema">Cinema</option>
      <option value="Museu">Museu</option>
      <option value="Galeria de Arte">Galeria de Arte</option>
      <option value="Praça Pública">Praça Pública</option>
      <option value="Centro Comunitário">Centro Comunitário</option>
      <option value="Escola ou Universidade">Escola ou Universidade</option>
    </optgroup>

    <optgroup label="⛪ Religiosos e Cerimoniais">
      <option value="Igreja">Igreja</option>
      <option value="Templo">Templo</option>
      <option value="Capela">Capela</option>
      <option value="Centro Espírita">Centro Espírita</option>
      <option value="Espaço Ecumênico">Espaço Ecumênico</option>
    </optgroup>

    <optgroup label="⚽ Esportivos">
      <option value="Quadra Esportiva">Quadra Esportiva</option>
      <option value="Ginásio">Ginásio</option>
      <option value="Estádio">Estádio</option>
      <option value="Campo de Futebol">Campo de Futebol</option>
      <option value="Arena Multiuso">Arena Multiuso</option>
    </optgroup>

    <optgroup label="💼 Outros">
      <option value="Local Privado">Local Privado</option>
      <option value="Residência">Residência</option>
      <option value="Espaço Personalizado">Espaço Personalizado</option>
      <option value="Outro">Outro</option>
    </optgroup>
  </select>
</div>


          <!-- Estado e Cidade -->
          <div class="form-row">
            <div class="form-group half">
              <label for="estado">Estado</label>
              <select id="estado" name="estado" required>
                <option value="">-- Selecione o estado --</option>
              </select>
            </div>

            <div class="form-group half">
              <label for="cidade">Cidade</label>
              <select id="cidade" name="cidade" required disabled>
                <option value="">-- Selecione o estado primeiro --</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="data_evento">Data e horário</label>
            <input id="data_evento" type="datetime-local" name="data_evento" required>
          </div>

          <!-- Serviços desejados -->
          <div class="form-group">
            <label>Serviços desejados</label>
            <div class="checkbox-group">
              <!-- Alimentação e Bebidas -->
              <label><input type="checkbox" name="servicos[]" value="Buffet"> Buffet</label>
              <label><input type="checkbox" name="servicos[]" value="Coquetel"> Coquetel</label>
              <label><input type="checkbox" name="servicos[]" value="Bar de Drinks"> Bar de Drinks</label>
              <label><input type="checkbox" name="servicos[]" value="Churrasco"> Churrasco</label>
              <label><input type="checkbox" name="servicos[]" value="Food Truck"> Food Truck</label>

              <!-- Música e Entretenimento -->
              <label><input type="checkbox" name="servicos[]" value="DJ"> DJ</label>
              <label><input type="checkbox" name="servicos[]" value="Banda Ao Vivo"> Banda Ao Vivo</label>
              <label><input type="checkbox" name="servicos[]" value="Animador"> Animador</label>
              <label><input type="checkbox" name="servicos[]" value="Cerimonialista"> Cerimonialista</label>
              <label><input type="checkbox" name="servicos[]" value="Apresentador"> Apresentador</label>

              <!-- Estrutura e Iluminação -->
              <label><input type="checkbox" name="servicos[]" value="Decoração"> Decoração</label>
              <label><input type="checkbox" name="servicos[]" value="Iluminação"> Iluminação</label>
              <label><input type="checkbox" name="servicos[]" value="Som e Áudio"> Som e Áudio</label>
              <label><input type="checkbox" name="servicos[]" value="Palco"> Palco</label>
              <label><input type="checkbox" name="servicos[]" value="Tenda"> Tenda</label>

              <!-- Fotografia e Vídeo -->
              <label><input type="checkbox" name="servicos[]" value="Fotógrafo"> Fotógrafo</label>
              <label><input type="checkbox" name="servicos[]" value="Filmagem"> Filmagem</label>
              <label><input type="checkbox" name="servicos[]" value="Cabine de Fotos"> Cabine de Fotos</label>
              <label><input type="checkbox" name="servicos[]" value="Drone"> Drone</label>

              <!-- Logística e Conforto -->
              <label><input type="checkbox" name="servicos[]" value="Segurança"> Segurança</label>
              <label><input type="checkbox" name="servicos[]" value="Transporte"> Transporte</label>
              <label><input type="checkbox" name="servicos[]" value="Estacionamento"> Estacionamento</label>
              <label><input type="checkbox" name="servicos[]" value="Banheiro Químico"> Banheiro Químico</label>
              <label><input type="checkbox" name="servicos[]" value="Limpeza"> Limpeza</label>

              <!-- Extras -->
              <label><input type="checkbox" name="servicos[]" value="Brindes Personalizados"> Brindes Personalizados</label>
              <label><input type="checkbox" name="servicos[]" value="Decoração com Balões"> Decoração com Balões</label>
              <label><input type="checkbox" name="servicos[]" value="Flores e Arranjos"> Flores e Arranjos</label>
              <label><input type="checkbox" name="servicos[]" value="Assessoria Completa"> Assessoria Completa</label>
              <label><input type="checkbox" name="servicos[]" value="Locação de Espaço"> Locação de Espaço</label>
            </div>
          </div>

          <div class="form-group">
            <label for="descricao">Descrição do evento</label>
            <textarea id="descricao" name="descricao" rows="5" placeholder="Conte mais sobre seu evento, estilo, número de convidados, etc."></textarea>
          </div>

          <button type="submit" class="btn-enviar">Criar Evento</button>
        </form>
      </div>
    </section>
  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>

  <!-- Script da API IBGE -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');

    // Carrega estados
    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
      .then(res => res.json())
      .then(estados => {
        estados.forEach(uf => {
          const option = document.createElement('option');
          option.value = uf.sigla;
          option.textContent = uf.nome;
          estadoSelect.appendChild(option);
        });
      });

    // Carrega cidades ao selecionar estado
    estadoSelect.addEventListener('change', () => {
      const uf = estadoSelect.value;
      cidadeSelect.innerHTML = '<option value="">Carregando...</option>';
      cidadeSelect.disabled = true;

      if (uf) {
        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
          .then(res => res.json())
          .then(cidades => {
            cidadeSelect.innerHTML = '<option value="">-- Selecione a cidade --</option>';
            cidades.forEach(c => {
              const option = document.createElement('option');
              option.value = c.nome;
              option.textContent = c.nome;
              cidadeSelect.appendChild(option);
            });
            cidadeSelect.disabled = false;
          });
      } else {
        cidadeSelect.innerHTML = '<option value="">-- Selecione o estado primeiro --</option>';
        cidadeSelect.disabled = true;
      }
    });
  });
  </script>
</body>
</html>
