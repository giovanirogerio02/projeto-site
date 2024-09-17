<?php
include 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php?login=erronaoautorizado');
    exit();
}

$sql = "SELECT id, nome FROM categorias";
$result = $conn->query($sql);

$categorias = [];
if ($result->num_rows > 0) {
    // Popula o array de categorias
    while($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}


?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produto</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
</head>

<body>
<?php include 'cabecalho.php'?>

    <div id="criarproduto">
        <form action="processa_criar_produto.php" method="post" enctype="multipart/form-data">
            <div class="containercriarprodutosform">
                <div class="formcriarprodutos">
                    <label for="nome">Nome
                        <input type="text" class="inputcriarprodutos" id="nome" name="nome" placeholder="Nome" required>
                    </label>
                    <label for="descricao">Descrição
                        <textarea class="inputcriarprodutos" id="descricao" name="descricao" rows="5" cols="30" placeholder="Descrição" required></textarea>
                    </label>
                    <label for="preco">Preço
                        <input type="number" step="0.02" name="preco" class="inputcriarprodutos" placeholder="Preço" required>
                    </label>
                </div>

                <div class="formcriarprodutos">
                    <label for="altura">Altura
                        <input type="number" class="inputcriarprodutos" name="altura" placeholder="Altura" step="0.02" required>
                    </label>

                    <label for="largura">Largura
                        <input type="number" class="inputcriarprodutos" name="largura" placeholder="Largura" step="0.02" required>
                    </label>

                    <label for="comprimento">Comprimento
                        <input type="number" class="inputcriarprodutos" name="comprimento" placeholder="Comprimento" step="0.02" required>
                    </label>

                </div>

                <div class="conteinerimagem">
                    <div class="imagemdoformcriarprodutos">
                        <label>Foto 1:
                            <input type="file" id="imagem" name="foto" required>
                        </label>
                    </div>

                    <div class="imagemdoformcriarprodutos">
                        <label>Foto 2:
                            <input type="file" id="imagem" name="foto2" required>
                        </label>
                    </div>

                    <div class="imagemdoformcriarprodutos">
                        <label>Foto 3:
                            <input type="file" id="imagem" name="foto3" required>
                        </label>
                    </div>

                    <div class="imagemdoformcriarprodutos">
                        <label>Foto 4:
                            <input type="file" id="imagem" name="foto4" required>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Mudar categoria -->
            <div class="formcriarprodutos">
                <label for="categorias">Categorias:</label>
                <div>
                    <select name="categorias" id="categorias" class="form-select">
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <option value="Lancheira">Lancheira</option>
                        <option value="Estojos">Estojos</option>
                        <option value="Bolsas Maternidade">Bolsas Maternidade</option>
                        <option value="Mochila">Mochila</option>
                        <option value="Tapete">Tapete</option>
                        <option value="Bordado">Bordado</option>
                        <option value="Molde">Molde</option>
                        <option value="Necessaire">Necessaire</option>
                        <option value="Chaveiros">Chaveiros</option>
                    </select>
                </div>
            </div>



            <input type="submit" class="inputcriarprodutos submitdocriarprodutos" value="Criar Produto">
        </form>
    </div>

<?php include 'rodape.html' ?>
</body>

</html>