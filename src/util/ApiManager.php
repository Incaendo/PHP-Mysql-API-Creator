<?php

/**
 * Description of ApiManager
 *
 * @author kapil
 */
class ApiManager {

  const PACKAGE = "com/test";
  
  public function generateFile($entityName, $templateVars, $file, $moduleName) {
//    sleep(1);
    $templateVars['AUTHOR'] = AUTHOR;
    $template = file_get_contents(__DIR__ . '/../../gen/' . $file . '/' . ucfirst($file) . '.php');
    $template = $this->replaceTemplateVars($template, $templateVars);
    $dirPath = $this->createDir($file, $moduleName);
    if ($entityName != "") {
      $fp = fopen(__DIR__ . "/../../" . $dirPath . "/" . ucfirst($this->toCamelCase($entityName)) . ucfirst($file) . ".php", "w+");
    } else {
      $fp = fopen(__DIR__ . "/../../" . $dirPath . "/" . ucfirst($file) . ".php", "w+");
    }
    fwrite($fp, $template);
    fclose($fp);
  }

  public function getTemplateVars($apiName, $api) {
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
  
  public function getApiRouteTemplateVars($apiName, $_api, $api, $type, $templateVars = false) {
    $controllerName = ucfirst($this->toCamelCase($api['entity']));
	
	if ($templateVars === false) {
    $templateVars = array(
      "apiRouteList" => ""
    );
	}
    
    foreach ($api['api_list'] as $api_key => $_api) {
      $params = "";
      if (strtolower($_api['method']) == "get") {
        foreach ($_api['request'] as $key => $val) {
          $params .= "/{" . $key . "}";
        }
      }
      $method = strtolower($_api['method']);
      $templateVars['apiRouteList'] .= '
$app->' . $method . '("/' . $api_key . $params . '", "App\Controller\\' . $controllerName . 'Controller:' . $api_key . '")
    ->setName("' . $api_key . '");
      ';
    }
	//print_r($templateVars); die;
    return $templateVars;
  }

  public function getApiRequestTemplateVars($apiName, $_api, $api, $type) {
    if ($type == "request") {
      $requestParams = (array) $_api['request'];
    } else {
      $requestParams = (array) $_api['response'];
    }
    $templateVars = array(
      "propertyList" => "",
      "propertyGetterList" => "",
      "propertySetterList" => "",
      "entityName" => ucfirst($this->toCamelCase($api['entity'])),
      "apiNameCamelCase" => $this->toCamelCase($apiName),
      "apiNameUperCase" => ucfirst($this->toCamelCase($apiName)),
    );

    foreach ($requestParams as $param_key => $param) {
      $apiTemplate = $this->getPropertyTemplate($param_key);
      $templateVars['propertyList'] .= "" .
      $apiTemplate;
    }
    
    foreach ($requestParams as $param_key => $param) {
      $apiTemplate = $this->getPropertyGetterTemplate($param_key);
      $templateVars['propertyGetterList'] .= "" .
        $apiTemplate;
    }
    
    foreach ($requestParams as $param_key => $param) {
      $apiTemplate = $this->getPropertySetterTemplate($param_key);
      $templateVars['propertySetterList'] .= "" .
        $apiTemplate;
    }
    return $templateVars;
  }
  
  private function getPropertyTemplate($property) {
    $template = '
 private $' . $this->getPropertyName($property) . ';';
    return $template;
  }

  private function getPropertyGetterTemplate($property) {
    $template = '
 /**
  * Get' . ucfirst($this->getPropertyName($property)) . '
  */
  public function get' . ucfirst($this->getPropertyName($property)) . '() {
    return $this->' . $this->getPropertyName($property) . ';
  }';
    return $template;
  }

  private function getPropertySetterTemplate($property) {
    $template = '
 /**
  * Set' . ucfirst($this->getPropertyName($property)) . '
  */
  public function set' . ucfirst($this->getPropertyName($property)) . '($' . $this->getPropertyName($property) . ') {
    return $this->' . $this->getPropertyName($property) . ' = $' . $this->getPropertyName($property) . ';
  }';
    return $template;
  }
  
  private function getPropertyName($name) {
    return $this->toCamelCase($name, false);
  }
  
  private function createDir($file, $moduleName) {
    $dirPath = "";
    try {
      switch ($file) {
        case "model":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/model", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/model";
          break;

        case "dto":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/dto", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/dto";
          break;

        case "dao":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component/data/dao", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/component/data/dao";
          break;
        
        case "sro":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/http";
          break;

        case "request":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/request", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/request";
          break;

        case "response":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/response", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/response";
          break;

        case "controller":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/controller", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/controller";
          break;

        case "component":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component/business", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/component/business";
          break;

        case "exception":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/exception", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/exception";
          break;

        case "translator":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component/business/translator", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/component/business/translator";
          break;

        case "validator":
          @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/validator", 0755);
          $dirPath = "app/" . self::PACKAGE . "/" . $moduleName . "/classes/validator";
          break;
        
        case "route":
          @mkdir(__DIR__ . "/", 0755);
          $dirPath = "app/";
          break;
      }
    } catch (Exception $e) {
      echo $e->getMessage();
      die("ERROR IN FILE WRITE");
    }
    return $dirPath;
  }

  private function replaceTemplateVars($template, $templateVars) {
    foreach ($templateVars as $key => $value) {
      $template = str_replace("<<" . $key . ">>", $value, $template);
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

  public function createFolderStructure($moduleName) {
    try {
      @mkdir(__DIR__ . "/../../app/", 0755);
      @mkdir(__DIR__ . "/../../app/com", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName, 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/cache", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/dto", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/model", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/util", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/request", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/response", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/exception", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component/business", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component/data", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/component/data/dao", 0755);
      @mkdir(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/controller", 0755);

      $templateVars = array();
      $templateVars['AUTHOR'] = AUTHOR;
      // Copy BaseController.
      $template = file_get_contents(__DIR__ . '/../../gen/controller/BaseController.php');
      $template = $this->replaceTemplateVars($template, $templateVars);
      $fp = fopen(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/controller/BaseController.php", "w+");
      fwrite($fp, $template);
      fclose($fp);

      // Copy CachedReader.
      $template = file_get_contents(__DIR__ . '/../../gen/cache/CachedReader.php');
      $template = $this->replaceTemplateVars($template, $templateVars);
      $fp = fopen(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/cache/CachedReader.php", "w+");
      fwrite($fp, $template);
      fclose($fp);

      // Copy Util.php.
      $template = file_get_contents(__DIR__ . '/../../gen/util/Util.php');
      $template = $this->replaceTemplateVars($template, $templateVars);
      $fp = fopen(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/util/Util.php", "w+");
      fwrite($fp, $template);
      fclose($fp);
      
      // Copy Error.php.
      $template = file_get_contents(__DIR__ . '/../../gen/http/response/Error.php');
      $template = $this->replaceTemplateVars($template, $templateVars);
      $fp = fopen(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/response/Error.php", "w+");
      fwrite($fp, $template);
      fclose($fp);
      
      // Copy Response.php File
      $template = file_get_contents(__DIR__ . '/../../gen/http/response/Response.php');
      $template = $this->replaceTemplateVars($template, $templateVars);
      $fp = fopen(__DIR__ . "/../../app/" . self::PACKAGE . "/" . $moduleName . "/classes/http/response/Response.php", "w+");
      fwrite($fp, $template);
      fclose($fp);
    } catch (Exception $e) {
      echo $e->getMessage();
      die("ERROR IN Create Folder Structure");
    }
  }

  public function getTranslatorFieldsVar($api, $table) {
    $templateVars = array(
      "entityName" => ucfirst($this->toCamelCase($api['entity'])),
      "entityNameCamelCase" => $this->toCamelCase($api['entity']),
      "populateDTOFromModelFieldList" => "",
      "populateModelFromDTOFieldList" => "",
      "populateSROFromDTOFieldList" => "",
      "populateDTOFromSROFieldList" => ""
    );
	
    foreach ($table['columns'] as $column) {
      if ($column['primary'] == 1) {
        continue;
      }
      $templateVars['populateModelFromDTOFieldList'] .= '
    $' . $templateVars['entityNameCamelCase'] . 'Model->set' . ucfirst($this->toCamelCase($column['name'])) . '($' . $templateVars['entityNameCamelCase'] . 'DTO->get' . ucfirst($this->toCamelCase($column['name'])) . '());';
      $templateVars['populateDTOFromModelFieldList'] .= '
    $' . $templateVars['entityNameCamelCase'] . 'DTO->set' . ucfirst($this->toCamelCase($column['name'])) . '($' . $templateVars['entityNameCamelCase'] . 'Model->get' . ucfirst($this->toCamelCase($column['name'])) . '());';
      $templateVars['populateSROFromDTOFieldList'] .= '
    $' . $templateVars['entityNameCamelCase'] . 'SRO->set' . ucfirst($this->toCamelCase($column['name'])) . '($' . $templateVars['entityNameCamelCase'] . 'DTO->get' . ucfirst($this->toCamelCase($column['name'])) . '());';
      $templateVars['populateDTOFromSROFieldList'] .= '
    $' . $templateVars['entityNameCamelCase'] . 'DTO->set' . ucfirst($this->toCamelCase($column['name'])) . '($' . $templateVars['entityNameCamelCase'] . 'SRO->get' . ucfirst($this->toCamelCase($column['name'])) . '());';
    }
    return $templateVars;
  }

  public function p($data) {
    echo "<pre>";
    print_r($data);
    die;
  }
}
