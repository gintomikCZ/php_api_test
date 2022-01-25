<?php

Abstract Class Controller {
  protected $request;
  protected $response;
  protected $data;
  protected $db;
  protected $table;
  protected $model;

  public function __construct($request, $response) {
      $this->db = Database::getInstance();
      $this->request = $request;
      $this->response = $response;
      $this->table = $this->request->getPath();
      $modelClassName = ucfirst($this->table.'Model');
      $dir = dirname(__DIR__, 1);
      if (!file_exists($dir.'/models/'.$modelClassName.'.php')) {
        $this->response->setStatus(404);
        $this->response->setError('Resource has not been found');
        $this->response->dataOut();
      }
      $this->model = new $modelClassName();
  }

  public abstract function processRequest();

}

