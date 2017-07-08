<?php

class Util {

  public function getModelTemplate($table_name, $tabel) {
    $model = '
      namespace App\Model;

      use Doctrine\ORM\Mapping as ORM;

      /**
       * ' . ucfirst($table_name) . '
       *
       * @ORM\Table(name="' . $table_name . '")
       * @ORM\Entity
       */
      class UserModel {
      ';
    foreach ($tabel['columns'] as $column) {
      $propertyTemplate = $this->getPropertyTemplate($column);
      $model .= "" .
        "\t\t\t\t" . "" . "\n" .
        $propertyTemplate .
        "\t\t\t\t" . "" . "\n\n";
    }
    foreach ($tabel['columns'] as $column) {
      $getter = $this->getGetterTemplate($column);
      $model .= "" .
        "\t\t\t\t" . "" . "\n" .
        $getter .
        "\t\t\t\t" . "" . "\n\n";
    }
    foreach ($tabel['columns'] as $column) {
      $setter = $this->getSetterTemplate($column);
      $model .= "" .
        "\t\t\t\t" . "" . "\n" .
        $setter .
        "\t\t\t\t" . "" . "\n\n";
    }
    
    $model .= "\n"
      . "}";
    $this->p($model);
  }

  private function getPropertyTemplate($property) {
    $template = '/**
    * @var ' . $this->getType($property) . '
    *
    * @ORM\Column(name="' . $property['name'] . '", type="' . $this->getType($property) . '", length=' . $this->getLength($property) . ',  nullable=' . $this->getNullable($property) . ')
    * @ORM\\' . ucfirst($property['name']) . '
    * ' . $this->getPrimaryTemplate($property) . '
    */
   private $' . $property['name'] . ';';
    return $template;
  }
  
  private function getGetterTemplate($property) {
    $template = '/**\n
      * Get ' . ucfirst($this->getPropertyName($property)) . '\n
      *
      * @return ' . ucfirst($this->getType($property)) . '     \n
      */\n
      */\n
      public function get' . ucfirst($this->getPropertyName($property)) . '() {
          return $this->' . ucfirst($this->getPropertyName($property)) . ';
      }';
    return $template;
  }
  
  private function getSetterTemplate($property) {
    $template = '/**\n
      * Set ' . ucfirst($this->getPropertyName($property)) . '\n
      *
      */\n
      */\n
      public function set' . ucfirst($this->getPropertyName($property)) . '($' . $this->getPropertyName($property) . ') {
          return $this->' . ucfirst($this->getPropertyName($property)) . ' = $'. $this->getPropertyName($property) .';
      }';
    return $template;
  }

  private function getType($column) {
    $type = explode("(", $column['type']);
    return $type[0];
  }
  
  private function getPropertyName($column) {
    return $column['name'];
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
    $type = explode(")", $type[1]);
//    $this->p($type);
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
