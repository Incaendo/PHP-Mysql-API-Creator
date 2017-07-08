<?php

class DaoManager {

  public function getDaoTemplate($entity) {
    $templateVars = array(
      "entityNameCamelCase" => $this->toCamelCase($entity),
      "entityName" => ucfirst($this->toCamelCase($entity)),
      "tableName" => $entity,
    );
    return $templateVars;
  }
   
  public function toCamelCase($string, $capitalizeFirstCharacter = false) {
    $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    if (!$capitalizeFirstCharacter) {
      $str[0] = strtolower($str[0]);
    }
    return $str;
  }

  private function p($data) {
    echo "<pre>";
    print_r($data);
    die;
  }

}
