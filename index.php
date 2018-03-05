<?php

include 'autoload.php';
include 'Router.php';

$request = $_SERVER['REQUEST_URI'];

$router = new Router($request);

$router->get();
