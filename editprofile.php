<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Code's Cave</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/styleprof.css">
	<link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
	<section class="py-5 my-5">
		<div class="container">
			<div class="back shadow rounded-lg d-block d-sm-flex">
				<div class="profile-tab-nav border-right">
					<div class="p-4">
                    <div class="img-circle text-center mb-3">
                        <?php
                        session_start();
                        // Verificar se o usuário está logado
                        if (!isset($_SESSION['idUsuario'])) {
                            echo "<script>alert('Você precisa estar logado para atualizar o perfil.');</script>";
                            echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
                            exit();
                        }

                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "CodesCave";

                        // Create connection
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        // Check connection
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }


                        $idUsuario = $_SESSION['idUsuario'];
                        $sql = "SELECT foto_usuario FROM Usuario WHERE idUsuario = $idUsuario";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $foto = $row['foto_usuario'];
                        if ($foto !== null) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($foto) . '" alt="Image" class="shadow">';
                        }
                        }
                        ?>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="profile.php" id="profileForm">
							<div class="form-group">
								<label for="profile_picture">Foto de Perfil:</label>
								<input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
							</div>
							<button type="submit" class="btn btn-primary">Salvar</button>
						</form>
						<h4 class="text-center">Usuario</h4>
					</div>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link " id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
							<i class="fa fa-home text-center mr-1"></i> 
							Conta
						</a>
						<a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
							<i class="fa fa-key text-center mr-1"></i> 
							Senha
						</a>
					</div>
				</div>
				
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="titulo mb-4">Configurações da Conta</h3>
						<form method="post" action="profile.php" id="accountForm">
							<div class="row">
								<div class="col-md-6">
									<div class="titulo form-group form">
										<label>Nome</label>
										<input type="text" name="user" class="form-back form-control" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="titulo form-group form">
										<label>Email</label>
										<input type="email" name="email" class="form-back form-control move-left" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="titulo form-group form">
										<label>Telefone</label>
										<input type="text" name="tel" class="form-back form-control">
									</div>
								</div>
								<div class="col-md-12">
									<div class="titulo form-group">
										<label>Bio</label>
										<textarea name="bio" class="form-back form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
							<div>
								<button type="submit" class="btn btn-primary">Atualizar</button>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<h3 class="titulo mb-4">Configurações de Senha</h3>
						<form method="post" action="trocasenha.php" id="passwordForm">
							<div class="row">
								<div class="col-md-6">
									<div class="titulo form-group">
										<label>Senha Antiga</label>
										<input type="password" name="pass" class="form-control" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="titulo form-group">
										<label>Nova Senha</label>
										<input type="password" name="nova_senha" class="form-control" required>
									</div>
								</div>
							</div>
							<div>
								<button class="btn btn-primary">Atualizar</button>
							</div>
						</form>
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