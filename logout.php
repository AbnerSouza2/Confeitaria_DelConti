<?php
session_start(); // Inicia a sessão, caso ainda não tenha sido iniciada

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se necessário, destrói a sessão
if (session_id() != '' || isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
}

session_destroy(); // Destrói a sessão

// Redireciona o usuário para a página de login (ou outra página de sua escolha)
header("Location: index.php");
exit();
?>
