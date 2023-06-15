<?php
error_reporting(0);

$user = ($_POST["user"]);
$email = ($_POST["email"]);
$pass = ($_POST["pass"]);

$defaultProfilePicture = file_get_contents('images/default.jpeg');

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

// Verificar se já existe um registro com o mesmo email ou nome de usuário
$checkQuery = "SELECT * FROM Usuario WHERE nome_usuario = '$user' OR email_usuario = '$email'";
$result = mysqli_query($conn, $checkQuery);
if (mysqli_num_rows($result) > 0) {
    // Registro já existe
    echo "<script>alert('Já existe um registro com o mesmo email ou nome de usuário.');</script>";
} else {
    // Inserir novo registro
    $sql = "INSERT INTO Usuario (nome_usuario, email_usuario, senha_usuario, foto_usuario)
    VALUES ('$user', '$email', '$pass', ?)";

    // Preparar a consulta
    $statement = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($statement, 's', $defaultProfilePicture);

    // Executar a consulta
    if (mysqli_stmt_execute($statement)) {
        // Registro criado com sucesso
        echo "<script>alert('Novo registro criado com sucesso.');</script>";
    } else {
        echo "Erro: " . mysqli_stmt_error($statement);
    }
}

mysqli_close($conn);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <title>Code's Cave</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/cadastro.css">  
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  </head>
  <body>
    <div class="box">
        <span class="borderline"></span>
        <form method="post" action="cadastro.php">
            <h2>Registrar-se</h2>
            <div class="inputbox">
                <input id="user" name="user" type="text" required="required">
                <span>Usuário</span>
                <i></i>
            </div>
            <div class="inputbox">
                <input id="email" name="email" type="email" required="required">
                <span>Email</span>
                <i></i>
            </div>
            <div class="inputbox">
                <input id="pass" name="pass" type="password" required="required">
                <span>Senha</span>
                <i></i>
            </div>
            <div class="links">
                <a href="esqSenha.html">Esqueci senha</a>
                <a href="login.html">Entrar</a>
            </div>
            <input type="submit" value="Sign up">
        </form>
    </div>
  </body>
</html>