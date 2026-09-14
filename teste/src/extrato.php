<?php

session_start();

require_once __DIR__ . '/php/funcoes.php';
require_once __DIR__ . '/includes/flash.php';

if (!contaExiste()) {
    header('Location: index.php');
    exit;
}

$paginaAtual = 'extrato';
$transacoes = $_SESSION['transacoes'] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Banco Virtual - Extrato</title>

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
                    <h1>Extrato</h1>
                    <div class="subtitulo">Historico de movimentacoes da conta</div>
                </div>
            </div>

            <?php exibirAviso(); ?>

            <div class="cartao">

                <?php if (empty($transacoes)): ?>

                    <div class="extrato-vazio">
                        <span class="icone-vazio">i</span>
                        Nenhuma movimentacao ainda. Deposite ou saque para ver o extrato aqui.
                    </div>

                <?php else: ?>

                    <div class="lista-extrato">

                        <?php foreach ($transacoes as $transacao): ?>

                            <?php $ehDeposito = $transacao['tipo'] === 'Deposito'; ?>

                            <div class="item-extrato">

                                <div class="info-esquerda">
                                    <span class="marcador-tipo <?= $ehDeposito ? 'deposito' : 'saque' ?>">
                                        <?= $ehDeposito ? '+' : '-' ?>
                                    </span>
                                    <div>
                                        <div class="tipo"><?= htmlspecialchars($transacao['tipo']) ?></div>
                                        <div class="horario"><?= htmlspecialchars($transacao['horario']) ?></div>
                                    </div>
                                </div>

                                <div class="valor <?= $ehDeposito ? 'deposito' : 'saque' ?>">
                                    <?= htmlspecialchars(formatarMoeda($transacao['valor'])) ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>
