<?php

/**
 * Commentout - Тестовая система комментариев
 *
 * @package  Commentout
 * @author   Gorkavenko Eugene <info@grkvnko.ru>
 */

define('ROOTPATH', __DIR__);

require ROOTPATH.'/app/core/autoload.php';

$router = new \Commentout\Router();
$router->resolve();