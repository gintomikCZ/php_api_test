<?php

Class PutController extends Controller {

    private $id;
    private $body;

    public function __construct($request, $response) {
      parent::__construct($request, $response);
      $params = $this->request->getParams();
      $this->body = $this->request->getBody();
      if (isset($this->body['id'])) {
        $this->id = $this->body['id'];
      } elseif (isset($params[0])) {
        $this->id = $params[0];
      } else {
        throw new Exception('id is missing');
      }
    }

    public function processRequest() {
      $data = $this->db->editRecord($this->table, $this->body, $this->id);
      $this->response->setStatus(200);
      $this->response->setData($data);
      $this->response->dataOut();
    }
}
