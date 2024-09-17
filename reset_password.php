<?php
include 'db.php';

$status = '';

if (isset($_POST['nova_senha']) && isset($_POST['confirmar_senha']) && isset($_GET['token'])) {
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $token = $_GET['token'];

    if ($nova_senha !== $confirmar_senha) {
        $status = 'senha_nao_coincide';
    } else {
        $sql_check_token = "SELECT email, token_expiration FROM login_clientes WHERE reset_token = ?";
        if ($stmt = $conn->prepare($sql_check_token)) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->bind_result($email, $expiration);
            $stmt->fetch();
            $stmt->close();

            if ($email && new DateTime() < new DateTime($expiration)) {
                $sql_check_admin = "SELECT is_admin FROM login_clientes WHERE email = ?";
                if ($stmt = $conn->prepare($sql_check_admin)) {
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->bind_result($is_admin);
                    $stmt->fetch();
                    $stmt->close();

                    if ($is_admin == 1) {
                        $status = 'usuario_admin';
                    } else {
                        $sql_update = "UPDATE login_clientes SET senha = ?, reset_token = NULL, token_expiration = NULL WHERE reset_token = ?";
                        if ($stmt = $conn->prepare($sql_update)) {
                            $hashed_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
                            $stmt->bind_param("ss", $hashed_senha, $token);
                            if ($stmt->execute()) {
                                header("Location: login.php?status=senha_atualizada");
                                exit();
                            } else {
                                $status = 'erro';
                            }
                            $stmt->close();
                        } else {
                            $status = 'erro';
                        }
                    }
                } else {
                    $status = 'erro';
                }
            } else {
                $status = 'token_expirado';
            }
        } else {
            $status = 'erro';
        }
    }
} elseif (!isset($_GET['token'])) {
    $status = 'token_faltando';
}

// Função para verificar se a senha é forte
function senha_forte($senha) {
    return preg_match('/[A-Z]/', $senha) &&         // Letra maiúscula
           preg_match('/[a-z]/', $senha) &&         // Letra minúscula
           preg_match('/[0-9]/', $senha) &&         // Número
           preg_match('/[\W_]/', $senha) &&         // Caracter especial
           strlen($senha) >= 8;                     // Comprimento mínimo
}

// Fecha a conexão
$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
</head>
<body>
<?php include 'cabecalho.php'; ?>

<div class="container">
    <div class="card-login">
        <div class="card">
            <div class="card-header">
                <h4 class="titulo-redefinir-senha">Redefinir Senha</h4>
            </div>
            <div class="card-body">
                <?php if ($status): ?>
                    <div class="text-danger">
                        <?php
                        switch ($status) {
                            case 'senha_nao_coincide':
                                echo "As senhas não são iguais.";
                                break;
                            case 'usuario_admin':
                                echo "Não é permitido redefinir a senha para administradores.";
                                break;
                            case 'erro':
                                echo "Por favor, tente novamente.";
                                break;
                            case 'token_expirado':
                                echo "Token expirado.";
                                break;
                            case 'token_faltando':
                                echo "Token inválido.";
                                break;
                        }
                        ?>
                    </div>
                <?php else: ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="nova_senha">Nova Senha:</label>
                            <input type="password" id="nova_senha" name="nova_senha" class="form-control" placeholder="Nova Senha" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmar_senha">Confirmar Nova Senha:</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" placeholder="Confirmar Senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Redefinir Senha</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.html'; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF"></script>
</body>
</html>