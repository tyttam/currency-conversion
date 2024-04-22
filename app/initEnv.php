<?php
// Инициализация переменных окружения .env

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv
    ->usePutenv()
    ->bootEnv(__DIR__.'/.env');
