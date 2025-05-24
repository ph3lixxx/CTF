<?php
$page = $_GET['page'] ?? 'home';
$flag = "CYSCOM{wowngemrihbank}";

if (preg_match('/flag/i', $page)) {
    echo "Nope bro, ga bisa akses langsung ke flag.";
    exit;
}

@include "$page.php";
?>
