<?php
session_start();

// Verificar se o ID do produto foi passado
if (!isset($_GET['id'])) {
    header('Location: carrinhodecompras.php'); // Corrigir o nome do arquivo para o correto
    exit();
}

$id = intval($_GET['id']);

// Remover produto do carrinho
if (isset($_SESSION['carrinho'][$id])) {
    unset($_SESSION['carrinho'][$id]);
}

// Redirecionar de volta para o carrinho
header('Location: carrinhodecompras.php'); // Corrigir o nome do arquivo para o correto
exit();
?>
