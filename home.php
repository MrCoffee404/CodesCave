<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    echo "<script>alert('Você precisa estar logado para entrar no fórum.');</script>";
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
    // Obter a foto do usuário do banco de dados
    $idUsuario = $_SESSION['idUsuario'];
    $sql = "SELECT foto_usuario FROM Usuario WHERE idUsuario = $idUsuario";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto_usuario'];
    } else {
        echo "Nenhum registro encontrado.";
    }
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
    <link rel="stylesheet" href="./css/custom.css">
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
      <section class="contenthome">
        <div class="container">
          <div class="row m-15 m-l-0">
          <div class="col-xs-6">                   
          <form method="post" class="form">
              <button class="btn btn-primary" onclick="window.open('./newpost.php')"><i class="fa fa-plus-square" aria-hidden="true"></i> Começar novo tópico</button>
          </form>
          </div>        
        </div>
        </div>
        <div class="container">
          <div class='col-md-8'>
        <?php
      // Verificar a conexão com o banco de dados
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else 
    // Obter todas as postagens do banco de dados
    $sqlPost = "SELECT p.*, u.nome_usuario, COUNT(c.idComentarios) AS total_comentarios, t.nome_topico, u.foto_usuario
    FROM Postagem p
    INNER JOIN Usuario u ON p.Usuario_idUsuario = u.idUsuario
    INNER JOIN Topico t ON p.Topico_idTopico = t.idTopico
    LEFT JOIN Comentario c ON p.idPostagem = c.Postagem_idPostagem
    GROUP BY p.idPostagem
    ORDER BY p.idPostagem DESC";

    $resultPost = mysqli_query($conn, $sqlPost);

        if (mysqli_num_rows($resultPost) > 0) {
        while ($rowPost = mysqli_fetch_assoc($resultPost)) {
            $postId = $rowPost['idPostagem'];
            $postTitle = $rowPost['titulo_post'];
            $postContent = $rowPost['conteudo_post'];
            $postDate = $rowPost['data_post'];
            $userName = $rowPost['nome_usuario'];
            $totalComments = $rowPost['total_comentarios'];
            $userId = $rowPost['Usuario_idUsuario'];
            $topicId = $rowPost['Topico_idTopico'];
            $topicName = $rowPost['nome_topico'];
            $foto = $rowPost['foto_usuario'];

        // Exibir o post
        echo "<div class='post'>";
        echo "  <div class='wrap-ut pull-left'>";
        echo "    <div class='userinfo pull-left'>";
        echo "      <div class='avatar'>";
        echo "        <h2><img src='data:image/jpeg;base64,".base64_encode($foto)."' alt='Foto do usuário'></h2>";
        echo "      </div>";
        echo "    </div>";
        echo "    <div class='posttexthome pull-left'>";
        echo "      <h2><a href='detail.php?id=".$postId."'>".$postTitle."</a></h2>";
        echo "      <small>".$postDate."</small>";
        echo "      <div class='post-content m-t-15'>";
        echo "        <p>".$postContent."</p>";
        echo "      </div>";
        echo "      <div class='tag'>";
        echo "        <span class='badge badge-color1'>".$topicName."</span>";
        echo "      </div>";
        echo "    </div>";
        echo "    <div class='clearfix'></div>";
        echo "  </div>";
        echo "  <div class='postinfo pull-left'>";
        echo "    <div class='dotmenu dropdown'></div>";
        echo "    <div class='comments'>";
        echo "      <div class='commentbg'>";
        echo "        ".$totalComments." comentários do post";
        echo "        <div class='mark'></div>";
        echo "      </div>";
        echo "    </div>";
        echo "  </div>";
        echo "  <div class='clearfix'></div>";
        echo "</div>";
        }
    } else {
        echo "Nenhuma postagem encontrada.";
    }
    ?>
    <footer>
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-xs-6 "><small>Code's Cave 2023</small></div>
              <div class="col-lg-4 col-xs-6 text-right  sociconcent">
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
    
    <script>
      let subMenu = document.getElementByID("subMenu");

      function toggleMenu(){
        subMenu.classList.toggle("open-menu");
      }

    </script>
  </body>
</html>
