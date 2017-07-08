<?php

class ModelManager {

  public function getModelTemplate($entity, $table_name, $tabel, $api) {
    $templateVars = array(
      "propertyList" => "",
      "propertyGetterList" => "",
      "propertySetterList" => "",
      "entityName" => ucfirst($this->toCamelCase($entity)),
      "tableName" => $table_name,
    );

	echo 'tabel--------------------------------------'; print_r($table_name);
	
    foreach ($tabel['columns'] as $column) {
      $propertyTemplate = $this->getPropertyTemplate($column, $api);
      $templateVars['propertyList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $propertyTemplate .
        "\t\t\t\t" . "" . "\n";
    }
    foreach ($tabel['columns'] as $column) {
      $getter = $this->getGetterTemplate($column);
      $templateVars['propertyGetterList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $getter .
        "\t\t\t\t" . "" . "\n";
    }
    foreach ($tabel['columns'] as $column) {
      $setter = $this->getSetterTemplate($column, $api);
      $templateVars['propertySetterList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $setter .
        "\t\t\t\t" . "" . "\n";
    }
	
	if ($table_name == 'tutor_file_uploads') {
		//echo print_r($templateVars); die;
	}
    return $templateVars;
  }

  private function getPropertyTemplate($property, $api) {
    
    $relation_template = '* @ORM\Column(name="' . $property['name'] . '", type="' . $this->getType($property) . '", ' . $this->getLength($property) . ' nullable=' . $this->getNullable($property) . ')
  * ' . $this->getPrimaryTemplate($property) . '';
    $type = $this->getType($property);
    if (isset($api['relation']) && array_key_exists($property['name'], $api['relation'])) {      
      preg_match('~[targetEntity=](.+?)[,]~', $api['relation'][$property['name']]['type'], $matches);
      if (isset($matches) && !empty($matches)) {
        $matches = explode("=", $matches[1]);
        $type = str_replace('"', "", $matches[1]);
      }
      $relation_template ="* @ORM\\" . $api['relation'][$property['name']]['type'] . '
  * @ORM\JoinTable(name="' . $api['relation'][$property['name']]['table'] . '")';
    }
    $template = '
 /**
  * @var ' . $type . '
  *  
  ' . $relation_template . '
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

  private function getSetterTemplate($property, $api) {
    $type = $this->getType($property);
    if (isset($api['relation']) && array_key_exists($property['name'], $api['relation'])) {      
      preg_match('~[targetEntity=](.+?)[,]~', $api['relation'][$property['name']]['type'], $matches);
      if (isset($matches) && !empty($matches)) {
        $matches = explode("=", $matches[1]);
        $type = "\App\Model\\" . str_replace('"', "", $matches[1]) . " ";
      }
    }
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
      case "char":
      case "datetime":
      case "varchar":
        return "string";
      
      case "timestamp":
        return "string";

      case "tinyint":
      case "int":
        return "integer";
      
    }
    return $type[0];
  }

  private function getPropertyName($column) {
    return $this->toCamelCase($column['name'], false);
  }

  private function toCamelCase($string, $capitalizeFirstCharacter = false) {
    $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    if (!$capitalizeFirstCharacter && !empty($str)) {
      $str[0] = strtolower($str[0]);
    }
    return $str;
  }

  private function getPrimaryTemplate($column) {
    if ($column['primary'] == 1) {
      return '
        * @ORM\\' . $this->getPropertyName($column) . '
          @ORM\GeneratedValue(strategy="IDENTITY")';
    } else {
      return "";
    }
  }

  private function getLength($column) {
	echo "--------------"; print_r($column);
    if (isset($column['type']) && $column['type'] != "") {
      $type = explode("(", $column['type']);
      if (isset($type[1])) {
        $type = explode(")", $type[1]);
	return "length=" . $type[0] . ",";
      } else {
	return "";
      }      
    }
  }

  private function getNullable($column) {
    if ($column['nullable'] == 1) {
      return "false";
    } else {
      return "true";
    }
  }

  private function p($data) {
    echo "<pre>";
    print_r($data);
    die;
  }

}
