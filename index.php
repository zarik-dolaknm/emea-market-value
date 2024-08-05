<?php
$jsonFile = 'players_example.json';

$jsonData = file_get_contents($jsonFile);
$players = json_decode($jsonData, true);

function comparePlayers($player1, $player2, $players) {
    $value1 = 0;
    $value2 = 0;
    
    foreach ($players as $player) {
        if ($player['player'] == $player1) {
            $value1 = $player['market_value'];
        }
        if ($player['player'] == $player2) {
            $value2 = $player['market_value'];
        }
    }
    
    $difference = abs($value2 - $value1);
    $percentageDifference = ($difference / $value1) * 100;
    
    return [
        'player1' => $player1,
        'player2' => $player2,
        'value1' => $value1,
        'value2' => $value2,
        'difference' => $difference,
        'percentageDifference' => $percentageDifference
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant Esporcu Karşılaştırma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            color: #4CAF50;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .results {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            margin-top: 20px;
            background-color: #ffcc00;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Esporcu Piyasa Değerlerini Karşılaştır</h1>
    <form method="POST">
        <label for="player1">Birinci Oyuncu:</label>
        <input list="players" name="player1" id="player1" required>
        <br>
        <label for="player2">İkinci Oyuncu:</label>
        <input list="players" name="player2" id="player2" required>
        <br>
        <button type="submit">Karşılaştır</button>
    </form>

    <datalist id="players">
        <?php
        foreach ($players as $player) {
            echo '<option value="' . $player['player'] . '">';
        }
        ?>
    </datalist>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $player1 = $_POST['player1'];
        $player2 = $_POST['player2'];

        $result = comparePlayers($player1, $player2, $players);

        echo '<div class="results">';
        echo '<h2>Sonuçlar:</h2>';
        echo '<p>' . $result['player1'] . ' piyasa değeri: ' . $result['value1'] . '</p>';
        if($result['player1']=="Brave")echo '<p><i>' . 'Brave baba kalplerin birincisi' . '</i></p>';
        echo '<p>' . $result['player2'] . ' piyasa değeri: ' . $result['value2'] . '</p>';
        echo '<p>Piyasa değeri farkı: ' . $result['difference'] . '</p>';
        echo '<p>Yüzdelik fark: ' . number_format($result['percentageDifference'], 2) . '%</p>';
        echo '</div>';
    }
    ?>

    <div class="message">
        <p>Bu piyasa değerleri gerçekle ilişkisi yoktur, sadece bireysel performanslarıyla ilişkilidir.</p>
    </div>
</body>
</html>
