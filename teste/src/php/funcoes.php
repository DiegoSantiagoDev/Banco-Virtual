<?php

function valorMonetarioValido($valor): bool
{
    if (!is_string($valor)) {
        return false;
    }

    $valor = trim($valor);

    return $valor !== '' && preg_match('/^\d{1,9}([.,]\d{1,2})?$/', $valor) === 1;
}

function normalizarValor($valor): ?string
{
    if (!valorMonetarioValido($valor)) {
        return null;
    }

    $valor = str_replace(',', '.', trim($valor));

    if (!str_contains($valor, '.')) {
        return $valor . '.00';
    }

    [$inteiro, $decimal] = explode('.', $valor, 2);
    return $inteiro . '.' . str_pad($decimal, 2, '0');
}

function valorParaCentavos(string $valor): ?int
{
    $valor = normalizarValor($valor);

    if ($valor === null) {
        return null;
    }

    [$inteiro, $decimal] = explode('.', $valor);
    $centavos = ((int) $inteiro * 100) + (int) $decimal;

    return $centavos;
}

function centavosParaValor(int $centavos): string
{
    if ($centavos < 0) {
        $centavos = 0;
    }

    $inteiro = intdiv($centavos, 100);
    $decimal = $centavos % 100;

    return $inteiro . '.' . str_pad((string) $decimal, 2, '0', STR_PAD_LEFT);
}

function formatarMoeda(string $valor): string
{
    $valor = normalizarValor($valor);

    if ($valor === null) {
        return 'R$ 0,00';
    }

    [$inteiro, $decimal] = explode('.', $valor);
    $inteiroFormatado = preg_replace('/\B(?=(\d{3})+(?!\d))/', '.', $inteiro);

    return 'R$ ' . $inteiroFormatado . ',' . $decimal;
}

function contaExiste(): bool
{
    return isset($_SESSION['titular'], $_SESSION['saldo'])
        && is_string($_SESSION['titular'])
        && is_string($_SESSION['saldo'])
        && normalizarValor($_SESSION['saldo']) !== null;
}

function abrirConta(string $nome, string $saldoInicial): string
{
    $nome = trim($nome);
    $saldoInicialNormalizado = normalizarValor($saldoInicial);

    if ($nome === '') {
        return 'Erro: informe o nome do titular.';
    }

    $tamanhoNome = preg_match_all('/./us', $nome, $partes);

    if ($tamanhoNome === false || $tamanhoNome < 3 || $tamanhoNome > 80) {
        return 'Erro: o nome deve ter entre 3 e 80 caracteres.';
    }

    if (preg_match('/\d/', $nome)) {
        return 'Erro: o nome nao pode conter numeros.';
    }

    if ($saldoInicialNormalizado === null) {
        return 'Erro: informe um saldo inicial valido com ate 2 casas decimais.';
    }

    $saldoInicialCentavos = valorParaCentavos($saldoInicialNormalizado);

    if ($saldoInicialCentavos === null || $saldoInicialCentavos < 0) {
        return 'Erro: o saldo inicial nao pode ser negativo.';
    }

    session_regenerate_id(true);

    $_SESSION['titular'] = $nome;
    $_SESSION['saldo'] = centavosParaValor($saldoInicialCentavos);
    $_SESSION['transacoes'] = [];

    return 'Conta aberta com sucesso para ' . $nome . '.';
}

function registrarTransacao(string $tipo, string $valor): void
{
    if (!isset($_SESSION['transacoes']) || !is_array($_SESSION['transacoes'])) {
        $_SESSION['transacoes'] = [];
    }

    array_unshift($_SESSION['transacoes'], [
        'tipo' => $tipo,
        'valor' => normalizarValor($valor) ?? '0.00',
        'horario' => date('d/m/Y H:i:s'),
    ]);
}

function depositar(string $valor): string
{
    if (!contaExiste()) {
        return 'Erro: nenhuma conta aberta.';
    }

    $valorNormalizado = normalizarValor($valor);
    $valorCentavos = $valorNormalizado !== null ? valorParaCentavos($valorNormalizado) : null;
    $saldoCentavos = valorParaCentavos($_SESSION['saldo']);

    if ($valorCentavos === null || $valorCentavos <= 0) {
        return 'Erro: o valor do deposito deve ser maior que zero e ter ate 2 casas decimais.';
    }

    if ($saldoCentavos === null) {
        return 'Erro: saldo invalido.';
    }

    $_SESSION['saldo'] = centavosParaValor($saldoCentavos + $valorCentavos);
    registrarTransacao('Deposito', $valorNormalizado);

    return 'Deposito de ' . formatarMoeda($valorNormalizado) . ' realizado com sucesso.';
}

function sacar(string $valor): string
{
    if (!contaExiste()) {
        return 'Erro: nenhuma conta aberta.';
    }

    $valorNormalizado = normalizarValor($valor);
    $valorCentavos = $valorNormalizado !== null ? valorParaCentavos($valorNormalizado) : null;
    $saldoCentavos = valorParaCentavos($_SESSION['saldo']);

    if ($valorCentavos === null || $valorCentavos <= 0) {
        return 'Erro: o valor do saque deve ser maior que zero e ter ate 2 casas decimais.';
    }

    if ($saldoCentavos === null) {
        return 'Erro: saldo invalido.';
    }

    if ($valorCentavos > $saldoCentavos) {
        return 'Erro: saldo insuficiente. Voce tem ' .
            formatarMoeda($_SESSION['saldo']) . ' disponivel.';
    }

    $_SESSION['saldo'] = centavosParaValor($saldoCentavos - $valorCentavos);
    registrarTransacao('Saque', $valorNormalizado);

    return 'Saque de ' . formatarMoeda($valorNormalizado) . ' realizado com sucesso.';
}

function encerrarConta(): string
{
    unset($_SESSION['titular'], $_SESSION['saldo'], $_SESSION['transacoes']);

    return 'Conta encerrada. Voce pode abrir uma nova conta.';
}

function gerarTokenCsrf(): string
{
    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validarTokenCsrf($token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && is_string($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
