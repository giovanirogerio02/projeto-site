<?php
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Consultar o produto pelo ID
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();

        // Adicionar ao carrinho
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }

        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['quantidade']++;
        } else {
            $_SESSION['carrinho'][$id] = array(
                'id' => $id,
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'quantidade' => 1
            );
        }

        // Remover da lista de desejos
        if (isset($_SESSION['wishlist'][$id])) {
            unset($_SESSION['wishlist'][$id]);
        }

        $_SESSION['wishlist_message'] = "Produto adicionado ao carrinho e removido da lista de desejos.";
    } else {
        $_SESSION['wishlist_message'] = "Produto não encontrado.";
    }

    $stmt->close();
    $conn->close();

    header('Location: listadedesejos.php');
    exit();
}
?>