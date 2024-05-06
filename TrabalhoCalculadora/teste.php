<?php
session_start();

// Inicializa o histórico se ainda não estiver definido
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Limpa o histórico se solicitado
if (isset($_POST['clear_history'])) {
    $_SESSION['history'] = [];
}

// Processa a requisição de cálculo, se houver
if (isset($_POST['operacao'])) {
    $a = $_POST['num1'] ?? '';
    $b = $_POST['num2'] ?? '';
    $op = $_POST['operacao'] ?? '';

    if (!empty($op)) {
        if ($op == '+')
            $c = $a + $b;
        else if ($op == '-')
            $c = $a - $b;
        else if ($op == '*')
            $c = $a * $b;
        else
            $c = $a / $b;

        // Adiciona a operação ao histórico
        $operation = "$a $op $b = $c";
        $_SESSION['history'][] = $operation;
    }
}
?>

<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <title>Calculadora PHP</title>
    <meta charset="UTF-8">
    <style>
        /* Estilos CSS aqui */
    </style>
</head>
<body>
<div class="title-container">
    <h1>Calculadora PHP</h1>
</div>
<div class="calculator-container">
    <form action="" method="post" id="calculator-form">
        <label for="num1">Primeiro Número:</label> <input name="num1" id="num1" type="text"><br>
        <label for="num2">Segundo Número:</label> <input name="num2" id="num2" type="text"><br>
        <input type="submit" name="operacao" value="+">
        <input type="submit" name="operacao" value="-">
        <input type="submit" name="operacao" value="*">
        <input type="submit" name="operacao" value="/">
        <br>
    </form>
    <button onclick="saveOperation()">Salvar na Memória</button>
    <button onclick="retrieveOperation()">Recuperar Memória</button>
    <form action="" method="post">
        <input type="hidden" name="clear_history" value="1">
        <button type="submit">Limpar Histórico</button>
    </form>
    <div id="result">
        <?php
        // Exibe o resultado da última operação
        if (isset($c)) {
            echo 'O resultado da operação é: <span style="color: blue;">' . $c . '</span>';
        }
        ?>
    </div>
    <div id="history">
        <h2>Histórico de Operações</h2>
        <?php
        // Exibe o histórico diretamente da sessão
        foreach ($_SESSION['history'] as $operation) {
            echo "<p>$operation</p>";
        }
        ?>
    </div>
</div>

<script>
    function saveOperation() {
        var num1 = document.getElementById('num1').value;
        var num2 = document.getElementById('num2').value;
        var operacao = document.querySelector('input[name="operacao"]:checked');
        if (operacao) {
            operacao = operacao.value;
            sessionStorage.setItem('numero1', num1);
            sessionStorage.setItem('numero2', num2);
            sessionStorage.setItem('operacao', operacao);
        }
    }

    function retrieveOperation() {
        var num1 = sessionStorage.getItem('numero1');
        var num2 = sessionStorage.getItem('numero2');
        var operacao = sessionStorage.getItem('operacao');
        if (num1 !== null && num2 !== null && operacao !== null) {
            document.getElementById('num1').value = num1;
            document.getElementById('num2').value = num2;
            document.querySelector('input[name="operacao"][value="' + operacao + '"]').checked = true;
        }
    }
</script>

</body>
</html>
