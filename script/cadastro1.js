document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();


    const nome = document.getElementById('nome_completo').value.trim();
    const cpf = document.getElementById('cpf').value.trim();
    const cep = document.getElementById('cep').value.trim();
    const email = document.getElementById('email').value.trim();


    const cpfRegex = /^\d{11}$/;
    const cepRegex = /^\d{8}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    if (nome.length < 5) {
        alert("Por favor, preencha o nome completo com pelo menos 5 caracteres.");
        return;
    }


    if (!cpfRegex.test(cpf)) {
        alert("CPF inválido. Deve conter exatamente 11 números.");
        return;
    }


    if (!cepRegex.test(cep)) {
        alert("CEP inválido. Deve conter exatamente 8 números.");
        return;
    }


    if (!emailRegex.test(email)) {
        alert("E-mail inválido. Por favor, insira um e-mail válido.");
        return;
    }


    alert("Primeira etapa concluída");
  window.location.href = 'cadastro2.html'
});