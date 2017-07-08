<?php

class ControllerManager {

  public function getTemplateVars($api, $tabel) {
    $templateVars = array(
      "apiList" => "",
      "entityName" => ucfirst($this->toCamelCase($api['entity'])),
      "entityNameCamelCase" => $this->toCamelCase($api['entity']),
      "entityNameSmallCase" => strtolower($this->toCamelCase($api['entity'])),
    );

    foreach ($api['api_list'] as $apiName => $_api) {
      $apiTemplate = $this->getApiTemplate($api, $apiName, $_api);
      $templateVars['apiList'] .= "" .
        "\t\t\t\t" . "" . "\n" .
        $apiTemplate .
        "\t\t\t\t" . "" . "\n";
    }
    return $templateVars;
  }

  private function getApiTemplate($api, $apiName, $_api) {
    $template = ''
      . '/**
   * Function ' . $apiName . '.
   * @author <<AUTHOR>>
   */
  public function ' . $apiName . '(Request $request, ApiResponse $apiResponse, $args) {
    $this->logger->debug("[<<entityName>>Controller:' . $apiName . ':Params:" . json_encode($args) . "] <<entityName>> ' . $this->getApiRealName($apiName) . ' API Call");
    $' . $this->getApiRealName($apiName) . 'Response = new \App\Response\\' . ucfirst($apiName) . 'Response;
    try {
      $' . $this->getApiRealName($apiName) . 'Request = $this->deserialize(json_encode($args), "App\Request\\' . ucfirst($apiName) . 'Request", "json");
      $<<entityNameSmallCase>>Component = new <<entityName>>Component();
      $' . $this->getApiRealName($apiName) . ' = $<<entityNameSmallCase>>Component->' . $apiName . '($' . $this->getApiRealName($apiName) . 'Request->get<<entityName>>());
      
      $' . $this->getApiRealName($apiName) . 'Response->setResponse($' . $this->getApiRealName($apiName) . ');
    } catch (\Exception $e) {
      $error = $this->errorException($e, $e->getCode(), $e->getMessage(), "<<entityName>>", "' . $apiName . '", "error");
      $' . $this->getApiRealName($apiName) . 'Response->setError($error);
    }
    $this->logger->debug("[<<entityName>>Controller:' . $apiName . ':Response:" . $this->serialize($' . $this->getApiRealName($apiName) . 'Response) . "]  <<entityName>> '  . $apiName .  ' API End");
    $this->render($' . $this->getApiRealName($apiName) . 'Response);
  }';
    return $template;
  }

  
  private function getApiRealName($apiName) {
    $patersToReplace = array('get', 'set', 'create', 'update', 'delete', 'remove', 'edit');
    foreach ($patersToReplace as $value) {
      $apiName = str_replace($value, "", $apiName);
      $apiName = str_replace(ucfirst($value), "", $apiName);
    }
    $apiName[0] = strtolower($apiName[0]);
    return $apiName;
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
