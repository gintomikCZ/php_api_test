<?php

Class PostController extends Controller {

  private $body;

  public function __construct($request, $response) {
    parent::__construct($request, $response);
    $this->body = $this->request->getBody();
  }

  public function processRequest() {
    $data = $this->db->addRecord($this->table, $this->body);
    $this->response->setStatus(201);
    $this->response->setData($data);
    $this->response->dataOut();
  }
}
