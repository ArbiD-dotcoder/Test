<?php
header('Content-Type: text/html; charset=UTF-8');

$errors = [];
$resultText = '';

$currencies = [
    'EUR' => 1.00,
    'USD' => 1.08,
    'JPY' => 157.50,
    'GBP' => 0.85,
    'AUD' => 1.60,
    'CAD' => 1.47,
    'CHF' => 0.95,
    'CNY' => 7.85,
    'HKD' => 8.45,
    'NZD' => 1.75,
    'SEK' => 11.25
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = isset($_POST['value']) ? (float)$_POST['value'] : 0;
    $from = $_POST['from_currency'] ?? '';
    $to = $_POST['to_currency'] ?? '';

    if ($value <= 0) {
        $errors[] = "Please enter a valid amount greater than 0.";
    }
    if (!isset($currencies[$from])) {
        $errors[] = "Invalid source currency selected.";
    }
    if (!isset($currencies[$to])) {
        $errors[] = "Invalid target currency selected.";
    }

    if (empty($errors)) {
        $value_in_eur = $value / $currencies[$from];
        $converted_value = $value_in_eur * $currencies[$to];
        $resultText = htmlspecialchars($value) . " $from = " . round($converted_value, 2) . " $to";
    }
}

if (!empty($errors)) {
    echo '<div style="background-color:#ffdede; padding:10px; border-radius:6px; color:#900;">';
    echo '<strong>Errors:</strong><ul>';
    foreach ($errors as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
    echo '</ul></div>';
} elseif ($resultText) {
    echo '<div style="background-color:#d0f0d0; padding:10px; border-radius:6px; color:#060;">';
    echo '<strong>Exchange Result:</strong><br>' . $resultText . '</div>';
}
?>
