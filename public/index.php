<?php

use Src\Core\Container;

require "../bootstrap.php";

$container = new Container();
$app = $container->createApplication();

$app->run();