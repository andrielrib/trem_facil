<?php
session_start();

// Initialize variables
$nome_completo = $cpf = $cep = $email = "";
$errors = [];

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $nome_completo = trim($_POST['nome_completo']);
    $cpf = trim($_POST['cpf']);
    $cep = trim($_POST['cep']);
    $email = trim($_POST['email']);

    // Name validation
    if (empty($nome_completo)) {
        $errors[] = "Nome completo é obrigatório.";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome_completo)) {
        $errors[] = "Nome deve conter apenas letras e espaços.";
    } elseif (strlen($nome_completo) < 3) {
        $errors[] = "Nome deve ter pelo menos 3 caracteres.";
    }

    // CPF validation
    $cpf_clean = preg_replace('/\D/', '', $cpf);
    if (empty($cpf)) {
        $errors[] = "CPF é obrigatório.";
    } elseif (strlen($cpf_clean) != 11) {
        $errors[] = "CPF deve ter 11 dígitos.";
    } elseif (!$this->validateCPF($cpf_clean)) {
        $errors[] = "CPF inválido.";
    }

    // CEP validation
    $cep_clean = preg_replace('/\D/', '', $cep);
    if (empty($cep)) {
        $errors[] = "CEP é obrigatório.";
    } elseif (strlen($cep_clean) != 8) {
        $errors[] = "CEP deve ter 8 dígitos.";
    }

    // Email validation
    if (empty($email)) {
        $errors[] = "Email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    // If no errors, store data and redirect
    if (empty($errors)) {
        $_SESSION['cadastro1'] = [
            'nome_completo' => $nome_completo,
            'cpf' => $cpf_clean,
            'cep' => $cep_clean,
            'email' => $email
        ];

        header("Location: cadastro2.php");
        exit();
    }
}

// CPF validation function
function validateCPF($cpf) {
    // Remove any non-numeric characters
    $cpf = preg_replace('/\D/', '', $cpf);

    // Check if CPF has 11 digits
    if (strlen($cpf) != 11) {
        return false;
    }

    // Check if all digits are the same
    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    // Calculate first verification digit
    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += $cpf[$i] * (10 - $i);
    }
    $first_digit = ($sum * 10) % 11;
    if ($first_digit == 10) $first_digit = 0;

    // Calculate second verification digit
    $sum = 0;
    for ($i = 0; $i < 10; $i++) {
        $sum += $cpf[$i] * (11 - $i);
    }
    $second_digit = ($sum * 10) % 11;
    if ($second_digit == 10) $second_digit = 0;

    return $cpf[9] == $first_digit && $cpf[10] == $second_digit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Parte 1</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .error-message {
            color: #ff5757;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        .success-message {
            color: #00bf63;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input:focus {
            outline: 2px solid #00bf63;
            outline-offset: 2px;
        }
    </style>
</head>

<body>
    <div class="cadastro1_icon">
        <img src="../assets/icons/trem_bala_icon.png" alt="Ícone Trem" width="260" height="210">
    </div>
    <br>
    <br>
    <br>

    <?php if (!empty($errors)): ?>
        <div style="color: #ff5757; text-align: center; margin: 10px 0;">
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div>
        <form id="formulario_cadas_1" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <strong><p class="margin_cadastro2">Nome completo:</p></strong>
            <input type="text"
                   class="caixa_login"
                   id="nome_completo"
                   name="nome_completo"
                   value="<?php echo htmlspecialchars($nome_completo); ?>"
                   required
                   placeholder="Digite seu nome completo">

            <strong><p class="margin_cadastro2">CPF:</p></strong>
            <input type="text"
                   class="caixa_login"
                   id="cpf"
                   name="cpf"
                   value="<?php echo htmlspecialchars($cpf); ?>"
                   required
                   placeholder="000.000.000-00"
                   maxlength="14">

            <strong><p class="margin_cadastro2">CEP:</p></strong>
            <input type="text"
                   class="caixa_login"
                   id="cep"
                   name="cep"
                   value="<?php echo htmlspecialchars($cep); ?>"
                   required
                   placeholder="00000-000"
                   maxlength="9">

            <strong><p class="margin_cadastro2">Email:</p></strong>
            <input type="email"
                   class="caixa_login"
                   id="email"
                   name="email"
                   value="<?php echo htmlspecialchars($email); ?>"
                   required
                   placeholder="seu.email@exemplo.com">

            <br><br>
            <div class="final_cadastro2">
                <a href="cadastro2.php"><button type="submit" class="caixa_verde_cadastro2"><p class="centralizar_cadastro2">PRÓXIMO</p></button></a>
            </div>
        </form>
    </div>

    <div class="flex_circulo">
        <div class="circulo_esquerda_cadastro2"></div>
        <div class="circulo_direita_cadastro2"></div>
    </div>

    <script>
        // Client-side validation and formatting
        document.addEventListener('DOMContentLoaded', function() {
            const nomeInput = document.getElementById('nome_completo');
            const cpfInput = document.getElementById('cpf');
            const cepInput = document.getElementById('cep');
            const emailInput = document.getElementById('email');

            // Name formatting
            nomeInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
                this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
            });

            // CPF formatting
            cpfInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length <= 11) {
                    this.value = this.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                }
            });

            // CEP formatting
            cepInput.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length <= 8) {
                    this.value = this.value.replace(/(\d{5})(\d{3})/, '$1-$2');
                }
            });

            // Email validation on blur
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    alert('Por favor, insira um email válido.');
                    this.focus();
                }
            });
        });
    </script>
</body>
</html>
