<?php
use OCA\CernBoxAuthToken\AppInfo\Application;


require_once __DIR__ . '/autoload.php';

$app = new Application();
$app->boot();

\OCP\Util::addScript('cernboxauthtoken', 'app');
