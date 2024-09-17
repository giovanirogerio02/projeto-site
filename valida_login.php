<?php
include 'db.php';

// Captura os dados do formulário
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? ''; 

// Depuração
if (empty($email) || empty($senha)) {
    die("Dados do formulário estão vazios.");
}

// Prepara a declaração para buscar o usuário
if ($stmt = $conn->prepare("SELECT senha, is_admin FROM login_clientes WHERE email = ?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($senha_cadastrada, $is_admin);
    $stmt->fetch();

    // Verifica se a senha foi cadastrada
    if ($senha_cadastrada === null) {
        die("Usuário não encontrado.");
    }

    $stmt->close();
    
    // Verifica se a senha é válida
    if (password_verify($senha, $senha_cadastrada)) {
        // Se a senha estiver correta, configura as variáveis de sessão
        $_SESSION['email'] = $email;
        $_SESSION['is_admin'] = $is_admin ? true : false;

        // Redireciona com base no status de admin
        if ($is_admin) {
            header('Location: criarProduto.php'); // Página para admin
        } else {
            $_SESSION['autenticado'] = 'SIM';
            header('Location: index.php'); // Página para usuário normal
        }
        exit();
    } else {
        // Senha inválida
        header('Location: login.php?login=erro');
        exit();
    }
} else {
    die("Erro na preparação da declaração: " . $conn->error);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
