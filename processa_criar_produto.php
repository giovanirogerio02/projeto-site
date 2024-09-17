<?php
include 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php?login=erronaoautorizado');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os valores do formulário
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = (float) $_POST['preco'];
    $altura = (float) $_POST['altura'];
    $largura = (float) $_POST['largura'];
    $comprimento = (float) $_POST['comprimento'];
    
    // Captura as categorias selecionadas (se houver)
    $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : [];
    

    // Upload das fotos
    $target_dir = "uploads/";
    $foto = basename($_FILES["foto"]["name"]);
    $foto2 = basename($_FILES["foto2"]["name"]);
    $foto3 = basename($_FILES["foto3"]["name"]);
    $foto4 = basename($_FILES["foto4"]["name"]);

    // Verifica se o diretório 'uploads/' existe
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Caminho completo dos arquivos para upload
    $uploadOk = true;
    $files = ['foto', 'foto2', 'foto3', 'foto4'];
    foreach ($files as $file) {
        $target_file = $target_dir . basename($_FILES[$file]["name"]);
        if (!move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
            $uploadOk = false;
            echo "Erro ao fazer upload da $file.";
            break;
        }
    }

    if ($uploadOk) {
        // Insere o produto na tabela 'produtos'
        $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, altura, largura, comprimento, foto, foto2, foto3, foto4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssidddssss", $nome, $descricao, $preco, $altura, $largura, $comprimento, $foto, $foto2, $foto3, $foto4);

        if ($stmt->execute()) {
            $produto_id = $stmt->insert_id; // Obtém o ID do produto inserido

            // Relaciona o produto com as categorias selecionadas
            if (!empty($categorias)) {
                foreach ($categorias as $categoria_id) {
                    $stmt_categoria = $conn->prepare("INSERT INTO produto_categoria (produto_id, categoria_id) VALUES (?, ?)");
                    $stmt_categoria->bind_param("ii", $produto_id, $categoria_id);
                    $stmt_categoria->execute();
                    $stmt_categoria->close();
                }
            }

            // Redireciona para a página de visualização do produto
            header("Location: visualizar_produto.php?id=" . $produto_id);
            exit;
        }

        $stmt->close();
    }

    $conn->close();
}
?>