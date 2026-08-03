<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
$_SESSION = array();
session_destroy();

header('Location: ' . SITE_URL . '/admin/login.php');
exit;