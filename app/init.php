<?php

// ✅ TEMP: Enable error reporting to diagnose blank page
error_reporting(E_ALL);
ini_set('display_errors', 1);

//  Session settings
ini_set('session.gc_maxlifetime', 28800);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
$sessionCookieExpireTime = 28800; // 8 hours
session_set_cookie_params($sessionCookieExpireTime);
session_start();

//  Core app loading
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/config.php';
require_once 'database.php';
