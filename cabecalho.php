
<?php 
if(isset($_SESSION)){
}

$usuario_autenticado = isset($_SESSION['autenticado']) && $_SESSION['autenticado'] ==='SIM';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
    


</head>

<body>
      
  <div class='cabecalho'>
      
      <div class="containera">
  
      <div class="row">
  
      <div class="col-sm">
        <a href='index.php' class='imagemi'>
            <img src="assets/dg1.png" class='imagemi'>
        </a>
      </div>
  
          <div class="col-sm">
          
              <nav class="navbar">
                  <form class="form-inline mt-5" style="display: flex; position: relative; top: -25px;">
                      <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                      <button id='botao' class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
                  </form>
              </nav>
  
          </div>
  
          <div class="col-sm" style="display: flex; position: relative; top: 32px;">
          
              <div class="container">
                  <div class="row">
  
                      <div class="col-sm">
                      <a href='listadedesejos.php'> <i class="fa-solid fa-heart fa-2xl coracao" style="margin-top: 20px;"></i> </a>
                      </div>
                      <div class="col-sm">
                      <a href='carrinhodecompras.php'><i class="fa-solid fa-cart-shopping fa-2xl carrinho"  style="margin-top: 20px;"></i></a>
                      </div>
                      <div class="col-sm">   
                      <button id='botao2' popovertarget='menuu'>                      
                      <i class="fa-solid fa-bars fa-2xl bot meenu"></i>  
                      </button>                      
                      </div>
  
                  </div>
              </div>
  
          </div>
  
      </div>
  
      </div>
  
    </div>
      
      
<div id="menuu" popover> <!-- div pai -->

 <H1> MENU </H1>

 <div id="sair">    
    <ul class="navbar-nav">
        <li class="nav-item">

            
            <a href="#" class="nav-link">
            <div class="coluna c1">
             Mochilas
            </div> 
            </a>
            

            
            <a href="#" class="nav-link">
            <div class="coluna c2">
             Estojos 
            </div>
            </a>
            

            
            <a href="#" class="nav-link">
            <div class="coluna c3">
             Chaveiros 
            </div>
            </a>
            

            
            <a href="#" class="nav-link">
            <div class="coluna c4">
             Necessaire 
            </div>
            </a>
            

            <a href="#" class="nav-link">
            <div class="coluna c5">
            
             Personalizados 
            
            </div>
            </a>

            
                
                <?php if($usuario_autenticado): ?> 
                <a href="minhaconta.php" class="nav-link">
                <div class="coluna c6">
                    Minha Conta!
                </div>
                </a>
                <?php  else: ?>
                    <a href='login.php' class='nav-link'>
                    <div class="coluna c6">
                        Logar
                    </div>
                    </a>
                <?php endif;?>

            

        </li>
    </ul>
  </div>


</div>

<div id="categorias">
    
<div class="cat1 cat"> Chaveiros </div>
<div class="cat2 cat"> Necessaire </div>
<div class="cat3 cat"> Mochilas </div>
<div class="cat4 cat"> Estojos </div>
<div class="cat5 cat"> Lancheiras </div>
<div class="cat6 cat"> Tapetes </div>

</div>




</body>

</html>