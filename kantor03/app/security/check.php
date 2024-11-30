<?php
require_once dirname(__FILE__).'/../../config.php';

session_start();

$role = $_SESSION['role'] ?? '';

if (empty($role)) {
    include _ROOT_PATH.'/app/security/login.php';
    exit();
}
?>
