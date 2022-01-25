<?php

Class DeleteController extends Controller {

  private $id;

  public function __construct($request, $response) {
    parent::__construct($request, $response);
    $body = $this->request->getBody();
    $params = $this->request->getParams();
    if (isset($body['id'])) {
      $this->id = $body->id;
    } elseif (isset($params[0])) {
      $this->id = $params[0];
    } else {
      throw new Exception('id is missing');
    }
  }

  public function processRequest() {
    $data = $this->db->deleteRecord($this->table, $this->id);
    $this->response->setStatus(204);
    $this->response->setData($data);
    $this->response->dataOut();
  }

}