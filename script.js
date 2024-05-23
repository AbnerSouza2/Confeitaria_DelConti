function realizarLogout() {
    fetch('logout.php', {
        method: 'POST'
    }).then(function(response) {
        // Redireciona para o index.php após o logout
        window.location.href = 'index.php';
    }).catch(function(error) {
        console.error('Erro ao realizar logout:', error);
    });
}