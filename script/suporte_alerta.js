 document.querySelectorAll('.caixa_selecione').forEach((el, idx) => {
            el.addEventListener('click', () => {
                el.dataset.selected = 'true';
                el.classList.remove('invalid');
            });
        });

        document.getElementById('submit-button').addEventListener('click', () => {
            let valid = true;
            document.querySelectorAll('.caixa_selecione').forEach(el => {
                if (el.dataset.selected !== 'true') {
                    el.classList.add('invalid');
                    valid = false;
                }
            });
            if (!valid) {
                alert('Por favor, selecione todos os campos antes de enviar.');
            } else {
                alert('Enviado com sucesso!');
               
            }
        });