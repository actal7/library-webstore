<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library App</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="/profile">Profile</a></li>
                <?php if ($_SESSION['role'] === 'clerk' || $_SESSION['role'] === 'admin'): ?>
                    <li><a href="/manage">Manage</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="/dashboard">Dashboard</a></li>
                <?php endif; ?>
                <li><a href="/logout">Logout</a></li>
            <?php else: ?>
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
