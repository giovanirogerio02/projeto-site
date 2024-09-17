                <?php 
                    // incluir rodapé da página 
            include('footer.php');

            ?>
    //abre Doctype e o título página de entregas.
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
            <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página de Entregas</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="styles.css">
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title><?php echo htmlspecialchars($title); ?></title>
                <link rel="stylesheet" href="styles.css">
            </head>
            //opção incluir php.
            <body>
            <?php include 'header.php'; ?>
            // div class com página de entregas.
    <div class="container mt-4">
        <h2>Página de entregas</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr> //opções com: produtos, valor, data e endereço do produto.
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Endereço</th>
                    </tr>
                </thead>
                //abre echo com os tópicos entregas.
                <tbody>
                <?php while ($pedido = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entrega['id']); ?></td>
                        <td><?php echo htmlspecialchars($entrega['data_entrega']); ?></td>
                        <td>R$ <?php echo number_format($entrega['total'], 2, ',', '.'); ?></td>
                    </tr>

                <header>
                    <h1><?php echo htmlspecialchars($header); ?></h1>
                </header>
                <main>
                    <section>
                        <p><?php echo htmlspecialchars($content); ?></p>
                    </section>
                </main>
                <footer> //echo com data e os direitos autorais do site.
                    <p>&copy; <?php echo date('Y'); ?> Meu site. Todos os direitos reservados.</p>
                </footer>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        </body>

        </html>
        