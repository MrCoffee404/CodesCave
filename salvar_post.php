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
}

// Obter os dados do formulário
$titulo = $_POST['titulo'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];

// Obter o ID da categoria selecionada
$sqlCategoria = "SELECT idTopico FROM Topico WHERE nome_topico = '$categoria'";
$resultCategoria = mysqli_query($conn, $sqlCategoria);

if (mysqli_num_rows($resultCategoria) > 0) {
    $rowCategoria = mysqli_fetch_assoc($resultCategoria);
    $idCategoria = $rowCategoria['idTopico'];

    // Preparar e executar a consulta SQL
    $sql = "INSERT INTO Postagem (conteudo_post, data_post, titulo_post, Usuario_idUsuario, Topico_idTopico) VALUES ('$descricao', NOW(), '$titulo', '{$_SESSION['idUsuario']}', '$idCategoria')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Postagem enviada com sucesso.');</script>";
        echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
        exit();
    } else {
        echo "Erro ao salvar a postagem: " . mysqli_error($conn);
        echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
        exit();
    }
} else {
    echo "<script>alert('Categoria Inválida.');</script>";
    echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
    exit();
}

mysqli_close($conn);
?>
