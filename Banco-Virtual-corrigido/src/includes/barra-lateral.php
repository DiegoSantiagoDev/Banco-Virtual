<?php
/*
 * BARRA LATERAL
 *
 * Espera que a variavel $paginaAtual esteja definida antes do include,
 * com um dos valores: 'painel', 'extrato' ou 'configuracoes'.
 */
?>
<div class="barra-lateral">

    <div class="logo">
        <div class="logo-marca">
            <span class="logo-letra">B</span>
        </div>
        <div class="logo-texto">Banco Virtual</div>
    </div>

    <div class="menu">
        <a href="painel.php" class="menu-item <?= $paginaAtual === 'painel' ? 'ativo' : '' ?>">Painel</a>
        <a href="extrato.php" class="menu-item <?= $paginaAtual === 'extrato' ? 'ativo' : '' ?>">Extrato</a>
        <a href="configuracoes.php" class="menu-item <?= $paginaAtual === 'configuracoes' ? 'ativo' : '' ?>">Configuracoes</a>
    </div>

    <div class="rodape-lateral">
        Conta de<br>
        <strong><?= htmlspecialchars($_SESSION['titular'] ?? '') ?></strong>
    </div>

</div>
