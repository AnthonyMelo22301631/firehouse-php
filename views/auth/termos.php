<?php include __DIR__ . '/../partials/header.php'; ?>

<!-- CSS exclusivo da página -->
<link rel="stylesheet" href="/firehouse-php/public/assets/css/termo.css?v=<?= time(); ?>">

<main class="conteudo">
    <div class="container-termo">

        <h1 class="titulo">Termo de Consentimento</h1>

        <div class="caixa-termo">
            <p>
                Este Termo de Consentimento descreve como seus dados pessoais serão coletados, utilizados e 
                armazenados dentro da plataforma <strong>FireHouse</strong>, de acordo com a Lei Geral de Proteção de Dados (LGPD – Lei nº 13.709/2018).
            </p>

            <h2>1. Coleta de Dados</h2>
            <p>A FireHouse coleta informações necessárias para o funcionamento do sistema, como:</p>
            <ul>
                <li>Nome completo</li>
                <li>Email</li>
                <li>Telefone</li>
                <li>Estado e Cidade</li>
                <li>Dados de eventos criados ou serviços realizados</li>
            </ul>

            <h2>2. Uso das Informações</h2>
            <p>Os dados coletados são utilizados para:</p>
            <ul>
                <li>Gerenciar sua conta na plataforma</li>
                <li>Permitir criação e organização de eventos</li>
                <li>Conectar clientes e colaboradores</li>
                <li>Melhorar a experiência e funcionamento do sistema</li>
            </ul>

            <h2>3. Compartilhamento de Dados</h2>
            <p>
                Seus dados somente serão compartilhados com colaboradores vinculados aos seus eventos, 
                quando necessário para execução do serviço.
            </p>

            <h2>4. Segurança</h2>
            <p>
                Utilizamos medidas técnicas para proteger suas informações contra acesso indevido, perda ou alterações 
                não autorizadas.
            </p>

            <h2>5. Direitos do Usuário</h2>
            <p>Você pode solicitar:</p>
            <ul>
                <li>Correção ou atualização dos seus dados</li>
                <li>Portabilidade</li>
                <li>Exclusão dos seus dados</li>
            </ul>
        </div>

        <!-- Aceite -->
        <form class="form-termo" method="POST" action="/firehouse-php/public/auth/aceitar-termos">
            <label class="checkbox">
                <input type="checkbox" required>
                Li e Aceito os Termos
            </label>

            <button type="submit" class="btn-aceitar">Aceitar e Continuar</button>
        </form>

    </div>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
