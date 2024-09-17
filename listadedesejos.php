<?php
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Inicializar a variável $wishlist_message e $is_wishlist_empty
$wishlist_message = '';
$is_wishlist_empty = true;

if (isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
    $is_wishlist_empty = false;
}

// Adicionar produto à lista de desejos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Verificar se o produto existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();

        if (!isset($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array();
        }

        if (!isset($_SESSION['wishlist'][$id])) {
            $_SESSION['wishlist'][$id] = array(
                'id' => $id,
                'nome' => $produto['nome'],
                'preco' => $produto['preco']
            );

            $_SESSION['wishlist_message'] = "Produto adicionado à lista de desejos!";
        } else {
            $_SESSION['wishlist_message'] = "Produto já está na lista de desejos.";
        }

        header('Location: listadedesejos.php');
        exit();
    } else {
        die("Produto não encontrado.");
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Desejos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
</head>
<body>
<?php include 'cabecalho.php'; ?>

<div class="container mt-4">
    <h2>Lista de Desejos</h2>

    <?php if (!empty($wishlist_message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($wishlist_message); ?>
        </div>
    <?php endif; ?>

    <?php if ($is_wishlist_empty): ?>
        <p>Sua lista de desejos está vazia.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['wishlist'] as $id => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>
                        <a href="remover_lista.php?id=<?php echo urlencode($id); ?>" class="btn btn-danger btn-sm">Remover</a>
                        <form action="carrinhodecompras.php" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button type="submit" class="btn btn-success btn-sm">Adicionar ao Carrinho</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include 'rodape.html'; ?>
</body>
</html>