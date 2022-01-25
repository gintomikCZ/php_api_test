<?php

Class DistributionModel {
  private $query;

  public function __construct() {
    $this->query = '
      SELECT
        distribution.id,
        distribution.distributiontime,
        device.device,
        content.content
        FROM distribution
        JOIN device ON distribution.deviceid = device.id
        JOIN content ON distribution.contentid = content.id' ;
  }

  public function getQuery() {
    return $this->query;
  }

}