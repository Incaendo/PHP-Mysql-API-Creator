<?php

use Silex\Application;

$app = new Application();
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
  'dbs.options' => array(
    'db' => array(
      'driver' => 'pdo_mysql',
      'dbname' => 'business_layer',
      'host' => 'localhost',
      'user' => 'root',
      'password' => 'root',
      'charset' => 'utf8',
    ),
  )
));

$app['debug'] = true;
$app['usr_search_names_foreigner_key'] = array();
include 'util/ModelManager.php';
include 'util/DatabaseManager.php';
include 'util/DtoManager.php';
include 'util/DaoManager.php';
include 'util/ApiManager.php';
include 'util/ControllerManager.php';
include 'util/ComponentManager.php';
return $app;
