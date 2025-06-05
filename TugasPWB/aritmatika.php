<?php
session_start();

// Inisialisasi input jika belum ada
if (!isset($_SESSION['input'])) {
    $_SESSION['input'] = '';
}

// Tombol ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btn = $_POST['btn'];

    if ($btn === 'C') {
        $_SESSION['input'] = '';
    } elseif ($btn === '=') {
        try {
            // Evaluasi ekspresi
            $result = eval('return ' . $_SESSION['input'] . ';');
            $_SESSION['input'] = $result;
        } catch (Throwable $e) {
            $_SESSION['input'] = 'Error';
        }
    } else {
        $_SESSION['input'] .= $btn;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator</title>
    <style>
        body {
            background: #000;
            font-family: 'Helvetica Neue', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .calculator {
            width: 300px;
            background: #000;
            border-radius: 40px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
        }
        .display {
            background: #000;
            color: #fff;
            text-align: right;
            font-size: 48px;
            padding: 20px;
            border-bottom: 1px solid #222;
            border-radius: 20px;
            min-height: 80px;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
        }
        .display::-webkit-scrollbar {
            display: none;
        }

        form {
            margin-top: 10px;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        button {
            font-size: 24px;
            border: none;
            border-radius: 50%;
            padding: 20px;
            background: #333;
            color: white;
            cursor: pointer;
            transition: 0.2s;
        }
        button.orange {
            background: #ff9500;
            color: white;
        }
        button.gray {
            background: #a5a5a5;
            color: black;
        }
        button.zero {
            grid-column: span 2;
            border-radius: 40px;
            text-align: left;
            padding-left: 28px;
        }
        button:active {
            filter: brightness(1.2);
        }
    </style>
</head>
<body>

<div class="calculator">
    <div class="display"><?= $_SESSION['input'] ?: '0' ?></div>
    <form method="post">
        <div class="buttons">
            <?php
            $buttons = [
                ['C', '', '', '/'],
                ['7', '8', '9', '*'],
                ['4', '5', '6', '-'],
                ['1', '2', '3', '+'],
                ['0', '.', '=', '']
            ];
            foreach ($buttons as $row) {
                foreach ($row as $btn) {
                    if ($btn === '') {
                        echo '<div></div>';
                        continue;
                    }

                    $class = '';
                    if ($btn === 'C') $class = 'gray';
                    elseif (in_array($btn, ['/', '*', '-', '+', '='])) $class = 'orange';
                    elseif ($btn === '0') $class = 'zero';

                    echo "<button class='$class' type='submit' name='btn' value='$btn'>$btn</button>";
                }
            }
            ?>
        </div>
    </form>
</div>

</body>
</html>
