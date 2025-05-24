<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password === 'priadingjn') {
        echo "Flag: CYSCOM{anjaybowlehjuga}";
    } else {
        echo "Password changed to: $password Coba lagi bwank!!";
    }
    exit;
}
?>

<form method="POST">
</form>
