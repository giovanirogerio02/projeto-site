<?php
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
 }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Redirecionar para a página de pagamento
    header('Location: pagamento.php');
    exit();
} else {
    // Se não for uma requisição POST, redirecionar para o carrinho
    header('Location: carrinhodecompras.php');
    exit();
}
?>
