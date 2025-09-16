document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('codigo');

    input.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            const code = input.value.trim();
            if (/^\d{6}$/.test(code)) {
                window.location.href = 'redefinir_senha'; 
            } else {
                alert("Digite um código de 6 dígitos válido.");
            }
        }
    });

    window.reenviarCodigo = () => {
        location.reload();
    };
});