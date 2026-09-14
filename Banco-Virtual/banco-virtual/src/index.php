<?php

session_start();

require_once __DIR__ . '/php/funcoes.php';
require_once __DIR__ . '/includes/flash.php';

if (contaExiste()) {
    header('Location: painel.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Banco Virtual - Abrir conta</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="pagina-login">

<div class="tela-login">

    <div class="login-vitrine">

        <div class="logo">
            <div class="logo-marca">
                <span class="logo-letra">B</span>
            </div>
            <div class="logo-texto">Banco Virtual</div>
        </div>

        <div class="vitrine-mensagem">
            <h1>Sua conta comeca aqui.</h1>
            <p>Abra uma conta simulada e acompanhe depositos, saques e o extrato completo em um so lugar.</p>
        </div>

        <div class="vitrine-rodape">
            Banco Virtual<br>
            Cooperativa financeira digital
        </div>

        <div class="forma forma-um"></div>
        <div class="forma forma-dois"></div>

    </div>

    <div class="login-formulario">

        <div class="cartao-login">

            <h2>Abrir conta</h2>
            <div class="subtitulo">Preencha os dados para comecar</div>

            <?php exibirAviso(); ?>

            <form method="post" action="php/logica.php">

                <input
                    type="hidden"
                    name="acao"
                    value="abrir"
                >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(gerarTokenCsrf(), ENT_QUOTES, 'UTF-8') ?>"
                >

                <label for="nome">
                    Nome do titular
                </label>

                <input
                    type="text"
                    name="nome"
                    id="nome"
                    placeholder="Digite o nome completo"
                    required
                    autofocus
                >

                <label for="saldo_inicial">
                    Saldo inicial (opcional)
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="saldo_inicial"
                    id="saldo_inicial"
                    placeholder="0,00"
                >

                <button
                    type="submit"
                    class="botao-principal"
                >
                    Abrir conta
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
