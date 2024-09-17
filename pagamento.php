<?php
include 'db.php'; // Inclua o arquivo de conexão com o banco de dados

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'] ?? null;
    $cart = $_SESSION['cart'] ?? array();
    $total = 0;

    // Verificar se o carrinho não está vazio
    if (!empty($cart)) {
        $conn->begin_transaction();
        try {
            // Inserir pedido na tabela de pedidos
            $sql = "INSERT INTO pedidos (usuario_id, total, data_pedido) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("id", $usuario_id, $total);
            $stmt->execute();
            $pedido_id = $stmt->insert_id; // Obter o ID do pedido inserido

            // Inserir itens do pedido
            $sql = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            foreach ($cart as $id => $item) {
                $preco = $item['preco'];
                $quantidade = $item['quantidade'];
                $total += $preco * $quantidade;
                $stmt->bind_param("iiid", $pedido_id, $id, $quantidade, $preco);
                $stmt->execute();
            }

            // Atualizar total do pedido
            $sql = "UPDATE pedidos SET total = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $total, $pedido_id);
            $stmt->execute();

            // Confirmar a transação
            $conn->commit();

            // Limpar o carrinho
            unset($_SESSION['cart']);
            unset($_SESSION['cart_count']);

            // Gerar o checkout no PagSeguro
            $email = 'seu_email@dominio.com'; // Substitua pelo seu e-mail
            $token = 'seu_token'; // Substitua pelo seu token
            $url = 'https://ws.pagseguro.uol.com.br/v2/checkout?email=' . $email . '&token=' . $token;

            $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <checkout>
                <items>';

            foreach ($cart as $id => $item) {
                $xml .= '
                <item>
                    <id>' . $id . '</id>
                    <description>' . htmlspecialchars($item['nome']) . '</description>
                    <amount>' . $item['preco'] . '</amount>
                    <quantity>' . $item['quantidade'] . '</quantity>
                </item>';
            }

            $xml .= '
                </items>
            </checkout>';

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/xml',
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            $responseXml = simplexml_load_string($response);
            if ($responseXml === false) {
                throw new Exception('Erro ao processar a resposta do PagSeguro.');
            }
            $code = $responseXml->code;
            $url_pagamento = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $code;

            // Redirecionar para a página de pagamento do PagSeguro
            header('Location: ' . $url_pagamento);
            exit();

        } catch (Exception $e) {
            // Em caso de erro, desfazer a transação
            $conn->rollback();
            die("Erro ao finalizar a compra: " . $e->getMessage());
        }
    } else {
        header('Location: carrinhodecompras.php');
        exit();
    }
} else {
    header('Location: carrinhodecompras.php');
    exit();
}
?>
