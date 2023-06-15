<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    echo "<script>alert('Você precisa estar logado para postar.');</script>";
    echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CodesCave";

// Conectar-se ao banco de dados
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar a conexão com o banco de dados
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Obter as informações do usuário do banco de dados
    $idUsuario = $_SESSION['idUsuario'];
    $sql = "SELECT nome_usuario, foto_usuario FROM Usuario WHERE idUsuario = $idUsuario";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user = $row['nome_usuario'];
        $foto = $row['foto_usuario'];
    } else {
        echo "Nenhum registro encontrado.";
    }

    mysqli_close($conn);
}
?>


<!doctype html>
<html lang="pt-br">
  <head>
    <title>Code's Cave</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <!-- Bootstrap CSS -->
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/customnewpost.css">
    <link href="https://fonts.googleapis.com/css?family=Muli:200,300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    
  </head>
  <body>
    <div class="container-fluid">
        <section class="headernav">
          <div class="container ">
              <div class="row">
                  <div class="col-xs-3"><a href="home.php"><h2>Code's Cave</h2></a></div>
                  <div class="col-xs-3 avt pull-right">
                      <div class="avatar pull-right dropdown">
                          <a data-toggle="dropdown" href><img src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Image" class="avt">
                          <ul class="dropdown-menu" role="menu">
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="login.html">Login</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-2" href="logout.php">Sair</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-3" href="profileview.php?id=<?php echo $_SESSION['idUsuario']; ?>">Ver Perfil</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-4" href="editprofile.php">Editar Perfil</a></li>
                          </ul>
                      </div>
                      <div class="clearfix"></div>
                  </div>
              </div>
          </div>
        </section>
      <section class="content">      
        <div class="container m-t-15">
          <div class='col-md-8'>
            <!-- New POSTS -->
            <div class="post">
    <form action="salvar_post.php" class="form newtopic" method="post">
        <div class="topwrap">
            <div class="userinfo pull-left">
                <div class="avatar">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Image" class="avt">
                </div>
            </div>
            <div class="posttext pull-left">
                <div>
                    <input type="text" placeholder="Título do post" class="form-control" name="titulo">
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <select name="categoria" id="category" class="form-control">
                            <option value="" disabled="" selected="">Selecionar categoria</option>
                            <option value="HTML">HTML</option>
                            <option value="CSS">CSS</option>
                            <option value="JS">JS</option>
                            <option value="PHP">PHP</option>
                            <option value="Python">Python</option>
                            <option value="C++">C++</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <textarea name="descricao" id="desc" placeholder="Descrição" class=" formdesc"></textarea>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="postinfobot">
            <div class="pull-right postreply m-b-15">
                <div class="pull-left"><button type="submit" class="btn btn-primary">Postar</button></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
</div>

    <footer>
      <div class="container">
          <div class="row">          
              <div class="col-lg-8 col-xs-6  "><small>Code's Cave 2023</small></div>
              <div class="col-lg-4 col-xs-6 text-right sociconcent">
                  <ul class="socialicons">
                      <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                      <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                      <li><a href="#"><i class="fa fa-cloud"></i></a></li>
                      <li><a href="#"><i class="fa fa-rss"></i></a></li>
                  </ul>
              </div>
          </div>
      </div>
  </footer>  
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
  
</html>