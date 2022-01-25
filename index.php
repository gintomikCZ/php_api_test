<?php

include(__DIR__."/config.php");

$request = new Request();
$response = new Response();
$path = strtolower($request->getPath());
$method = strtolower($request->getMethod());

if (in_array($method, ['get', 'post', 'put', 'delete']) === false) {
  $response->setStatus(405);
  $response->setError('Method not allowed.');
  $response->dataOut();
}

$className = ucfirst($method) . 'Controller';
$controller = new $className($request, $response);

try {
  $controller->processRequest();
}
catch (Exception $e) {
  if (mode === 'production') {
    $response->setError($e);
    $response->setStatus(500);
    $response->dataOut();
  }
  throw new Exception($e->getMessage());
}
