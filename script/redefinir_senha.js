document.getElementById('redefinir').addEventListener('submit', function(e) {
    e.preventDefault();

    const senha = document.getElementById('nova_senha').value.trim();
    const confirmar = document.getElementById('confirmar_senha').value.trim();

    if (!senha || senha.length < 6) {
        alert('A senha deve ter pelo menos 6 caracteres.');
        return;
    }

    if (senha !== confirmar) {
        alert('As senhas não coincidem.');
        return;
    }

    alert('Senha redefinida com sucesso!');
     window.location.href = "login.html"
});
