<?php

session_start();

require_once __DIR__ . '/php/funcoes.php';
require_once __DIR__ . '/includes/flash.php';

if (!contaExiste()) {
    header('Location: index.php');
    exit;
}

$paginaAtual = 'configuracoes';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Banco Virtual - Configuracoes</title>

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
                    <h1>Configuracoes</h1>
                    <div class="subtitulo">Dados da sua conta</div>
                </div>
            </div>

            <?php exibirAviso(); ?>

            <div class="cartao">

                <h2>Dados da conta</h2>

                <div class="linha-info">
                    <span>Titular</span>
                    <strong><?= htmlspecialchars($_SESSION['titular']) ?></strong>
                </div>

                <div class="linha-info">
                    <span>Saldo atual</span>
                    <strong><?= htmlspecialchars(formatarMoeda($_SESSION['saldo'])) ?></strong>
                </div>

            </div>

            <div class="cartao cartao-perigo">

                <h2>Encerrar conta</h2>
                <p class="subtitulo">Isso apaga a conta simulada e todo o historico de movimentacoes.</p>

                <form method="post" action="php/logica.php">
                    <input type="hidden" name="acao" value="encerrar">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(gerarTokenCsrf(), ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="botao-secundario">
                        Encerrar conta
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>
