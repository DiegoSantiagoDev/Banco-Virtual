<?php

session_start();

require_once __DIR__ . '/php/funcoes.php';
require_once __DIR__ . '/includes/flash.php';

if (!contaExiste()) {
    header('Location: index.php');
    exit;
}

$paginaAtual = 'painel';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Banco Virtual - Painel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include __DIR__ . '/includes/barra-lateral.php'; ?>

<div class="area-principal">

    <div class="conteudo">

        <div class="corpo-conteudo">

            <div class="cabecalho">
                <div>
                    <h1>Ola, <?= htmlspecialchars($_SESSION['titular']) ?></h1>
                    <div class="subtitulo">Confira o resumo da sua conta</div>
                </div>
            </div>

            <?php exibirAviso(); ?>

            <div class="cartao-saldo">
                <div class="rotulo">Saldo disponivel</div>
                <div class="valor-saldo"><?= htmlspecialchars(formatarMoeda($_SESSION['saldo'])) ?></div>
            </div>

            <div class="grade-acoes">

                <div class="cartao">

                    <div class="icone-acao icone-deposito">+</div>

                    <h2>Depositar</h2>

                    <form method="post" action="php/logica.php">

                        <input type="hidden" name="acao" value="depositar">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(gerarTokenCsrf(), ENT_QUOTES, 'UTF-8') ?>">

                        <label for="valor_deposito">
                            Valor do deposito
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="valor"
                            id="valor_deposito"
                            placeholder="0,00"
                            required
                        >

                        <button type="submit" class="botao-principal">
                            Depositar
                        </button>

                    </form>

                </div>

                <div class="cartao">

                    <div class="icone-acao icone-saque">-</div>

                    <h2>Sacar</h2>

                    <form method="post" action="php/logica.php">

                        <input type="hidden" name="acao" value="sacar">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(gerarTokenCsrf(), ENT_QUOTES, 'UTF-8') ?>">

                        <label for="valor_saque">
                            Valor do saque
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="valor"
                            id="valor_saque"
                            placeholder="0,00"
                            required
                        >

                        <button type="submit" class="botao-principal">
                            Sacar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
