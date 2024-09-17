<?php
include 'db.php';

// Captura os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

// Função para verificar se a senha é forte
function senha_forte($senha) {
    return preg_match('/[A-Z]/', $senha) &&         // Letra maiúscula
           preg_match('/[a-z]/', $senha) &&         // Letra minúscula
           preg_match('/[0-9]/', $senha) &&         // Número
           preg_match('/[\W_]/', $senha) &&         // Caracter especial
           strlen($senha) >= 8;                     // Comprimento mínimo
}

// Verifica se as senhas coincidem
if ($senha !== $confirmar_senha) {
    header('Location: crieconta.php?erro=senha');
    exit();
}

// Verifica se a senha é forte
if (!senha_forte($senha)) {
    header('Location: crieconta.php?erro=senha_forte');
    exit();
}

// Cria o hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Prepara a declaração para verificar se o e-mail já existe
if ($stmt = $conn->prepare("SELECT COUNT(*) FROM login_clientes WHERE email = ?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    if ($count > 0) {
        // E-mail já cadastrado
        header('Location: crieconta.php?erro=email');
        exit();
    }
} else {
    die("Erro na preparação da declaração: " . $conn->error);
}

// Insere o novo usuário
if ($stmt = $conn->prepare("INSERT INTO login_clientes (nome, email, senha) VALUES (?, ?, ?)")) {
    $stmt->bind_param("sss", $nome, $email, $senha_hash);
    if ($stmt->execute()) {
        header('Location: login.php');
        exit();
    } else {
        die("Erro ao inserir usuário: " . $stmt->error);
    }
    $stmt->close();
} else {
    die("Erro na preparação da declaração: " . $conn->error);
}

// Fecha a conexão
$conn->close();
?>
