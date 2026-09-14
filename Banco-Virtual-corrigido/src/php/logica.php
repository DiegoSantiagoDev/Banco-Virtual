<?php

session_start();

require_once __DIR__ . '/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$acao = isset($_POST['acao']) && is_string($_POST['acao']) ? $_POST['acao'] : '';
$token = $_POST['csrf_token'] ?? null;

if (!validarTokenCsrf($token)) {
    $_SESSION['aviso'] = [
        'tipo' => 'erro',
        'texto' => 'Erro: requisicao invalida. Tente novamente.',
    ];

    header('Location: ../index.php');
    exit;
}

$mensagem = '';
$redirecionarPara = '../index.php';

switch ($acao) {
    case 'abrir':
        $nome = isset($_POST['nome']) && is_string($_POST['nome']) ? $_POST['nome'] : '';
        $saldoInicial = isset($_POST['saldo_inicial']) && is_string($_POST['saldo_inicial'])
            ? trim($_POST['saldo_inicial'])
            : '0';

        if ($saldoInicial === '') {
            $saldoInicial = '0';
        }

        $mensagem = abrirConta($nome, $saldoInicial);
        $redirecionarPara = contaExiste() ? '../painel.php' : '../index.php';
        break;

    case 'depositar':
        $valor = isset($_POST['valor']) && is_string($_POST['valor']) ? $_POST['valor'] : '';
        $mensagem = depositar($valor);
        $redirecionarPara = '../painel.php';
        break;

    case 'sacar':
        $valor = isset($_POST['valor']) && is_string($_POST['valor']) ? $_POST['valor'] : '';
        $mensagem = sacar($valor);
        $redirecionarPara = '../painel.php';
        break;

    case 'encerrar':
        $mensagem = encerrarConta();
        $redirecionarPara = '../index.php';
        break;

    default:
        $mensagem = 'Erro: acao invalida.';
        $redirecionarPara = '../index.php';
        break;
}

if ($mensagem !== '') {
    $_SESSION['aviso'] = [
        'tipo' => str_starts_with($mensagem, 'Erro') ? 'erro' : 'sucesso',
        'texto' => $mensagem,
    ];
}

header('Location: ' . $redirecionarPara);
exit;
