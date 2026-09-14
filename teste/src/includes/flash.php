<?php

function exibirAviso(): void
{
    if (!isset($_SESSION['aviso']) || !is_array($_SESSION['aviso'])) {
        return;
    }

    $aviso = $_SESSION['aviso'];
    unset($_SESSION['aviso']);

    $classe = ($aviso['tipo'] ?? '') === 'erro' ? 'erro' : 'sucesso';
    $texto = is_string($aviso['texto'] ?? null) ? $aviso['texto'] : '';

    echo '<div class="aviso ' . $classe . '">' . htmlspecialchars($texto, ENT_QUOTES, 'UTF-8') . '</div>';
}
