<?php 
$email = ($_POST["email"]);

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

$sql = "SELECT * FROM Usuario where email_usuario='$email'"; 
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "<script>alert('Um email de recuperação foi enviado.'); window.history.back();</script>";
    die();
  }
} else {
  echo "<script>alert('Email não encontrado.'); window.history.back();</script>";
}

mysqli_close($conn);
?>