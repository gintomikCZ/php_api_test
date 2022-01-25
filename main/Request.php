<?php
Class Request {
  
  private $headers;
  private $method;
  private $path = '';
  private $body;
  private $params = array();

  public function __construct(){
    $this->headers = getallheaders();
    $this->method = $_SERVER['REQUEST_METHOD'];
    $urlParsed = parse_url($_SERVER['REQUEST_URI']);
    $path = $urlParsed['path'];
    if(substr($path, 0,1) === "/") $path = substr($path, 1);
    if(substr($path, strlen($path) - 1, 1) === "/") $path = substr($path, 0, strlen($path) - 1);
    if(substr($path, 0,1) === "/") $path = substr($path, 1);

    $pathSplited = explode('/', $path);
    if(count($pathSplited) > 0) {
      $this->path = array_shift($pathSplited);
      $this->params = $pathSplited;
    }
    $this->body = strtolower($this->method) === 'get' ? null : json_decode(file_get_contents("php://input"), true);
  }

  public function getHeaders(){
    return $this->headers;
  }
  public function getBody(){
    return $this->body;
  }
  public function getMethod() {
    return $this->method;
  }
  public function getParams() {
    return $this->params;
  }
  public function getPath(){
    return $this->path;
  }
}

