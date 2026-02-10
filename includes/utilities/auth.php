<?php

function check_logged_in(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}
