<?php
require_once dirname(__FILE__).'/../../config.php';

// 1. zakończenie sesji
session_start();
session_destroy();

// 2. przekieruj lub "forward" na stronę główną
//redirect
header("Location: "._APP_URL);
//"forward"
//include _ROOT_PATH.'/index.php';