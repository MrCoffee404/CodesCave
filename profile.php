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

// Verificar se um arquivo foi enviado
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['profile_picture'];
    $tmpFilePath = $file['tmp_name'];

    // Verificar o formato do arquivo
    $allowedFormats = ['jpeg', 'jpg', 'png', 'gif'];
    $fileFormat = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileFormat, $allowedFormats)) {
        echo "<script>alert('Formato de arquivo inválido. Envie uma imagem JPEG, JPG, PNG ou GIF.');</script>";
        echo "<script>window.history.back();</script>"; // Redirecionar de volta à página anterior
        exit();
    }

    // Ler o conteúdo do arquivo
    $profilePicture = file_get_contents($tmpFilePath);

    // Atualizar o registro existente, incluindo a imagem
    $idUsuario = $_SESSION['idUsuario'];
    $sql = "UPDATE Usuario SET foto_usuario = ? WHERE idUsuario = $idUsuario";

    // Preparar a consulta
    $statement = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($statement, 's', $profilePicture);

    // Executar a consulta
    if (mysqli_stmt_execute($statement)) {
        // Registro atualizado com sucesso
        mysqli_close($conn);
        echo "<script>alert('Registro atualizado!'); window.history.back();</script>";
        exit();
    } else {
        echo "Erro: " . mysqli_stmt_error($statement);
    }
} else {
    // Caso nenhum arquivo tenha sido enviado, não atualizar a foto de perfil
    $idUsuario = $_SESSION['idUsuario'];
    $user = ($_POST["user"]);
    $email = ($_POST["email"]);
    $bio = ($_POST["bio"]);
    $tel = ($_POST["tel"]);

    // Atualizar registro existente sem a foto de perfil
    $sql = "UPDATE Usuario SET nome_usuario = '$user', email_usuario = '$email', bio_usuario = '$bio', telefone_usuario = '$tel' WHERE idUsuario = $idUsuario";

    if (mysqli_query($conn, $sql)) {
        // Registro atualizado com sucesso
        mysqli_close($conn);
        echo "<script>alert('Registro atualizado!'); window.history.back();</script>";
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
