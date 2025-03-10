<?php
    $dsn = "mysql:host=localhost;dbname=clothing_store;charset=utf8";
    $username = "root";
    $password = "abcABC12@";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Kết nối thất bại: " . $e->getMessage());
    }
?>
