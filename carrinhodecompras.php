<?php
//Você tem que arrumar a questão de pedidos. Os pedidos não estão indo pro banco de dados

include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Inicializar a variável $is_cart_empty
$is_cart_empty = !isset($_SESSION['carrinho']) || empty($_SESSION['carrinho']);

// Atualizar quantidades no carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantities'])) {
    if (isset($_POST['quantidades']) && is_array($_POST['quantidades'])) {
        foreach ($_POST['quantidades'] as $id => $quantidade) {
            $id = intval($id);
            $quantidade = intval($quantidade);

            // Validar a quantidade
            if ($quantidade > 0) {
                if (isset($_SESSION['carrinho'][$id])) {
                    $_SESSION['carrinho'][$id]['quantidade'] = $quantidade;
                }
            } else {
                // Remover item se a quantidade for 0 ou negativa
                unset($_SESSION['carrinho'][$id]);
            }
        }
    }

    // Atualizar o estado do carrinho
    $is_cart_empty = empty($_SESSION['carrinho']);
}

// Adicionar produto ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Verificar se o ID é positivo
    if ($id > 0) {
        // Verificar se o produto existe no banco de dados
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
        if ($stmt === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $produto = $result->fetch_assoc();

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

            // Verificar se o produto está na lista de desejos e removê-lo se necessário
            if (isset($_SESSION['lista_desejos'][$id])) {
                unset($_SESSION['lista_desejos'][$id]);
            }
        } else {
            die("Produto não encontrado.");
        }

        $stmt->close();
    } else {
        die("ID de produto inválido.");
    }

    $conn->close();

    // Redirecionar para a página atual para refletir a adição
    header('Location: carrinhodecompras.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
</head>
<body>
<?php include 'cabecalho.php'; ?>

<div class="container mt-4">
    <h2>Carrinho de Compras</h2>

    <?php if ($is_cart_empty): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <form action="carrinhodecompras.php" method="POST">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrinho'] as $id => $item):
                        $item_total = $item['preco'] * $item['quantidade'];
                        $total += $item_total;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td>
                                <input type="number" name="quantidades[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($item['quantidade']); ?>" min="1" class="form-control" style="width: 100px;">
                            </td>
                            <td>R$ <?php echo number_format($item_total, 2, ',', '.'); ?></td>
                            <td>
                                <a href="remover_carrinho.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" name="update_quantities" class="btn btn-primary">Editar</button>
            <a href="finalizar_compra.php" class="btn btn-success">Finalizar Compra</a>
        </form>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php include 'rodape.html'; ?>
</body>
</html>
