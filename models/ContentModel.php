<?php

Class ContentModel {
  private $query;

  public function __construct() {
    $this->query = '
      SELECT
        content.id,
        content.content,
        content.file
        FROM content';
  }

  public function getQuery() {
    return $this->query;
  }

}