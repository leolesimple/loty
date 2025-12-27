<?php

function clean(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function redirectTo(string $url): void
{
    header("Location: $url");
    exit();
}

function formatDate(string $dateString): string
{
    $date = new DateTime($dateString);
    return $date->format('d/m/Y');
}

function formatDateTime(string $dateString): string
{
    $date = new DateTime($dateString);
    return $date->format('d/m/Y H:i');
}

function isUserLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}