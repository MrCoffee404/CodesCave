<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    echo "<script>alert('Você precisa estar logado para comentar.');</script>";
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
    // Obter os dados do formulário
    $reply = $_POST['reply'];
    $postId = $_POST['postId'];
    $userId = $_SESSION['idUsuario'];
    
    // Preparar e executar a consulta para inserir o comentário no banco de dados
    $sql = "INSERT INTO Comentario (conteudo_comentario, data_comentario, usuario_idusuario, Postagem_idPostagem) VALUES ('$reply', NOW(), $userId, $postId)";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Comentário salvo com sucesso.');</script>";
        echo "<script>window.location.href = 'detail.php?id=$postId';</script>"; // Redirecionar para a página de detalhes do post
    } else {
        echo "Erro ao salvar o comentário: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
