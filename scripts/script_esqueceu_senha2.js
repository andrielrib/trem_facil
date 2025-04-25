function confirmarSenha() {
    const senha = document.getElementById("novaSenha").value;
    const confirmar = document.getElementById("confirmarSenha").value;
  
    if (!senha || !confirmar) {
      alert("Preencha os dois campos.");
    } else if (senha !== confirmar) {
      alert("As senhas não coincidem.");
    } else {
      alert("Senha redefinida com sucesso!");
   
    }
  }
  