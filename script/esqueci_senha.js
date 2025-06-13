function validarCodigo() {
    const codigo = document.getElementById('codigo').value.trim();


    if (codigo === "") {
        alert("Por favor, digite o código de confirmação.");
        return;
    }


    const regex = /^\d{6}$/;
    if (!regex.test(codigo)) {
        alert("O código deve conter exatamente 6 números.");
        return;
    }




    window.location.href = "redefinir_senha.js";
}