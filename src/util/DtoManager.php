<?php

class DtoManager {

  public function getDtoTemplate($entity, $table_name, $tabel) {
    $templateVars = array(
      "propertyList" => "",
      "propertyGetterList" => "",
      "propertySetterList" => "",
      "entityName" => ucfirst($this->toCamelCase($entity)),
      "tableName" => $entity,
    );

    foreach ($tabel['columns'] as $column) {
      if ($column['primary'] == 1) {
        continue;
      }
      $propertyTemplate = $this->getPropertyTemplate($column);
      $templateVars['propertyList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $propertyTemplate .
        "\t\t\t\t" . "" . "\n";
    }
    foreach ($tabel['columns'] as $column) {
      if ($column['primary'] == 1) {
        continue;
      }
      $getter = $this->getGetterTemplate($column);
      $templateVars['propertyGetterList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $getter .
        "\t\t\t\t" . "" . "\n";
    }
    foreach ($tabel['columns'] as $column) {
      if ($column['primary'] == 1) {
        continue;
      }
      $setter = $this->getSetterTemplate($column);
      $templateVars['propertySetterList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $setter .
        "\t\t\t\t" . "" . "\n";
    }
    return $templateVars;
  }

  private function getPropertyTemplate($property) {
    $template = '
 /**
  * @var ' . $this->getType($property) . '
  */
 private $' . $this->getPropertyName($property) . ';';
    return $template;
  }

  private function getGetterTemplate($property) {
    $template = '
 /**
  * Get' . ucfirst($this->getPropertyName($property)) . '
  *
  * @return ' . ucfirst($this->getType($property)) . '
  */
  public function get' . ucfirst($this->getPropertyName($property)) . '() {
    return $this->' . $this->getPropertyName($property) . ';
  }';
    return $template;
  }

  private function getSetterTemplate($property) {
    $template = '
 /**
  * Set' . ucfirst($this->getPropertyName($property)) . '
  */
  public function set' . ucfirst($this->getPropertyName($property)) . '($' . $this->getPropertyName($property) . ') {
    return $this->' . $this->getPropertyName($property) . ' = $' . $this->getPropertyName($property) . ';
  }';
    return $template;
  }

  private function getType($column) {
    $type = explode("(", $column['type']);
    switch ($type[0]) {
      case "varchar":
        return "string";
      
      case "timestamp":
        return "string";
      
      case "int":
        return "integer";
    }
    return $type[0];
  }

  private function getPropertyName($column) {
    return $this->toCamelCase($column['name'], false);
  }

  public function toCamelCase($string, $capitalizeFirstCharacter = false) {
    $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    if (!$capitalizeFirstCharacter) {
      $str[0] = strtolower($str[0]);
    }
    return $str;
  }

  private function getPrimaryTemplate($column) {
    if ($column['primary'] == 1) {
      return '@ORM\GeneratedValue(strategy="IDENTITY")';
    } else {
      return "";
    }
  }

  private function getLength($column) {
    $type = explode("(", $column['type']);
    if (isset($type[1])) {
      $type = explode(")", $type[1]);
    }
    return $type[0];
  }

  private function getNullable($column) {
    if ($column['nullable'] == 1) {
      return "true";
    } else {
      return "false";
    }
  }

  private function p($data) {
    echo "<pre>";
    print_r($data);
    die;
  }

}
