<?php
include 'validator.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verifica se o produto existe na lista de desejos
    if (isset($_SESSION['wishlist'][$id])) {
        unset($_SESSION['wishlist'][$id]); // Remove o item da lista de desejos

        // Se a lista estiver vazia, limpe a sessão
        if (empty($_SESSION['wishlist'])) {
            unset($_SESSION['wishlist']);
        }

        $_SESSION['wishlist_message'] = "Produto removido da lista de desejos!";
    }
}

header('Location: listadedesejos.php');
exit();
?>
