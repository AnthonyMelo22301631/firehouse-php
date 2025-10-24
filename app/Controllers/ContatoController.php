<?php
namespace App\Controllers;

class ContatoController
{
    public function index()
    {
        // Exibe o formulário
        require __DIR__ . '/../../views/contato.php';
    }

    public function enviar()
    {
        // Captura os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mensagem = trim($_POST['mensagem'] ?? '');

        // Validação simples
        if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mensagem === '') {
            echo "<script>alert('Preencha todos os campos corretamente.');window.history.back();</script>";
            exit;
        }

        // Configuração do e-mail
        $to = '22301631@aluno.cotemig.com.br';
        $subject = "📩 Nova mensagem de contato - FireHouse";
        $body = "
        <h2>Nova mensagem recebida</h2>
        <p><strong>Nome:</strong> {$nome}</p>
        <p><strong>E-mail:</strong> {$email}</p>
        <p><strong>Mensagem:</strong><br>" . nl2br(htmlspecialchars($mensagem)) . "</p>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: {$nome} <{$email}>" . "\r\n";

        // Envia o e-mail
        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');window.location.href='/firehouse-php/public/contato';</script>";
        } else {
            echo "<script>alert('Erro ao enviar a mensagem. Tente novamente mais tarde.');window.history.back();</script>";
        }
    }
}
