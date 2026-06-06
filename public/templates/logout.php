<?php
require_once '../../app/core/App.php';
App::init();

$_SESSION = [];
session_destroy();

Redirect::redirect('login.php');
exit;
