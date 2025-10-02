<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $value = isset($_POST['value']) ? (float)$_POST['value'] : 0;
    $coefficient = isset($_POST['coefficient']) ? (float)$_POST['coefficient'] : 0;
    $direction = $_POST['direction'] ?? '';

    $errors = [];
    if ($value <= 0) $errors[] = "Value must be greater than 0.";
    if ($coefficient <= 0) $errors[] = "Coefficient must be greater than 0.";
    if (!in_array($direction, ['eur_to_all', 'all_to_eur'])) $errors[] = "Invalid exchange direction.";

    if (!empty($errors)) {
        echo "<h2>Errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul><a href='index.html'>Go back</a>";
        exit;
    }

    if ($direction === 'eur_to_all') {
        $result = $value * $coefficient;
        $exchangeMessage = "€$value = $result Lekë";
    } else {
        $result = $value / $coefficient;
        $exchangeMessage = "$value Lekë = €" . round($result, 2);
    }

    echo "<h2>Exchange Result</h2>";
    echo htmlspecialchars($exchangeMessage);
    echo "<br><br><a href='index.html'>Go back</a>";
} else {
    echo "Access this page via the form: <a href='index.html'>index.html</a>";
}
?>
