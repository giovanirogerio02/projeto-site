<?php
include 'db.php';

$status = '';

if (isset($_POST['codigo']) && isset($_GET['token'])) {
    $codigo = $_POST['codigo'];
    $token = $_GET['token'];

    $sql_check_token = "SELECT email, token_expiration, verification_code FROM login_clientes WHERE reset_token = ?";
    if ($stmt = $conn->prepare($sql_check_token)) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($email, $expiration, $stored_code);
        $stmt->fetch();
        $stmt->close();

        if ($email && new DateTime() < new DateTime($expiration) && $stored_code == $codigo) {
            // Código de verificação correto
            header("Location: reset_password.php?token=" . $token);
            exit();
        } else {
            $status = 'token_expirado_ou_codigo_invalido';
        }
    } else {
        $status = 'erro';
    }
} elseif (!isset($_GET['token'])) {
    $status = 'token_faltando';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código</title>
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
                <h4 class="titulo-redefinir-senha">Verificar Código</h4>
            </div>
            <div class="card-body">
                <?php if ($status): ?>
                    <div class="text-danger">
                        <?php
                        switch ($status) {
                            case 'token_expirado_ou_codigo_invalido':
                                echo "Token expirado ou código de verificação inválido.";
                                break;
                            case 'token_faltando':
                                echo "Token inválido.";
                                break;
                            case 'erro':
                                echo "Por favor, tente novamente.";
                                break;
                        }
                        ?>
                    </div>
                <?php else: ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="codigo">Código de Verificação:</label>
                            <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Código de Verificação" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Verificar Código</button>
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