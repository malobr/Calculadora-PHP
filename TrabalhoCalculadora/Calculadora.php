<?php
session_start();
if (isset($_POST['clear_history'])) {
    unset($_SESSION['history']);
}

if (isset($_POST['save_to_memory'])) {
    if (isset($_POST['num1']) && isset($_POST['num2']) && isset($_POST['operacao'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operacao = $_POST['operacao'];
        $_SESSION['memory'] = array($num1, $num2, $operacao);
    }
}

if (isset($_POST['retrieve_from_memory'])) {
    if (isset($_SESSION['memory'])) {
        $num1 = $_SESSION['memory'][0];
        $num2 = $_SESSION['memory'][1];
        $operacao = $_SESSION['memory'][2];
        echo "<script>
                  document.querySelector('input[name=\"num1\"]').value = '$num1';
                  document.querySelector('input[name=\"num2\"]').value = '$num2'; 
                  document.querySelector('input[name=\"operacao\"][value=\"$operacao\"]').checked = true; 
               </script>";
    }
}
?>
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
            --result-color: #FF1493; 
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
            width: 350px;
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
            width: calc(50% - 5px); 
        }

        button:hover {
            border: 1px solid #ccc;
            background-color: var(--secondary-color);
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
            color: var(--text-color); 
        }

        h1 {
            color: var(--text-color);
            text-shadow: 0 0 10px var(--shadow-color);
            margin: 0;
        }

        #history {
            margin-top: 20px;
            color: var(--text-color);
        }

        #history p {
            margin: 5px 0;
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
            <input type="submit" name="operacao" value="!">  
            <input type="submit" name="operacao" value="^">  
            <br>
        </form> 
        <form method="post" id="memory-form">
            <button type="submit" name="save_to_memory">Salvar na Memória</button>
            <button type="submit" name="retrieve_from_memory">Recuperar Memória</button>
            <button onclick="saveOrRetrieve()">M</button>
            <button type="submit" name="clear_history">Limpar Histórico</button>
            <div id="result"></div>
            <div id="history">
                <h3>Histórico das Operações:</h3>
                <?php
                if(isset($_SESSION['history'])) {
                    foreach($_SESSION['history'] as $item) {
                        echo "<p>$item</p>";
                    }
                }
                ?>
            </div>
        </form>
    </div>

    <?php
    $a = isset($_POST['num1']) ? $_POST['num1'] : null;
    $b = isset($_POST['num2']) ? $_POST['num2'] : null;
    $op = isset($_POST['operacao']) ? $_POST['operacao'] : null;

    if (!empty($op)) {
        if ($op == '+')
            $c = $a + $b;
        else if ($op == '-')
            $c = $a - $b;
        else if ($op == '*')
            $c = $a * $b;
        else if ($op == '/')
            $c = $a / $b;
        else if ($op == '!')
            $c = factorial($a);
        else if ($op == '^')
            $c = power($a, $b);

        if ($op == '!')
            echo "<script>document.getElementById('result').innerHTML = 'O fatorial de $a é: <span style=\"color: var(--result-color);\">$c</span>';</script>";
        else if ($op == '^')
            echo "<script>document.getElementById('result').innerHTML = 'O resultado da potência é: <span style=\"color: var(--result-color);\">$c</span>';</script>";
        else
            echo "<script>document.getElementById('result').innerHTML = 'O resultado da operação é: <span style=\"color: var(--result-color);\">$c</span>';</script>";

        $history_item = "$a $op $b = $c";
        $_SESSION['history'][] = $history_item;
    }

    function factorial($n) {
        if ($n === 0) return 1;
        return $n * factorial($n - 1);
    }

    function power($x, $y) {
        return pow($x, $y);
    }
    ?>

<script>
        function saveOrRetrieve() {
            var num1 = document.querySelector('input[name="num1"]').value;
            var num2 = document.querySelector('input[name="num2"]').value;
            var operacao = document.querySelector('input[name="operacao"]:checked');
            if (operacao) operacao = operacao.value;
            var num1_saved = sessionStorage.getItem('numero1');
            var num2_saved = sessionStorage.getItem('numero2');
            var operacao_saved = sessionStorage.getItem('operacao');

            if (num1_saved && num2_saved && operacao_saved) {
                document.querySelector('input[name="num1"]').value = num1_saved;
                document.querySelector('input[name="num2"]').value = num2_saved;
                if (operacao_saved)
                    document.querySelector('input[name="operacao"][value="' + operacao_saved + '"]').checked = true;
                sessionStorage.removeItem('numero1');
                sessionStorage.removeItem('numero2');
                sessionStorage.removeItem('operacao');
            } else {
                sessionStorage.setItem('numero1', num1);
                sessionStorage.setItem('numero2', num2);
                sessionStorage.setItem('operacao', operacao);
            }
        }
    </script>
</body>
</html>
