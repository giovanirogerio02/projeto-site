<?php
include 'db.php';

// Buscar produtos
$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="utf-8" />
    <title>Ateliê Aline Nacur</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href='style.css'>
    <link rel="shortcut icon" href="assets/corujinha.png"/>

<?php
include 'styleCabelho.php';
?>

</head>

<body>

<?php 

include 'cabecalho.php';

include 'homeaqui.php';
?>

<div id="conteiner1">

    
<?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row['id']; // Captura o ID do produto
            $nome = htmlspecialchars($row["nome"]);
            $foto = htmlspecialchars($row["foto"]);
            $foto_url = "uploads/" . $foto;
            $nomeM = ucfirst($nome);
            
            echo "
            <a href='visualizar_produto.php?id=$id'> <div class='cards card1'>
                <img src='$foto_url' height='300px' width='300px' alt='$nome'>
                <p class='text'> $nomeM </p>
            </div> </a>
            ";
        }
    } else {
        echo "<p>Nenhum produto encontrado.</p>";
    }
?>


    
</div>



<?php include 'rodape.html'; ?>

</body>
</html>