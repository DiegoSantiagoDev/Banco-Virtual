# Banco-Virtual

Projeto de banco virtual desenvolvido em PHP puro, HTML e CSS, sem JavaScript, frameworks ou POO.

## Funcionalidades

- Abertura de conta simulada
- Deposito
- Saque
- Consulta de saldo
- Extrato de movimentacoes
- Encerramento da conta
- Mensagens de sucesso e erro
- Protecao CSRF nos formularios
- Validacao dos dados no servidor

## Valores monetarios

O projeto nao utiliza `float` para dinheiro. Os valores sao tratados com precisao de centavos, usando strings e inteiros em centavos nas operacoes. Isso evita erros de precisao comuns em calculos com ponto flutuante.

Em PHP nao existe `BigDecimal` nativo como no Java. O uso de centavos inteiros neste projeto cumpre a mesma finalidade para valores com duas casas decimais e nao depende da extensao BCMath.

## Tecnologias

- PHP
- HTML
- CSS
- Sessoes do PHP
