<?php
session_start();

// Destruir a sessão atual
session_destroy();

// Redirecionar para a página de login ou qualquer outra página desejada
header("Location: index.html");
exit();
?>