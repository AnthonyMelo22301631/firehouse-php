<?php
namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContatoController
{
    public function index()
    {
        require __DIR__ . '/../../views/contato.php';
    }

    public function enviar()
    {
        require __DIR__ . '/../../vendor/autoload.php';

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mensagem = trim($_POST['mensagem'] ?? '');

        if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mensagem === '') {
            echo "<script>alert('Preencha todos os campos corretamente.');window.history.back();</script>";
            exit;
        }

        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor SMTP do Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'SEU_EMAIL@gmail.com';  // 🔹 coloque aqui seu e-mail Gmail
            $mail->Password = 'SENHA_DE_APP';         // 🔹 não é sua senha normal (explico abaixo)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom($email, $nome);
            $mail->addAddress('22301631@aluno.cotemig.com.br', 'FireHouse Contato');

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = '📩 Nova mensagem de contato - FireHouse';
            $mail->Body = "
                <h3>Nova mensagem de contato</h3>
                <p><strong>Nome:</strong> {$nome}</p>
                <p><strong>E-mail:</strong> {$email}</p>
                <p><strong>Mensagem:</strong><br>" . nl2br(htmlspecialchars($mensagem)) . "</p>
            ";

            $mail->send();

            echo "<script>alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');window.location.href='/firehouse-php/public/contato';</script>";

        } catch (Exception $e) {
            echo "<script>alert('Erro ao enviar mensagem: {$mail->ErrorInfo}');window.history.back();</script>";
        }
    }
}
