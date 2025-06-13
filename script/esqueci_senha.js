function reenviarCodigo() {
    const codigo = document.getElementById('codigo').value.trim();

    if (/^\d{4,}$/.test(codigo)) {
        console.log("Código digitado:", codigo);
        window.location.href = 'redefenir_senha.html';
    } else {
        alert("Por favor, digite pelo menos 4 números.");
    }
}