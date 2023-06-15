<?php
error_reporting(0);
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    echo "<script>alert('Você precisa estar logado para visualizar o post.');</script>";
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
    // Obter o ID do post da URL
    if (isset($_GET['id'])) {
        $postId = $_GET['id'];

        // Verificar se o post existe no banco de dados
        $sqlPostExists = "SELECT * FROM Postagem WHERE idPostagem = $postId";
        $resultPostExists = mysqli_query($conn, $sqlPostExists);

        if (mysqli_num_rows($resultPostExists) > 0) {
            // Obter os detalhes do post do banco de dados
            $sqlPost = "SELECT p.*, u.nome_usuario, COUNT(c.idComentarios) AS total_comentarios, t.nome_topico, u.foto_usuario
                        FROM Postagem p
                        INNER JOIN Usuario u ON p.Usuario_idUsuario = u.idUsuario
                        INNER JOIN Topico t ON p.Topico_idTopico = t.idTopico
                        LEFT JOIN Comentario c ON p.idPostagem = c.Postagem_idPostagem
                        WHERE p.idPostagem = $postId";
            $resultPost = mysqli_query($conn, $sqlPost);

            if (mysqli_num_rows($resultPost) > 0) {
                $rowPost = mysqli_fetch_assoc($resultPost);
                $postTitle = $rowPost['titulo_post'];
                $postContent = $rowPost['conteudo_post'];
                $postDate = $rowPost['data_post'];
                $userName = $rowPost['nome_usuario'];
                $totalComments = $rowPost['total_comentarios'];
                $userId = $rowPost['Usuario_idUsuario'];
                $topicId = $rowPost['Topico_idTopico'];
                $topicName = $rowPost['nome_topico'];
                $foto = $rowPost['foto_usuario'];
            } else {
                echo "Nenhum registro de post encontrado.";
            }
            
            // Obter as informações do usuário que fez o post
            $sqlUser = "SELECT idUsuario, nome_usuario, foto_usuario FROM Usuario WHERE idUsuario = $userId";
            $resultUser = mysqli_query($conn, $sqlUser);

            if (mysqli_num_rows($resultUser) > 0) {
                $rowUser = mysqli_fetch_assoc($resultUser);
                $userName = $rowUser['nome_usuario'];
                if (isset($rowUser['foto_usuario'])) {
                    $foto = $rowUser['foto_usuario'];
                } else {
                    // Definir um valor padrão para $foto caso a coluna foto_usuario seja nula
                    $foto = 'caminho_da_imagem_padrao.jpg';
                }
            }
                // Obter as informações do usuário do banco de dados
                $sqlUser = "SELECT foto_usuario FROM Usuario WHERE idUsuario = $userId";
                $resultUser = mysqli_query($conn, $sqlUser);

                if (mysqli_num_rows($resultUser) > 0) {
                    $rowUser = mysqli_fetch_assoc($resultUser);
                    if (isset($rowUser['foto_usuario'])) {
                        $foto = $rowUser['foto_usuario'];
                    } else {
                        // Definir um valor padrão para $foto caso a coluna foto_usuario seja nula
                        $foto = 'caminho_da_imagem_padrao.jpg';
                    }
            }
        } else {
            echo "Nenhum registro de post encontrado.";
        }
    } else {
        echo "ID do post não especificado na URL.";
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
    <link rel="stylesheet" href="./css/customdetail.css">
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
                      <div class="avatar pull-right dropdown avatarheader">
                          <a data-toggle="dropdown" href><img src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Image" class="avt">
                          <ul class="dropdown-menu " role="menu">
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
<!-- POSTS -->
<div class="post">
    <div class="topwrap">
        <div class="userinfo pull-left">
            <div class="avatar">
            <?php
            // Consulta para obter a foto do usuário que fez o post
            $sqlUser = "SELECT foto_usuario FROM Usuario WHERE idUsuario = (SELECT Usuario_idUsuario FROM Postagem WHERE idPostagem = $postId)";
            $resultUser = mysqli_query($conn, $sqlUser);

            if (mysqli_num_rows($resultUser) > 0) {
                $rowUser = mysqli_fetch_assoc($resultUser);
                $userPhoto = $rowUser['foto_usuario'];

                // Verificar se a foto do usuário existe
                if (!empty($userPhoto)) {
                    echo "<img src='data:image/jpeg;base64," . base64_encode($userPhoto) . "' alt='Image' class='avt'>";
                } else {
                    echo "<img src='caminho_da_imagem_padrao.jpg' alt='Image' class='avt'>"; // Usar uma imagem padrão se a foto não existir
                }
            } else {
                echo "Nenhuma foto de usuário encontrada.";
            }
            ?>
            </div>
        </div>
        <div class="posttext pull-left posttextcolor">
            <h2><?php echo $postTitle; ?></h2>
            <div class="posted"><i class="fa fa-clock-o"></i> Postado em: <?php echo $postDate; ?></div>
            <div class="tag">
                <span class="badge badge-color1"><?php echo $topicName; ?></span>
            </div>
            <div class='text-light m-t-15'></div>
            <hr/>
            
            
            <div>
                <textarea name="descricao" id="desc" readonly class="textbox textarea-post"><?php echo $postContent; ?></textarea>
            </div>

            

        </div>
        <div class="clearfix"></div>  
    </div>                              
    <div class="postinfobot">
        <div class="clearfix"></div>
    </div>
</div>
<!-- COMENTÁRIOS -->
<h5 style="margin-left: 20px;"><?php echo $totalComments; ?> comentários</h5>

<?php
// Consulta SQL para obter os comentários relacionados ao post
$sqlComments = "SELECT c.*, u.nome_usuario, u.foto_usuario
                FROM Comentario c
                INNER JOIN Usuario u ON c.Usuario_idUsuario = u.idUsuario
                WHERE c.Postagem_idPostagem = $postId";
$resultComments = mysqli_query($conn, $sqlComments);

if (mysqli_num_rows($resultComments) > 0) {
    while ($rowComment = mysqli_fetch_assoc($resultComments)) {
        $commentContent = $rowComment['conteudo_comentario'];
        $commentDate = $rowComment['data_comentario'];
        $commentUserName = $rowComment['nome_usuario'];
        $commentUserImage = $rowComment['foto_usuario'];
        ?>
        <!-- Exibir Comentário -->
        <div class="post comment">
            <div class="topwrap">
                <div class="userinfo pull-left">
                    <div class="avatar">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($commentUserImage); ?>" alt="Imagem do usuário que comentou">
                    </div>
                </div>
                <div>    
                    <h5 class="username"><?php echo $commentUserName; ?></h5>
                    <textarea name="descricao" id="desc" readonly class="textboxD textarea-post"><?php echo $commentContent; ?></textarea>
                </div>
                <div class="posttextAction">
                    <span class="m-r-15"><?php echo $commentDate; ?></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
    }
} else {
    echo "Nenhum comentário encontrado.";
}
?>

<!-- Reply Comment -->
<div class="post comment commentpost">
  <form action="salvar_comentario.php" class="form" method="post">
    <div class="topwrap">
      <div class="userinfo pull-left">
        <div class="avatar">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Image" class="avt">
        </div>
      </div>
      <div class="posttext pull-left posttextcolor">
        <div class="textwraper m-b-10">
          <textarea name="reply" id="reply" placeholder="Escrever comentário..." class="colorcomment"></textarea>
        </div>
      </div>
      <div class="clearfix m-b-10"></div>
    </div>                              
    <div class="postinfobot">
      <div class="pull-right postreply m-b-10">
        <div class="pull-left">
          <input type="hidden" name="postId" value="<?php echo $postId; ?>">
          <button type="submit" class="btn btn-primary">Comentar</button>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
  </form>
</div>
      
    
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