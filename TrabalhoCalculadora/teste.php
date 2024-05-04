<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <title>Calculadora PHP</title>
    <meta charset="UTF-8">
    <style>
        :root {
            --primary-color: #6a0dad;
            --secondary-color: #9c27b0;
            --text-color: #fff;
            --shadow-color: rgba(255, 255, 255, 0.3);
            --neon-color: #4B0082;
            --result-color: #FF1493; /* Cor para o resultado da operação */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .title-container {
            margin-bottom: 20px;
        }

        .calculator-container {
            width: 300px;
            background-color: #222;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 20px var(--shadow-color);
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: var(--text-color);
        }

        input[type="text"], input[type="submit"] {
            width: calc(50% - 5px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #222;
            color: var(--text-color);
            box-shadow: 0 0 10px var(--shadow-color);
        }

        input[type="submit"] {
            background-color: var(--primary-color);
            color: var(--text-color);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            border: 1px solid #ccc;
            background-color: var(--secondary-color);
            box-shadow: 0 0 20px #9370DB;
        }

        button {
            background-color: var(--primary-color);
            color: var(--text-color);
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            border: 1px solid #ccc;
            background-color: var(--secondary-color);
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
            color: var(--text-color); /* Alterado para cor padrão */
            text-shadow: 0 0 10px var(--shadow-color);
        }

        .neon-text {
            font-size: 18px;
            color: var(--text-color);
            text-shadow: 0 0 5px var(--neon-color), 0 0 10px var(--neon-color), 0 0 15px var(--neon-color), 0 0 20px var(--neon-color), 0 0 35px var(--neon-color), 0 0 40px var(--neon-color), 0 0 50px var(--neon-color), 0 0 75px var(--neon-color);text-shadow: 0 0 10px var(--neon-color), 0 0 20px var(--neon-color), 0 0 30px var(--neon-color), 0 0 40px var(--neon-color), 0 0 70px var(--neon-color), 0 0 80px var(--neon-color), 0 0 100px var(--neon-color), 0 0 150px var(--neon-color);
        }

        h1 {
            color: var(--text-color);
            text-shadow: 0 0 10px var(--shadow-color);
            margin: 0;
        }

        #history {
            margin-top: 20px;
            color: var(--text-color);
            text-align: left;
        }
    </style>
</head>
<body>
<div class="title-container">
    <h1>Calculadora PHP</h1>
</div>
<div class="calculator-container">
    <form action="" method="post" id="calculator-form">
        <label for="num1">Primeiro Número:</label> <input name="num1" type="text"><br>
        <label for="num2">Segundo Número:</label> <input name="num2" type="text"><br>
        <input type="submit" name="operacao" value="+">
        <input type="submit" name="operacao" value="-">
        <input type="submit" name="operacao" value="*">
        <input type="submit" name="operacao" value="/">
        <br>
    </form>
    <button onclick="saveToMemory()">Salvar na Memória</button>
    <button onclick="retrieveFromMemory()">Recuperar Memória</button>
    <button onclick="clearHistory()">Limpar Histórico</button>
    <div id="result"></div>
    <div id="history"></div>
</div>

<?php

session_start();

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
    $history = $_SESSION['history'] ?? [];
    $history[] = "$a $op $b = $c";
    $_SESSION['history'] = $history;

    echo "<script>document.getElementById('result').innerHTML = 'O resultado da operação é: <span style=\"color: var(--result-color);\">$c</span>';</script>";
}

?>

<script>
    function saveToMemory() {
        var num1 = document.querySelector('input[name="num1"]').value;
        var num2 = document.querySelector('input[name="num2"]').value;
        var operacao = document.querySelector('input[name="operacao"]:checked');
        if (operacao)
            operacao = operacao.value;
        sessionStorage.setItem('numero1', num1);
        sessionStorage.setItem('numero2', num2);
        sessionStorage.setItem('operacao', operacao);
    }

    function retrieveFromMemory() {
        var num1 = sessionStorage.getItem('numero1');
        var num2 = sessionStorage.getItem('numero2');
        var operacao = sessionStorage.getItem('operacao');
        if (num1 !== null && num2 !== null && operacao !== null) {
            document.querySelector('input[name="num1"]').value = num1;
            document.querySelector('input[name="num2"]').value = num2;
            if (operacao)
                document.querySelector('input[name="operacao"][value="' + operacao + '"]').checked = true;
        }
    }

    function clearHistory() {
        document.getElementById('history').innerHTML = '';
        sessionStorage.removeItem('history');
    }

    // Exibe o histórico armazenado na sessão
    var history = <?php echo json_encode($_SESSION['history'] ?? []) ?>;
    var historyHtml = "<h2>Histórico de Operações</h2>";
    history.forEach(function(operation) {
        historyHtml += "<p>" + operation + "</p>";
    });
    document.getElementById('history').innerHTML = historyHtml;
</script>

</body>
</html>