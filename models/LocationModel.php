<?php

Class LocationModel {
  private $query;

  public function __construct() {
    $this->query = '
      SELECT
        location.id,
        location.location,
        location.description,
        location.gps
        FROM location';
  }

  public function getQuery() {
    return $this->query;
  }

}