<?php

function check_logged_in(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
}
