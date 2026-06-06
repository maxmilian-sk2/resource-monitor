<?php

class App
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/Config.php';
        require_once __DIR__ . '/Database.php';
        require_once __DIR__ . '/Helper.php';
        require_once __DIR__ . '/Redirect.php';

        require_once __DIR__ . '/../models/Endpoint.php';
        require_once __DIR__ . '/../models/User.php';
    }
}
