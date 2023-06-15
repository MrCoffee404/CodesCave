<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CodesCave";

// Conectar-se ao banco de dados
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar a conexão com o banco de dados
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificar se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    echo "<script>alert('Você precisa estar logado para visualizar o perfil.');</script>";
    echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
    exit();
}

$idUsuario = $_SESSION['idUsuario'];

// Verificar se a ID do usuário foi passada na URL
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];
}

// Obter as informações do usuário do banco de dados
$sql = "SELECT nome_usuario, bio_usuario, foto_usuario FROM Usuario WHERE idUsuario = $idUsuario";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user = $row['nome_usuario'];
    $bio = $row['bio_usuario'];
    $foto = $row['foto_usuario'];
} else {
    echo "Nenhum registro encontrado.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Code's Cave</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/styleprofview.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    
</head>
<body>

<section class="py-5 my-5">
    <div class="container">
        <div class="back shadow rounded-lg d-block d-sm-flex">
            <div class="profile-tab-nav border-right">
                <div class="p-4">
                <div class="img-circle text-center mb-3">
                     <img src="data:image/jpeg;base64,<?php echo base64_encode($foto); ?>" alt="Image" class="shadow">
                </div>
                    <h4 class="text-center"><?php echo $user; ?></h4>
                </div>
            </div>
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <h3 class="titulo mb-4">Perfil</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="titulo form-group">
                                  <label><?php echo $user; ?></label>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="titulo form-group">
                                <label><?php echo $bio; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>              
        </div>
        <div>
			<button onclick="window.location.href = 'home.php'" class="btn btn-primary">Voltar</button>
		</div>
    </div>
</section>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
