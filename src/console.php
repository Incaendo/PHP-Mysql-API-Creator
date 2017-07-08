<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\DBAL\Schema\Table;

$console = new Application('API Master', '1.0');

$console->register('generate:api')
  ->setDefinition(array())
  ->setDescription("Generate Api's")
  ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {

    define("AUTHOR", "Kapil Kumar <kapil.kumar@incanedo.com>");
    define("COPYRIGHT", "(c) 2017, Company.");
    $config = array(
      "module" => "user",
      "apis" => array(
        "category" => array(
          "module" => "marketplace",
          "entity" => "category",
          "table" => "category_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "createCategory" => array(
              "method" => "POST",
              "request" => array(
                "categoryName" => "",
                "categoryDescription" => "",
                "type" => "KAPIL",
                "categoryImage" => "",
                "metaTitle" => "",
                "metaDescription" => "",
                "roleCodes" => "",
                "status" => 1
              ),
              "response" => array(
                "status" => true,
                "category" => array(
                  "categoryName" => "",
                  "categoryDescription" => "",
                  "type" => "KAPIL",
                  "categoryImage" => "",
                  "metaTitle" => "",
                  "metaDescription" => "",
                  "roleCodes" => "",
                  "status" => 1
                )
              ),
              "validators" => array(
                "required" => array("categoryName", "categoryDescription", "type", "roleCodes"),
                "email" => array("emailId"),
                "mobile" => array()
              )
            ),
            "getCategoryList" => array(
              "method" => "GET",
              "request" => array("roleCode" => "STU"),
              "response" => array("firstName" => "Kapil", "lastName" => "Chauhan"),
            )
          )
        ),
        "catalog" => array(
          "module" => "marketplace",
          "entity" => "product",
          "relation" => array(
            "profile_id" => array(
              "table" => "category_master",
              "type" => 'OneToOne(targetEntity="CategoryMasterModel", cascade={"persist", "remove"})'
            )
          ),
          "table" => "product_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "createProduct" => array(
              "method" => "POST",
              "request" => array(
                "productTitle" => "",
                "productSubtitle" => "",
                "productDescription" => "",
                "metaTitle" => "",
                "metaDescription" => "",
                "image" => "",
                "price" => "",
                "categoryCode" => "",
                "skuCode" => "9324324432",
                "minOrderQuantity" => "",
                "maxOrderQuantity" => "",
                "sortOrder" => "",
                "createdDate" => "",
                "updatedDate" => "",
                "schoolCode" => "",
                "classCode" => "",
                "classCode" => "",
                "status" => 1
              ),
              "response" => array("status" => true),
              "validators" => array(
                "required" => array("productTitle", "productDescription", "price", "categoryCode"),
                "email" => array(),
                "mobile" => array()
              )
            ),
            "getProductDetails" => array(
              "method" => "GET",
              "request" => array("skuCode" => 123),
              "response" => array(
                "productTitle" => "",
                "productSubtitle" => "",
                "productDescription" => "",
                "metaTitle" => "",
                "metaDescription" => "",
                "image" => "",
                "price" => "",
                "categoryCode" => "",
                "skuCode" => "9324324432",
                "minOrderQuantity" => "",
                "maxOrderQuantity" => "",
                "sortOrder" => "",
                "createdDate" => "",
                "updatedDate" => "",
                "schoolCode" => "",
                "classCode" => "",
                "classCode" => "",
                "status" => 1
              ),
            ),
          )
        ),
        "pincode" => array(
          "module" => "marketplace",
          "entity" => "pincode",
          "table" => "pincode_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "isServicablePincode" => array(
              "method" => "GET",
              "request" => array("pincode" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
        "address" => array(
          "module" => "marketplace",
          "entity" => "address",
          "table" => "user_address",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "getUserAddressList" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "addAddress" => array(
              "method" => "POST",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "updateAddress" => array(
              "method" => "PUT",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "deleteAddress" => array(
              "method" => "DELETE",
              "request" => array("addressCode" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
        "cart" => array(
          "module" => "marketplace",
          "entity" => "address",
          "table" => "user_cart",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "getUserCart" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "addItemToCart" => array(
              "method" => "POST",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "updateCartItemQuantity" => array(
              "method" => "PUT",
              "request" => array("itemId" => 12334, 'quantity' => 2),
              "response" => array("status" => true),
            ),
            "deleteCartItem" => array(
              "method" => "DELETE",
              "request" => array("itemId" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
        "order" => array(
          "module" => "marketplace",
          "entity" => "address",
          "table" => "order_master",
          "filesToPopulate" => array("model", "controller", "component", "dao", "dto", "sro", "request", "response", "exception", "translator", "validator", "route"),
          "api_list" => array(
            "getOrderList" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "getMyOrderList" => array(
              "method" => "GET",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "getOrderDetails" => array(
              "method" => "GET",
              "request" => array("orderId" => 12334),
              "response" => array("status" => true),
            ),
            "addAddress" => array(
              "method" => "POST",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "updateAddress" => array(
              "method" => "PUT",
              "request" => array("uuid" => 12334),
              "response" => array("status" => true),
            ),
            "deleteAddress" => array(
              "method" => "DELETE",
              "request" => array("addressCode" => 12334),
              "response" => array("status" => true),
            ),
          )
        ),
      )
    );



    echo PHP_EOL . 'SCRIPT START.' . PHP_EOL;
    $modelManager = new ModelManager();
    $datamaseManager = new DatabaseManager();
    $apiManager = new ApiManager();
    $dtoManager = new DtoManager();
    $daoManager = new DaoManager();
    $controllerManager = new ControllerManager();
    $componentManager = new ComponentManager();
    $apiManager->createFolderStructure($config['module']);
    $tables = $datamaseManager->prepareTableList($app);
    echo PHP_EOL . 'PROCESSING.' . PHP_EOL;
    foreach ($config['apis'] as $api) {
      $table = $tables[$api['table']];
      $templateVars = array(
        "entityNameCamelCase" => $daoManager->toCamelCase($api['entity']),
        "entityName" => ucfirst($daoManager->toCamelCase($api['entity']))
      );
      try {
        foreach ($api['filesToPopulate'] as $file) {
          switch ($file) {
            case "model":
              // GENERATE MODEL
              echo PHP_EOL . 'PREPARING DATA TO CREATE MODEL FILE.' . PHP_EOL;
              $templateVars = $modelManager->getModelTemplate($api['entity'], $api['table'], $table, $api);
              echo PHP_EOL . 'CREATING MODEL FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              if (isset($api['relation'])) {
                foreach ($api['relation'] as $relation) {
                  $table = $tables[$relation['table']];
                  echo PHP_EOL . 'PREPARING DATA FOR RELATION ENTITY FOR ' . $relation['table'] . PHP_EOL;
                  $templateVars = $modelManager->getModelTemplate($relation['table'], $relation['table'], $table, $api);
                  echo PHP_EOL . 'CREATING RELATION MODEL FILE FOR ' . $relation['table'] . PHP_EOL;
                  $apiManager->generateFile($relation['table'], $templateVars, $file, $config['module']);
                }
              }
              break;

            case "dto":
              // GENERATE DTO
              echo PHP_EOL . 'COLLECTING DATA FOR DTO.' . PHP_EOL;
              $templateVars = $dtoManager->getDtoTemplate($api['entity'], $api['table'], $table);
              echo PHP_EOL . 'WRITING DTO FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              echo PHP_EOL . 'WRITING SRO FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, "sro", $config['module']);
              break;

            case "dao":
              // GENERATE DTO
              echo PHP_EOL . 'PREPARING DAO TEMPLATE.' . PHP_EOL;
              $templateVars = $daoManager->getDaoTemplate($api['entity'], $api['table'], $table);
              echo PHP_EOL . 'WRITING DAO FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              break;

            case "controller":
              // GENERATE CONTROLLER
              echo PHP_EOL . 'PREPARING CONTROLLER ACTIONS OF API\'s.' . PHP_EOL;
              $templateVars = $controllerManager->getTemplateVars($api, $table);
              echo PHP_EOL . 'WRITING CONTROLLER FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              break;

            case "component":
              // GENERATE COMPONENT
              echo PHP_EOL . 'PREPARING COMPONENT FILE TEMPLATE.' . PHP_EOL;
              $templateVars = $componentManager->getTemplateVars($api, $table);
              echo PHP_EOL . 'WRITING COMPONENT FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              break;

            case "exception":
              // GENERATE Exception File
              echo PHP_EOL . 'PREPARING EXCEPTION FILES TEMPLATE.' . PHP_EOL;
              echo PHP_EOL . 'WRITING EXCEPTION FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              break;

            case "translator":
              // GENERATE TRANSLATORS
              echo PHP_EOL . 'PREPARING TO WRITE TRANSLATORS.' . PHP_EOL;
              $templateVars = $apiManager->getTranslatorFieldsVar($api, $table);
              echo PHP_EOL . 'WRITING TRANSLATOR FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              break;

            case "validator":
              // GENERATE VALIDATORS
              echo PHP_EOL . 'PREPARING VALIDATION TEMPLATES.' . PHP_EOL;
              $templateVars = $componentManager->getValidatorTemplateVars($api, $table);
              echo PHP_EOL . 'WRITING VALIDATION FILE.' . PHP_EOL;
              $apiManager->generateFile($api['entity'], $templateVars, $file, $config['module']);
              break;

            case "request":
              // GENERATE REQUEST OBJECT FILES
              foreach ($api['api_list'] as $apiName => $_api) {
                echo PHP_EOL . 'PREPARING REQUEST OBJECT FOR API ' . ucfirst($apiName) . PHP_EOL;
                $templateVars = $apiManager->getApiRequestTemplateVars($apiName, $_api, $api, $file);
                echo PHP_EOL . 'WRITING REQUEST OBJECT FILE FOR API ' . ucfirst($apiName) . PHP_EOL;
                $apiManager->generateFile($apiName, $templateVars, $file, $config['module']);
              }
              break;

            case "response":
              // GENERATE RESPONSE OBJECT FILES
              foreach ($api['api_list'] as $apiName => $_api) {
                echo PHP_EOL . 'PREPARING RESPONSE OBJECT FOR API ' . ucfirst($apiName) . PHP_EOL;
                $templateVars = $apiManager->getApiRequestTemplateVars($apiName, $_api, $api, $file);
                echo PHP_EOL . 'WRITING RESPONSE OBJECT FILE FOR API ' . ucfirst($apiName) . PHP_EOL;
                $apiManager->generateFile($apiName, $templateVars, $file, $config['module']);
              }
              break;

            case "route":
              // GENERATE RESPONSE OBJECT FILES
              echo PHP_EOL . 'PREPARING ROTES OF API ' . PHP_EOL;
              if (!isset($routeTemplateVars)) {
                $routeTemplateVars = false;
              }
              $routeTemplateVars = $apiManager->getApiRouteTemplateVars($apiName, $_api, $api, $file, $routeTemplateVars);
              echo PHP_EOL . 'WRITING ROUTE FILE FOR API ' . PHP_EOL;
              $apiManager->generateFile("", $routeTemplateVars, $file, $config['module']);
              break;
          }
        }
      } catch (Exception $e) {
        echo PHP_EOL . 'EXCEPTION WHILE CREATING API\'s.' . PHP_EOL;
        echo $e->getMessage();
        die("Exception in command, Please provide valid config");
      }
    }
    echo PHP_EOL . 'SCRIPT COMPLETED SUCCESSFULLY.' . PHP_EOL;
  });

return $console;
