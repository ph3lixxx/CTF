<?php
$page = $_GET['page'] ?? 'home';
$flag = "CYC{janganlupabersyukur}";

if (preg_match('/flag/i', $page)) {
    echo "Nope bro, ga bisa akses langsung ke flag.";
    exit;
}

@include "$page.php";
?>
