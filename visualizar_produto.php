<?php
include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar se o ID do produto é válido
if ($id <= 0) {
    die("ID de produto inválido.");
}

// Buscar as informações do produto no banco de dados
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
    } else {
        die("Produto não encontrado.");
    }
} else {
    die("Erro ao buscar produto: " . $stmt->error);
}

$stmt->close();
$conn->close();

// Verifique se $produto está definido
if (!isset($produto)) {
    die("Não foi possível carregar as informações do produto.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
</head>
<body>
<?php include 'cabecalho.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Exibir Imagens do Produto -->
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php if (!empty($produto['foto'])): ?>
                        <div class="carousel-item active">
                            <img src="uploads/<?php echo htmlspecialchars($produto['foto']); ?>" class="d-block w-100" alt="Foto Principal">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produto['foto2'])): ?>
                        <div class="carousel-item">
                            <img src="uploads/<?php echo htmlspecialchars($produto['foto2']); ?>" class="d-block w-100" alt="Foto Secundária">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produto['foto3'])): ?>
                        <div class="carousel-item">
                            <img src="uploads/<?php echo htmlspecialchars($produto['foto3']); ?>" class="d-block w-100" alt="Imagem do Produto">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produto['foto4'])): ?>
                        <div class="carousel-item">
                            <img src="uploads/<?php echo htmlspecialchars($produto['foto4']); ?>" class="d-block w-100" alt="Imagem do Produto">
                        </div>
                    <?php endif; ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
            <p><strong>Preço:</strong> R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <p><strong>Dimensões:</strong> <?php echo "{$produto['altura']}cm x {$produto['largura']}cm x {$produto['comprimento']}cm"; ?></p>

            <form action="listadedesejos.php" method="post" class="mt-2">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <button type="submit" id="add-to-wishlist" class="btn btn-primary">
                    <img src="assets/coracao.png" alt="Adicionar à Lista de Desejos" style="width: 24px; height: 24px;">
                </button>
                <div id="confirmation-message" class="alert-message" style="display: none;">Produto adicionado à lista de desejos!</div>
            </form>

            <form action="carrinhodecompras.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-success">Adicionar ao Carrinho</button>

            <button class="btn btn-warning mt-2" onclick="sendMessage()">Tenha o seu personalizado!</button>
            <script>
            function sendMessage() {
                const phoneNumber = '5543996709161'; // Número no formato internacional
                const productName = '<?php echo htmlspecialchars($produto['nome']); ?>';
                const productLink = window.location.href; // Link para a página do produto
                const message = `Oiii, eu gostaria de um ${productName} personalizado. É esse produto aqui: ${productLink}`;
                
                // Cria o link para o WhatsApp
                const whatsappLink = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;
                
                // Abre o link em uma nova aba
                window.open(whatsappLink, '_blank');
            }
            </script>
              </form>
        </div>
    </div>
</div>

<?php include 'rodape.html'; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>