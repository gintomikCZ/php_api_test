<?php

Class GetController extends Controller {

  private $params;

  public function __construct($request, $response) {
    parent::__construct($request, $response);
    $this->params = $this->request->getParams();
  }

  public function ProcessRequest() {
    $data = isset($this->params[0]) ? $this->fetchOne() : $this->fetchAll();
    $this->response->setStatus(200);
    $this->response->setData($data);
    $this->response->dataOut();
  }

  private function fetchAll() {
    $query = $this->model->getQuery();
    return $this->db->fetchAll($query);
  }

  private function fetchOne() {
    $id = [ 'id' => $this->params[0]];
    $query = $this->model->getQuery() . ' WHERE ' . $this->table . '.id = :id';
    return $this->db->fetchOne($query, $id);
  }
}

