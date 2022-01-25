<?php

Class DeviceModel {
  private $query;

  public function __construct() {
    $this->query = '
      SELECT
        device.id,
        device.apikey,
        device.description,
        device.device,
        device.ip,
        location.location,
        device.uuid
        FROM device JOIN location ON device.locationid = location.id';
  }

  public function getQuery() {
    return $this->query;
  }

}