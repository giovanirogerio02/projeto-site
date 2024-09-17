
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'db.php';

ini_set('display_errors', 0);
error_reporting(0);

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: lostsenha.php?status=email_incorreto");
        exit();
    }

        // Restringir e-mails não autorizados
        if ($email === 'admin@example.com') {
            header("Location: lostsenha.php?status=email_nao_autorizado");
            exit();
        }

    $email = $conn->real_escape_string($email);
    $sql_code = "SELECT id FROM login_clientes WHERE email = ?";
    if ($stmt = $conn->prepare($sql_code)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();

        if ($id === null) {
            header("Location: lostsenha.php?status=email_nao_existe");
            exit();
        }

        $token = bin2hex(random_bytes(16));
        $verification_code = rand(100000, 999999);  // Código de verificação
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $sql_update = "UPDATE login_clientes SET reset_token = ?, token_expiration = ?, verification_code = ? WHERE email = ?";
        if ($stmt = $conn->prepare($sql_update)) {
            $stmt->bind_param("ssss", $token, $expiration, $verification_code, $email);
            $stmt->execute();
            $stmt->close();
        } else {
            error_log("Erro ao preparar a atualização do token: " . $conn->error);
            header("Location: lostsenha.php?status=erro");
            exit();
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USERNAME') ?: 'alinenacuratelie@gmail.com';
            $mail->Password = getenv('SMTP_PASSWORD') ?: 'igyd oany hipx mpct';
            $mail->SMTPSecure = 'TLS';
            $mail->Port = 587;

            $mail->setFrom('alinenacuratelie@gmail.com', 'Ateliê Aline Nacur');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Redefinir Senha';
            $mail->Body    = 'Clique no link para redefinir sua senha: <a href="http://localhost/codigo-principal-main/codigo.php?token=' . $token . '">Redefinir Senha</a><br>Seu código de verificação é: ' . $verification_code;
            $mail->AltBody = 'Clique no link para redefinir sua senha: http://localhost/codigo-principal-main/codigo.php?token=' . $token . ' Seu código de verificação é: ' . $verification_code;

            $mail->send();
            header("Location: lostsenha.php?status=senha_enviada");
        } catch (Exception $e) {
            error_log("Erro ao enviar o e-mail. Erro: {$mail->ErrorInfo}");
            header("Location: lostsenha.php?status=erro");
        }
    } else {
        error_log("Erro na preparação da declaração: " . $conn->error);
        header("Location: lostsenha.php?status=erro");
    }
} else {
    header("Location: lostsenha.php?status=email_nao_fornecido");
}

$conn->close();
?>