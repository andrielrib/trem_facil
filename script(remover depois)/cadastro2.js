document.getElementById('formulario_cadas_2').addEventListener('submit', function(e) {
        e.preventDefault();

        const telefone = document.getElementById('telefone').value.trim();
        const senha = document.getElementById('senha').value.trim();
        const confirmar = document.getElementById('confirmar_senha').value.trim();

        const phoneRegex = /^\d{10,15}$/;

        if (!telefone || !phoneRegex.test(telefone)) {
            alert('Por favor, insira um telefone válido (somente números, entre 10 e 15 dígitos).');
            return;
        }

        if (!senha || senha.length < 6) {
            alert('A senha deve conter pelo menos 6 caracteres.');
            return;
        }

        if (senha !== confirmar) {
            alert('As senhas não coincidem.');
            return;
        }

        alert('Cadastro validado com sucesso!');
       window.location.href = "rotas.html"
    });