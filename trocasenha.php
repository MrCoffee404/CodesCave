<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    echo "<script>alert('Você precisa estar logado para atualizar a senha.');</script>";
    echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
    exit();
}

$senhaAntiga = $_POST['pass'];
$novaSenha = $_POST['nova_senha'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CodesCave";

// Conectar ao banco de dados
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Recuperar a senha armazenada no banco de dados para o usuário em questão
$idUsuario = $_SESSION['idUsuario'];
$sql = "SELECT senha_usuario FROM Usuario WHERE idUsuario = $idUsuario";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $senhaArmazenada = $row['senha_usuario'];

    if ($senhaAntiga === $senhaArmazenada) {
        // Senha antiga válida, atualizar a senha no banco de dados
        $sql = "UPDATE Usuario SET senha_usuario = '$novaSenha' WHERE idUsuario = $idUsuario";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            echo "<script>alert('Senha atualizada com sucesso.');</script>";
            echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
            exit();
        } else {
            echo "Erro ao atualizar a senha: " . mysqli_error($conn);
        }
    } else {
        mysqli_close($conn);
        echo "<script>alert('Senha antiga incorreta.');</script>";
        echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
        exit();
    }
} else {
    mysqli_close($conn);
    echo "Erro ao recuperar a senha: " . mysqli_error($conn);
}
?>
