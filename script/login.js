 document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^\d{10,15}$/;

            if (!username || !(emailRegex.test(username) || phoneRegex.test(username))) {
                alert('Por favor, insira um email ou telefone válido.');
                return;
            }

            if (!password) {
                alert('Por favor, insira sua senha.');
                return;
            }

            alert('Login válido! Prosseguindo...');
            window.location.href = "rotas.html";
        });
 
       