<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, departamento, estado) VALUES (?, ?, ?, ?)");
$stmt->execute([
    $_POST['nombre'],
    $_POST['email'],
    $_POST['departamento'],
    $_POST['estado']
]);

header('Location: index.php');
exit;
