<?php
session_start();

// Função para calcular fatorial
function factorial($n)
{
    if ($n <= 1) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

// Função para calcular potência
function power($x, $y)
{
    return pow($x, $y);
}

// Função para limpar o histórico
function clearHistory()
{
    $_SESSION['history'] = array();
}

// Inicialização do histórico
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
}

// Verificar se foi pressionado o botão de memória
if (isset($_POST['memory'])) {
    if (!isset($_SESSION['memory'])) {
        $_SESSION['memory'] = array();
    }

    if (empty($_SESSION['memory'])) {
        $_SESSION['memory'] = array(
            'num1' => $_POST['num1'],
            'num2' => $_POST['num2'],
            'operation' => $_POST['operation']
        );
    } else {
        $_POST['num1'] = $_SESSION['memory']['num1'];
        $_POST['num2'] = $_SESSION['memory']['num2'];
        $_POST['operation'] = $_SESSION['memory']['operation'];
    }
}

// Verificar se foi pressionado o botão de limpar a memória
if (isset($_POST['clear_memory'])) {
    $_SESSION['memory'] = array();
    $_SESSION['memory_operation'] = '';
}

// Verificar se foi pressionado o botão de limpar o histórico
if (isset($_POST['clear_history'])) {
    clearHistory();
}

// Realizar a operação
if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    $result = 0;

    switch ($operation) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            if ($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = "Erro: divisão por zero";
            }
            break;
        case 'n!':
            $result = factorial($num1);
            break;
        case 'x^y':
            $result = power($num1, $num2);
            break;
        default:
            $result = "Operação inválida";
            break;
    }

    // Adicionar à sessão o histórico
    $history_item = array('num1' => $num1, 'num2' => $num2, 'operation' => $operation, 'result' => $result);
    array_push($_SESSION['history'], $history_item);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
    
    :root {
    --neon-green: #0f0;
    --neon-pink: #ff00ff;
    --black: #000;
    --white: #fff;
}

body {
    font-family: 'Gothic A1', 'Bebas Neue', 'Roboto Condensed', sans-serif;
    margin: 0;
    padding: 0;
    background-color: var(--black);
    color: var(--white);
}

.wrapper {
    background-color: var(--black);
    padding: 20px;
}

.container {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: var(--black);
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
}

h2,
h3 {
    text-align: center;
    color: var(--neon-green);
    margin-bottom: 20px;
    text-shadow: 0 0 10px var(--neon-green); /* Adicionando sombra neon */
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
}

.input-group {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 15px;
}

.input-group>* {
    flex: 1;
    margin-right: 10px;
}

input[type="text"],
select,
input[type="submit"],
input[type="button"] {
    padding: 10px;
    border: 1px solid var(--neon-green);
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    background-color: var(--black);
    color: var(--neon-green);
}

input[type="submit"]:hover,
input[type="button"]:hover {
    background-color: var(--neon-green);
    color: var(--black);
    border-color: var(--neon-green);
    transition: background-color 0.3s ease;
}

input[name="memory"],
input[name="clear_memory"] {
    background-color: var(--black);
    color: var(--neon-pink);
    border: 1px solid var(--neon-pink);
    border-radius: 5px;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
    margin-top: 5px;
    margin-bottom: 5px;
    margin-right: 5px;
}

input[name="memory"]:hover,
input[name="clear_memory"]:hover {
    background-color: var(--neon-pink);
    color: var(--black);
    border-color: var(--neon-pink);
    transition: background-color 0.3s ease;
}

ul {
    list-style-type: none;
    padding: 0;
    text-align: center;
    margin-top: 20px;
}

li {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    background-color: var(--black);
    box-shadow: 0 2px 5px rgba(255, 255, 255, 0.1);
    color: var(--neon-green);
    text-shadow: 0 0 10px var(--neon-green); /* Adicionando sombra neon */
}

h3 {
    text-align: center;
    color: var(--neon-green);
    text-shadow: 0 0 10px var(--neon-green); /* Adicionando sombra neon */
}

    </style>
</head>

<body>
    <div class="wrapper">
        <h2>CyberCalculadora PHP</h2>
        <div class="container">
            <form method="post">
                Primeiro Numero: <input type="text" name="num1"
                    value="<?php echo isset($_POST['num1']) ? $_POST['num1'] : ''; ?>"><br><br>
                Segundo Numero: <input type="text" name="num2"
                    value="<?php echo isset($_POST['num2']) ? $_POST['num2'] : ''; ?>"><br><br>
                Operação:
                <select name="operation">
                    <option value="+">+ (Soma)</option>
                    <option value="-">- (Subtracao)</option>
                    <option value="*">* (MUltiplicacao)</option>
                    <option value="/">/ (Divisao)</option>
                    <option value="n!">n! (Fatorial)</option>
                    <option value="x^y">x^y (Potencia)</option>
                </select><br><br>
                <input type="submit" name="calculate" value="Fazer o Calculo">
                <input type="submit" name="memory" value="Salvar e Recuperar Memoria">
                <input type="submit" name="clear_memory" value="Limpar a Memoria">
                <input type="submit" name="clear_history" value="Limpar o Historico">
            </form>

            <?php if (isset($result)) : ?>
            <h3>Resultado: <?php echo $result; ?></h3>
            <?php endif; ?>

        </div>
        <div class="container">
        <h3>Historico de Operacoes:</h3>
        <ul>
            <?php foreach ($_SESSION['history'] as $item) : ?>
            <li><?php echo $item['num1'] . ' ' . $item['operation'] . ' ' . $item['num2'] . ' = ' . $item['result']; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>
</body>

</html>