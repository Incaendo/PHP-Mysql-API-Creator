<?php

class ComponentManager {

  public function getTemplateVars($api, $tabel) {
    $templateVars = array(
      "apiComponentList" => "",
      "entityName" => ucfirst($this->toCamelCase($api['entity'])),
      "entityNameCamelCase" => $this->toCamelCase($api['entity'])
    );

    foreach ($api['api_list'] as $apiName => $_api) {
      $apiTemplate = $this->getApiTemplate($api, $apiName, $_api);
      $templateVars['apiComponentList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $apiTemplate .
        "\t\t\t\t" . "" . "\n";
    }
    return $templateVars;
  }

  private function getApiTemplate($api, $apiName, $_api) {
    $template = ''
      . '
  /**
   * Function ' . $apiName . '.
   * @author <<AUTHOR>>
   */
  public function ' . $apiName . '($<<entityNameCamelCase>>SRO) {
    $this->validator->validate' . ucfirst($apiName) . 'Request($<<entityNameCamelCase>>SRO);
    try {
      $<<entityNameCamelCase>>DTO = $this->translators->populate<<entityName>>DTOFromSRO($<<entityNameCamelCase>>SRO);
      $<<entityNameCamelCase>>Model = $this->translators->populate<<entityName>>ModelFromDTO($<<entityNameCamelCase>>DTO);
      
      $<<entityNameCamelCase>>DAO = new <<entityName>>DAO();
      //TODO  Write your logic of component
      
      //$<<entityNameCamelCase>>Models = $<<entityNameCamelCase>>DAO->get<<entityName>>By<<entityName>>Code($<<entityNameCamelCase>>DAO->get<<entityNameCamelCase>>Code());
      $<<entityNameCamelCase>>Model = $<<entityNameCamelCase>>Models[0];
      $<<entityNameCamelCase>>DTO = $this->translators->populate<<entityName>>DTOFromModel($<<entityNameCamelCase>>Model);
      $<<entityNameCamelCase>>SRO = $this->translators->populate<<entityName>>SROFromDTO($<<entityNameCamelCase>>DTO);
    } catch (\MySQLException $e) {
      $this->logger->error("MySQLException occured in <<entityName>>Component ' . $apiName . ' function message: " . $e->getMessage());
      throw new <<entityName>>Exception($e->getMessage(), 500);
    }
    
    //return $<<entityNameCamelCase>>SRO;
  }';
    return $template;
  }

  
  public function getValidatorTemplateVars($api, $tabel) {
    $templateVars = array(
      "entityValidatorList" => "",
      "entityName" => ucfirst($this->toCamelCase($api['entity'])),
      "entityNameCamelCase" => $this->toCamelCase($api['entity'])
    );

    foreach ($api['api_list'] as $apiName => $_api) {
      $apiTemplate = $this->getValidatorTemplate($_api, $apiName);
      $templateVars['entityValidatorList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $apiTemplate .
        "\t\t\t\t" . "" . "\n";
    }
    return $templateVars;
  }
  
  private function getValidatorTemplate($api, $apiName) {
    $template = '
  /**
   * Function validate' . ucfirst($apiName) . 'Request.
   * This function is used to validate set password params.
   * @author <<AUTHOR>>
   */
  public function validate' . ucfirst($apiName) . 'Request($<<entityNameCamelCase>>SRO) {
    ';
    if (isset($api['validators']) && !empty($api['validators'])) {      
      foreach ($api['validators'] as $type => $validator) {
        foreach ($validator as $validation) {
          $_template = $this->getValidationTemplate($validation, $type);
          $template .= "\t\t" . $_template  . "\n";
        }
      }
    }
  $template .= '
  }';
    return $template;
  }
  
  public function getValidationTemplate($field, $validation) {
    switch ($validation) {
      case "required":
    $template = '
    if (empty($<<entityNameCamelCase>>SRO->get' . ucfirst($this->toCamelCase($field)) . '())) {
      throw new \InvalidArgumentException("' . $this->toCamelCase($field) . ' can not be blank.", 1009);
    }';
        break;
      case "email":
    $template = '
    if (!$this->util->isValidEmail($<<entityNameCamelCase>>SRO->get' . ucfirst($this->toCamelCase($field)) . '())) {
      throw new \InvalidArgumentException("' . $this->toCamelCase($field) . ' should be a valid email.", 1010);
    }';
        break;
      case "mobile":
    $template = '
    if (!$this->util->isValidMobile($<<entityNameCamelCase>>SRO->get' . ucfirst($this->toCamelCase($field)) . '())) {
      throw new \InvalidArgumentException("' . $this->toCamelCase($field) . ' should be a valid mobile number.", 1011);
    }';
        break;
    }
    
    return $template;
  }

  private function toCamelCase($string, $capitalizeFirstCharacter = false) {
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
