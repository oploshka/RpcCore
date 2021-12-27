<?php
// Простенький роутер

// берем переданный роут
$route = trim($_SERVER['REQUEST_URI'] ?? 'index', " \n\r\t\v\0/");

$page = [
  'form' => true,
  'docs' => true,
  'api'  => true,
  'home' => true,
];

if(!isset($page[$route])){
  $route = 'home';
}

include __DIR__. '/../page/'.$route.'.php';