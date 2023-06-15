<?php 
session_start();

$login = $_POST["login"];
$senha = $_POST["pass"];

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

$sql = "SELECT * FROM Usuario WHERE nome_usuario='$login' AND senha_usuario='$senha'"; 
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Login encontrado, redirecionar para a página home.html e armazenar o ID do usuário na sessão
  $row = mysqli_fetch_assoc($result);
  $_SESSION['idUsuario'] = $row['idUsuario'];
  header('Location: home.php');
  exit(); // Encerrar o script para evitar que o restante do código seja executado
} else {
  // Login não encontrado, exibir mensagem de erro na mesma página
  echo "<script>alert('Não achamos seu login. Por favor, verifique suas credenciais.'); window.history.back();</script>";
}

mysqli_close($conn);
?>
