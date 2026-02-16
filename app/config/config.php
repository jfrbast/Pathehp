<?php

// Configuration base de données
const DB_HOST = 'localhost';
const DB_NAME = 'cinema_reservation';
const DB_USER = 'root';
const DB_PASS = '';
const DB_CHARSET = 'utf8mb4';

// Durée de vie de la session (inactivité) en secondes
const SESSION_TIMEOUT = 1800; // 30 minutes

// Cookie "se souvenir de moi"
const REMEMBER_ME_COOKIE = 'remember_me';
const REMEMBER_ME_DURATION = 60 * 60 * 24 * 30; // 30 jours

// URL de base (déduite automatiquement depuis /public/index.php)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$baseDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
define('BASE_URL', ($baseDir === '' ? '' : $baseDir) . '/');

