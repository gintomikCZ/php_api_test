<?php
Class Response {
  private $headers;
  private $error;
  private $status;
  private $data;

  public function __construct(){
    $this->headers = array(
      "Access-Control-Allow-Origin" => "*",
      "Access-Control-Allow-Headers" => "*",
      "Access-Control-Allow-Methods" => "POST, GET, PUT, DELETE, OPTIONS",
      "Access-Control-Max-Age" => "3600",
      "Content-Type" => 'application/json'
    );
  }

  public function setError ($e) {
    $this->error = $e;
  }

  public function setData ($data) {
    $this->data = $data;
  }

  public function setStatus ($status) {
    $this->status = $status;
  }

  private function setHeaders() {
    foreach ($this->headers as $key => $value) {
      header($key . ':' . $value);
    }
  }
  public function dataOut() {
    $output = $this->status < 300 ? $this->data : $this->error;
    http_response_code($this->status);
    $this->setHeaders();
    echo json_encode($output);
    exit;
  }
}